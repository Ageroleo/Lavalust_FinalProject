<?php
class ApplyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Session library first so it can properly initialize session settings
        $this->call->library('session');
        $this->call->database(); // Initialize database connection
        $this->call->model('ApplicationModel', 'Application');
        $this->call->model('UserModel', 'User');
    }

    public function index()
    {
        // Check if user is logged in
        if (empty($_SESSION['user'])) {
            redirect('/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        
        // Get user data
        $user = $this->User->findUser($userId);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/login');
            exit;
        }
        
        // Get latest application or profile data (which contains profile information for pre-filling)
        $applications = $this->Application->getProfileDataByUser($userId);
        $latestApplication = !empty($applications) ? $applications[0] : null;
        
        // Merge user data with application data for form pre-filling
        $formData = array_merge($user, $latestApplication ?: []);
        
        // Show the scholarship application form with pre-filled data
        $this->call->view('apply/form', ['formData' => $formData]);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('apply/form');
            exit;
        }

        $required_fields = ['last_name', 'first_name', 'address', 'birthday', 'email'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error_message'] = 'Please fill in all required fields.';
                redirect('apply/form');
                exit;
            }
        }

        $uploads = [];
        $upload_dir = 'public/uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
        foreach ($_FILES as $key => $file) {
            if (!empty($file['name'])) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed_ext)) {
                    $_SESSION['error_message'] = 'Invalid file type: ' . htmlspecialchars($file['name']);
                    redirect('apply/form');
                    exit;
                }

                $filename = uniqid() . '_' . basename($file['name']);
                $target_path = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    $uploads[$key] = $filename;
                }
            }
        }

        // Remove 'id' from POST data if it exists (it shouldn't be in the form)
        $postData = $_POST;
        unset($postData['id']);
        
        $data = array_merge($postData, [
            'uploaded_files' => json_encode($uploads),
            'id' => $_SESSION['user']['id'] ?? null, // Link application to user
        ]);

        $this->Application->saveApplication($data);

        $_SESSION['success_message'] = 'Your scholarship application was submitted successfully!';
        redirect('/applicant/dashboard');
        exit;
    }

    public function success()
{
    // Load the success view
    $this->call->view('apply/success');
}

}
