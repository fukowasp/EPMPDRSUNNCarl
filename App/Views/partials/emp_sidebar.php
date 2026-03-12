<aside class="main-sidebar">
    <!-- Brand Logo -->
    <a href="<?= base_url('employee/dashboard') ?>" class="brand-link">
        <div class="brand-image">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <div class="brand-text">SUNN Portal</div>
            <div class="brand-subtitle">Personal Data Sheet</div>
        </div>
    </a>

    <!-- User Panel -->
    <div class="user-panel d-flex align-items-center">
        <div class="image">
            <?php if (!empty($personalInfo['employee_photo_base64'])): ?>
                <img src="<?= $personalInfo['employee_photo_base64'] ?>" class="img-circle" alt="Employee Photo">
            <?php else: ?>
                <i class="bi bi-person-circle" style="font-size: 2rem; color: white;"></i>
            <?php endif; ?>
        </div>
        <div class="info">
            <div style="color:white; font-weight: 500;">
                <?= $employeeName ?? 'Employee Name' ?>
            </div>
            <p style="color:white; margin:0;">
                <?= $personalInfo['employee_id'] ?? 'EMP-0000' ?> •
                <?= $personalInfo['department'] ?? 'Department' ?>
            </p>
        </div>


    </div>


    <!-- Sidebar Menu -->
    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

            <li class="nav-header">PDS SECTIONS</li>

            <!-- C1 -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseC1" role="button" aria-expanded="false" aria-controls="collapseC1">
                    <span><i class="bi bi-collection"></i> C1</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="collapseC1">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="<?= base_url('employee/info') ?>" class="nav-link">
                                <i class="bi bi-person-vcard"></i> I. Personal Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('employee/famback') ?>" class="nav-link">
                                <i class="bi bi-people"></i> II. Family Background
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('employee/eduback') ?>" class="nav-link">
                                <i class="bi bi-mortarboard"></i> III. Educational Background
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('employee/eduback/graduate') ?>" class="nav-link">
                                <i class="bi bi-mortarboard"></i> III. Graduate Studies
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- C2 -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseC2" role="button" aria-expanded="false" aria-controls="collapseC2">
                    <span><i class="bi bi-award"></i> C2</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="collapseC2">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="<?= base_url('employee/civilser') ?>" class="nav-link">
                                <i class="bi bi-award-fill"></i> IV. Civil Service Eligibility
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('employee/workexp') ?>" class="nav-link">
                                <i class="bi bi-briefcase"></i> V. Work Experience
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- C3 -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseC3" role="button" aria-expanded="false" aria-controls="collapseC3">
                    <span><i class="bi bi-list-task"></i> C3</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="collapseC3">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="<?= base_url('employee/volunterwork') ?>" class="nav-link">
                                <i class="bi bi-heart"></i> VI. Voluntary Work / Civic Involvement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('employee/learndev') ?>" class="nav-link">
                                <i class="bi bi-journal-bookmark"></i> VII. Learning & Development / Trainings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('employee/otherinfo') ?>" class="nav-link">
                                <i class="bi bi-info-circle"></i> VIII. Other Information
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- C4 -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseC4" role="button" aria-expanded="false" aria-controls="collapseC4">
                    <span><i class="bi bi-file-earmark-text"></i> C4</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="collapseC4">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="<?= base_url('employee/c4sections') ?>" class="nav-link">
                                <i class="bi bi-question-circle"></i> IX. Additional Questions & Declaration
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Training History -->
            <li class="nav-item">
                <a href="<?= base_url('employee/pds/preview') ?>" class="nav-link">
                    <span><i class="bi bi-eye"></i> Preview your PDS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('employee/trainings/history') ?>" class="nav-link">
                    <span><i class="bi bi-card-checklist"></i> Training History</span>
                </a>
            </li>

            <li class="nav-header">ACCOUNT</li>
            <li class="nav-item">
                <a href="<?= base_url('employee/logout') ?>" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>

        </ul>
    </nav>
</aside>