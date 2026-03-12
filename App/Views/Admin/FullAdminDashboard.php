<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?= csrf_meta() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Full Admin Dashboard</title>

<!-- CSS -->
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">

<!-- JS -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/buttons.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('libs/chartjs/chart.min.js') ?>"></script>

<style>
body { margin:0; font-family:'Segoe UI', Arial, sans-serif; background:#f5f7fb; }
.header { background:linear-gradient(to right,#003a70,#0aa66c); color:#fff; padding:18px 30px; display:flex; justify-content:space-between; align-items:center; }
.header-title { font-size:22px; font-weight:bold; display:flex; align-items:center; gap:8px; }
.header-user { position:relative; display:flex; align-items:center; gap:8px; background:rgba(255,255,255,0.15); padding:8px 14px; border-radius:20px; cursor:pointer; }
.dropdown-menu-custom { position:absolute; top:110%; right:0; background:#fff; color:#333; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.15); display:none; min-width:140px; z-index:100; }
.dropdown-menu-custom a { display:flex; align-items:center; padding:10px 15px; gap:8px; text-decoration:none; color:#333; }
.dropdown-menu-custom a:hover { background:#f0f0f0; }
.container-admin { display:flex; }
.sidebar { width:260px; background:#0b2447; height:calc(100vh - 70px); color:#fff; padding-top:20px; }
.sidebar-section-title { font-size:11px; opacity:0.6; padding:10px 20px 5px; text-transform:uppercase; }
.menu-item { padding:12px 20px; display:flex; align-items:center; gap:12px; cursor:pointer; opacity:0.9; }
.menu-item:hover, .menu-item.active { background:rgba(255,255,255,0.1); opacity:1; }
.content { flex:1; padding:25px 35px; }
.hidden { display:none !important; }
.card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div class="header-title"><i class="bi bi-shield-check"></i> Full Admin Dashboard</div>
    <div class="header-user" id="userDropdown">
        <i class="bi bi-person-circle"></i> <?= htmlspecialchars($fullAdmin['username']) ?> <i class="bi bi-caret-down-fill"></i>
        <div class="dropdown-menu-custom" id="dropdownMenu">
            <a href="<?= base_url('admin/fulladmin/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</div>

<div class="container-admin">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-section-title">Overview</div>
        <div class="menu-item active" id="btnDashboard"><i class="bi bi-speedometer2"></i> Dashboard</div>
        <div class="sidebar-section-title">Accounts</div>
        <div class="menu-item" id="btnManage"><i class="bi bi-person-badge"></i> Manage Accounts</div>
    </div>

    <!-- PAGE CONTENT -->
    <div class="content">

        <!-- DASHBOARD PAGE -->
        <div id="pageDashboard">
            <h2>Dashboard Overview</h2>
            <p class="text-muted">Professional Development Center Management</p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h6 class="text-muted">ADMIN Count</h6>
                        <h3 id="adminCount"><?= $adminCount ?></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h6 class="text-muted">PDC Count</h6>
                        <h3 id="pdcCount"><?= $pdcCount ?></h3>
                    </div>
                </div>
            </div>
            <div class="card p-3 shadow-sm mt-4" style="max-width:350px;">
                <h6>Trainings & Seminars Overview</h6>
                <canvas id="roleChart"></canvas>
            </div>
        </div>

        <!-- MANAGE ACCOUNTS PAGE -->
        <div id="pageManage" class="hidden">
            <h2><i class="bi bi-people-fill"></i> Manage Accounts</h2>
            <table id="accountsTable" class="table table-striped table-bordered mt-4">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['status']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn" data-id="<?= $user['id'] ?>"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="<?= $user['id'] ?>"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- MODAL FOR ADD/EDIT USER -->
<div class="modal fade" id="userModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="accountForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editIndex">
        <div class="mb-3">
          <label>Username</label>
          <input type="text" class="form-control" id="username" required>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" class="form-control" id="password">
          <small class="text-muted">Leave empty to keep current password when editing</small>
        </div>
        <div class="mb-3">
          <label>Role</label>
          <select class="form-control" id="role">
            <option value="admin">Admin</option>
            <option value="pdc">PDC</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select class="form-control" id="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
// DROPDOWN
let csrfToken = document.querySelector('meta[name="csrf-token"]').content;


document.getElementById('userDropdown').onclick = () => {
    let menu = document.getElementById('dropdownMenu');
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
};

// NAVIGATION
const dashboardBtn = document.getElementById("btnDashboard");
const manageBtn = document.getElementById("btnManage");
const pageDashboard = document.getElementById("pageDashboard");
const pageManage = document.getElementById("pageManage");

    dashboardBtn.onclick = () => { 
        dashboardBtn.classList.add("active"); 
        manageBtn.classList.remove("active"); 
        pageDashboard.classList.remove("hidden"); 
        pageManage.classList.add("hidden"); 
    };

    manageBtn.onclick = () => { 
        manageBtn.classList.add("active"); 
        dashboardBtn.classList.remove("active"); 
        pageManage.classList.remove("hidden"); 
        pageDashboard.classList.add("hidden"); 
    };

    // DATATABLE
    let table = $('#accountsTable').DataTable({
        dom: '<"d-flex justify-content-between mb-3"<"dataTables_filter"f><"dataTables_buttons"B>>rtip',
        buttons: [{
            text: '<i class="bi bi-plus"></i> Add Account',
            className: 'btn btn-success btn-sm',
            action: function () {
                $('#modalTitle').text('Add User');
                $('#accountForm')[0].reset();
                $('#editIndex').val('');
                $('#userModal').modal('show');
            }
        }]
    });

// ADD / EDIT USER
$('#accountForm').on('submit', function(e){
    e.preventDefault();

    let id = $('#editIndex').val();
    let url = id 
        ? "<?= base_url('admin/fulladmin/updateUser') ?>" 
        : "<?= base_url('admin/fulladmin/addUser') ?>";

    let data = {
        username: $('#username').val(),
        role: $('#role').val(),
        status: $('#status').val(),
        password: $('#password').val(),
        _csrf_token: csrfToken
    };

    if(id) data.id = id;

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(res){
            // Always update CSRF token
            if(res.csrf_token) csrfToken = res.csrf_token;

            if(res.success){
                Swal.fire({
                    icon:'success',
                    title:'Success!',
                    text:res.message,
                    timer:1500,
                    showConfirmButton:false
                }).then(()=> location.reload());
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function(xhr){
            let msg = xhr.responseJSON?.message || 'An error occurred';
            Swal.fire('Error', msg, 'error');
        }
    });
});

    // EDIT BUTTON
    $('#accountsTable tbody').on('click', '.editBtn', function () {
        let id = $(this).data('id');

        $.get("<?= base_url('admin/fulladmin/getUserById') ?>", {id: id}, function(user){
            $('#modalTitle').text('Edit User');
            $('#editIndex').val(user.id);
            $('#username').val(user.username);
            $('#role').val(user.role);
            $('#status').val(user.status);
            $('#password').val('');
            $('#userModal').modal('show');
        }, 'json');
    });


   // DELETE BUTTON
    $('#accountsTable tbody').on('click', '.deleteBtn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This account will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('admin/fulladmin/deleteUser') ?>", {id: id, _csrf_token: csrfToken}, function(res){
                    csrfToken = res.csrf_token; // update CSRF
                    if(res.success){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }, 'json');
            }
        });
    });


    // CHART
    const ctx = document.getElementById("roleChart");
    new Chart(ctx, {
        type:"bar",
        data:{
            labels:["Admin","PDC"],
            datasets:[{
                data:[<?= $adminCount ?>, <?= $pdcCount ?>],
                backgroundColor:["#003a70","#0aa66c"],
                borderRadius:5
            }]
        },
        options:{plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
    });
</script>
</body>
</html>