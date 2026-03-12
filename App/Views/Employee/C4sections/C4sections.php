<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>C4 Section - Personal Data Sheet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/c4.css') ?>">
</head>
<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid py-4">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="bi bi-file-earmark-person"></i> C4 - Additional Information & Declaration</h1>
                    <p class="page-subtitle">Complete the following sections for your Personal Data Sheet</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="post" enctype="multipart/form-data">

                        <!-- ================= Question 34 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">34. Relatives in Government</h3>
                                    <p class="section-description mb-0">Are you related by consanguinity or affinity to appointing authorities?</p>
                                </div>
                            </div>
                            <div class="row g-3 ms-1">
                                <div class="col-md-6">
                                    <label>a. within the third degree?</label>
                                    <input type="text" name="q34a" class="form-control" placeholder="If YES, give details">
                                </div>
                                <div class="col-md-6">
                                    <label>b. within the fourth degree?</label>
                                    <input type="text" name="q34b" class="form-control" placeholder="If YES, give details">
                                </div>
                            </div>
                        </div>

                        <!-- ================= Question 35 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-exclamation-triangle"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">35. Administrative & Criminal Records</h3>
                                    <p class="section-description mb-0">Provide details if applicable</p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>a. Ever found guilty of administrative offense?</label>
                                    <input type="text" name="q35a" class="form-control mb-2" placeholder="If YES, give details">
                                </div>
                                <div class="col-md-6">
                                    <label>b. Ever criminally charged?</label>
                                    <input type="text" name="q35b" class="form-control mb-2" placeholder="If YES, give details">
                                    <div class="row g-2 mt-1">
                                        <div class="col-md-6">
                                            <label>Date Filed:</label>
                                            <input type="date" name="q35b_datefiled" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Status of Case/s:</label>
                                            <input type="text" name="q35b_status" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- ================= Question 36 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-exclamation-triangle"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">36. Conviction of Crime</h3>
                                    <p class="section-description mb-0">Provide details if applicable</p>
                                </div>
                            </div>
                            <input type="text" name="q36" class="form-control" placeholder="If YES, give details">
                        </div>


                        <!-- ================= Question 37 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-person-dash"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">37. Separation from Service</h3>
                                    <p class="section-description mb-0">Details if you have been separated from service in any mode</p>
                                </div>
                            </div>
                            <input type="text" name="q37" class="form-control" placeholder="If YES, give details">
                        </div>

                        <!-- ================= Question 38 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-person-lines-fill"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">38. Election Participation</h3>
                                    <p class="section-description mb-0">Answer the following items</p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>a. Candidate in last national/local election?</label>
                                    <input type="text" name="q38a" class="form-control" placeholder="If YES, give details">
                                </div>
                                <div class="col-md-6">
                                    <label>b. Resigned to campaign?</label>
                                    <input type="text" name="q38b" class="form-control" placeholder="If YES, give details">
                                </div>
                            </div>
                        </div>

                        <!-- ================= Question 39 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-globe"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">39. Immigrant or Permanent Resident Status</h3>
                                </div>
                            </div>
                            <input type="text" name="q39" class="form-control" placeholder="If YES, give details (country)">
                        </div>

                        <!-- ================= Question 40 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-shield-check"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">40. Special Status (IP, PWD, Solo Parent)</h3>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label>a. Member of indigenous group?</label>
                                    <input type="text" name="q40a" class="form-control" placeholder="If YES, specify">
                                </div>
                                <div class="col-md-4">
                                    <label>b. Person with disability?</label>
                                    <input type="text" name="q40b" class="form-control" placeholder="If YES, specify ID No:">
                                </div>
                                <div class="col-md-4">
                                    <label>c. Solo parent?</label>
                                    <input type="text" name="q40c" class="form-control" placeholder="If YES, specify ID No:">
                                </div>
                            </div>
                        </div>

                        <!-- ================= Question 41 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-card-list"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">41. References</h3>
                                    <p class="section-description mb-0">Person not related by consanguinity or affinity</p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-light">
                                        <tr><th>NAME</th><th>ADDRESS</th><th>TEL. NO.</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="ref_name1" class="form-control"></td>
                                            <td><input type="text" name="ref_address1" class="form-control"></td>
                                            <td><input type="text" name="ref_tel1" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="ref_name2" class="form-control"></td>
                                            <td><input type="text" name="ref_address2" class="form-control"></td>
                                            <td><input type="text" name="ref_tel2" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ================= Question 42 ================= -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-file-text"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">42. Declaration</h3>
                                </div>
                            </div>

                            <p>I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement...</p>

                            <div class="row g-4 text-center mt-3">
                                <div class="col-md-4">
                                    <div class="photo-box position-relative border rounded" style="height:180px; width:135px; margin:0 auto;">
                                        <img id="photoPreview" src="" alt="Employee Photo" class="w-100 h-100" style="object-fit:cover; display:none;">
                                        <div class="photo-placeholder text-center" style="font-size:0.8rem;">
                                            <strong>PHOTO</strong><br><small class="text-muted">(4.5 cm x 3.5 cm)</small>
                                        </div>
                                        <input type="file" name="photo" class="form-control mt-2 position-absolute bottom-0 start-50 translate-middle-x" accept="image/*">
                                    </div>
                                    <p class="text-muted mt-1" style="font-size:0.8rem;">ID picture taken within the last 6 months</p>
                                </div>

                                <div class="col-md-4">
                                    <div class="signature-box border rounded p-2">
                                        <div class="signature-area" style="height:60px;"></div>
                                        <div class="signature-label bg-light mt-2">Signature (Sign inside the box)</div>
                                        <div class="signature-label bg-light mt-1">Date Accomplished</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="thumb-box border rounded p-2">
                                        <div class="thumb-area" style="height:80px;"></div>
                                        <div class="thumb-label mt-2">Right Thumbmark</div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <label>Government Issued ID</label>
                            <input type="text" name="gov_id" class="form-control mb-2" placeholder="Please indicate ID">
                            <label>ID/License/Passport No.:</label>
                            <input type="text" name="gov_id_no" class="form-control mb-2">
                            <label>Date/Place of Issuance:</label>
                            <input type="text" name="gov_id_issue" class="form-control">

                            <p class="mt-4">SUBSCRIBED AND SWORN to before me this ____________________________, affiant exhibiting his/her validly issued government ID as indicated above.</p>
                            <div class="text-center mt-4">
                                <div class="border border-secondary rounded mb-2 mx-auto" style="width:300px; height:80px;"></div>
                                <p class="fw-semibold text-secondary mb-0">Person Administering Oath</p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Save Section C4</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script>
  $(document).ready(function() {

    // 🔹 Auto-load saved data
    $.getJSON('<?= base_url('employee/c4sections/get') ?>', function(res) {
        if (res.success && res.data) {
            const d = res.data;

            // Auto-fill form except file input
            for (const key in d) {
                if (!d.hasOwnProperty(key)) continue;
                if (key === 'photo') continue; // 🚫 Skip file input
                if (d[key] === null || d[key] === "0000-00-00") continue;

                const $input = $(`[name="${key}"]`);
                if ($input.length) $input.val(d[key]);
            }

            // ✅ Show existing photo
            if (d.photo) {
                const imgUrl = `<?= base_url('assets/c4sections/') ?>${d.photo}`;
                $('#photoPreview').attr('src', imgUrl).show();
                $('.photo-placeholder').hide();
            }
        }
    });

    // 🔹 Handle form submit
    $('form').off('submit').on('submit', function(e) {
        e.preventDefault();

        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('Saving...');

        const formData = new FormData(this);

        $.ajax({
            url: '<?= base_url('employee/c4sections/save') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function(res) {
                if (res.success) {
                    alert(res.message || '✅ C4 section saved successfully!');

                    // ✅ Clear file input safely
                    $('input[name="photo"]').val('');

                    // ✅ Reload latest data (optional)
                    $.getJSON('<?= base_url('employee/c4sections/get') ?>', function(update) {
                        if (update.success && update.data.photo) {
                            const imgUrl = `<?= base_url('assets/c4sections/') ?>${update.data.photo}`;
                            $('#photoPreview').attr('src', imgUrl).show();
                            $('.photo-placeholder').hide();
                        }
                    });

                } else {
                    alert(res.error || '❌ Failed to save. Try again.');
                }
                $btn.prop('disabled', false).html('<i class="bi bi-save"></i> Save Section C4');
            },

            error: function(xhr) {
                let msg = xhr.responseJSON?.error || '⚠️ Unexpected server error.';
                alert(msg);
                $btn.prop('disabled', false).html('<i class="bi bi-save"></i> Save Section C4');
            }
        });
    });

    // 🔹 Live preview when uploading new photo
    $('input[name="photo"]').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Please select an image file only.');
            e.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            $('#photoPreview').attr('src', e.target.result).show();
            $('.photo-placeholder').hide();
        };
        reader.readAsDataURL(file);
    });

});
</script>
</body>
</html>
