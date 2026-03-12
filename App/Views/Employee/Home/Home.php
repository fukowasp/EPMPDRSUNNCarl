<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($data['title'] ?? 'Login Portal') ?></title>
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/index.css') ?>">

</head>
<body>
    <div class="portal-container">
        <div class="portal-card">

            <!-- University Header -->
            <div class="university-header">
                <div class="university-logo">
                    <i class="bi <?= htmlspecialchars($data['university']['logo_icon'] ?? 'bi-mortarboard-fill') ?>"></i>
                </div>
                <h1 class="university-title"><?= htmlspecialchars($data['university']['name'] ?? 'University') ?></h1>
                <p class="university-subtitle"><?= htmlspecialchars($data['university']['subtitle'] ?? '') ?></p>
            </div>

            <!-- Portal Content -->
            <div class="portal-content">
                <div class="text-center mb-3">
                    <h4 class="mb-1"><?= htmlspecialchars($data['welcome'] ?? 'Welcome!') ?></h4>
                    <p class="text-muted mb-0">Select your login portal to access your account</p>
                </div>

                <div class="portal-grid">
                    <?php foreach ($data['portals'] as $portal): ?>
                        <a href="<?= htmlspecialchars($portal['link']) ?>" class="portal-option <?= htmlspecialchars($portal['class']) ?>">
                            <?php if ($portal['badge']): ?>
                                <div class="portal-badge"><?= htmlspecialchars($portal['badge']) ?></div>
                            <?php endif; ?>
                            <div class="portal-icon">
                                <i class="bi <?= htmlspecialchars($portal['icon']) ?>"></i>
                            </div>
                            <h4 class="portal-title"><?= htmlspecialchars($portal['title']) ?></h4>
                            <p class="portal-description"><?= htmlspecialchars($portal['description']) ?></p>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi <?= htmlspecialchars($portal['note_icon']) ?> me-1"></i>
                                    <?= htmlspecialchars($portal['note']) ?>
                                </small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

              <!-- Access Notice -->
              <div class="text-center mt-3">
                  <div class="border-top pt-3">
                      <p class="text-muted mb-0">
                          <i class="bi bi-shield-lock me-1"></i>
                          Access is limited to officially registered <strong>SUNN employees</strong>.
                      </p>
                  </div>
              </div>
            </div>

            <!-- Footer Info -->
            <div class="footer-info">
                <p>
                    <i class="bi bi-telephone me-1"></i>
                    Support: <?= htmlspecialchars($data['footer']['phone'] ?? '') ?> • 
                    <i class="bi bi-envelope me-1"></i>
                    <?= htmlspecialchars($data['footer']['email'] ?? '') ?>
                </p>
            </div>
        </div>
    </div>

    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const portalOptions = document.querySelectorAll('.portal-option');
            portalOptions.forEach(option => {
                option.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });
                option.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
