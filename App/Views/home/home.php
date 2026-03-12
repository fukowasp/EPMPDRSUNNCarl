<?php start_session(); ?>
<!DOCTYPE html>
<html lang="en">

<?php homeview_layout(['header','style']); ?>

<body class="bg-home">

    <?php homeview_layout(['logo']); ?>

    <div class="container portal-wrapper d-flex flex-column justify-content-center align-items-center mt-5 pt-4">

        <div class="university-header text-center mb-4">
            <div class="university-logo mb-2">
                <i class="bi <?= htmlspecialchars($data['university']['logo_icon'] ?? 'bi-mortarboard-fill') ?>"></i>
            </div>
            <h1 class="university-title"><?= htmlspecialchars($data['university']['name'] ?? 'State University of Northern Negros') ?></h1>
            <p class="university-subtitle"><?= htmlspecialchars($data['university']['subtitle'] ?? 'Unified Login Portal') ?></p>
        </div>

        <div class="text-center mb-3">
            <h4 class="mb-1"><?= htmlspecialchars($data['welcome'] ?? 'Welcome to SUNN Portal') ?></h4>
            <p class="text-muted mb-0">Select your login portal to access your account</p>
        </div>

        <div class="portal-grid row justify-content-center">
            <?php foreach ($data['portals'] as $portal): ?>
                <a href="<?= htmlspecialchars($portal['link']) ?>" class="portal-option col-12 col-md-4 mb-3 <?= htmlspecialchars($portal['class']) ?>">
                    <?php if (!empty($portal['badge'])): ?>
                        <div class="portal-badge"><?= htmlspecialchars($portal['badge']) ?></div>
                    <?php endif; ?>
                    <div class="portal-icon mb-2">
                        <i class="bi <?= htmlspecialchars($portal['icon']) ?>"></i>
                    </div>
                    <h4 class="portal-title"><?= htmlspecialchars($portal['title']) ?></h4>
                    <p class="portal-description"><?= htmlspecialchars($portal['description']) ?></p>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="bi <?= htmlspecialchars($portal['note_icon']) ?> me-1"></i>
                            <?= htmlspecialchars($portal['note']) ?>
                        </small>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4">
            <div class="border-top pt-3">
                <p class="text-muted mb-0">
                    <i class="bi bi-shield-lock me-1"></i>
                    Access is limited to officially registered <strong>SUNN employees</strong>.
                </p>
            </div>
        </div>

    </div>

    <footer class="footer-info text-center mt-4">
        <p class="text-muted mb-0">
            <i class="bi bi-telephone me-1"></i>
            Support: <?= htmlspecialchars($data['footer']['phone'] ?? '090909090909') ?> • 
            <i class="bi bi-envelope me-1"></i>
            <?= htmlspecialchars($data['footer']['email'] ?? 'sunn.edu.ph') ?>
        </p>
    </footer>

    <?php homeview_layout(['script']); ?>

</body>
</html>