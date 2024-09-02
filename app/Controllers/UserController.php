<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
        
        //////////////////////////////////////////////Show Get Started Page///////////////////////////////////////////////////////
        public function GetStarted()
        {
            // Start session
            $session = session();
            
            // Check if the user is logged in
            if ($session->get('isLoggedIn')) {
                // Load User model
                $userModel = new UserModel();
                $user = $userModel->find($session->get('user_id'));
    
                if ($user) {
                    // If not logged in or user not found, show the login page
                    echo view('includes/public/getstarted/getstarted_header.php');
                    echo view('includes/public/getstarted/getstarted_body.php');
                    //echo view('includes/public/footer.php');
                    echo view('includes/public/body_static_inc.php');
                }
            }
            
            return redirect()->to('/login');
        }
       
        //////////////////////////////////////////////Direct User to Designated Dashboard/////////////////////////////////////////
        public function onboardRedirect()
        {
            // Start session
            $session = session();
            
            // Check if the user is logged in
            if ($session->get('isLoggedIn')) {
                // Load User model
                $userModel = new UserModel();
                $user = $userModel->find($session->get('user_id'));
    
                if ($user) {
                    // If not logged in or user not found, show the login page
                    echo view('includes/public/getstarted/getstarted_header.php');
                    echo view('includes/public/getstarted/getstarted_body.php');
                    //echo view('includes/public/footer.php');
                    echo view('includes/public/body_static_inc.php');
                }
            }
            
            return redirect()->to('/login');
        }
       

        //////////////////////////////////////////////Dashboard//////////////////////////////////////////////////////////////////
        public function Dashboard(){
            echo "Demo Dashboard";
        }

        //////////////////////////////////////////////Show Upload Photos Page////////////////////////////////////////////////////
        public function UploadProfilePhoto()
        {
            // Start session
            $session = session();
            
            // Check if the user is logged in
            if ($session->get('isLoggedIn')) {
                // Load User model
                $userModel = new UserModel();
                $user = $userModel->find($session->get('user_id'));
    
                if ($user) {
                    // If not logged in or user not found, show the login page
                    echo view('includes/public/login/Login_header.php');
                    echo view('includes/public/login/Login_body.php');
                    echo view('includes/public/footer.php');
                    echo view('includes/public/body_static_inc.php');
                }
            }
            
            // // If not logged in or user not found, show the login page
            // echo view('includes/public/login/Login_header.php');
            // echo view('includes/public/login/Login_body.php');
            // echo view('includes/public/footer.php');
            // echo view('includes/public/body_static_inc.php');
        }
}

