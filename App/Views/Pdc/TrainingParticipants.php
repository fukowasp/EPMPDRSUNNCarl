<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Training Participants | SUNN</title>

<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/pdc/pdcdashboard.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/select2/css/select2.min.css') ?>">
</head>

<body class="bg-light">
<?php include dirname(__DIR__, 1) . '/partials/pdc_navbar.php'; ?>
<?php include dirname(__DIR__, 1) . '/partials/pdc_sidebar.php'; ?>
<main>
  <div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold"><i class="bi bi-person-lines-fill"></i> Training Participants</h3>
    </div>

    <div class="card p-3 shadow-sm mb-4">
      <div class="row g-2 align-items-center">
        <div class="col-md-8">
          <label class="form-label fw-bold">Select Training</label>
          <select id="trainingSelect" class="form-select">
              <option value="" disabled selected>-- Select Training --</option>
          </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button id="loadRecommendations" class="btn btn-primary w-100">
            <i class="bi bi-lightbulb"></i> Show Recommended Employees
          </button>
        </div>
      </div>
    </div>

    <div class="card p-3 shadow-sm">
      <h5 class="fw-bold mb-3"><i class="bi bi-person-check"></i> Recommended Employees</h5>
      <div class="mb-2">
        <input type="text" id="recommendedSearch" class="form-control" placeholder="Search recommended employees...">
      </div>
      <table id="recommendedTable" class="table table-striped table-bordered nowrap align-middle" style="width:100%">
        <thead>
          <tr>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Skills / Specialization</th>
            <th>Similarity Score</th>
            <th>Total L&D Trainings</th>  <!-- NEW -->
            <th>Action</th>
          </tr>
        </thead>
        
        <tbody>
          <tr><td colspan="4" class="text-center text-muted">Select a training to view recommendations</td></tr>
        </tbody>
      </table>
    </div>

    <div class="card p-3 shadow-sm mt-4">
      <h5 class="fw-bold mb-3"><i class="bi bi-list-check"></i> All Participants</h5>
      <table id="participantsTable" class="table table-striped table-bordered nowrap align-middle" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Employee</th>
            <th>Training Title</th>
            <th>Type</th>
            <th>Category</th>
            <th>Date Completed</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</main>
<!-- JS -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('dist/select2/js/select2.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/responsive.bootstrap5.min.js') ?>"></script>
<script>
$(function() {
  const CSRF_TOKEN = '<?= csrf_token() ?>';
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } });

  $('#trainingSelect').select2({ placeholder: "-- Select Training --", width: '100%', allowClear: true });

  let selectedTrainingId = null;

  // Participants DataTable
  const participantsTable = $('#participantsTable').DataTable({
      responsive: true,
      ajax: { url: '<?= base_url("pdc/trainingparticipants/getParticipants") ?>', type: 'GET', dataSrc: 'data' },
      columns: [
          { data: 'employee_id' },
          { data: 'employee_name' },
          { data: 'training_title' },
          { data: 'type' },
          { data: 'category' },
          { data: 'end_date', defaultContent: '—' },
          { 
              data: 'status',
              render: function(s, type, row) {
                  if (!s || s.trim() === '') s = 'Pending';
                  const colors = { Pending: 'bg-secondary', Accepted: 'bg-warning text-dark', Cancelled: 'bg-danger' };
                  return `<span class="badge ${colors[s] || 'bg-secondary'}" ${s === 'Cancelled' ? `data-reason="${row.cancel_reason || 'No reason provided'}"` : ''}>${s}</span>`;
              }
          },
          { 
              data: 'employee_id',
              render: function(empId, type, row) {
                    let buttons = `<button class="btn btn-sm btn-danger delete-btn" 
                        data-employee-id="${empId}" 
                        data-training-id="${row.training_id}">
                  <i class="bi bi-trash"></i> Delete
                  </button>`;
                  
                  if(row.status === 'Cancelled'){
                      buttons = `<button class="btn btn-sm btn-warning view-cancel-reason-btn me-2" 
                                        data-employee-id="${empId}" 
                                        data-employee-name="${row.employee_name}" 
                                        data-reason="${row.cancel_reason || 'No reason provided'}">
                                    <i class="bi bi-eye"></i> View Cancelled Reason
                                </button>` + buttons;
                  }
                  return buttons;
              }
          }
      ]
  });


  // Load trainings dropdown
  function loadTrainings() {
      $.getJSON("<?= base_url('pdc/training/getTrainingsJson') ?>", res => {
          if(res.success && res.data.length > 0) {
              const currentValue = selectedTrainingId || $('#trainingSelect').val();
              let options = '<option value="">-- Select Training --</option>';
              options += res.data.map(t => `<option value="${t.training_id}">${t.training_title} (${t.category})</option>`).join('');
              $('#trainingSelect').html(options).val(currentValue).trigger('change');
          }
      });
  }

