<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\DepOffices;

class DepOfficesController extends Controller
{
    protected $model; // No type hint

    public function __construct()
    {
        // Check auth FIRST
        if (!Auth::adminCheck()) {
            header("Location: " . base_url('admin/login'));
            exit;
        }
        
        $this->model = new DepOffices();
    }

    public function index()
    {
        $this->view('Admin/depoffices');
    }

  public function getAll()
  {
      try {
          $rows = $this->model->getAll();
          json_response(['data' => $rows]);
      } catch (\Throwable $e) {
          json_response(['error' => $e->getMessage()], 500);
      }
  }


  public function add()
  {
      try {
          $result = $this->model->add(); // model returns true/false
          if ($result) {
              json_response(['success' => true]);
          } else {
              json_response(['success' => false, 'error' => 'Add failed']);
          }
      } catch (\Throwable $e) {
          json_response(['success' => false, 'error' => $e->getMessage()], 500);
      }
  }




  public function update()
  {
      try {
          $this->model->update();
          json_response(['success' => true]);
      } catch (\Throwable $e) {
          json_response(['success' => false, 'error' => $e->getMessage()], 500);
      }
  }


  public function delete()
  {
      try {
          $dept_id = (int)($_POST['dept_id'] ?? 0);

          if ($dept_id <= 0) {
              json_response([
                  'success' => false,
                  'error' => 'Invalid department ID'
              ], 400);
              return;
          }

          $this->model->delete($dept_id);

          json_response(['success' => true]);

      } catch (\Throwable $e) {
          json_response([
              'success' => false,
              'error' => $e->getMessage()
          ], 500);
      }
  }


}