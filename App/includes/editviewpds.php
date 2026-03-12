<div class="modal fade" id="editPDSModal" tabindex="-1" aria-labelledby="editPDSModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title fw-bold" id="editPDSModalLabel">Edit Personal Data Sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
        <form id="editPDSForm" novalidate enctype="multipart/form-data">
            <!-- Employee ID (Hidden) -->
            <input type="hidden" id="edit_employee_id" name="employee_id" value="">

          <!-- ================= Section Tabs ================= -->
          <div class="mb-3 d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn active" data-target="edit-personal-info">Personal Info</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-family-info">Family Background</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-education-info">Education</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-graduate-studies">Graduate Studies</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-civil-service">Civil Service</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-work-exp">Work Experience</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-vol-work">Voluntary Work</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-learning-dev">Learning & Development</button>
            <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-other-info">Other Information</button>
            <!-- <button type="button" class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="edit-c4-additional-info">Additional Info & Declaration</button> -->
          </div>

          <!-- Sections -->
          <div id="edit_pds_sections">
            <!-- ================= Personal Info Section ================= -->
            <div class="pds-section" id="edit-personal-info">
            <h6 class="fw-bold text-uppercase mb-3">Personal Information</h6>
            <div class="row g-3">
                <!-- ================= Name ================= -->
                <div class="col-md-4">
                <label class="form-label">Surname</label>
                <input type="text" class="form-control" name="surname" id="edit_surname" required>
                </div>
                <div class="col-md-4">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                </div>
                <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input type="text" class="form-control" name="middle_name" id="edit_middle_name">
                </div>
                <div class="col-md-4">
                <label class="form-label">Name Extension</label>
                <input type="text" class="form-control" name="name_extension" id="edit_name_extension" placeholder="Jr./Sr.">
                </div>

                <!-- ================= Birth Info ================= -->
                <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="date_of_birth" id="edit_date_of_birth">
                </div>
                <div class="col-md-4">
                <label class="form-label">Place of Birth</label>
                <input type="text" class="form-control" name="place_of_birth" id="edit_place_of_birth">
                </div>

                <!-- ================= Gender & Civil Status ================= -->
                <div class="col-md-4">
                <label class="form-label">Sex</label>
                <select class="form-select" name="sex" id="edit_sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                </div>
                <div class="col-md-4">
                <label class="form-label">Civil Status</label>
                <select class="form-select" name="civil_status" id="edit_civil_status">
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                    <option value="Other">Other</option>
                </select>
                </div>

                <!-- ================= Citizenship ================= -->
                <div class="col-md-4">
                <label class="form-label">Citizenship</label>
                <select class="form-select" name="citizenship_type" id="edit_citizenship_type">
                    <option value="Filipino">Filipino</option>
                    <option value="Dual Citizenship">Dual Citizenship</option>
                </select>
                </div>
                <div class="col-md-4 d-none" id="dual_citizenship_by_container">
                <label class="form-label">Dual Citizenship By</label>
                <select class="form-select" name="dual_citizenship_by" id="edit_dual_citizenship_by">
                    <option value="birth">Birth</option>
                    <option value="naturalization">Naturalization</option>
                </select>
                </div>
                <div class="col-md-4 d-none" id="dual_citizenship_country_container">
                <label class="form-label">Country of Dual Citizenship</label>
                <input type="text" class="form-control" name="dual_citizenship_country" id="edit_dual_citizenship_country">
                </div>

                <!-- ================= Physical Info ================= -->
                <div class="col-md-6">
                <label class="form-label">Height (m)</label>
                <input type="text" class="form-control" name="height" id="edit_height">
                </div>
                <div class="col-md-6">
                <label class="form-label">Weight (kg)</label>
                <input type="text" class="form-control" name="weight" id="edit_weight">
                </div>
                <div class="col-md-6">
                <label class="form-label">Blood Type</label>
                <input type="text" class="form-control" name="blood_type" id="edit_blood_type">
                </div>

                <!-- ================= Government IDs ================= -->
                <div class="col-md-6">
                <label class="form-label">GSIS No.</label>
                <input type="text" class="form-control" name="gsis_id_no" id="edit_gsis_no">
                </div>
                <div class="col-md-6">
                <label class="form-label">Pag-IBIG No.</label>
                <input type="text" class="form-control" name="pagibig_id_no" id="edit_pagibig_no">
                </div>
                <div class="col-md-6">
                <label class="form-label">PhilHealth No.</label>
                <input type="text" class="form-control" name="philhealth_no" id="edit_philhealth_no">
                </div>
                <div class="col-md-6">
                <label class="form-label">SSS No.</label>
                <input type="text" class="form-control" name="sss_no" id="edit_sss_no">
                </div>
                <div class="col-md-6">
                <label class="form-label">TIN</label>
                <input type="text" class="form-control" name="tin_no" id="edit_tin">
                </div>

                <!-- ================= Residential Address ================= -->
                <div class="col-md-6">
                <label class="form-label">House / Block / Lot</label>
                <input type="text" class="form-control" name="res_house_block_lot" id="edit_res_house_block_lot">
                </div>
                <div class="col-md-6">
                <label class="form-label">Street</label>
                <input type="text" class="form-control" name="res_street" id="edit_res_street">
                </div>
                <div class="col-md-6">
                <label class="form-label">Subdivision</label>
                <input type="text" class="form-control" name="res_subdivision" id="edit_res_subdivision">
                </div>
                <div class="col-md-6">
                <label class="form-label">Barangay</label>
                <input type="text" class="form-control" name="res_barangay" id="edit_res_barangay">
                </div>
                <div class="col-md-6">
                <label class="form-label">City / Municipality</label>
                <input type="text" class="form-control" name="res_city_municipality" id="edit_res_city_municipality">
                </div>
                <div class="col-md-6">
                <label class="form-label">Province</label>
                <input type="text" class="form-control" name="res_province" id="edit_res_province">
                </div>
                <div class="col-md-6">
                <label class="form-label">ZIP Code</label>
                <input type="text" class="form-control" name="res_zip_code" id="edit_res_zip_code">
                </div>

                <!-- ================= Permanent Address ================= -->
                <div class="col-md-6">
                <label class="form-label">House / Block / Lot</label>
                <input type="text" class="form-control" name="perm_house_block_lot" id="edit_perm_house_block_lot">
                </div>
                <div class="col-md-6">
                <label class="form-label">Street</label>
                <input type="text" class="form-control" name="perm_street" id="edit_perm_street">
                </div>
                <div class="col-md-6">
                <label class="form-label">Subdivision</label>
                <input type="text" class="form-control" name="perm_subdivision" id="edit_perm_subdivision">
                </div>
                <div class="col-md-6">
                <label class="form-label">Barangay</label>
                <input type="text" class="form-control" name="perm_barangay" id="edit_perm_barangay">
                </div>
                <div class="col-md-6">
                <label class="form-label">City / Municipality</label>
                <input type="text" class="form-control" name="perm_city_municipality" id="edit_perm_city_municipality">
                </div>
                <div class="col-md-6">
                <label class="form-label">Province</label>
                <input type="text" class="form-control" name="perm_province" id="edit_perm_province">
                </div>
                <div class="col-md-6">
                <label class="form-label">ZIP Code</label>
                <input type="text" class="form-control" name="perm_zip_code" id="edit_perm_zip_code">
                </div>

                <!-- ================= Contact Info ================= -->
                <div class="col-md-6">
                <label class="form-label">Telephone No.</label>
                <input type="text" class="form-control" name="telephone_no" id="edit_telephone_no">
                </div>
                <div class="col-md-6">
                <label class="form-label">Mobile No.</label>
                <input type="text" class="form-control" name="mobile_no" id="edit_mobile_no">
                </div>
                <div class="col-md-12">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email_address" id="edit_email_address">
                </div>

            </div> <!-- end row -->
            </div>

            <!-- ================= Family Background Section ================= -->
            <div class="pds-section d-none" id="edit-family-info">
                <h6 class="fw-bold text-uppercase mb-2">Family Background</h6>

                <div class="row g-3">
                    <!-- Spouse -->
                    <div class="col-md-6">
                        <label>Spouse Surname</label>
                        <input type="text" name="spouse_surname" class="form-control" id="edit_spouse_surname" value="<?= $family_background['spouse_surname'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Spouse First Name</label>
                        <input type="text" name="spouse_first_name" class="form-control" id="edit_spouse_first_name" value="<?= $family_background['spouse_first_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Spouse Middle Name</label>
                        <input type="text" name="spouse_middle_name" class="form-control" id="edit_spouse_middle_name" value="<?= $family_background['spouse_middle_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Spouse Name Extension</label>
                        <input type="text" name="spouse_name_extension" class="form-control" id="edit_spouse_name_extension" value="<?= $family_background['spouse_name_extension'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Spouse Occupation</label>
                        <input type="text" name="spouse_occupation" class="form-control" id="edit_spouse_occupation" value="<?= $family_background['spouse_occupation'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Spouse Employer Name</label>
                        <input type="text" name="spouse_employer_name" class="form-control" id="edit_spouse_employer_name" value="<?= $family_background['spouse_employer_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-12">
                        <label>Spouse Business Address</label>
                        <textarea name="spouse_business_address" class="form-control" id="edit_spouse_business_address"><?= $family_background['spouse_business_address'] ?? '' ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Spouse Telephone No.</label>
                        <input type="text" name="spouse_telephone_no" class="form-control" id="edit_spouse_telephone_no" value="<?= $family_background['spouse_telephone_no'] ?? '' ?>">
                    </div>

                    <!-- Father -->
                    <div class="col-md-6">
                        <label>Father Surname</label>
                        <input type="text" name="father_surname" class="form-control" id="edit_father_surname" value="<?= $family_background['father_surname'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Father First Name</label>
                        <input type="text" name="father_first_name" class="form-control" id="edit_father_first_name" value="<?= $family_background['father_first_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Father Middle Name</label>
                        <input type="text" name="father_middle_name" class="form-control" id="edit_father_middle_name" value="<?= $family_background['father_middle_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Father Name Extension</label>
                        <input type="text" name="father_name_extension" class="form-control" id="edit_father_name_extension" value="<?= $family_background['father_name_extension'] ?? '' ?>">
                    </div>

                    <!-- Mother -->
                    <div class="col-md-6">
                        <label>Mother Maiden Name</label>
                        <input type="text" name="mother_maiden_name" class="form-control" id="edit_mother_maiden_name" value="<?= $family_background['mother_maiden_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Mother Surname</label>
                        <input type="text" name="mother_surname" class="form-control" id="edit_mother_surname" value="<?= $family_background['mother_surname'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Mother First Name</label>
                        <input type="text" name="mother_first_name" class="form-control" id="edit_mother_first_name" value="<?= $family_background['mother_first_name'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Mother Middle Name</label>
                        <input type="text" name="mother_middle_name" class="form-control" id="edit_mother_middle_name" value="<?= $family_background['mother_middle_name'] ?? '' ?>">
                    </div>
                </div>
            </div>



            <!-- Education Section -->
            <div class="pds-section d-none" id="edit-education-info">
              <h6 class="fw-bold text-uppercase mb-2">Educational Background</h6>
              <!-- Education table as inputs or repeatable rows -->
            </div>

            <!-- Graduate Studies Section -->
            <div class="pds-section d-none" id="edit-graduate-studies">
                <h6 class="fw-bold text-uppercase mb-2 d-flex justify-content-between align-items-center">
                    Graduate Studies
                    <button type="button" id="addGradRow" class="btn btn-sm btn-success">+ Add</button>
                </h6>
                <table class="table table-sm table-bordered" id="edit_grad_table">
                    <thead>
                    <tr>
                        <th>Degree / Course</th>
                        <th>Institution</th>
                        <th>Year Graduated</th>
                        <th>Units</th>
                        <th>Specialization</th>
                        <th>Scholarship / Honor</th>
                        <th>Certification</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Rows dynamically created by JS -->
                    </tbody>
                </table>
            </div>


            <!-- Civil Service Section -->
            <div class="pds-section d-none" id="edit-civil-service">
                <h6 class="fw-bold text-uppercase mb-2 d-flex justify-content-between align-items-center">
                    Civil Service Eligibility
                    <button type="button" id="addCivilRow" class="btn btn-sm btn-success">+ Add</button>
                </h6>

                <table class="table table-sm table-bordered" id="edit_civil_table">
                    <thead>
                        <tr>
                            <th>Career Service</th>
                            <th>Rating</th>
                            <th>Date of Examination</th>
                            <th>Place of Examination</th>
                            <th>Proof of Certification</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- rows inserted via JS -->
                    </tbody>
                </table>
            </div>

            <!-- Work Experience Section -->
            <div class="pds-section d-none" id="edit-work-exp">
                <h6 class="fw-bold text-uppercase mb-2 d-flex justify-content-between align-items-center">
                    Work Experience
                    <button type="button" id="addWorkRow" class="btn btn-sm btn-success">+ Add</button>
                </h6>
                <table class="table table-sm table-bordered" id="edit_work_table">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Company</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Monthly Salary</th>
                            <th>Salary Grade</th>
                            <th>Status</th>
                            <th>Gov't Service</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows dynamically created by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Voluntary Work Section -->
            <div class="pds-section d-none" id="edit-vol-work">
                <h6 class="fw-bold text-uppercase mb-2 d-flex justify-content-between align-items-center">
                    Voluntary Work or Involvement
                    <button type="button" id="addVoluntaryRow" class="btn btn-sm btn-success">+ Add</button>
                </h6>
                <table class="table table-sm table-bordered" id="edit_voluntary_table">
                    <thead>
                        <tr>
                            <th>Organization Name</th>
                            <th>Position / Role</th>
                            <th>Address</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Number of Hours</th>
                            <th>Membership ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows dynamically created by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Learning and Development Section -->
            <div class="pds-section d-none" id="edit-learning-dev">
                <h6 class="fw-bold text-uppercase mb-2 d-flex justify-content-between align-items-center">
                    Learning and Development (L&D) Interventions/Training Programs Attended
                    <button type="button" id="addLearningRow" class="btn btn-sm btn-success">+ Add</button>
                </h6>
                <table class="table table-sm table-bordered" id="edit_learning_table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Number of Hours</th>
                            <th>Type of LD</th>
                            <th>Conducted / Sponsored By</th>
                            <th>Certification</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows dynamically created by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Other Information Section -->
            <div id="edit-other-info" class="pds-section d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-uppercase">Other Information</h6>
                    <button type="button" class="btn btn-sm btn-success" id="addOtherInfoRow">
                        <i class="bi bi-plus-circle me-1"></i>Add Other Information
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="edit_other_table">
                        <thead class="table-light">
                            <tr>
                                <th>Special Skills / Hobbies</th>
                                <th>Non-Academic Recognition</th>
                                <th>Membership / Organization</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer" style="position: sticky; bottom: 0; background: #fff; z-index: 10;">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const editTabButtons = document.querySelectorAll('#editPDSModal .pds-tab-btn');
const editSections = document.querySelectorAll('#editPDSModal .pds-section');
const childrenTable = document.querySelector("#edit_children_table tbody");

// Tab switching logic
editTabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        editTabButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        editSections.forEach(sec => sec.classList.add('d-none'));
        const target = btn.getAttribute('data-target');
        document.getElementById(target).classList.remove('d-none');
    });
});

</script>

