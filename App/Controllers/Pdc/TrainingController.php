<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Pdc\Training;
use App\Models\Pdc\TrainingTypes;
use App\Models\Pdc\TrainingCategories;

class TrainingController extends Controller
{
    protected Training $trainingModel;
    protected TrainingTypes $typeModel;
    protected TrainingCategories $categoryModel;

    public function __construct()
    {
        try {
            $this->trainingModel = new Training();
            $this->typeModel = new TrainingTypes();
            $this->categoryModel = new TrainingCategories();

            if (!Auth::pdcCheck()) {
                header("Location: " . base_url('pdc/login'));
                exit;
            }
        } catch (\Throwable $e) {
            die("Controller init failed: " . $e->getMessage());
        }
    }

    public function index()
    {
        $this->view('Pdc/Training');
    }

    public function getTrainings()
    {
        try {
            $data = $this->trainingModel->getTrainings();
            json_response(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function addTraining()
    {
        try {
            $success = $this->trainingModel->addTraining($_POST);
            json_response(['success' => $success]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateTraining()
    {
        try {
            $success = $this->trainingModel->updateTraining($_POST);
            json_response(['success' => $success]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function deleteTraining()
    {
        try {
            $success = $this->trainingModel->deleteTraining($_POST['id'] ?? 0);
            json_response(['success' => $success]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getTrainingsJson()
    {
        try {
            $data = $this->trainingModel->getTrainingsData();
            json_response(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getTypes()
    {
        try {
            $data = $this->typeModel->getAll();
            json_response(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getCategories()
    {
        try {
            $data = $this->categoryModel->getAll();
            json_response(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            json_response(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
