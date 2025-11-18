<?php

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        
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
        $applications = $this->Application->getAllApplications();
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
}
