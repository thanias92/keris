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
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/uikit.css') ?>">
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

    <!-- Sidebar dependencies -->
    <script src="<?= base_url('assets/js/plugins/simplebar.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <script src="<?= base_url('assets/js/pcoded.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.bootstrap) {
                bootstrap.Collapse.prototype._config.animation = false;
            }
        });
    </script>

    <!-- Feather Icons -->
    <script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>
    <script>
        feather.replace();
    </script>

    <!-- Mantis Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

<script>
    function confirmSubmit(btn) {
        const form = btn.closest('form'); // 🔑 AMBIL FORM YANG BENAR
        const isCreate = btn.innerText.includes('Simpan');

        Swal.fire({
            title: isCreate ? 'SIMPAN DATA?' : 'UBAH DATA?',
            text: isCreate ?
                'Apakah yakin ingin menyimpan data ini?' : 'Apakah yakin ingin mengubah data ini?',
            icon: 'question',
            width: 360,
            padding: '1.25rem',
            customClass: {
                popup: 'swal-mantis'
            },
            showCancelButton: true,
            confirmButtonText: isCreate ? 'Simpan' : 'Ubah',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // ✅ SUBMIT YANG BENAR
            }
        });
    }

    function confirmDelete(url) {
        Swal.fire({
            title: 'HAPUS DATA?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            width: 360,
            padding: '1.25rem',
            customClass: {
                popup: 'swal-mantis'
            },
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete').submit(); // ✅ POST
            }
        });
    }
</script>

</html>