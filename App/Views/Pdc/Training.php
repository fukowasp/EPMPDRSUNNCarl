<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDC Training Management | SUNN</title>

<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">

<style>
/* Sidebar with updated gradient */
.sidebar { 
    width: 250px; 
    position: fixed; 
    top: 60px; 
    left: 0; 
    height: calc(100% - 70px); 
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    padding-top: 1rem; 
    overflow-y: auto;
}
.sidebar a { 
    color: white; 
    display: block; 
    padding: 12px 20px; 
    text-decoration: none; 
    transition: 0.2s; 
}
.sidebar a.active, .sidebar a:hover { 
    background: rgba(255,255,255,0.2); 
}

/* Main content */
main {
    margin-left: 250px;
    padding: 70px 20px 20px 20px;
    background: linear-gradient(120deg, #fff9e6, #ffffffff);
    min-height: 100vh;
    transition: all 0.3s ease;
}

/* Card container */
.container {
    background: rgba(255, 255, 255, 0.9);
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* DataTable styling */
table.dataTable thead {
    background: linear-gradient(90deg, #ffea85 0%, #ffc107 100%);
    color: #000;
    font-weight: 600;
}
.dataTable tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    background: linear-gradient(90deg,#fff3cd 0%,#ffe066 100%);
}
.dataTable {
    border-radius: 10px;
    overflow: hidden;
}
.dataTables_filter input {
    border-radius: 0.5rem;
    border: 1px solid #ffc107;
    padding: 0.25rem 0.5rem;
    background: #fffbea;
}
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

/* Add Training button */
.btn-add-training {
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    border: none;
    color: #fff;
    transition: 0.2s;
}
.btn-add-training:hover {
    opacity: 0.85;
}

/* Buttons */
.btn-warning {
    background: #ffc107;
    border: none;
    color: #000;
    transition: 0.2s;
}
.btn-warning:hover {
    background: #ffcd39;
    color: #000;
}

/* Responsive */
@media (max-width: 992px) {
    main { margin-left: 0; }
    table.dataTable { font-size: 0.9rem; }
}
</style>
</head>
<body class="bg-light">

<?php include dirname(__DIR__, 1) . '/partials/pdc_navbar.php'; ?>
<?php include dirname(__DIR__, 1) . '/partials/pdc_sidebar.php'; ?>

<main>
    <div class="container-fluid my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold"><i class="bi bi-journal-text me-2"></i> PDC Trainings</h3>
            <button class="btn btn-add-training" data-bs-toggle="modal" data-bs-target="#addTrainingModal">
                <i class="bi bi-plus-circle me-1"></i> Add Training
            </button>
        </div>

        <div class="card p-3 shadow-sm">
            <table id="trainingsTable" class="table table-striped table-bordered nowrap align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Category</th> 
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</main>

<!-- Add Training Modal -->
<div class="modal fade" id="addTrainingModal" tabindex="-1" aria-labelledby="addTrainingLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="addTrainingLabel"><i class="bi bi-plus-circle me-2"></i>Add Training</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addTrainingForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Training Title</label>
            <input type="text" name="training_title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="training_description" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Type</label>
            <select name="type" id="typeSelect" class="form-select" required>
              <option value="" selected disabled>Select Type</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category" id="categorySelect" class="form-select" required>
              <option value="" selected disabled>Select Category</option>
            </select>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Start Date</label>
              <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">End Date</label>
              <input type="date" name="end_date" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Location</label>
            <input type="text" name="location" class="form-control">
          </div>
          <button type="submit" class="btn btn-add-training w-100 fw-semibold">Save Training</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Training Modal -->
<div class="modal fade" id="editTrainingModal" tabindex="-1" aria-labelledby="editTrainingLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="editTrainingLabel"><i class="bi bi-pencil me-2"></i>Edit Training</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editTrainingForm">
          <input type="hidden" name="training_id" id="edit_training_id">
          <div class="mb-3">
            <label class="form-label fw-semibold">Training Title</label>
            <input type="text" name="training_title" id="edit_training_title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="training_description" id="edit_training_description" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Type</label>
            <select name="type" id="edit_type" class="form-select" required>
              <option value="" selected disabled>Select Type</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category" id="edit_category" class="form-select" required>
              <option value="" selected disabled>Select Category</option>
            </select>
          </div>

          <div class="mb-3 d-none" id="newCategoryDiv">
            <label class="form-label fw-semibold">Enter New Category</label>
            <input type="text" name="new_category" id="new_category" class="form-control" placeholder="Enter new category">
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Start Date</label>
              <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">End Date</label>
              <input type="date" name="end_date" id="edit_end_date" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Location</label>
            <input type="text" name="location" id="edit_location" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary w-100 fw-semibold">Update Training</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/responsive.bootstrap5.min.js') ?>"></script>

<script>
$(document).ready(function() {
    const table = $('#trainingsTable').DataTable({
        ajax: '<?= base_url("pdc/training/getTrainings") ?>',
        responsive: true,
        columns: [
            { data: 'training_id' },
            { data: 'training_title' },
            { data: 'training_description' },
            { data: 'type' }, 
            { data: 'category' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'location' },
            {
                data: null,
                orderable: false,
                render: (data, type, row) => `
                    <button class="btn btn-primary btn-sm edit-btn"
                        data-id="${row.training_id}"
                        data-title="${row.training_title}"
                        data-description="${row.training_description}"
                        data-type="${row.type}"
                        data-category="${row.category}"
                        data-start="${row.start_date}"
                        data-end="${row.end_date}"
                        data-location="${row.location}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${row.training_id}">
                        <i class="bi bi-trash"></i>
                    </button>
                `
            }
        ]
    });

    // Add Training
    $('#addTrainingForm').on('submit', function(e) {
        e.preventDefault();
        $.post('<?= base_url("pdc/training/addTraining") ?>', $(this).serialize(), res => {
            if (res.success) {
                $('#addTrainingModal').modal('hide');
                $('#addTrainingForm')[0].reset();
                table.ajax.reload(null, false);
                Swal.fire('Success', 'Training added successfully!', 'success');
            } else {
                Swal.fire('Error', 'Failed to save training.', 'error');
            }
        }, 'json').fail(() => Swal.fire('Error', 'Could not connect to server.', 'error'));
    });

    // Delete
    $('#trainingsTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the training permanently.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url("pdc/training/deleteTraining") ?>', { id }, res => {
                    if (res.success) {
                        table.ajax.reload(null, false);
                        Swal.fire('Deleted!', 'Training has been deleted.', 'success');
                    } else {
                        Swal.fire('Error', 'Failed to delete.', 'error');
                    }
                }, 'json').fail(() => Swal.fire('Error', 'Could not connect to server.', 'error'));
            }
        });
    });

    // Open Edit Modal
    $('#trainingsTable').on('click', '.edit-btn', function() {
        const btn = $(this);
        $('#edit_training_id').val(btn.data('id'));
        $('#edit_training_title').val(btn.data('title'));
        $('#edit_training_description').val(btn.data('description'));
        $('#edit_type').val(btn.data('type')); 
        $('#edit_category').val(btn.data('category'));
        $('#edit_start_date').val(btn.data('start'));
        $('#edit_end_date').val(btn.data('end'));
        $('#edit_location').val(btn.data('location'));
        $('#editTrainingModal').modal('show');
    });

    // Update
    $('#editTrainingForm').on('submit', function(e) {
        e.preventDefault();
        $.post('<?= base_url("pdc/training/updateTraining") ?>', $(this).serialize(), res => {
            if (res.success) {
                $('#editTrainingModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire('Success', 'Training updated successfully!', 'success');
            } else {
                Swal.fire('Error', 'Failed to update.', 'error');
            }
        }, 'json').fail(() => Swal.fire('Error', 'Could not connect to server.', 'error'));
    });

    // Show/hide new category input
    $('#categorySelect').on('change', function() {
        const isOther = $(this).val() === 'other';
        $('#newCategoryDiv').toggleClass('d-none', !isOther);
        if (!isOther) $('#new_category').val('');
    });
});

  // Load Types
  function loadTypes() {
      $.getJSON('<?= base_url("pdc/training/getTypes") ?>', function(res) {
          if(res.success){
              const options = res.data.map(t => `<option value="${t.type_name}">${t.type_name}</option>`).join('');
              $('#typeSelect, #edit_type').append(options);
          }
      });
  }

  // Load Categories
  function loadCategories() {
      $.getJSON('<?= base_url("pdc/training/getCategories") ?>', function(res) {
          if(res.success){
              const options = res.data.map(c => `<option value="${c.category_name}">${c.category_name}</option>`).join('');
              $('#categorySelect, #edit_category').append(options);
          }
      });
  }

loadTypes();
loadCategories();
</script>

</body>
</html>
