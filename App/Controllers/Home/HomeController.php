<?php
namespace App\Controllers\Home;

use App\Models\Home\Home as HomeModel;

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
        view_render('home/home', $data);
    }   
}