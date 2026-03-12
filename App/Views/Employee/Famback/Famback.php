<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Background - Personal Data Sheet | SUNN</title>

    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/famback.css') ?>">
</head>
<body>

<div class="wrapper">
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid py-4">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="bi bi-people"></i> Family Background</h1>
                    <p class="page-subtitle">Information about your spouse, parents, and children</p>
                </div>
            </div>

            <!-- Family Background Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form id="familyBackgroundForm">

                        <!-- ================= Spouse Information ================= -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-heart"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">Spouse Information</h3>
                                    <p class="section-description mb-0">Details about your spouse (if married)</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="spouseSurname" class="form-label">Spouse Surname</label>
                                    <input type="text" class="form-control" id="spouseSurname" name="spouseSurname">
                                </div>
                                <div class="col-md-3">
                                    <label for="spouseFirstName" class="form-label">Spouse First Name</label>
                                    <input type="text" class="form-control" id="spouseFirstName" name="spouseFirstName">
                                </div>
                                <div class="col-md-3">
                                    <label for="spouseMiddleName" class="form-label">Spouse Middle Name</label>
                                    <input type="text" class="form-control" id="spouseMiddleName" name="spouseMiddleName">
                                </div>
                                <div class="col-md-3">
                                    <label for="spouseNameExtension" class="form-label">Name Extension</label>
                                    <input type="text" class="form-control" id="spouseNameExtension" name="spouseNameExtension">
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5 class="fw-semibold mb-3"><i class="bi bi-briefcase text-primary"></i> Employment Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="spouseOccupation" class="form-label">Occupation</label>
                                        <input type="text" class="form-control" id="spouseOccupation" name="spouseOccupation">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="spouseEmployer" class="form-label">Employer/Business Name</label>
                                        <input type="text" class="form-control" id="spouseEmployer" name="spouseEmployer">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="spouseBusinessAddress" class="form-label">Business Address</label>
                                        <input type="text" class="form-control" id="spouseBusinessAddress" name="spouseBusinessAddress">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="spouseTelephoneNo" class="form-label">Telephone Number</label>
                                        <input type="tel" class="form-control" id="spouseTelephoneNo" name="spouseTelephoneNo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Parents Information ================= -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">Parents Information</h3>
                                    <p class="section-description mb-0">Details about your father and mother</p>
                                </div>
                            </div>

                            <!-- Father's Info -->
                            <h5 class="fw-semibold mb-3"><i class="bi bi-person-badge text-primary"></i> Father’s Information</h5>
                            <div class="row g-3">
                                <div class="col-md-3"><label for="fatherSurname" class="form-label">Father's Surname</label><input type="text" class="form-control" id="fatherSurname" name="fatherSurname"></div>
                                <div class="col-md-3"><label for="fatherFirstName" class="form-label">Father's First Name</label><input type="text" class="form-control" id="fatherFirstName" name="fatherFirstName"></div>
                                <div class="col-md-3"><label for="fatherMiddleName" class="form-label">Father's Middle Name</label><input type="text" class="form-control" id="fatherMiddleName" name="fatherMiddleName"></div>
                                <div class="col-md-3"><label for="fatherNameExtension" class="form-label">Name Extension</label><input type="text" class="form-control" id="fatherNameExtension" name="fatherNameExtension"></div>
                            </div>

                            <!-- Mother’s Info -->
                            <div class="mt-4">
                                <h5 class="fw-semibold mb-3"><i class="bi bi-person-heart text-primary"></i> Mother’s Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-3"><label for="motherMaidenName" class="form-label">Mother’s Maiden Name</label><input type="text" class="form-control" id="motherMaidenName" name="motherMaidenName"></div>
                                    <div class="col-md-3"><label for="motherSurname" class="form-label">Mother’s Surname</label><input type="text" class="form-control" id="motherSurname" name="motherSurname"></div>
                                    <div class="col-md-3"><label for="motherFirstName" class="form-label">Mother’s First Name</label><input type="text" class="form-control" id="motherFirstName" name="motherFirstName"></div>
                                    <div class="col-md-3"><label for="motherMiddleName" class="form-label">Mother’s Middle Name</label><input type="text" class="form-control" id="motherMiddleName" name="motherMiddleName"></div>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Children Information ================= -->
                        <div class="form-section">
                            <div class="section-header mb-3 d-flex align-items-center">
                                <div class="section-icon me-2"><i class="bi bi-person-plus"></i></div>
                                <div>
                                    <h3 class="section-title mb-0">Children Information</h3>
                                    <p class="section-description mb-0">List all your children with their full names and birth dates</p>
                                </div>
                            </div>

                            <!-- Add Child -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-semibold mb-0"><i class="bi bi-list-ul text-primary"></i> Children List</h5>
                                <button type="button" class="btn btn-success btn-sm" onclick="addChildToList()">
                                    <i class="bi bi-plus-circle"></i> Add Child
                                </button>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-5">
                                    <label for="childFullName" class="form-label">Child’s Full Name</label>
                                    <input type="text" class="form-control" id="childFullName" placeholder="Enter child's complete name">
                                </div>
                                <div class="col-md-5">
                                    <label for="childBirthDate" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="childBirthDate">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary w-100" onclick="addChildToList()">
                                        <i class="bi bi-plus"></i> Add to List
                                    </button>
                                </div>
                            </div>

                            <div id="childrenList" class="border rounded p-3 bg-light text-center">
                                <i class="bi bi-person-plus display-5 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0">No children added yet. Click "Add Child" to start adding.</p>
                            </div>
                        </div>

                        <!-- ================= Form Actions ================= -->
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="clearForm()">
                                <i class="bi bi-arrow-clockwise"></i> Clear Form
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Family Background
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


    <!-- jQuery -->
    <script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script>
