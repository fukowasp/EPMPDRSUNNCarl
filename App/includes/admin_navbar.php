<?php
use App\Helpers\Auth;
$admin = Auth::adminUser();
?>
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
  <div class="container-fluid">

    <!-- Sidebar toggle button for small screens -->
    <button class="btn btn-outline-secondary d-lg-none me-3" type="button" 
            data-bs-toggle="collapse" data-bs-target="#sidebarMenu" 
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle sidebar">
      <i class="bi bi-list"></i>
    </button>

    <a class="navbar-brand fw-bold" href="<?= base_url('admin/dashboard') ?>">
      <i class="bi bi-shield-check me-2"></i>Admin Dashboard
    </a>

    <div class="ms-auto">
      <?php if ($admin): ?>
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <?php if (!empty($admin['profile_image'])): ?>
              <img src="<?= base_url('uploads/admins/' . htmlspecialchars($admin['profile_image'])) ?>" 
                   alt="Admin Profile" class="rounded-circle me-2" width="32" height="32">
            <?php else: ?>
              <i class="bi bi-person-circle me-2"></i>
            <?php endif; ?>
            <?= htmlspecialchars($admin['name'] ?? 'Admin User') ?>
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
              </a>
            </li>
          </ul>
        </div>
      <?php else: ?>
        <a href="<?= base_url('admin/login') ?>" class="btn btn-outline-primary">
          <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>
