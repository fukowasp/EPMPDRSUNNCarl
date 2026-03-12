<?php
namespace App\Controllers\Employee\C4sections;

use App\Core\EmployeeBaseController;
use App\Helpers\Auth;
use App\Models\Employee\C4sections\C4sections;

class C4sectionsController extends EmployeeBaseController
{
    protected C4sections $model;
    protected string $uploadDir;
    protected string $publicPath;

    public function __construct()
    {
        parent::__construct();

        $this->model = new C4sections();
        $this->uploadDir = dirname(__DIR__, 4) . '/public/assets/c4sections/';
        $this->publicPath = base_url('public/assets/c4sections/');

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
    }

    /** Show C4 form */
    public function index(): void
    {
        $this->view('Employee/C4sections/C4sections');
    }

    /** Save or update C4 data */
public function save(): void
{
    $employee_id = $this->globalEmployeeData['personalInfo']['employee_id'] ?? null;
    if (!$employee_id) {
        $this->json(['success' => false, 'message' => 'Unauthorized'], 401);
        return;
    }

    $data = $_POST;
    $data['employee_id'] = $employee_id;

    $existing = $this->model->getByEmployeeId($employee_id);
    $data['photo'] = $existing['photo'] ?? null;

    if (!empty($_FILES['photo']['name'])) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','pdf'];
        if (!in_array($ext, $allowed)) {
            $this->json(['success'=>false,'message'=>'Invalid file type.']);
            return;
        }
        $filename = 'photo_' . time() . '.' . $ext;
        $destination = $this->uploadDir . $filename;
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            $this->json(['success'=>false,'message'=>'Failed to upload file.']);
            return;
        }
        $data['photo'] = $filename;
    }

    // Fill missing fields to avoid SQL errors
    $fields = ['q34a','q34b','q35a','q35b','q35b_datefiled','q35b_status','q36','q37',
               'q38a','q38b','q39','q40a','q40b','q40c','ref_name1','ref_address1','ref_tel1',
               'ref_name2','ref_address2','ref_tel2','gov_id','gov_id_no','gov_id_issue'];

    foreach ($fields as $f) {
        if (!isset($data[$f])) $data[$f] = null;
    }

    error_log("Saving C4 section: " . print_r($data, true));

    $saved = $this->model->save($data);

    if (!$saved) {
        error_log("Failed to save C4 section for employee {$employee_id}");
    }

    $this->json([
        'success' => $saved,
        'message' => $saved ? 'C4 section saved successfully!' : 'Failed to save. Please try again.'
    ]);
}



}
