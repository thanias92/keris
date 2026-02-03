<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SIMIKO v3' ?></title>

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

    <!-- 1️⃣ Popper (WAJIB untuk tooltip) -->
    <script src="<?= base_url('assets/js/plugins/popper.min.js') ?>"></script>

    <!-- 2️⃣ Bootstrap -->
    <script src="<?= base_url('assets/js/plugins/bootstrap.min.js') ?>"></script>

    <!-- 3️⃣ Simplebar -->
    <script src="<?= base_url('assets/js/plugins/simplebar.min.js') ?>"></script>

    <!-- 4️⃣ Config -->
    <!--<script src="<?= base_url('assets/js/config.js') ?>"></script> -->

    <!-- 5️⃣ Pcoded -->
    <script src="<?= base_url('assets/js/pcoded.js') ?>"></script>

    <!-- 6️⃣ Feather -->
    <script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>
    <script>
        feather.replace();
    </script>

    <!-- 7️⃣ Main -->
    <!-- <script src="<?= base_url('assets/js/main.js') ?>"></script> -->
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