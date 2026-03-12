<?php
declare(strict_types=1);

namespace App\Models\Admin;

use PDO;
use App\Core\Database;

class EmployeeList
{
    protected PDO $conn;

    protected array $singleTables = [
        'personal_information',
        'family_background',
        'educational_background'
    ];

    protected array $multiTables = [
        'graduate_studies' => ['institution_name','graduate_course','year_graduated','units_earned','specialization','honor_received','certification_file'],
        'civil_service_eligibility' => ['career_service','rating','date_of_examination_conferment','place_of_examination_conferment','proof_of_certification'],
        'work_experience' => ['work_date_from','work_date_to','work_position','work_company','work_salary','work_grade','work_status','work_govt_service'],
        'voluntarywork' => ['organization_name','position_role','organization_address','start_date','end_date','number_of_hours','membership_id_url'],
        'learning_development_programs' => ['ld_title','ld_date_from','ld_date_to','ld_hours','ld_type','ld_sponsor','ld_certification'],
        'other_information_skills' => ['skill_hobby'],
        'other_information_recognition' => ['recognition'],
        'other_information_membership' => ['membership']
    ];

    public function __construct(?PDO $pdo = null)
    {
        $this->conn = $pdo ?? Database::getInstance();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    // ----------------------
    // Fetch single employee (full PDS)
    // ----------------------
    public function getEmployee(string $employeeId): array
    {
        // First get employee_register data
        $stmt = $this->conn->prepare("SELECT * FROM employee_register WHERE employee_id = ?");
        $stmt->execute([$employeeId]);
        $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$employeeData) return [];

        $data = $employeeData; // Start with employee_register fields

        // Get personal_information
        $stmt = $this->conn->prepare("SELECT * FROM personal_information WHERE employee_id = ?");
        $stmt->execute([$employeeId]);
        $personalInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($personalInfo) {
            // Merge personal_information fields into main data array
            $data = array_merge($data, $personalInfo);
        }

        // Single-row tables (family, education)
        foreach (['family_background', 'educational_background'] as $table) {
            $stmt = $this->conn->prepare("SELECT * FROM {$table} WHERE employee_id = ?");
            $stmt->execute([$employeeId]);
            $data[$table] = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        // Multi-row tables
        foreach ($this->multiTables as $table => $fields) {
            $stmt = $this->conn->prepare("SELECT * FROM {$table} WHERE employee_id = ?");
            $stmt->execute([$employeeId]);
            $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }

    // ----------------------
    // Update full employee info
    // ----------------------
    public function updateEmployee(string $employeeId, array $input, array $files = []): bool
    {
        try {
            $this->conn->beginTransaction();

            // Update single-row tables (personal info, family, education)
            $this->updateSingleRowTables($employeeId, $input);

            // Update multi-row tables (graduate studies, etc.)
            $this->updateMultiRowTables($employeeId, $input, $files);

            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            error_log("Update employee failed: " . $e->getMessage());
            throw $e;
        }
    }

    protected function updateSingleRowTables(string $employeeId, array $input): void
    {
        // ============== UPDATE PERSONAL INFORMATION ==============
        $personalFields = [
            'surname', 'first_name', 'middle_name', 'name_extension',
            'date_of_birth', 'place_of_birth', 'sex', 'civil_status',
            'citizenship_type', 'dual_citizenship_by', 'dual_citizenship_country',
            'height', 'weight', 'blood_type',
            'gsis_id_no', 'pagibig_id_no', 'philhealth_no', 'sss_no', 'tin_no',
            'agency_employee_no',
            'res_house_block_lot', 'res_street', 'res_subdivision', 'res_barangay',
            'res_city_municipality', 'res_province', 'res_zip_code',
            'perm_house_block_lot', 'perm_street', 'perm_subdivision', 'perm_barangay',
            'perm_city_municipality', 'perm_province', 'perm_zip_code',
            'telephone_no', 'mobile_no', 'email_address'
        ];

        $personalData = ['employee_id' => $employeeId];
        foreach ($personalFields as $field) {
            if (isset($input[$field])) {
                $personalData[$field] = $input[$field];
            }
        }

        if (count($personalData) > 1) { // More than just employee_id
            $this->upsertSingleTable('personal_information', $employeeId, $personalData);
        }

        // ============== UPDATE FAMILY BACKGROUND ==============
        $familyFields = [
            'spouse_surname', 'spouse_first_name', 'spouse_middle_name', 'spouse_name_extension',
            'spouse_occupation', 'spouse_employer_name', 'spouse_business_address', 'spouse_telephone_no',
            'father_surname', 'father_first_name', 'father_middle_name', 'father_name_extension',
            'mother_maiden_name', 'mother_surname', 'mother_first_name', 'mother_middle_name'
        ];

        $familyData = ['employee_id' => $employeeId];
        foreach ($familyFields as $field) {
            if (isset($input[$field])) {
                $familyData[$field] = $input[$field];
            }
        }

        if (count($familyData) > 1) {
            $this->upsertSingleTable('family_background', $employeeId, $familyData);
        }

        // ============== UPDATE EDUCATIONAL BACKGROUND ==============
        $eduFields = [
            'elementary_school_name', 'elementary_year_graduated', 'elementary_honor',
            'secondary_school_name', 'secondary_year_graduated', 'secondary_honor',
            'seniorhigh_school_name', 'seniorhigh_year_graduated', 'seniorhigh_honor',
            'vocational_course', 'vocational_year_completed', 'vocational_honor',
            'college_course', 'college_year_graduated', 'college_units_earned', 'college_honor'
        ];

        $eduData = ['employee_id' => $employeeId];
        foreach ($eduFields as $field) {
            if (isset($input[$field])) {
                $eduData[$field] = $input[$field];
            }
        }

        if (count($eduData) > 1) {
            $this->upsertSingleTable('educational_background', $employeeId, $eduData);
        }
    }

    protected function updateMultiRowTables(string $employeeId, array $input): void
    {
        // ----------------------
        // DELETE Graduate Studies
        // ----------------------
        if (!empty($input['grad_delete'])) {
            foreach ($input['grad_delete'] as $deleteId) {
                $stmt = $this->conn->prepare("DELETE FROM graduate_studies WHERE id = ?");
                $stmt->execute([$deleteId]);
            }
        }

        // ----------------------
        // INSERT / UPDATE Graduate Studies
        // ----------------------
        $count = count($input['graduate_course'] ?? []);
        for ($i = 0; $i < $count; $i++) {
            $row = [
                'id' => $input['grad_id'][$i] ?? null,
                'employee_id' => $employeeId,
                'graduate_course' => $input['graduate_course'][$i] ?? '',
                'institution_name' => $input['institution_name'][$i] ?? '',
                'year_graduated' => $input['year_graduated'][$i] ?? '',
                'units_earned' => $input['units_earned'][$i] ?? '',
                'specialization' => $input['specialization'][$i] ?? '',
                'honor_received' => $input['honor_received'][$i] ?? '',
            ];

            if (!empty($input['certification_file'][$i])) {
                $row['certification_file'] = $input['certification_file'][$i];
            }

            $this->upsertGraduateStudy($row);
        }

        // ----------------------
        // DELETE Civil Service
        // ----------------------
        if (!empty($input['civil_delete'])) {
            foreach ($input['civil_delete'] as $deleteId) {
                $stmt = $this->conn->prepare("DELETE FROM civil_service_eligibility WHERE id = ?");
                $stmt->execute([$deleteId]);
            }
        }

        // ----------------------
        // INSERT / UPDATE Civil Service
        // ----------------------
        if (!empty($input['career_service'])) {
            $row = [
                'id' => $input['civil_id'] ?? null,
                'employee_id' => $employeeId,
                'career_service' => $input['career_service'] ?? '',
                'rating' => $input['rating'] ?? '',
                'date_of_examination_conferment' => $input['date_of_examination_conferment'] ?? '',
                'place_of_examination_conferment' => $input['place_of_examination_conferment'] ?? '',
            ];

            if (!empty($input['proof_of_certification'])) {
                $row['proof_of_certification'] = $input['proof_of_certification'];
            }

            $this->upsertCivilService($row);
        }

        // ----------------------
        // DELETE Work Experience
        // ----------------------
        if (!empty($input['work_delete'])) {
            foreach ($input['work_delete'] as $deleteId) {
                $stmt = $this->conn->prepare("DELETE FROM work_experience WHERE id = ?");
                $stmt->execute([$deleteId]);
            }
        }

        // ----------------------
        // INSERT / UPDATE Work Experience
        // ----------------------
        $count = count($input['work_date_from'] ?? []);
        for ($i = 0; $i < $count; $i++) {
            $row = [
                'id' => $input['work_id'][$i] ?? null,
                'employee_id' => $employeeId,
                'work_date_from' => $input['work_date_from'][$i] ?? '',
                'work_date_to' => $input['work_date_to'][$i] ?? '',
                'work_position' => $input['work_position'][$i] ?? '',
                'work_company' => $input['work_company'][$i] ?? '',
                'work_salary' => $input['work_salary'][$i] ?? '',
                'work_grade' => $input['work_grade'][$i] ?? '',
                'work_status' => $input['work_status'][$i] ?? '',
                'work_govt_service' => $input['work_govt_service'][$i] ?? ''
            ];

            $this->upsertWorkExperience($row);
        }
        
        // ----------------------
        // INSERT / UPDATE Voluntary Work
        // ----------------------
        if (!empty($input['organization_name']) || !empty($input['voluntary_id'])) {
            $data = [
                'voluntary_id' => $input['voluntary_id'] ?? null,
                'employee_id' => $employeeId,
                'organization_name' => $input['organization_name'] ?? '',
                'position_role' => $input['position_role'] ?? '',
                'organization_address' => $input['organization_address'] ?? '',
                'start_date' => $input['start_date'] ?? '',
                'end_date' => $input['end_date'] ?? '',
                'number_of_hours' => $input['number_of_hours'] ?? 0,
                'membership_id_url' => $input['membership_id_url'] ?? null 
            ];
            
            $this->upsertVoluntaryWork($data);
        } 

        // ----------------------
        // DELETE Learning Development
        // ----------------------
        if (!empty($input['ld_delete'])) {
            foreach ($input['ld_delete'] as $deleteId) {
                $stmt = $this->conn->prepare("DELETE FROM learning_development_programs WHERE id = ?");
                $stmt->execute([$deleteId]);
            }
        }

        // ----------------------
        // INSERT / UPDATE Learning Development
        // ----------------------
        if (!empty($input['ld_title'])) {
            $data = [
                'id' => $input['ld_id'] ?? null,
                'employee_id' => $employeeId,
                'ld_title' => $input['ld_title'] ?? '',
                'ld_date_from' => $input['ld_date_from'] ?? '',
                'ld_date_to' => $input['ld_date_to'] ?? '',
                'ld_hours' => $input['ld_hours'] ?? 0,
                'ld_type' => $input['ld_type'] ?? '',
                'ld_sponsor' => $input['ld_sponsor'] ?? '',
                'ld_certification' => $input['ld_certification'] ?? null
            ];
            
            $this->upsertLearningDevelopment($data);
        }

        if (!empty($input['skill_hobby']) || !empty($input['recognition']) || !empty($input['membership'])) {
            $data = [
                'other_info_id' => $input['other_info_id'] ?? null,
                'employee_id' => $employeeId,
                'skill_hobby' => $input['skill_hobby'] ?? '',
                'recognition' => $input['recognition'] ?? '',
                'membership' => $input['membership'] ?? ''
            ];
            
            $this->upsertOtherInformation($data);
        }
    }

    public function getAll(int $limit = 200, int $offset = 0, ?string $search = null): array
    {
        $where = '';
        $params = [];

        if ($search) {
            $where = "WHERE pi.first_name LIKE :search OR pi.surname LIKE :search OR er.employee_id LIKE :search";
            $params[':search'] = "%$search%";
        }

        $countSql = "SELECT COUNT(*) 
                    FROM employee_register er
                    LEFT JOIN personal_information pi ON pi.employee_id = er.employee_id
                    $where";
        $countStmt = $this->conn->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        // Use integer interpolation for LIMIT/OFFSET
        $offset = (int)$offset;
        $limit = (int)$limit;

        $sql = "SELECT 
                    er.employee_id,
                    er.department,
                    er.employment_type,
                    pi.first_name,
                    pi.surname,
                    pi.middle_name,
                    pi.mobile_no,
                    pi.email_address
                FROM employee_register er
                LEFT JOIN personal_information pi ON pi.employee_id = er.employee_id
                $where
                ORDER BY pi.surname ASC
                LIMIT $offset, $limit";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'rows' => $rows,
            'pagination' => [
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]
        ];
    }

    // ----------------------
    // Graduate studies upsert
    // ----------------------
    protected function upsertGraduateStudy(array $data): bool
    {
        $id = $data['id'] ?? null;
        
        // Clean empty id
        if (empty($id)) {
            $id = null;
        }
        
        unset($data['id']);

        if ($id) {
            // UPDATE existing record
            $updateData = $data;
            unset($updateData['employee_id']); // Don't update employee_id
            
            $setStr = implode(', ', array_map(fn($c) => "`$c` = :$c", array_keys($updateData)));
            $sql = "UPDATE graduate_studies SET $setStr WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($updateData as $key => $val) {
                $stmt->bindValue(":$key", $val);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } else {
            // INSERT new record
            $cols = implode(', ', array_map(fn($c) => "`$c`", array_keys($data)));
            $placeholders = implode(', ', array_map(fn($c) => ":$c", array_keys($data)));
            $sql = "INSERT INTO graduate_studies ($cols) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute($data);
        }
    }

    protected function upsertCivilService(array $data): bool
    {
        $id = $data['id'] ?? null;
        
        // Clean empty id
        if (empty($id)) {
            $id = null;
        }

        if ($id) {
            // UPDATE existing record
            $updateData = $data;
            unset($updateData['id']);
            unset($updateData['employee_id']); // Don't update employee_id
            
            // Only update proof_of_certification if new file provided
            $setFields = [];
            foreach ($updateData as $key => $val) {
                if ($key === 'proof_of_certification' && empty($val)) {
                    continue; // Skip if no new file
                }
                $setFields[] = "`$key` = :$key";
            }
            
            if (empty($setFields)) {
                return true; // Nothing to update
            }
            
            $setStr = implode(', ', $setFields);
            $sql = "UPDATE civil_service_eligibility SET $setStr WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($updateData as $key => $val) {
                if ($key === 'proof_of_certification' && empty($val)) {
                    continue;
                }
                $stmt->bindValue(":$key", $val);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } else {
            // INSERT new record
            unset($data['id']);
            
            $cols = implode(', ', array_map(fn($c) => "`$c`", array_keys($data)));
            $placeholders = implode(', ', array_map(fn($c) => ":$c", array_keys($data)));
            $sql = "INSERT INTO civil_service_eligibility ($cols) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute($data);
        }
    }

    protected function upsertWorkExperience(array $data): bool
    {
        $id = $data['id'] ?? null;

        // Clean empty id
        if (empty($id)) {
            $id = null;
        }

        unset($data['id']);

        if ($id) {
            // UPDATE existing record
            $updateData = $data;
            unset($updateData['employee_id']); // Don't update employee_id

            $setStr = implode(', ', array_map(fn($c) => "`$c` = :$c", array_keys($updateData)));
            $sql = "UPDATE work_experience SET $setStr WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            foreach ($updateData as $key => $val) {
                $stmt->bindValue(":$key", $val);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } else {
            // INSERT new record
            $cols = implode(', ', array_map(fn($c) => "`$c`", array_keys($data)));
            $placeholders = implode(', ', array_map(fn($c) => ":$c", array_keys($data)));
            $sql = "INSERT INTO work_experience ($cols) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute($data);
        }
    }

    protected function upsertVoluntaryWork(array $data): bool
    {
        $id = $data['voluntary_id'] ?? null;
        
        // Clean empty id
        if (empty($id)) {
            $id = null;
        }
        
        if ($id) {
            // UPDATE existing record
            $sql = "UPDATE voluntarywork 
                    SET organization_name = :organization_name,
                        position_role = :position_role,
                        organization_address = :organization_address,
                        start_date = :start_date,
                        end_date = :end_date,
                        number_of_hours = :number_of_hours";
            
            // Only update file if new one provided
            if (!empty($data['membership_id_url'])) {
                $sql .= ", membership_id_url = :membership_id_url";
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':organization_name', $data['organization_name']);
            $stmt->bindValue(':position_role', $data['position_role']);
            $stmt->bindValue(':organization_address', $data['organization_address']);
            $stmt->bindValue(':start_date', $data['start_date']);
            $stmt->bindValue(':end_date', $data['end_date']);
            $stmt->bindValue(':number_of_hours', (int)$data['number_of_hours'], PDO::PARAM_INT);
            
            if (!empty($data['membership_id_url'])) {
                $stmt->bindValue(':membership_id_url', $data['membership_id_url']);
            }
            
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } else {
            // INSERT new record
            $sql = "INSERT INTO voluntarywork 
                    (employee_id, organization_name, position_role, organization_address, 
                    start_date, end_date, number_of_hours, membership_id_url)
                    VALUES 
                    (:employee_id, :organization_name, :position_role, :organization_address,
                    :start_date, :end_date, :number_of_hours, :membership_id_url)";
            
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute([
                'employee_id' => $data['employee_id'],
                'organization_name' => $data['organization_name'],
                'position_role' => $data['position_role'],
                'organization_address' => $data['organization_address'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'number_of_hours' => (int)$data['number_of_hours'],
                'membership_id_url' => $data['membership_id_url'] ?? null
            ]);
        }
    }

    // ----------------------
    // Upsert Learning Development
    // ----------------------
    protected function upsertLearningDevelopment(array $data): bool
    {
        $id = $data['id'] ?? null;
        
        // Clean empty id
        if (empty($id)) {
            $id = null;
        }
        
        if ($id) {
            // UPDATE existing record
            $sql = "UPDATE learning_development_programs 
                    SET ld_title = :ld_title,
                        ld_date_from = :ld_date_from,
                        ld_date_to = :ld_date_to,
                        ld_hours = :ld_hours,
                        ld_type = :ld_type,
                        ld_sponsor = :ld_sponsor";
            
            // Only update file if new one provided
            if (!empty($data['ld_certification'])) {
                $sql .= ", ld_certification = :ld_certification";
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':ld_title', $data['ld_title']);
            $stmt->bindValue(':ld_date_from', $data['ld_date_from']);
            $stmt->bindValue(':ld_date_to', $data['ld_date_to']);
            $stmt->bindValue(':ld_hours', (int)$data['ld_hours'], PDO::PARAM_INT);
            $stmt->bindValue(':ld_type', $data['ld_type']);
            $stmt->bindValue(':ld_sponsor', $data['ld_sponsor']);
            
            if (!empty($data['ld_certification'])) {
                $stmt->bindValue(':ld_certification', $data['ld_certification']);
            }
            
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } else {
            // INSERT new record
            $sql = "INSERT INTO learning_development_programs 
                    (employee_id, ld_title, ld_date_from, ld_date_to, ld_hours, ld_type, ld_sponsor, ld_certification)
                    VALUES 
                    (:employee_id, :ld_title, :ld_date_from, :ld_date_to, :ld_hours, :ld_type, :ld_sponsor, :ld_certification)";
            
            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute([
                'employee_id' => $data['employee_id'],
                'ld_title' => $data['ld_title'],
                'ld_date_from' => $data['ld_date_from'],
                'ld_date_to' => $data['ld_date_to'],
                'ld_hours' => (int)$data['ld_hours'],
                'ld_type' => $data['ld_type'],
                'ld_sponsor' => $data['ld_sponsor'],
                'ld_certification' => $data['ld_certification'] ?? null
            ]);
        }
    }


    // ----------------------
    // Delete methods
    // ----------------------
    public function deleteGraduateStudy(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM graduate_studies WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Exception $e) {
            error_log("Delete graduate study failed: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCivilService(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM civil_service_eligibility WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Exception $e) {
            error_log("Delete civil service failed: " . $e->getMessage());
            return false;
        }
    }

    public function deleteWorkExperience(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM work_experience WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Exception $e) {
            error_log("Delete work experience failed: " . $e->getMessage());
            return false;
        }
    }

    public function deleteVoluntaryWork(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM voluntarywork WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Exception $e) {
            error_log("Delete voluntary work failed: " . $e->getMessage());
            return false;
        }
    }

