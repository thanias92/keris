<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SIMIKO v3' ?></title>

    <!-- Public Sans (Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/fonts/tabler-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fonts/feather.css') ?>">

    <!-- Mantis Styles (URUTAN PENTING) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style-preset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/uikit.css') ?>">
</head>

<body>

    <?= $this->include('partials/sidebar') ?>
    <?= $this->include('partials/navbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Feather Icons -->
    <script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>
    <script>
        feather.replace();
    </script>

    <!-- Mantis Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>