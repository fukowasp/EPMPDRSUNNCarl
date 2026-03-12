<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | Department / Offices</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">

<style>
  .dataTables_wrapper { width: 100% !important; overflow-x: auto; }
  table.dataTable { width: 100% !important; table-layout: auto !important; }
  table.dataTable td, table.dataTable th { white-space: nowrap; }
  table.dataTable td:last-child { text-align: center; min-width: 120px; }
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
      <h3><i class="bi bi-building me-2"></i>Department / Offices</h3>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle me-1"></i> Add
      </button>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table id="depofficesTable" class="table table-striped table-bordered align-middle w-100">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="addForm" class="modal-content">
      <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);">
        <h5 class="modal-title">Add Department / Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer flex-wrap">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="editForm" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Department / Office</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="dept_id" id="edit_id">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" id="edit_name" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer flex-wrap">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>

<script>
$(function() {
const table = $('#depofficesTable').DataTable({
    ajax: '<?= base_url("admin/depoffices/getAll") ?>', // <- matches your controller
    columns: [
        { data: 'dept_id' },
        { data: 'name' },
        { data: null, orderable: false, render: data => `
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-primary btn-sm editBtn" 
                    data-id="${data.dept_id}" data-name="${data.name}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-danger btn-sm deleteBtn" 
                    data-id="${data.dept_id}"><i class="bi bi-trash"></i></button>
            </div>
        `}
    ],
    responsive: true,
    pageLength: 25
});

  // Add
    $('#addForm').submit(function(e){
      e.preventDefault(); // prevent normal form submit

      $.post('<?= base_url("admin/depoffices/add") ?>', $(this).serialize(), res => {
          if (res.success) {
              $('#addModal').modal('hide');  // hide modal
              table.ajax.reload();            // reload DataTable
              $('#addForm')[0].reset();       // reset form

              Swal.fire({
                  icon: 'success',
                  title: 'Added!',
                  text: 'Department / Office added successfully',
                  timer: 1500,
                  showConfirmButton: false
              });
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Failed',
                  text: res.error || 'Unable to add record'
              });
          }
      }, 'json').fail(function(xhr){
          Swal.fire({
              icon: 'error',
              title: 'Server Error',
              text: xhr.responseText || 'Something went wrong'
          });
      });
  });


  // Edit modal
$('#depofficesTable').on('click', '.editBtn', function() {
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));

    // Initialize and show Bootstrap modal
    const editModalEl = document.getElementById('editModal');
    const editModal = new bootstrap.Modal(editModalEl);
    editModal.show();

    // Store reference to use when hiding after update
    $('#editForm').data('bs.modal', editModal);
});


  // Update
$('#editForm').submit(function(e){
    e.preventDefault();
    const modalInstance = $(this).data('bs.modal'); // get stored modal instance

    $.post('<?= base_url("admin/depoffices/update") ?>', $(this).serialize(), res => {
      if (res.success) {
        if (modalInstance) modalInstance.hide();
        table.ajax.reload();

        Swal.fire({
          icon: 'success',
          title: 'Updated!',
          text: 'Department / Office updated successfully',
          timer: 1500,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Failed',
          text: res.error || 'Unable to update record'
        });
      }
    }, 'json');
});


  // Delete
  $('#depofficesTable').on('click', '.deleteBtn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This record will be permanently deleted',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('<?= base_url("admin/depoffices/delete") ?>', { dept_id: id }, res => {
          if (res.success) {
            table.ajax.reload();

            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'Department / Office has been deleted',
              timer: 1500,
              showConfirmButton: false
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Failed',
              text: res.error || 'Unable to delete record'
            });
          }
        }, 'json');
      }
    });
  });
});
</script>

</body>
</html>
