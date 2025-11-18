<?php
class ApplyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->call->database(); // Initialize database connection
        $this->call->model('ApplicationModel', 'Application');
    }

    public function index()
    {
        // Show the scholarship application form
        $this->call->view('apply/form');
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

        $data = array_merge($_POST, [
            'uploaded_files' => json_encode($uploads),
            'id' => $_SESSION['user']['id'] ?? null,
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
