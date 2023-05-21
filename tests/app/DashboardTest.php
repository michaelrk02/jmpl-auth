<?php

namespace App;

use App\Database\Seeds\TestSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class DashboardTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait;

    protected $seed = TestSeeder::class;
    protected $seedOnce = true;

    protected function setUp(): void
    {
        parent::setUp();

        $_SESSION['auth'] = '8f7474cd-3f78-4c48-83a7-14cc81490ccc';
    }

    // T-DSB-01
    public function testDashboardLoggedIn()
    {
        $result = $this->withSession()->get('/');

        $result->assertSee('Welcome!');
    }

    // T-DSB-04
    public function testRedirectIfLoggedOut()
    {
        $result = $this->get('/');

        $result->assertRedirectTo('/user/login');
    }
}
