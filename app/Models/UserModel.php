<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends BaseModel
{
    protected $table = 'user';

    protected $allowedFields = [
        'email',
        'password',
        'name',

        'is_activated',

        'gauth_is_activated',
        'gauth_secret_key'
    ];

    public function findEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
