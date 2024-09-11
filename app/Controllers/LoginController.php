<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends BaseController
{
    // Utility method to check if the user is logged in and valid
    public function checkSessionValidity()
    {
        $session = session();

        if ($session->get('isLoggedIn')) {
            $userId = $session->get('user_id');
            $sessionId = $session->get('session_id');

            // Verify session validity from the database
            $db = \Config\Database::connect();
            $sessionData = $db->table('user_sessions')
                ->where('user_id', $userId)
                ->where('session_id', $sessionId)
                ->where('is_valid', 1)
                ->get()
                ->getRow();

            if ($sessionData) {
                return true;
            } else {
                // Invalidate the session if it's not valid
                $session->destroy();
                return false;
            }
        }
        return false;
    }

    ///////////////////////////////////////////Get Redirect Address / checkLoginStatus///////////////////////////
    public function getRedirectAddress()
    {
        // Start session
        $session = session();
        
        // Check if the user is logged in
        if ($this->checkSessionValidity()) {
            // Load User model
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));
            
            if ($user) {
                // Determine the redirect URL based on user type
                $redirectUrl = ($user['usertype'] === 'admin') ? 'admin/dashboard' : 'user/dashboard';

                // Return JSON response with user details and redirect URL
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'User is logged in',
                    'usertype' => $user['usertype'],
                    'redirect' => $redirectUrl,
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


    //////////////////////////////////////////////Show Login Page///////////////////////////////////////////////////////
    public function index()
    {
        if ($this->checkSessionValidity()) {
            $userModel = new UserModel();
            $user = $userModel->find(session()->get('user_id'));

            if ($user) {
                $redirectUrl = ($user['usertype'] === 'admin') ? 'admin/dashboard' : 'user/dashboard';
                return redirect()->to($redirectUrl);
            }
        }

        // Show the login page if not logged in
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

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[4]'
        ]);

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        if (empty($email) || empty($password)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email and password are required.']);
        }

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['status' => 'error', 'message' => $validation->getErrors()]);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $userModel->update($user['id'], ['lastseen' => time()]);

            $sessionId = session_id();
            $userAgent = $this->request->getUserAgent();
            $ipAddress = $this->request->getIPAddress();

            $db = \Config\Database::connect();
            $db->table('user_sessions')->insert([
                'user_id' => $user['id'],
                'session_id' => $sessionId,
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'is_valid' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'last_activity' => date('Y-m-d H:i:s')
            ]);

            $session->set([
                'user_id' => $user['id'],
                'session_id' => $sessionId,
                'usertype' => $user['usertype'],
                'isLoggedIn' => true
            ]);

            $redirectUrl = ($user['usertype'] === 'admin') ? base_url('admin/dashboard') : base_url('user/dashboard');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Logged In!', 'redirect_url' => $redirectUrl]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    }

    ////////////////////////////////////////////////////Logout//////////////////////////////////////////////////////////////////////////
    public function logout()
    {
        $session = session();
        $sessionId = $session->get('session_id');

        if ($sessionId) {
            $db = \Config\Database::connect();
            $db->table('user_sessions')->where('session_id', $sessionId)->update(['is_valid' => 0]);
        }

        $session->destroy();
        return redirect()->to('login');
    }

    //////////////////////////////////////////////Show Sign Up Page///////////////////////////////////////////////////////
    public function signup()
    {
        if ($this->checkSessionValidity()) {
            $userModel = new UserModel();
            $user = $userModel->find(session()->get('user_id'));

            if ($user) {
                $redirectUrl = ($user['usertype'] === 'admin') ? 'admin/dashboard' : 'user/dashboard';
                return redirect()->to($redirectUrl);
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
        $session = session();
        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => 'required|valid_email',
            'name' => 'required|min_length[3]',
            'phone' => 'required|numeric|exact_length[11]',
            'dob' => 'required|valid_date',
            'gender' => 'required|in_list[Male,Female,Other]',
            'blood_group' => 'required|min_length[2]',
            'password' => 'required|min_length[6]',
            'confirmPassword' => 'required|matches[password]'
        ]);

        $email = $this->request->getVar('email');
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar('phone');
        $dob = $this->request->getVar('dob');
        $gender = $this->request->getVar('gender');
        $bloodGroup = $this->request->getVar('blood_group');
        $password = $this->request->getVar('password');

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['status' => 'error', 'message' => $validation->getErrors()]);
        }

        $userModel = new UserModel();

        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email already exists.']);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userId = $userModel->insert([
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'dob' => $dob,
            'gender' => $gender,
            'blood_group' => $bloodGroup,
            'password' => $hashedPassword,
            'usertype' => 'general'
        ]);

        if ($userId) {
            $session->set([
                'user_id' => $userId,
                'usertype' => 'general',
                'isLoggedIn' => true
            ]);

            $redirectUrl = base_url('user/getstarted');
            return $this->response->setJSON(['status' => 'success', 'message' => 'User registered successfully', 'redirect_url' => $redirectUrl]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to register user.']);
        }
    }
}
