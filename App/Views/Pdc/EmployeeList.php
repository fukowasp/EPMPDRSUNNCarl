<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDC Employee List | SUNN</title>

<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">

<style>
/* Sidebar gradient */
.sidebar { 
    width:250px; 
    position:fixed; 
    top:60px; 
    left:0; 
    height:calc(100% - 70px);
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    padding-top:1rem; 
    overflow-y:auto;
}
.sidebar a { 
    color:white; 
    display:block; 
    padding:12px 20px; 
    text-decoration:none; 
    transition:0.2s; 
}
.sidebar a.active, 
.sidebar a:hover { 
    background: rgba(255,255,255,0.2); 
}

/* Navbar gradient & PDC User button green */
.navbar-custom {
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
}
.pdc-user-btn {
  border: none;
  color: #fff;
  background-image: linear-gradient(30deg, #059669, #34d399);
  border-radius: 20px;
  background-size: 100% auto;
  font-family: inherit;
  font-size: 17px;
  padding: 0.6em 1.5em;
  transition: background-size 0.3s ease, box-shadow 0.3s ease;
}
.pdc-user-btn:hover {
  background-position: right center;
  background-size: 200% auto;
  animation: pulse512 1.5s infinite;
}
@keyframes pulse512 {
  0% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.4); }
  70% { box-shadow: 0 0 0 10px rgba(5, 150, 105, 0); }
  100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
}

/* Main content */
main {
    margin-left: 250px;
    padding: 70px 20px 20px 20px;
    background: linear-gradient(120deg, #fff9e6, #ffffffff);
    min-height: 100vh;
    transition: all 0.3s ease;
}

/* Card-style container for the table */
.container {
    background: rgba(255, 255, 255, 0.9);
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* DataTable header gradient */
table.dataTable thead {
    background: linear-gradient(90deg, #ffea85 0%, #ffc107 100%);
    color: #000;
    font-weight: 600;
}

/* Table rows hover with gradient */
.dataTable tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    background: linear-gradient(90deg,#fff3cd 0%,#ffe066 100%);
}

/* Rounded table and border */
.dataTable {
    border-radius: 10px;
    overflow: hidden;
}

/* Search input style */
.dataTables_filter input {
    border-radius: 0.5rem;
    border: 1px solid #ffc107;
    padding: 0.25rem 0.5rem;
    background: #fffbea;
}

/* Pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    background: #fffbea;
    border: 1px solid #ffc107;
    border-radius: 5px;
    color: #000 !important;
    margin: 0 2px;
    padding: 5px 12px;
    transition: 0.2s;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #ffc107;
    color: #fff !important;
}

/* Highlight selected row */
.dataTable tbody tr.selected {
    background: linear-gradient(90deg,#ffe066 0%,#fff3cd 100%);
}

/* View PDS button updated color */
.btn-info {
    background: #0077B6;
    border-color: #005f99;
    color: #fff;
    transition: 0.2s;
}
.btn-info:hover {
    background: #005f99;
    color: #fff;
}

/* Responsive adjustments for small screens */
@media (max-width: 992px) {
    main { margin-left: 0; }
    table.dataTable { font-size: 0.9rem; }
}
</style>
</head>
<body class="bg-light">

<!-- Navbar -->
<?php include dirname(__DIR__, 1) . '/partials/pdc_navbar.php'; ?>

<!-- Sidebar -->
<?php include dirname(__DIR__, 1) . '/partials/pdc_sidebar.php'; ?>

<!-- View PDS modal -->
<?php include dirname(__DIR__, 1) . '/partials/pdc_viewpds.php'; ?>

<main>
    <div class="container-fluid my-4">
        <h3 class="mb-3">PDC Employee List</h3>
        <div class="card p-3 shadow-sm">
            <table id="employeeTable" class="table table-striped table-bordered nowrap align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Employment Type</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img id="previewImage" src="" class="img-fluid w-100">
      </div>
    </div>
  </div>
</div>



<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/responsive.bootstrap5.min.js') ?>"></script>

<script>
// Escape HTML for safety
const escapeHTML = text => text ? text.toString().replace(/[&<>"']/g, m =>
  ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])) : '—';

// Populate fields from mapping
const populateFields = (mapping, data) => {
    for (const [fieldId, key] of Object.entries(mapping)) {
        const el = document.getElementById(fieldId);
        if (el) el.textContent = escapeHTML(data[key] || '—');
    }
};

// Populate array tables (graduate studies, civil service, work, voluntary, learning & dev)
// Updated populateArrayTable for image preview modal
const populateArrayTable = (tableId, arr, columns, baseFolder = '') => {
    const tbody = document.querySelector(tableId + ' tbody');
    tbody.innerHTML = arr.length
      ? arr.map(item => `<tr>${
            columns.map(col => {
                const fileName = item[col];
                
                // Render image if it's a file / proof / membership_id_url
                if (col.includes('file') || col.includes('certification') || col.includes('proof') || col === 'membership_id_url') {
                    if(fileName){
                        return `<td>
                                    <img src="${baseFolder}${fileName}" 
                                         class="pds-preview-img" 
                                         style="width:50px;height:50px;object-fit:cover;cursor:pointer;" 
                                         data-src="${baseFolder}${fileName}">
                                </td>`;
                    } else return '<td>—</td>';
                } else {
                    return `<td>${escapeHTML(item[col] || '—')}</td>`;
                }
            }).join('')
        }</tr>`).join('')
      : `<tr><td colspan="${columns.length}" class="text-center text-muted">No data</td></tr>`;
};

// Image click preview
document.addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('pds-preview-img')) {
        const src = e.target.getAttribute('data-src');
        const preview = document.getElementById('previewImage');
        preview.src = src;
        
        // Show the image modal manually
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }
});




