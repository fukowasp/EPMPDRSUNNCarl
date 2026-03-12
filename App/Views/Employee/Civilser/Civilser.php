<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Civil Service Eligibility</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/civilser.css') ?>">

    <style>
        .preview-img { max-width: 100px; border-radius: 6px; }
        .preview-pdf { font-size: 14px; color: #d9534f; }
    </style>
</head>

<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="page-title"><i class="bi bi-award"></i> Civil Service Eligibility</h1>
                <p class="page-subtitle">Please provide your civil service eligibility information</p>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>List all your civil service eligibilities including Career Service, RA 1080 (Board/Bar), CES, CSEE, Barangay Eligibility, Driver's License, etc.
            </div>

            <!-- Eligibility Table -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Top controls: Add button + Sort dropdown -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-success" id="addEligibilityBtn"><i class="bi bi-plus-circle me-2"></i>Add Eligibility</button>

                        <div>
                            <label for="sortDate" class="form-label me-2 mb-0">Sort by Date:</label>
                            <select id="sortDate" class="form-select d-inline-block w-auto">
                                <option value="desc">Latest → Oldest</option>
                                <option value="asc">Oldest → Latest</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="eligibilityTable">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Eligibility Type</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Place</th>
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center p-0">
        <img src="" id="imagePreview" class="img-fluid rounded" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="eligibilityModal" tabindex="-1" aria-labelledby="eligibilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content form-card">
            <form id="eligibilityForm" enctype="multipart/form-data">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
                    <h5 class="modal-title" id="eligibilityModalLabel">Add Eligibility</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="eligibility_id">
                    <input type="hidden" name="existing_proof" id="existing_proof">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Eligibility Type</label>
                            <select class="form-select" name="type" id="eligibility_type" required>
                                <option value="">Select</option>
                                <option value="Career Service - Professional">Career Service - Professional</option>
                                <option value="Career Service - Sub-Professional">Career Service - Sub-Professional</option>
                                <option value="RA 1080 (Board/Bar)">RA 1080 (Board/Bar)</option>
                                <option value="CES - Eligibility">CES - Eligibility</option>
                                <option value="CSEE - Barangay">CSEE - Barangay</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating</label>
                            <input type="text" class="form-control" name="rating" id="eligibility_rating" placeholder="e.g., 85.50%, Passed">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Examination/Conferment</label>
                            <input type="date" class="form-control" name="date" id="eligibility_date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Place of Examination/Conferment</label>
                            <input type="text" class="form-control" name="place" id="eligibility_place" placeholder="e.g., Manila">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Proof of Certification</label>
                            <input type="file" class="form-control" name="proof" id="eligibility_proof" accept="image/*,.pdf">
                            <div class="preview-container mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer form-actions">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveEligibilityBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
$(document).ready(function () {
    const tableBody = $('#eligibilityTable tbody');
    const modal = new bootstrap.Modal($('#eligibilityModal'));

    // ------------------------------
    // SORT FUNCTION
    // ------------------------------
    function sortEligibilityTable(order) {
        const rows = tableBody.find('tr').get();
        rows.sort(function(a, b) {
            const dateAtext = $(a).children().eq(3).text().trim();
            const dateBtext = $(b).children().eq(3).text().trim();
            const dateA = dateAtext ? new Date(dateAtext) : new Date(0);
            const dateB = dateBtext ? new Date(dateBtext) : new Date(0);
            return order === 'asc' ? dateA - dateB : dateB - dateA;
        });
        $.each(rows, function(idx, row) {
            tableBody.append(row);
            $(row).children().eq(0).text(idx + 1);
        });
    }

    // ------------------------------
    // LOAD ELIGIBILITIES
    // ------------------------------
    function loadEligibilities() {
        $.getJSON('<?= base_url("employee/civilser/get") ?>')
        .done(function(res) {
            tableBody.empty();

            if(res.success && res.data.length > 0){
                res.data.forEach((item, idx) => {
                    const proofFile = item.proof_of_certification || '';
                    let proofHtml = '';
                    if(proofFile){
                        const fileUrl = '<?= base_url("public/assets/civilser/") ?>' + proofFile;
                        proofHtml = proofFile.toLowerCase().endsWith('.pdf')
                            ? `<a href="${fileUrl}" target="_blank" class="preview-pdf">PDF</a>`
                            : `<img src="${fileUrl}" class="preview-img clickable-img" style="cursor:pointer"/>`;
                    }

                    tableBody.append(`
                        <tr data-id="${item.id}" data-file="${proofFile}">
                            <td>${idx + 1}</td>
                            <td>${item.career_service || ''}</td>
                            <td>${item.rating || ''}</td>
                            <td>${item.date_of_examination_conferment || ''}</td>
                            <td>${item.place_of_examination_conferment || ''}</td>
                            <td>${proofHtml}</td>
                            <td>
                                <button class="btn btn-sm btn-info edit-entry"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-danger delete-entry"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `);
                });

                // Apply current sort immediately
                sortEligibilityTable($('#sortDate').val());
            } else {
                tableBody.append('<tr><td colspan="7" class="text-center">No records found.</td></tr>');
            }
        })
        .fail(function(xhr, status, error){
            console.error('Failed to load eligibilities:', status, error);
            tableBody.empty().append('<tr><td colspan="7" class="text-center text-danger">Error loading records.</td></tr>');
            Swal.fire('Error', 'Could not load civil service eligibilities.', 'error');
        });
    }

    // ------------------------------
    // ADD / EDIT MODAL
    // ------------------------------
    $('#addEligibilityBtn').click(function() {
        $('#eligibilityForm')[0].reset();
        $('#eligibility_id, #existing_proof').val('');
        $('.preview-container').html('');
        $('#eligibilityModalLabel').text('Add Eligibility');
        modal.show();
    });

    $(document).on('click', '.edit-entry', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const file = row.data('file') || '';

        $('#eligibility_id').val(id);
        $('#eligibility_type').val(row.children().eq(1).text());
        $('#eligibility_rating').val(row.children().eq(2).text());
        $('#eligibility_date').val(row.children().eq(3).text());
        $('#eligibility_place').val(row.children().eq(4).text());
        $('#existing_proof').val(file);

        if(file){
            const fileUrl = '<?= base_url("public/assets/civilser/") ?>' + file;
            $('.preview-container').html(
                file.toLowerCase().endsWith('.pdf') 
                ? `<a href="${fileUrl}" target="_blank" class="preview-pdf">PDF</a>` 
                : `<img src="${fileUrl}" class="preview-img"/>`
            );
        } else {
            $('.preview-container').html('');
        }

        $('#eligibilityModalLabel').text('Edit Eligibility');
        modal.show();
    });

    // ------------------------------
    // DELETE ENTRY
    // ------------------------------
    $(document).on('click', '.delete-entry', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const file = row.data('file') || '';

        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '<?= base_url("employee/civilser/delete") ?>',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({id, file}),
                    dataType: 'json',
                    success: function(res){
                        if(res.success){
                            row.remove();
                            Swal.fire('Deleted!', 'The record has been deleted.', 'success');
                        } else {
                            Swal.fire('Error!', res.message || 'Delete failed!', 'error');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error('Delete error:', status, error, xhr.responseText);
                        Swal.fire('Error!', 'An unexpected error occurred while deleting.', 'error');
                    }
                });
            }
        });
    });

    // ------------------------------
    // PREVIEW FILE
    // ------------------------------
    $('#eligibility_proof').change(function() {
        const file = this.files[0];
        const container = $('.preview-container').html('');
        if(!file) return;

        const url = URL.createObjectURL(file);
        container.html(
            file.type.startsWith('image/') 
            ? `<img src="${url}" class="preview-img"/>` 
            : `<span class="preview-pdf">${file.name}</span>`
        );
    });

    $(document).on('click', '.clickable-img', function() {
        $('#imagePreview').attr('src', $(this).attr('src'));
        new bootstrap.Modal($('#imagePreviewModal')).show();
    });

    // ------------------------------
    // SUBMIT FORM
    // ------------------------------
    $('#eligibilityForm').submit(function(e){
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: '<?= base_url("employee/civilser/save") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res){
                if(res && res.success){
                    modal.hide();
                    loadEligibilities();
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Eligibility record has been saved.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Error', res.message || 'Save failed!', 'error');
                }
            },
            error: function(xhr, status, error){
                console.error('Save error:', status, error, xhr.responseText);
                Swal.fire('Error', 'An unexpected error occurred while saving.', 'error');
            }
        });
    });

    // ------------------------------
    // SORT DROPDOWN CHANGE
    // ------------------------------
    $('#sortDate').change(function() {
        sortEligibilityTable($(this).val());
    });

    // ------------------------------
    // INITIAL LOAD
    // ------------------------------
    loadEligibilities();
});
</script>
</body>
</html>