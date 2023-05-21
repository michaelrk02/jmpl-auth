<?php

namespace App;

use App\Database\Seeds\TestSeeder;
use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use stdClass;

class ActivateTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait, StatusTestTrait;

    protected $seed = TestSeeder::class;

    // T-ACT-01
    public function testActivate()
    {
        $user = $this->makeAccount('alice@localhost.localdomain', 'Alice');
        $token = $this->makeToken($user);

        $result = $this->get($this->makeRoute($token));

        $this->assertStatus($result, 'success', 'has been activated');
    }

    // T-ACT-02
    public function testInvalidSignature()
    {
        helper('text');

        $user = $this->makeAccount('alice@localhost.localdomain', 'Alice');
        $token = $this->makeToken($user);
        $token['sig'] = md5(random_string());

        $result = $this->get($this->makeRoute($token));

        $this->assertStringContainsString('Invalid signature', $result->response()->getBody());
    }

    // T-ACT-03
    public function testExpired()
    {
        $user = $this->makeAccount('alice@localhost.localdomain', 'Alice');
        $token = $this->makeToken($user, time() - 86400);

        $result = $this->get($this->makeRoute($token));

        $this->assertStringContainsString('Link has expired', $result->response()->getBody());
    }

    // T-ACT-04
    public function testInvalidAccount()
    {
        $user = new stdClass();
        $user->id = '04500b5a-2c6d-44c9-a062-d6eebd3cc55e';
        $token = $this->makeToken($user);

        $result = $this->get($this->makeRoute($token));

        $this->assertStringContainsString('Account not found', $result->response()->getBody());
    }

    // T-ACT-05
    public function testActivatedAccount()
    {
        $user = $this->makeAccount('alice@localhost.localdomain', 'Alice');
        $token = $this->makeToken($user);

        $this->get($this->makeRoute($token));
        $result = $this->get($this->makeRoute($token));

        $this->assertStringContainsString('Account is already activated', $result->response()->getBody());
    }

    protected function makeAccount($email, $name)
    {
        $this->post('/user/register', [
            'email' => $email,
            'password' => 'password',
            'passconf' => 'password',
            'name' => $name
        ]);

        $userModel = model(UserModel::class);
        $user = $userModel->where('email', $email)->first();
        if (!isset($user)) {
            return null;
        }

        return $user;
    }

    protected function makeToken($user, $exp = null)
    {
        $jmpl = config('Jmpl');

        $id = $user->id;
        $exp = isset($exp) ? $exp : time() + 86400;
        $sig = hash_hmac('sha256', $id.$exp, $jmpl->secretKey);

        return compact('id', 'exp', 'sig');
    }

    protected function makeRoute($token)
    {
        return '/user/activate?'.http_build_query($token);
    }
}
