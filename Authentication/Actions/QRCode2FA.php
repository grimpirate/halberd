<?php

declare(strict_types=1);

namespace Halberd\Authentication\Actions;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Exceptions\RuntimeException;
use CodeIgniter\Shield\Models\UserIdentityModel;

use CodeIgniter\Shield\Authentication\Actions\ActionInterface;
use PragmaRX\Google2FA\Google2FA;

/**
 * Class QRCode2FA
 *
 * One Time Password code to verify their account.
 */
class QRCode2FA implements ActionInterface
{
    private string $type = 'qrcode_2fa';

    /**
     * Displays verification prompt.
     */
    public function show(): string
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        $this->createIdentity($user);

        return view(setting('Auth.views')['action_qrcode_2fa_verify']);
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
     * Attempts to verify the code the user entered.
     *
     * @return RedirectResponse|string
     */
    public function verify(IncomingRequest $request)
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $postedToken = $request->getPost('token');

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        $identity = $this->getIdentity($user);
        $identity->secret = (new Google2FA())->getCurrentOtp($identity->secret);

        // Token mismatch? Let them try again...
        if (! $authenticator->checkAction($identity, $postedToken)) {
            session()->setFlashdata('error', lang('Auth.invalid2FAToken'));

            return view(setting('Auth.views')['action_qrcode_2fa_verify']);
        }

        // Get our login redirect url
        return redirect()->to(config('Auth')->loginRedirect());
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

        $secret = $identityModel->getIdentityByType(
            $user,
            'google_2fa'
        )->secret;

        // Delete any previous identities for action
        $identityModel->deleteIdentitiesByType($user, $this->type);

        return $identityModel->createCodeIdentity(
            $user,
            [
                'type'  => $this->type,
                'name'  => 'login',
                'extra' => lang('Auth.need2FA'),
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
