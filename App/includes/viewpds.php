<div class="modal fade" id="viewPDSModal" tabindex="-1" aria-labelledby="viewPDSModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="viewPDSModalLabel">
          <i class="bi bi-person-vcard me-2"></i>Employee Personal Data Sheet (PDS)
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body bg-light">
        <!-- Section Buttons -->
        <div class="mb-4 d-flex flex-wrap gap-2 justify-content-center">
          <button class="btn btn-primary btn-sm pds-tab-btn active shadow-sm" data-target="personal-info">
            <i class="bi bi-person me-1"></i>Personal Info
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="family-info">
            <i class="bi bi-people me-1"></i>Family
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="education-info">
            <i class="bi bi-book me-1"></i>Education
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="graduate-studies">
            <i class="bi bi-mortarboard me-1"></i>Graduate Studies
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="civil-service">
            <i class="bi bi-award me-1"></i>Civil Service
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="work-exp">
            <i class="bi bi-briefcase me-1"></i>Work Experience
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="vol-work">
            <i class="bi bi-heart me-1"></i>Voluntary Work
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="learning-dev">
            <i class="bi bi-lightbulb me-1"></i>Learning & Dev
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="other-info">
            <i class="bi bi-info-circle me-1"></i>Other Info
          </button>
          <button class="btn btn-outline-primary btn-sm pds-tab-btn shadow-sm" data-target="c4-additional-info">
            <i class="bi bi-file-text me-1"></i>Declaration
          </button>
        </div>

        <!-- Sections Container -->
        <div id="pds_sections" class="bg-white rounded shadow-sm p-4">
          
          <!-- Personal Info -->
          <div class="pds-section" id="personal-info">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-person-circle fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Personal Information</h5>
            </div>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-sm table-hover">
                  <tr><th width="40%">Employee ID:</th><td id="pds_employee_id" class="fw-semibold">—</td></tr>
                  <tr><th>Surname:</th><td id="pds_surname" class="fw-semibold">—</td></tr>
                  <tr><th>First Name:</th><td id="pds_first_name" class="fw-semibold">—</td></tr>
                  <tr><th>Middle Name:</th><td id="pds_middle_name">—</td></tr>
                  <tr><th>Name Extension:</th><td id="pds_name_ext">—</td></tr>
                  <tr><th>Department:</th><td id="pds_department" class="fw-semibold">—</td></tr>
                  <tr><th>Employment Type:</th><td id="pds_employment_type">—</td></tr>
                  <tr><th>Mobile No:</th><td id="pds_mobile_no">—</td></tr>
                  <tr><th>Email:</th><td id="pds_email">—</td></tr>
                  <tr><th>Date of Birth:</th><td id="pds_dob">—</td></tr>
                  <tr><th>Place of Birth:</th><td id="pds_pob">—</td></tr>
                  <tr><th>Sex:</th><td id="pds_sex">—</td></tr>
                  <tr><th>Civil Status:</th><td id="pds_civil_status">—</td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-sm table-hover">
                  <tr><th width="40%">Height (m):</th><td id="pds_height">—</td></tr>
                  <tr><th>Weight (kg):</th><td id="pds_weight">—</td></tr>
                  <tr><th>Blood Type:</th><td id="pds_blood_type">—</td></tr>
                  <tr><th>GSIS ID:</th><td id="pds_gsis">—</td></tr>
                  <tr><th>PAG-IBIG ID:</th><td id="pds_pagibig">—</td></tr>
                  <tr><th>PhilHealth No:</th><td id="pds_philhealth">—</td></tr>
                  <tr><th>SSS No:</th><td id="pds_sss">—</td></tr>
                  <tr><th>TIN No:</th><td id="pds_tin">—</td></tr>
                  <tr><th>Agency Employee No:</th><td id="pds_agency_no">—</td></tr>
                  <tr><th>Citizenship:</th><td id="pds_citizenship">—</td></tr>
                  <tr><th>Residential Address:</th><td id="pds_residential_address">—</td></tr>
                  <tr><th>Permanent Address:</th><td id="pds_permanent_address">—</td></tr>
                  <tr><th>Telephone No:</th><td id="pds_telephone">—</td></tr>
                </table>
              </div>
            </div>
          </div>

          <!-- Family Info -->
          <div class="pds-section d-none" id="family-info">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-people-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Family Background</h5>
            </div>
            <h6 class="fw-semibold text-secondary mb-3">Spouse Information</h6>
            <table class="table table-sm table-hover mb-4">
              <tr><th width="30%">Spouse Name:</th><td id="pds_spouse_name">—</td></tr>
              <tr><th>Occupation:</th><td id="pds_spouse_occupation">—</td></tr>
              <tr><th>Employer / Business:</th><td id="pds_spouse_employer">—</td></tr>
              <tr><th>Business Address:</th><td id="pds_spouse_address">—</td></tr>
              <tr><th>Telephone No.:</th><td id="pds_spouse_phone">—</td></tr>
            </table>

            <h6 class="fw-semibold text-secondary mb-3">Parents Information</h6>
            <table class="table table-sm table-hover mb-4">
              <tr><th width="30%">Father's Full Name:</th><td id="pds_father">—</td></tr>
              <tr><th>Mother's Full Name:</th><td id="pds_mother">—</td></tr>
              <tr><th>Mother's Maiden Name:</th><td id="pds_mother_maiden">—</td></tr>
            </table>

            <h6 class="fw-semibold text-secondary mb-3">Children</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_children_table">
                <thead class="table-primary">
                  <tr>
                    <th>Name</th>
                    <th>Birthdate</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="2" class="text-center text-muted">No children recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Education -->
          <div class="pds-section d-none" id="education-info">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-book-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Educational Background</h5>
            </div>
            <div class="row">
              <div class="col-md-6">
                <h6 class="fw-semibold text-secondary mb-3">Elementary</h6>
                <table class="table table-sm table-hover mb-4">
                  <tr><th width="40%">School:</th><td id="pds_elem_school">—</td></tr>
                  <tr><th>Year Graduated:</th><td id="pds_elem_year">—</td></tr>
                  <tr><th>Honors:</th><td id="pds_elem_honor">—</td></tr>
                </table>

                <h6 class="fw-semibold text-secondary mb-3">Secondary</h6>
                <table class="table table-sm table-hover mb-4">
                  <tr><th width="40%">School:</th><td id="pds_sec_school">—</td></tr>
                  <tr><th>Year Graduated:</th><td id="pds_sec_year">—</td></tr>
                  <tr><th>Honors:</th><td id="pds_sec_honor">—</td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <h6 class="fw-semibold text-secondary mb-3">Senior High School</h6>
                <table class="table table-sm table-hover mb-4">
                  <tr><th width="40%">School:</th><td id="pds_shs_school">—</td></tr>
                  <tr><th>Year Graduated:</th><td id="pds_shs_year">—</td></tr>
                  <tr><th>Honors:</th><td id="pds_shs_honor">—</td></tr>
                </table>

                <h6 class="fw-semibold text-secondary mb-3">Vocational / Trade</h6>
                <table class="table table-sm table-hover mb-4">
                  <tr><th width="40%">Course:</th><td id="pds_voc_course">—</td></tr>
                  <tr><th>Year Completed:</th><td id="pds_voc_year">—</td></tr>
                  <tr><th>Honors:</th><td id="pds_voc_honor">—</td></tr>
                </table>
              </div>
            </div>

            <h6 class="fw-semibold text-secondary mb-3">College / University</h6>
            <table class="table table-sm table-hover">
              <tr><th width="30%">Course:</th><td id="pds_col_course">—</td></tr>
              <tr><th>Year Graduated:</th><td id="pds_col_year">—</td></tr>
              <tr><th>Units Earned:</th><td id="pds_col_units">—</td></tr>
              <tr><th>Honors:</th><td id="pds_col_honor">—</td></tr>
            </table>
          </div>

          <!-- Graduate Studies -->
          <div class="pds-section d-none" id="graduate-studies">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-mortarboard-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Graduate Studies</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_grad_table">
                <thead class="table-primary">
                  <tr>
                    <th>Degree / Course</th>
                    <th>Institution</th>
                    <th>Year</th>
                    <th>Units</th>
                    <th>Specialization</th>
                    <th>Honors</th>
                    <th>Certification</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="7" class="text-muted text-center">No graduate studies recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Civil Service -->
          <div class="pds-section d-none" id="civil-service">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-award-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Civil Service Eligibility</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_civil_service_table">
                <thead class="table-primary">
                  <tr>
                    <th>Eligibility Type</th>
                    <th>Rating</th>
                    <th>Date of Exam</th>
                    <th>Place</th>
                    <th>Certification</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="5" class="text-muted text-center">No civil service eligibility recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Work Experience -->
          <div class="pds-section d-none" id="work-exp">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-briefcase-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Work Experience</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_work_table">
                <thead class="table-primary">
                  <tr>
                    <th>Position</th>
                    <th>Company</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Salary</th>
                    <th>Grade</th>
                    <th>Status</th>
                    <th>Gov't Service</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="8" class="text-muted text-center">No work experience recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Voluntary Work -->
          <div class="pds-section d-none" id="vol-work">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-heart-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Voluntary Work</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_volwork_table">
                <thead class="table-primary">
                  <tr>
                    <th>Organization</th>
                    <th>Position</th>
                    <th>Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Hours</th>
                    <th>Proof</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="7" class="text-muted text-center">No voluntary work recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Learning & Development -->
          <div class="pds-section d-none" id="learning-dev">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-lightbulb-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Learning & Development</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_learningdev_table">
                <thead class="table-primary">
                  <tr>
                    <th>Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Hours</th>
                    <th>Type</th>
                    <th>Conducted By</th>
                    <th>Certification</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="7" class="text-muted text-center">No learning and development recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Other Information -->
          <div class="pds-section d-none" id="other-info">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-info-circle-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Other Information</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm" id="pds_other_table">
                <thead class="table-primary">
                  <tr>
                    <th>Skills & Hobbies</th>
                    <th>Distinctions</th>
                    <th>Memberships</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="3" class="text-muted text-center">No other information recorded</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- C4 Additional Info & Declaration -->
          <div class="pds-section d-none" id="c4-additional-info">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
              <i class="bi bi-file-text-fill fs-4 text-primary me-2"></i>
              <h5 class="mb-0 fw-bold text-primary">Additional Information & Declaration</h5>
            </div>

            <!-- Relatives in Government -->
            <div class="card mb-3 shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">34. Relatives in Government</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Within the third degree:</strong> <span id="q34a" class="ms-2">—</span>
                  </div>
                  <div class="col-md-6">
                    <strong>Within the fourth degree:</strong> <span id="q34b" class="ms-2">—</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Administrative & Criminal Records -->
            <div class="card mb-3 shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">35. Administrative & Criminal Records</h6>
              </div>
              <div class="card-body">
                <p><strong>a. Ever found guilty of administrative offense:</strong> <span id="q35a" class="ms-2">—</span></p>
                <p><strong>b. Ever criminally charged:</strong> <span id="q35b" class="ms-2">—</span></p>
                <div class="row">
                  <div class="col-md-6">
                    <strong>Date Filed:</strong> <span id="q35b_datefiled" class="ms-2">—</span>
                  </div>
                  <div class="col-md-6">
                    <strong>Status:</strong> <span id="q35b_status" class="ms-2">—</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Other Legal & Service Info -->
            <div class="card mb-3 shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">36–38. Other Legal & Service Information</h6>
              </div>
              <div class="card-body">
                <p><strong>36. Conviction of Crime:</strong> <span id="q36" class="ms-2">—</span></p>
                <p><strong>37. Separation from Service:</strong> <span id="q37" class="ms-2">—</span></p>
                <p><strong>38a. Candidate in last election:</strong> <span id="q38a" class="ms-2">—</span></p>
                <p><strong>38b. Resigned to campaign:</strong> <span id="q38b" class="ms-2">—</span></p>
              </div>
            </div>

            <!-- Residency & Special Status -->
            <div class="card mb-3 shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">39–40. Residency and Special Status</h6>
              </div>
              <div class="card-body">
                <p><strong>39. Immigrant/Permanent Resident:</strong> <span id="q39" class="ms-2">—</span></p>
                <div class="row">
                  <div class="col-md-4">
                    <strong>40a. Indigenous group:</strong> <span id="q40a" class="ms-2">—</span>
                  </div>
                  <div class="col-md-4">
                    <strong>40b. Person with disability:</strong> <span id="q40b" class="ms-2">—</span>
                  </div>
                  <div class="col-md-4">
                    <strong>40c. Solo parent:</strong> <span id="q40c" class="ms-2">—</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- References -->
            <div class="card mb-4 shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">41. References</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-sm">
                    <thead class="table-light">
                      <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Tel. No.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="ref_name1">—</td>
                        <td id="ref_address1">—</td>
                        <td id="ref_tel1">—</td>
                      </tr>
                      <tr>
                        <td id="ref_name2">—</td>
                        <td id="ref_address2">—</td>
                        <td id="ref_tel2">—</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Declaration -->
            <div class="card mb-4 shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">42. Declaration</h6>
              </div>
              <div class="card-body">
                <p id="declaration" class="text-justify">—</p>
              </div>
            </div>

            <!-- Signature / Photo / Thumb -->
            <div class="row text-center mb-4">
              <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                  <div class="card-body">
                    <div class="border rounded mb-2" style="width:140px; height:180px; margin:auto; overflow:hidden;">
                      <img id="photo" src="" class="w-100 h-100" style="object-fit:cover; display:none;" alt="Photo">
                      <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                        <i class="bi bi-person-square fs-1"></i>
                      </div>
                    </div>
                    <small class="text-muted">PHOTO</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                  <div class="card-body">
                    <div id="signature" class="border rounded mb-2 p-3" style="height:80px; background:#f8f9fa;">—</div>
                    <small class="text-muted d-block">Signature</small>
                    <small class="text-muted">Date Accomplished</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                  <div class="card-body">
                    <div id="thumb" class="border rounded mb-2 p-3" style="height:80px; background:#f8f9fa;">—</div>
                    <small class="text-muted">Right Thumbmark</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Government ID -->
            <div class="card shadow-sm">
              <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">Government Issued ID</h6>
              </div>
              <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                  <tr><th width="35%">ID:</th><td id="gov_id">—</td></tr>
                  <tr><th>ID/License/Passport No.:</th><td id="gov_id_no">—</td></tr>
                  <tr><th>Date/Place of Issuance:</th><td id="gov_id_issue">—</td></tr>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light">

        <button class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Tab button click logic with smooth transitions
  const tabButtons = document.querySelectorAll('.pds-tab-btn');
  const sections = document.querySelectorAll('.pds-section');

  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Update button states
      tabButtons.forEach(b => {
        b.classList.remove('active', 'btn-primary');
        b.classList.add('btn-outline-primary');
      });
      btn.classList.remove('btn-outline-primary');
      btn.classList.add('active', 'btn-primary');

      // Switch sections with fade effect
      sections.forEach(sec => sec.classList.add('d-none'));
      const target = btn.getAttribute('data-target');
      const targetSection = document.getElementById(target);
      targetSection.classList.remove('d-none');
      
      // Smooth scroll to top of modal body
      document.querySelector('#viewPDSModal .modal-body').scrollTop = 0;
    });
  });


</script>

<!-- Add html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
  /* Clean design enhancements */
  #viewPDSModal .table th {
    color: #495057;
    font-weight: 600;
  }
  
  #viewPDSModal .table-hover tbody tr:hover {
    background-color: #f8f9fa;
  }
  
  #viewPDSModal .pds-tab-btn {
    transition: all 0.3s ease;
    font-weight: 500;
  }
  
  #viewPDSModal .pds-tab-btn:hover {
    transform: translateY(-2px);
  }
  
  #viewPDSModal .card {
    border: none;
    transition: transform 0.2s ease;
  }
  
  #viewPDSModal .card:hover {
    transform: translateY(-2px);
  }
  
  #viewPDSModal .border-bottom {
    border-color: #dee2e6 !important;
  }
  
  #viewPDSModal .modal-body {
    max-height: 70vh;
  }
</style>