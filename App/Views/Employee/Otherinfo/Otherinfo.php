<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Other Information</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/otherinfo.css') ?>">
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="container-fluid py-4">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="page-title"><i class="bi bi-info-circle"></i> Other Information</h1>
                <p class="page-subtitle">Provide additional relevant details</p>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>Include special skills, distinctions, and memberships in organizations.
            </div>

            <!-- Other Information Table Card -->
            <div class="form-card mb-4">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <button class="btn btn-success" id="addOtherInfo">
                            <i class="bi bi-plus-circle me-2"></i>Add Entry
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Special Skills and Hobbies</th>
                                    <th>Non-Academic Distinctions / Recognition</th>
                                    <th>Membership in Association/Organization</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($otherInfos)): ?>
                                    <?php foreach($otherInfos as $index => $info): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= ($info['skills_hobbies']) ?></td>
                                            <td><?= ($info['distinctions']) ?></td>
                                            <td><?= ($info['membership']) ?></td>
                                            <!-- <td>
                                                <?php 
                                                $proof = !empty($info['proof_membership']) ? $info['proof_membership'] : null;
                                                if ($proof): 
                                                    $fileExt = strtolower(pathinfo($proof, PATHINFO_EXTENSION));
                                                    $fileUrl = base_url('public/assets/membership_proof/' . $proof);
                                                ?>
                                                    <?php if(in_array($fileExt, ['jpg','jpeg','png'])): ?>
                                                        <a href="<?= $fileUrl ?>" target="_blank">
                                                            <img src="<?= $fileUrl ?>" class="img-thumbnail" style="width:80px; height:80px; object-fit:cover;">
                                                        </a>
                                                    <?php elseif($fileExt === 'pdf'): ?>
                                                        <button class="btn btn-sm btn-outline-danger view-pdf" data-src="<?= $fileUrl ?>">View PDF</button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No File</span>
                                                <?php endif; ?>
                                            </td> -->
                                            <td>
                                                <button class="btn btn-sm btn-primary editOtherInfo" data-id="<?= $info['id'] ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger deleteOtherInfo" data-id="<?= $info['id'] ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add/Edit Other Info Modal -->
            <div class="modal fade" id="otherInfoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content form-card">
                        <form id="otherInfoForm" method="post" enctype="multipart/form-data">
                            <div class="modal-header" style="background: linear-gradient(135deg, var(--sunn-primary), var(--sunn-secondary)); color:white;">
                                <h5 class="modal-title" id="otherInfoModalLabel">Add Other Information</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <?= csrf_input() ?>
                                <input type="hidden" id="info_id" name="info_id">

                                <div class="mb-3 position-relative">
                                    <label class="form-label">Special Skills and Hobbies</label>
                                    <input type="text" class="form-control" name="skills_hobbies" autocomplete="off">
                                    <ul id="skillsDropdown" class="list-group position-absolute w-100" style="z-index:1000;"></ul>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Non-Academic Distinctions / Recognition</label>
                                    <textarea class="form-control" name="distinctions" rows="2" ></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Membership in Association / Organization</label>
                                    <textarea class="form-control" name="membership" rows="2"></textarea>
                                </div>

                                <!-- <div class="mb-3">
                                    <label class="form-label">Proof of Membership</label>
                                    <input type="file" class="form-control" name="proof_membership" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Allowed formats: pdf, jpg, jpeg, png</small>

                                
                                        <div id="existingProof" class="mt-2"></div>
                                        <input type="hidden" name="existing_proof" id="existing_proof">
                                </div> -->

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="saveOtherInfo">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PDF / Image Modal -->
            <div class="modal fade" id="fileModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">File Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center">
                            <iframe id="fileFrame" src="" style="width:100%; height:80vh;" frameborder="0"></iframe>
                            <img id="fileImg" src="" style="max-width:100%; max-height:80vh; display:none;" />
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>

