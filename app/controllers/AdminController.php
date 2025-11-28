<?php

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Session library first so it can properly initialize session settings
        $this->call->library('session');
        
        // Check if user is admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            redirect('/login');
            exit;
        }

        $this->call->database(); // Initialize database connection
        $this->call->model('ApplicationModel', 'Application');  
    }

    public function dashboard()
    {
        $statistics = $this->Application->getStatistics();
        $this->call->view('admin/dashboard', ['statistics' => $statistics]);
    }

    public function applications()
    {
        // Get all applications for review (pending status)
        $applications = $this->Application->getApplicationsForReview();
        $this->call->view('admin/applications', ['applications' => $applications]);
    }
    

    public function view($id)
    {
        $application = $this->Application->getById($id);
        if (!$application) {
            $_SESSION['error_message'] = 'Application not found.';
            redirect('/admin/applications');
            exit;
        }
        $this->call->view('admin/view_application', ['application' => $application]);
    }

    public function approve($id)
    {
        $result = $this->Application->updateStatus($id, 'Approved');
        if ($result) {
            $_SESSION['success_message'] = 'Application approved successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to approve application.';
        }
        redirect('/admin/applications');
    }

    public function reject($id)
    {
        $result = $this->Application->updateStatus($id, 'Rejected');
        if ($result) {
            $_SESSION['success_message'] = 'Application rejected successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to reject application.';
        }
        redirect('/admin/applications');
    }


public function verify($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $status = $_POST['status'];

            $applicationModel = new ApplicationModel();
            $update = $applicationModel->updateStatus($id, $status);

        if ($update) {
            redirect('/admin/applications?success=1');
        } else {
            redirect('/admin/applications?error=1');
        }
    }

    redirect('/admin/applications');
}

    public function settings()
    {
        $this->call->model('UserModel', 'User');
        $this->call->view('admin/settings');
    }

    public function updateAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/settings');
            exit;
        }

        $this->call->model('UserModel', 'User');
        $userId = $_SESSION['user']['id'];
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        if (empty($fullname) || empty($email)) {
            $_SESSION['error_message'] = 'Full name and email are required.';
            redirect('/admin/settings');
            exit;
        }

        // Check if email is already taken by another user
        $existingUser = $this->User->findByEmail($email);
        if ($existingUser && $existingUser['id'] != $userId) {
            $_SESSION['error_message'] = 'Email is already taken by another user.';
            redirect('/admin/settings');
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

        redirect('/admin/settings');
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/settings');
            exit;
        }

        $this->call->model('UserModel', 'User');
        $userId = $_SESSION['user']['id'];
        $currentPassword = isset($_POST['current_password']) ? $_POST['current_password'] : '';
        $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error_message'] = 'All password fields are required.';
            redirect('/admin/settings');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = 'New password and confirm password do not match.';
            redirect('/admin/settings');
            exit;
        }

        if (strlen($newPassword) < 6) {
            $_SESSION['error_message'] = 'Password must be at least 6 characters long.';
            redirect('/admin/settings');
            exit;
        }

        // Get current user
        $user = $this->User->findUser($userId);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/admin/settings');
            exit;
        }

        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error_message'] = 'Current password is incorrect.';
            redirect('/admin/settings');
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

        redirect('/admin/settings');
    }
}
