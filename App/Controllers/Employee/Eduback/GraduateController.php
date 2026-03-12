<?php
namespace App\Controllers\Employee\Eduback;

use App\Core\Controller;
use App\Models\Admin\GradTable;

class GraduateController extends Controller
{
    protected GradTable $model;

    public function __construct()
    {
        $this->model = new GradTable();
    }

    public function getAllJson(): void
    {
        $courses = $this->model->getAllCourses();
        json_response(['data' => $courses]);
    }
}
