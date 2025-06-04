<?php

declare(strict_types=1);

namespace GrimPirate\Halberd\Authentication\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use CodeIgniter\I18n\Time;
use GrimPirate\Halberd\Authentication\Authenticators\TOTP;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Exceptions\RuntimeException;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Traits\Viewable;

use CodeIgniter\Shield\Authentication\Actions\ActionInterface;

class TOTPActivator implements ActionInterface
{
    use Viewable;

    public const ISSUER = 'Halberd';
    public const VIEW = '\GrimPirate\Halberd\Authentication\Actions\TOTPActivator';

    private string $type = TOTP::ID_TYPE_TOTP_2FA;

    /**
     * Shows the initial screen to the user with a QR code for activation
     */
    public function show(): string
    {
        /** @var TOTP $authenticator */
        $authenticator = auth('totp')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        
        if ($user === null)
            throw new RuntimeException('Cannot get the pending login User.');

        $identity = $this->getIdentity($user);

        return view(service('settings')->get('TOTP.view') ?? VIEW, $user->isNotActivated() ? ['qrcode' => service('halberd')->svg($identity->secret2), 'secret' => $identity->secret] : []);
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
        /** @var TOTP $authenticator */
        $authenticator = auth('totp')->getAuthenticator();

        $postedToken = $request->getVar('token');

        $user = $authenticator->getPendingUser();
        
        if ($user === null)
            throw new RuntimeException('Cannot get the pending login User.');

        $identity = $this->getIdentity($user);

        // No match - let them try again.
        if (! $authenticator->checkAction($identity, $postedToken))
        {
            session()->setFlashdata('error', lang($user->isNotActivated() ? 'Auth.invalidActivateToken' : 'Auth.invalid2FAToken'));

            return view(service('settings')->get('TOTP.view') ?? VIEW, $user->isNotActivated() ? ['qrcode' => service('halberd')->svg($identity->secret2), 'secret' => $identity->secret] : []);
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

        $halberd = service('halberd');
        $secret = $halberd->generateSecretKey();

        return null !== $identity
            ? $identity->secret
            : $identityModel->createCodeIdentity(
                $user,
                [
                    'type'  => $this->type,
                    'secret2' => $halberd->qrcode(service('settings')->get('TOTP.issuer') ?? ISSUER, $user->username ?? $user->email, $secret),
                    'last_used_at' => Time::yesterday(),
                ],
                static fn (): string => $secret
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
