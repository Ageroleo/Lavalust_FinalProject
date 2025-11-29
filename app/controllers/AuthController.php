<?php
class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Session library first so it can properly initialize session settings
        $this->call->library('session');
        $this->call->model('UserModel', 'User');
    }

    public function index()
    {
        // If already logged in, redirect by role
        if (!empty($_SESSION['user'])) {
            return $this->redirectByRole($_SESSION['user']['role']);
        }
        $this->call->view('auth/login');
    }

    public function login()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

        // Hardcoded admin login - set session properly
        if ($email === 'admin@naujan.local' && $password === 'admin123') {
            $_SESSION['user'] = [
                'id' => 0,
                'email' => 'admin@naujan.local',
                'fullname' => 'Administrator',
                'role' => 'admin'
            ];
            return $this->redirectByRole('admin');
        }

        $user = $this->User->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            $_SESSION['user'] = $user;
            return $this->redirectByRole($user['role']);
        }

        $this->call->view('auth/login', ['error' => 'Invalid login credentials']);
    }

    public function registerPage()
    {
        // Only guests can access register page
        if (!empty($_SESSION['user'])) {
            return $this->redirectByRole($_SESSION['user']['role']);
        }
        $this->call->view('auth/register');
    }

    public function register()
    {
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? (string)$_POST['confirm_password'] : '';

        // Validate required fields
        if ($fullname === '' || $email === '' || $password === '' || $confirm_password === '') {
            return $this->call->view('auth/register', ['error' => 'All fields are required']);
        }

        // Validate password match
        if ($password !== $confirm_password) {
            return $this->call->view('auth/register', ['error' => 'Passwords do not match']);
        }

        // Validate password requirements
        $passwordErrors = $this->validatePassword($password);
        if (!empty($passwordErrors)) {
            return $this->call->view('auth/register', ['error' => implode(' ', $passwordErrors)]);
        }

        if ($this->User->findByEmail($email)) {
            return $this->call->view('auth/register', ['error' => 'Email already registered']);
        }

        $userPayload = [
            'fullname' => $fullname,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'applicant',
            'is_verified' => 1
        ];

        $this->User->createUser($userPayload);
        $_SESSION['success'] = 'Registration successful! You can now log in.';

        redirect('/login');
        exit;

    }

    private function validatePassword($password)
    {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }

        return $errors;
    }

    public function logout()
    {
        session_destroy();
        return redirect('/login');
    }

    public function adminDashboard()
    {
        $this->requireRole('admin');
        $this->call->database();
        $this->call->model('ApplicationModel', 'Application');
        $statistics = $this->Application->getStatistics();
        $this->call->view('dashboard_admin', ['statistics' => $statistics]);
    }

    public function applicantDashboard()
    {
        $this->requireRole('applicant');
        $this->call->view('dashboard_applicant');
    }

    private function requireRole($role)
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
            redirect('/login');
            exit;
        }
    }

    private function redirectByRole($role)
    {
        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/applicant/dashboard');
    }
}
