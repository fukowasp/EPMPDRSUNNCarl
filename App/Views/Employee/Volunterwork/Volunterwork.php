<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Voluntary Work | SUNN</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/volunterwork.css') ?>">
</head>
<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="page-title"><i class="bi bi-heart"></i> Voluntary Work</h1>
                <p class="page-subtitle">List all your voluntary work, civic welfare, and community service activities</p>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>Please include organization name, address, position, number of hours, period of service, and proof of participation.
            </div>

            <!-- Voluntary Work Table -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <button class="btn btn-success" id="addVoluntaryBtn">
                            <i class="bi bi-plus-circle me-2"></i>Add Voluntary Work
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="voluntaryTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Organization</th>
                                    <th>Address</th>
                                    <th>Position/Role</th>
                                    <th>Hours</th>
                                    <th>Period</th>
                                    <th>Proof</th>
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

<!-- Image/PDF Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">File Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center p-0" style="min-height: 400px;">
        <img src="" id="imagePreview" class="img-fluid d-none" style="max-height: 80vh;">
        <iframe id="pdfPreview" class="d-none" style="width: 100%; height: 80vh;" frameborder="0"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Voluntary Work Modal -->
<div class="modal fade" id="voluntaryModal" tabindex="-1" aria-labelledby="voluntaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content form-card">
      <form id="voluntaryForm" enctype="multipart/form-data">
        
        <!-- Modal Header -->
        <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
          <h5 class="modal-title" id="voluntaryModalLabel">Add Voluntary Work</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <input type="hidden" name="id" id="voluntary_id">
          <input type="hidden" name="existing_files" id="existing_files">

          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">Organization Name <span class="required">*</span></label>
              <input type="text" class="form-control" name="organization_name" id="organization_name" required>
            </div>

            <div class="col-12">
              <label class="form-label">Organization Address</label>
              <textarea class="form-control" name="organization_address" id="organization_address" rows="2"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">Position/Role <span class="required">*</span></label>
              <input type="text" class="form-control" name="position_role" id="position_role" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Number of Hours <span class="required">*</span></label>
              <input type="number" class="form-control" name="number_of_hours" id="number_of_hours" min="1" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Period of Service - From</label>
              <input type="date" class="form-control" name="service_from" id="service_from">
            </div>

            <div class="col-md-6">
              <label class="form-label">Period of Service - To</label>
              <input type="date" class="form-control" name="service_to" id="service_to">
            </div>

            <div class="col-12">
              <label class="form-label">Proof of Membership/Participation (Images/PDF)</label>
              <input type="file" class="form-control" name="proof_files[]" id="proof_files" multiple accept="image/*,.pdf">
              <small class="text-muted">You can upload images (JPG, PNG, GIF) or PDF files</small>
              <div class="preview-container mt-2"></div>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer form-actions">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="saveVoluntaryBtn">Save</button>
        </div>

      </form>
    </div>
  </div>
</div>


