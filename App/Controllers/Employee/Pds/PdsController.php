<?php

namespace App\Controllers\Employee\Pds;

use App\Core\EmployeeBaseController;
use App\Helpers\Auth;
use App\Models\Employee\Pds\Pds;

class PdsController extends EmployeeBaseController
{
    protected Pds $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Pds();
    }

    /* ─────────────────────────────────────────────────────────────────
       EMPLOYEE DATA  →  cell map consumed by pds_renderer.js
       Key:   "SheetName:CellAddr"  where CellAddr is the TOP-LEFT
              cell of a merged region (or the plain cell address).
              The renderer splits on the FIRST colon only, so
              "C1:D10" → sheet="C1", addr="D10"  ✓
    ───────────────────────────────────────────────────────────────── */
    public function employeeData(): void
    {
        $employeeId = Auth::id();
        $data       = $this->model->getAllPdsData($employeeId);
        $cells      = [];

        /* ══════════════════════════════════════════════════════════════
           C1  ·  Personal Information / Family Background / Education
           Print area: A1:N61
        ══════════════════════════════════════════════════════════════ */
        if (!empty($data['personal'])) {
            $p = $data['personal'];

            // ── Section I: Personal Information ──────────────────────

            // 1. Surname          → merged D10:N10   TL = D10
            $cells['C1:D10'] = ['v' => strtoupper($p['surname'] ?? '')];

            // 2. First Name       → unmerged D11..K11 (individual cells, write to D11)
            $cells['C1:D11'] = ['v' => strtoupper($p['first_name'] ?? '')];

            //    Name Extension   → L11:N11 label cell also serves as input (write to TL = L11)
            $cells['C1:L11'] = ['v' => strtoupper($p['name_extension'] ?? '')];

            //    Middle Name      → unmerged D12..N12, write to D12
            $cells['C1:D12'] = ['v' => strtoupper($p['middle_name'] ?? '')];

            // 3. Date of Birth   → merged D13:F13   TL = D13
            if (!empty($p['date_of_birth'])) {
                $cells['C1:D13'] = ['v' => date('d/m/Y', strtotime($p['date_of_birth']))];
            }

            // 4. Place of Birth  → merged D15:F15   TL = D15
            $cells['C1:D15'] = ['v' => $p['place_of_birth'] ?? ''];

            // 5. Sex at Birth    → merged D16:F16   TL = D16
            $cells['C1:D16'] = ['v' => $p['sex'] ?? ''];

            // 6. Civil Status    → merged D17:F18   TL = D17
            $cells['C1:D17'] = ['v' => $p['civil_status'] ?? ''];

            // 16. Citizenship    → merged J13:N13   TL = J13
            $cells['C1:J13'] = ['v' => $p['citizenship_type'] ?? ''];

            // 7. Height          → merged D22:F23   TL = D22
            $cells['C1:D22'] = ['v' => (string)($p['height'] ?? '')];

            // 8. Weight          → merged D24:F24   TL = D24
            $cells['C1:D24'] = ['v' => (string)($p['weight'] ?? '')];

            // 9. Blood Type      → merged D25:F26   TL = D25
            $cells['C1:D25'] = ['v' => $p['blood_type'] ?? ''];

            // 10. GSIS ID        → merged D27:F28   TL = D27
            $cells['C1:D27'] = ['v' => $p['gsis_id_no'] ?? ''];

            // 11. Pag-IBIG       → merged D29:F30   TL = D29
            $cells['C1:D29'] = ['v' => $p['pagibig_id_no'] ?? ''];

            // 12. PhilHealth     → merged D31:F31   TL = D31
            $cells['C1:D31'] = ['v' => $p['philhealth_no'] ?? ''];

            // 13. SSS/PhilSys    → merged D32:F32   TL = D32
            $cells['C1:D32'] = ['v' => $p['sss_no'] ?? ''];

            // 14. TIN            → merged D33:F33   TL = D33
            $cells['C1:D33'] = ['v' => $p['tin_no'] ?? ''];

            // 15. Agency Emp No  → merged D34:F34   TL = D34
            $cells['C1:D34'] = ['v' => $p['agency_employee_no'] ?? ''];

            // ── 17. Residential Address ──────────────────────────────
            $cells['C1:I17'] = ['v' => $p['res_house_block_lot'] ?? ''];   // merged I17:K17
            $cells['C1:L17'] = ['v' => $p['res_street'] ?? ''];            // merged L17:N17
            $cells['C1:I19'] = ['v' => $p['res_subdivision'] ?? ''];       // merged I19:K20
            $cells['C1:L19'] = ['v' => $p['res_barangay'] ?? ''];          // merged L19:N20
            $cells['C1:I22'] = ['v' => $p['res_city_municipality'] ?? '']; // merged I22:K22
            $cells['C1:L22'] = ['v' => $p['res_province'] ?? ''];          // merged L22:N22
            $cells['C1:I24'] = ['v' => $p['res_zip_code'] ?? ''];          // merged I24:N24

            // ── 18. Permanent Address ────────────────────────────────
            $cells['C1:I25'] = ['v' => $p['perm_house_block_lot'] ?? ''];   // merged I25:K25
            $cells['C1:L25'] = ['v' => $p['perm_street'] ?? ''];            // merged L25:N25
            $cells['C1:I27'] = ['v' => $p['perm_subdivision'] ?? ''];       // merged I27:K27
            $cells['C1:L27'] = ['v' => $p['perm_barangay'] ?? ''];          // merged L27:N27
            $cells['C1:I30'] = ['v' => $p['perm_city_municipality'] ?? '']; // merged I30:K30
            $cells['C1:L30'] = ['v' => $p['perm_province'] ?? ''];          // merged L30:N30
            $cells['C1:I31'] = ['v' => $p['perm_zip_code'] ?? ''];          // merged I31:K31

            // 19-21. Contact
            $cells['C1:I32'] = ['v' => $p['telephone_no'] ?? ''];   // merged I32:N32
            $cells['C1:I33'] = ['v' => $p['mobile_no'] ?? ''];      // merged I33:N33
            $cells['C1:I34'] = ['v' => $p['email_address'] ?? ''];  // merged I34:N34
        }

        // ── Section II: Family Background ────────────────────────────
        if (!empty($data['family']['family'])) {
            $f = $data['family']['family'];

            // 22. Spouse
            $cells['C1:D36'] = ['v' => strtoupper($f['spouse_surname'] ?? '')];       // merged D36:H36
            $cells['C1:D37'] = ['v' => strtoupper($f['spouse_first_name'] ?? '')];    // merged D37:F37
            $cells['C1:I37'] = ['v' => strtoupper($f['spouse_name_extension'] ?? '')];// merged I37:L37
            $cells['C1:D38'] = ['v' => strtoupper($f['spouse_middle_name'] ?? '')];   // merged D38:H38
            $cells['C1:D39'] = ['v' => $f['spouse_occupation'] ?? ''];                // merged D39:H39
            $cells['C1:D40'] = ['v' => $f['spouse_employer_name'] ?? ''];             // merged D40:H40
            $cells['C1:D41'] = ['v' => $f['spouse_business_address'] ?? ''];          // merged D41:H41
            $cells['C1:D42'] = ['v' => $f['spouse_telephone_no'] ?? ''];              // merged D42:H42

            // 24. Father
            $cells['C1:D43'] = ['v' => strtoupper($f['father_surname'] ?? '')];       // merged D43:H43
            $cells['C1:D44'] = ['v' => strtoupper($f['father_first_name'] ?? '')];    // merged D44:F44
            $cells['C1:I44'] = ['v' => strtoupper($f['father_name_extension'] ?? '')];// merged I44:L44
            $cells['C1:D45'] = ['v' => strtoupper($f['father_middle_name'] ?? '')];   // merged D45:H45

            // 25. Mother
            $cells['C1:D46'] = ['v' => strtoupper($f['mother_maiden_name'] ?? '')];   // first col after B46:H46 label
            $cells['C1:D47'] = ['v' => strtoupper($f['mother_surname'] ?? '')];       // merged D47:H47
            $cells['C1:D48'] = ['v' => strtoupper($f['mother_first_name'] ?? '')];    // merged D48:H48
            $cells['C1:D49'] = ['v' => strtoupper($f['mother_middle_name'] ?? '')];   // merged D49:H49
        }

        // 23. Children (name rows I37-I48, birthdate cols M37-M48)
        if (!empty($data['family']['children'])) {
            $childRows = [37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];
            foreach ($data['family']['children'] as $i => $child) {
                if (!isset($childRows[$i])) break;
                $r = $childRows[$i];
                $cells["C1:I{$r}"] = ['v' => strtoupper($child['child_name'] ?? '')];
                if (!empty($child['child_birthdate'])) {
                    $cells["C1:M{$r}"] = ['v' => date('d/m/Y', strtotime($child['child_birthdate']))];
                }
            }
        }

        // ── Section III: Educational Background ──────────────────────
        if (!empty($data['education']['education'])) {
            $e = $data['education']['education'];

            // Elementary  row 54:  D54=school(merged D:F), G54=course(merged G:I), M54=yr, N54=honors
            $cells['C1:D54'] = ['v' => $e['elementary_school_name'] ?? ''];
            $cells['C1:M54'] = ['v' => (string)($e['elementary_year_graduated'] ?? '')];
            $cells['C1:N54'] = ['v' => $e['elementary_honor'] ?? ''];

            // Secondary   row 55
            $cells['C1:D55'] = ['v' => $e['secondary_school_name'] ?? ''];
            $cells['C1:M55'] = ['v' => (string)($e['secondary_year_graduated'] ?? '')];
            $cells['C1:N55'] = ['v' => $e['secondary_honor'] ?? ''];

            // Vocational  row 56
            $cells['C1:D56'] = ['v' => $e['vocational_course'] ?? ''];
            $cells['C1:M56'] = ['v' => (string)($e['vocational_year_completed'] ?? '')];
            $cells['C1:N56'] = ['v' => $e['vocational_honor'] ?? ''];

            // College     row 57
            $cells['C1:G57'] = ['v' => $e['college_course'] ?? ''];
            $cells['C1:L57'] = ['v' => $e['college_units_earned'] ?? ''];
            $cells['C1:M57'] = ['v' => (string)($e['college_year_graduated'] ?? '')];
            $cells['C1:N57'] = ['v' => $e['college_honor'] ?? ''];
        }

        // Graduate Studies row 58 (first record)
        if (!empty($data['education']['graduate'][0])) {
            $gs = $data['education']['graduate'][0];
            $cells['C1:D58'] = ['v' => $gs['institution_name'] ?? ''];   // merged D58:F58
            $cells['C1:G58'] = ['v' => $gs['graduate_course'] ?? ''];    // merged G58:I58
            $cells['C1:L58'] = ['v' => $gs['units_earned'] ?? ''];
            $cells['C1:M58'] = ['v' => (string)($gs['year_graduated'] ?? '')];
            $cells['C1:N58'] = ['v' => $gs['honor_received'] ?? ''];
        }

        /* ══════════════════════════════════════════════════════════════
           C2  ·  Civil Service Eligibility  &  Work Experience
           Print area: A2:K48

           Eligibility per row (verified merges):
             A{r}:E{r} = career service   TL = A{r}
             G{r}:H{r} = rating           TL = G{r}
             I{r}      = date (single after G:H merge)
             J{r}      = place (single)

           Work Experience per row 18-45 (verified merges):
             A{r}:B{r} = date from    TL = A{r}
             C{r}      = date to      (single)
             D{r}:F{r} = position     TL = D{r}
             G{r}:I{r} = dept/company TL = G{r}
             J{r}      = status       (single)
             K{r}      = govt service (single)
        ══════════════════════════════════════════════════════════════ */

        // ── Section IV: Civil Service Eligibility ────────────────────
        if (!empty($data['professional']['eligibility'])) {
            $eligRows = [5, 6, 7, 8, 9, 10, 11];
            foreach ($data['professional']['eligibility'] as $i => $elig) {
                if (!isset($eligRows[$i])) break;
                $r = $eligRows[$i];

                $cells["C2:A{$r}"] = ['v' => $elig['career_service'] ?? ''];    // A{r}:E{r}
                $cells["C2:G{$r}"] = ['v' => $elig['rating'] ?? ''];            // G{r}:H{r}

                if (!empty($elig['date_of_examination_conferment'])) {
                    $cells["C2:I{$r}"] = [
                        'v' => date('m/d/Y', strtotime($elig['date_of_examination_conferment']))
                    ];
                }
                $cells["C2:J{$r}"] = ['v' => $elig['place_of_examination_conferment'] ?? ''];
            }
        }

        // ── Section V: Work Experience ────────────────────────────────
        if (!empty($data['professional']['work'])) {
            $workRows = range(18, 45);
            foreach ($data['professional']['work'] as $i => $work) {
                if (!isset($workRows[$i])) break;
                $r = $workRows[$i];

                $dateFrom = !empty($work['work_date_from'])
                    ? date('m/d/Y', strtotime($work['work_date_from'])) : '';
                $dateTo   = !empty($work['work_date_to'])
                    ? date('m/d/Y', strtotime($work['work_date_to'])) : 'Present';

                $cells["C2:A{$r}"] = ['v' => $dateFrom];                         // A{r}:B{r}
                $cells["C2:C{$r}"] = ['v' => $dateTo];                           // single
                $cells["C2:D{$r}"] = ['v' => $work['work_position'] ?? ''];      // D{r}:F{r}
                $cells["C2:G{$r}"] = ['v' => $work['work_company'] ?? ''];       // G{r}:I{r}
                $cells["C2:J{$r}"] = ['v' => $work['work_status'] ?? ''];        // single
                $cells["C2:K{$r}"] = ['v' => $work['work_govt_service'] ?? ''];  // single
            }
        }

        /* ══════════════════════════════════════════════════════════════
           C3  ·  Voluntary Work  /  L&D Programs  /  Other Info
           Print area: A1:K51

           Voluntary Work rows 6-12 (verified merges):
             A{r}:D{r} = org name+address  TL = A{r}
             E{r}      = date from  (single)
             F{r}      = date to    (single)
             G{r}      = hours      (single)
             H{r}:K{r} = position   TL = H{r}

           L&D rows 18-38 (same pattern):
             A{r}:D{r} = title      TL = A{r}
             E{r}      = date from
             F{r}      = date to
             G{r}      = hours
             H{r}      = type
             I{r}:K{r} = sponsor    TL = I{r}

           Other Info rows 42-48:
             A{r}:B{r} = skills     TL = A{r}
             C{r}:H{r} = recognition TL = C{r}
             I{r}:K{r} = membership TL = I{r}
        ══════════════════════════════════════════════════════════════ */

        // ── Section VI: Voluntary Work ────────────────────────────────
        if (!empty($data['professional']['voluntary'])) {
            $volRows = [6, 7, 8, 9, 10, 11, 12];
            foreach ($data['professional']['voluntary'] as $i => $vol) {
                if (!isset($volRows[$i])) break;
                $r = $volRows[$i];

                $orgFull = trim(
                    ($vol['organization_name'] ?? '') . ' ' .
                    ($vol['organization_address'] ?? '')
                );
                $cells["C3:A{$r}"] = ['v' => $orgFull];                                  // A{r}:D{r}

                if (!empty($vol['start_date'])) {
                    $cells["C3:E{$r}"] = ['v' => date('m/d/Y', strtotime($vol['start_date']))];
                }
                if (!empty($vol['end_date'])) {
                    $cells["C3:F{$r}"] = ['v' => date('m/d/Y', strtotime($vol['end_date']))];
                }

                $cells["C3:G{$r}"] = ['v' => (string)($vol['number_of_hours'] ?? '')];
                $cells["C3:H{$r}"] = ['v' => $vol['position_role'] ?? ''];               // H{r}:K{r}
            }
        }

        // ── Section VII: L&D Programs ─────────────────────────────────
        if (!empty($data['professional']['ld'])) {
            $ldRows = range(18, 38);
            foreach ($data['professional']['ld'] as $i => $ld) {
                if (!isset($ldRows[$i])) break;
                $r = $ldRows[$i];

                $cells["C3:A{$r}"] = ['v' => $ld['ld_title'] ?? ''];                   // A{r}:D{r}

                if (!empty($ld['ld_date_from'])) {
                    $cells["C3:E{$r}"] = ['v' => date('m/d/Y', strtotime($ld['ld_date_from']))];
                }
                if (!empty($ld['ld_date_to'])) {
                    $cells["C3:F{$r}"] = ['v' => date('m/d/Y', strtotime($ld['ld_date_to']))];
                }

                $cells["C3:G{$r}"] = ['v' => (string)($ld['ld_hours'] ?? '')];
                $cells["C3:H{$r}"] = ['v' => $ld['ld_type'] ?? ''];
                $cells["C3:I{$r}"] = ['v' => $ld['ld_sponsor'] ?? ''];                 // I{r}:K{r}
            }
        }

        // ── Section VIII: Other Information ──────────────────────────
        $otherRows = [42, 43, 44, 45, 46, 47, 48];

        foreach (($data['other']['skills'] ?? []) as $i => $skill) {
            if (!isset($otherRows[$i])) break;
            $cells["C3:A{$otherRows[$i]}"] = ['v' => $skill['skill_hobby'] ?? ''];    // A:B
        }

        foreach (($data['other']['recognition'] ?? []) as $i => $rec) {
            if (!isset($otherRows[$i])) break;
            $cells["C3:C{$otherRows[$i]}"] = ['v' => $rec['recognition'] ?? ''];     // C:H
        }

        foreach (($data['other']['membership'] ?? []) as $i => $mem) {
            if (!isset($otherRows[$i])) break;
            $cells["C3:I{$otherRows[$i]}"] = ['v' => $mem['membership'] ?? ''];      // I:K
        }

        /* ══════════════════════════════════════════════════════════════
           C4  ·  Declarations  /  References  /  Government ID
           Print area: A1:M71

           YES/NO cells (verified from XLSX merge analysis):
             q34a  → I2:J2    TL = I2
             q34b  → I3:J3    TL = I3
             q35a  → I11:L11  TL = I11
             q35b  → I12:L12  TL = I12
             date  → J20 (single)
             status→ I22:K22  TL = I22
             q36   → I15:L15  TL = I15
             q37   → I25:L25  TL = I25
             q38a  → I29:L29  TL = I29
             q38b  → I34:L34  TL = I34
             q39   → I39:L39  TL = I39
             q40a  → I40:L40  TL = I40
             q40b  → K35:L35  TL = K35
             q40c  → K32:L32  TL = K32

           References:
             ref1 name    → A52:E52  TL = A52
             ref1 address → G52:I52  TL = G52
             ref1 tel     → J52
             ref2 name    → A53:E53  TL = A53
             ref2 address → G53:I53  TL = G53
             ref2 tel     → J53

           Gov ID:
             type     → D62 (merged D62:D63)
             number   → D64 (merged D64:D65)
             date/pl  → A54 (merged A54:E54)
        ══════════════════════════════════════════════════════════════ */
        if (!empty($data['other']['c4'])) {
            $c4 = $data['other']['c4'];
            $yn = static fn($v) => strtoupper(trim((string)($v ?? '')));

            $cells['C4:I2']  = ['v' => $yn($c4['q34a'])];   // related 3rd degree?
            $cells['C4:I3']  = ['v' => $yn($c4['q34b'])];   // related 4th degree?

            $cells['C4:I11'] = ['v' => $yn($c4['q35a'])];   // found guilty?
            $cells['C4:I12'] = ['v' => $yn($c4['q35b'])];   // criminally charged?

            if (!empty($c4['q35b_datefiled'])) {
                $cells['C4:J20'] = ['v' => date('m/d/Y', strtotime($c4['q35b_datefiled']))];
            }
            $cells['C4:I22'] = ['v' => $c4['q35b_status'] ?? ''];   // status of case

            $cells['C4:I15'] = ['v' => $yn($c4['q36'])];   // convicted?
            $cells['C4:I25'] = ['v' => $yn($c4['q37'])];   // separated from service?
            $cells['C4:I29'] = ['v' => $yn($c4['q38a'])];  // candidate in election?
            $cells['C4:I34'] = ['v' => $yn($c4['q38b'])];  // resigned from govt?
            $cells['C4:I39'] = ['v' => $yn($c4['q39'])];   // immigrant?
            $cells['C4:I40'] = ['v' => $yn($c4['q40a'])];  // indigenous people?
            $cells['C4:K35'] = ['v' => $yn($c4['q40b'])];  // person with disability?
            $cells['C4:K32'] = ['v' => $yn($c4['q40c'])];  // solo parent?

            // References
            $cells['C4:A52'] = ['v' => $c4['ref_name1'] ?? ''];
            $cells['C4:G52'] = ['v' => $c4['ref_address1'] ?? ''];
            $cells['C4:J52'] = ['v' => $c4['ref_tel1'] ?? ''];

            $cells['C4:A53'] = ['v' => $c4['ref_name2'] ?? ''];
            $cells['C4:G53'] = ['v' => $c4['ref_address2'] ?? ''];
            $cells['C4:J53'] = ['v' => $c4['ref_tel2'] ?? ''];

            // Government Issued ID
            $cells['C4:D62'] = ['v' => $c4['gov_id'] ?? ''];
            $cells['C4:D64'] = ['v' => $c4['gov_id_no'] ?? ''];
            $cells['C4:A54'] = ['v' => $c4['gov_id_issue'] ?? ''];
        }

        json_response([
            'success' => true,
            'cells'   => $cells,
        ]);
    }

    /* ─────────────────────────────────────────────────────────────────
       INDEX  —  render the PDS preview page
    ───────────────────────────────────────────────────────────────── */
    public function index(): void
    {
        $employeeId = Auth::id();
        $pdsData    = $this->model->getAllPdsData($employeeId);

        $this->view('Employee/Pds/Preview', [
            'pds'        => $pdsData,
            'employeeId' => $employeeId,
        ]);
    }

    /* ─────────────────────────────────────────────────────────────────
       GET  —  full raw data with CSRF
    ───────────────────────────────────────────────────────────────── */
    public function get(): void
    {
        if (!csrf_verify($_GET['_csrf_token'] ?? null)) {
            json_response([
                'success'    => false,
                'message'    => 'CSRF token mismatch.',
                'csrf_token' => csrf_token(),
            ]);
            return;
        }

        $employeeId = Auth::id();
        $data       = $this->model->getAllPdsData($employeeId);

        json_response([
            'success'    => true,
            'data'       => $data,
            'csrf_token' => csrf_token(),
        ]);
    }
}