<?php
// Admin Employee List View
namespace App\Views\Admin;

include dirname(__DIR__, 2) . '/includes/admin_navbar.php';
include dirname(__DIR__, 2) . '/includes/admin_sidebar.php';
include dirname(__DIR__, 2) . '/includes/editviewpds.php';
include dirname(__DIR__, 2) . '/includes/viewpds.php';
include __DIR__ . '/Modals/addGraduateStudy.php';
include __DIR__ . '/Modals/addEditCivilser.php';
include __DIR__ . '/Modals/addEditWorkExp.php';
include __DIR__ . '/Modals/addEditVolunterWork.php';
include __DIR__ . '/Modals/addEditLearndev.php';
include __DIR__ . '/Modals/addEditOtherinfo.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee List</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">

<!-- Styles -->
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">
</head>
<body>
<div class="main-content p-4" style="margin-left: 250px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-people-fill me-2"></i>Employee List</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="employeeTable" class="table table-striped table-bordered w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>Employment Type</th>
                            <th>Mobile No</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Certificate Preview Modal - WITH PDF.js -->
<div class="modal fade" id="certPreviewModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="certPreviewTitle">Document Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="min-height: 600px; max-height: 80vh; overflow: auto;">
        <!-- Loading Spinner -->
        <div id="certPreviewLoading" class="d-flex justify-content-center align-items-center" style="min-height: 500px;">
          <div class="text-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading document...</p>
          </div>
        </div>
        
        <!-- Image Preview -->
        <div id="certPreviewImageContainer" class="d-none text-center" style="overflow: auto; max-height: 70vh;">
          <img id="certPreviewImage" class="img-fluid" style="max-width: 100%; height: auto;" alt="Certificate">
        </div>
        
        <!-- PDF Preview with PDF.js -->
        <div id="certPreviewPDFContainer" class="d-none" style="width: 100%;">
          <!-- PDF Navigation -->
          <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
            <div>
              <button id="pdf-prev" class="btn btn-sm btn-outline-primary me-2">
                <i class="bi bi-chevron-left"></i> Previous
              </button>
              <button id="pdf-next" class="btn btn-sm btn-outline-primary">
                Next <i class="bi bi-chevron-right"></i>
              </button>
            </div>
            <div>
              <span>Page: <span id="pdf-page-num"></span> / <span id="pdf-page-count"></span></span>
            </div>
            <div>
              <button id="pdf-zoom-out" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-zoom-out"></i>
              </button>
              <button id="pdf-zoom-in" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-zoom-in"></i>
              </button>
            </div>
          </div>
          <!-- PDF Canvas -->
          <div id="pdf-canvas-container" class="text-center" style="overflow: auto; max-height: 60vh;">
            <canvas id="pdf-canvas" style="border: 1px solid #ddd; max-width: 100%;"></canvas>
          </div>
        </div>
        
        <!-- Error Message -->
        <div id="certPreviewError" class="alert alert-danger d-none" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <strong>Failed to load document.</strong>
          <p class="mb-0 mt-2">The document could not be displayed. Please try again.</p>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" id="openInNewTab" class="btn btn-primary d-none" target="_blank">
          <i class="bi bi-box-arrow-up-right me-2"></i>Open in New Tab
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i>Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<!-- PDF.js Library -->
<script src="<?= base_url('dist/pdf/pdf.min.js') ?>"></script>


