<?php

namespace App\Controllers;
use App\Models\UserModel;

class LoginController extends BaseController
{

    //////////////////////////////////////////////Show Login Page///////////////////////////////////////////////////////
    public function index()
    {
        // Start session
        $session = session();
        
        // Check if the user is logged in
        if ($session->get('isLoggedIn')) {
            // Load User model
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            if ($user) {
                // Redirect based on user type
                if ($user['usertype'] == 'user') {
                    return redirect()->to('user/dashboard');
                } elseif ($user['usertype'] == 'admin') {
                    return redirect()->to('admin/dashboard');
                }
            }
        }
        
        // If not logged in or user not found, show the login page
        echo view('includes/public/login/Login_header.php');
        echo view('includes/public/login/Login_body.php');
        echo view('includes/public/footer.php');
        echo view('includes/public/body_static_inc.php');
    }

    
    

    //////////////////////////////////////////////Process User Login////////////////////////////////////////////////////
    public function login()
    {
        helper(['form', 'url']);
        $session = session();

        // Define validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[4]'
        ]);

        // Get the POST data
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Check if POST data is empty
        if (empty($email) || empty($password)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email and password are required.']);
        }

        // Run validation
        if (!$validation->withRequest($this->request)->run()) {
            // Return validation errors
            return $this->response->setJSON(['status' => 'error', 'message' => $validation->getErrors()]);
        }

        // Load User model
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Update lastseentime with Unix timestamp
                $userModel->update($user['id'], ['lastseen' => time()]);

                // Set session data
                $session->set([
                    'user_id' => $user['id'],
                    'usertype' => $user['usertype'],
                    'isLoggedIn' => true
                ]);

                // Determine the redirect URL
                $redirectUrl = ($user['usertype'] === 'admin') ? base_url('admin/dashboard') : base_url('user/dashboard');

                // Return success response with redirection URL
                return $this->response->setJSON(['status' => 'success', 'message' => 'Logged In!', 'redirect_url' => $redirectUrl]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email or password']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    }

    
    ////////////////////////////////////////////////////Check User Login Status////////////////////////////////////////////////////
    public function checkLoginStatus()
    {
        // Start session
        $session = session();
        
        // Check if the user is logged in
        if ($session->get('isLoggedIn')) {
            // Load User model
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            if ($user) {
                // Return JSON response with user details
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'User is logged in',
                    'usertype' => $user['usertype'],
                    'data' => [
                        'name' => $user['name'], // Assuming you have a 'name' field in your user table
                        'username' => $user['username'] // Assuming you have a 'username' field in your user table
                    ]
                ]);
            } else {
                // Return JSON response if user data is not found
                return $this->response->setJSON(['status' => 'error', 'message' => 'User data not found']);
            }
        } else {
            // Return JSON response if user is not logged in
            return $this->response->setJSON(['status' => 'error', 'message' => 'User is not logged in']);
        }
    }


    ////////////////////////////////////////////////////Logout//////////////////////////////////////////////////////////////////////////
    public function logout()
    {
        $session = session();
        
        // Destroy the session
        $session->destroy();
        
        // Return a response indicating successful logout
        return redirect()->to('login');
    }

    ////////////////////////////////////////////////////Get User Redirection Address////////////////////////////////////////////////////
    public function getRedirectAddress()
    {
        // Start session
        $session = session();
        
        // Check if the user is logged in
        if ($session->get('isLoggedIn')) {
            // Load User model
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));
            if ($user) {
                if($user['usertype'] == 'user'){
                    return $this->response->setJSON(['status' => 'success', 'redirect' => 'user/dashboard']);
                }
                if($user['usertype'] == 'admin'){
                    return $this->response->setJSON(['status' => 'success', 'redirect' => 'admin/dashboard']);
                }
            } else {
                // Return JSON response if user data is not found
                return $this->response->setJSON(['status' => 'error', 'message' => 'User data not found']);
            }
        } else {
            // Return JSON response if user is not logged in
            return $this->response->setJSON(['status' => 'error', 'message' => 'User is not logged in']);
        }
    }

    


    //////////////////////////////////////////////Show Sign Up Page///////////////////////////////////////////////////////
    public function signup()
    {
        // Start session
        $session = session();
        
        // Check if the user is logged in
        if ($session->get('isLoggedIn')) {
            // Load User model
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            if ($user) {
                // Redirect based on user type
                if ($user['usertype'] == 'user') {
                    return redirect()->to('user/dashboard');
                } elseif ($user['usertype'] == 'admin') {
                    return redirect()->to('admin/dashboard');
                }
            }
        }
        
        echo view('includes/public/signup/Signup_header.php');
        echo view('includes/public/signup/Signup_body.php');
        echo view('includes/public/footer.php');
        echo view('includes/public/body_static_inc.php');
    }

    
    //////////////////////////////////////////////Process User Sign Up////////////////////////////////////////////////////
    public function signupProcess()
    {
        helper(['form', 'url']);
        $session = session(); // Start session
        $validation = \Config\Services::validation();

        // Define validation rules
        $validation->setRules([
            'email' => 'required|valid_email',
            'name' => 'required|min_length[3]',
            'phone' => 'required|numeric|exact_length[10]',
            'dob' => 'required|valid_date',
            'gender' => 'required|in_list[Male,Female,Other]',
            'blood_group' => 'required|min_length[2]',
            'password' => 'required|min_length[6]',
            'confirmPassword' => 'required|matches[password]'
        ]);

        // Get the POST data
        $email = $this->request->getVar('email');
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar('phone');
        $dob = $this->request->getVar('dob');
        $gender = $this->request->getVar('gender');
        $bloodGroup = $this->request->getVar('blood_group');
        $password = $this->request->getVar('password');

        // Run validation
        if (!$validation->withRequest($this->request)->run()) {
            // Return validation errors
            return $this->response->setJSON(['status' => 'error', 'message' => $validation->getErrors()]);
        }

        // Load User model
        $userModel = new UserModel();

        // Check if the email already exists in the database
        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email already exists.']);
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Save user data
        $userId = $userModel->insert([
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'dob' => $dob,
            'gender' => $gender,
            'blood_group' => $bloodGroup,
            'password' => $hashedPassword,
            'usertype' => 'general' // or set this based on your application logic
        ]);

        // Check if the user was saved successfully
        if ($userId) {
            // Set session data to log the user in
            $session->set([
                'user_id' => $userId,
                'usertype' => 'general', // Or the appropriate user type
                'isLoggedIn' => true
            ]);

            // Determine the redirect URL
            $redirectUrl = base_url('user/getstarted'); // Adjust this URL if necessary

            // Return success response with redirection URL
            return $this->response->setJSON(['status' => 'success', 'message' => 'User registered successfully', 'redirect_url' => $redirectUrl]);
        } else {
            // Return error response if user registration failed
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to register user.']);
        }
    }



}
