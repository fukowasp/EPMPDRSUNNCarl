<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Learning and Development Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/sweetalert2/dist/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/learning-development.css') ?>">
</head>
<body>

<div class="wrapper">
  <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

  <div class="content-wrapper">
    <div class="container-fluid py-4">

      <!-- Page Header -->
      <div class="page-header mb-4">
        <h1 class="page-title"><i class="bi bi-book"></i> Learning and Development</h1>
        <p class="page-subtitle">Please provide your training and development history</p>
      </div>

      <!-- Info Alert -->
      <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle me-2"></i>List all your learning and development interventions, including training programs.
      </div>

      <!-- LD Table Card -->
      <div class="form-card mb-4">
        <div class="card-body">
          <div class="text-end mb-3">
            <button class="btn btn-success" id="addLearningDevelopment">
              <i class="bi bi-plus-circle me-2"></i>Add Training Program
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="ld-table">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Hours</th>
                  <th>Type</th>
                  <th>Sponsored By</th>
                  <th>Certification</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="ld-container">
                <!-- Dynamic LD entries will appear here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <!-- Image Preview Modal -->
      <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Image Preview</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
              <img src="" id="imagePreview" style="width:100%; height:auto; display:block;">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- PDF Viewer Modal -->
      <div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 90vw;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="bi bi-file-pdf me-2"></i>PDF Viewer</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh;">
              <iframe id="pdfViewer" style="width:100%; height:100%; border:none;"></iframe>
            </div>
            <div class="modal-footer">
              <a href="" id="pdfDownloadLink" class="btn btn-primary" target="_blank" download>
                <i class="bi bi-download me-2"></i>Download PDF
              </a>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Add/Edit LD Modal -->
      <div class="modal fade" id="learningDevelopmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content form-card">
            <form id="learningDevelopmentForm" enctype="multipart/form-data">
              
              <!-- Modal Header -->
              <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
                <h5 class="modal-title" id="learningDevelopmentModalLabel">Add Training Program</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal Body -->
              <div class="modal-body">
                <input type="hidden" id="ld_id" name="ld_id">

                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label">Title of Training Program <span class="required">*</span></label>
                    <input type="text" class="form-control" id="ld_title" name="ld_title" required>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Inclusive Dates - From <span class="required">*</span></label>
                    <input type="date" class="form-control" id="ld_date_from" name="ld_date_from" required>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Inclusive Dates - To <span class="required">*</span></label>
                    <input type="date" class="form-control" id="ld_date_to" name="ld_date_to" required>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Number of Hours <span class="required">*</span></label>
                    <input type="number" class="form-control" id="ld_hours" name="ld_hours" required min="1">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Type of LD <span class="required">*</span></label>
                    <select class="form-select" id="ld_type" name="ld_type" required>
                      <option value="">Select Type</option>
                      <option>Managerial</option>
                      <option>Supervisory</option>
                      <option>Technical</option>
                      <option>Leadership</option>
                      <option>Professional</option>
                      <option>Skills Development</option>
                      <option>Other</option>
                    </select>
                  </div>

                  <div class="col-12">
                    <label class="form-label">Conducted/Sponsored By <span class="required">*</span></label>
                    <input type="text" class="form-control" id="ld_sponsor" name="ld_sponsor" required>
                  </div>

                  <div class="col-12">
                    <label class="form-label">Proof of Certification <span class="text-muted" id="cert-required-label">*</span></label>
                    <input type="file" class="form-control" id="ld_certification" name="ld_certification" accept="image/*,.pdf">
                    <small class="text-muted">Accepted formats: JPG, PNG, GIF, PDF (Max 5MB)</small>
                    <div class="preview-container mt-2" id="ld_cert_preview"></div>
                  </div>
                </div>
              </div>

              <!-- Modal Footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveLD">
                  <span class="spinner-border spinner-border-sm me-2 d-none" id="saveSpinner"></span>
                  <span id="saveBtnText">Save</span>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
