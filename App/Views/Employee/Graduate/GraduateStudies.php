<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Graduate Studies</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/grad.css') ?>">
</head>
<body>

<div class="wrapper">
  <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

  <div class="content-wrapper">
    <div class="container-fluid py-4">

      <!-- Page Header -->
      <div class="page-header mb-4">
        <h1 class="page-title"><i class="bi bi-mortarboard"></i> Graduate Studies</h1>
        <p class="page-subtitle">Please provide your graduate study history</p>
      </div>

      <!-- Info Alert -->
      <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle me-2"></i>List all your graduate studies including degrees earned.
      </div>

      <!-- Graduate Studies Table -->
      <div class="form-card mb-4">
        <div class="card-body">
          <div class="text-end mb-3">
            <button class="btn btn-success" id="addGraduateStudy">
              <i class="bi bi-plus-circle me-2"></i>Add Graduate Study
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="graduate-table">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Institution</th>
                  <th>Course</th>
                  <th>Year Graduated</th>
                  <th>Units Earned</th>
                  <th>Specialization</th>
                  <th>Honors</th>
                  <th>Certification</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="graduate-container">
                <!-- Dynamic rows -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Add/Edit Modal -->
      <div class="modal fade" id="graduateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content form-card">
            <form id="graduateForm" enctype="multipart/form-data">
              <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
                <h5 class="modal-title">Add Graduate Study</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="id" name="id">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="institution_name" name="institution_name" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Graduate Course <span class="text-danger">*</span></label>
                    <select class="form-select" id="graduate_course" name="graduate_course" required>
                      <option value="">Select Graduate Course</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Year Graduated</label>
                    <input type="number" class="form-control" id="year_graduated" name="year_graduated" min="1900" max="2099" step="1">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Units Earned</label>
                    <input type="text" class="form-control" id="units_earned" name="units_earned">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Honors / Awards</label>
                    <input type="text" class="form-control" id="honor_received" name="honor_received">
                  </div>
                  <div class="col-12">
                    <label class="form-label">Proof of Certification</label>
                    <input type="file" class="form-control" id="certification_file" name="certification_file" accept="image/*,.pdf">
                    <div class="preview-container mt-2" id="cert_preview"></div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Image Preview Modal -->
      <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-body p-0">
              <img src="" id="imagePreview" style="width:100%; height:auto; display:block;">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
