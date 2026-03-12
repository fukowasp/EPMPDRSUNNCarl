<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDC Reports | SUNN</title>

<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">

<style>
/* Sidebar & Main */
.sidebar { 
    width:250px; 
    position:fixed; 
    top:60px; 
    left:0; 
    height:calc(100% - 70px); 
    background: linear-gradient(180deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    padding-top:1rem; 
    overflow-y:auto; 
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

main { 
    margin-left: 250px; 
    padding: 70px 20px 20px 20px; 
    background: linear-gradient(120deg, #fff9e6, #ffffffff); 
    min-height: 100vh; 
    transition: all 0.3s ease; 
}

.container { 
    background: rgba(255, 255, 255, 0.95); 
    padding: 25px 30px; 
    border-radius: 15px; 
    box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
}

/* Table */
table.dataTable thead { 
    background: linear-gradient(90deg, #ffea85 0%, #ffc107 100%); 
    color: #000; 
    font-weight: 600; 
}
.dataTable tbody tr:hover { 
    transform: translateY(-2px); 
    box-shadow: 0 6px 20px rgba(0,0,0,0.08); 
    background: linear-gradient(90deg,#fff3cd 0%,#ffe066 100%); 
}
.dataTables_filter input { 
    border-radius: 0.5rem; 
    border: 1px solid #ffc107; 
    padding: 0.25rem 0.5rem; 
    background: #fffbea; 
}

/* Buttons */
.btn-download-pdf {
    background: #0077B6;
    color: #fff;
    font-weight: 500;
    border: none;
    transition: 0.2s;
}
.btn-download-pdf:hover {
    opacity: 0.85;
}

/* Responsive */
@media (max-width: 992px) { 
    main { margin-left: 0; } 
    table.dataTable { font-size: 0.9rem; } 
}
</style>
</head>

<body class="bg-light">

<?php include dirname(__DIR__, 1) . '/partials/pdc_navbar.php'; ?>
<?php include dirname(__DIR__, 1) . '/partials/pdc_sidebar.php'; ?>

<main>
  <div class="container-fluid my-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
      <h3 class="fw-bold"><i class="bi bi-file-earmark-text"></i> Reports</h3>
      <button class="btn btn-download-pdf" onclick="downloadPDF()">
        <i class="bi bi-file-earmark-pdf"></i> Download PDF
      </button>
    </div>

    <!-- Participants Table -->
    <div class="card p-3 mb-4 shadow-sm">
    <h5 class="fw-bold mb-3">Training Participants</h5>

    <!-- Filter -->
    <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <label for="statusFilter" class="form-label fw-bold mb-0">Filter by Status:</label>
            <select id="statusFilter" class="form-select w-auto">
                <option value="">All</option>
                <option value="Accepted">Accepted</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-2">
            <label for="trainingFilter" class="form-label fw-bold mb-0">Filter by Training:</label>
            <select id="trainingFilter" class="form-select w-auto">
                <option value="">All</option>
                <!-- Options populated dynamically -->
            </select>
        </div>

        <div class="d-flex align-items-center gap-2">
            <label for="yearFilter" class="form-label fw-bold mb-0">Filter by Year:</label>
            <select id="yearFilter" class="form-select w-auto">
                <option value="">All</option>
                <!-- Options populated dynamically -->
            </select>
        </div>

    </div>


    <!-- DataTable -->
    <table id="participantsTable" class="table table-striped table-bordered nowrap align-middle" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Employee</th>
            <th>Training</th>
            <th>Date Completed</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>

    <div class="row">
        <!-- Participants Chart (8 columns) -->
        <div class="col-md-8 mb-4">
            <div class="card p-3 shadow-sm no-print">
                <h5 class="fw-bold mb-3">Participants by Training</h5>
                <div style="position: relative; height: 400px; width: 100%;">
                    <canvas id="participantsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Participants Status Chart (4 columns) -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow-sm no-print">
                <h5 class="fw-bold mb-3">Participants Status</h5>
                <div style="position: relative; height: 400px; width: 100%;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
  </div>
</main>

<!-- JS Libraries -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/responsive.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('libs/chartjs/chart.min.js') ?>"></script>
<script src="<?= base_url('dist/pdf/jspdf.umd.min.js') ?>"></script>
<script src="<?= base_url('dist/pdf/jspdf.plugin.autotable.min.js') ?>"></script>

<script>
$(function() {
  // Initialize DataTable
       const table = $('#participantsTable').DataTable({
        responsive: true,
        ajax: { url: '<?= base_url("pdc/reports/getParticipantsReport") ?>', type: 'GET', dataSrc: 'data' },
        columns: [
            { data: 'employee_training_id' },
            { data: 'employee_name' },
            { data: 'training_title' },
            { 
                data: 'end_date', 
                render: d => (d === '0000-00-00' || !d) ? '—' : d
            },
            { 
                data: 'status', 
                render: s => {
                    let color = s === 'Accepted' ? 'bg-success' : s === 'Pending' ? 'bg-warning' : 'bg-danger';
                    return `<span class="badge ${color}">${s}</span>`;
                }
            }
        ],
        initComplete: function(settings, json) {
            // Populate training filter dynamically
            let trainings = [...new Set(json.data.map(d => d.training_title))].sort();
            trainings.forEach(t => $('#trainingFilter').append(`<option value="${t}">${t}</option>`));

            // Populate year filter dynamically
            let years = [...new Set(json.data
                .map(d => d.end_date)
                .filter(d => d && d !== '0000-00-00')
                .map(d => d.split('-')[0]) // get only year
            )].sort();
            years.forEach(y => $('#yearFilter').append(`<option value="${y}">${y}</option>`));
        }
    });

    // Status Filter
    $('#statusFilter').on('change', function() {
        table.column(4).search($(this).val()).draw();
    });

    // Training Filter
    $('#trainingFilter').on('change', function() {
        table.column(2).search($(this).val()).draw();
    });

    // Year Filter (matches year part of end_date)
    $('#yearFilter').on('change', function() {
        const year = $(this).val();
        table.column(3).search(year ? '^' + year : '', true, false).draw(); // regex search
    });

  // Participants Chart - Modern Version
    $.post('<?= base_url("pdc/reports/getParticipantsChart") ?>', function(res) {
        if(res.success) {
            const ctx = document.getElementById('participantsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.data.map(d => d.training_title),
                    datasets: [{
                        label: 'Total Participants',
                        data: res.data.map(d => d.total),
                        borderRadius: 10,        // Rounded bars
                        backgroundColor: function(context) {
                            const value = context.raw;
                            // Gradient color
                            const chart = context.chart;
                            const { ctx, chartArea } = chart;
                            if (!chartArea) return '#ffc107';
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, '#ffd966'); // bottom
                            gradient.addColorStop(1, '#ffb84d'); // top
                            return gradient;
                        },
                        maxBarThickness: 35
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0b5ed7',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.raw} participant${context.raw > 1 ? 's' : ''}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 12 } }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 12 } },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        }
                    }
                }
            });
        }
    }, 'json');


    // Participants Status Chart 
    $.post('<?= base_url("pdc/reports/getParticipantsStatusChart") ?>', function(res) {
        if(res.success && res.data.length) {
            const ctxStatus = document.getElementById('statusChart').getContext('2d');

            // Define colors for each status dynamically
            const statusColors = {
                'Accepted': '#28a745',   // Green
                'Pending': '#ffc107',    // Yellow
                'Cancelled': '#dc3545'    // Red
            };

            const labels = res.data.map(d => d.status);
            const data = res.data.map(d => d.total);
            const backgroundColors = labels.map(l => statusColors[l] || '#6c757d'); // fallback gray

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '65%', // modern donut
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 15,
                                padding: 15,
                                font: { size: 12, weight: '500' }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a,b)=>a+b,0);
                                    const percent = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.raw} (${percent}%)`;
                                }
                            },
                            backgroundColor: '#0b5ed7',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderRadius: 8,
                            padding: 10
                        }
                    }
                }
            });
        }
    }, 'json');

});

    // PDF Download function
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4');
        const table = $('#participantsTable').DataTable();
        const data = table.rows({ search: 'applied' }).data().toArray(); // filtered rows

        // Summary statistics
        const totalEmployees = [...new Set(data.map(r => r.employee_name))].length;
        const totalSelected = data.filter(r => r.status === 'Accepted').length;

        // Header
        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor('#0b5ed7');
        doc.text('State University of Northern Negros', 40, 40);
        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor('#000');
        doc.text('Personnel Development Center (PDC) - Training Participants Report', 40, 60);

        // Filters / Summary
        let filtersText = `Total Employees: ${totalEmployees} | Selected for Training: ${totalSelected}`;
        const year = $('#yearFilter').val() || 'All Years';
        const status = $('#statusFilter').val() || 'All Status';
        const training = $('#trainingFilter').val() || 'All Trainings';
        filtersText += `\nYear: ${year} | Status: ${status} | Training: ${training}`;
        doc.setFontSize(11);
        doc.text(filtersText, 40, 80);

        // Table rows
        const rows = data.map(r => [
            r.employee_training_id,
            r.employee_name,
            r.training_title,
            (r.end_date === '0000-00-00' || !r.end_date) ? '—' : r.end_date,
            r.status.replace(/<[^>]*>?/gm, '')
        ]);

        // Draw table
        doc.autoTable({
            startY: 110,
            head: [['ID', 'Employee', 'Training', 'Date Completed', 'Status']],
            body: rows,
            styles: { fontSize: 10, cellPadding: 4 },
            headStyles: { fillColor: [11, 94, 215], textColor: 255, fontStyle: 'bold' },
            alternateRowStyles: { fillColor: [245, 245, 245] },
            theme: 'grid',
            margin: { left: 40, right: 40 },
            didDrawPage: function (data) {
                const pageCount = doc.internal.getNumberOfPages();
                doc.setFontSize(10);
                doc.setTextColor(100);
                doc.text(`Page ${data.pageNumber} of ${pageCount}`, data.settings.margin.left, doc.internal.pageSize.height - 10);
            }
        });

        doc.save('PDC_Training_Participants.pdf');
    }


</script>

</body>
</html>
