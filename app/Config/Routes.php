<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Public Pages
$routes->get('/', 'HomeController::index');
$routes->get('/home', 'HomeController::index');

//Signup and Registration Processors
$routes->get('/signup', 'LoginController::signup');                                     //Signup Page
$routes->post('/signup/process', 'LoginController::signupProcess');                     //Signup API

//Authenticators and User Basic Information API
$routes->get('/login', 'LoginController::index');                                       //Login Page
$routes->get('/logout', 'LoginController::logout');                                     //Logout Processor
//APIs
$routes->post('/login/process', 'LoginController::login');                              //Login API
$routes->get('/login/checkStatus', 'LoginController::getRedirectAddress');              //User Authentication Status after Login
$routes->get('/login/getRedirectAddress', 'LoginController::getRedirectAddress');       //Same Shit, Too lazy to update the Javascript

//Session Management
$routes->get('/user/manageSessions', 'UserController::manageSessions');                 //Show all user session
$routes->get('/user/invalidateSession/(:any)', 'UserController::invalidateSession/$1'); //Logout of other device

//User Onboarding Pages (For New Users)
$routes->get('/user/getstarted', 'UserController::GetStarted');                         
$routes->get('/user/onboard', 'UserController::onboardRedirect');
$routes->get('/user/uploadphoto', 'UserController::UploadProfilePhoto');
$routes->get('/user/dashboard', 'AreaHeatmapController::index');
//$routes->get('/user/dashboard', 'UserController::Dashboard');

//Admin Operations
$routes->get('/admin/database/backup/download', 'BackupController::DownloadDatabaseSQL');   //Download Database in SQL Format to Local Device


//Heatmap
//User Heatmap Views
$routes->get('/user/heatmap', 'AreaHeatmapController::index');                              //Mosquito Density Heatmap Landing Page
//APIs
$routes->get('/user/heatmap/getLocations', 'AreaHeatmapController::getLocations');          //Returns Coordinate Data to Client to generate Heatmap
// $routes->get('/user/heatmap/demo', 'AreaHeatmapController::demo');                          