$(document).ready(function () {
    // Load existing family background
    $.getJSON("<?= base_url('employee/famback/get') ?>", function (res) {
        if (res.success && res.data) {
            const d = res.data;

            // Prefill spouse
            $("#spouseSurname").val(d.spouse_surname || "");
            $("#spouseFirstName").val(d.spouse_first_name || "");
            $("#spouseMiddleName").val(d.spouse_middle_name || "");
            $("#spouseNameExtension").val(d.spouse_name_extension || "");
            $("#spouseOccupation").val(d.spouse_occupation || "");
            $("#spouseEmployer").val(d.spouse_employer_name || "");
            $("#spouseBusinessAddress").val(d.spouse_business_address || "");
            $("#spouseTelephoneNo").val(d.spouse_telephone_no || "");

            // Prefill father
            $("#fatherSurname").val(d.father_surname || "");
            $("#fatherFirstName").val(d.father_first_name || "");
            $("#fatherMiddleName").val(d.father_middle_name || "");
            $("#fatherNameExtension").val(d.father_name_extension || "");

            // Prefill mother
            $("#motherMaidenName").val(d.mother_maiden_name || "");
            $("#motherSurname").val(d.mother_surname || "");
            $("#motherFirstName").val(d.mother_first_name || "");
            $("#motherMiddleName").val(d.mother_middle_name || "");

            // Prefill children
            if (Array.isArray(d.children) && d.children.length) {
                $("#childrenList").empty();
                d.children.forEach(c => {
                    $("#childrenList").append(renderChildItem(c.child_name, c.child_birthdate));
                });
            }
        }
    });

    // Add new child
    window.addChildToList = function () {
        const name = $("#childFullName").val().trim();
        const dob = $("#childBirthDate").val();

        if (!name || !dob) return alert("⚠️ Fill out both child name and birthdate.");

        $("#childrenList").append(renderChildItem(name, dob));
        $("#childFullName").val("");
        $("#childBirthDate").val("");
    };

    // Render child row
    function renderChildItem(name = "", dob = "") {
        return `<div class="child-item mb-2 d-flex gap-2 align-items-center">
            <input type="text" class="form-control child-name" value="${name}" placeholder="Child Name">
            <input type="date" class="form-control child-birthdate" value="${dob}">
            <button type="button" class="btn btn-danger btn-sm remove-child">
                <i class="bi bi-trash"></i>
            </button>
        </div>`;
    }

    // Remove child
    $(document).on("click", ".remove-child", function () {
        $(this).closest(".child-item").remove();
    });

    // Clear form
    window.clearForm = function () {
        $("#familyBackgroundForm")[0].reset();
        $("#childrenList").html('<div class="text-center text-muted py-3"><i class="bi bi-person-plus display-4 mb-2"></i><p class="mb-0">No children added yet. Click "Add Child" to start adding children.</p></div>');
    };

    // Submit form
    $("#familyBackgroundForm").on("submit", function (e) {
        e.preventDefault();

        const children = [];
        const seen = new Set();
        let hasError = false;

        $("#childrenList .child-item").each(function () {
            const name = $(this).find(".child-name").val().trim();
            const dob = $(this).find(".child-birthdate").val();
            if (!name || !dob) hasError = true;
            const key = name + "|" + dob;
            if (!seen.has(key)) {
                seen.add(key);
                children.push({ child_name: name, child_birthdate: dob });
            }
        });

        if (hasError) return alert("⚠️ Please complete all child fields.");

        const payload = {
            spouse_surname: $("#spouseSurname").val(),
            spouse_first_name: $("#spouseFirstName").val(),
            spouse_middle_name: $("#spouseMiddleName").val(),
            spouse_name_extension: $("#spouseNameExtension").val(),
            spouse_occupation: $("#spouseOccupation").val(),
            spouse_employer_name: $("#spouseEmployer").val(),
            spouse_business_address: $("#spouseBusinessAddress").val(),
            spouse_telephone_no: $("#spouseTelephoneNo").val(),
            father_surname: $("#fatherSurname").val(),
            father_first_name: $("#fatherFirstName").val(),
            father_middle_name: $("#fatherMiddleName").val(),
            father_name_extension: $("#fatherNameExtension").val(),
            mother_maiden_name: $("#motherMaidenName").val(),
            mother_surname: $("#motherSurname").val(),
            mother_first_name: $("#motherFirstName").val(),
            mother_middle_name: $("#motherMiddleName").val(),
            children: children
        };

        $.ajax({
            url: "<?= base_url('employee/famback/save') ?>",
            type: "POST",
            data: JSON.stringify(payload),
            contentType: "application/json",
            success: function (res) {
                if (res.success) {
                    alert("✅ " + res.message);
                    if (res.redirect) window.location.href = res.redirect;
                } else {
                    alert("❌ " + (res.error || res.message));
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("❌ Failed to save. Please try again.");
            }
        });
    });
});
</script>

</body>
</html>
