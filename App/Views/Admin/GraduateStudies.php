<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | Graduate Studies</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">

<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="<?= base_url('libs/sweetalert2/dist/sweetalert2.min.css') ?>">

<style>
  .dataTables_wrapper { width: 100% !important; overflow-x: auto; }
  table.dataTable { width: 100% !important; table-layout: auto !important; }
  table.dataTable td, table.dataTable th { white-space: nowrap; }
  table.dataTable td:last-child { text-align: center; min-width: 180px; }

  /* Blue circular tab buttons */
  .nav-tabs {
    border-bottom: none;
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 15px;
  }

  .nav-tabs .nav-link {
    color: #0d6efd;
    background-color: #e9f1ff;
    border: 2px solid #0d6efd;
    border-radius: 50px;
    transition: all 0.3s ease;
    font-weight: 500;
    padding: 8px 18px;
  }

  .nav-tabs .nav-link:hover {
    background-color: #cfe2ff;
    color: #0b5ed7;
    transform: translateY(-2px);
  }

  .nav-tabs .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
    font-weight: 600;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
  }

  /* Fit certification image */
  #view_certification img {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
  }
</style>
</head>
<body class="bg-light">

<?php include dirname(__DIR__, 2) . '/includes/admin_navbar.php'; ?>

<div class="d-flex">
  <!-- Sidebar -->
  <?php include dirname(__DIR__, 2) . '/includes/admin_sidebar.php'; ?>
  
  <!-- Main content -->
  <div class="flex-grow-1 main-content p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h3><i class="bi bi-mortarboard-fill me-2"></i>Graduate Studies Records</h3>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table id="gradTable" class="table table-striped table-bordered align-middle w-100">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Program</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- View Modal with Tabs -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Graduate Study Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="viewTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">General Info</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab">Academic Details</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="cert-tab" data-bs-toggle="tab" data-bs-target="#certification" type="button" role="tab">Certification</button>
          </li>
        </ul>
        <div class="tab-content mt-3">
          <!-- General Info -->
          <div class="tab-pane fade show active" id="general" role="tabpanel">
            <table class="table table-bordered">
              <tbody>
                <tr><th>ID</th><td id="view_id"></td></tr>
                <tr><th>Employee ID</th><td id="view_employee_id"></td></tr>
                <tr><th>Full Name</th><td id="view_full_name"></td></tr>
                <tr><th>Institution</th><td id="view_institution"></td></tr>
                <tr><th>Program</th><td id="view_program"></td></tr>
              </tbody>
            </table>
          </div>
          <!-- Academic Details (updated to match General Info style) -->
          <div class="tab-pane fade" id="academic" role="tabpanel">
            <table class="table table-bordered">
              <tbody>
                <tr><th>Year Graduated</th><td id="view_year"></td></tr>
                <tr><th>Units Earned</th><td id="view_units"></td></tr>
                <tr><th>Specialization</th><td id="view_specialization"></td></tr>
                <tr><th>Honor Received</th><td id="view_honor"></td></tr>
              </tbody>
            </table>
          </div>
          <!-- Certification -->
          <div class="tab-pane fade" id="certification" role="tabpanel">
            <div id="view_certification" class="text-center"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form id="editForm" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Graduate Study</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <input type="hidden" name="id" id="edit_id">
        <input type="hidden" name="existing_file" id="existing_file">

        <div class="col-md-6">
          <label class="form-label">Institution Name</label>
          <input type="text" name="institution_name" id="institution_name" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Program</label>
          <select name="graduate_course" id="graduate_course" class="form-select" required>
            <option value="">Select Program</option>
            <option value="DIT">Doctor in Information Technology (DIT)</option>
            <option value="PHDEM">Doctor of Philosophy in Educational Management (PHDEM)</option>
            <option value="DPA">Doctor of Public Administration (DPA)</option>
            <option value="MIT">Master in Information Technology (MIT)</option>
            <option value="MN">Master in Nursing (MN)</option>
            <option value="MPA">Master in Public Administration (MPA)</option>
            <option value="MAED">Master of Arts in Education (MAED)</option>
            <option value="MSA">Master of Science in Agriculture (MSA)</option>
            <option value="MSFi">Master of Science in Fisheries (MSFi)</option>
          </select>
        </div>

        <div class="col-md-4">
          <label class="form-label">Year Graduated</label>
          <input type="number" name="year_graduated" id="year_graduated" class="form-control">
        </div>

        <div class="col-md-4">
          <label class="form-label">Units Earned</label>
          <input type="text" name="units_earned" id="units_earned" class="form-control">
        </div>

        <div class="col-md-4">
          <label class="form-label">Honor Received</label>
          <input type="text" name="honor_received" id="honor_received" class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">Specialization</label>
          <input type="text" name="specialization" id="specialization" class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">Certification File</label>
          <input type="file" name="certification_file" id="certification_file" class="form-control">
        </div>
      </div>
      <div class="modal-footer flex-wrap">
        <button type="submit" class="btn btn-success">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>

