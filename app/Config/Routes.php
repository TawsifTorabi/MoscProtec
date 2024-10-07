<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //Admin Operations
$routes->get('/admin/database/backup/download', 'BackupController::DownloadDatabaseSQL');   //Download Database in SQL Format to Local Device


//************//
//Public Pages
//************//
//Landing
$routes->get('/', 'HomeController::index');                                                 //Landing
$routes->get('/home', 'HomeController::index');                                             //Landing Alter
//Signup and Registration Processors
$routes->get('/signup', 'LoginController::signup');                                         //Signup Page
$routes->post('/signup/process', 'LoginController::signupProcess');                         //Signup API
$routes->post('/signup/checkUsername', 'LoginController::checkUsername');                   //Validate Username
//User Onboarding Pages (For New Users)
$routes->get('/user/getstarted', 'UserController::UserGetStarted');                         //Welcome New User                                          
$routes->get('/user/uploadphoto', 'UserController::UploadProfilePhoto');                    //Set Profile Photo


//Authenticators and User Basic Information API
$routes->get('/login', 'LoginController::index');                                           //Login Page
$routes->get('/logout', 'LoginController::logout');                                         //Logout Processor
//APIs
$routes->post('/login/process', 'LoginController::login');                                  //Login API
$routes->get('/login/checkStatus', 'LoginController::getRedirectAddress');                  //User Authentication Status after Login
$routes->get('/login/getRedirectAddress', 'LoginController::getRedirectAddress');           //Same Shit, Too lazy to update the Javascript

//User & Session Management
$routes->get('/user/onboard', 'UserController::onboardRedirectDashboard');                  //Redirect User to dashboard                                          
$routes->get('/user/manageSessions', 'UserController::manageSessions');                     //Show all user session
$routes->get('/user/invalidateSession/(:any)', 'UserController::invalidateSession/$1');     //Logout of other device
$routes->post('/profile/uploadAvatar', 'ProfileController::uploadAvatar');                  //Process Profile Picture Uploads 
//APIs
$routes->get('/global/photos/profile/(:segment)', 'ProfileController::serveProfilePhoto/$1');   //Returns user photo by username e.g: /global/photos/profile/pajeet420
$routes->get('/global/photos/currentUser', 'ProfileController::serveCurrentUserPhoto/$1');      //Returns user photo e.g: /global/photos/currentUser



//************//
//General User Pages
//************//
$routes->get('/user/dashboard', 'AreaHeatmapController::index');
//$routes->get('/user/dashboard', 'UserController::Dashboard');


//************//
///Heatmap  Pages
//************//
//User Heatmap Views
$routes->get('/user/heatmap', 'AreaHeatmapController::index');                              //Mosquito Density Heatmap Landing Page
$routes->get('/user/heatmap/report', 'AreaHeatmapController::report');                       //Mosquito Density Report Page
//APIs
$routes->get('/user/heatmap/getLocations', 'AreaHeatmapController::getLocations');          //Returns Coordinate Data to Client to generate Heatmap
$routes->post('/user/heatmap/reportLocation', 'AreaHeatmapController::reportLocation');          //Returns Coordinate Data to Client to generate Heatmap


//Messenger
$routes->get('/user/messenger', 'ChatController::chatIndex');                                       //Chat Landing
//Chat APIs
$routes->get('/user/messenger/chats/(:num)/(:num)', 'ChatController::getChatMessages/$1/$2');       //Get Chat from Thread --
$routes->get('/user/messenger/last-chat/(:num)/(:num)', 'ChatController::getLastChat/$1/$2');       //Get One Last Chat Message --
$routes->get('/user/messenger/conversations', 'ChatController::Conversation');                      //List Of Conversations. --
$routes->post('/user/messenger/get-chats', 'ChatController::getChats');                             //Get Chats from 2 two user thread and Mark Them as Read (get-chats?id_2=DESTINATION_USER_ID) --
$routes->post('/user/messenger/send-message', 'ChatController::sendMessage');                       //Sends Message (to_id=USER_ID&message=STRING) --
$routes->post('/user/messenger/search', 'ChatController::search');                                  //Search By Username or Name (Returns JSON list) --
$routes->post('/user/messenger/update-last-seen', 'UserController::updateLastSeen');                //Current Update User Last Seen (Returns JSON list) --
$routes->get('/user/messenger/getUserID', 'UserController::GetUserID');                             //Get Current User ID --



$routes->get('/user/medical', 'MedicalController::index');                                          //Mosquito Density Heatmap Landing Page
$routes->get('/user/medical/history', 'MedicalController::history');                                          //Mosquito Density Heatmap Landing Page
$routes->get('/user/bloodbank/list', 'MedicalController::donorList');                                          //Mosquito Density Heatmap Landing Page
$routes->get('/user/bloodbank/history', 'MedicalController::bloodHistory');                                          //Mosquito Density Heatmap Landing Page
$routes->get('/user/counselling', 'MedicalController::counselling');                                          //Mosquito Density Heatmap Landing Page



