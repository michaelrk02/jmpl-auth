<?php

namespace Config;

use App\Controllers\Home;
use App\Controllers\UserController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', [Home::class, 'index'], ['as' => 'home']);
    $routes->get('/user/logout', [UserController::class, 'logout'], ['as' => 'user.logout']);
    $routes->post('/user/activate/gauth', [UserController::class, 'activateGoogleAuth'], ['as' => 'user.activate.gauth']);
});

$routes->group('', ['filter' => 'guest'], static function ($routes) {
    $routes->get('/user/login', [UserController::class, 'login'], ['as' => 'user.login']);
    $routes->post('/user/login', [UserController::class, 'authenticate']);
    $routes->get('/user/otp', [UserController::class, 'otp'], ['as' => 'user.otp']);
    $routes->post('/user/otp', [UserController::class, 'authenticateOtp']);
    $routes->get('/user/register', [UserController::class, 'register'], ['as' => 'user.register']);
    $routes->post('/user/register', [UserController::class, 'store']);
    $routes->get('/user/activate', [UserController::class, 'activate'], ['as' => 'user.activate']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
