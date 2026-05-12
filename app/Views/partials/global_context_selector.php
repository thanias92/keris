<?php

use App\Models\TimKerjaModel;

$timModel = new TimKerjaModel();

$listTim = $timModel
    ->orderBy('nama_tim', 'ASC')
    ->findAll();

$selectedTahun = session('global_tahun') ?? date('Y');

$selectedTim = session('global_id_tim') ?? session('id_tim');

$selectedKegiatan = session('global_id_kegiatan') ?? '';
?>
<div class="global-context-bar">

    <div class="context-group">
        <select name="ctx_tahun" id="ctx_tahun" class="select-tahun">

            <?php for ($y = date('Y'); $y >= 2024; $y--): ?>

                <option
                    value="<?= $y ?>"
                    <?= $selectedTahun == $y ? 'selected' : '' ?>>
                    <?= $y ?>
                </option>

            <?php endfor; ?>

        </select>
    </div>

    <div class="context-group">
        <select name="ctx_tim" id="ctx_tim">

            <?php foreach ($listTim as $tim): ?>

                <option
                    value="<?= $tim['id_tim'] ?>"
                    <?= $selectedTim == $tim['id_tim'] ? 'selected' : '' ?>>
                    <?= esc($tim['nama_tim']) ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div class="context-group">
        <select name="ctx_kegiatan" id="ctx_kegiatan">
            <option value="">Semua Kegiatan</option>
        </select>
    </div>

    <button class="btn-context-reset" title="Reset filter" onclick="resetGlobalContext()">
        <i class="ti ti-rotate"></i>
    </button>

</div>

<link rel="stylesheet" href="<?= base_url('assets/css/global-context-selector.css') ?>">
<script>
    window.GC_CONFIG = {
        csrf: {
            name: '<?= csrf_token() ?>',
            token: '<?= csrf_hash() ?>',
        },

        url: {
            set: '<?= site_url('global-context/set') ?>',
            kegiatan: '<?= site_url('global-context/kegiatan') ?>',
            reset: '<?= site_url('global-context/reset') ?>',
        },

        default: {
            tahun: '<?= session('global_tahun') ?? date('Y') ?>',
            id_tim: '<?= session('global_id_tim') ?? session('id_tim') ?>',
            id_kegiatan: '<?= session('global_id_kegiatan') ?? '' ?>',
        },

        user: {
            role: '<?= session('user_role') ?>',
            id_tim: '<?= session('id_tim') ?>'
        }
    };
</script>
<script src="<?= base_url('assets/js/global-context-selector.js') ?>"></script>