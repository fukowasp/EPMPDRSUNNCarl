<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\FullAdminDashboardModel;

class FullAdminDashboardController extends Controller
{
    protected FullAdminDashboardModel $model;

    public function __construct()
    {
        $this->model = new FullAdminDashboardModel();
    }

    public function index()
    {
        if (!Auth::fullAdminCheck()) {
            header("Location: " . base_url('admin/login'));
            exit;
        }

        $fullAdmin = Auth::fullAdminUser();

        $data = [
            'adminCount' => $this->model->getCountByRole('admin'),
            'pdcCount'   => $this->model->getCountByRole('pdc'),
            'fullAdmin'  => $fullAdmin,
            'allUsers'   => $this->model->getAllUsers()
        ];

        return $this->view('Admin/FullAdminDashboard', $data);
    }

    public function addUser()
    {
        csrf_check_or_fail(); // ✅ verify token

        if(empty($_POST['username']) || empty($_POST['password'])){
            json_response([
                'success' => false,
                'message' => 'Username and Password required',
                'csrf_token' => csrf_regenerate() // always send new CSRF
            ], 400);
            return;
        }

        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'], // ← RAW password
            'role'     => $_POST['role'],
            'status'   => $_POST['status']
        ];

        $success = $this->model->addUser($data);

        json_response([
            'success' => $success,
            'message' => $success ? 'User added successfully' : 'Failed to add user',
            'csrf_token' => csrf_regenerate() // send new CSRF
        ]);
    }

    public function updateUser()
    {
        csrf_check_or_fail(); // ✅ verify token

        $id = $_POST['id'];
        $data = [
            'username' => $_POST['username'],
            'role'     => $_POST['role'],
            'status'   => $_POST['status']
        ];
      if(!empty($_POST['password'])) 
          $data['password'] = $_POST['password'];


        $success = $this->model->updateUser($id, $data);

        json_response([
            'success' => $success,
            'message' => $success ? 'User updated successfully' : 'Failed to update user',
            'csrf_token' => csrf_regenerate()
        ]);
    }

    public function deleteUser()
    {
        csrf_check_or_fail(); // ✅ verify token

        $id = $_POST['id'];
        $success = $this->model->deleteUser($id);

        json_response([
            'success' => $success,
            'message' => $success ? 'User deleted successfully' : 'Failed to delete user',
            'csrf_token' => csrf_regenerate()
        ]);
    }



    public function getUserById()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            json_response(['success' => false, 'message' => 'User ID is required'], 400);
            return;
        }

        $user = $this->model->getUserById((int)$id);

        if ($user) {
            json_response($user);
        } else {
            json_response(['success' => false, 'message' => 'User not found'], 404);
        }
    }


    public function logout()
    {
        Auth::fullAdminLogout();
    }
}