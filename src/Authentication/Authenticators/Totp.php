<?php

declare(strict_types=1);

namespace GrimPirate\Halberd\Authentication\Authenticators;

use CodeIgniter\Shield\Authentication\Authenticators\Session;

use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Exceptions\LogicException;

class Totp extends Session
{
    // Identity types
    public const ID_TYPE_TOTP_2FA = 'totp_2fa';
    public const ACTION_TOTP_2FA = 'action_totp_2fa';

    /**
     * Check token in Action
     *
     * @param string $token Token to check
     */
    public function checkAction(UserIdentity $identity, string $token): bool
    {
        if(!$this->loggedIn() && !$this->isPending())
            throw new LogicException(lang('Totp.exception.user'));

        // Irrelevant that $token could be an empty '' string
        if (!service('halberd')->verifyKeyNewer($identity->secret, $token, $identity->last_used_at->getTimestamp()))
            return false;

        // On success - update last_used_at
        $this->userIdentityModel->touchIdentity($identity);

        // Clean up our session
        $this->removeSessionUserKey('auth_action');
        $this->removeSessionUserKey('auth_action_message');

        $this->completeLogin($this->user);

        return true;
    }
}

