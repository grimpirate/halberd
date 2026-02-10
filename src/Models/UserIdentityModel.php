<?php

namespace GrimPirate\Halberd\Models;

use GrimPirate\Halberd\Entities\UserIdentity;

use CodeIgniter\Shield\Models\UserIdentityModel as ShieldUserIdentityModel;

class UserIdentityModel extends ShieldUserIdentityModel
{
    protected $returnType     = UserIdentity::class;
}