$('#participantsTable tbody').on('click', '.delete-btn', function(){
    const employee_id = $(this).data('employee-id');
    const training_id = $(this).data('training-id'); // Make sure your button has this

    if(!employee_id || !training_id) return alert('Invalid participant ID or training ID');

    if(!confirm('Are you sure you want to delete this participant?')) return;

    $.post('<?= base_url("pdc/trainingparticipants/deleteParticipant") ?>', 
        { employee_id, training_id, _csrf_token: CSRF_TOKEN }, 
        res => {
            if(res.success){
                participantsTable.ajax.reload(null,false);
                alert(res.message);
            } else alert(res.message || 'Failed to delete participant');
        }, 'json'
    ).fail(() => alert('Error occurred while deleting participant'));
});


  // Update selectedTrainingId on change
  $('#trainingSelect').on('change', function() {
      selectedTrainingId = $(this).val();
  });

  // Load recommended employees
  function loadRecommendations() {
      const training_id = selectedTrainingId;
      const tableBody = $('#recommendedTable tbody');

      if(!training_id) {
          tableBody.html('<tr><td colspan="5" class="text-center text-muted">Please select a training first</td></tr>');
          return;
      }

      tableBody.html('<tr><td colspan="5" class="text-center text-muted">Loading recommendations...</td></tr>');

      $.get('<?= base_url("pdc/trainingparticipants/getRecommendedEmployeesContentBased") ?>', { training_id }, res => {
          if(res.success && res.data.length > 0){
              const rows = res.data.map(e => `
                  <tr>
                      <td><strong>${e.full_name}</strong><br><small class="text-muted">${e.education}</small></td>
                      <td>${e.department_office ?? '—'}</td>
                      <td><div><strong>Skills:</strong> ${e.skills}</div><div><strong>Spec:</strong> ${e.specialization}</div></td>
                      <td><span class="badge bg-success">${e.similarity_score ?? '—'}%</span></td>
                      <td><span class="badge bg-info">${e.total_ld_trainings ?? 0}</span></td>
                      <td>
                          ${e.status === 'Cancelled'
                              ? `<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Cancelled</span>`
                              : `<button class="btn btn-sm btn-primary add-btn" data-id="${e.employee_id}" data-name="${e.full_name}"><i class="bi bi-person-plus"></i> Add</button>`}
                      </td>
                  </tr>
              `).join('');
              tableBody.html(rows);

              // Search filter
              $('#recommendedSearch').off('keyup').on('keyup', function() {
                  const value = $(this).val().toLowerCase();
                  $('#recommendedTable tbody tr').filter(function() {
                      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                  });
              });

          } else {
              tableBody.html('<tr><td colspan="5" class="text-center text-muted">No recommended employees found</td></tr>');
          }
      }).fail(() => tableBody.html('<tr><td colspan="5" class="text-center text-danger">Error fetching recommendations</td></tr>'));
  }

  $('#loadRecommendations').on('click', loadRecommendations);

  // Add participant
  $('#recommendedTable').on('click', '.add-btn', function(){
      const employee_id = $(this).data('id');
      const training_id = selectedTrainingId;

      $.post('<?= base_url("pdc/trainingparticipants/addParticipant") ?>', { employee_id, training_id, status: 'Pending', _csrf_token: CSRF_TOKEN }, res => {
          if(res.success){
              participantsTable.ajax.reload(null, false);
              Swal.fire({ icon:'success', title:'Participant Added!', timer:1500, showConfirmButton:false });
              $(this).closest('tr').remove(); // remove added row
          } else {
              Swal.fire({ icon:'error', title:'Failed', text: res.message || 'Employee already added or error occurred.' });
          }
      }, 'json');
  });
  // View cancellation reason
  $('#participantsTable tbody').on('click', '.view-cancel-reason-btn', function(){
      Swal.fire({
          title: `Cancelled Participant`,
          html: `<p><strong>Employee ID:</strong> ${$(this).data('employee-id')}</p>
                 <p><strong>Employee Name:</strong> ${$(this).data('employee-name')}</p>
                 <p><strong>Reason:</strong> ${$(this).data('reason')}</p>`,
          icon: 'info',
          confirmButtonText: 'Close'
      });
  });

  // Initial load
  loadTrainings();
});

</script>
</body>
</html>
