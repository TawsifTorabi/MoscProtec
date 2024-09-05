<?php

namespace App\Controllers;
use App\Models\UserModel; // Import the UserModel
use App\Controllers\LoginController;

class HomeController extends BaseController
{
    public function index()
    {
        // Start session
        $session = session();
        
        $data = ['sessionValid' => false];
        $LoginController = new LoginController();

        // Check if the user is logged in and user exists
        if ($LoginController->checkSessionValidity()) {

            $sessionValid = true;
            
            // Initialize data array
            $data = [
                'isLoggedIn' => $session->get('isLoggedIn'),
                'user_id' => $session->get('user_id'),
                'sessionValid' => true
            ];

            $userModel = new UserModel();
            $user = $userModel->find($data['user_id']);
        }

        // Render view files with the data
        echo view('includes/public/landing/Landing_header.php', $data);
        echo view('includes/public/landing/Landing_body.php');
        echo view('includes/public/footer.php');
        echo view('includes/public/body_static_inc.php');
    }
}
