<?php

declare(strict_types=1);

namespace GrimPirate\Halberd\Authentication\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Exceptions\LogicException;
use CodeIgniter\Shield\Exceptions\RuntimeException;
use CodeIgniter\Shield\Models\UserIdentityModel;

use CodeIgniter\Shield\Authentication\Actions\ActionInterface;
use PragmaRX\Google2FA\Google2FA;

class QRCodeActivator implements ActionInterface
{
    private string $type = 'qrcode_activate';
    private string $issuer = $_ENV['grimpirate.halberd.issuer'] ?? 'Halberd';

    /**
     * Shows the initial screen to the user with a QR code for activation
     */
    public function show(): string
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        //helper('qrcode');
        $qrcode = qrcode($this->issuer, $user->username, $this->createIdentity($user));

        // Display the info page
        return view(setting('Auth.views')['action_qrcode_activate_show'], ['user' => $user, 'qrcode' => $qrcode]);
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
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $postedToken = $request->getVar('token');

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        $identity = $this->getIdentity($user);
        $secret = $identity->secret;
        $identity->secret = (new Google2FA())->getCurrentOtp($secret);

        // No match - let them try again.
        if (! $authenticator->checkAction($identity, $postedToken)) {
            session()->setFlashdata('error', lang('Auth.invalidActivateToken'));

            //helper('qrcode');
            $qrcode = qrcode($this->issuer, $user->username, $secret);

            return view(setting('Auth.views')['action_qrcode_activate_show'], ['user' => $user, 'qrcode' => $qrcode]);
        }

        $user = $authenticator->getUser();

        // Set the user active now
        $user->activate();

        $this->generateIdentity(
            $user,
            [
                'type'  => 'google_2fa',
                'name'  => 'activated'
            ],
            static fn (): string => $secret,
            false
        );

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Creates an identity for the action of the user.
     *
     * @return string secret
     */
    public function createIdentity(User $user): string
    {
        return $this->generateIdentity(
            $user,
            [
                'type'  => $this->type,
                'name'  => 'register',
                'extra' => lang('QRAuth.needVerification'),
            ],
            static fn (): string => (new Google2FA())->generateSecretKey(),
            true
        );
    }

    /**
     * Creates an identity for the action of the user.
     *
     * @return string secret
     */
    private function generateIdentity(User $user, array $data, callable $generator, bool $deletePriors): string
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        // Delete any previous identities for action
        if($deletePriors)
            $identityModel->deleteIdentitiesByType($user, $data['type']);

        return $identityModel->createCodeIdentity($user, $data, $generator);
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