    // ----------------------
    // Delete Learning Development
    // ----------------------
    public function deleteLearningDevelopment(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM learning_development_programs WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Exception $e) {
            error_log("Delete learning development failed: " . $e->getMessage());
            return false;
        }
    }

        // Delete Employee (and all related records)
        // ----------------------
        public function deleteEmployee(string $employeeId): bool
        {
            try {
                $this->conn->beginTransaction();
                
                // Delete from all related tables first
                $tables = [
                    'graduate_studies',
                    'civil_service_eligibility',
                    'work_experience',
                    'voluntarywork',
                    'learning_development_programs',
                    'other_information_skills',
                    'other_information_recognition',
                    'other_information_membership',
                    'educational_background',
                    'family_background',
                    'personal_information'
                ];
                
                foreach ($tables as $table) {
                    $stmt = $this->conn->prepare("DELETE FROM {$table} WHERE employee_id = ?");
                    $stmt->execute([$employeeId]);
                }
                
                // Finally delete from employee_register
                $stmt = $this->conn->prepare("DELETE FROM employee_register WHERE employee_id = ?");
                $stmt->execute([$employeeId]);
                
                $this->conn->commit();
                return true;
                
            } catch (\Exception $e) {
                $this->conn->rollBack();
                error_log("Delete employee failed: " . $e->getMessage());
                throw $e;
            }
        }

    protected function upsertOtherInformation(array $data): bool
    {
        $employeeId = $data['employee_id'];
        $skillHobby = $data['skill_hobby'] ?? '';
        $recognition = $data['recognition'] ?? '';
        $membership = $data['membership'] ?? '';
        
        try {
            // Insert skill if provided
            if (!empty($skillHobby)) {
                if (!empty($data['other_info_id'])) {
                    // Update existing
                    $stmt = $this->conn->prepare(
                        "UPDATE other_information_skills 
                        SET skill_hobby = :skill_hobby 
                        WHERE id = :id"
                    );
                    $stmt->execute([
                        'skill_hobby' => $skillHobby,
                        'id' => $data['other_info_id']
                    ]);
                } else {
                    // Insert new
                    $stmt = $this->conn->prepare(
                        "INSERT INTO other_information_skills (employee_id, skill_hobby) 
                        VALUES (:employee_id, :skill_hobby)"
                    );
                    $stmt->execute([
                        'employee_id' => $employeeId,
                        'skill_hobby' => $skillHobby
                    ]);
                }
            }
            
            // Insert recognition if provided
            if (!empty($recognition)) {
                if (!empty($data['other_info_id'])) {
                    $stmt = $this->conn->prepare(
                        "UPDATE other_information_recognition 
                        SET recognition = :recognition 
                        WHERE id = :id"
                    );
                    $stmt->execute([
                        'recognition' => $recognition,
                        'id' => $data['other_info_id']
                    ]);
                } else {
                    $stmt = $this->conn->prepare(
                        "INSERT INTO other_information_recognition (employee_id, recognition) 
                        VALUES (:employee_id, :recognition)"
                    );
                    $stmt->execute([
                        'employee_id' => $employeeId,
                        'recognition' => $recognition
                    ]);
                }
            }
            
            // Insert membership if provided
            if (!empty($membership)) {
                if (!empty($data['other_info_id'])) {
                    $stmt = $this->conn->prepare(
                        "UPDATE other_information_membership 
                        SET membership = :membership 
                        WHERE id = :id"
                    );
                    $stmt->execute([
                        'membership' => $membership,
                        'id' => $data['other_info_id']
                    ]);
                } else {
                    $stmt = $this->conn->prepare(
                        "INSERT INTO other_information_membership (employee_id, membership) 
                        VALUES (:employee_id, :membership)"
                    );
                    $stmt->execute([
                        'employee_id' => $employeeId,
                        'membership' => $membership
                    ]);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            error_log("Upsert other information failed: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete Other Information by type
     */
    public function deleteOtherInformation(int $id, string $type): bool
    {
        try {
            $table = match($type) {
                'skill' => 'other_information_skills',
                'recognition' => 'other_information_recognition',
                'membership' => 'other_information_membership',
                default => throw new \InvalidArgumentException("Invalid type: $type")
            };
            
            $stmt = $this->conn->prepare("DELETE FROM {$table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\Exception $e) {
            error_log("Delete other information failed: " . $e->getMessage());
            return false;
        }
    }

    protected function upsertSingleTable(string $table, string $employeeId, array $data): bool
    {
        $data['employee_id'] = $employeeId;

        // Normalize empty strings to NULL
        foreach ($data as $k => $v) {
            if ($v === '') {
                $data[$k] = null;
            }
        }

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$table} WHERE employee_id = ?");
        $stmt->execute([$employeeId]);
        $exists = (int)$stmt->fetchColumn() > 0;

        if ($exists) {
            $updateData = $data;
            unset($updateData['employee_id']);

            if (empty($updateData)) {
                return true;
            }

            $setStr = implode(', ', array_map(fn($c) => "`$c` = :$c", array_keys($updateData)));
            $sql = "UPDATE {$table} SET {$setStr} WHERE employee_id = :employee_id";
            $stmt = $this->conn->prepare($sql);

            foreach ($updateData as $k => $v) {
                $stmt->bindValue(":$k", $v);
            }

            $stmt->bindValue(':employee_id', $employeeId);

            return $stmt->execute();
        }

        $cols = implode(', ', array_map(fn($c) => "`$c`", array_keys($data)));
        $place = implode(', ', array_map(fn($c) => ":$c", array_keys($data)));

        $sql = "INSERT INTO {$table} ({$cols}) VALUES ({$place})";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($data);
    }
}