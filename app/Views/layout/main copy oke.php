<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'KERIS JAYA' ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/fonts/tabler-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fonts/feather.css') ?>">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style-preset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/uikit.css') ?>">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?= $this->include('partials/sidebar') ?>
    <?= $this->include('partials/navbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- ✅ BOOTSTRAP 5 BUNDLE (WAJIB & SATU-SATUNYA) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Plugins -->
    <script src="<?= base_url('assets/js/plugins/simplebar.min.js') ?>"></script>

    <!-- Layout / Sidebar -->
    <script src="<?= base_url('assets/js/pcoded.js') ?>"></script>

    <!-- Feather Icons -->
    <script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>
    <script>
        feather.replace();
    </script>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-mantis'
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>