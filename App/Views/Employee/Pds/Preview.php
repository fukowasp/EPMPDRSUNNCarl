<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDS Preview — CS Form 212</title>
  <link rel="stylesheet" href="<?= base_url('public/pds-preview.css') ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<div class="pds-header d-flex align-items-center justify-content-between mb-3">
  <!-- Left: Back icon + Title -->
  <div class="d-flex align-items-center gap-2">
    <!-- Title + Subtitle -->
    <div>
      <h1 class="h5 mb-0 text-white">📋 Personal Data Sheet Preview</h1>
      <p class="mb-0" style="font-size: 11px; opacity: .85; color: #fff;">
        CS Form No. 212 • Revised 2025 • Showing your saved data
      </p>
    </div>

    <!-- Back icon, aligned to middle of title block -->
    <a href="http://localhost/EPMPDRSUNN/employee/dashboard" class="btn-back text-decoration-none text-white fs-4 ms-2" title="Go Back">
      <i class="bi bi-arrow-left-circle"></i>
    </a>
  </div>

  <!-- Right: Download button -->
  <a href="#" class="btn btn-dl" title="Download XLSX">
    <i class="bi bi-download"></i>
  </a>
</div>

  <div class="tab-bar">
    <button class="pds-tab active" onclick="switchTab('C1', this)">C1 — Personal & Education</button>
    <button class="pds-tab" onclick="switchTab('C2', this)">C2 — Eligibility & Work Exp.</button>
    <button class="pds-tab" onclick="switchTab('C3', this)">C3 — Trainings & Other Info</button>
    <button class="pds-tab" onclick="switchTab('C4', this)">C4 — Declarations</button>

  </div>

  <div class="sheet-wrap">
    <div class="sheet-inner" id="sheetContent"></div>
  </div>
  <script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>

  <script src="<?= base_url('assets/pds/pds_page.js') ?>"></script>


  <script>
    const PDS_CONFIG = {
      templateUrl: '<?= base_url("assets/pds/PDS-Form-212-2025.xlsx") ?>',
      apiBase: '<?= base_url("employee/pds") ?>',
      employeeId: '<?= $employeeId ?>'
    };
  </script>
  <script src="<?= base_url("public/pds_renderer.js") ?>"></script>


</body>

</html>