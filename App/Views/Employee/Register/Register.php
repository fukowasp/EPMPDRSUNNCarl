<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Registration - State University of Northern Negros</title>
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/register.css') ?>">
    <style>
       
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- University Header -->
            <div class="university-header">
                <div class="university-logo">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h1 class="university-title">State University of Northern Negros</h1>
                <p class="university-subtitle">Employee Registration Portal</p>
                <div class="role-badge">
                    <i class="bi bi-person-add me-1"></i>New Employee Registration
                </div>
            </div>
            
            <!-- Registration Form -->
            <div class="register-form">
                <form action="#" method="post" enctype="multipart/form-data" id="employeeRegisterForm">
                    

                    
                    <!-- Account Information Section -->
                    <div class="mb-3">
                        <h6 class="section-title">
                            <i class="bi bi-key-fill me-2"></i>Account Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="employee_id" class="form-label">Employee ID </label>
                                <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="EMP-1234" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="department" class="form-label">Department/College *</label>
                                <select class="form-select" id="department" name="department" required>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="employment_type" class="form-label">Employment Type *</label>
                                <select class="form-select" id="employment_type" name="employment_type" required>
                                    <option value="">Select Employment Type</option>
                                    <option value="Permanent">Permanent</option>
                                    <option value="Non-Permanent">Non-Permanent</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="password-strength" id="password-strength"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="confirm_password" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div id="password-match" class="form-text"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> of SUNN *
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-register">
                        <i class="bi bi-person-check me-2"></i>Register Employee Account
                    </button>
                </form>
            </div>
            
            <!-- Register Links -->
            <div class="register-links">
                <div class="mb-2">
                    <a href="<?= base_url('/') ?>">
                        <i class="bi bi-arrow-left me-1"></i>Back to Main Portal
                    </a>
                </div>
                <p class="mb-1">Already have an account?</p>
                <div class="row">
                    <div class="col-4">
                        <a href="<?= base_url('employee/login') ?>">Employee</a>
                    </div>
                    <div class="col-4">
                        <a href="<?= base_url('pdc/login')?>">PDC</a>
                    </div>
                    <div class="col-4">
                        <a href="<?= base_url('admin/login')?>">Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Bootstrap JS -->
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Registration Form JS -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("employeeRegisterForm");
    const password = document.getElementById("password");
    const confirm = document.getElementById("confirm_password");
    const passwordStrengthEl = document.getElementById("password-strength");
    const passwordMatchEl = document.getElementById("password-match");

    // Password live strength and validation check
    password.addEventListener("input", () => {
        const val = password.value;
        let errorMsg = "";

        if (val.length < 8) {
            errorMsg = "Password must be at least 8 characters";
        } else if (!/[A-Z]/.test(val)) {
            errorMsg = "Password must include at least one uppercase letter";
        } else if (!/[a-z]/.test(val)) {
            errorMsg = "Password must include at least one lowercase letter";
        } else if (!/\d/.test(val)) {
            errorMsg = "Password must include at least one number";
        }

        if (errorMsg) {
            passwordStrengthEl.textContent = errorMsg;
            passwordStrengthEl.style.color = "red";
        } else {
            passwordStrengthEl.textContent = "Password is strong";
            passwordStrengthEl.style.color = "green";
        }
    });

    // Password match live check
    const checkPasswordMatch = () => {
        if (confirm.value.length === 0) {
            passwordMatchEl.textContent = "";
            return;
        }
        if (password.value === confirm.value) {
            passwordMatchEl.textContent = "Passwords match";
            passwordMatchEl.style.color = "green";
        } else {
            passwordMatchEl.textContent = "Passwords do not match";
            passwordMatchEl.style.color = "red";
        }
    };
    password.addEventListener("input", checkPasswordMatch);
    confirm.addEventListener("input", checkPasswordMatch);

    // Form submit
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const fd = new FormData(form);
        const jsonData = {};
        fd.forEach((v, k) => jsonData[k] = v);

        // Frontend password validation
        if (jsonData.password !== jsonData.confirm_password) {
            alert("Passwords do not match!");
            return;
        }
        if (jsonData.password.length < 8 || !/[A-Z]/.test(jsonData.password) || !/[a-z]/.test(jsonData.password) || !/\d/.test(jsonData.password)) {
            alert("Password must be at least 8 characters, include uppercase, lowercase, and a number");
            return;
        }

        fetch("<?= base_url('employee/register') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                employee_id: jsonData.employee_id,
                department: jsonData.department,
                employment_type: jsonData.employment_type,
                password: jsonData.password
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                form.reset();
                window.location.href = data.redirect;
            } else if (data.status === "error" && data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const el = document.getElementById(`error-${key}`);
                    if (el) el.textContent = data.errors[key];
                });
            } else {
                alert(data.message || "Unexpected error occurred");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Unable to connect to the server");
        });
    });
});

fetch("<?= base_url('employee/departments/json') ?>")
  .then(res => res.json())
  .then(data => {
      const select = document.getElementById("department");
      select.innerHTML = '<option value="">Select Department/College</option>';
      data.data.forEach(dep => {
          const option = document.createElement("option");
          option.value = dep.name; // or dep.dept_id
          option.textContent = dep.name;
          select.appendChild(option);
      });
  })
  .catch(err => console.error("Failed to load departments", err));


</script>
</body>
</html>