<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Training History</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSS -->
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/datatables/css/responsive.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/trainings.css') ?>">

</head>

<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../../partials/emp_sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="page-title"><i class="bi bi-card-checklist"></i> Training History</h1>
                <p class="page-subtitle">View all assigned trainings and respond as needed.</p>
            </div>

            <!-- Trainings Card -->
            <div class="card training-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="employeeTrainingsTable" class="table table-hover nowrap align-middle w-100">
                            <thead>
                                <tr>
                                    <th>Training Title</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('dist/datatables/js/dataTables.responsive.min.js') ?>"></script>

<script>
$(function() {
    const csrfToken = '<?= csrf_token() ?>';

    const table = $('#employeeTrainingsTable').DataTable({
        responsive: true,
        destroy: true,
        language: { emptyTable: "No trainings assigned." },
        ajax: {
            url: '<?= base_url("employee/trainings/history/fetch") ?>',
            type: 'GET',
            data: d => d._csrf_token = csrfToken,
            dataSrc: 'data'
        },
        columns: [
            { data: 'training_title' },
            { data: 'type' },
            { data: 'start_date', defaultContent: '—' },
            { data: 'end_date', defaultContent: '—' },
            {
                data: 'status',
                render: (s, type, row) => {
                    const badges = {
                        'Accepted': `<span class="badge badge-success"><i class="bi bi-check-circle-fill"></i> Accepted</span>`,
                        'Cancelled': `<span class="badge badge-danger clickable-reason" data-reason="${row.cancel_reason || 'No reason provided'}">
                                        <i class="bi bi-x-circle-fill"></i> View Reason
                                      </span>`,
                        'Pending': `<span class="badge badge-warning clickable-status" data-id="${row.employee_training_id}">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>`
                    };
                    return badges[s] || s;
                }
            }
        ]
    });

    // Respond to Pending
    $('#employeeTrainingsTable').on('click', '.clickable-status', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Respond to Training',
            text: 'Accept or decline this training?',
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: 'Accept',
            denyButtonText: 'Decline',
            confirmButtonColor: 'var(--sunn-secondary)',
            denyButtonColor: 'var(--sunn-accent)'
        }).then(result => {
            if(result.isConfirmed) sendAction(id,'accept');
            else if(result.isDenied) promptCancel(id);
        });

        function promptCancel(id){
            Swal.fire({
                title:'Cancellation Reason',
                input:'textarea',
                showCancelButton:true
            }).then(res=>{
                if(res.isConfirmed && res.value.trim() !== '') sendAction(id,'cancel',res.value.trim());
                else if(res.isConfirmed) Swal.fire('Error','Reason is required.','error');
            });
        }

        function sendAction(id,action,reason=null){
            $.ajax({
                url: `<?= base_url("employee/trainings/history/") ?>${action}`,
                type:'POST',
                dataType:'json',
                data:{ id, reason, _csrf_token: csrfToken },
                success: res=>{
                    if(res.success){
                        table.ajax.reload(null,false);
                        Swal.fire('Success',`Training ${action==='accept'?'accepted':'declined'} successfully!`,'success');
                    } else Swal.fire('Error', res.message || 'Update failed','error');
                },
                error:()=> Swal.fire('Error','Server connection failed','error')
            });
        }
    });

    // View Cancel Reason
    $('#employeeTrainingsTable').on('click','.clickable-reason',function(){
        Swal.fire({title:'Cancellation Reason',text: $(this).data('reason'),icon:'info'});
    });
});
</script>

</body>
</html>
