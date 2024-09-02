<?php

namespace App\Controllers;
use App\Models\UserModel; // Import the UserModel

class HomeController extends BaseController
{
    public function index()
    {
        // Start session
        $session = session();
        
        // Initialize data array
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'user_id' => $session->get('user_id')
        ];

        // Check if the user is logged in and user exists
        if ($data['isLoggedIn']) {
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
