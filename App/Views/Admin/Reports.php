<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Graduate Studies Report</title>

<!-- Local CSS -->
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin/admindashboard.css') ?>">

<!-- Local JS -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/responsive.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('libs/chartjs/chart.min.js') ?>"></script>

<!-- CDN JS for PDF only -->
<script src="<?= base_url('dist/pdf/jspdf.umd.min.js') ?>"></script>
<script src="<?= base_url('dist/pdf/jspdf.plugin.autotable.min.js') ?>"></script>

<style>
.chart-container {
    position: relative;
    width: 100%;
    max-width: 500px; /* chart max width */
    margin: auto;
    height: 400px; /* fixed height */
}
</style>
</head>

<body class="bg-light">

<?php 
include dirname(__DIR__, 2) . '/includes/admin_navbar.php'; 
include dirname(__DIR__, 2) . '/includes/admin_sidebar.php'; 
?>

<div class="main-content p-4" style="margin-left: 250px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-file-earmark-bar-graph me-2"></i>Graduate Studies Report</h3>
       <button id="downloadPdf" class="btn btn-success">Download PDF</button>
    </div>

    <!-- Graduate Table -->
    <div class="card shadow-sm mb-4">
        <div class="card-body table-responsive">
            <table id="graduateTable" class="table table-striped table-bordered w-100">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Institution</th>
                        <th>Graduate Course</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($graduates as $g): ?>
                    <tr>
                        <td><?= $g->id ?></td>
                        <td><?= $g->employee_id ?></td>
                        <td><?= $g->first_name ?></td>
                        <td><?= $g->surname ?></td>
                        <td><?= $g->institution_name ?></td>
                        <td><?= $g->graduate_course ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graduate Studies Chart -->
<div class="card shadow-sm col-md-8 mb-3">
    <div class="card-body">
        <h5 class="card-title mb-3">Graduate Studies Distribution (%)</h5>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 chart-container">
                <canvas id="gradChart"></canvas>
            </div>
        </div>
    </div>
</div>


</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#graduateTable').DataTable();

    // Fetch chart data via POST
    $.ajax({
        url: '<?= base_url("admin/reports/chartData") ?>',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
            const totalEmployees = data.reduce((sum, item) => sum + parseInt(item.total), 0);
            const labels = data.map(d => d.graduate_course);
            const percentages = data.map(d => ((parseInt(d.total)/totalEmployees)*100).toFixed(1));

            new Chart(document.getElementById('gradChart'), {
                type: 'pie',
                data: {
                    labels: labels.map((label, i) => `${label} (${percentages[i]}%)`),
                    datasets: [{
                        label: 'Graduate Studies',
                        data: data.map(d => parseInt(d.total)),
                        backgroundColor: ['#6c757d', '#007bff', '#28a745', '#ffc107', '#17a2b8', '#fd7e14']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        },
        error: function(xhr) {
            console.error('Error fetching chart data:', xhr.responseText);
        }
    });

    // PDF download
    $('#downloadPdf').click(function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Graduate Studies Report", 14, 20);
        doc.autoTable({ html: '#graduateTable', startY: 30 });
        doc.save("graduate_studies_report.pdf");
    });
});
</script>

</body>
</html>
