<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Employee Login - SUNN</title>
<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <!-- University Header / Logo -->
        <div class="university-header text-center mb-4">
            <div class="university-logo mb-2">
                <i class="bi bi-mortarboard-fill fs-1"></i>
            </div>
            <h1 class="university-title mb-0">State University of Northern Negros</h1>
            <p class="university-subtitle mb-2">Employee Portal</p>
            <div class="role-badge badge bg-primary text-white">
                <i class="bi bi-person-badge me-1"></i>Employee Login
            </div>
        </div>

        <!-- Login Form -->
        <div class="login-form">
            <form id="employeeLoginForm">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Employee ID" required>
                    <label for="employee_id"><i class="bi bi-person me-2"></i>Employee ID</label>
                </div>

                <div class="form-floating mb-3 position-relative">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                    <i class="bi bi-eye-slash toggle-password" style="position:absolute; top:50%; right:15px; cursor:pointer; transform:translateY(-50%);"></i>
                </div>

                <button type="submit" class="btn btn-login w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <!-- Login Links -->
            <div class="login-links text-center">
                <div class="row">
                    <div class="col-12 mb-2">
                        <a href="<?= base_url('/') ?>"><i class="bi bi-arrow-left me-1"></i>Back to Main Portal</a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('pdc/login') ?>">PDC Login</a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/login') ?>">Admin/HR Login</a>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted"><i class="bi bi-shield-check me-1"></i>Secure login protected</small>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index:1080">
    <div id="toastContainer"></div>
</div>

<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>

<script>
document.getElementById('employeeLoginForm').addEventListener('submit', async function(e){
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    // Show loading spinner
    Swal.fire({
        title: 'Signing in...',
        text: 'Please wait while we verify your credentials.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const response = await fetch('<?= base_url("employee/login") ?>', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Redirecting...',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: data.message
            });
        }

    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Unable to process request. Please try again.'
        });
    }
});

    // Toggle password visibility
    const toggle = document.querySelector('.toggle-password');
    const password = document.getElementById('password');

    toggle.addEventListener('click', ()=>{
        if(password.type === 'password'){
            password.type = 'text';
            toggle.classList.replace('bi-eye-slash','bi-eye');
        } else {
            password.type = 'password';
            toggle.classList.replace('bi-eye','bi-eye-slash');
        }
});
</script>
</body>
</html>