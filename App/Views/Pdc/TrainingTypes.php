<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Training Types | SUNN</title>

  <!-- Bootstrap + Icons -->
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">

  <!-- Custom Dashboard CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/pdc/pdcdashboard.css') ?>">
</head>

<body class="bg-light">
<?php include dirname(__DIR__, 1) . '/partials/pdc_navbar.php'; ?>
<?php include dirname(__DIR__, 1) . '/partials/pdc_sidebar.php'; ?>

<main>
  <div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold text-dark">
        <i class="bi bi-list-ul"></i> Training Types
      </h3>
      <button class="btn btn-primary" id="btnAdd">
        <i class="bi bi-plus-lg"></i> Add Type
      </button>
    </div>

    <div class="card p-3 shadow-sm">
      <table id="typesTable" class="table table-striped table-bordered nowrap align-middle w-100">
        <thead>
          <tr>
            <th>ID</th>
            <th>Type Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="typeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="typeForm">
        <?= csrf_input() ?>
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fw-bold">Add Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label class="form-label fw-semibold">Type Name</label>
            <input type="text" name="type_name" id="type_name" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/responsive.bootstrap5.min.js') ?>"></script>

<script>
$(function () {
  const csrfToken = '<?= csrf_token() ?>';

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': csrfToken,
      'X-Requested-With': 'XMLHttpRequest'
    }
  });

  const table = $('#typesTable').DataTable({
    responsive: true,
    ajax: {
      url: '<?= base_url("pdc/trainingtypes/fetch") ?>',
      type: 'GET',
      dataSrc: 'data',
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      }
    },
    columns: [
      { data: 'id' },
      { data: 'type_name' },
      {
        data: null,
        render: (data, type, row) => `
          <button class="btn btn-sm btn-warning editBtn" data-id="${row.id}" data-name="${row.type_name}">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">
            <i class="bi bi-trash"></i>
          </button>
        `
      }
    ]
  });

  // ➕ Add
  $('#btnAdd').on('click', () => {
    $('#typeForm')[0].reset();
    $('#id').val('');
    $('.modal-title').text('Add Type');
    $('#typeModal').modal('show');
  });

  // 💾 Save (Add or Update)
  $('#typeForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize() + '&_csrf_token=' + encodeURIComponent(csrfToken);
    const id = $('#id').val();
    const url = id
      ? '<?= base_url("pdc/trainingtypes/update") ?>'
      : '<?= base_url("pdc/trainingtypes/store") ?>';

    $.post(url, formData, res => {
      const r = typeof res === 'string' ? JSON.parse(res) : res;
      Swal.fire({
        icon: r.status,
        title: r.message,
        timer: 1500,
        showConfirmButton: false
      });
      if (r.status === 'success') {
        $('#typeModal').modal('hide');
        table.ajax.reload(null, false);
      }
    });
  });

  // ✏️ Edit
  $('#typesTable').on('click', '.editBtn', function () {
    $('#id').val($(this).data('id'));
    $('#type_name').val($(this).data('name'));
    $('.modal-title').text('Edit Type');
    $('#typeModal').modal('show');
  });

  // 🗑️ Delete
  $('#typesTable').on('click', '.deleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Delete this training type?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      confirmButtonColor: '#d33'
    }).then(res => {
      if (res.isConfirmed) {
        $.post('<?= base_url("pdc/trainingtypes/delete") ?>', { id, _csrf_token: csrfToken }, res => {
          const r = typeof res === 'string' ? JSON.parse(res) : res;
          Swal.fire({
            icon: r.status,
            title: r.message,
            timer: 1500,
            showConfirmButton: false
          });
          table.ajax.reload(null, false);
        });
      }
    });
  });
});
</script>

</body>
</html>