<script>
$(document).ready(function() {
    // ---------------- Add / Edit Modal ----------------
    $('#addOtherInfo').on('click', function() {
        $('#otherInfoForm')[0].reset();
        $('#info_id').val('');
        $('#existingProof').html('');
        $('#existing_proof').val('');
        $('#otherInfoModalLabel').text('Add Other Information');
        new bootstrap.Modal(document.getElementById('otherInfoModal')).show();
    });

    // View PDF/Image
    $(document).on('click', '.view-pdf, .view-img', function() {
        let src = $(this).data('src');
        let ext = src.split('.').pop().toLowerCase();

        if(ext === 'pdf') {
            $('#fileFrame').show().attr('src', src);
            $('#fileImg').hide();
        } else {
            $('#fileImg').show().attr('src', src);
            $('#fileFrame').hide();
        }

        new bootstrap.Modal(document.getElementById('fileModal')).show();
    });


    // Submit Add/Edit Form
    $('#otherInfoForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading
        Swal.fire({
            title: 'Please wait...',
            text: 'Saving information',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let formData = new FormData(this);
        formData.set('_csrf_token', $('input[name="_csrf_token"]').val());

        $.ajax({
            url: "<?= base_url('employee/otherinfo/save') ?>",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                // Update CSRF token
                if(response.csrf_token) {
                    $('input[name="_csrf_token"]').val(response.csrf_token);
                }

                if(response.success) {
                    let isEdit = $('#info_id').val() !== ""; 
                    let msg = isEdit ? "Information updated successfully!" : "Information added successfully!";

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: msg,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({ 
                        icon: 'error', 
                        title: 'Oops...', 
                        text: response.message || 'Something went wrong!',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error!', 
                    text: 'Failed to save information. Please try again.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });


    // ---------------- Edit Entry ----------------
    $('.editOtherInfo').on('click', function() {
        let id = $(this).data('id');
        
        // Show loading
        Swal.fire({
            title: 'Loading...',
            text: 'Fetching information',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.get("<?= base_url('employee/otherinfo/get') ?>", { 
            id: id, 
            _csrf_token: $('input[name="_csrf_token"]').val()
        }, function(response) {
            Swal.close(); // Close loading

            if(response.csrf_token) {
                $('input[name="_csrf_token"]').val(response.csrf_token);
            }

            if(response.success) {
                let data = response.data;
                $('#info_id').val(id);
                $('input[name="skills_hobbies"]').val(data.skills_hobbies);
                $('textarea[name="distinctions"]').val(data.distinctions);
                $('textarea[name="membership"]').val(data.membership);

                if(data.proof_membership) {
                    let ext = data.proof_membership.split('.').pop().toLowerCase();
                    let btnClass = ext === 'pdf' ? 'view-pdf' : 'view-img';
                    $('#existingProof').html(
                        `<button type="button" class="btn btn-sm btn-outline-info ${btnClass}" data-src="<?= base_url('public/assets/membership_proof/') ?>${data.proof_membership}">View Current File</button>`
                    );
                    $('#existing_proof').val(data.proof_membership);
                } else {
                    $('#existingProof').html('<span class="text-muted">No File</span>');
                    $('#existing_proof').val('');
                }

                $('#otherInfoModalLabel').text('Edit Other Information');
                new bootstrap.Modal(document.getElementById('otherInfoModal')).show();
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error!', 
                    text: 'Failed to fetch data.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            }
        }, 'json').fail(function() {
            Swal.fire({ 
                icon: 'error', 
                title: 'Error!', 
                text: 'Failed to fetch data. Please try again.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        });
    });


    // ---------------- Delete Entry ----------------
    $('.deleteOtherInfo').on('click', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete this entry!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.post("<?= base_url('employee/otherinfo/delete') ?>", { 
                    id: id, 
                    _csrf_token: $('input[name="_csrf_token"]').val()
                }, function(response) {
                    if(response.csrf_token) {
                        $('input[name="_csrf_token"]').val(response.csrf_token);
                    }

                    if(response.success) {
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'Deleted!', 
                            text: response.message || 'Entry has been deleted.',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#28a745'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Error!', 
                            text: response.message || 'Failed to delete entry.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    }
                }, 'json').fail(function() {
                    Swal.fire({ 
                        icon: 'error', 
                        title: 'Error!', 
                        text: 'Failed to delete entry. Please try again.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                });
            }
        });
    });

    // Autocomplete for Special Skills and Hobbies
    $('input[name="skills_hobbies"]').on('input', function() {
        let query = $(this).val().trim();
        let dropdown = $('#skillsDropdown');
        dropdown.empty();

        if (query.length < 2) return;

        $.get('<?= base_url("employee/otherinfo/search-skills") ?>', { q: query }, function(response) {
            if (response.success && response.data.length) {
                response.data.forEach(skill => {
                    dropdown.append(`<li class="list-group-item list-group-item-action" style="cursor:pointer;">${skill}</li>`);
                });
            }
        }, 'json');
    });

    // When user clicks a skill, fill input
    $(document).on('click', '#skillsDropdown li', function() {
        $('input[name="skills_hobbies"]').val($(this).text());
        $('#skillsDropdown').empty();
    });

    // Hide dropdown if click outside
    $(document).click(function(e) {
        if (!$(e.target).closest('input[name="skills_hobbies"], #skillsDropdown').length) {
            $('#skillsDropdown').empty();
        }
    });

});
</script>


</body>
</html>
