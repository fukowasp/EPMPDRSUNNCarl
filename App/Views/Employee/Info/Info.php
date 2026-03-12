<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Information - Personal Data Sheet | SUNN</title>
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/info.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>

    <div class="wrapper">
        <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-fluid py-4">

                <!-- Page Header -->
                <div class="page-header mb-4">
                    <div class="page-header-content">
                        <h1 class="page-title"><i class="bi bi-person-vcard"></i> Personal Information</h1>
                        <p class="page-subtitle">Complete your personal details for the Personal Data Sheet (PDS)</p>
                    </div>
                </div>

                <!-- Form Wrapper -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form id="personalInfoForm" method="POST" enctype="multipart/form-data">

                            <!-- ================= Basic Information ================= -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-3 d-flex align-items-center">
                                    <div class="section-icon me-2"><i class="bi bi-person-badge"></i></div>
                                    <div>
                                        <h3 class="section-title mb-0">Basic Information</h3>
                                        <p class="section-description mb-0">Personal details and identification
                                            information</p>
                                    </div>
                                </div>

                                <!-- Employee Photo and Name -->
                                <div class="row align-items-start g-4">
                                    <div class="col-lg-9">
                                        <h5 class="fw-semibold mb-3"><i class="bi bi-card-text text-primary"></i> Full
                                            Name</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6 col-lg-3">
                                                <label for="surname" class="form-label">Surname <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="surname" name="surname"
                                                    required>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <label for="first_name" class="form-label">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name"
                                                    name="first_name" required>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <label for="middle_name" class="form-label">Middle Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="middle_name"
                                                    name="middle_name" required>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <label for="name_extension" class="form-label">Name Extension</label>
                                                <input type="text" class="form-control" id="name_extension"
                                                    name="name_extension">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 text-center">
                                        <h6 class="text-primary mb-2"><i class="bi bi-camera"></i> Employee Photo</h6>
                                        <img id="employee_photo" src="<?= base_url('assets/default-user.png') ?>"
                                            class="img-thumbnail rounded mb-2"
                                            style="width:120px; height:120px; object-fit:cover;" alt="Employee Photo">
                                        <input type="file" id="employeePhotoInput" name="employee_photo"
                                            class="form-control form-control-sm" accept="image/*">
                                    </div>
                                </div>

                                <!-- Birth Information -->
                                <div class="mt-4">
                                    <h5 class="fw-semibold mb-3"><i class="bi bi-calendar-event text-primary"></i> Birth
                                        Information</h5>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="date_of_birth" class="form-label">Date of Birth <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="date_of_birth"
                                                name="date_of_birth" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="place_of_birth" class="form-label">Place of Birth <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="place_of_birth"
                                                name="place_of_birth" placeholder="City, Province" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sex" class="form-label">Sex <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="sex" name="sex" required>
                                                <option value="">Choose sex</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Characteristics -->
                                <div class="mt-4">
                                    <h5 class="fw-semibold mb-3"><i class="bi bi-person-lines-fill text-primary"></i>
                                        Personal Characteristics</h5>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label for="civil_status" class="form-label">Civil Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="civil_status" name="civil_status" required>
                                                <option value="">Choose status</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Separated">Separated</option>
                                                <option value="Divorced">Divorced</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="height" class="form-label">Height (m) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" id="height"
                                                name="height" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="weight" class="form-label">Weight (kg) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.1" class="form-control" id="weight"
                                                name="weight" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="blood_type" class="form-label">Blood Type <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="blood_type" name="blood_type" required>
                                                <option value="">Choose type</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= Government IDs ================= -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-3 d-flex align-items-center">
                                    <div class="section-icon me-2"><i class="bi bi-card-list"></i></div>
                                    <div>
                                        <h3 class="section-title mb-0">Government IDs & Numbers</h3>
                                        <p class="section-description mb-0">Official identification numbers and
                                            citizenship information</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="gsis_id_no" class="form-label">GSIS ID Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="gsis_id_no" name="gsis_id_no"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pagibig_id_no" class="form-label">PAG-IBIG ID Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pagibig_id_no" name="pagibig_id_no"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="philhealth_no" class="form-label">PhilHealth Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="philhealth_no" name="philhealth_no"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sss_no" class="form-label">SSS Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="sss_no" name="sss_no" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tin_no" class="form-label">TIN Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tin_no" name="tin_no" required>
                                    </div>
                                </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="agency_employee_no" class="form-label">Agency Employee Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="agency_employee_no"
                                            name="agency_employee_no" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Citizenship <span class="text-danger">*</span></label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="citizenship_filipino"
                                                name="citizenship_type" value="Filipino" checked>
                                            <label class="form-check-label" for="citizenship_filipino">
                                                Filipino
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="citizenship_dual"
                                                name="citizenship_type" value="Dual Citizenship">
                                            <label class="form-check-label" for="citizenship_dual">
                                                Dual Citizenship
                                            </label>
                                        </div>

                                        <!-- Dual Citizenship Section -->
                                        <div id="dual_citizenship_section" style="display:none; margin-top:10px;">

                                            <label class="form-label">If Dual Citizenship:</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="by_birth"
                                                    name="dual_citizenship_by" value="By Birth">
                                                <label class="form-check-label" for="by_birth">
                                                    By Birth
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="by_naturalization"
                                                    name="dual_citizenship_by" value="By Naturalization">
                                                <label class="form-check-label" for="by_naturalization">
                                                    By Naturalization
                                                </label>
                                            </div>

                                            <div class="mt-2">
                                                <label for="dual_country" class="form-label">Country</label>
                                                <select class="form-select" id="dual_country"
                                                    name="dual_citizenship_country">
                                                    <option value="">Select Country</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= Address Section ================= -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-3 d-flex align-items-center">
                                    <div class="section-icon me-2"><i class="bi bi-geo-alt"></i></div>
                                    <div>
                                        <h3 class="section-title mb-0">Address Information</h3>
                                        <p class="section-description mb-0">Residential and permanent address details
                                        </p>
                                    </div>
                                </div>

                                <h5 class="fw-semibold mb-3"><i class="bi bi-house text-primary"></i> Residential
                                    Address</h5>
                                <div class="row g-3">
                                    <div class="col-md-6"><label for="res_house_block_lot"
                                            class="form-label">House/Block/Lot</label><input type="text"
                                            class="form-control" id="res_house_block_lot" name="res_house_block_lot"
                                            required></div>
                                    <div class="col-md-6"><label for="res_street"
                                            class="form-label">Street</label><input type="text" class="form-control"
                                            id="res_street" name="res_street" required></div>
                                    <div class="col-md-6"><label for="res_subdivision"
                                            class="form-label">Subdivision</label><input type="text"
                                            class="form-control" id="res_subdivision" name="res_subdivision" required>
                                    </div>
                                    <div class="col-md-6"><label for="res_barangay"
                                            class="form-label">Barangay</label><input type="text" class="form-control"
                                            id="res_barangay" name="res_barangay" required></div>
                                    <div class="col-md-6"><label for="res_city_municipality"
                                            class="form-label">City/Municipality</label><input type="text"
                                            class="form-control" id="res_city_municipality" name="res_city_municipality"
                                            required></div>
                                    <div class="col-md-6"><label for="res_province"
                                            class="form-label">Province</label><input type="text" class="form-control"
                                            id="res_province" name="res_province" required></div>
                                    <div class="col-md-6"><label for="res_zip_code" class="form-label">Zip
                                            Code</label><input type="text" class="form-control" id="res_zip_code"
                                            name="res_zip_code" required></div>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-semibold mb-0"><i class="bi bi-pin-map text-primary"></i>
                                            Permanent Address</h5>
                                        <div>
                                            <input type="checkbox" id="sameAsResidential">
                                            <label for="sameAsResidential">Same as Residential</label>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6"><label for="perm_house_block_lot"
                                                class="form-label">House/Block/Lot</label><input type="text"
                                                class="form-control" id="perm_house_block_lot"
                                                name="perm_house_block_lot" required></div>
                                        <div class="col-md-6"><label for="perm_street"
                                                class="form-label">Street</label><input type="text" class="form-control"
                                                id="perm_street" name="perm_street" required></div>
                                        <div class="col-md-6"><label for="perm_subdivision"
                                                class="form-label">Subdivision</label><input type="text"
                                                class="form-control" id="perm_subdivision" name="perm_subdivision"
                                                required></div>
                                        <div class="col-md-6"><label for="perm_barangay"
                                                class="form-label">Barangay</label><input type="text"
                                                class="form-control" id="perm_barangay" name="perm_barangay" required>
                                        </div>
                                        <div class="col-md-6"><label for="perm_city_municipality"
                                                class="form-label">City/Municipality</label><input type="text"
                                                class="form-control" id="perm_city_municipality"
                                                name="perm_city_municipality" required></div>
                                        <div class="col-md-6"><label for="perm_province"
                                                class="form-label">Province</label><input type="text"
                                                class="form-control" id="perm_province" name="perm_province" required>
                                        </div>
                                        <div class="col-md-6"><label for="perm_zip_code" class="form-label">Zip
                                                Code</label><input type="text" class="form-control" id="perm_zip_code"
                                                name="perm_zip_code" required></div>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= Contact Section ================= -->
                            <div class="form-section">
                                <div class="section-header mb-3 d-flex align-items-center">
                                    <div class="section-icon me-2"><i class="bi bi-telephone"></i></div>
                                    <div>
                                        <h3 class="section-title mb-0">Contact Information</h3>
                                        <p class="section-description mb-0">Phone numbers and email address for
                                            communication</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="telephone_no" class="form-label">Telephone Number <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="telephone_no" name="telephone_no"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="mobile_no" class="form-label">Mobile Number <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="mobile_no" name="mobile_no" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email_address" class="form-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email_address" name="email_address"
                                            required>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="text-end mt-4">
                                    <button type="button" id="clearFormBtn" class="btn btn-outline-secondary me-2">
                                        <i class="bi bi-arrow-clockwise"></i> Clear Form
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Save Information
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- JS -->
    <script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script id="6g4a8k">
        $(document).ready(function () {
            const form = $('#personalInfoForm')[0];
            const photoInput = $('#employeePhotoInput')[0];
            const photoPreview = $('#employee_photo')[0];

            // Prefill data via JSON
            $.getJSON("<?= base_url('employee/info/get') ?>", function (res) {
                if (!res.success || !res.data) return;
                const d = res.data;
                for (const key in d) {
                    const el = $('#' + key);
                    if (el.length) el.val(d[key]);
                }
                if (d.employee_photo_base64) photoPreview.src = d.employee_photo_base64;
            });

            // Live photo preview
            photoInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => photoPreview.src = e.target.result;
                reader.readAsDataURL(file);
            });

            // Form submission
            $('#personalInfoForm').on('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(form);
                try {
                    const res = await fetch("<?= base_url('employee/info/save') ?>", { method: 'POST', body: formData });
                    const result = await res.json();
                    if (result.success) {
                        alert(`✅ ${result.message}`);
                        window.location.href = "<?= base_url('employee/dashboard') ?>";
                    } else {
                        alert(`❌ ${result.message || result.error}`);
                    }
                } catch (err) {
                    console.error(err);
                    alert("❌ Error saving information.");
                }
            });

            // Clear form
            $('#clearFormBtn').on('click', function () {
                form.reset();
                photoPreview.src = "<?= base_url('assets/default-user.png') ?>";
                $('#dual_citizenship_section').hide();
            });

            // Copy residential to permanent
            $('#sameAsResidential').on('change', function () {
                if (!this.checked) return;
                ['house_block_lot', 'street', 'subdivision', 'barangay', 'city_municipality', 'province', 'zip_code'].forEach(suffix => {
                    $('#perm_' + suffix).val($('#res_' + suffix).val());
                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {

            // Initialize Select2
            $('#dual_country').select2({
                placeholder: "Select Country",
                width: '100%'
            });

            // Load countries
            $.get("https://restcountries.com/v3.1/all?fields=name", function (data) {

                data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                data.forEach(function (country) {
                    $('#dual_country').append(
                        `<option value="${country.name.common}">${country.name.common}</option>`
                    );
                });

                $('#dual_country').trigger('change');

            });

            // Citizenship radio toggle
            $('input[name="citizenship_type"]').on('change', function () {

                if ($(this).val() === "Dual Citizenship") {
                    $('#dual_citizenship_section').slideDown();
                } else {
                    $('#dual_citizenship_section').slideUp();

                    // Reset dual fields when Filipino selected
                    $('input[name="dual_citizenship_by"]').prop('checked', false);
                    $('#dual_country').val(null).trigger('change');
                }

            });

        });
    </script>
</body>

</html>