<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'HomeController::index');
$routes->get('/home', 'HomeController::index');


$routes->get('/login', 'LoginController::index');
$routes->post('/login/process', 'LoginController::login');
$routes->get('/login/checkStatus', 'LoginController::checkLoginStatus');
$routes->get('/login/getRedirectAddress', 'LoginController::getRedirectAddress');
$routes->get('/logout', 'LoginController::logout');

$routes->get('/signup', 'LoginController::signup');
$routes->post('/signup/process', 'LoginController::signupProcess');


$routes->get('/user/getstarted', 'UserController::GetStarted');
$routes->get('/user/onboard', 'UserController::onboardRedirect');
$routes->get('/user/uploadphoto', 'UserController::UploadProfilePhoto');
$routes->get('/user/dashboard', 'UserController::Dashboard');

