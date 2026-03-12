<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Educational Background Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/eduback.css') ?>">
</head>

<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid py-4">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="bi bi-mortarboard"></i> Educational Background</h1>
                    <p class="page-subtitle">Please provide your complete educational history</p>
                </div>
            </div>

            <!-- Educational Background Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form id="educationForm" method="POST" enctype="multipart/form-data">

                        <!-- Elementary Education -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-house-door"></i></div>
                                <h3 class="section-title mb-0">Elementary Education</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">School Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="elementary_name" required placeholder="Enter elementary school name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Year Graduated</label>
                                    <input type="number" class="form-control" name="elementary_year" 
                                     placeholder="YYYY">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Scholarship / Honor</label>
                                    <input type="text" class="form-control" name="elementary_honor" placeholder="Any awards, honors, or scholarships received">
                                </div>
                            </div>
                        </div>

                        <!-- Secondary Education -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-building"></i></div>
                                <h3 class="section-title mb-0">Secondary Education (Junior High School)</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">School Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="secondary_name" required placeholder="Enter junior high school name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Year Graduated</label>
                                    <input type="number" class="form-control" name="secondary_year"  placeholder="YYYY">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Scholarship / Honor</label>
                                    <input type="text" class="form-control" name="secondary_honor" placeholder="Any awards, honors, or scholarships received">
                                </div>
                            </div>
                        </div>

                        <!-- Senior High School -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-bank"></i></div>
                                <h3 class="section-title mb-0">Senior High School</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">School Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="seniorhigh_name" required placeholder="Enter senior high school name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Year Graduated</label>
                                    <input type="number" class="form-control" name="seniorhigh_year"  placeholder="YYYY">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Scholarship / Honor</label>
                                    <input type="text" class="form-control" name="seniorhigh_honor" placeholder="Any awards, honors, or scholarships received">
                                </div>
                            </div>
                        </div>

                        <!-- Vocational / Trade Course -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-tools"></i></div>
                                <h3 class="section-title mb-0">Vocational / Trade Course</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Course / School</label>
                                    <input type="text" class="form-control" name="vocational_course" placeholder="Enter vocational course and school name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Year Completed</label>
                                    <input type="number" class="form-control" name="vocational_year"  placeholder="YYYY">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Scholarship / Honor</label>
                                    <input type="text" class="form-control" name="vocational_honor" placeholder="Any awards, honors, or scholarships received">
                                </div>
                            </div>
                        </div>

                        <!-- College / University -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-mortarboard"></i></div>
                                <h3 class="section-title mb-0">College / University</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Degree / Course</label>
                                    <input type="text" class="form-control" name="college_course" placeholder="e.g., Bachelor of Science in Computer Science">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Year Graduated</label>
                                    <input type="number" class="form-control" name="college_year"  placeholder="YYYY">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Units Earned (if not graduated)</label>
                                    <input type="text" class="form-control" name="college_units" placeholder="e.g., 120 units">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Scholarship / Honor</label>
                                    <input type="text" class="form-control" name="college_honor" placeholder="e.g., Cum Laude">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="text-end mt-4">
                            <a href="<?= base_url('employee/dashboard') ?>" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-left"></i> Back to PDS
                            </a>
                            <button type="submit" class="btn btn-primary" form="educationForm">
                                <i class="bi bi-check-circle"></i> Save Educational Background
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
$(document).ready(() => {
    const inputMap = {
        elementary_school_name: 'elementary_name',
        elementary_year_graduated: 'elementary_year',
        elementary_honor: 'elementary_honor',
        secondary_school_name: 'secondary_name',
        secondary_year_graduated: 'secondary_year',
        secondary_honor: 'secondary_honor',
        seniorhigh_school_name: 'seniorhigh_name',
        seniorhigh_year_graduated: 'seniorhigh_year',
        seniorhigh_honor: 'seniorhigh_honor',
        vocational_course: 'vocational_course',
        vocational_year_completed: 'vocational_year',
        vocational_honor: 'vocational_honor',
        college_course: 'college_course',
        college_year_graduated: 'college_year',
        college_units_earned: 'college_units',
        college_honor: 'college_honor'
    };

    const loadEducation = () => {
        $.getJSON("<?= base_url('employee/eduback/get') ?>")
        .done(res => {
            if (!res.success) return;
            const bg = res.data || {};
            for (const key in inputMap) {
                $(`[name="${inputMap[key]}"]`).val(bg[key] || '');
            }
        })
        .fail(() => console.warn("Failed to load educational background"));
    };

    $('#educationForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        for (const [dbKey, inputName] of Object.entries(inputMap)) {
            formData.append(`educational_background[${dbKey}]`, $(`[name="${inputName}"]`).val() || '');
        }

        $.ajax({
            url: "<?= base_url('employee/eduback/save') ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: res => {
                Swal.fire('Saved!', res.message, res.success ? 'success' : 'error');
                if (res.success) loadEducation();
            },
            error: () => Swal.fire('Error', 'Failed to save educational background', 'error')
        });
    });

    loadEducation();
});
</script>

</body>
</html>
