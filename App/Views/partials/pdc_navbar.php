<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);">
  <div class="container-fluid">
    <!-- Sidebar toggle for mobile -->
    <button class="btn btn-light d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <i class="bi bi-list fs-4"></i>
    </button>

    <!-- Navbar brand -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('pdc/dashboard') ?>">
      <i class="bi bi-shield-lock-fill fs-4"></i> PDC Dashboard
    </a>

    <!-- User dropdown -->
    <div class="dropdown ms-auto">
      <button class="pdc-user-btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" style="
    border: none;
    color: #fff;
    background-image: linear-gradient(30deg, #059669, #34d399);
    border-radius: 20px;
    background-size: 100% auto;
    font-family: inherit;
    font-size: 17px;
    padding: 0.6em 1.5em;
    transition: background-size 0.3s ease, box-shadow 0.3s ease;
">
  <i class="bi bi-person-circle me-2"></i> PDC User
</button>

      <ul class="dropdown-menu dropdown-menu-end shadow">
        <li>
          <form method="POST" action="<?= base_url('pdc/logout') ?>" style="margin:0;">
            <?= csrf_input(); ?>
            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
              <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Custom Styles -->
<style>
/* Gradient style for the PDC User dropdown button */
.pdc-user-btn {
  border: none;
  color: #fff;
  background-image: linear-gradient(30deg, #0400ff, #4ce3f7);
  border-radius: 20px;
  background-size: 100% auto;
  font-family: inherit;
  font-size: 17px;
  padding: 0.6em 1.5em;
  transition: background-size 0.3s ease, box-shadow 0.3s ease;
}

.pdc-user-btn:hover {
  background-position: right center;
  background-size: 200% auto;
  animation: pulse512 1.5s infinite;
}

/* Pulse effect */
@keyframes pulse512 {
  0% {
    box-shadow: 0 0 0 0 #05bada66;
  }
  70% {
    box-shadow: 0 0 0 10px rgb(218 103 68 / 0%);
  }
  100% {
    box-shadow: 0 0 0 0 rgb(218 103 68 / 0%);
  }
}
</style>
