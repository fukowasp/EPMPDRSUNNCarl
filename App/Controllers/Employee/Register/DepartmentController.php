<?php
namespace App\Controllers\Employee\Register;

use App\Core\Controller;
use App\Models\Admin\DepOffices;

class DepartmentController extends Controller
{
    protected DepOffices $model;

    public function __construct()
    {
        $this->model = new DepOffices();
    }

  public function getAllJson(): void
  {
      try {
          $stmt = $this->model->getAllJson();
          json_response(['status' => 'success', 'data' => $stmt]);
      } catch (\Exception $e) {
          // Return JSON even on error
          json_response(['status' => 'error', 'message' => $e->getMessage()], 500);
      }
  }

}
