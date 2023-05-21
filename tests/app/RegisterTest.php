<?php

namespace App;

use App\Database\Seeds\TestSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class RegisterTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait, StatusTestTrait;

    protected $seed = TestSeeder::class;

    // T-REG-01
    public function testValid()
    {
        $result = $this->post('/user/register', [
            'email' => 'alice@localhost.localdomain',
            'password' => 'password',
            'passconf' => 'password',
            'name' => 'Alice'
        ]);

        $this->assertStatus($result, 'success', 'Verification link has been sent');
    }

    // T-REG-02
    public function testEmpty()
    {
        $result = $this->post('/user/register', [
            'email' => '',
            'password' => '',
            'passconf' => '',
            'name' => ''
        ]);

        $this->assertStatus($result, 'error', 'are required');
    }

    // T-REG-03
    public function testUsedEmail()
    {
        $result = $this->post('/user/register', [
            'email' => 'jim@localhost.localdomain',
            'password' => 'password',
            'passconf' => 'password',
            'name' => 'Jack'
        ]);

        $this->assertStatus($result, 'error', 'already in use');
    }

    // T-REG-04
    public function testShortPassword()
    {
        $result = $this->post('/user/register', [
            'email' => 'alice@localhost.localdomain',
            'password' => 'pass',
            'passconf' => 'pass',
            'name' => 'Alice'
        ]);

        $this->assertStatus($result, 'error', 'should not be less than');
    }

    // T-REG-05
    public function testWrongPassconf()
    {
        $result = $this->post('/user/register', [
            'email' => 'alice@localhost.localdomain',
            'password' => 'password',
            'passconf' => 'wordpass',
            'name' => 'Alice'
        ]);

        $this->assertStatus($result, 'error', 'do not match');
    }
}
