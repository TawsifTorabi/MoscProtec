<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{

    // Method to serve user's profile photo
    public function serveProfilePhoto($username)
    {
        // Check if the user is logged in (if needed)
        if (!$this->checkSessionValidity()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not logged in']);
        }

        $userModel = new UserModel();

        // Find user by username
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            // If user not found
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'User not found']);
        }

        // If user has no profile photo, serve the default placeholder
        if (empty($user['pp'])) {
            $placeholderPath = FCPATH . 'assets/chat/img/user-default.png'; // Use full path for serving
            return $this->serveImage($placeholderPath);
        }

        // Full path of the user's profile photo
        $filePath = WRITEPATH . 'uploads/avatars/' . $user['pp'];

        if (!is_file($filePath)) {
            // If file does not exist, serve the default placeholder image
            $placeholderPath = FCPATH . 'assets/chat/img/user-default.png';
            return $this->serveImage($placeholderPath);
        }

        // Serve the user's profile photo
        return $this->serveImage($filePath);
    }






    // Method to serve the profile photo of the currently logged-in user
    public function serveCurrentUserPhoto()
    {
        // Check if the user is logged in
        if (!$this->checkSessionValidity()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not logged in']);
        }

        // Get the currently logged-in user's ID from the session
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User ID not found in session']);
        }

        // Load the UserModel
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            // If the user is not found in the database
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'User not found']);
        }

        // Check if the user has a profile picture
        if (empty($user['pp'])) {
            // If no profile picture, serve the default placeholder
            $placeholderPath = FCPATH . 'assets/img/placeholder_square.jpeg'; // Path to default image
            return $this->serveImage($placeholderPath);
        }

        // Full path of the user's profile photo
        $filePath = WRITEPATH . 'uploads/avatars/' . $user['pp'];

        if (!is_file($filePath)) {
            // If file does not exist, serve the default placeholder
            $placeholderPath = FCPATH . 'assets/img/placeholder_square.jpeg';
            return $this->serveImage($placeholderPath);
        }

        // Serve the user's profile photo
        return $this->serveImage($filePath);
    }

    // Helper method to serve an image
    private function serveImage($filePath)
    {
        if (!is_file($filePath)) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'File not found']);
        }

        return $this->response
            ->setContentType(mime_content_type($filePath))
            ->setBody(file_get_contents($filePath));
    }



    //Upload User Photo
    public function uploadAvatar()
    {
        // Start session
        $session = session();

        // Check if the user is logged in
        if (!$this->checkSessionValidity()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not logged in']);
        }

        // Get the logged-in user ID
        $userId = $session->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if ($user) {
            // Handle the uploaded file
            $file = $this->request->getFile('avatar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Generate a unique name for the file
                $newName = $file->getRandomName();

                // Define the path to save the file
                $filePath = WRITEPATH . 'uploads/avatars/';

                // Move the file to the upload directory
                if ($file->move($filePath, $newName)) {
                    // Update the 'pp' field with the new filename
                    $userModel->update($userId, ['pp' => $newName]);

                    return $this->response->setJSON(['status' => 'success', 'message' => 'Upload success']);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to move the file']);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid file']);
            }
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'User not found']);
    }




    //Session Validator
    private function checkSessionValidity()
    {
        $session = session();
        return $session->get('user_id') !== null;
    }
    
}
