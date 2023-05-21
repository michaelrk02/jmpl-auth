<?php

namespace App;

use App\Database\Seeds\TestSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class LogoutTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait, StatusTestTrait;

    protected $seed = TestSeeder::class;

    // T-OUT-01
    public function test()
    {
        $_SESSION['auth'] = '8f7474cd-3f78-4c48-83a7-14cc81490ccc';

        $result = $this->withSession()->get('/user/logout');

        $this->assertStatus($result, 'success', 'Logged out');
    }
}
