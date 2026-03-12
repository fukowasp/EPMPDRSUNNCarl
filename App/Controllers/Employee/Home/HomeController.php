<?php
namespace App\Controllers\Employee\Home;

use App\Models\Employee\Home\Home as HomeModel;


class HomeController
{
    protected $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }

    public function index()
    {
        $data = $this->homeModel->getData();

        // Pass it to the view
        view_render('Employee/Home/Home', $data);
    }   
}
