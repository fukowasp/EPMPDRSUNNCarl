<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDC Dashboard | SUNN</title>
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/chartjs/chart.min.js') ?>"></script>
<style>
/* Stat Cards */
.stat-card { 
    border-radius:16px; 
    transition: transform 0.3s ease, box-shadow 0.3s ease; 
    background-color: rgba(255,255,255,0.85);
}
.stat-card:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 6px 20px rgba(0,0,0,0.08); 
}

/* Sidebar gradient */
.sidebar { 
    width:250px; 
    position:fixed; 
    top:60px; 
    left:0; 
    height:calc(100% - 70px); 
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    padding-top:1rem; 
}
.sidebar a { 
    color:white; 
    display:block; 
    padding:12px 20px; 
    text-decoration:none; 
    transition:0.2s; 
}
.sidebar a.active, .sidebar a:hover { 
    background: rgba(255,255,255,0.2); 
}

/* Welcome card gradient */
.welcome-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    color: white;
}

/* Main content */
main { 
    margin-left:250px; 
    padding-top:70px; 
    padding-right:20px; 
    padding-left:20px; 
}

/* Responsive adjustments */
@media (max-width:992px) { 
    .sidebar { display:none; } 
    main { margin-left:0; } 
}

.chart-container { 
    width: 100%; 
    max-width: 600px; 
    margin: auto; 
    height: 350px; 
}
</style>
</head>
<body>

<?php include dirname(__DIR__, 1) . '/partials/pdc_navbar.php'; ?>
<?php include dirname(__DIR__, 1) . '/partials/pdc_sidebar.php'; ?>

<main>
    <!-- Welcome Card -->
    <section class="mb-4">
        <div class="welcome-card p-4 rounded-4 shadow-sm">
            <h2 class="fw-bold mb-1">Welcome back 👋</h2>
            <p class="mb-0">Here’s an overview of your department.</p>
        </div>
    </section>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-top border-warning border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Employees</h6>
                        <h3 id="employeeCount" class="fw-bold">0</h3>
                        <small class="text-secondary">Updated today</small>
                    </div>
                    <div class="bg-warning bg-opacity-25 text-warning p-3 rounded-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-top border-success border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Trainings</h6>
                        <h3 id="totalTrainings" class="fw-bold">0</h3>
                        <small class="text-secondary">All trainings</small>
                    </div>
                    <div class="bg-success bg-opacity-25 text-success p-3 rounded-3">
                        <i class="bi bi-journal-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-top border-primary border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Active Trainings</h6>
                        <h3 id="activeTrainings" class="fw-bold">0</h3>
                        <small class="text-secondary">Ongoing sessions</small>
                    </div>
                    <div class="bg-primary bg-opacity-25 text-primary p-3 rounded-3">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-top border-info border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Participants</h6>
                        <h3 id="totalParticipants" class="fw-bold">0</h3>
                        <small class="text-secondary">All sessions</small>
                    </div>
                    <div class="bg-info bg-opacity-25 text-info p-3 rounded-3">
                        <i class="bi bi-person-lines-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Participants per Training</h5>
                <div class="chart-container">
                    <canvas id="participantsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Training Status Overview</h5>
                <div class="chart-container">
                    <canvas id="trainingStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
$(document).ready(function() {
    $.getJSON('<?= base_url("pdc/dashboard/stats") ?>', function(data) {
        $('#employeeCount').text(data.totalEmployees);
        $('#totalTrainings').text(data.totalTrainings);
        $('#activeTrainings').text(data.activeTrainings);

        const totalParticipants = data.trainings.reduce((sum,t)=>sum+t.participants,0);
        $('#totalParticipants').text(totalParticipants);

        const ctxParticipants = document.getElementById('participantsChart').getContext('2d');
        new Chart(ctxParticipants, {
            type: 'bar',
            data: {
                labels: data.trainings.map(t => t.title),
                datasets: [{ label: 'Participants', data: data.trainings.map(t => t.participants), backgroundColor: '#0d6efd' }]
            },
            options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
        });

        const ctxStatus = document.getElementById('trainingStatusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: { 
                labels: ['Pending', 'Accepted', 'Cancelled'], // <-- match DB values
                datasets: [{
                    data: [
                        data.statusCounts.pending, 
                        data.statusCounts.accepted, 
                        data.statusCounts.cancelled // <-- change from 'declined' to 'cancelled'
                    ],
                    backgroundColor: ['#6c757d','#198754','#dc3545']
                }] 
            },
            options: { 
                responsive: true, 
                plugins: { legend: { position: 'bottom' } } 
            }
        });

    });
});
</script>
</body>
</html>
