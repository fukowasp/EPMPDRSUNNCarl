<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PDC Login - State University of Northern Negros</title>
  <style>
    body {
      visibility: hidden; /* hide page initially */
    }
  </style>
  <script>
    window.addEventListener('load', () => {
      document.body.style.visibility = 'visible'; // show when fully loaded
    });
  </script>
    <!-- Bootstrap & Icons -->
 	<link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css')?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/pdc/pdclogin.css')?>">
  </head>
  <body>
    <main class="login-container">
      <section class="login-card">
        <!-- Header -->
        <header class="university-header">
          <div class="university-logo">
            <i class="bi bi-diagram-3-fill"></i>
          </div>
          <h1 class="university-title">State University of Northern Negros</h1>
          <p class="university-subtitle">Program Development Committee</p>
          <span class="role-badge">
            <i class="bi bi-people-fill me-1"></i> PDC Portal
          </span>
          <div class="pdc-info">
            <i class="bi bi-info-circle me-1"></i>
            Access to program development, curriculum planning, and academic
            oversight tools
          </div>
        </header>

        <!-- Form -->
        <div class="login-form">
        <form action="<?= base_url('pdc/login') ?>" method="post" id="pdcLoginForm">
            <input type="hidden" name="login_type" value="pdc" />
            <?= csrf_input() ?> <!-- ✅ CSRF token -->

            <!-- username -->
            <div class="form-floating">
              <input type="text" class="form-control" id="username" name="username"
                    placeholder="Username" required autocomplete="username" />
              <label for="username">
                <i class="bi bi-person-badge me-2"></i> PDC Username
              </label>
            </div>

            <!-- password -->
            <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password"
                    placeholder="Password" required autocomplete="current-password" />
              <label for="password">
                <i class="bi bi-shield-lock me-2"></i> Secure Password
              </label>
            </div>

            <button type="submit" class="btn btn-login">
              <i class="bi bi-shield-check me-2"></i> Secure Sign In
            </button>
        </form>
        </div>

        <!-- Links -->
        <footer class="login-links">
          <div class="row">
            <div class="col-12 mb-2">
              <a href="<?= base_url('/')?>">
                <i class="bi bi-arrow-left me-1"></i> Back to Main Portal
              </a>
            </div>
            <div class="col-6">
              <a href="<?= base_url('employee/login')?>">Employee Login</a>
            </div>
            <div class="col-6">
              <a href="<?= base_url('admin/login')?>">Admin/HR Login</a>
            </div>
          </div>
          <div class="mt-3">
            <small class="text-muted">
              <i class="bi bi-shield-fill-check me-1"></i>
              PDC Portal – Enhanced security for academic administration
            </small>
          </div>
        </footer>
      </section>
    </main>

    <!-- Bootstrap JS -->
<script src="<?= base_url('libs/jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('libs/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script>
$(document).ready(function() {
    const form = $("#pdcLoginForm");
    const button = form.find("button[type='submit']");
    const usernameInput = $("#username");
    const passwordInput = $("#password");

    form.on("submit", function(e) {
        e.preventDefault();

        const username = usernameInput.val().trim();
        const password = passwordInput.val();

        // Basic client-side validation
        if (username.length < 3 || password.length < 6) {
            Swal.fire({
                icon: 'warning',
                title: 'Input Required',
                text: 'Please enter valid login credentials.',
                timer: 1800,
                showConfirmButton: false
            });
            return;
        }

        // Disable submit button while processing
        button.prop("disabled", true);

        // Show loading
        Swal.fire({
            title: 'Authenticating...',
            text: 'Securing access to PDC Portal.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
        });

        // AJAX login
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            dataType: "json",

            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Access Granted',
                        text: 'Redirecting...',
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    handleLoginError(response.message || 'Invalid login credentials.');
                }
            },

            error: function() {
                handleLoginError('Server error. Please try again.');
            },

            complete: function() {
                // Always re-enable the button
                button.prop("disabled", false);
            }
        });
    });

    function handleLoginError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: message,
            timer: 2000,
            showConfirmButton: false,
            willClose: () => {
                resetForm();
            }
        });
    }

    function resetForm() {
        // Reset form values
        form[0].reset();

        // Reset floating labels (Bootstrap 5)
        form.find('.form-floating input').each(function() {
            this.classList.remove('is-valid');
            this.classList.remove('is-invalid');
        });

        // Reset placeholders / floating label positions
        form.find('.form-floating input').each(function() {
            if (!this.value) this.blur();
        });

        // Focus username for UX
        usernameInput.focus();

        // Re-enable button just in case
        button.prop("disabled", false);
    }
});
</script>
</html>