$(function() {
    const ldContainer = $('#ld-container');
    const modal = new bootstrap.Modal($('#learningDevelopmentModal'));
    const imageModal = new bootstrap.Modal($('#imagePreviewModal'));
    const pdfModal = new bootstrap.Modal($('#pdfViewerModal'));
    const imagePreview = $('#imagePreview');
    const pdfViewer = $('#pdfViewer');
    const pdfDownloadLink = $('#pdfDownloadLink');
    const certInput = $('#ld_certification');
    const certPreview = $('#ld_cert_preview');
    const saveBtn = $('#saveLD');
    const saveSpinner = $('#saveSpinner');
    const saveBtnText = $('#saveBtnText');
    let isEditing = false;

    // Refresh table
    function refreshTable(data) {
        ldContainer.html('');
        if (data.length === 0) {
            ldContainer.append(`
                <tr>
                    <td colspan="9" class="text-center text-muted">No training programs added yet</td>
                </tr>
            `);
            return;
        }
        
        data.forEach((ld, i) => {
            const certDisplay = ld.ld_certification
                ? (ld.ld_certification.endsWith('.pdf')
                    ? `<button class="btn btn-sm btn-outline-primary view-pdf-btn" data-pdf="<?= base_url('assets/learndev/') ?>${ld.ld_certification}">
                         <i class="bi bi-file-pdf me-1"></i> View PDF
                       </button>`
                    : `<img src="<?= base_url('assets/learndev/') ?>${ld.ld_certification}" class="clickable-img" style="max-width:100px; cursor:pointer; border-radius:4px;">`)
                : '<span class="text-muted">N/A</span>';
            ldContainer.append(`
                <tr>
                    <td>${i+1}</td>
                    <td>${escapeHtml(ld.ld_title)}</td>
                    <td>${ld.ld_date_from}</td>
                    <td>${ld.ld_date_to}</td>
                    <td>${ld.ld_hours}</td>
                    <td>${escapeHtml(ld.ld_type)}</td>
                    <td>${escapeHtml(ld.ld_sponsor)}</td>
                    <td>${certDisplay}</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary edit-ld" data-id="${ld.id}" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger remove-ld" data-id="${ld.id}" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Table image click → open modal
    ldContainer.on('click', '.clickable-img', function() {
        const src = $(this).attr('src');
        imagePreview.attr('src', src);
        imageModal.show();
    });

    // View PDF button click → open PDF viewer modal
    ldContainer.on('click', '.view-pdf-btn', function() {
        const pdfUrl = $(this).data('pdf');
        pdfViewer.attr('src', pdfUrl);
        pdfDownloadLink.attr('href', pdfUrl);
        pdfModal.show();
    });

    // Clear PDF viewer when modal closes
    $('#pdfViewerModal').on('hidden.bs.modal', function() {
        pdfViewer.attr('src', '');
    });

    // Preview uploaded file in modal
    certInput.on('change', function() {
        const file = this.files[0];
        if (!file) {
            certPreview.html('');
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire('Error', 'File size exceeds 5MB limit', 'error');
            $(this).val('');
            certPreview.html('');
            return;
        }

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                certPreview.html(`<img src="${e.target.result}" style="max-width:150px; border-radius:4px;">`);
            }
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            const fileUrl = URL.createObjectURL(file);
            certPreview.html(`
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary preview-pdf-btn" data-pdf-url="${fileUrl}">
                        <i class="bi bi-file-pdf me-1"></i> Preview PDF
                    </button>
                    <span class="text-muted">${file.name}</span>
                </div>
            `);
        } else {
            certPreview.html('<span class="text-muted">File preview not available</span>');
        }
    });

    // Preview PDF from file upload
    certPreview.on('click', '.preview-pdf-btn', function() {
        const pdfUrl = $(this).data('pdf-url');
        pdfViewer.attr('src', pdfUrl);
        pdfDownloadLink.hide(); // Hide download for preview
        pdfModal.show();
        
        // Show download link again when modal closes
        $('#pdfViewerModal').one('hidden.bs.modal', function() {
            pdfDownloadLink.show();
        });
    });

    // Load table from backend
    function loadLDTable() {
        $.getJSON("<?= base_url('employee/learndev/get') ?>", function(res) {
            if (res.success) {
                // Sort by 'From' date descending (latest first)
                res.data.sort((a, b) => new Date(b.ld_date_from) - new Date(a.ld_date_from));
                refreshTable(res.data);
            }
        }).fail(function() {
            Swal.fire('Error', 'Failed to load data', 'error');
        });
    }
    loadLDTable();

    // Open modal for new LD
    $('#addLearningDevelopment').click(function() {
        isEditing = false;
        $('#learningDevelopmentForm')[0].reset();
        $('#ld_id').val('');
        certPreview.html('');
        $('#learningDevelopmentModalLabel').text('Add Training Program');
        $('#cert-required-label').text('*');
        certInput.prop('required', true);
        modal.show();
    });

    // Delete LD
    ldContainer.on('click', '.remove-ld', function() {
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.post("<?= base_url('employee/learndev/delete') ?>", {id: id}, function(res) {
                    if(res.success) {
                        loadLDTable();
                        Swal.fire('Deleted!', res.message, 'success');
                    } else {
                        Swal.fire('Error', res.error || 'Failed to delete record', 'error');
                    }
                }, 'json').fail(function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.error || 'Something went wrong', 'error');
                });
            }
        });
    });

    // Save LD (add/edit)
    $('#learningDevelopmentForm').submit(function(e) {
        e.preventDefault();
        
        // Validate dates
        const dateFrom = new Date($('#ld_date_from').val());
        const dateTo = new Date($('#ld_date_to').val());
        
        if (dateFrom > dateTo) {
            Swal.fire('Error', 'End date must be after start date', 'error');
            return;
        }

        // Check if file is required (for new entries)
        if (!isEditing && !certInput[0].files.length) {
            Swal.fire('Error', 'Please upload a certification document', 'error');
            return;
        }

        // Show loading
        saveBtn.prop('disabled', true);
        saveSpinner.removeClass('d-none');
        saveBtnText.text('Saving...');

        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url("employee/learndev/save") ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if(res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#learningDevelopmentForm')[0].reset();
                    certPreview.html('');
                    modal.hide();
                    loadLDTable();
                } else {
                    Swal.fire('Error', res.error || 'Something went wrong', 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.error || 'Something went wrong', 'error');
            },
            complete: function() {
                saveBtn.prop('disabled', false);
                saveSpinner.addClass('d-none');
                saveBtnText.text('Save');
            }
        });
    });

    // Edit LD
    ldContainer.on('click', '.edit-ld', function() {
        isEditing = true;
        const id = $(this).data('id');
        
        // Show loading
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.getJSON(`<?= base_url('employee/learndev/get') ?>?id=${id}`, function(res) {
            Swal.close();
            
            if(res.success) {
                const ld = res.data;
                $('#ld_id').val(ld.id);
                $('#ld_title').val(ld.ld_title);
                $('#ld_date_from').val(ld.ld_date_from);
                $('#ld_date_to').val(ld.ld_date_to);
                $('#ld_hours').val(ld.ld_hours);
                $('#ld_type').val(ld.ld_type);
                $('#ld_sponsor').val(ld.ld_sponsor);
                
                // Update modal title
                $('#learningDevelopmentModalLabel').text('Edit Training Program');
                
                // Make certification optional for editing
                $('#cert-required-label').text('(Optional - leave empty to keep current)');
                certInput.prop('required', false);
                
                // Show existing certification
                if(ld.ld_certification) {
                    const certUrl = `<?= base_url('assets/learndev/') ?>${ld.ld_certification}`;
                    if(ld.ld_certification.endsWith('.pdf')) {
                        certPreview.html(`
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="bi bi-file-pdf me-2"></i>Current certification: 
                                        <strong>${ld.ld_certification}</strong>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary view-current-pdf" data-pdf="${certUrl}">
                                        <i class="bi bi-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        `);
                    } else {
                        certPreview.html(`
                            <div class="alert alert-info">
                                <div><i class="bi bi-image me-2"></i>Current certification:</div>
                                <img src="${certUrl}" style="max-width:150px; border-radius:4px; cursor:pointer;" class="mt-2 clickable-current-img">
                            </div>
                        `);
                    }
                } else {
                    certPreview.html('');
                }
                
                modal.show();
            } else {
                Swal.fire('Error', res.error || 'Failed to load record', 'error');
            }
        }).fail(function(xhr) {
            Swal.close();
            Swal.fire('Error', xhr.responseJSON?.error || 'Failed to load record', 'error');
        });
    });

    // View current PDF in edit mode
    certPreview.on('click', '.view-current-pdf', function() {
        const pdfUrl = $(this).data('pdf');
        pdfViewer.attr('src', pdfUrl);
        pdfDownloadLink.attr('href', pdfUrl);
        pdfModal.show();
    });

    // View current image in edit mode
    certPreview.on('click', '.clickable-current-img', function() {
        const src = $(this).attr('src');
        imagePreview.attr('src', src);
        imageModal.show();
    });
});
</script>
</body>
</html>