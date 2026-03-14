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
       Key format: "SheetName:CellAddr"  (split on FIRST colon)
       
       ALL addresses verified by extracting merged cell ranges directly
       from PDS-Form-212-2025.xlsx using openpyxl.
    ───────────────────────────────────────────────────────────────── */
    public function employeeData(): void
    {
        $employeeId = Auth::id();
        $data = $this->model->getAllPdsData($employeeId);
        $cells = [];

        /* ══════════════════════════════════════════════════════════════
           C1  ·  Personal Information / Family Background / Education
        ══════════════════════════════════════════════════════════════ */
        if (!empty($data['personal'])) {
            $p = $data['personal'];

            // 1. Surname          → D10:N10
            $cells['C1:D10'] = ['v' => strtoupper($p['surname'] ?? '')];
            // 2. First Name       → D11 (individual cells)
            $cells['C1:D11'] = ['v' => strtoupper($p['first_name'] ?? '')];
            //    Name Extension   → L11:N11
            $cells['C1:L11'] = ['v' => strtoupper($p['name_extension'] ?? '')];
            //    Middle Name      → D12
            $cells['C1:D12'] = ['v' => strtoupper($p['middle_name'] ?? '')];
            // 3. Date of Birth    → D13:F13
            if (!empty($p['date_of_birth'])) {
                $cells['C1:D13'] = ['v' => date('d/m/Y', strtotime($p['date_of_birth']))];
            }
            // 4. Place of Birth   → D15:F15
            $cells['C1:D15'] = ['v' => $p['place_of_birth'] ?? ''];
            // 5. Sex at Birth     → D16:F16
            $cells['C1:D16'] = ['v' => $p['sex'] ?? ''];
            // 6. Civil Status     → D17:F18
            $cells['C1:D17'] = ['v' => $p['civil_status'] ?? ''];
            // 16. Citizenship     → J13:N13
            $cells['C1:J13'] = ['v' => $p['citizenship_type'] ?? ''];
            // 7. Height           → D22:F23
            $cells['C1:D22'] = ['v' => (string) ($p['height'] ?? '')];
            // 8. Weight           → D24:F24
            $cells['C1:D24'] = ['v' => (string) ($p['weight'] ?? '')];
            // 9. Blood Type       → D25:F26
            $cells['C1:D25'] = ['v' => $p['blood_type'] ?? ''];
            // 10. GSIS/UMID       → D27:F28
            $cells['C1:D27'] = ['v' => $p['gsis_id_no'] ?? ''];
            // 11. Pag-IBIG        → D29:F30
            $cells['C1:D29'] = ['v' => $p['pagibig_id_no'] ?? ''];
            // 12. PhilHealth      → D31:F31
            $cells['C1:D31'] = ['v' => $p['philhealth_no'] ?? ''];
            // 13. PhilSys (PSN)   → D32:F32
            $cells['C1:D32'] = ['v' => $p['sss_no'] ?? ''];
            // 14. TIN             → D33:F33
            $cells['C1:D33'] = ['v' => $p['tin_no'] ?? ''];
            // 15. Agency Emp No   → D34:F34
            $cells['C1:D34'] = ['v' => $p['agency_employee_no'] ?? ''];

            // 17. Residential Address
            $cells['C1:I17'] = ['v' => $p['res_house_block_lot'] ?? ''];   // I17:K17
            $cells['C1:L17'] = ['v' => $p['res_street'] ?? ''];            // L17:N17
            $cells['C1:I19'] = ['v' => $p['res_subdivision'] ?? ''];       // I19:K20
            $cells['C1:L19'] = ['v' => $p['res_barangay'] ?? ''];          // L19:N20
            $cells['C1:I22'] = ['v' => $p['res_city_municipality'] ?? '']; // I22:K22
            $cells['C1:L22'] = ['v' => $p['res_province'] ?? ''];          // L22:N22
            $cells['C1:I24'] = ['v' => $p['res_zip_code'] ?? ''];          // I24:N24

            // 18. Permanent Address
            $cells['C1:I25'] = ['v' => $p['perm_house_block_lot'] ?? ''];   // I25:K25
            $cells['C1:L25'] = ['v' => $p['perm_street'] ?? ''];            // L25:N25
            $cells['C1:I27'] = ['v' => $p['perm_subdivision'] ?? ''];       // I27:K27
            $cells['C1:L27'] = ['v' => $p['perm_barangay'] ?? ''];          // L27:N27
            $cells['C1:I30'] = ['v' => $p['perm_city_municipality'] ?? '']; // I30:K30
            $cells['C1:L30'] = ['v' => $p['perm_province'] ?? ''];          // L30:N30
            $cells['C1:I31'] = ['v' => $p['perm_zip_code'] ?? ''];          // I31:K31

            // 19-21. Contact
            $cells['C1:I32'] = ['v' => $p['telephone_no'] ?? ''];   // I32:N32
            $cells['C1:I33'] = ['v' => $p['mobile_no'] ?? ''];      // I33:N33
            $cells['C1:I34'] = ['v' => $p['email_address'] ?? ''];  // I34:N34
        }

        // ── Section II: Family Background ────────────────────────────
        if (!empty($data['family']['family'])) {
            $f = $data['family']['family'];

            $cells['C1:D36'] = ['v' => strtoupper($f['spouse_surname'] ?? '')];        // D36:H36
            $cells['C1:D37'] = ['v' => strtoupper($f['spouse_first_name'] ?? '')];     // D37:F37
            $cells['C1:I37'] = ['v' => strtoupper($f['spouse_name_extension'] ?? '')]; // I37:L37
            $cells['C1:D38'] = ['v' => strtoupper($f['spouse_middle_name'] ?? '')];    // D38:H38
            $cells['C1:D39'] = ['v' => $f['spouse_occupation'] ?? ''];                 // D39:H39
            $cells['C1:D40'] = ['v' => $f['spouse_employer_name'] ?? ''];              // D40:H40
            $cells['C1:D41'] = ['v' => $f['spouse_business_address'] ?? ''];           // D41:H41
            $cells['C1:D42'] = ['v' => $f['spouse_telephone_no'] ?? ''];               // D42:H42

            $cells['C1:D43'] = ['v' => strtoupper($f['father_surname'] ?? '')];        // D43:H43
            $cells['C1:D44'] = ['v' => strtoupper($f['father_first_name'] ?? '')];     // D44:F44
            $cells['C1:I44'] = ['v' => strtoupper($f['father_name_extension'] ?? '')]; // I44:L44
            $cells['C1:D45'] = ['v' => strtoupper($f['father_middle_name'] ?? '')];    // D45:H45

            $cells['C1:D47'] = ['v' => strtoupper($f['mother_surname'] ?? '')];        // D47:H47
            $cells['C1:D48'] = ['v' => strtoupper($f['mother_first_name'] ?? '')];     // D48:H48
            $cells['C1:D49'] = ['v' => strtoupper($f['mother_middle_name'] ?? '')];    // D49:H49
        }

        // 23. Children — name I{r}:L{r}, DOB M{r}:N{r}, rows 36-48
        if (!empty($data['family']['children'])) {
            $childRows = [36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];
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
        // D{r}:F{r}=School  G{r}:I{r}=Course  J{r}=From  K{r}=To
        // L{r}=Units  M{r}=YrGrad  N{r}=Honors
        if (!empty($data['education']['education'])) {
            $e = $data['education']['education'];

            // Elementary  row 54
            $cells['C1:D54'] = ['v' => $e['elementary_school_name'] ?? ''];
            $cells['C1:G54'] = ['v' => $e['elementary_course'] ?? ''];
            $cells['C1:J54'] = ['v' => (string) ($e['elementary_from'] ?? '')];
            $cells['C1:K54'] = ['v' => (string) ($e['elementary_to'] ?? '')];
            $cells['C1:L54'] = ['v' => $e['elementary_units_earned'] ?? ''];
            $cells['C1:M54'] = ['v' => (string) ($e['elementary_year_graduated'] ?? '')];
            $cells['C1:N54'] = ['v' => $e['elementary_honor'] ?? ''];

            // Secondary   row 55
            $cells['C1:D55'] = ['v' => $e['secondary_school_name'] ?? ''];
            $cells['C1:G55'] = ['v' => $e['secondary_course'] ?? ''];
            $cells['C1:J55'] = ['v' => (string) ($e['secondary_from'] ?? '')];
            $cells['C1:K55'] = ['v' => (string) ($e['secondary_to'] ?? '')];
            $cells['C1:L55'] = ['v' => $e['secondary_units_earned'] ?? ''];
            $cells['C1:M55'] = ['v' => (string) ($e['secondary_year_graduated'] ?? '')];
            $cells['C1:N55'] = ['v' => $e['secondary_honor'] ?? ''];

            // Vocational  row 56
            $cells['C1:D56'] = ['v' => $e['vocational_school_name'] ?? ''];
            $cells['C1:G56'] = ['v' => $e['vocational_course'] ?? ''];
            $cells['C1:J56'] = ['v' => (string) ($e['vocational_from'] ?? '')];
            $cells['C1:K56'] = ['v' => (string) ($e['vocational_to'] ?? '')];
            $cells['C1:L56'] = ['v' => $e['vocational_units_earned'] ?? ''];
            $cells['C1:M56'] = ['v' => (string) ($e['vocational_year_completed'] ?? '')];
            $cells['C1:N56'] = ['v' => $e['vocational_honor'] ?? ''];

            // College     row 57
            $cells['C1:D57'] = ['v' => $e['college_school_name'] ?? ''];
            $cells['C1:G57'] = ['v' => $e['college_course'] ?? ''];
            $cells['C1:J57'] = ['v' => (string) ($e['college_from'] ?? '')];
            $cells['C1:K57'] = ['v' => (string) ($e['college_to'] ?? '')];
            $cells['C1:L57'] = ['v' => $e['college_units_earned'] ?? ''];
            $cells['C1:M57'] = ['v' => (string) ($e['college_year_graduated'] ?? '')];
            $cells['C1:N57'] = ['v' => $e['college_honor'] ?? ''];
        }

        // Graduate Studies row 58
        if (!empty($data['education']['graduate'][0])) {
            $gs = $data['education']['graduate'][0];
            $cells['C1:D58'] = ['v' => $gs['institution_name'] ?? ''];
            $cells['C1:G58'] = ['v' => $gs['graduate_course'] ?? ''];
            $cells['C1:J58'] = ['v' => (string) ($gs['graduate_from'] ?? '')];
            $cells['C1:K58'] = ['v' => (string) ($gs['graduate_to'] ?? '')];
            $cells['C1:L58'] = ['v' => $gs['units_earned'] ?? ''];
            $cells['C1:M58'] = ['v' => (string) ($gs['year_graduated'] ?? '')];
            $cells['C1:N58'] = ['v' => $gs['honor_received'] ?? ''];
        }

        /* ══════════════════════════════════════════════════════════════
           C2  ·  Civil Service Eligibility & Work Experience
           
           Eligibility rows 5–11:
             A{r}:E{r} = career service   F{r} = rating
             G{r}:H{r} = date             I{r} = place
             J{r} = license no            K{r} = valid until

           Work Experience rows 18–45:
             A{r}:B{r} = from   C{r} = to
             D{r}:F{r} = position title
             G{r}:I{r} = dept/company
             J{r} = status   K{r} = govt Y/N
        ══════════════════════════════════════════════════════════════ */

        if (!empty($data['professional']['eligibility'])) {
            $eligRows = [5, 6, 7, 8, 9, 10, 11];
            foreach ($data['professional']['eligibility'] as $i => $elig) {
                if (!isset($eligRows[$i])) break;
                $r = $eligRows[$i];
                $cells["C2:A{$r}"] = ['v' => $elig['career_service'] ?? ''];
                $cells["C2:F{$r}"] = ['v' => $elig['rating'] ?? ''];
                if (!empty($elig['date_of_examination_conferment'])) {
                    $cells["C2:G{$r}"] = ['v' => date('m/d/Y', strtotime($elig['date_of_examination_conferment']))];
                }
                $cells["C2:I{$r}"] = ['v' => $elig['place_of_examination_conferment'] ?? ''];
                $cells["C2:J{$r}"] = ['v' => $elig['license_number'] ?? ''];
                $cells["C2:K{$r}"] = ['v' => $elig['license_valid_until'] ?? ''];
            }
        }

        if (!empty($data['professional']['work'])) {
            $workRows = range(18, 45);
            foreach ($data['professional']['work'] as $i => $work) {
                if (!isset($workRows[$i])) break;
                $r = $workRows[$i];
                $cells["C2:A{$r}"] = ['v' => !empty($work['work_date_from']) ? date('m/d/Y', strtotime($work['work_date_from'])) : ''];
                $cells["C2:C{$r}"] = ['v' => !empty($work['work_date_to']) ? date('m/d/Y', strtotime($work['work_date_to'])) : 'Present'];
                $cells["C2:D{$r}"] = ['v' => $work['work_position'] ?? ''];
                $cells["C2:G{$r}"] = ['v' => $work['work_company'] ?? ''];
                $cells["C2:J{$r}"] = ['v' => $work['work_status'] ?? ''];
                $cells["C2:K{$r}"] = ['v' => $work['work_govt_service'] ?? ''];
            }
        }

        /* ══════════════════════════════════════════════════════════════
           C3  ·  Voluntary Work / L&D / Other Info
           
           Voluntary rows 6–12:
             A{r}:D{r}=org  E{r}=from  F{r}=to  G{r}=hrs  H{r}:K{r}=position

           L&D rows 18–28, 35–38:
             A{r}:D{r}=title  E{r}=from  F{r}=to  G{r}=hrs  H{r}=type  I{r}:K{r}=sponsor

           Other rows 42–48:
             A{r}:B{r}=skill  C{r}:H{r}=recognition  I{r}:K{r}=membership
        ══════════════════════════════════════════════════════════════ */

        if (!empty($data['professional']['voluntary'])) {
            $volRows = [6, 7, 8, 9, 10, 11, 12];
            foreach ($data['professional']['voluntary'] as $i => $vol) {
                if (!isset($volRows[$i])) break;
                $r = $volRows[$i];
                $cells["C3:A{$r}"] = ['v' => trim(($vol['organization_name'] ?? '') . ' ' . ($vol['organization_address'] ?? ''))];
                if (!empty($vol['start_date'])) $cells["C3:E{$r}"] = ['v' => date('m/d/Y', strtotime($vol['start_date']))];
                if (!empty($vol['end_date']))   $cells["C3:F{$r}"] = ['v' => date('m/d/Y', strtotime($vol['end_date']))];
                $cells["C3:G{$r}"] = ['v' => (string) ($vol['number_of_hours'] ?? '')];
                $cells["C3:H{$r}"] = ['v' => $vol['position_role'] ?? ''];
            }
        }

        if (!empty($data['professional']['ld'])) {
            $ldRows = [18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 35, 36, 37, 38];
            foreach ($data['professional']['ld'] as $i => $ld) {
                if (!isset($ldRows[$i])) break;
                $r = $ldRows[$i];
                $cells["C3:A{$r}"] = ['v' => $ld['ld_title'] ?? ''];
                if (!empty($ld['ld_date_from'])) $cells["C3:E{$r}"] = ['v' => date('m/d/Y', strtotime($ld['ld_date_from']))];
                if (!empty($ld['ld_date_to']))   $cells["C3:F{$r}"] = ['v' => date('m/d/Y', strtotime($ld['ld_date_to']))];
                $cells["C3:G{$r}"] = ['v' => (string) ($ld['ld_hours'] ?? '')];
                $cells["C3:H{$r}"] = ['v' => $ld['ld_type'] ?? ''];
                $cells["C3:I{$r}"] = ['v' => $ld['ld_sponsor'] ?? ''];
            }
        }

        $otherRows = [42, 43, 44, 45, 46, 47, 48];
        foreach (($data['other']['skills'] ?? []) as $i => $skill) {
            if (!isset($otherRows[$i])) break;
            $cells["C3:A{$otherRows[$i]}"] = ['v' => $skill['skill_hobby'] ?? ''];
        }
        foreach (($data['other']['recognition'] ?? []) as $i => $rec) {
            if (!isset($otherRows[$i])) break;
            $cells["C3:C{$otherRows[$i]}"] = ['v' => $rec['recognition'] ?? ''];
        }
        foreach (($data['other']['membership'] ?? []) as $i => $mem) {
            if (!isset($otherRows[$i])) break;
            $cells["C3:I{$otherRows[$i]}"] = ['v' => $mem['membership'] ?? ''];
        }

        /* ══════════════════════════════════════════════════════════════
           C4  ·  Declarations / References / Government ID
           
           ALL positions verified from PDS-Form-212-2025.xlsx:
           
           Q34a within 3rd degree  → I6:L6   (TL=I6)
           Q34b within 4th degree  → I8       (single)
           Q35a found guilty       → I15:L15  (TL=I15)
           Q35b criminally charged → I18      (single, row inside C18:F22)
           Q35b date filed         → J20      (single, after H20:I20 label)
           Q35b status of case     → I22:K22  (TL=I22)
           Q36  convicted          → I25:L25  (TL=I25)
           Q37  separated          → I29:L29  (TL=I29)
           Q38a election candidate → K32:L32  (TL=K32)
           Q38b resigned for poll  → I34:L34  (TL=I34)
           Q39  immigrant          → I39:L39  (TL=I39)
           Q40a indigenous group   → I43      (single)
           Q40b disability         → I45      (single)
           Q40c solo parent        → I47      (single)
           
           References:
           ref name    → A52:E52 / A53:E53 / A54:E54
           ref address → F52 / F53 / F54      (single cells)
           ref contact → G52:I52 / G53:I53 / G54:I54
           
           Gov ID:
           type   → D62:D63  (TL=D62)
           number → D64:D65  (TL=D64)
           
           Photo  → J50:M55  (TL=J50)
        ══════════════════════════════════════════════════════════════ */
        if (!empty($data['other']['c4'])) {
            $c4 = $data['other']['c4'];
            $yn = static fn($v) => strtoupper(trim((string) ($v ?? '')));

            // Q34
            $cells['C4:I6']  = ['v' => $yn($c4['q34a'])];  // a. within 3rd degree → I6:L6
            $cells['C4:I8']  = ['v' => $yn($c4['q34b'])];  // b. within 4th degree → I8 single

            // Q35
            $cells['C4:I15'] = ['v' => $yn($c4['q35a'])];  // found guilty → I15:L15
            $cells['C4:I18'] = ['v' => $yn($c4['q35b'])];  // criminally charged → I18 single
            if (!empty($c4['q35b_datefiled'])) {
                $cells['C4:J20'] = ['v' => date('m/d/Y', strtotime($c4['q35b_datefiled']))]; // J20 single
            }
            $cells['C4:I22'] = ['v' => $c4['q35b_status'] ?? ''];  // status → I22:K22

            // Q36 convicted → I25:L25
            $cells['C4:I25'] = ['v' => $yn($c4['q36'])];

            // Q37 separated → I29:L29
            $cells['C4:I29'] = ['v' => $yn($c4['q37'])];

            // Q38a election candidate → K32:L32
            $cells['C4:K32'] = ['v' => $yn($c4['q38a'])];
            // Q38b resigned for poll  → I34:L34
            $cells['C4:I34'] = ['v' => $yn($c4['q38b'])];

            // Q39 immigrant → I39:L39
            $cells['C4:I39'] = ['v' => $yn($c4['q39'])];

            // Q40a indigenous group → I43 single
            $cells['C4:I43'] = ['v' => $yn($c4['q40a'])];
            // Q40b disability       → I45 single
            $cells['C4:I45'] = ['v' => $yn($c4['q40b'])];
            // Q40c solo parent      → I47 single
            $cells['C4:I47'] = ['v' => $yn($c4['q40c'])];

            // References
            $cells['C4:A52'] = ['v' => $c4['ref_name1'] ?? ''];
            $cells['C4:F52'] = ['v' => $c4['ref_address1'] ?? ''];   // F52 single
            $cells['C4:G52'] = ['v' => $c4['ref_tel1'] ?? ''];       // G52:I52

            $cells['C4:A53'] = ['v' => $c4['ref_name2'] ?? ''];
            $cells['C4:F53'] = ['v' => $c4['ref_address2'] ?? ''];
            $cells['C4:G53'] = ['v' => $c4['ref_tel2'] ?? ''];

            $cells['C4:A54'] = ['v' => $c4['ref_name3'] ?? ''];
            $cells['C4:F54'] = ['v' => $c4['ref_address3'] ?? ''];
            $cells['C4:G54'] = ['v' => $c4['ref_tel3'] ?? ''];

            // Government Issued ID
            // Row 61: "Government Issued ID:" label B61:C61 → value D61 (single cell)
            $cells['C4:D61'] = ['v' => $c4['gov_id'] ?? ''];         // D61 single — ID type (e.g. "Passport")
            // Row 62: "ID/License/Passport No.:" label B62:C63 → value D62:D63
            $cells['C4:D62'] = ['v' => $c4['gov_id_no'] ?? ''];      // D62:D63 — ID number
            // Row 64: "Date/Place of Issuance:" label B64:C65 → value D64:D65
            $cells['C4:D64'] = ['v' => $c4['gov_id_issue'] ?? ''];   // D64:D65 — date/place
        }

        // Photo → J50:M55 (TL=J50, logical row=50 col=10 in HTML table)
        // Resolve the stored photo path to a public URL so the browser can load it.
        // The personal_information.photo column may store:
        //   - a relative path like "uploads/photos/emp_123.jpg"
        //   - a full URL  (pass through unchanged)
        //   - a base64 data URI (pass through unchanged)
        $rawPhoto = $data['personal']['photo'] ?? null;
        $photo    = null;

        if (!empty($rawPhoto)) {
            if (str_starts_with($rawPhoto, 'data:') || str_starts_with($rawPhoto, 'http')) {
                // Already a data URI or absolute URL — use as-is
                $photo = $rawPhoto;
            } else {
                // Relative path — prepend base_url so the browser can fetch it
                $photo = base_url(ltrim($rawPhoto, '/'));
            }
        }

        json_response([
            'success' => true,
            'cells'   => $cells,
            'photo'   => $photo,
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