<script>
$(function() {
  const viewModal = new bootstrap.Modal('#viewModal');
  const editModal = new bootstrap.Modal('#editModal');
  const basePath = '<?= base_url('public/assets/graduate_cert/') ?>';

  const programNames = {
    'DIT': 'Doctor in Information Technology (DIT)',
    'PHDEM': 'Doctor of Philosophy in Educational Management (PHDEM)',
    'DPA': 'Doctor of Public Administration (DPA)',
    'MIT': 'Master in Information Technology (MIT)',
    'MN': 'Master in Nursing (MN)',
    'MPA': 'Master in Public Administration (MPA)',
    'MAED': 'Master of Arts in Education (MAED)',
    'MSA': 'Master of Science in Agriculture (MSA)',
    'MSFi': 'Master of Science in Fisheries (MSFi)'
  };

  const table = $('#gradTable').DataTable({
    ajax: '<?= base_url("admin/graduatestudies/fetchAllJson") ?>',
    responsive: true,
    autoWidth: false,
    columns: [
      { data: 'id' },
      { data: 'employee_id' },
      { data: null, render: row => `${row.first_name ?? ''} ${row.surname ?? ''}` },
      { data: 'graduate_course', render: val => programNames[val] ?? val },
      { data: null, orderable: false, render: () => `
        <div class="d-flex flex-wrap gap-2 justify-content-center">
          <button class="btn btn-info btn-sm viewBtn">View</button>
          <button class="btn btn-warning btn-sm editBtn">Edit</button>
          <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
        </div>
      `}
    ]
  });

  // View
  $('#gradTable').on('click', '.viewBtn', function() {
    const data = table.row($(this).parents('tr')).data();
    $('#view_id').text(data.id);
    $('#view_employee_id').text(data.employee_id);
    $('#view_full_name').text(`${data.first_name ?? ''} ${data.surname ?? ''}`);
    $('#view_institution').text(data.institution_name ?? '');
    $('#view_program').text(programNames[data.graduate_course] ?? data.graduate_course);
    $('#view_year').text(data.year_graduated ?? '');
    $('#view_units').text(data.units_earned ?? '');
    $('#view_specialization').text(data.specialization ?? '');
    $('#view_honor').text(data.honor_received ?? '');

    if(data.certification_file){
      const ext = data.certification_file.split('.').pop().toLowerCase();
      let html = '';
      if(['jpg','jpeg','png','gif','webp'].includes(ext)){
        html = `<a href="${basePath + encodeURIComponent(data.certification_file)}" target="_blank">
                  <img src="${basePath + encodeURIComponent(data.certification_file)}"></a>`;
      } else if(ext==='pdf'){
        html = `<a href="${basePath + encodeURIComponent(data.certification_file)}" target="_blank" class="text-danger">
                  <i class="bi bi-file-earmark-pdf-fill fs-3"></i> View PDF</a>`;
      } else {
        html = `<a href="${basePath + encodeURIComponent(data.certification_file)}" target="_blank">View File</a>`;
      }
      $('#view_certification').html(html);
    } else {
      $('#view_certification').text('—');
    }

    viewModal.show();
  });

  // Edit
  $('#gradTable').on('click', '.editBtn', function() {
    const data = table.row($(this).parents('tr')).data();
    $('#edit_id').val(data.id);
    $('#institution_name').val(data.institution_name);
    $('#graduate_course').val(data.graduate_course);
    $('#year_graduated').val(data.year_graduated);
    $('#units_earned').val(data.units_earned);
    $('#specialization').val(data.specialization);
    $('#honor_received').val(data.honor_received);
    $('#existing_file').val(data.certification_file);
    editModal.show();
  });

  // Update with SweetAlert2
  $('#editForm').submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
      url: '<?= base_url("admin/graduatestudies/update") ?>',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: res => {
        Swal.fire({
          icon: res.success ? 'success' : 'error',
          title: res.success ? 'Updated!' : 'Error!',
          text: res.message
        }).then(() => {
          if(res.success){
            editModal.hide();
            table.ajax.reload(null,false);
          }
        });
      }
    });
  });

  // Delete with SweetAlert2
  $('#gradTable').on('click', '.deleteBtn', function() {
    const data = table.row($(this).parents('tr')).data();
    Swal.fire({
      title: 'Are you sure?',
      text: "This record will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if(result.isConfirmed){
        $.post('<?= base_url("admin/graduatestudies/delete") ?>', { id: data.id }, res => {
          Swal.fire({
            icon: res.success ? 'success' : 'error',
            title: res.success ? 'Deleted!' : 'Error!',
            text: res.message
          }).then(() => {
            if(res.success) table.ajax.reload(null,false);
          });
        }, 'json');
      }
    });
  });
});
</script>

</body>
</html>
