<?php

namespace App;

use App\Database\Seeds\TestSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class LoginTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait, StatusTestTrait;

    protected $seed = TestSeeder::class;

    // T-LOG-01
    public function testValid()
    {
        $result = $this->post('/user/login', [
            'email' => 'jim@localhost.localdomain',
            'password' => 'password'
        ]);

        $this->assertStatus($result, 'success', 'Welcome back');
    }

    // T-LOG-02
    public function testEmpty()
    {
        $result = $this->post('/user/login', [
            'email' => '',
            'password' => ''
        ]);

        $this->assertStatus($result, 'error', 'are required');
    }

    // T-LOG-03
    public function testUnregistered()
    {
        $result = $this->post('/user/login', [
            'email' => 'joe@localhost.localdomain',
            'password' => 'password'
        ]);

        $this->assertStatus($result, 'error', 'does not exist');
    }

    // T-LOG-04
    public function testInactive()
    {
        $this->post('/user/register', [
            'email' => 'alice@localhost.localdomain',
            'password' => 'password',
            'passconf' => 'password',
            'name' => 'Alice'
        ]);

        $result = $this->post('/user/login', [
            'email' => 'alice@localhost.localdomain',
            'password' => 'password'
        ]);

        $this->assertStatus($result, 'error', 'not verified');
    }

    // T-LOG-05
    public function testWrongPassword()
    {
        $result = $this->post('/user/login', [
            'email' => 'jim@localhost.localdomain',
            'password' => 'wordpass'
        ]);

        $this->assertStatus($result, 'error', 'Incorrect password');
    }
}
