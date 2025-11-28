<?php

class ApplicantController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Session library first so it can properly initialize session settings
        $this->call->library('session');

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
        
        // Educational Background
        $school_name = isset($_POST['school_name']) ? trim($_POST['school_name']) : '';
        $year_level = isset($_POST['year_level']) ? trim($_POST['year_level']) : '';
        $school_type = isset($_POST['school_type']) ? trim($_POST['school_type']) : '';
        $course = isset($_POST['course']) ? trim($_POST['course']) : '';
        $academic_standing = isset($_POST['academic_standing']) ? trim($_POST['academic_standing']) : '';
        
        // Family Background
        $father_name = isset($_POST['father_name']) ? trim($_POST['father_name']) : '';
        $father_occupation = isset($_POST['father_occupation']) ? trim($_POST['father_occupation']) : '';
        $mother_name = isset($_POST['mother_name']) ? trim($_POST['mother_name']) : '';
        $mother_occupation = isset($_POST['mother_occupation']) ? trim($_POST['mother_occupation']) : '';
        $parent_contact = isset($_POST['parent_contact']) ? trim($_POST['parent_contact']) : '';
        $parent_address = isset($_POST['parent_address']) ? trim($_POST['parent_address']) : '';
        $annual_income = isset($_POST['annual_income']) ? trim($_POST['annual_income']) : '';
        
        // Parent/Guardian Information
        $guardian_name = isset($_POST['guardian_name']) ? trim($_POST['guardian_name']) : '';
        $guardian_relationship = isset($_POST['guardian_relationship']) ? trim($_POST['guardian_relationship']) : '';
        $guardian_contact = isset($_POST['guardian_contact']) ? trim($_POST['guardian_contact']) : '';
        $guardian_address = isset($_POST['guardian_address']) ? trim($_POST['guardian_address']) : '';

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

        // Update user account
        // Note: updateUser returns rowCount() which can be 0 if no rows changed, but that's still success
        try {
            $userResult = $this->User->updateUser($userId, $userData);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Failed to update profile: ' . $e->getMessage();
            redirect('/applicant/profile');
            exit;
        }
        
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
            // Educational Background
            'school_name' => $school_name,
            'year_level' => $year_level,
            'school_type' => $school_type,
            'course' => $course,
            'academic_standing' => $academic_standing,
            // Family Background
            'father_name' => $father_name,
            'father_occupation' => $father_occupation,
            'mother_name' => $mother_name,
            'mother_occupation' => $mother_occupation,
            'parent_contact' => $parent_contact,
            'parent_address' => $parent_address,
            'annual_income' => $annual_income,
            // Parent/Guardian Information
            'guardian_name' => $guardian_name,
            'guardian_relationship' => $guardian_relationship,
            'guardian_contact' => $guardian_contact,
            'guardian_address' => $guardian_address,
            'id' => $userId
        ];
        
        try {
            if ($latestApplication) {
                // Update existing application data - use application ID, not user ID
                $applicationId = $latestApplication['id'] ?? null;
                if ($applicationId) {
                    // Remove user_id from update data as it shouldn't change
                    $updateData = $applicationData;
                    unset($updateData['id']);
                    $this->Application->db->table('applications')
                        ->where('id', $applicationId)
                        ->update($updateData);
                }
            } else {
                // Create new application record for profile
                $applicationData['status'] = 'pending';
                $this->Application->saveApplication($applicationData);
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Failed to update profile: ' . $e->getMessage();
            redirect('/applicant/profile');
            exit;
        }
        
        // Update was successful (userResult can be 0 if no user data changed, which is still success)
        // Update session with new data
        $updatedUser = $this->User->findUser($userId);
        if ($updatedUser) {
            unset($updatedUser['password']);
            $_SESSION['user'] = $updatedUser;
        }
        
        $_SESSION['success_message'] = 'Profile updated successfully!';
        redirect('/applicant/profile');
    }

    public function settings()
    {
        $this->call->view('applicant/settings');
    }

    public function updateAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/applicant/settings');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        if (empty($fullname) || empty($email)) {
            $_SESSION['error_message'] = 'Full name and email are required.';
            redirect('/applicant/settings');
            exit;
        }

        // Check if email is already taken by another user
        $existingUser = $this->User->findByEmail($email);
        if ($existingUser && $existingUser['id'] != $userId) {
            $_SESSION['error_message'] = 'Email is already taken by another user.';
            redirect('/applicant/settings');
            exit;
        }

        // Update user account
        $userData = [
            'fullname' => $fullname,
            'email' => $email
        ];

        try {
            $this->User->updateUser($userId, $userData);
            
            // Update session with new data
            $updatedUser = $this->User->findUser($userId);
            if ($updatedUser) {
                unset($updatedUser['password']);
                $_SESSION['user'] = $updatedUser;
            }
            
            $_SESSION['success_message'] = 'Account information updated successfully!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Failed to update account: ' . $e->getMessage();
        }

        redirect('/applicant/settings');
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/applicant/settings');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $currentPassword = isset($_POST['current_password']) ? $_POST['current_password'] : '';
        $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error_message'] = 'All password fields are required.';
            redirect('/applicant/settings');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = 'New password and confirm password do not match.';
            redirect('/applicant/settings');
            exit;
        }

        if (strlen($newPassword) < 6) {
            $_SESSION['error_message'] = 'Password must be at least 6 characters long.';
            redirect('/applicant/settings');
            exit;
        }

        // Get current user
        $user = $this->User->findUser($userId);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/applicant/settings');
            exit;
        }

        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error_message'] = 'Current password is incorrect.';
            redirect('/applicant/settings');
            exit;
        }

        // Update password
        $userData = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];

        try {
            $this->User->updateUser($userId, $userData);
            $_SESSION['success_message'] = 'Password changed successfully!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Failed to change password: ' . $e->getMessage();
        }

        redirect('/applicant/settings');
    }
}
