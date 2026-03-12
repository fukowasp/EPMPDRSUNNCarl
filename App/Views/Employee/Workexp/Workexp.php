<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Work Experience</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/civilser.css') ?>">
</head>
<body>
<div class="wrapper">
  <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

  <div class="content-wrapper">
    <div class="container-fluid py-4">

      <!-- Page Header -->
      <div class="page-header mb-4">
        <h1 class="page-title"><i class="bi bi-briefcase"></i> Work Experience</h1>
        <p class="page-subtitle">Please provide your complete work history</p>
      </div>

      <!-- Info Alert -->
      <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle me-2"></i>List all your work experience including government and private service.
      </div>

      <!-- Work Experience Table Card -->
      <div class="form-card mb-4">
        <div class="card-body">
          <div class="text-end mb-3">
            <button class="btn btn-success" id="addWorkExperienceBtn">
              <i class="bi bi-plus-circle me-2"></i>Add Work Experience
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="workExperienceTable">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Position</th>
                  <th>Company</th>
                  <th>Status</th>
                  <th>Govt Service</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="workExperienceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content form-card">
      <form id="workExperienceForm">
        <!-- Modal Header -->
        <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
          <h5 class="modal-title" id="workExperienceModalLabel">Add Work Experience</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <input type="hidden" name="id" id="work_id">

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Inclusive Dates - From <span class="required">*</span></label>
              <input type="date" class="form-control" name="date_from" id="work_date_from" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Inclusive Dates - To</label>
              <input type="date" class="form-control" name="date_to" id="work_date_to">
            </div>

            <div class="col-12">
              <label class="form-label">Position Title <span class="required">*</span></label>
              <input type="text" class="form-control" name="position" id="work_position" required>
            </div>

            <div class="col-12">
              <label class="form-label">Company / Department / Agency <span class="required">*</span></label>
              <input type="text" class="form-control" name="company" id="work_company" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Monthly Salary</label>
              <input type="number" class="form-control" name="salary" id="work_salary" step="0.01">
            </div>

            <div class="col-md-4">
              <label class="form-label">Salary/Job/Pay Grade & Step</label>
              <input type="text" class="form-control" name="grade" id="work_grade">
            </div>

            <div class="col-md-4">
              <label class="form-label">Status of Appointment</label>
              <input type="text" class="form-control" name="status" id="work_status">
            </div>

            <div class="col-md-6">
              <label class="form-label">Government Service <span class="required">*</span></label>
              <select class="form-select" name="govt_service" id="work_govt_service" required>
                <option value="">Select</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer form-actions">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="saveWorkExperienceBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- View Work Experience Modal -->
<div class="modal fade" id="workExperienceViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content form-card">
      <!-- Modal Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
        <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Work Experience Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-4">
        <div class="table-responsive">
          <table class="table table-borderless mb-0">
            <tbody>
              <tr>
                <th style="width:35%">Inclusive Dates</th>
                <td id="view_work_dates"></td>
              </tr>
              <tr>
                <th>Position Title</th>
                <td id="view_work_position"></td>
              </tr>
              <tr>
                <th>Company / Department / Agency</th>
                <td id="view_work_company"></td>
              </tr>
              <tr>
                <th>Monthly Salary</th>
                <td id="view_work_salary"></td>
              </tr>
              <tr>
                <th>Salary/Job/Pay Grade & Step</th>
                <td id="view_work_grade"></td>
              </tr>
              <tr>
                <th>Status of Appointment</th>
                <td id="view_work_status"></td>
              </tr>
              <tr>
                <th>Government Service</th>
                <td id="view_work_govt_service"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer form-actions justify-content-center">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
$(document).ready(function() {
  const tableBody = $('#workExperienceTable tbody');
  const modal = new bootstrap.Modal($('#workExperienceModal'));

  function loadWorkExperiences() {
    $.getJSON('<?= base_url("employee/workexp/get") ?>', function(res) {
      tableBody.empty();

      if(res.success && res.data.length) {

        // ✅ Sort by date_from DESC (latest first)
        res.data.sort((a, b) => {
          return new Date(b.work_date_from) - new Date(a.work_date_from);
        });

        res.data.forEach((exp, idx) => {
          tableBody.append(`
            <tr data-id="${exp.id}" 
                data-salary="${exp.work_salary||''}" 
                data-grade="${exp.work_grade||''}">
              <td>${idx+1}</td>
              <td>${exp.work_date_from||''}</td>
              <td>${exp.work_date_to||''}</td>
              <td>${exp.work_position||''}</td>
              <td>${exp.work_company||''}</td>
              <td>${exp.work_status||''}</td>
              <td>${exp.work_govt_service||''}</td>
              <td>
                <button class="btn btn-sm btn-info view-entry">
                  <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary edit-entry">
                  <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-entry">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          `);
        });

      } else {
        tableBody.append('<tr><td colspan="8" class="text-center">No records found.</td></tr>');
      }
    });
  }

  $('#addWorkExperienceBtn').click(function() {
    $('#workExperienceForm')[0].reset();
    $('#work_id').val('');
    $('#workExperienceModalLabel').text('Add Work Experience');
    modal.show();
  });

  $(document).on('click', '.edit-entry', function() {
    const row = $(this).closest('tr');
    $('#work_id').val(row.data('id'));
    $('#work_date_from').val(row.children().eq(1).text());
    $('#work_date_to').val(row.children().eq(2).text());
    $('#work_position').val(row.children().eq(3).text());
    $('#work_company').val(row.children().eq(4).text());
    $('#work_salary').val(row.data('salary'));
    $('#work_grade').val(row.data('grade'));
    $('#work_status').val(row.children().eq(5).text());
    $('#work_govt_service').val(row.children().eq(6).text());
    $('#workExperienceModalLabel').text('Edit Work Experience');
    modal.show();
  });

  $(document).on('click', '.view-entry', function() {
    const row = $(this).closest('tr');
    $('#view_work_dates').text(`${row.children().eq(1).text()} - ${row.children().eq(2).text() || 'Present'}`);
    $('#view_work_position').text(row.children().eq(3).text());
    $('#view_work_company').text(row.children().eq(4).text());
    $('#view_work_salary').text(row.data('salary') || '-');
    $('#view_work_grade').text(row.data('grade') || '-');
    $('#view_work_status').text(row.children().eq(5).text() || '-');
    $('#view_work_govt_service').text(row.children().eq(6).text() || '-');

    new bootstrap.Modal($('#workExperienceViewModal')).show();
  });

  $('#workExperienceForm').submit(function(e){
    e.preventDefault();
    const formData = $(this).serialize();
    $.post('<?= base_url("employee/workexp/save") ?>', formData, function(res){
      Swal.fire(res.success?'Saved!':'Error!', res.message, res.success?'success':'error');
      if(res.success){ modal.hide(); loadWorkExperiences(); }
    }, 'json');
  });

  $(document).on('click', '.delete-entry', function() {
    const row = $(this).closest('tr');
    const id = row.data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "This record will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then(result=>{
      if(result.isConfirmed){
        $.post('<?= base_url("employee/workexp/delete") ?>', {id}, function(res){
          Swal.fire(res.success?'Deleted!':'Error!', res.message, res.success?'success':'error');
          if(res.success) loadWorkExperiences();
        }, 'json');
      }
    });
  });

  loadWorkExperiences();
});
</script>
</body>
</html>