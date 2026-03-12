<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">
  <script src="<?= base_url('libs/chartjs/chart.min.js') ?>"></script>


  <!-- CSRF Meta Tag -->
  <?= csrf_meta() ?>

  <style>
    canvas { width: 100% !important; height: 300px !important; }
    .chart-card { border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
  </style>
</head>
<body>

<?php include dirname(__DIR__, 2) . '/includes/admin_sidebar.php'; ?>
<?php include dirname(__DIR__,2) . '/includes/admin_navbar.php'; ?>

<div class="main-content">
  <div class="page-header">
    <h4><i class="bi bi-speedometer2 me-2"></i>Dashboard Overview</h4>
    <small class="text-muted">Professional Development Center Management</small>
  </div>

  <div id="statsRow" class="row mb-4 text-center text-muted">
    <div class="col-12">
      <div class="spinner-border text-warning" role="status"></div> Loading data...
    </div>
  </div>

  <div class="row g-4 mb-4" id="chartRow" style="display:none;">
    <div class="col-lg-4">
      <div class="card chart-card p-3">
        <h6>Graduate Studies Distribution</h6>
        <canvas id="gradStudyChart"></canvas>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card chart-card p-3">
        <h6>Employee Types</h6>
        <canvas id="employeeTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

 <script src="<?= base_url('dist/datatables/js/bootstrap.bundle.min.js') ?>"></script>

<script>
// CSRF Functions
function getCsrfToken() {
  const metaTag = document.querySelector('meta[name="csrf-token"]');
  return metaTag ? metaTag.getAttribute('content') : '';
}

function updateCsrfToken(newToken) {
  if (!newToken) return;
  const metaTag = document.querySelector('meta[name="csrf-token"]');
  if (metaTag) {
    metaTag.setAttribute('content', newToken);
  }
}

// Fetch with CSRF
async function fetchWithCsrf(url, options = {}) {
  const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': getCsrfToken(),
    ...(options.headers || {})
  };

  const response = await fetch(url, {
    ...options,
    headers
  });

  const data = await response.json();

  // Update token if server sends new one
  if (data.csrf_token) {
    updateCsrfToken(data.csrf_token);
  }

  // Handle CSRF errors
  if (response.status === 403 && data.error) {
    throw new Error(data.error);
  }

  return { response, data };
}

// Load Dashboard Data
async function loadDashboardData() {
  try {
    const { data } = await fetchWithCsrf("<?= base_url('admin/dashboard/fetch') ?>", {
      method: 'GET'
    });

    if (!data.success) {
      throw new Error(data.error || "Failed to load data");
    }

    const d = data.data;

    // Render Stats
    document.getElementById('statsRow').innerHTML = `
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card card">
          <div class="card-body">
            <h6>Total Permanent Employees</h6>
            <h3>${d.totalPermanentEmployees}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card card">
          <div class="card-body">
            <h6>Total Non-Permanent Employees</h6>
            <h3>${d.totalNonPermanentEmployees}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card card">
          <div class="card-body">
            <h6>Graduate Studies</h6>
            <h3>${d.graduateStudies.reduce((sum, g) => sum + parseInt(g.total), 0)}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card card">
          <div class="card-body">
            <h6>Total Employees</h6>
            <h3>${d.totalEmployees}</h3>
          </div>
        </div>
      </div>
    `;

    // Employee Type Bar Chart
    new Chart(document.getElementById('employeeTypeChart'), {
      type: 'bar',
      data: {
        labels: ['Permanent', 'Non-Permanent'],
        datasets: [{
          label: 'Employees',
          data: [d.totalPermanentEmployees, d.totalNonPermanentEmployees],
          backgroundColor: ['#0d6efd', '#ffc107']
        }]
      },
      options: { 
        responsive: true, 
        plugins: { legend: { display: false } }, 
        scales: { y: { beginAtZero: true } } 
      }
    });

    // Graduate Studies Doughnut Chart
    const colors = d.graduateStudies.map((_, i) => `hsl(${i * 40},70%,60%)`);
    new Chart(document.getElementById('gradStudyChart'), {
      type: 'doughnut',
      data: { 
        labels: d.graduateStudies.map(r => r.program), 
        datasets: [{ 
          data: d.graduateStudies.map(r => r.total), 
          backgroundColor: colors 
        }] 
      }
    });

    document.getElementById('chartRow').style.display = '';

  } catch (err) {
    console.error('Dashboard Error:', err);
    document.getElementById('statsRow').innerHTML = 
      `<div class="text-danger text-center">Failed to load data: ${err.message}</div>`;
  }
}

document.addEventListener('DOMContentLoaded', loadDashboardData);
</script>
</body>
</html>