<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $userModel = model(UserModel::class);
        $userModel->emptyTable();

        $userModel->protect(false);
        $userModel->insert([
            'id' => '8f7474cd-3f78-4c48-83a7-14cc81490ccc',
            'email' => 'jim@localhost.localdomain',
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'name' => 'Jim',
            'is_activated' => true
        ]);
        $userModel->protect(true);
    }
}
