<?php
class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->call->model('UserModel', 'User');
    }

    private function requireAdmin()
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            redirect('/login');
            exit;
        }
    }

    public function index()
    {
        $this->requireAdmin();
        $users = $this->User->allUsers();
        $this->call->view('users/index', ['users' => $users]);
    }

    public function create()
    {
        $this->requireAdmin();
        $this->call->view('users/create');
    }

    public function store()
    {
        $this->requireAdmin();
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : 'applicant';

        if ($fullname === '' || $email === '') {
            return $this->call->view('users/create', ['error' => 'Name and Email are required']);
        }

        if ($this->User->findByEmail($email)) {
            return $this->call->view('users/create', ['error' => 'Email already exists']);
        }

        $data = ['fullname' => $fullname, 'email' => $email, 'role' => $role];
        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $data['password'] = password_hash(bin2hex(random_bytes(6)), PASSWORD_DEFAULT);
        }

        $this->User->createUser($data);
        return redirect('/admin/users');
    }

    public function edit($id)
    {
        $this->requireAdmin();
        $user = $this->User->findUser($id);
        if (!$user) {
            return $this->call->view('users/index', ['users' => $this->User->allUsers(), 'error' => 'User not found']);
        }
        $this->call->view('users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        $this->requireAdmin();
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : 'applicant';

        if ($fullname === '' || $email === '') {
            return $this->call->view('users/edit', ['user' => $this->User->findUser($id), 'error' => 'fullname and Email are required']);
        }

        $data = ['fullname' => $fullname, 'email' => $email, 'role' => $role];
        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->User->updateUser($id, $data);
        return redirect('/admin/users');
    }

    public function destroy($id)
    {
        $this->requireAdmin();
        $this->User->deleteUser($id);
        return redirect('/admin/users');
    }
}
