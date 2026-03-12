<!-- Sidebar -->
<nav id="sidebarMenu" class="collapse d-lg-block sidebar flex-shrink-0">
  <div class="sidebar-header p-3">
    <h5 class="mb-0"><i class="bi bi-grid-fill me-2"></i>Admin Menu</h5>
  </div>

  <div class="list-group list-group-flush mt-2">
    <?php $currentUri = $_SERVER['REQUEST_URI']; ?>
    <!-- Section: Overview -->
    <div class="px-3 mt-2 text-muted small fw-bold text-uppercase">Overview</div>
    <a href="<?= base_url('admin/dashboard') ?>" 
       class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/dashboard') !== false ? 'active' : '' ?>">
      <i class="bi bi-house-door-fill me-2"></i>Dashboard
    </a>
    <!-- Section: Setup / Master Data -->
    <div class="px-3 mt-3 text-muted small fw-bold text-uppercase">Setup</div>
    <a href="<?= base_url('admin/depoffices') ?>" 
      class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/depoffices') !== false ? 'active' : '' ?>">
      <i class="bi bi-building me-2"></i>Department / Offices
    </a>
    <a href="<?= base_url('admin/gradtable') ?>" 
      class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/gradtable') !== false ? 'active' : '' ?>">
      <i class="bi bi-mortarboard-fill me-2"></i>Degree Program
    </a>
    <a href="<?= base_url('admin/academicrank') ?>" 
      class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/academicrank') !== false ? 'active' : '' ?>">
      <i class="bi bi-award-fill me-2"></i>Academic Rank
    </a>
    <!-- Section: Employee Management -->
    <div class="px-3 mt-3 text-muted small fw-bold text-uppercase">Employee Records</div>
    <a href="<?= base_url('Admin/EmployeeList') ?>" 
       class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/employeelist') !== false ? 'active' : '' ?>">
      <i class="bi bi-people-fill me-2"></i>Employee Management
    </a>

    <!-- Section: Account Management -->
    <div class="px-3 mt-3 text-muted small fw-bold text-uppercase">Accounts</div>
    <a href="<?= base_url('admin/manageaccounts') ?>" 
       class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/manageaccounts') !== false ? 'active' : '' ?>">
      <i class="bi bi-person-circle me-2"></i>Manage Accounts
    </a>

    <!-- Section: Reports and Analytics -->
    <div class="px-3 mt-3 text-muted small fw-bold text-uppercase">Reports & Analytics</div>
    <a href="<?= base_url('admin/reports') ?>" 
       class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/reports') !== false ? 'active' : '' ?>">
      <i class="bi bi-file-earmark-bar-graph me-2"></i>Generate Reports
    </a>
    <a href="<?= base_url('admin/graduatestudies') ?>" 
       class="list-group-item list-group-item-action border-0 py-2 <?= strpos($currentUri, '/admin/graduatestudies') !== false ? 'active' : '' ?>">
      <i class="bi bi-graph-up me-2"></i>Graduate Studies Analytics
    </a>
  </div>
</nav>
<!-- Custom CSS -->
<style>
  #sidebarMenu {
    background: linear-gradient(135deg, #1e3a8a 0%, #059669 100%, #dbeafe 200%);
    color: #fff;
  }

  #sidebarMenu .list-group-item {
    background-color: transparent;
    color: #fff;
  }

  #sidebarMenu .list-group-item:hover,
  #sidebarMenu .list-group-item.active {
    background-color: rgba(255,255,255,0.15); /* Slightly lighter for hover/active */
    color: #fff;
  }

  #sidebarMenu .sidebar-header h5 {
    color: #fff;
  }

  #sidebarMenu .text-muted {
    color: rgba(255, 255, 255, 0.7) !important;
  }
</style>