<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script>
$(function(){
    const getUrl = "<?= base_url('employee/volunterwork/get') ?>";
    const saveUrl = "<?= base_url('employee/volunterwork/save') ?>";
    const deleteUrl = "<?= base_url('employee/volunterwork/deleteWork') ?>";
    const baseFileUrl = "<?= base_url('public/assets/voluntarywork/') ?>";

    const tableBody = $('#voluntaryTable tbody');

    // Helper function to determine file type
    function getFileType(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        return ['jpg', 'jpeg', 'png', 'gif'].includes(ext) ? 'image' : 'pdf';
    }

    // Render file previews (images and PDFs) with remove option
    function renderPreviews(fileStr) {
        const container = $('.preview-container');
        container.empty();
        if(!fileStr) return;

        const files = fileStr.split(',').filter(f => f.trim());
        files.forEach(f => {
            f = f.trim();
            if(!f) return;
            const url = baseFileUrl + f;
            const fileType = getFileType(f);

            if (fileType === 'image') {
                container.append(`
                    <div class="d-inline-block position-relative me-2 mb-2">
                        <img src="${url}" class="clickable-file border rounded" 
                            style="height:70px;width:70px;object-fit:cover;cursor:pointer;" 
                            title="Click to preview">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-file" 
                            data-file="${f}" style="padding:2px 6px;font-size:10px;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `);
            } else {
                container.append(`
                    <div class="d-inline-block position-relative me-2 mb-2">
                        <div class="clickable-file border rounded d-flex align-items-center justify-content-center bg-light" 
                            data-url="${url}" data-type="pdf"
                            style="height:70px;width:70px;cursor:pointer;" 
                            title="Click to preview PDF">
                            <i class="bi bi-file-pdf text-danger" style="font-size:30px;"></i>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-file" 
                            data-file="${f}" style="padding:2px 6px;font-size:10px;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `);
            }
        });
    }

    // Remove file from existing files
    $(document).on('click', '.remove-file', function() {
        const fileToRemove = $(this).data('file');
        let existingFiles = $('#existing_files').val().split(',').filter(f => f.trim());
        existingFiles = existingFiles.filter(f => f !== fileToRemove);
        $('#existing_files').val(existingFiles.join(','));
        renderPreviews(existingFiles.join(','));
    });

    // Load table with clickable images/PDFs
    function loadVoluntaryWork(){
        $.getJSON(getUrl, function(res){
            tableBody.empty();
            const works = res.voluntarywork || [];

            works.sort((a, b) => {
                const dateA = a.end_date ? new Date(a.end_date) : new Date(a.start_date);
                const dateB = b.end_date ? new Date(b.end_date) : new Date(b.start_date);
                return dateB - dateA; 
            });

            if(works.length){
                works.forEach((item, index) => {
                    const period = item.start_date && item.end_date ? `${item.start_date} to ${item.end_date}` : '';
                    const files = (item.membership_id_url || '').split(',').filter(f => f.trim());

                    const proofs = files.map(f => {
                        f = f.trim();
                        if(!f) return '';
                        const url = baseFileUrl + f;
                        const fileType = getFileType(f);

                        if (fileType === 'image') {
                            return `<img src="${url}" class="clickable-file me-1 mb-1 border rounded" 
                                        style="height:50px;width:50px;object-fit:cover;cursor:pointer;" 
                                        title="Click to preview">`;
                        } else {
                            return `<div class="clickable-file d-inline-block me-1 mb-1 border rounded bg-light text-center" 
                                        data-url="${url}" data-type="pdf"
                                        style="height:50px;width:50px;cursor:pointer;padding:10px;" 
                                        title="Click to preview PDF">
                                        <i class="bi bi-file-pdf text-danger" style="font-size:25px;"></i>
                                    </div>`;
                        }
                    }).join('');

                    tableBody.append(`
                        <tr>
                            <td>${index+1}</td>
                            <td>${item.organization_name || ''}</td>
                            <td>${item.organization_address || ''}</td>
                            <td>${item.position_role || ''}</td>
                            <td>${item.number_of_hours || ''}</td>
                            <td>${period}</td>
                            <td>${proofs}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editBtn" data-id="${item.id}"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${item.id}"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    // Add new entry
    $('#addVoluntaryBtn').click(function(){
        $('#voluntaryForm')[0].reset();
        $('#voluntary_id, #existing_files').val('');
        $('.preview-container').empty();
        $('#voluntaryModalLabel').text('Add Voluntary Work');
        $('#voluntaryModal').modal('show');
    });

    // Edit entry - FIXED: Now properly loads all data
    $(document).on('click', '.editBtn', function(){
        const id = $(this).data('id');
        $.getJSON(getUrl + '?id=' + id, function(res){
            if (res.success && res.data) {
                const item = res.data;
                $('#voluntary_id').val(item.id);
                $('#existing_files').val(item.membership_id_url || '');
                $('#organization_name').val(item.organization_name || '');
                $('#organization_address').val(item.organization_address || '');
                $('#position_role').val(item.position_role || '');
                $('#number_of_hours').val(item.number_of_hours || '');
                $('#service_from').val(item.start_date || '');
                $('#service_to').val(item.end_date || '');
                renderPreviews(item.membership_id_url || '');
                $('#voluntaryModalLabel').text('Edit Voluntary Work');
                $('#voluntaryModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load data'
                });
            }
        });
    });

    // Delete entry
    $(document).on('click', '.deleteBtn', function(){
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This entry will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.post(deleteUrl, {id}, function(res){
                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Deleted!' : 'Failed',
                        text: res.message
                    });
                    if(res.success) loadVoluntaryWork();
                }, 'json');
            }
        });
    });

    // Save form
    $('#voluntaryForm').submit(function(e){
        e.preventDefault();
        const formData = new FormData(this);
        formData.set('existing_files', $('#existing_files').val());

        $.ajax({
            url: saveUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res){
                if(res.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        // Refresh the page after success message
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: res.message
                    });
                }
            },
            error: function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'An error occurred while saving.'
                });
            }
        });
    });

    // File preview (both images and PDFs)
    $(document).on('click', '.clickable-file', function() {
        const $this = $(this);
        
        if ($this.is('img')) {
            // Image preview
            const src = $this.attr('src');
            $('#imagePreview').attr('src', src).removeClass('d-none');
            $('#pdfPreview').addClass('d-none');
        } else {
            // PDF preview
            const url = $this.data('url');
            $('#pdfPreview').attr('src', url).removeClass('d-none');
            $('#imagePreview').addClass('d-none');
        }
        
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    });

    // Clear modal on close
    $('#previewModal').on('hidden.bs.modal', function() {
        $('#imagePreview').attr('src', '').addClass('d-none');
        $('#pdfPreview').attr('src', '').addClass('d-none');
    });

    // Initial load
    loadVoluntaryWork();
});
</script>
</body>
</html>