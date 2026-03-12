<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | Academic Ranks</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">
</head>
<body class="bg-light">

<?php include dirname(__DIR__,2).'/includes/admin_navbar.php'; ?>
<?php include dirname(__DIR__,2).'/includes/admin_sidebar.php'; ?>

    <div class="flex-grow-1 main-content p-4">
        <div class="d-flex justify-content-between mb-4">
            <h3><i class="bi bi-award me-2"></i>Academic Ranks</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-1"></i> Add
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="rankTable" class="table table-striped table-bordered w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Rank Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="addForm" class="modal-content">
        <?= csrf_input() ?> <!-- Use global CSRF helper -->
        <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);">
            <h5 class="modal-title">Add Academic Rank</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="text" name="rank_name" class="form-control" placeholder="Rank Name" required>
        </div>
        <div class="modal-footer flex-wrap">
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editForm" class="modal-content">
        <?= csrf_input() ?> <!-- Use global CSRF helper -->
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Edit Academic Rank</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="rank_name" id="edit_name" class="form-control" required>
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
    // Initialize DataTable
    const table = $('#rankTable').DataTable({
        ajax: '<?= base_url("admin/academicrank/getAll") ?>',
        columns: [
            { data: 'id' },
            { data: 'rank_name' },
            { data: null, render: d => `
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary btn-sm editBtn"
                            data-id="${d.id}"
                            data-name="${d.rank_name}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-sm deleteBtn"
                            data-id="${d.id}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `, orderable: false }
        ]
    });
    // -------------------- ADD --------------------
    $('#addForm').submit(function(e){
        e.preventDefault();
        const formData = $(this).serialize(); // Includes CSRF token

        $.ajax({
            url: '<?= base_url("admin/academicrank/add") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res){
                if(res.success){
                    $('#addModal').modal('hide');
                    Swal.fire({
                        icon:'success',
                        title:'Added!',
                        text:'Academic rank has been added.',
                        timer:1500,
                        showConfirmButton:false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', res.message || 'Failed to add rank.', 'error');
                }
            },
            error: function(xhr){
                const msg = xhr.responseJSON?.message || 'Server error occurred';
                Swal.fire('Error', msg, 'error');
            }
        });
    });
    // -------------------- EDIT --------------------
    $('#rankTable').on('click', '.editBtn', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_name').val($(this).data('name'));
        new bootstrap.Modal('#editModal').show();
    });
    $('#editForm').submit(function(e){
        e.preventDefault();
        const formData = $(this).serialize(); // Includes CSRF token

        $.ajax({
            url: '<?= base_url("admin/academicrank/update") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res){
                if(res.success){
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                    Swal.fire({
                        icon:'success',
                        title:'Updated!',
                        text:'Academic rank updated successfully.',
                        timer:1500,
                        showConfirmButton:false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', res.message || 'Update failed.', 'error');
                }
            },
            error: function(xhr){
                const msg = xhr.responseJSON?.message || 'Server error occurred';
                Swal.fire('Error', msg, 'error');
            }
        });
    });
    // -------------------- DELETE --------------------
    $('#rankTable').on('click', '.deleteBtn', function(e){
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'Delete this rank?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '<?= base_url("admin/academicrank/delete") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, _csrf_token: '<?= $csrf_token ?>' },
                    success: function(res){
                        if(res.success){
                            Swal.fire({
                                icon:'success',
                                title:'Deleted!',
                                text:'Academic rank has been removed.',
                                timer:1500,
                                showConfirmButton:false
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Error', res.message || 'Delete failed.', 'error');
                        }
                    },
                    error: function(xhr){
                        const msg = xhr.responseJSON?.message || 'Server error occurred';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>