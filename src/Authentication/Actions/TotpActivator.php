<?php

declare(strict_types=1);

namespace GrimPirate\Halberd\Authentication\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\RuntimeException;

use GrimPirate\Halberd\Authentication\Authenticators\Totp;
use GrimPirate\Halberd\Entities\UserIdentity;
use GrimPirate\Halberd\Models\UserIdentityModel;

use CodeIgniter\Shield\Authentication\Actions\ActionInterface;
use CodeIgniter\Shield\Authentication\Actions\ConditionalActionInterface;


class TotpActivator implements ActionInterface, ConditionalActionInterface
{
    private string $type = Totp::ID_TYPE_TOTP_2FA;

    public function appliesTo(User $user): bool
    {
        $permission = setting('Totp.permission');
        if(empty($permission)) return true;
        return $user->can($permission);
    }

    /**
     * Shows the initial screen to the user with a QR code for activation
     */
    public function show(): string
    {
        /** @var Totp $authenticator */
        $authenticator = auth('totp')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        
        if ($user === null)
            throw new RuntimeException('Cannot get the pending login User.');

        $identity = $this->getIdentity($user);

        return view(setting('Auth.views')['action_totp_2fa'], $user->isNotActivated() ? ['qrcode' => $identity->qrcode, 'secret' => $identity->secret] : []);
    }

    /**
     * This method is unused.
     *
     * @return Response|string
     */
    public function handle(IncomingRequest $request)
    {
        throw new PageNotFoundException();
    }

    /**
     * Verifies the QR code matches an
     * identity we have for that user.
     *
     * @return RedirectResponse|string
     */
    public function verify(IncomingRequest $request)
    {
        /** @var Totp $authenticator */
        $authenticator = auth('totp')->getAuthenticator();

        $postedToken = $request->getPost('token');

        $user = $authenticator->getPendingUser();
        
        if ($user === null)
            throw new RuntimeException('Cannot get the pending login User.');

        $identity = $this->getIdentity($user);

        // No match - let them try again.
        if (! $authenticator->checkAction($identity, $postedToken))
        {
            session()->setFlashdata('error', lang($user->isNotActivated() ? 'Auth.invalidActivateToken' : 'Auth.invalid2FAToken'));

            return view(setting('Auth.views')['action_totp_2fa'], $user->isNotActivated() ? ['qrcode' => $identity->qrcode, 'secret' => $identity->secret] : []);
        }

        // getUser instead of getPendingUser updates user state to LOGGED_IN
        $user = $authenticator->getUser();

        $isNotActivated = $user->isNotActivated();

        if($isNotActivated)
            $user->activate();

        // Success!
        return $isNotActivated
            ? redirect()->to(config('Auth')->registerRedirect())
                ->with('message', lang('Auth.registerSuccess'))
            : redirect()->to(config('Auth')->loginRedirect());
    }

    /**
     * Creates an identity for the action of the user.
     *
     * @return string secret
     */
    public function createIdentity(User $user): string
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identity = $identityModel->getIdentityByType(
            $user,
            $this->type
        );

        return null !== $identity
            ? $identity->secret
            : $identityModel->createCodeIdentity(
                $user,
                [
                    'type'  => $this->type,
                    'secret2' => $user->username ?? $user->email,
                    'last_used_at' => Time::yesterday(),
                ],
                static fn (): string => service('halberd')->generateSecretKey()
            );
    }

    /**
     * Returns an identity for the action of the user.
     */
    private function getIdentity(User $user): ?UserIdentity
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        return $identityModel->getIdentityByType(
            $user,
            $this->type
        );
    }

    /**
     * Returns the string type of the action class.
     */
    public function getType(): string
    {
        return $this->type;
    }
}
