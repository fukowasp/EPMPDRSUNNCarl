<div class="modal fade" id="viewPDSModal" tabindex="-1" aria-labelledby="viewPDSModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header text-white" style="background: linear-gradient(90deg, #1e3a8a, #059669);">
        <h5 class="modal-title fw-bold" id="viewPDSModalLabel">
          <i class="bi bi-person-vcard me-2"></i>Employee Personal Data Sheet (PDS)
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <!-- Section Buttons -->
        <div class="mb-3 d-flex flex-wrap gap-2">
          <button class="btn btn-outline-primary btn-sm pds-tab-btn active" data-target="personal-info">Personal Info</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="family-info">Family Background</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="education-info">Education</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="graduate-studies">Graduate Studies</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="civil-service">Civil Service</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="work-exp">Work Experience</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="vol-work">Voluntary Work</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="learning-dev">Learning & Development</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="other-info">Other Information</button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn" data-target="c4-sections">C4 Sections</button>
        </div>

        <!-- Sections -->
        <div id="pds_sections">
          <!-- Personal Info -->
          <div class="pds-section" id="personal-info">
            <h6 class="fw-bold text-uppercase mb-2">Personal Information</h6>
            <table class="table table-borderless table-sm">
              <tr><th>Employee ID:</th><td id="pds_employee_id">—</td></tr>
              <tr><th>Surname:</th><td id="pds_surname">—</td></tr>
              <tr><th>First Name:</th><td id="pds_first_name">—</td></tr>
              <tr><th>Middle Name:</th><td id="pds_middle_name">—</td></tr>
              <tr><th>Name Extension (Jr./Sr.):</th><td id="pds_name_ext">—</td></tr>
              <tr><th>Department:</th><td id="pds_department">—</td></tr>
              <tr><th>Employment Type:</th><td id="pds_employment_type">—</td></tr>
              <tr><th>Mobile No:</th><td id="pds_mobile_no">—</td></tr>
              <tr><th>Email:</th><td id="pds_email">—</td></tr>
              <tr><th>Date of Birth:</th><td id="pds_dob">—</td></tr>
              <tr><th>Place of Birth:</th><td id="pds_pob">—</td></tr>
              <tr><th>Sex:</th><td id="pds_sex">—</td></tr>
              <tr><th>Civil Status:</th><td id="pds_civil_status">—</td></tr>
              <tr><th>Height (m):</th><td id="pds_height">—</td></tr>
              <tr><th>Weight (kg):</th><td id="pds_weight">—</td></tr>
              <tr><th>Blood Type:</th><td id="pds_blood_type">—</td></tr>
              <tr><th>GSIS ID:</th><td id="pds_gsis">—</td></tr>
              <tr><th>PAG-IBIG ID:</th><td id="pds_pagibig">—</td></tr>
              <tr><th>PhilHealth No:</th><td id="pds_philhealth">—</td></tr>
              <tr><th>SSS No:</th><td id="pds_sss">—</td></tr>
              <tr><th>TIN No:</th><td id="pds_tin">—</td></tr>
              <tr><th>Agency Employee No:</th><td id="pds_agency_no">—</td></tr>
              <tr><th>Citizenship:</th><td id="pds_citizenship">—</td></tr>
              <tr><th>Dual Citizenship By:</th><td id="pds_dual_by">—</td></tr>
              <tr><th>Dual Citizenship Country:</th><td id="pds_dual_country">—</td></tr>
              <tr><th>Residential Address:</th><td id="pds_res_address">—</td></tr>
              <tr><th>Permanent Address:</th><td id="pds_perm_address">—</td></tr>
              <tr><th>Telephone No:</th><td id="pds_telephone">—</td></tr>
            </table>
          </div>

          <!-- Family Info -->
          <div class="pds-section d-none" id="family-info">
            <h6 class="fw-bold text-uppercase mb-2">Family Background</h6>
            <table class="table table-borderless table-sm">
              <tr><th>Spouse Name:</th><td id="pds_spouse_name">—</td></tr>
              <tr><th>Occupation:</th><td id="pds_spouse_occupation">—</td></tr>
              <tr><th>Employer / Business:</th><td id="pds_spouse_employer">—</td></tr>
              <tr><th>Business Address:</th><td id="pds_spouse_address">—</td></tr>
              <tr><th>Telephone No.:</th><td id="pds_spouse_phone">—</td></tr>
              <tr><th>Father's Full Name:</th><td id="pds_father">—</td></tr>
              <tr><th>Mother's Full Name:</th><td id="pds_mother">—</td></tr>
              <tr><th>Mother's Maiden Name:</th><td id="pds_mother_maiden">—</td></tr>
            </table>
          </div>

          <!-- Education Info -->
          <div class="pds-section d-none" id="education-info">
            <h6 class="fw-bold text-uppercase mb-2">Educational Background</h6>
            <table class="table table-borderless table-sm">
              <tr><th>Elementary School:</th><td id="pds_elem_school">—</td></tr>
              <tr><th>Year Graduated:</th><td id="pds_elem_year">—</td></tr>
              <tr><th>Scholarship / Honor:</th><td id="pds_elem_honor">—</td></tr>
              <tr><th>Secondary School:</th><td id="pds_sec_school">—</td></tr>
              <tr><th>Year Graduated:</th><td id="pds_sec_year">—</td></tr>
              <tr><th>Scholarship / Honor:</th><td id="pds_sec_honor">—</td></tr>
              <tr><th>Senior High School:</th><td id="pds_shs_school">—</td></tr>
              <tr><th>Year Graduated:</th><td id="pds_shs_year">—</td></tr>
              <tr><th>Scholarship / Honor:</th><td id="pds_shs_honor">—</td></tr>
              <tr><th>Vocational / Trade Course:</th><td id="pds_voc_course">—</td></tr>
              <tr><th>Year Completed:</th><td id="pds_voc_year">—</td></tr>
              <tr><th>Scholarship / Honor:</th><td id="pds_voc_honor">—</td></tr>
              <tr><th>College / University:</th><td id="pds_col_course">—</td></tr>
              <tr><th>Year Graduated:</th><td id="pds_col_year">—</td></tr>
              <tr><th>Units Earned:</th><td id="pds_col_units">—</td></tr>
              <tr><th>Scholarship / Honor:</th><td id="pds_col_honor">—</td></tr>
            </table>
          </div>

          <!-- Graduate Studies -->
          <div class="pds-section d-none" id="graduate-studies">
            <h6 class="fw-bold text-uppercase mb-2">Graduate Studies</h6>
            <table class="table table-borderless table-sm" id="pds_grad_table">
              <thead>
                <tr>
                  <th>Degree / Course</th>
                  <th>Institution</th>
                  <th>Year Graduated</th>
                  <th>Units</th>
                  <th>Specialization</th>
                  <th>Scholarship / Honor</th>
                  <th>Certification</th>
                </tr>
              </thead>
              <tbody>
                <tr><td colspan="7" class="text-muted text-center">No graduate studies recorded.</td></tr>
              </tbody>
            </table>
          </div>

          <!-- Civil Service -->
          <div class="pds-section d-none" id="civil-service">
            <h6 class="fw-bold text-uppercase mb-2">Civil Service Eligibility</h6>
            <table class="table table-borderless table-sm" id="pds_civil_service_table">
              <thead>
                <tr>
                  <th>Eligibility Type</th>
                  <th>Rating</th>
                  <th>Date of Exam / Conferment</th>
                  <th>Place of Exam / Conferment</th>
                  <th>Proof of Certification</th>
                </tr>
              </thead>
              <tbody>
                <tr><td colspan="5" class="text-muted text-center">No civil service eligibility recorded.</td></tr>
              </tbody>
            </table>
          </div>

          <!-- Work Experience -->
          <div class="pds-section d-none" id="work-exp">
            <h6 class="fw-bold text-uppercase mb-2">Work Experience</h6>
            <table class="table table-borderless table-sm" id="pds_work_table">
              <thead>
                <tr>
                  <th>Position Title</th>
                  <th>Company / Organization</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Monthly Salary</th>
                  <th>Salary Grade</th>
                  <th>Appointment Status</th>
                  <th>Government Service</th>
                </tr>
              </thead>
              <tbody>
                <tr><td colspan="8" class="text-muted text-center">No work experience recorded.</td></tr>
              </tbody>
            </table>
          </div>

          <!-- Voluntary Work -->
          <div class="pds-section d-none" id="vol-work">
            <h6 class="fw-bold text-uppercase mb-2">Voluntary Work</h6>
            <table class="table table-borderless table-sm" id="pds_volwork_table">
              <thead>
                <tr>
                  <th>Organization</th>
                  <th>Position / Role</th>
                  <th>Address</th>
                  <th>Date From</th>
                  <th>Date To</th>
                  <th>No. of Hours</th>
                  <th>Proof / Membership ID</th>
                </tr>
              </thead>
              <tbody>
                <tr><td colspan="7" class="text-muted text-center">No voluntary work recorded.</td></tr>
              </tbody>
            </table>
          </div>

          <!-- Learning & Development -->
          <div class="pds-section d-none" id="learning-dev">
            <h6 class="fw-bold text-uppercase mb-2">Learning & Development</h6>
            <table class="table table-borderless table-sm" id="pds_learningdev_table">
              <thead>
                <tr>
                  <th>Title of Learning and Development</th>
                  <th>Date From</th>
                  <th>Date To</th>
                  <th>Number of Hours</th>
                  <th>Type of LD</th>
                  <th>Conducted / Sponsored By</th>
                  <th>Proof / Certification</th>
                </tr>
              </thead>
              <tbody>
                <tr><td colspan="7" class="text-muted text-center">No learning and development record found.</td></tr>
              </tbody>
            </table>
          </div>
            <!-- Other Information -->
            <div class="pds-section d-none" id="other-info">
              <h6 class="fw-bold text-uppercase mb-2">Other Information</h6>

              <table class="table table-borderless table-sm" id="pds_otherinfo_table">
                <thead>
                  <tr>
                    <th>Special Skills and Hobbies</th>
                    <th>Non-Academic Distinctions / Recognition</th>
                    <th>Membership in Association / Organization</th>
                    <th>Proof of ID Membership</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="4" class="text-muted text-center">No other information recorded.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- C4 Sections -->
            <div class="pds-section d-none" id="c4-sections">
              <h6 class="fw-bold text-uppercase mb-3">C4 Sections</h6>

              <div class="row g-3">
                <!-- Left Column -->
                <div class="col-lg-6 col-md-12">
                  <div class="card shadow-sm p-3">
                    <h6 class="fw-bold text-primary mb-2">Questions</h6>
                    <table class="table table-borderless table-sm mb-0">
                      <tbody>
                        <tr><th>Q34a:</th><td id="c4_q34a">—</td></tr>
                        <tr><th>Q34b:</th><td id="c4_q34b">—</td></tr>
                        <tr><th>Q35a:</th><td id="c4_q35a">—</td></tr>
                        <tr><th>Q35b:</th><td id="c4_q35b">—</td></tr>
                        <tr><th>Q35b Date Filed:</th><td id="c4_q35b_datefiled">—</td></tr>
                        <tr><th>Q35b Status:</th><td id="c4_q35b_status"><span class="badge bg-success">—</span></td></tr>
                        <tr><th>Q36:</th><td id="c4_q36">—</td></tr>
                        <tr><th>Q37:</th><td id="c4_q37">—</td></tr>
                        <tr><th>Q38a:</th><td id="c4_q38a">—</td></tr>
                        <tr><th>Q38b:</th><td id="c4_q38b">—</td></tr>
                        <tr><th>Q39:</th><td id="c4_q39">—</td></tr>
                        <tr><th>Q40a:</th><td id="c4_q40a">—</td></tr>
                        <tr><th>Q40b:</th><td id="c4_q40b">—</td></tr>
                        <tr><th>Q40c:</th><td id="c4_q40c">—</td></tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6 col-md-12">
                  <div class="card shadow-sm p-3">
                    <h6 class="fw-bold text-primary mb-2">References & IDs</h6>
                    <table class="table table-borderless table-sm mb-3">
                      <tbody>
                        <tr><th>Ref Name 1:</th><td id="c4_ref_name1">—</td></tr>
                        <tr><th>Ref Address 1:</th><td id="c4_ref_address1">—</td></tr>
                        <tr><th>Ref Tel 1:</th><td id="c4_ref_tel1">—</td></tr>
                        <tr><th>Ref Name 2:</th><td id="c4_ref_name2">—</td></tr>
                        <tr><th>Ref Address 2:</th><td id="c4_ref_address2">—</td></tr>
                        <tr><th>Ref Tel 2:</th><td id="c4_ref_tel2">—</td></tr>
                      </tbody>
                    </table>

                    <div class="d-flex align-items-center mt-2 gap-3">
                      <div>
                        <label class="form-label fw-bold mb-1">Photo</label>
                        <div id="c4_photo">—</div>
                      </div>
                      <div>
                        <label class="form-label fw-bold mb-1">Gov ID</label>
                        <div><span id="c4_gov_id" class="badge bg-info me-1">—</span></div>
                        <div><span id="c4_gov_id_no" class="badge bg-warning text-dark me-1">—</span></div>
                        <div><span id="c4_gov_id_issue" class="badge bg-secondary me-1">—</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ✅ UPDATED STYLES -->
<style>
  /* Tab buttons with border and hover effect */
  .pds-tab-btn {
    border-radius: 50px !important;
    background-color: #fff !important;
    border: 2px solid #1e3a8a !important;
    color: #1e3a8a !important;
    font-weight: 600;
    padding: 8px 22px !important;
    transition: all 0.3s ease;
  }

  .pds-tab-btn:hover,
  .pds-tab-btn:focus {
    background-color: #0D6EFF !important;
    color: #fff !important;
    transform: scale(1.05);
  }

  .pds-tab-btn.active {
    background-color: #3f7de0ff !important;
    border-color: #059669 !important;
    color: #fff !important;
  }

  .nav-tabs {
    border: none !important;
  }

  .nav-tabs .nav-link {
    border: none !important;
  }

  .nav-tabs .nav-link:focus-visible {
    outline: none !important;
  }

  
</style>


<script>
  // Tab button click logic
  const tabButtons = document.querySelectorAll('.pds-tab-btn');
  const sections = document.querySelectorAll('.pds-section');

  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      tabButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      sections.forEach(sec => sec.classList.add('d-none'));
      const target = btn.getAttribute('data-target');
      document.getElementById(target).classList.remove('d-none');
    });
  });

</script>
