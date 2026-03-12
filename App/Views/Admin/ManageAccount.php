<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Employee Accounts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= csrf_meta() ?>
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">
  <script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
  <style>
    .password-text { font-family: monospace; letter-spacing: .05em; }
    .pw-hidden { filter: blur(6px); }
    .btn-primary:hover { background-color: #0056b3; border-color: #0056b3; }
    .btn-danger:hover { background-color: #c82333; border-color: #c82333; }
  </style>
</head>
<body class="bg-light">
  <?php include dirname(__DIR__, 2) . '/includes/admin_navbar.php'; ?>
  <?php include dirname(__DIR__, 2) . '/includes/admin_sidebar.php'; ?>

  <div class="main-content p-4" style="margin-left: 250px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3><i class="bi bi-lock-fill me-2"></i>Manage Employee Accounts</h3>
      <div>
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#employeeModal">
            <i class="bi bi-person-plus"></i> Add Employee
          </button>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table id="accountTable" class="table table-striped table-bordered align-middle" style="width:100%">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Department</th>
                <th>Academic Rank</th>
                <th>Employment Type</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="employeeForm">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="employeeModalTitle">Add Employee Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="employee_id_hidden" name="id">

          <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="employee_id" name="employee_id" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Department/College</label>
            <select class="form-select" id="department" name="department" required>
              <option value="">Select Department/College</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Academic Rank</label>
            <select class="form-select" id="academic_rank" name="academic_rank" required>
              <option value="">Select Academic Rank</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Employment Type</label>
            <select class="form-select" id="employment_type" name="employment_type" required>
              <option value="">Select Employment Type</option>
              <option value="Permanent">Permanent</option>
              <option value="Non-Permanent">Non-Permanent</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Password <small class="text-muted">(Leave blank to keep current when editing)</small></label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="employeeModalBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script>
$(function () {
    const employeeModalEl = document.getElementById('employeeModal');

    // Get latest CSRF token from meta
    function getCsrfToken() {
        return $('meta[name="csrf-token"]').attr('content');
    }

    // Escape HTML to prevent XSS
    function escapeHtml(str) {
        return $('<div>').text(str).html();
    }

    // Unified fetch for Add/Update/Delete with CSRF
    async function jsonFetch(url, payload) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        // Update CSRF token if backend sent a new one
        if (data.csrf_token) {
            $('meta[name="csrf-token"]').attr('content', data.csrf_token);
        }
        return data;
    }
    // Initialize DataTable with XSS-safe render
    const table = $('#accountTable').DataTable({
        ajax: { url: "<?= base_url('admin/manageaccount/fetchAllJson') ?>", dataSrc: 'rows' },
        columns: [
            { data: 'id' },
            { data: 'employee_id', render: d => escapeHtml(d) },
            { data: 'department', render: d => escapeHtml(d) },
            { data: 'academic_rank', render: d => escapeHtml(d) },
            { data: 'employment_type', render: d => escapeHtml(d) },
            { data: 'created_at', render: d => escapeHtml(d) },
            {
                data: null,
                orderable: false,
                render: row => `
                    <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">
                        <i class="bi bi-trash"></i>
                    </button>
                `
            }
        ]
    });
    // Add button
    $('[data-bs-target="#employeeModal"]').on('click', async () => {
        $('#employeeForm')[0].reset();
        $('#employee_id_hidden').val('');
        $('#employeeModalTitle').text('Add Employee Account');
        $('#employeeModalBtn').text('Add');

        await loadDepartments();
        await loadAcademicRanks();
    });
    // Edit button
    $('#accountTable tbody').on('click', '.btn-edit', async function () {
        const row = table.row($(this).closest('tr')).data();
        if (!row) return;

        $('#employee_id_hidden').val(row.id);
        $('#employee_id').val(row.employee_id);
        $('#employment_type').val(row.employment_type);
        $('#password').val('');

        $('#employeeModalTitle').text('Edit Employee Account');
        $('#employeeModalBtn').text('Update');

        await loadDepartments(row.department);
        await loadAcademicRanks(row.academic_rank);

        const modal = new bootstrap.Modal(employeeModalEl);
        modal.show();
    });
    // Form Submit
    $('#employeeForm').on('submit', async function (e) {
        e.preventDefault();

        const id = $('#employee_id_hidden').val();
        const url = id
            ? "<?= base_url('admin/manageaccount/update') ?>"
            : "<?= base_url('admin/manageaccount/add') ?>";

        const payload = {
            id,
            employee_id: $('#employee_id').val().trim(),
            department: $('#department').val(),
            academic_rank: $('#academic_rank').val(),
            employment_type: $('#employment_type').val(),
            password: $('#password').val().trim()
        };

        if (!payload.employee_id || !payload.department || !payload.academic_rank || !payload.employment_type) {
            Swal.fire('Warning', 'Required fields missing', 'warning');
            return;
        }
        try {
            const data = await jsonFetch(url, payload);
            if (data.success) {
                bootstrap.Modal.getInstance(employeeModalEl)?.hide();
                table.ajax.reload(null, false);

                Swal.fire({
                    icon: 'success',
                    title: id ? 'Updated' : 'Added',
                    text: data.message,
                    timer: 1400,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', data.message || 'Operation failed', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Server error occurred', 'error');
        }
    });
    // Delete
    $('#accountTable tbody').on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        if (!id) return;

        Swal.fire({
            title: 'Delete account?',
            text: 'This cannot be undone',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d'
        }).then(async result => {
            if (!result.isConfirmed) return;

            try {
                const data = await jsonFetch("<?= base_url('admin/manageaccount/delete') ?>", { id });
                if (data.success) {
                    table.ajax.reload(null, false);
                    Swal.fire('Deleted', data.message, 'success');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Error', 'Server error occurred', 'error');
            }
        });
    });
    // Load Departments (with optional pre-select)
    async function loadDepartments(selected = '') {
        try {
            const res = await fetch("<?= base_url('admin/manageaccount/getAllDepartments') ?>", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() }
            });
            const data = await res.json();

            if (data.success) {
                const deptSelect = $('#department');
                deptSelect.empty();
                const fragment = document.createDocumentFragment();
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Department/College';
                fragment.appendChild(defaultOption);

                data.rows.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = escapeHtml(d.name);  
                    opt.textContent = escapeHtml(d.name);
                    if (d.name === selected) opt.selected = true;
                    fragment.appendChild(opt);
                });

                deptSelect.append(fragment);

                if (data.csrf_token) $('meta[name="csrf-token"]').attr('content', data.csrf_token);
            }
        } catch (err) {
            console.error(err);
        }
    }

    // Load Academic Ranks (with optional pre-select)
    async function loadAcademicRanks(selected = '') {
        try {
            const res = await fetch("<?= base_url('admin/manageaccount/getAllAcademicRanks') ?>", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() }
            });
            const data = await res.json();

            if (data.success) {
                const rankSelect = $('#academic_rank');
                rankSelect.empty();
                const fragment = document.createDocumentFragment();
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Academic Rank';
                fragment.appendChild(defaultOption);

                data.rows.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = escapeHtml(r.rank_name);
                    opt.textContent = escapeHtml(r.rank_name);
                    if (r.rank_name === selected) opt.selected = true;
                    fragment.appendChild(opt);
                });

                rankSelect.append(fragment);

                if (data.csrf_token) $('meta[name="csrf-token"]').attr('content', data.csrf_token);
            }
        } catch (err) { console.error(err); }
    }
});
</script>
</body>
</html>