// Initialize DataTable
let table = $('#employeeTable').DataTable({
    responsive: true,
    ajax: {
        url: "<?= base_url('pdc/employeelist/fetchAllJson') ?>",
        dataSrc: json => json.status === 'success' ? json.rows : []
    },
    columns: [
        { data: 'employee_id', render: escapeHTML },
        { data: null, render: row => `${escapeHTML(row.first_name)} ${escapeHTML(row.surname)}` },
        { data: 'department', render: escapeHTML },
        { data: 'employment_type', render: escapeHTML },
        { data: 'mobile_no', render: escapeHTML },
        { data: 'email_address', render: escapeHTML },
        { data: null, render: row => `<button class="btn btn-info btn-sm view-btn" data-id="${escapeHTML(row.employee_id)}">View PDS</button>` }
    ]
});

// Build Other Information Combined Table
function buildOtherInfoData(skills, recognition, membership) {
    const maxRows = Math.max(skills.length, recognition.length, membership.length);

    const rows = [];
    for (let i = 0; i < maxRows; i++) {
        rows.push({
            skill_hobby: skills[i]?.skill_hobby || '—',
            recognition: recognition[i]?.recognition || '—',
            membership: membership[i]?.membership || '—',
            proof_membership: membership[i]?.proof_membership || null
        });
    }
    return rows;
}


