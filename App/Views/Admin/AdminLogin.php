<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin/HR Login - State University of Northern Negros</title>

    <!-- CSRF Meta -->
    <?= csrf_meta() ?>

    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/adminlogin.css') ?>">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- University Header -->
            <div class="university-header">
                <div class="university-logo">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <h1 class="university-title">State University of Northern Negros</h1>
                <p class="university-subtitle">Administrative Portal</p>
                <div class="role-badge"><i class="bi bi-gear-fill me-1"></i>Admin/HR Access</div>
                <div class="security-notice">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <strong>Restricted Access:</strong> This portal is for authorized personnel only. All access is logged and monitored.
                </div>
            </div>

            <!-- Login Form -->
            <div class="login-form">
                <form action="<?= base_url('admin/login') ?>" method="post" id="adminLoginForm">
                    <!-- CSRF Input -->
                    <?= csrf_input() ?>
                    <input type="hidden" name="login_type" value="admin">

                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Admin Username" required autocomplete="username">
                        <label for="username"><i class="bi bi-person-fill-gear me-2"></i>Admin Username</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Secure Password" required autocomplete="current-password">
                        <label for="password"><i class="bi bi-key-fill me-2"></i>Secure Password</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="secureSession">
                        <label class="form-check-label" for="secureSession"><strong>Secure session</strong> (Auto-logout after 30 minutes of inactivity)</label>
                    </div>

                    <button type="submit" class="btn btn-login"><i class="bi bi-shield-check me-2"></i>Secure Admin Login</button>
                </form>
            </div>

            <!-- Login Links -->
            <div class="login-links">
                <div class="row">
                    <div class="col-12 mb-2"><a href="<?= base_url('/') ?>"><i class="bi bi-arrow-left me-1"></i>Back to Main Portal</a></div>
                    <div class="col-6"><a href="<?= base_url('employee/login')?>">Employee Login</a></div>
                    <div class="col-6"><a href="<?= base_url('pdc/login')?>">PDC Login</a></div>
                </div>
                <div class="mt-3"><small class="text-muted"><i class="bi bi-shield-fill-exclamation me-1"></i>Administrative access - All activities are logged and audited</small></div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
    $(function() {
        // Attach CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle login submit with JSON
        $('#adminLoginForm').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: "<?= base_url('admin/login') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    // Refresh CSRF token
                    if(res.csrf_token) {
                        $('meta[name="csrf-token"]').attr('content', res.csrf_token);
                    }

                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: 'Redirecting...',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.href = res.redirect;
                        }, 1500);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: res.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: xhr.status + " " + xhr.statusText
                    });
                }
            });
        });

        // Inactivity auto logout (JSON)
        let inactivityTime = 30 * 60 * 1000; // 30 minutes
        let logoutTimer;

        function resetTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(function() {
                $.ajax({
                    url: "<?= base_url('admin/logout') ?>",
                    type: "GET",
                    dataType: "json",
                    success: function() {
                        Swal.fire({
                            icon: 'info',
                            title: 'Session Expired',
                            text: 'You have been logged out due to inactivity.'
                        }).then(() => {
                            window.location.href = "<?= base_url('admin/login') ?>";
                        });
                    }
                });
            }, inactivityTime);
        }

        $(document).on('mousemove keypress click scroll', resetTimer);
        resetTimer();
    });
    </script>
</body>
</html>
