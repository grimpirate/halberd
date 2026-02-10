<?php

namespace GrimPirate\Halberd\Entities;

use CodeIgniter\Shield\Entities\UserIdentity as ShieldUserIdentity;

class UserIdentity extends ShieldUserIdentity
{
    public function getQrcode()
    {
        return service('halberd')->qrcode($this->username ?? $this->email, $this->secret);
    }
}