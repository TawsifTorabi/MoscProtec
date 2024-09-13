<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\LoginController;

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



    ///////////////////////////////////////////////Session Management////////////////////////////////////////////
    public function manageSessions()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('login');
        }

        // Get all sessions for the user
        $db = \Config\Database::connect();
        $sessions = $db->table('user_sessions')->where('user_id', $userId)->get()->getResult();

        return view('manage_sessions', ['sessions' => $sessions]);
    }

    public function invalidateSession($sessionId)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('login');
        }

        // Invalidate the specific session
        $db = \Config\Database::connect();
        $db->table('user_sessions')->where(['user_id' => $userId, 'session_id' => $sessionId])->update(['is_valid' => 0]);

        return redirect()->to('user/manageSessions');
    }






    //////////////////////////////////////////////Direct New User to Welcome Page/////////////////////////////////////////
    public function UserGetStarted()
    {
        $data['title'] = 'User Onboarding - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            // If not logged in or user not found, show the login page
            echo view('includes/public/getstarted/getstarted_header.php', $data);
            echo view('includes/public/getstarted/getstarted_nav.php');
            echo view('includes/public/getstarted/getstarted_body.php');
            echo view('includes/public/body_static_inc.php');
        } else {
            // Initialize data array for error
            $data_error = [
                'title' => $data['title'],  // Use the same title from $data
                'message' => 'You are not authenticated to view this page.'
            ];
            echo view('errors\html\not_authorized.php', $data_error);
        }
    }


    //////////////////////////////////////////////Show Upload Photos Page////////////////////////////////////////////////////
    public function UploadProfilePhoto()
    {
        $data['title'] = 'Upload Your Photo - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            // If not logged in or user not found, show the login page
            echo view('includes/public/getstarted/getstarted_header.php', $data);
            echo view('includes/public/getstarted/getstarted_nav.php');
            echo view('includes/public/getstarted/UploadProfilePhoto/ProfilePhoto.php');
            echo view('includes/public/body_static_inc.php');
        } else {
            // Initialize data array for error
            $data_error = [
                'title' => $data['title'],  // Use the same title from $data
                'message' => 'You are not authenticated to view this page.'
            ];
            echo view('errors\html\not_authorized.php', $data_error);
        }
    }

    // Method to redirect users to their respective dashboards based on usertype
    public function onboardRedirectDashboard()
    {
        // Check if the user is logged in
        if (!$this->isAuthenticated()) {
            return redirect()->to('/login')->with('error', 'You must log in to access this page.');
        }

        // Get the currently logged-in user's ID from the session
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'User ID not found in session.');
        }

        // Load the UserModel
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        // Determine the dashboard URL based on the usertype
        $usertype = $user['usertype'];
        switch ($usertype) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'general':
                return redirect()->to('/user/dashboard');
            default:
                return redirect()->to('/login')->with('error', 'User type is not recognized.');
        }
    }
}