// View PDS click handler
$('#employeeTable tbody').on('click', '.view-btn', async function(){
    const id = $(this).data('id');
    try {
        const res = await fetch(`<?= base_url('pdc/employeelist/viewPDS') ?>?id=${id}`);
        const data = await res.json();
        if(data.status !== 'success') {
            alert(data.message || 'Failed to fetch PDS.');
            return;
        }
        const pds = data.data;

        // Personal info mapping
        const personalMapping = {
            pds_employee_id: 'employee_id',
            pds_surname: 'surname',
            pds_first_name: 'first_name',
            pds_middle_name: 'middle_name',
            pds_name_ext: 'name_extension',
            pds_department: 'department',
            pds_employment_type: 'employment_type',
            pds_mobile_no: 'mobile_no',
            pds_email: 'email_address',
            pds_dob: 'date_of_birth',
            pds_pob: 'place_of_birth',
            pds_sex: 'sex',
            pds_civil_status: 'civil_status',
            pds_height: 'height',
            pds_weight: 'weight',
            pds_blood_type: 'blood_type',
            pds_gsis: 'gsis_id_no',
            pds_pagibig: 'pagibig_id_no',
            pds_philhealth: 'philhealth_no',
            pds_sss: 'sss_no',
            pds_tin: 'tin_no',
            pds_agency_no: 'agency_employee_no',
            pds_citizenship: 'citizenship_type',
            pds_dual_by: 'dual_citizenship_by',
            pds_dual_country: 'dual_citizenship_country',
            pds_telephone: 'telephone_no',
        };

        // Populate fields including concatenated addresses
        const populatePersonalInfo = (employee) => {
            // Populate normal fields
            for (const [fieldId, key] of Object.entries(personalMapping)) {
                const el = document.getElementById(fieldId);
                if (el) el.textContent = escapeHTML(employee[key] || '—');
            }

            // Concatenate residential address
            const resAddress = [
                employee.res_house_block_lot,
                employee.res_street,
                employee.res_subdivision,
                employee.res_barangay,
                employee.res_city_municipality,
                employee.res_province,
                employee.res_zip_code
            ].filter(Boolean).join(', ');
            document.getElementById('pds_res_address').textContent = escapeHTML(resAddress || '—');

            // Concatenate permanent address
            const permAddress = [
                employee.perm_house_block_lot,
                employee.perm_street,
                employee.perm_subdivision,
                employee.perm_barangay,
                employee.perm_city_municipality,
                employee.perm_province,
                employee.perm_zip_code
            ].filter(Boolean).join(', ');
            document.getElementById('pds_perm_address').textContent = escapeHTML(permAddress || '—');
        };



        populatePersonalInfo(pds.employee);

        // Family info mapping
        const familyMapping = {
            pds_spouse_name: 'spouse_full_name',
            pds_spouse_occupation: 'spouse_occupation',
            pds_spouse_employer: 'spouse_employer_name',
            pds_spouse_address: 'spouse_business_address',
            pds_spouse_phone: 'spouse_telephone_no',
            pds_father: 'father_full_name',
            pds_mother: 'mother_full_name',
            pds_mother_maiden: 'mother_maiden_name'
        };
        populateFields(familyMapping, pds.family);

        // Education mapping
        const educationMapping = {
            pds_elem_school: 'elementary_school_name',
            pds_elem_year: 'elementary_year_graduated',
            pds_elem_honor: 'elementary_honor',
            pds_sec_school: 'secondary_school_name',
            pds_sec_year: 'secondary_year_graduated',
            pds_sec_honor: 'secondary_honor',
            pds_shs_school: 'seniorhigh_school_name',
            pds_shs_year: 'seniorhigh_year_graduated',
            pds_shs_honor: 'seniorhigh_honor',
            pds_voc_course: 'vocational_course',
            pds_voc_year: 'vocational_year_completed',
            pds_voc_honor: 'vocational_honor',
            pds_col_course: 'college_course',
            pds_col_year: 'college_year_graduated',
            pds_col_units: 'college_units_earned',
            pds_col_honor: 'college_honor'
        };
        populateFields(educationMapping, pds.education);

        // Populate tables
        populateArrayTable('#pds_grad_table', pds.graduate_studies, ['graduate_course','institution_name','year_graduated','units_earned','specialization','honor_received','certification_file'], '<?= base_url("public/assets/graduate_cert/") ?>');
       
        populateArrayTable('#pds_civil_service_table', pds.civil_service, [
        'career_service',          
        'rating',
        'date_of_examination_conferment',
        'place_of_examination_conferment',
        'proof_of_certification'
        ], '<?= base_url("public/assets/civilser/") ?>');
        populateArrayTable('#pds_work_table', pds.work_experience, [
            'work_position',       // Position Title
            'work_company',        // Company / Organization
            'work_date_from',      // Start Date
            'work_date_to',        // End Date
            'work_salary',         // Monthly Salary
            'work_grade',          // Salary Grade
            'work_status',         // Appointment Status
            'work_govt_service'    // Government Service
        ]);

        populateArrayTable('#pds_volwork_table', pds.voluntarywork, [
        'organization_name',   // Organization
        'position_role',       // Position / Role
        'organization_address',// Address
        'start_date',          // Date From
        'end_date',            // Date To
        'number_of_hours',     // No. of Hours
        'membership_id_url'    // Proof / Membership ID
        ], '<?= base_url("public/assets/voluntarywork/") ?>');

        populateArrayTable('#pds_learningdev_table', pds.learning_development, [
            'ld_title',         // Title of Learning and Development
            'ld_date_from',     // Date From
            'ld_date_to',       // Date To
            'ld_hours',         // Number of Hours
            'ld_type',          // Type of LD
            'ld_sponsor',       // Conducted / Sponsored By
            'ld_certification'  // Proof / Certification
        ], '<?= base_url("public/assets/learndev/") ?>');

            // OTHER INFORMATION
            const otherInfoRows = buildOtherInfoData(
                pds.other_skills || [],
                pds.other_recognition || [],
                pds.other_membership || []
            );

            populateArrayTable('#pds_otherinfo_table', 
                otherInfoRows,
                ['skill_hobby', 'recognition', 'membership', 'proof_membership'],
                '<?= base_url("public/assets/membership_proof/") ?>'
            );

          // Populate C4 Sections
            if(pds.c4_sections){
                const c4 = pds.c4_sections;
                for (const key in c4) {
                    const el = document.getElementById('c4_' + key);
                    if(el){
                        // If it's a photo file, show as image
                        if(key === 'photo' && c4[key]){
                            el.innerHTML = `<img src="<?= base_url('public/assets/c4_photos/') ?>${c4[key]}" 
                                            class="img-thumbnail" 
                                            style="width:80px;height:80px;object-fit:cover;cursor:pointer;" 
                                            onclick="new bootstrap.Modal(document.getElementById('imagePreviewModal')).show(); 
                                                    document.getElementById('previewImage').src='<?= base_url('public/assets/c4_photos/') ?>${c4[key]}'">`;
                        } else {
                            el.textContent = c4[key] ?? '—';
                        }
                    }
                }
            }
  
        // Show modal
        new bootstrap.Modal(document.getElementById('viewPDSModal')).show();

    } catch(err) {
        console.error(err);
        alert('Error fetching PDS.');
    }
});
</script>

</body>
</html>
