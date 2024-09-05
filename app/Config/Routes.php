<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //Public Pages
$routes->get('/', 'HomeController::index');
$routes->get('/home', 'HomeController::index');


//Authenticators and User Basic Information API
$routes->get('/login', 'LoginController::index');                                       //Login Page
$routes->post('/login/process', 'LoginController::login');                              //Login API
$routes->get('/login/checkStatus', 'LoginController::getRedirectAddress');              //Authentication Status after Login
$routes->get('/login/getRedirectAddress', 'LoginController::getRedirectAddress');       //Same Shit, Too lazy to update the Javascript
$routes->get('/logout', 'LoginController::logout');                                     //Logout API

//Signup and Registration Processors
$routes->get('/signup', 'LoginController::signup');                                     //Signup Page
$routes->post('/signup/process', 'LoginController::signupProcess');                     //Signup API

//User Onboarding Pages (For New Users)
$routes->get('/user/getstarted', 'UserController::GetStarted');                         
$routes->get('/user/onboard', 'UserController::onboardRedirect');
$routes->get('/user/uploadphoto', 'UserController::UploadProfilePhoto');
$routes->get('/user/dashboard', 'UserController::Dashboard');

$routes->get('/user/manageSessions', 'UserController::manageSessions');
$routes->get('/user/invalidateSession/(:any)', 'UserController::invalidateSession/$1');