$(function() {
    const gradContainer = $('#graduate-container');
    const modalEl = $('#graduateModal');
    const modal = new bootstrap.Modal(modalEl);
    const imgPreviewModal = new bootstrap.Modal($('#imagePreviewModal'));
    const form = $('#graduateForm');
    const certInput = $('#certification_file');
    const certPreview = $('#cert_preview');
    const certPath = "<?= base_url('public/assets/graduate_cert/') ?>";

    // Load graduate courses into dropdown
    $.getJSON("<?= base_url('employee/eduback/graduate/getAllJson') ?>", res => {
        const select = $("#graduate_course").empty().append('<option value="">-- Select Graduate Course --</option>');
        res.data?.forEach(item => select.append(`<option value="${item.course_name}">${item.course_name}</option>`));
    });

    // Open modal to add new graduate study
    $('#addGraduateStudy').click(() => {
        form[0].reset();
        $('#id').val('');
        certPreview.html('');
        $('input[name="existing_file"]').remove();
        modalEl.find('.modal-title').text('Add Graduate Study');
        modal.show();
    });

    // Edit graduate study
    gradContainer.on('click', '.edit-grad', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        if(!id) return;

        Swal.fire({title:'Loading...', allowOutsideClick:false, didOpen:()=>Swal.showLoading()});
        $.getJSON("<?= base_url('employee/eduback/graduate/get') ?>", {id}, res => {
            Swal.close();
            if(res.success && res.data){
                const g = res.data;
                $('#id').val(g.id);
                $('#institution_name').val(g.institution_name);
                $('#graduate_course').val(g.graduate_course);
                $('#year_graduated').val(g.year_graduated);
                $('#units_earned').val(g.units_earned);
                $('#specialization').val(g.specialization);
                $('#honor_received').val(g.honor_received);

                if(g.certification_file){
                    const html = g.certification_file.endsWith('.pdf')
                        ? `<a href="${certPath}${g.certification_file}" target="_blank"><i class="bi bi-file-earmark-pdf"></i> View PDF</a>`
                        : `<img src="${certPath}${g.certification_file}" class="shadow-sm rounded" style="max-width:120px;">`;
                    certPreview.html(html);
                    if(!$('input[name="existing_file"]').length) form.append(`<input type="hidden" name="existing_file" value="${g.certification_file}">`);
                    else $('input[name="existing_file"]').val(g.certification_file);
                } else {
                    certPreview.html('');
                    $('input[name="existing_file"]').remove();
                }

                modalEl.find('.modal-title').text('Edit Graduate Study');
                modal.show();
            } else {
                Swal.fire('Error', res.message || 'Failed to fetch record', 'error');
            }
        });
    });

    // Delete graduate study
    gradContainer.on('click', '.remove-grad', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const file = row.data('file') || '';
        if(!id) return Swal.fire('Error', 'Invalid record ID', 'error');

        Swal.fire({
            title: 'Delete this record?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if(result.isConfirmed){
                $.ajax({
                    url: '<?= base_url("employee/eduback/graduate/delete") ?>',
                    method: 'POST',
                    data: {id, file},
                    dataType: 'json',
                    success: function(res){
                        if(res.success){
                            Swal.fire('Deleted!', res.message, 'success');
                            loadTable(); // refresh table
                        } else {
                            Swal.fire('Error!', res.message || 'Delete failed!', 'error');
                        }
                    },
                    error: function(){
                        Swal.fire('Error!', 'Unexpected error occurred while deleting.', 'error');
                    }
                });
            }
        });
    });

    // Preview file before upload
    certInput.on('change', function(e){
        const file = e.target.files[0];
        if(!file) return certPreview.html('');
        if(file.type.startsWith('image/')){
            certPreview.html(`<img src="${URL.createObjectURL(file)}" style="max-width:150px;" class="shadow-sm rounded">`);
        } else {
            certPreview.html(`<span class="text-muted fst-italic">${file.name}</span>`);
        }
    });

    // Image preview modal
    gradContainer.on('click', '.clickable-img', function() {
        $('#imagePreview').attr('src', $(this).attr('src'));
        imgPreviewModal.show();
    });

    // Save form
    form.on('submit', function(e){
        e.preventDefault();
        const data = new FormData(this);
        Swal.fire({title:'Saving...', text:'Please wait...', allowOutsideClick:false, didOpen:()=>Swal.showLoading()});

        $.ajax({
            url: '<?= base_url("employee/eduback/graduate/save") ?>',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res){
                Swal.close();
                if(res.success){
                    modal.hide();
                    loadTable();
                    form[0].reset();
                    certPreview.html('');
                    $('input[name="existing_file"]').remove();
                    Swal.fire({icon:'success', title:'Saved!', text: res.message, timer:1500, showConfirmButton:false});
                } else {
                    Swal.fire('Error!', res.message || 'Save failed!', 'error');
                }
            },
            error: function(xhr, status, error){
                Swal.close();
                console.error('Save error:', status, error, xhr.responseText);
                Swal.fire('Error!', 'Unexpected error occurred while saving.', 'error');
            }
        });
    });

    // Load graduate studies table
    function loadTable(){
        $.getJSON("<?= base_url('employee/eduback/graduate/get') ?>", res => {
            gradContainer.empty();
            if(!res.data || !res.data.length){
                gradContainer.append(`<tr><td colspan="9" class="text-center text-muted py-3">
                    <i class="bi bi-exclamation-circle"></i> No graduate studies found
                </td></tr>`);
                return;
            }
            res.data.forEach((grad, i) => {
                const certFile = grad.certification_file || '';
                const certHtml = certFile
                    ? (certFile.endsWith('.pdf')
                        ? `<a href="${certPath}${certFile}" target="_blank"><i class="bi bi-file-earmark-pdf"></i> View PDF</a>`
                        : `<img src="${certPath}${certFile}" class="grad-cert-img shadow-sm rounded clickable-img" style="max-width:100px; cursor:pointer;">`)
                    : '<span class="text-muted fst-italic">No file</span>';

                gradContainer.append(`
                    <tr data-id="${grad.id}" data-file="${certFile}">
                        <td>${i+1}</td>
                        <td>${grad.institution_name}</td>
                        <td>${grad.graduate_course}</td>
                        <td>${grad.year_graduated ?? ''}</td>
                        <td>${grad.units_earned ?? ''}</td>
                        <td>${grad.specialization ?? ''}</td>
                        <td>${grad.honor_received ?? ''}</td>
                        <td>${certHtml}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-primary edit-grad me-1"><i class="bi bi-pencil"></i></button>
                            <button type="button" class="btn btn-sm btn-danger remove-grad"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `);
            });
        });
    }

    // Initial load
    loadTable();
});
</script>

</body>
</html>