<script>
$(document).ready(function() {

     pdfjsLib.GlobalWorkerOptions.workerSrc = "<?= base_url('dist/pdf/pdf.worker.min.js') ?>";
    
    // PDF.js State Variables
    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    let scale = 1.5;
    const MIN_SCALE = 0.5;
    const MAX_SCALE = 3.0;
    const SCALE_STEP = 0.25;

    // ========================================
    // PDF RENDERING FUNCTIONS
    // ========================================
    
        function renderPage(num) {
        pageRendering = true;
        
        pdfDoc.getPage(num).then(function(page) {
            const canvas = document.getElementById('pdf-canvas');
            const ctx = canvas.getContext('2d');
            const viewport = page.getViewport({ scale: scale });
            
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            
            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            
            const renderTask = page.render(renderContext);
            
            renderTask.promise.then(function() {
                pageRendering = false;
                
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            }).catch(function(err) {
                pageRendering = false;
            });
        }).catch(function(err) {
            pageRendering = false;
        });
        
        document.getElementById('pdf-page-num').textContent = num;
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    function onNextPage() {
        if (!pdfDoc || pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    function onZoomIn() {
        if (scale >= MAX_SCALE) return;
        scale += SCALE_STEP;
        queueRenderPage(pageNum);
    }

    function onZoomOut() {
        if (scale <= MIN_SCALE) return;
        scale -= SCALE_STEP;
        queueRenderPage(pageNum);
    }

    // ========================================
    // TYPE DETECTION HELPER
    // ========================================
    
    function detectFileType(fullPath) {
        const pathLower = fullPath.toLowerCase();
        
        if (pathLower.includes('/graduate_cert/')) return 'graduate';
        if (pathLower.includes('/civilser/')) return 'civil';
        if (pathLower.includes('/learndev/')) return 'learning';
        if (pathLower.includes('/voluntarywork/')) return 'voluntarywork';
        
        // Default fallback
        return 'voluntarywork';
    }

    // ========================================
    // MODAL RESET FUNCTION
    // ========================================
    
    function resetModal() {
        // Reset PDF variables
        pdfDoc = null;
        pageNum = 1;
        pageRendering = false;
        pageNumPending = null;
        scale = 1.5;
        
        // Clear canvas
        const canvas = document.getElementById('pdf-canvas');
        if(canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
        
        // Clear image
        $('#certPreviewImage').attr('src', '');
        
        // Reset modal state
        $('#certPreviewLoading').removeClass('d-none');
        $('#certPreviewImageContainer').addClass('d-none');
        $('#certPreviewPDFContainer').addClass('d-none');
        $('#certPreviewError').addClass('d-none');
        $('#openInNewTab').addClass('d-none').attr('href', '#');
    }

    // ========================================
    // THUMBNAIL CLICK HANDLER
    // ========================================
    
        $(document).on('click', '.cert-thumbnail', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const fullPath = $(this).data('file');
        const fileName = fullPath.split('/').pop();
        const ext = fileName.split('.').pop().toLowerCase();
        const type = detectFileType(fullPath);

        resetModal();
        const modal = new bootstrap.Modal(document.getElementById('certPreviewModal'), {
            backdrop: 'static',
            keyboard: true
        });
        modal.show();

        if (ext === 'pdf') {
            handlePDFPreview(fileName, type, fullPath);
        } else {
            handleImagePreview(fileName, fullPath);
        }
    });

    // ========================================
    // PDF PREVIEW HANDLER
    // ========================================
    
        function handlePDFPreview(fileName, type, fullPath) {
        $('#certPreviewTitle').text('PDF Document - ' + fileName);
        
        const pdfUrl = '<?= base_url("admin/employeelist/servePDF") ?>?file=' + 
                    encodeURIComponent(fileName) + '&type=' + type;

        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        
        loadingTask.promise.then(function(pdf) {
            pdfDoc = pdf;
            
            document.getElementById('pdf-page-count').textContent = pdf.numPages;
            
            $('#pdf-prev').prop('disabled', pageNum <= 1);
            $('#pdf-next').prop('disabled', pageNum >= pdf.numPages);

            $('#certPreviewLoading').addClass('d-none');
            $('#certPreviewPDFContainer').removeClass('d-none');
            $('#openInNewTab').removeClass('d-none').attr('href', pdfUrl);

            renderPage(1);
        }).catch(function(err) {
            $('#certPreviewLoading').addClass('d-none');
            $('#certPreviewError').removeClass('d-none');
            
            const errorMsg = err.message || 'Unknown error';
            $('#certPreviewError').html(`
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Failed to load PDF document.</strong>
                <p class="mb-0 mt-2">Error: ${errorMsg}</p>
                <p class="mb-0 text-muted small mt-1">File: ${fileName}</p>
            `);
        });
    }

    // ========================================
    // IMAGE PREVIEW HANDLER
    // ========================================
    
    function handleImagePreview(fileName, fullPath) {
        $('#certPreviewTitle').text('Image - ' + fileName);
        
        const img = new Image();
        
        img.onload = function() {
            $('#certPreviewImage').attr('src', fullPath);
            $('#certPreviewLoading').addClass('d-none');
            $('#certPreviewImageContainer').removeClass('d-none');
            $('#openInNewTab').removeClass('d-none').attr('href', fullPath);
        };
        
        img.onerror = function() {
            console.error('Failed to load image:', fullPath);
            $('#certPreviewLoading').addClass('d-none');
            $('#certPreviewError').removeClass('d-none');
            $('#certPreviewError').html(`
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Failed to load image.</strong>
                <p class="mb-0 mt-2">The image could not be displayed.</p>
                <p class="mb-0 text-muted small mt-1">File: ${fileName}</p>
            `);
        };
        
        img.src = fullPath;
    }

    // ========================================
    // EVENT HANDLERS
    // ========================================
    
    // PDF Navigation Controls
    $(document).on('click', '#pdf-prev', onPrevPage);
    $(document).on('click', '#pdf-next', onNextPage);
    $(document).on('click', '#pdf-zoom-in', onZoomIn);
    $(document).on('click', '#pdf-zoom-out', onZoomOut);

    // Update button states after navigation
    $(document).on('click', '#pdf-prev, #pdf-next', function() {
        setTimeout(() => {
            if (pdfDoc) {
                $('#pdf-prev').prop('disabled', pageNum <= 1);
                $('#pdf-next').prop('disabled', pageNum >= pdfDoc.numPages);
            }
        }, 100);
    });

    // Modal cleanup on close
    $('#certPreviewModal').on('hidden.bs.modal', function () {
        resetModal();
    });

    // Keyboard navigation
    $(document).on('keydown', function(e) {
        if (!$('#certPreviewModal').hasClass('show')) return;
        
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                onPrevPage();
                break;
            case 'ArrowRight':
                e.preventDefault();
                onNextPage();
                break;
            case '+':
            case '=':
                e.preventDefault();
                onZoomIn();
                break;
            case '-':
            case '_':
                e.preventDefault();
                onZoomOut();
                break;
        }
    });


    function generateCertThumbnail(filename, baseUrl, altText = 'Certificate') {
        if (!filename) return '—';
        
        const fullUrl = baseUrl + filename;
        const ext = filename.split('.').pop().toLowerCase();
        const isPDF = ext === 'pdf';
        
        // For PDFs, use a simple text badge instead of an icon
        if (isPDF) {
            return `
                <span class="cert-thumbnail badge bg-danger" 
                    style="cursor: pointer; font-size: 14px; padding: 8px 12px;"
                    data-file="${fullUrl}"
                    data-type="pdf"
                    title="Click to preview ${altText}">
                    <i class="bi bi-file-pdf"></i> PDF
                </span>
            `;
        }
        
        // For images, show the actual image
        return `
            <img src="${fullUrl}"
                class="cert-thumbnail"
                style="height: 45px; width: auto; cursor: pointer; border: 1px solid #ddd; border-radius: 4px; padding: 2px;"
                data-file="${fullUrl}"
                data-type="image"
                title="Click to preview ${altText}"
                alt="${altText}">
        `;
    }

    const nv = v => (v === null || v === undefined ? '' : v);

    function populateWorkExperienceTable(workExperiences, employeeId) {
        const tbody = document.querySelector("#edit_work_table tbody");
        if (!tbody) {
            console.error('Work experience table not found!');
            return;
        }
        
        tbody.innerHTML = '';
        
        if (workExperiences && workExperiences.length) {
            workExperiences.forEach(we => {
                const row = document.createElement("tr");
                row.dataset.workId = we.id;
                row.dataset.empId = employeeId;
                row.innerHTML = `
                    <td data-position="${nv(we.work_position)}">${nv(we.work_position)}</td>
                    <td data-company="${nv(we.work_company)}">${nv(we.work_company)}</td>
                    <td data-from="${nv(we.work_date_from)}">${nv(we.work_date_from)}</td>
                    <td data-to="${nv(we.work_date_to)}">${nv(we.work_date_to)}</td>
                    <td data-salary="${nv(we.work_salary)}">${nv(we.work_salary)}</td>
                    <td data-grade="${nv(we.work_grade)}">${nv(we.work_grade)}</td>
                    <td data-status="${nv(we.work_status)}">${nv(we.work_status)}</td>
                    <td data-govt="${nv(we.work_govt_service)}">${nv(we.work_govt_service)}</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button type="button" class="btn btn-sm btn-warning editWork" data-id="${we.id}" data-emp-id="${employeeId}">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger deleteWork" data-id="${we.id}">Delete</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="9" class="text-muted text-center">No work experience recorded.</td></tr>';
        }
    }

    function populateVoluntaryWorkTable(voluntaryWorks, employeeId) {
        const tbody = document.querySelector("#edit_voluntary_table tbody");
        tbody.innerHTML = '';
        
        if (voluntaryWorks && voluntaryWorks.length) {
            voluntaryWorks.forEach(vw => {
                const membershipThumbnail = vw.membership_id_url 
                    ? (() => {

                        const base = "<?= base_url('assets/voluntarywork/') ?>";
                        const file = vw.membership_id_url;
                        const fullUrl = base + file;
                        const ext = file.split('.').pop().toLowerCase();
                        
                        return `
                            <img src="${ext === 'pdf' 
                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                        : fullUrl
                                    }"
                                class="cert-thumbnail"
                                style="height:45px; width:auto; cursor:pointer;"
                                data-file="${fullUrl}"
                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                title="Click to preview">
                        `;
                    })()
                    : '';

                const row = document.createElement("tr");
                row.dataset.voluntaryId = vw.id;
                row.dataset.empId = employeeId;
                row.innerHTML = `
                    <td data-org="${nv(vw.organization_name)}">${nv(vw.organization_name)}</td>
                    <td data-role="${nv(vw.position_role)}">${nv(vw.position_role)}</td>
                    <td data-address="${nv(vw.organization_address)}">${nv(vw.organization_address)}</td>
                    <td data-start="${nv(vw.start_date)}">${nv(vw.start_date)}</td>
                    <td data-end="${nv(vw.end_date)}">${nv(vw.end_date)}</td>
                    <td data-hours="${nv(vw.number_of_hours)}">${nv(vw.number_of_hours)}</td>
                    <td class="text-center">${membershipThumbnail}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning editVoluntary" data-id="${vw.id}" data-emp-id="${employeeId}">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger deleteVoluntary" data-id="${vw.id}">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }
    }

    function populateLearningDevelopmentTable(learningPrograms, employeeId) {
        const tbody = document.querySelector("#edit_learning_table tbody");
        tbody.innerHTML = '';
        
        if (learningPrograms && learningPrograms.length) {
            learningPrograms.forEach(ld => {
                const certThumbnail = ld.ld_certification 
                    ? (() => {
                        const base = "<?= base_url('assets/learndev/') ?>";
                        const file = ld.ld_certification;
                        const ext = file.split('.').pop().toLowerCase();
                        
                        return `
                            <img src="${ext === 'pdf' 
                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                        : base + file
                                    }"
                                class="cert-thumbnail"
                                style="height:45px; width:auto; cursor:pointer;"
                                data-file="${base + file}"
                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                title="Click to preview">
                        `;
                    })()
                    : '';

                const row = document.createElement("tr");
                row.dataset.ldId = ld.id;
                row.dataset.empId = employeeId;
                row.innerHTML = `
                    <td data-title="${nv(ld.ld_title)}">${nv(ld.ld_title)}</td>
                    <td data-from="${nv(ld.ld_date_from)}">${nv(ld.ld_date_from)}</td>
                    <td data-to="${nv(ld.ld_date_to)}">${nv(ld.ld_date_to)}</td>
                    <td data-hours="${nv(ld.ld_hours)}">${nv(ld.ld_hours)}</td>
                    <td data-type="${nv(ld.ld_type)}">${nv(ld.ld_type)}</td>
                    <td data-sponsor="${nv(ld.ld_sponsor)}">${nv(ld.ld_sponsor)}</td>
                    <td class="text-center">${certThumbnail}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning editLearning" data-id="${ld.id}" data-emp-id="${employeeId}">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger deleteLearning" data-id="${ld.id}">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }
    }

    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Initialize DataTable
    const table = $('#employeeTable').DataTable({
        ajax: {
            url: '<?= base_url("admin/employeelist/fetchAllJson") ?>',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'employee_id' },
            { data: null, render: d => `${d.first_name || ''} ${d.surname || ''}`.trim() || '—' },
            { data: 'department' },
            { data: 'employment_type' },
            { data: 'mobile_no', render: d => d || '—' },
            { data: 'email_address', render: d => d || '—' },
            { 
                data: null,
                orderable: false,
                searchable: false,
                render: d => `
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-info btn-sm view-btn" data-id="${d.employee_id}"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${d.employee_id}"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${d.employee_id}"><i class="bi bi-trash"></i></button>
                    </div>
                `
            }
        ],
        responsive: true
    });


    // -------------------- Populate PDS Modal (VIEW ONLY) --------------------
    function populatePDSModal(emp) {
        const pi = emp;

        const map = {
            'pds_employee_id': 'employee_id',
            'pds_surname': 'surname',
            'pds_first_name': 'first_name',
            'pds_middle_name': 'middle_name',
            'pds_name_ext': 'name_extension',
            'pds_department': 'department',
            'pds_employment_type': 'employment_type',
            'pds_mobile_no': 'mobile_no',
            'pds_email': 'email_address',
            'pds_dob': 'date_of_birth',
            'pds_pob': 'place_of_birth',
            'pds_sex': 'sex',
            'pds_civil_status': 'civil_status',
            'pds_height': 'height',
            'pds_weight': 'weight',
            'pds_blood_type': 'blood_type',
            'pds_gsis': 'gsis_id_no',
            'pds_pagibig': 'pagibig_id_no',
            'pds_philhealth': 'philhealth_no',
            'pds_sss': 'sss_no',
            'pds_tin': 'tin_no',
            'pds_agency_no': 'agency_employee_no',
            'pds_citizenship': 'citizenship_type',
            'pds_telephone': 'telephone_no'
        };

        for (const [modalId, key] of Object.entries(map)) {
            $(`#${modalId}`).text(pi[key] ?? '—');
        }

        const formatAddress = parts => parts.filter(Boolean).join(', ') || '—';

        $('#pds_residential_address').text(
            formatAddress([
                pi.res_house_block_lot,
                pi.res_street,
                pi.res_subdivision,
                pi.res_barangay,
                pi.res_city_municipality,
                pi.res_province,
                pi.res_zip_code
            ])
        );

        $('#pds_permanent_address').text(
            formatAddress([
                pi.perm_house_block_lot,
                pi.perm_street,
                pi.perm_subdivision,
                pi.perm_barangay,
                pi.perm_city_municipality,
                pi.perm_province,
                pi.perm_zip_code
            ])
        );

        // -------------------- Family Background --------------------
        const fb = emp.family_background || {};
        const formatFullName = (first, middle, last, ext) =>
            [first, middle, last, ext].filter(Boolean).join(' ').trim() || '—';

        $('#pds_spouse_name').text(formatFullName(fb.spouse_first_name, fb.spouse_middle_name, fb.spouse_surname, fb.spouse_name_extension));
        $('#pds_spouse_occupation').text(fb.spouse_occupation ?? '—');
        $('#pds_spouse_employer').text(fb.spouse_employer_name ?? '—');
        $('#pds_spouse_address').text(fb.spouse_business_address ?? '—');
        $('#pds_spouse_phone').text(fb.spouse_telephone_no ?? '—');
        $('#pds_father').text(formatFullName(fb.father_first_name, fb.father_middle_name, fb.father_surname, fb.father_name_extension));
        $('#pds_mother').text(formatFullName(fb.mother_first_name, fb.mother_middle_name, fb.mother_surname));
        $('#pds_mother_maiden').text(fb.mother_maiden_name ?? '—');

        // -------------------- Children --------------------
        const childrenTableBody = $('#pds_children_table tbody');
        childrenTableBody.empty();

        if (fb.children && fb.children.length > 0) {
            fb.children.forEach(child => {
                const birthdate = child.birthdate ? new Date(child.birthdate).toLocaleDateString() : '—';
                const row = `<tr>
                                <td>${child.name || '—'}</td>
                                <td>${birthdate}</td>
                            </tr>`;
                childrenTableBody.append(row);
            });
        } else {
            childrenTableBody.append(`<tr><td colspan="2" class="text-muted text-center">No children listed</td></tr>`);
        }

        // -------------------- Educational Background --------------------
        const edu = emp.educational_background || {};

        $('#pds_elem_school').text(edu.elementary_school_name ?? '—');
        $('#pds_elem_year').text(edu.elementary_year_graduated ?? '—');
        $('#pds_elem_honor').text(edu.elementary_honor ?? '—');

        $('#pds_sec_school').text(edu.secondary_school_name ?? '—');
        $('#pds_sec_year').text(edu.secondary_year_graduated ?? '—');
        $('#pds_sec_honor').text(edu.secondary_honor ?? '—');

        $('#pds_shs_school').text(edu.seniorhigh_school_name ?? '—');
        $('#pds_shs_year').text(edu.seniorhigh_year_graduated ?? '—');
        $('#pds_shs_honor').text(edu.seniorhigh_honor ?? '—');

        $('#pds_voc_course').text(edu.vocational_course ?? '—');
        $('#pds_voc_year').text(edu.vocational_year_completed ?? '—');
        $('#pds_voc_honor').text(edu.vocational_honor ?? '—');

        $('#pds_col_course').text(edu.college_course ?? '—');
        $('#pds_col_year').text(edu.college_year_graduated ?? '—');
        $('#pds_col_units').text(edu.college_units_earned ?? '—');
        $('#pds_col_honor').text(edu.college_honor ?? '—');

        // -------------------- Graduate Studies --------------------
        const viewGradTableBody = $('#pds_grad_table tbody');
        viewGradTableBody.empty();

        if (emp.graduate_studies && emp.graduate_studies.length > 0) {
            emp.graduate_studies.forEach(gs => {
                const certThumbnail = gs.certification_file 
                    ? (() => {
                        const base = "<?= base_url('assets/graduate_cert/') ?>";
                        const file = gs.certification_file;
                        const ext = file.split('.').pop().toLowerCase();
                        
                        return `
                            <img src="${ext === 'pdf' 
                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                        : base + file
                                    }"
                                class="cert-thumbnail"
                                style="height:45px; width:auto; cursor:pointer;"
                                data-file="${base + file}"
                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                title="Click to preview">
                        `;
                    })()
                    : '—';

                const row = `<tr>
                                <td>${gs.graduate_course || '—'}</td>
                                <td>${gs.institution_name || '—'}</td>
                                <td>${gs.year_graduated || '—'}</td>
                                <td>${gs.units_earned || '—'}</td>
                                <td>${gs.specialization || '—'}</td>
                                <td>${gs.honor_received || '—'}</td>
                                <td class="text-center">${certThumbnail}</td>
                            </tr>`;
                viewGradTableBody.append(row);
            });
        } else {
            viewGradTableBody.append(`<tr><td colspan="7" class="text-muted text-center">No graduate studies recorded.</td></tr>`);
        }

        // -------------------- Civil Service Eligibility --------------------
        const viewCivilTableBody = $('#pds_civil_service_table tbody');
        viewCivilTableBody.empty();

        if (emp.civil_service_eligibility && emp.civil_service_eligibility.length > 0) {
            emp.civil_service_eligibility.forEach(cs => {
                const proofThumbnail = cs.proof_of_certification 
                    ? (() => {
                        const base = "<?= base_url('assets/civilser/') ?>";
                        const file = cs.proof_of_certification;
                        const ext = file.split('.').pop().toLowerCase();
                        
                        return `
                            <img src="${ext === 'pdf' 
                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                        : base + file
                                    }"
                                class="cert-thumbnail"
                                style="height:45px; width:auto; cursor:pointer;"
                                data-file="${base + file}"
                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                title="Click to preview">
                        `;
                    })()
                    : '—';

                const row = `<tr>
                                <td>${cs.career_service || '—'}</td>
                                <td>${cs.rating || '—'}</td>
                                <td>${cs.date_of_examination_conferment || '—'}</td>
                                <td>${cs.place_of_examination_conferment || '—'}</td>
                                <td class="text-center">${proofThumbnail}</td>
                            </tr>`;
                viewCivilTableBody.append(row);
            });
        } else {
            viewCivilTableBody.append(`<tr><td colspan="5" class="text-muted text-center">No civil service eligibility recorded.</td></tr>`);
        }

        // -------------------- Work Experience --------------------
        const viewWorkTableBody = $('#pds_work_table tbody');
        viewWorkTableBody.empty();

        if (emp.work_experience && emp.work_experience.length > 0) {
            emp.work_experience.forEach(we => {
                const row = `<tr>
                                <td>${we.work_position || '—'}</td>
                                <td>${we.work_company || '—'}</td>
                                <td>${we.work_date_from || '—'}</td>
                                <td>${we.work_date_to || '—'}</td>
                                <td>${we.work_salary || '—'}</td>
                                <td>${we.work_grade || '—'}</td>
                                <td>${we.work_status || '—'}</td>
                                <td>${we.work_govt_service || '—'}</td>
                            </tr>`;
                viewWorkTableBody.append(row);
            });
        } else {
            viewWorkTableBody.append(`<tr><td colspan="8" class="text-muted text-center">No work experience recorded.</td></tr>`);
        }

        // -------------------- Voluntary Work --------------------
        const viewVolWorkTableBody = $('#pds_volwork_table tbody');
        viewVolWorkTableBody.empty();

        if (emp.voluntarywork && emp.voluntarywork.length > 0) {
            emp.voluntarywork.forEach(vw => {
                const membershipThumbnail = vw.membership_id_url 
                    ? (() => {
                        const base = "<?= base_url('assets/voluntarywork/') ?>";
                        const file = vw.membership_id_url;
                        const ext = file.split('.').pop().toLowerCase();
                        
                        return `
                            <img src="${ext === 'pdf' 
                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                        : base + file
                                    }"
                                class="cert-thumbnail"
                                style="height:45px; width:auto; cursor:pointer;"
                                data-file="${base + file}"
                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                title="Click to preview">
                        `;
                    })()
                    : '—';

                const row = `<tr>
                                <td>${vw.organization_name || '—'}</td>
                                <td>${vw.position_role || '—'}</td>
                                <td>${vw.organization_address || '—'}</td>
                                <td>${vw.start_date || '—'}</td>
                                <td>${vw.end_date || '—'}</td>
                                <td>${vw.number_of_hours || '—'}</td>
                                <td class="text-center">${membershipThumbnail}</td>
                            </tr>`;
                viewVolWorkTableBody.append(row);
            });
        } else {
            viewVolWorkTableBody.append(`<tr><td colspan="7" class="text-muted text-center">No voluntary work recorded.</td></tr>`);
        }

        // -------------------- Learning & Development --------------------
        const viewLDTableBody = $('#pds_learningdev_table tbody');
        viewLDTableBody.empty();

        if (emp.learning_development_programs && emp.learning_development_programs.length > 0) {
            emp.learning_development_programs.forEach(ld => {
                const certThumbnail = ld.ld_certification 
                    ? (() => {
                        const base = "<?= base_url('assets/learndev/') ?>";
                        const file = ld.ld_certification;
                        const ext = file.split('.').pop().toLowerCase();
                        
                        return `
                            <img src="${ext === 'pdf' 
                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                        : base + file
                                    }"
                                class="cert-thumbnail"
                                style="height:45px; width:auto; cursor:pointer;"
                                data-file="${base + file}"
                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                title="Click to preview">
                        `;
                    })()
                    : '—';

                const row = `<tr>
                                <td>${ld.ld_title || '—'}</td>
                                <td>${ld.ld_date_from || '—'}</td>
                                <td>${ld.ld_date_to || '—'}</td>
                                <td>${ld.ld_hours || '—'}</td>
                                <td>${ld.ld_type || '—'}</td>
                                <td>${ld.ld_sponsor || '—'}</td>
                                <td class="text-center">${certThumbnail}</td>
                            </tr>`;
                viewLDTableBody.append(row);
            });
        } else {
            viewLDTableBody.append(`<tr><td colspan="7" class="text-muted text-center">No learning and development record found.</td></tr>`);
        }

        // -------------------- Other Information --------------------
        const viewOtherTableBody = $('#pds_other_table tbody');
        viewOtherTableBody.empty();

        const skills = emp.other_information_skills || [];
        const recognition = emp.other_information_recognition || [];
        const membership = emp.other_information_membership || [];

        const maxRows = Math.max(skills.length, recognition.length, membership.length);

        if (maxRows > 0) {
            for (let i = 0; i < maxRows; i++) {
                const row = `<tr>
                                <td>${skills[i]?.skill_hobby || '—'}</td>
                                <td>${recognition[i]?.recognition || '—'}</td>
                                <td>${membership[i]?.membership || '—'}</td>
                            </tr>`;
                viewOtherTableBody.append(row);
            }
        } else {
            viewOtherTableBody.append(`<tr><td colspan="3" class="text-muted text-center">No Other Information.</td></tr>`);
        }
    }


    // -------------------- View Employee --------------------
    $('#employeeTable').on('click', '.view-btn', function() {
        const id = $(this).data('id');

        $.ajax({
            url: '<?= base_url("admin/employeelist/getEmployee") ?>',
            type: 'GET',
            data: { employee_id: id },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    populatePDSModal(res.data);
                    new bootstrap.Modal(document.getElementById('viewPDSModal')).show();
                } else {
                    Swal.fire('Error', res.message || 'Employee not found.', 'error');
                }
            }
        });
    });

    // -------------------- Edit Employee --------------------
    $('#editPDSForm').on('submit', function(e){
    e.preventDefault();

        const formData = new FormData(this); // includes arrays + files

        fetch('<?= base_url("admin/employeelist/updateEmployee") ?>', {
            method: 'POST',
            body: formData,
            // DO NOT manually set 'Content-Type'
            headers: {
                'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                Swal.fire('Success', data.message, 'success');

                // Update the modal dynamically
                populatePDSModal(data.data); // <-- Pass the updated employee object

                bootstrap.Modal.getInstance(document.getElementById('editPDSModal')).hide();

                // Refresh the table row without full reload
                const rowIndex = table.rows().eq(0).filter((i) => {
                    return table.cell(i, 0).data() === data.data.employee_id;
                });
                table.row(rowIndex).data(data.data).invalidate(); // update DataTable row
            }
        });
    });


    // -------------------- Edit Button --------------------
    $('#employeeTable').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '<?= base_url("admin/employeelist/getEmployee") ?>',
            type: 'GET',
            data: { employee_id: id },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    const emp = res.data;

                    // ============================================
                    // RESET ALL SECTIONS - SHOW ONLY PERSONAL INFO
                    // ============================================
                    $('.pds-section').addClass('d-none');
                    $('#edit-personal-info').removeClass('d-none');
                    
                    // Reset tab buttons
                    $('.pds-tab-btn').removeClass('active');
                    $('.pds-tab-btn[data-target="edit-personal-info"]').addClass('active');

                    // Null-safe helper
                    const nv = v => (v === null || v === undefined ? '' : v);

                    // --- Personal Info ---
                    $('#edit_employee_id').val(emp.employee_id);
                    $('#edit_surname').val(emp.surname);
                    $('#edit_first_name').val(emp.first_name);
                    $('#edit_middle_name').val(emp.middle_name);
                    $('#edit_name_extension').val(emp.name_extension);
                    $('#edit_date_of_birth').val(emp.date_of_birth);
                    $('#edit_place_of_birth').val(emp.place_of_birth);
                    $('#edit_sex').val(emp.sex);
                    $('#edit_civil_status').val(emp.civil_status);
                    $('#edit_citizenship_type').val(emp.citizenship_type);
                    $('#edit_height').val(emp.height);
                    $('#edit_weight').val(emp.weight);
                    $('#edit_blood_type').val(emp.blood_type);
                    $('#edit_gsis_no').val(emp.gsis_id_no);
                    $('#edit_pagibig_no').val(emp.pagibig_id_no);
                    $('#edit_philhealth_no').val(emp.philhealth_no);
                    $('#edit_sss_no').val(emp.sss_no);
                    $('#edit_tin').val(emp.tin_no);
                    $('#edit_agency_employee_no').val(emp.agency_employee_no);

                    // --- Residential Address ---
                    $('#edit_res_house_block_lot').val(emp.res_house_block_lot);
                    $('#edit_res_street').val(emp.res_street);
                    $('#edit_res_subdivision').val(emp.res_subdivision);
                    $('#edit_res_barangay').val(emp.res_barangay);
                    $('#edit_res_city_municipality').val(emp.res_city_municipality);
                    $('#edit_res_province').val(emp.res_province);
                    $('#edit_res_zip_code').val(emp.res_zip_code);

                    // --- Permanent Address ---
                    $('#edit_perm_house_block_lot').val(emp.perm_house_block_lot);
                    $('#edit_perm_street').val(emp.perm_street);
                    $('#edit_perm_subdivision').val(emp.perm_subdivision);
                    $('#edit_perm_barangay').val(emp.perm_barangay);
                    $('#edit_perm_city_municipality').val(emp.perm_city_municipality);
                    $('#edit_perm_province').val(emp.perm_province);
                    $('#edit_perm_zip_code').val(emp.perm_zip_code);

                    $('#edit_telephone_no').val(emp.telephone_no);
                    $('#edit_mobile_no').val(emp.mobile_no);
                    $('#edit_email_address').val(emp.email_address);
                    
                    // --- Family Background ---
                    if(emp.family_background){
                        const fam = emp.family_background;
                        
                        $('#edit_spouse_surname').val(fam.spouse_surname || '');
                        $('#edit_spouse_first_name').val(fam.spouse_first_name || '');
                        $('#edit_spouse_middle_name').val(fam.spouse_middle_name || '');
                        $('#edit_spouse_name_extension').val(fam.spouse_name_extension || '');
                        $('#edit_spouse_occupation').val(fam.spouse_occupation || '');
                        $('#edit_spouse_employer_name').val(fam.spouse_employer_name || '');
                        $('#edit_spouse_business_address').val(fam.spouse_business_address || '');
                        $('#edit_spouse_telephone_no').val(fam.spouse_telephone_no || '');

                        $('#edit_father_surname').val(fam.father_surname || '');
                        $('#edit_father_first_name').val(fam.father_first_name || '');
                        $('#edit_father_middle_name').val(fam.father_middle_name || '');
                        $('#edit_father_name_extension').val(fam.father_name_extension || '');

                        $('#edit_mother_maiden_name').val(fam.mother_maiden_name || '');
                        $('#edit_mother_surname').val(fam.mother_surname || '');
                        $('#edit_mother_first_name').val(fam.mother_first_name || '');
                        $('#edit_mother_middle_name').val(fam.mother_middle_name || '');
                    }

                    // --- Educational Background ---
                    if (emp.educational_background) {
                        const edu = emp.educational_background;

                        $('#edit-education-info').html(`
                            <h6 class="fw-bold text-uppercase mb-2">Educational Background</h6>

                            <div class="row g-3">

                                <!-- Elementary -->
                                <div class="col-md-6">
                                    <label>Elementary School</label>
                                    <input type="text" name="elementary_school_name" class="form-control"
                                        value="${nv(edu.elementary_school_name)}">
                                </div>

                                <div class="col-md-6">
                                    <label>Year Graduated</label>
                                    <input type="text" name="elementary_year_graduated" class="form-control"
                                        value="${nv(edu.elementary_year_graduated)}">
                                </div>

                                <div class="col-md-12">
                                    <label>Honors Received</label>
                                    <input type="text" name="elementary_honor" class="form-control"
                                        value="${nv(edu.elementary_honor)}">
                                </div>

                                <!-- Secondary -->
                                <div class="col-md-6">
                                    <label>Secondary School</label>
                                    <input type="text" name="secondary_school_name" class="form-control"
                                        value="${nv(edu.secondary_school_name)}">
                                </div>

                                <div class="col-md-6">
                                    <label>Year Graduated</label>
                                    <input type="text" name="secondary_year_graduated" class="form-control"
                                        value="${nv(edu.secondary_year_graduated)}">
                                </div>

                                <div class="col-md-12">
                                    <label>Honors Received</label>
                                    <input type="text" name="secondary_honor" class="form-control"
                                        value="${nv(edu.secondary_honor)}">
                                </div>

                                <!-- Senior High -->
                                <div class="col-md-6">
                                    <label>Senior High School</label>
                                    <input type="text" name="seniorhigh_school_name" class="form-control"
                                        value="${nv(edu.seniorhigh_school_name)}">
                                </div>

                                <div class="col-md-6">
                                    <label>Year Graduated</label>
                                    <input type="text" name="seniorhigh_year_graduated" class="form-control"
                                        value="${nv(edu.seniorhigh_year_graduated)}">
                                </div>

                                <div class="col-md-12">
                                    <label>Honors Received</label>
                                    <input type="text" name="seniorhigh_honor" class="form-control"
                                        value="${nv(edu.seniorhigh_honor)}">
                                </div>

                                <!-- Vocational -->
                                <div class="col-md-6">
                                    <label>Vocational Course</label>
                                    <input type="text" name="vocational_course" class="form-control"
                                        value="${nv(edu.vocational_course)}">
                                </div>

                                <div class="col-md-3">
                                    <label>Year Completed</label>
                                    <input type="text" name="vocational_year_completed" class="form-control"
                                        value="${nv(edu.vocational_year_completed)}">
                                </div>

                                <div class="col-md-3">
                                    <label>Honor</label>
                                    <input type="text" name="vocational_honor" class="form-control"
                                        value="${nv(edu.vocational_honor)}">
                                </div>

                                <!-- College -->
                                <div class="col-md-6">
                                    <label>College Course</label>
                                    <input type="text" name="college_course" class="form-control"
                                        value="${nv(edu.college_course)}">
                                </div>

                                <div class="col-md-3">
                                    <label>Year Graduated</label>
                                    <input type="text" name="college_year_graduated" class="form-control"
                                        value="${nv(edu.college_year_graduated)}">
                                </div>

                                <div class="col-md-3">
                                    <label>Units Earned</label>
                                    <input type="text" name="college_units_earned" class="form-control"
                                        value="${nv(edu.college_units_earned)}">
                                </div>

                                <div class="col-md-12">
                                    <label>Honor</label>
                                    <input type="text" name="college_honor" class="form-control"
                                        value="${nv(edu.college_honor)}">
                                </div>

                            </div>
                        `);
                    }

                    // --- Graduate Studies ---
                    const gradTableBody = document.querySelector("#edit_grad_table tbody");
                    gradTableBody.innerHTML = '';
                    
                    if (emp.graduate_studies && emp.graduate_studies.length) {
                        emp.graduate_studies.forEach(gs => {
                            const row = document.createElement("tr");
                            row.dataset.gradId = gs.id;
                            row.dataset.empId = emp.employee_id;
                            row.innerHTML = `
                                <td data-course="${nv(gs.graduate_course)}">${nv(gs.graduate_course)}</td>
                                <td data-institution="${nv(gs.institution_name)}">${nv(gs.institution_name)}</td>
                                <td data-year="${nv(gs.year_graduated)}">${nv(gs.year_graduated)}</td>
                                <td data-units="${nv(gs.units_earned)}">${nv(gs.units_earned)}</td>
                                <td data-specialization="${nv(gs.specialization)}">${nv(gs.specialization)}</td>
                                <td data-honor="${nv(gs.honor_received)}">${nv(gs.honor_received)}</td>
                                <td>
                                    ${gs.certification_file
                                        ? (() => {
                                            const base = "<?= base_url('assets/graduate_cert/') ?>";
                                            const file = gs.certification_file;
                                            const ext = file.split('.').pop().toLowerCase();
                                            
                                            return `
                                                <img src="${ext === 'pdf' 
                                                            ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                                            : base + file
                                                        }"
                                                    class="cert-thumbnail"
                                                    style="height:45px; width:auto; cursor:pointer;"
                                                    data-file="${base + file}"
                                                    data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                                    title="Click to preview">
                                            `;
                                        })()
                                        : ''
                                    }
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button type="button" class="btn btn-sm btn-warning editGrad" data-id="${gs.id}" data-emp-id="${emp.employee_id}">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger deleteGrad" data-id="${gs.id}">Delete</button>
                                    </div>
                                </td>
                            `;
                            gradTableBody.appendChild(row);
                        });
                    }

                    // --- Civil Service ---
                    const civilTableBody = document.querySelector("#edit_civil_table tbody");
                    civilTableBody.innerHTML = '';
                    
                    if(emp.civil_service_eligibility && emp.civil_service_eligibility.length){
                        emp.civil_service_eligibility.forEach(cs => {
                            const row = document.createElement("tr");
                            row.dataset.civilId = cs.id;
                            row.dataset.empId = emp.employee_id;
                            row.innerHTML = `
                                <td data-career="${nv(cs.career_service)}">${nv(cs.career_service)}</td>
                                <td data-rating="${nv(cs.rating)}">${nv(cs.rating)}</td>
                                <td data-date="${nv(cs.date_of_examination_conferment)}">${nv(cs.date_of_examination_conferment)}</td>
                                <td data-place="${nv(cs.place_of_examination_conferment)}">${nv(cs.place_of_examination_conferment)}</td>
                                <td>
                                    ${cs.proof_of_certification 
                                        ? (() => {
                                            const base = "<?= base_url('assets/civilser/') ?>";
                                            const file = cs.proof_of_certification;
                                            const ext = file.split('.').pop().toLowerCase();
                                            
                                            return `
                                                <img src="${ext === 'pdf' 
                                                            ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                                            : base + file
                                                        }"
                                                    class="cert-thumbnail"
                                                    style="height:45px; width:auto; cursor:pointer;"
                                                    data-file="${base + file}"
                                                    data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                                    title="Click to preview">
                                            `;
                                        })()
                                        : ''
                                    }
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning editCivil" data-id="${cs.id}" data-emp-id="${emp.employee_id}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger deleteCivil" data-id="${cs.id}">Delete</button>
                                </td>
                            `;
                            civilTableBody.appendChild(row);
                        });
                    }


                    // ==================== WORK EXPERIENCE ====================

                    // Populate Work Experience Table in Edit Modal
                    function populateWorkExperienceTable(workExperiences, employeeId) {
                        const tbody = document.querySelector("#edit_work_table tbody");
                        if (!tbody) {
                            console.error('Work experience table not found!');
                            return;
                        }
                        
                        tbody.innerHTML = '';
                        
                        if (workExperiences && workExperiences.length) {
                            workExperiences.forEach(we => {
                                const row = document.createElement("tr");
                                row.dataset.workId = we.id;
                                row.dataset.empId = employeeId;
                                row.innerHTML = `
                                    <td data-position="${nv(we.work_position)}">${nv(we.work_position)}</td>
                                    <td data-company="${nv(we.work_company)}">${nv(we.work_company)}</td>
                                    <td data-from="${nv(we.work_date_from)}">${nv(we.work_date_from)}</td>
                                    <td data-to="${nv(we.work_date_to)}">${nv(we.work_date_to)}</td>
                                    <td data-salary="${nv(we.work_salary)}">${nv(we.work_salary)}</td>
                                    <td data-grade="${nv(we.work_grade)}">${nv(we.work_grade)}</td>
                                    <td data-status="${nv(we.work_status)}">${nv(we.work_status)}</td>
                                    <td data-govt="${nv(we.work_govt_service)}">${nv(we.work_govt_service)}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button type="button" class="btn btn-sm btn-warning editWork" data-id="${we.id}" data-emp-id="${employeeId}">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger deleteWork" data-id="${we.id}">Delete</button>
                                        </div>
                                    </td>
                                `;
                                tbody.appendChild(row);
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="9" class="text-muted text-center">No work experience recorded.</td></tr>';
                        }
                    }


                    function populateVoluntaryWorkTable(voluntaryWorks, employeeId) {
                        const tbody = document.querySelector("#edit_voluntary_table tbody");
                        tbody.innerHTML = '';
                        
                        if (voluntaryWorks && voluntaryWorks.length) {
                            voluntaryWorks.forEach(vw => {
                                const membershipThumbnail = vw.membership_id_url 
                                    ? (() => {
                                        const base = "<?= base_url('assets/voluntarywork/') ?>";
                                        const file = vw.membership_id_url;
                                        const ext = file.split('.').pop().toLowerCase();
                                        
                                        return `
                                            <img src="${ext === 'pdf' 
                                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                                        : base + file
                                                    }"
                                                class="cert-thumbnail"
                                                style="height:45px; width:auto; cursor:pointer;"
                                                data-file="${base + file}"
                                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                                title="Click to preview">
                                        `;
                                    })()
                                    : '';

                                const row = document.createElement("tr");
                                row.dataset.voluntaryId = vw.id;
                                row.dataset.empId = employeeId;
                                row.innerHTML = `
                                    <td data-org="${nv(vw.organization_name)}">${nv(vw.organization_name)}</td>
                                    <td data-role="${nv(vw.position_role)}">${nv(vw.position_role)}</td>
                                    <td data-address="${nv(vw.organization_address)}">${nv(vw.organization_address)}</td>
                                    <td data-start="${nv(vw.start_date)}">${nv(vw.start_date)}</td>
                                    <td data-end="${nv(vw.end_date)}">${nv(vw.end_date)}</td>
                                    <td data-hours="${nv(vw.number_of_hours)}">${nv(vw.number_of_hours)}</td>
                                    <td class="text-center">${membershipThumbnail}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning editVoluntary" data-id="${vw.id}" data-emp-id="${employeeId}">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger deleteVoluntary" data-id="${vw.id}">Delete</button>
                                    </td>
                                `;
                                tbody.appendChild(row);
                            });
                        }
                    }

                    // ==================== LEARNING DEVELOPMENT ====================

                    // Populate Learning Development Table in Edit Modal
                    function populateLearningDevelopmentTable(learningPrograms, employeeId) {
                        const tbody = document.querySelector("#edit_learning_table tbody");
                        tbody.innerHTML = '';
                        
                        if (learningPrograms && learningPrograms.length) {
                            learningPrograms.forEach(ld => {
                                const certThumbnail = ld.ld_certification 
                                    ? (() => {
                                        const base = "<?= base_url('assets/learndev/') ?>";
                                        const file = ld.ld_certification;
                                        const ext = file.split('.').pop().toLowerCase();
                                        
                                        return `
                                            <img src="${ext === 'pdf' 
                                                        ? 'https://cdn-icons-png.flaticon.com/512/337/337946.png' 
                                                        : base + file
                                                    }"
                                                class="cert-thumbnail"
                                                style="height:45px; width:auto; cursor:pointer;"
                                                data-file="${base + file}"
                                                data-type="${ext === 'pdf' ? 'pdf' : 'image'}"
                                                title="Click to preview">
                                        `;
                                    })()
                                    : '';

                                const row = document.createElement("tr");
                                row.dataset.ldId = ld.id;
                                row.dataset.empId = employeeId;
                                row.innerHTML = `
                                    <td data-title="${nv(ld.ld_title)}">${nv(ld.ld_title)}</td>
                                    <td data-from="${nv(ld.ld_date_from)}">${nv(ld.ld_date_from)}</td>
                                    <td data-to="${nv(ld.ld_date_to)}">${nv(ld.ld_date_to)}</td>
                                    <td data-hours="${nv(ld.ld_hours)}">${nv(ld.ld_hours)}</td>
                                    <td data-type="${nv(ld.ld_type)}">${nv(ld.ld_type)}</td>
                                    <td data-sponsor="${nv(ld.ld_sponsor)}">${nv(ld.ld_sponsor)}</td>
                                    <td class="text-center">${certThumbnail}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning editLearning" data-id="${ld.id}" data-emp-id="${employeeId}">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger deleteLearning" data-id="${ld.id}">Delete</button>
                                    </td>
                                `;
                                tbody.appendChild(row);
                            });
                        }
                    }

                    // Helper function to populate Other Information table
                    function populateOtherInformationTable(otherInfo, employeeId) {
                        const tbody = document.querySelector("#edit_other_table tbody");
                        tbody.innerHTML = '';
                        
                        const skills = otherInfo.other_information_skills || [];
                        const recognition = otherInfo.other_information_recognition || [];
                        const membership = otherInfo.other_information_membership || [];
                        
                        const maxRows = Math.max(skills.length, recognition.length, membership.length);
                        
                        if (maxRows > 0) {
                            for (let i = 0; i < maxRows; i++) {
                                const skillData = skills[i] || {};
                                const recognitionData = recognition[i] || {};
                                const membershipData = membership[i] || {};
                                
                                const row = document.createElement("tr");
                                row.dataset.rowIndex = i;
                                row.innerHTML = `
                                    <td data-skill="${nv(skillData.skill_hobby)}" data-skill-id="${skillData.id || ''}">${nv(skillData.skill_hobby)}</td>
                                    <td data-recognition="${nv(recognitionData.recognition)}" data-recognition-id="${recognitionData.id || ''}">${nv(recognitionData.recognition)}</td>
                                    <td data-membership="${nv(membershipData.membership)}" data-membership-id="${membershipData.id || ''}">${nv(membershipData.membership)}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning editOtherInfo" data-row-index="${i}" data-emp-id="${employeeId}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        ${skillData.id || recognitionData.id || membershipData.id ? `
                                        <button type="button" class="btn btn-sm btn-danger deleteOtherInfo" 
                                                data-skill-id="${skillData.id || ''}"
                                                data-recognition-id="${recognitionData.id || ''}"
                                                data-membership-id="${membershipData.id || ''}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        ` : ''}
                                    </td>
                                `;
                                tbody.appendChild(row);
                            }
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-muted text-center">No other information recorded.</td></tr>';
                        }
                    }

                    
                    populateOtherInformationTable(emp, emp.employee_id);
                    populateWorkExperienceTable(emp.work_experience, emp.employee_id);
                    populateVoluntaryWorkTable(emp.voluntarywork, emp.employee_id);
                    populateLearningDevelopmentTable(emp.learning_development_programs, emp.employee_id);

                    // Show modal
                    new bootstrap.Modal(document.getElementById('editPDSModal')).show();
                } else {
                    Swal.fire('Error', res.message || 'Employee data not found.', 'error');
                }
            }
        });
    });


    // Add new Other Information
    $(document).on('click', '#addOtherInfoRow', function() {
        const empId = $('#edit_employee_id').val();
        
        console.log('Adding other information for employee:', empId);
        
        // Reset modal title and form
        $('#otherInfoModalLabel').text('Add Other Information');
        $('#otherInfoForm')[0].reset();
        
        // Clear all hidden fields
        $('.other_info_id').val('');
        $('.other_info_employee_id').val(empId);
        
        // Show modal
        new bootstrap.Modal(document.getElementById('otherInfoModal')).show();
    });

    // Edit Other Information
    $(document).on('click', '.editOtherInfo', function() {
        const row = $(this).closest('tr');
        const empId = $(this).data('emp-id');
        
        // Set modal title
        $('#otherInfoModalLabel').text('Edit Other Information');
        
        // Fill hidden employee ID
        $('.other_info_employee_id').val(empId);
        
        // Get data from row
        const skillId = row.find('td[data-skill-id]').data('skill-id');
        const recognitionId = row.find('td[data-recognition-id]').data('recognition-id');
        const membershipId = row.find('td[data-membership-id]').data('membership-id');
        
        // Store IDs (use the first available ID)
        const mainId = skillId || recognitionId || membershipId || '';
        $('.other_info_id').val(mainId);
        
        // Fill form fields
        $('input[name="skill_hobby"]').val(row.find('td[data-skill]').data('skill'));
        $('input[name="recognition"]').val(row.find('td[data-recognition]').data('recognition'));
        $('input[name="membership"]').val(row.find('td[data-membership]').data('membership'));
        
        // Show modal
        new bootstrap.Modal(document.getElementById('otherInfoModal')).show();
    });

    // Submit Other Information Form
    $('#otherInfoForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Validate: at least one field must be filled
        const skill = formData.get('skill_hobby');
        const recognition = formData.get('recognition');
        const membership = formData.get('membership');
        
        if (!skill && !recognition && !membership) {
            Swal.fire('Warning', 'Please fill in at least one field.', 'warning');
            return;
        }
        
        $.ajax({
            url: '<?= base_url("admin/employeelist/updateEmployee") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Hide the other info modal
                        bootstrap.Modal.getInstance(document.getElementById('otherInfoModal')).hide();
                        
                        // Refresh the other information table in the edit modal
                        populateOtherInformationTable(res.data, res.data.employee_id);
                    });
                } else {
                    Swal.fire('Error', res.message || 'Failed to save.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        });
    });

    // -------------------- Edit Graduate Study --------------------
    $(document).on('click', '.editGrad', function() {

    const row = $(this).closest('tr');

        // Fill modal array inputs
        $('.grad_id').val(row.data('gradId'));
        $('.grad_employee_id').val(row.data('empId'));

        $('input[name="graduate_course[]"]').val(row.find('td[data-course]').data('course'));
        $('input[name="institution_name[]"]').val(row.find('td[data-institution]').data('institution'));
        $('input[name="year_graduated[]"]').val(row.find('td[data-year]').data('year'));
        $('input[name="units_earned[]"]').val(row.find('td[data-units]').data('units'));
        $('input[name="specialization[]"]').val(row.find('td[data-specialization]').data('specialization'));
        $('input[name="honor_received[]"]').val(row.find('td[data-honor]').data('honor'));


        // file input cannot be prefilled
        $('input[name="certification_file[]"]').val('');

        new bootstrap.Modal(document.getElementById('gradModal')).show();
    });

    // -------------------- Add Graduate Study --------------------
    $('#addGradRow').on('click', function() {

        const empId = $('#edit_employee_id').val();

        $('.grad_id').val('');
        $('.grad_employee_id').val(empId);

        $('input[name="graduate_course[]"]').val('');
        $('input[name="institution_name[]"]').val('');
        $('input[name="year_graduated[]"]').val('');
        $('input[name="units_earned[]"]').val('');
        $('input[name="specialization[]"]').val('');
        $('input[name="honor_received[]"]').val('');
        $('input[name="certification_file[]"]').val('');

        new bootstrap.Modal(document.getElementById('gradModal')).show();
    });


    // ======================================================
    // =============== EDIT CIVIL SERVICE ====================
    // ======================================================
    $(document).on('click', '.editCivil', function () {

        const row = $(this).closest('tr');

        // Set modal title
        $('#civilModalLabel').text('Edit Civil Service Eligibility');

        // Fill IDs
        $('.civil_id').val(row.data('civilId'));
        $('.civil_employee_id').val(row.data('empId'));

        // Fill form fields from row data attributes
        $('input[name="career_service"]').val(
            row.find('td[data-career]').data('career')
        );

        $('input[name="rating"]').val(
            row.find('td[data-rating]').data('rating')
        );

        $('input[name="date_of_examination_conferment"]').val(
            row.find('td[data-date]').data('date')
        );

        $('input[name="place_of_examination_conferment"]').val(
            row.find('td[data-place]').data('place')
        );

        // File input cannot be pre-filled!
        $('input[name="proof_of_certification"]').val('');

        // Show modal
        new bootstrap.Modal(document.getElementById('civilModal')).show();
    });


    // ======================================================
    // ================= ADD CIVIL SERVICE ===================
    // ======================================================
    $(document).on('click', '#addCivilRow', function () {

        const empId = $('#edit_employee_id').val(); // same as grad

        // Reset modal title
        $('#civilModalLabel').text('Add Civil Service Eligibility');

        // Clear all fields
        $('.civil_id').val('');
        $('.civil_employee_id').val(empId);

        $('input[name="career_service"]').val('');
        $('input[name="rating"]').val('');
        $('input[name="date_of_examination_conferment"]').val('');
        $('input[name="place_of_examination_conferment"]').val('');
        $('input[name="proof_of_certification"]').val('');

        // Show modal
        new bootstrap.Modal(document.getElementById('civilModal')).show();
    });

    // -------------------- Submit Graduate Study Form --------------------
    $('#gradForm').on('submit', function(e) {
        e.preventDefault(); // prevent default form submission

        const form = this;
        const formData = new FormData(form);

        fetch('<?= base_url("admin/employeelist/updateEmployee") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'CSRF-Token': $('meta[name="csrf-token"]').attr('content') // include CSRF if required
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('gradModal')).hide();
                    $('#employeeTable').DataTable().ajax.reload(null, false); // refresh table without full reload
                });
            } else {
                Swal.fire('Error', data.message || 'Failed to save.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        });
    });

    // ------------- Submit Civil Service Form -------------
    $('#civilForm').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch('<?= base_url("admin/employeelist/updateEmployee") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'CSRF-Token': $('meta[name="csrf-token"]').attr('content') // if CSRF enabled
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('civilModal')).hide();
                    $('#employeeTable').DataTable().ajax.reload(null, false); // reload table
                });
            } else {
                Swal.fire('Error', data.message || 'Failed to save.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        });
    });
    
    // Delete a child immediately
    $(document).on("click", ".deleteChildRow", function () {
        const childId = $(this).data("id");
        const employeeId = $(this).data("employee");

        Swal.fire({
            title: "Delete child?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.post("<?= base_url('admin/employeelist/deleteChild') ?>",
                {
                    id: childId,
                    employee_id: employeeId
                },
                function (res) {
                    if (res.status === "success") {
                        Swal.fire("Deleted!", "Child removed.", "success");
                        $(`button[data-id='${childId}']`).closest("tr").remove();
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                },
                "json"
            );
        });
    });


        // Add new Work Experience
    $(document).on('click', '#addWorkRow', function() {
        const empId = $('#edit_employee_id').val();
        
        console.log('Adding work experience for employee:', empId); // DEBUG
        
        // Reset modal title and form
        $('#workModalLabel').text('Add Work Experience');
        $('#workForm')[0].reset();
        
        // Clear work_id but SET employee_id
        $('.work_id').val('');
        $('.work_employee_id').val(empId); // This sets the employee_id
        
        // Show modal
        new bootstrap.Modal(document.getElementById('workModal')).show();
    });

    // Edit Work Experience Button
    $(document).on('click', '.editWork', function() {
        const row = $(this).closest('tr');
        
        // Set modal title
        $('#workModalLabel').text('Edit Work Experience');
        
        // Fill hidden IDs
        $('.work_id').val($(this).data('id'));
        $('.work_employee_id').val($(this).data('emp-id'));
        
        // Fill form fields from row data attributes
        $('input[name="work_position[]"]').val(row.find('td[data-position]').data('position'));
        $('input[name="work_company[]"]').val(row.find('td[data-company]').data('company'));
        $('input[name="work_date_from[]"]').val(row.find('td[data-from]').data('from'));
        $('input[name="work_date_to[]"]').val(row.find('td[data-to]').data('to'));
        $('input[name="work_salary[]"]').val(row.find('td[data-salary]').data('salary'));
        $('input[name="work_grade[]"]').val(row.find('td[data-grade]').data('grade'));
        $('input[name="work_status[]"]').val(row.find('td[data-status]').data('status'));
        $('select[name="work_govt_service[]"]').val(row.find('td[data-govt]').data('govt'));
        
        // Show modal
        new bootstrap.Modal(document.getElementById('workModal')).show();
    });



    // Submit Work Experience Form
    $('#workForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url("admin/employeelist/updateEmployee") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Hide the work modal
                        bootstrap.Modal.getInstance(document.getElementById('workModal')).hide();
                        
                        // Refresh the work experience table in the edit modal
                        populateWorkExperienceTable(res.data.work_experience, res.data.employee_id);
                        
                        // Update the main employee table row (optional - updates the main list)
                        const rowIndex = table.rows().eq(0).filter((i) => {
                            return table.cell(i, 0).data() === res.data.employee_id;
                        });
                        if (rowIndex.length > 0) {
                            const rowData = {
                                employee_id: res.data.employee_id,
                                first_name: res.data.first_name,
                                surname: res.data.surname,
                                middle_name: res.data.middle_name,
                                department: res.data.department,
                                employment_type: res.data.employment_type,
                                mobile_no: res.data.mobile_no,
                                email_address: res.data.email_address
                            };
                            table.row(rowIndex).data(rowData).draw(false);
                        }
                    });
                } else {
                    Swal.fire('Error', res.message || 'Failed to save.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        });
    });

    // ======================================================
    // ============= VOLUNTARY WORK HANDLERS ================
    // ======================================================

    // Add new Voluntary Work
    $(document).on('click', '#addVoluntaryRow', function() {
        const empId = $('#edit_employee_id').val();
        
        console.log('Adding voluntary work for employee:', empId);
        
        // Reset modal title and form
        $('#voluntaryModalLabel').text('Add Voluntary Work');
        $('#voluntaryForm')[0].reset();
        
        // Clear voluntary_id but SET employee_id
        $('.voluntary_id').val('');
        $('.voluntary_employee_id').val(empId);
        
        // Show modal
        new bootstrap.Modal(document.getElementById('voluntaryModal')).show();
    });

    // Edit Voluntary Work Button
    $(document).on('click', '.editVoluntary', function() {
        const row = $(this).closest('tr');
        
        // Set modal title
        $('#voluntaryModalLabel').text('Edit Voluntary Work');
        
        // Fill hidden IDs
        $('.voluntary_id').val($(this).data('id'));
        $('.voluntary_employee_id').val($(this).data('emp-id'));
        
        // Fill form fields from row data attributes
        $('input[name="organization_name"]').val(row.find('td[data-org]').data('org'));
        $('input[name="position_role"]').val(row.find('td[data-role]').data('role'));
        $('input[name="organization_address"]').val(row.find('td[data-address]').data('address'));
        $('input[name="start_date"]').val(row.find('td[data-start]').data('start'));
        $('input[name="end_date"]').val(row.find('td[data-end]').data('end'));
        $('input[name="number_of_hours"]').val(row.find('td[data-hours]').data('hours'));
        
        // File input cannot be pre-filled
        $('input[name="membership_id_url"]').val('');
        
        // Show modal
        new bootstrap.Modal(document.getElementById('voluntaryModal')).show();
    });

    // Submit Voluntary Work Form
    $('#voluntaryForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url("admin/employeelist/updateEmployee") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Hide the voluntary modal
                        bootstrap.Modal.getInstance(document.getElementById('voluntaryModal')).hide();
                        
                        // Refresh the voluntary work table in the edit modal
                        populateVoluntaryWorkTable(res.data.voluntarywork, res.data.employee_id);
                        
                        // Update the main employee table row (optional)
                        const rowIndex = table.rows().eq(0).filter((i) => {
                            return table.cell(i, 0).data() === res.data.employee_id;
                        });
                        if (rowIndex.length > 0) {
                            const rowData = {
                                employee_id: res.data.employee_id,
                                first_name: res.data.first_name,
                                surname: res.data.surname,
                                middle_name: res.data.middle_name,
                                department: res.data.department,
                                employment_type: res.data.employment_type,
                                mobile_no: res.data.mobile_no,
                                email_address: res.data.email_address
                            };
                            table.row(rowIndex).data(rowData).draw(false);
                        }
                    });
                } else {
                    Swal.fire('Error', res.message || 'Failed to save.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        });
    });


    // ======================================================
    // ============= LEARNING DEVELOPMENT HANDLERS ==========
    // ======================================================

    // ADD Learning & Development
    $(document).on('click', '#addLearningRow', function() {
        const empId = $('#edit_employee_id').val();
        
        console.log('Adding learning development for employee:', empId);
        
        // Reset modal title and form
        $('#learningModalLabel').text('Add Learning & Development');
        $('#learningForm')[0].reset();
        
        // Clear ld_id but SET employee_id
        $('.ld_id').val('');
        $('.ld_employee_id').val(empId);
        
        $('#learningSubmitBtn').text('Save');
        
        // Show modal
        new bootstrap.Modal(document.getElementById('learningModal')).show();
    });

    // Edit Learning & Development
    $(document).on('click', '.editLearning', function() {
        const row = $(this).closest('tr');
        
        // Set modal title
        $('#learningModalLabel').text('Edit Learning & Development');
        
        // Fill hidden IDs
        $('.ld_id').val($(this).data('id'));
        $('.ld_employee_id').val($(this).data('emp-id'));
        
        // Fill form fields from row data attributes
        $('input[name="ld_title"]').val(row.find('td[data-title]').data('title'));
        $('input[name="ld_date_from"]').val(row.find('td[data-from]').data('from'));
        $('input[name="ld_date_to"]').val(row.find('td[data-to]').data('to'));
        $('input[name="ld_hours"]').val(row.find('td[data-hours]').data('hours'));
        $('select[name="ld_type"]').val(row.find('td[data-type]').data('type'));
        $('input[name="ld_sponsor"]').val(row.find('td[data-sponsor]').data('sponsor'));
        
        // File input cannot be pre-filled
        $('input[name="ld_certification"]').val('');
        
        $('#learningSubmitBtn').text('Update');
        
        // Show modal
        new bootstrap.Modal(document.getElementById('learningModal')).show();
    });

    // Submit Learning Development Form
    $('#learningForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url("admin/employeelist/updateEmployee") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Hide the learning modal
                        bootstrap.Modal.getInstance(document.getElementById('learningModal')).hide();
                        
                        // Refresh the learning development table in the edit modal
                        populateLearningDevelopmentTable(res.data.learning_development_programs, res.data.employee_id);
                        
                        // Update the main employee table row (optional)
                        const rowIndex = table.rows().eq(0).filter((i) => {
                            return table.cell(i, 0).data() === res.data.employee_id;
                        });
                        if (rowIndex.length > 0) {
                            const rowData = {
                                employee_id: res.data.employee_id,
                                first_name: res.data.first_name,
                                surname: res.data.surname,
                                middle_name: res.data.middle_name,
                                department: res.data.department,
                                employment_type: res.data.employment_type,
                                mobile_no: res.data.mobile_no,
                                email_address: res.data.email_address
                            };
                            table.row(rowIndex).data(rowData).draw(false);
                        }
                    });
                } else {
                    Swal.fire('Error', res.message || 'Failed to save.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            }
        });
    });



    // ==================== DELETE HANDLERS ====================

    // Delete Graduate Study
    $(document).on('click', '.deleteGrad', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Delete Graduate Study?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/employeelist/deleteGraduateStudy") ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    headers: {
                        'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.remove(); // Remove the row from table
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'Failed to delete graduate study.', 'error');
                    }
                });
            }
        });
    });

    // Delete Civil Service
    $(document).on('click', '.deleteCivil', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Delete Civil Service Eligibility?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/employeelist/deleteCivilService") ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    headers: {
                        'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.remove(); // Remove the row from table
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'Failed to delete civil service eligibility.', 'error');
                    }
                });
            }
        });
    });

    // Delete Work Experience
    $(document).on('click', '.deleteWork', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Delete Work Experience?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/employeelist/deleteWorkExperience") ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    headers: {
                        'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.remove(); // Remove the row from table
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'Failed to delete work experience.', 'error');
                    }
                });
            }
        });
    });

    // Delete Voluntary Work
    $(document).on('click', '.deleteVoluntary', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Delete Voluntary Work?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/employeelist/deleteVoluntaryWork") ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    headers: {
                        'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.remove(); // Remove the row from table
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'Failed to delete voluntary work.', 'error');
                    }
                });
            }
        });
    });

    // Delete Learning Development
    $(document).on('click', '.deleteLearning', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Delete Learning & Development?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin/employeelist/deleteLearningDevelopment") ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    headers: {
                        'CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.remove(); // Remove the row from table
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'Failed to delete learning & development program.', 'error');
                    }
                });
            }
        });
    });

    // Delete Other Information
    $(document).on('click', '.deleteOtherInfo', function() {
        const skillId = $(this).data('skill-id');
        const recognitionId = $(this).data('recognition-id');
        const membershipId = $(this).data('membership-id');
        const row = $(this).closest('tr');
        
        if (!skillId && !recognitionId && !membershipId) {
            Swal.fire('Warning', 'No data to delete.', 'warning');
            return;
        }
        
        Swal.fire({
            title: 'Delete Other Information?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const deletePromises = [];
                
                // Delete skill if exists
                if (skillId) {
                    deletePromises.push(
                        $.ajax({
                            url: '<?= base_url("admin/employeelist/deleteOtherInformation") ?>',
                            type: 'POST',
                            data: { id: skillId, type: 'skill' },
                            headers: { 'CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
                        })
                    );
                }
                
                // Delete recognition if exists
                if (recognitionId) {
                    deletePromises.push(
                        $.ajax({
                            url: '<?= base_url("admin/employeelist/deleteOtherInformation") ?>',
                            type: 'POST',
                            data: { id: recognitionId, type: 'recognition' },
                            headers: { 'CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
                        })
                    );
                }
                
                // Delete membership if exists
                if (membershipId) {
                    deletePromises.push(
                        $.ajax({
                            url: '<?= base_url("admin/employeelist/deleteOtherInformation") ?>',
                            type: 'POST',
                            data: { id: membershipId, type: 'membership' },
                            headers: { 'CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
                        })
                    );
                }
                
                Promise.all(deletePromises)
                    .then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Other information deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        row.remove();
                    })
                    .catch((error) => {
                        console.error('Delete error:', error);
                        Swal.fire('Error', 'Failed to delete other information.', 'error');
                    });
            }
        });
    });

    // -------------------- Delete Employee --------------------
    $('#employeeTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (!confirm('Are you sure?')) return;
        $.ajax({
            url: '<?= base_url("admin/employeelist/delete") ?>',
            type: 'POST',
            headers: { 'CSRF-Token': csrfToken },
            contentType: 'application/json',
            data: JSON.stringify({ employee_id: id }),
            success: res => {
                Swal.fire(res.status === 'success' ? 'Deleted!' : 'Error!', res.message, res.status === 'success' ? 'success' : 'error')
                     .then(() => table.ajax.reload());
            }
        });
    });
});
</script>
</body>
</html>