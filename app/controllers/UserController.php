<?php
class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Session library first so it can properly initialize session settings
        $this->call->library('session');
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
        $this->call->database();
        $this->call->library('pagination');
        
        // Get search query
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Pagination settings
        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        
        // Get total count
        $total_rows = $this->User->countUsers($search);
        
        // Calculate offset
        $offset = ($page - 1) * $rows_per_page;
        
        // Get users with search and pagination
        $users = $this->User->searchUsers($search, $rows_per_page, $offset);
        
        // Initialize pagination
        $pagination = $this->pagination;
        $pagination->set_theme('custom');
        $pagination->set_custom_classes([
            'nav' => 'pagination-wrapper',
            'ul' => 'pagination',
            'li' => 'page-item',
            'a' => 'page-link',
            'active' => 'active'
        ]);
        
        // Build base URL with search parameter
        // Pagination library will append page number, so we need to include search in base URL
        $base_url = '/admin/users';
        if (!empty($search)) {
            $base_url .= '?search=' . urlencode($search);
        }
        // Set delimiter to &page= for query string format
        $pagination->set_options(['page_delimiter' => (!empty($search) ? '&page=' : '?page=')]);
        $pagination_data = $pagination->initialize($total_rows, $rows_per_page, $page, $base_url, 5);
        
        $this->call->view('users/index', [
            'users' => $users,
            'search' => $search,
            'pagination' => $pagination,
            'pagination_data' => $pagination_data,
            'total_rows' => $total_rows
        ]);
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
        $this->call->database();
        $user = $this->User->findUser($id);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/admin/users');
            exit;
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

    public function search()
    {
        $this->requireAdmin();
        $this->call->database();
        $this->call->library('pagination');
        
        // Get search query
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Pagination settings
        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        
        // Get total count
        $total_rows = $this->User->countUsers($search);
        
        // Calculate offset
        $offset = ($page - 1) * $rows_per_page;
        
        // Get users with search and pagination
        $users = $this->User->searchUsers($search, $rows_per_page, $offset);
        
        // Initialize pagination
        $pagination = $this->pagination;
        $pagination->set_theme('custom');
        $pagination->set_custom_classes([
            'nav' => 'pagination-wrapper',
            'ul' => 'pagination',
            'li' => 'page-item',
            'a' => 'page-link',
            'active' => 'active'
        ]);
        
        // Build base URL with search parameter
        $base_url = '/admin/users';
        if (!empty($search)) {
            $base_url .= '?search=' . urlencode($search);
        }
        $pagination->set_options(['page_delimiter' => (!empty($search) ? '&page=' : '?page=')]);
        $pagination_data = $pagination->initialize($total_rows, $rows_per_page, $page, $base_url, 5);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'users' => $users,
            'total_rows' => $total_rows,
            'pagination_html' => $pagination_data['last'] > 1 ? $pagination->paginate() : '',
            'pagination_info' => $pagination_data['info'] ?? '',
            'search' => $search
        ]);
        exit;
    }
}
