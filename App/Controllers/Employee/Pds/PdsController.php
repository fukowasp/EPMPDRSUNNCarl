<?php
namespace App\Controllers\Employee\Pds;

use App\Core\EmployeeBaseController;

class PdsController extends EmployeeBaseController
{
    public function index(): void
    {
        // Pass employee data to view
        $this->view('Employee/Pds/Preview');
    }
}