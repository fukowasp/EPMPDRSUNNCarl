    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Dashboard - SUNN</title>

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

    <!-- Chart.js -->
    <script src="<?= base_url('libs/chartjs/chart.min.js') ?>"></script>

    </head>
    <body>
    <div class="wrapper d-flex">

        <!-- Sidebar -->
        <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="content-wrapper flex-grow-1" id="content">
            <div class="container-fluid py-3">

                <!-- Welcome -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-speedometer2 text-primary"></i> Employee Dashboard
                    </h4>
                    <div class="welcome">Welcome back, <?= $employeeName ?? 'Employee' ?>!</div>
                </div>

                <!-- Dashboard Cards -->
                <div id="dashboard-cards" class="row g-4">

                <!-- Trainings Accepted -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 text-center h-100">
                            <!-- Card header with gradient -->
                            <div class="card-header text-white" style="background: linear-gradient(170deg, #1e3a8a, #059669);">
                                Trainings Accepted
                            </div>
                            <div class="card-body">
                                <h2><?= $acceptedTrainingsCount ?? 0 ?></h2>
                                <p class="text-muted mb-1">Total Trainings Accepted</p>
                                <div class="progress">
                                    <!-- Progress bar color -->
                                    <div class="progress-bar" role="progressbar" style="width: <?= $acceptedTrainingsCountPercent ?? 0 ?>%; background-color: #059669;" aria-valuenow="<?= $acceptedTrainingsCountPercent ?? 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Pending Trainings -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 text-center h-100">
                            <div class="card-header text-white" style="background: #059669;">
                                Pending Trainings
                            </div>
                            <div class="card-body">
                                <h2><?= !empty($pendingInvites) ? count($pendingInvites) : 0 ?></h2>
                                <p class="text-muted mb-1">Awaiting Response</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $pendingPercent ?? 0 ?>%; background-color: #dbeafe;" aria-valuenow="<?= $pendingPercent ?? 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 text-center h-100">
                            <div class="card-header text-white" style="background: #059669; color: #1e3a8a;">
                                Notifications
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <?php if(!empty($pendingInvites)): ?>
                                    <h2><i class="bi bi-bell-fill" style="color:#059669;"></i></h2>
                                    <p class="fw-semibold mb-2">You have <?= count($pendingInvites) ?> pending invite(s)</p>
                                    <a href="<?= base_url('employee/trainings/history') ?>" class="btn" style="background-color: #1e3a8a; color: #fff;">
                                        <i class="bi bi-card-checklist"></i> View
                                    </a>
                                <?php else: ?>
                                    <h2><i class="bi bi-check-circle-fill" style="color:#059669;"></i></h2>
                                    <p class="text-muted mb-0">No new notifications</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <!-- Total Trainings Completed -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <a href="<?= base_url('/employee/learndev') ?>" style="text-decoration: none;">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header text-white" style="background: linear-gradient(135deg,#1e3a8a,#059669);">
                                Total Trainings Completed
                            </div>
                            <div class="card-body text-center">
                                <h2><?= $totalTrainingsCompleted ?? 0 ?></h2>
                                <p class="text-muted mb-1">Trainings Completed</p>
                                <p class="fw-semibold"><?= $totalTrainingHours ?? 0 ?> hours</p>
                                <div class="progress">
                                    <?php 
                                        $percent = ($totalTrainingHours / 100) * 100; 
                                        $percent = min($percent, 100); // cap at 100%
                                    ?>
                                    <div class="progress-bar" role="progressbar" style="width: <?= $percent ?>%; background-color: #1e3a8a;" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                <!-- Charts Section -->
                <div class="row mt-4">

                    <!-- Training Completion Chart -->
                    <div class="col-12 col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-white" style="background: linear-gradient(135deg,#1e3a8a,#059669);">
                            Trainings Completion
                        </div>
                            <div class="card-body">
                                <canvas id="completionChart"></canvas>
                            </div>
                        </div>
                    </div>
                                <div class="col-12 col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header text-white" style="background: linear-gradient(135deg,#1e3a8a,#059669);">
                            Total Trainings Completed
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="height: 250px;">
                            <canvas id="totalTrainingsChart" style="max-height: 100%; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>


            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.min.js') ?>"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const accepted = <?= $acceptedTrainingsCount ?? 0 ?>;
        const pending = <?= !empty($pendingInvites) ? count($pendingInvites) : 0 ?>;
        const declined = <?= $declinedTrainings ?? 0 ?>;

        const completionCtx = document.getElementById('completionChart').getContext('2d');
        new Chart(completionCtx, {
            type: 'bar',
            data: {
                labels: ['Accepted', 'Pending', 'Declined'],
                datasets: [{
                    label: 'Trainings',
                    data: [accepted, pending, declined],
                    backgroundColor: [
                        accepted > 0 ? '#1e3a8a' : '#d1d5db',
                        pending > 0 ? '#059669' : '#d1d5db',
                        declined > 0 ? '#dc2626' : '#d1d5db'
                    ]
                }]
            },
            options: { 
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        const totalTrainingsCtx = document.getElementById('totalTrainingsChart').getContext('2d');
        new Chart(totalTrainingsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Trainings Completed', 'Hours Completed'],
                datasets: [{
                    label: 'Total',
                    data: [
                        <?= $totalTrainingsCompleted ?? 0 ?>, 
                        <?= $totalTrainingHours ?? 0 ?>
                    ],
                    backgroundColor: ['#1e3a8a', '#059669'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

    });
    </script>
    </body>
    </html>
