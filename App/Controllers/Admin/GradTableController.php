<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\GradTable;

class GradTableController extends Controller
{
    protected GradTable $model;

    public function __construct()
    {
        $this->model = new GradTable();

        if (!Auth::adminCheck()) {
            if ($this->isAjax()) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unauthorized'
                ]);
                exit;
            }

            header("Location: " . base_url('admin/login'));
            exit;
        }
    }

    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }


    public function index()
    {
        $this->view('Admin/GradTable');
    }


    public function getAll()
    {
        $this->model->getAll();
    }

    public function add()
    {
        $this->model->add();
    }

    public function update()
    {
        $this->model->update();
    }

    public function delete()
    {
        $this->model->delete();
    }
}
