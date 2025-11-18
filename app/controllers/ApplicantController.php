<?php

class ApplicantController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();

        if (!isset($_SESSION['user'])) {
            redirect('/login');
            exit;
        }

        $this->call->database(); // Initialize database connection
        $this->call->model('ApplicationModel', 'Application');
        $this->call->model('UserModel', 'User');
    }

    public function dashboard()
    {
        $userId = $_SESSION['user']['id']; 

        $applications = $this->Application->getApplicationsByUser($userId);

        $this->call->view('dashboard_applicant', [
            'applications' => $applications
        ]);
    }

    public function myApplications()
    {
        $userId = $_SESSION['user']['id'];
        $applications = $this->Application->getApplicationsByUser($userId);
        
        $this->call->view('applicant/my_applications', [
            'applications' => $applications
        ]);
    }

    public function viewApplication($id)
    {
        $userId = $_SESSION['user']['id'];
        $application = $this->Application->getApplicationByUserAndId($userId, $id);
        
        if (!$application) {
            $_SESSION['error_message'] = 'Application not found or you do not have permission to view it.';
            redirect('/applicant/my-applications');
            exit;
        }
        
        $this->call->view('applicant/view_application', [
            'application' => $application
        ]);
    }

    public function profile()
    {
        $userId = $_SESSION['user']['id'];
        $user = $this->User->findUser($userId);
        
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/applicant/dashboard');
            exit;
        }
        
        // Remove password from user data for security
        unset($user['password']);
        
        // Get latest application data to populate profile
        $applications = $this->Application->getApplicationsByUser($userId);
        $latestApplication = !empty($applications) ? $applications[0] : null;
        
        // Merge user data with application data for profile display
        $profileData = array_merge($user, $latestApplication ?: []);
        
        $this->call->view('applicant/profile', [
            'user' => $profileData,
            'hasApplication' => !empty($latestApplication)
        ]);
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/applicant/profile');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        
        // Get profile data
        $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
        $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
        $middle_name = isset($_POST['middle_name']) ? trim($_POST['middle_name']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';
        $age = isset($_POST['age']) ? trim($_POST['age']) : '';
        $civil_status = isset($_POST['civil_status']) ? trim($_POST['civil_status']) : '';
        $contact_no = isset($_POST['contact_no']) ? trim($_POST['contact_no']) : '';
        $birth_place = isset($_POST['birth_place']) ? trim($_POST['birth_place']) : '';
        $height = isset($_POST['height']) ? trim($_POST['height']) : '';
        $weight = isset($_POST['weight']) ? trim($_POST['weight']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $special_skills = isset($_POST['special_skills']) ? trim($_POST['special_skills']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

        // Validation
        if (empty($last_name) || empty($first_name) || empty($email)) {
            $_SESSION['error_message'] = 'Last name, first name, and email are required.';
            redirect('/applicant/profile');
            exit;
        }

        // Check if email is already taken by another user
        $existingUser = $this->User->findByEmail($email);
        if ($existingUser && $existingUser['id'] != $userId) {
            $_SESSION['error_message'] = 'Email is already taken by another user.';
            redirect('/applicant/profile');
            exit;
        }

        // Prepare user update data
        $userData = [
            'fullname' => trim($first_name . ' ' . $last_name),
            'email' => $email
        ];

        // Update password only if provided
        if (!empty($password)) {
            if ($password !== $confirm_password) {
                $_SESSION['error_message'] = 'Passwords do not match.';
                redirect('/applicant/profile');
                exit;
            }
            if (strlen($password) < 6) {
                $_SESSION['error_message'] = 'Password must be at least 6 characters long.';
                redirect('/applicant/profile');
                exit;
            }
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update user account
        $userResult = $this->User->updateUser($userId, $userData);
        
        // Update or create application record with profile data
        $applications = $this->Application->getApplicationsByUser($userId);
        $latestApplication = !empty($applications) ? $applications[0] : null;
        
        $applicationData = [
            'last_name' => $last_name,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'address' => $address,
            'birthday' => $birthday,
            'age' => $age,
            'civil_status' => $civil_status,
            'contact_no' => $contact_no,
            'birth_place' => $birth_place,
            'height' => $height,
            'weight' => $weight,
            'email' => $email,
            'special_skills' => $special_skills,
            'user_id' => $userId
        ];
        
        if ($latestApplication) {
            // Update existing application data
            $this->Application->db->table('applications')
                ->where('id', $latestApplication['id'])
                ->update($applicationData);
        } else {
            // Create new application record for profile
            $applicationData['status'] = 'pending';
            $this->Application->saveApplication($applicationData);
        }
        
        if ($userResult) {
            // Update session with new data
            $updatedUser = $this->User->findUser($userId);
            unset($updatedUser['password']);
            $_SESSION['user'] = $updatedUser;
            
            $_SESSION['success_message'] = 'Profile updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to update profile.';
        }

        redirect('/applicant/profile');
    }
}
