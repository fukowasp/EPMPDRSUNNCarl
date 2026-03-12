<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDS Preview &mdash; CS Form 212 (Revised 2025)</title>
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <!-- ExcelJS -->
    <script src="<?= base_url('libs/exceljs/exceljs.min.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('public/style.css')?>">
</head>

<body>

    <!-- ── Top Bar ── -->
    <div class="pds-topbar">
        <a href="<?= base_url('employee/dashboard') ?>" class="btn btn-sm btn-outline-light">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <div class="title-block">
            <h4><i class="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i>Personal Data Sheet Preview</h4>
            <small>CS Form No. 212 &bull; Revised 2025 &bull; Showing your saved data</small>
        </div>
        <a id="btnDownload" href="#" download="Personal-Data-Sheet-CS-Form-212-2025.xlsx"
            class="btn btn-sm btn-success">
            <i class="bi bi-download"></i> Download Template
        </a>
        <a href="<?= base_url('employee/pds/upload') ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-upload"></i> Upload Notarized PDS
        </a>
    </div>

    <!-- ── Info Banner ── -->
    <div class="pds-info-bar">
        <i class="bi bi-info-circle-fill me-1"></i>
        This is a <strong>read-only preview</strong> of the PDS template (CS Form 212, Revised 2025).
        To update your information, edit the relevant section from the sidebar and re-submit.
    </div>

    <!-- ── Sheet Tabs ── -->
    <div class="pds-tabs" id="sheetTabs">
        <div class="pds-tab active" onclick="switchTab('C1',this)">
            <i class="bi bi-person-vcard"></i> C1 &mdash; Personal &amp; Education
        </div>
        <div class="pds-tab" onclick="switchTab('C2',this)">
            <i class="bi bi-briefcase"></i> C2 &mdash; Eligibility &amp; Work Exp.
        </div>
        <div class="pds-tab" onclick="switchTab('C3',this)">
            <i class="bi bi-journal-bookmark"></i> C3 &mdash; Trainings &amp; Other Info
        </div>
        <div class="pds-tab" onclick="switchTab('C4',this)">
            <i class="bi bi-file-earmark-text"></i> C4 &mdash; Declarations
        </div>
    </div>

    <!-- ── Sheet Display Area ── -->
    <div class="container-fluid px-0">
        <div class="pds-sheet-wrap" id="sheetWrap" style="max-height: calc(100vh - 165px);">
            <div id="pdsLoading">
                <div class="spinner-border text-primary" style="width:2.5rem;height:2.5rem;"></div>
                <div>
                    <div class="fw-semibold text-dark" style="font-size:.95rem;">Loading PDS Template&hellip;</div>
                    <div class="text-muted" style="font-size:.8rem;">Rendering spreadsheet with ExcelJS</div>
                </div>
            </div>
            <div id="pdsError" class="d-none" style="display:none!important;">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                <div class="fw-semibold text-danger">Failed to render template</div>
                <p class="text-muted" style="font-size:.82rem;">Please try downloading the template instead.</p>
                <a id="btnDownload2" href="#" download="Personal-Data-Sheet.xlsx"
                    class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-download"></i> Download Template
                </a>
            </div>
            <div id="sheetContent" style="display:none;"></div>
        </div>
    </div>

    <!-- ── Footer ── -->
    <div class="pds-footer">
        <span><i class="bi bi-file-earmark-spreadsheet me-1"></i>CS Form No. 212 (Revised 2025) &bull; Civil Service
            Commission Philippines</span>
        <span id="cellCount" class="text-muted"></span>
    </div>


    <!-- Bootstrap JS -->
    <script src="<?= base_url('public/script.js') ?>"></script>
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>