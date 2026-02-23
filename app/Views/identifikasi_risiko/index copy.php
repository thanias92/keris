<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">
    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header pk-header">
        <div class="page-block">
            <div class="row align-items-center">

                <!-- LEFT -->
                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Manajemen Risiko</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Identifikasi Risiko
                            </li>
                        </ol>
                    </nav>

                    <div class="d-flex align-items-center gap-3">
                        <h2 class="page-title mb-0">Identifikasi Risiko</h2>

                        <?php if (!$activeKonteks): ?>
                            <span class="badge bg-warning-subtle text-warning border border-warning">
                                Konteks belum dipilih
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <button class="btn btn-primary"
                        <?= !$activeKonteks ? 'disabled' : '' ?>
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRisiko">
                        <i class="ti ti-plus"></i> Risiko
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= END HEADER ================= -->

    <!-- DROPDOWN KONTEKS -->
    <?php if (!empty($konteksList)): ?>
        <?= view('identifikasi_risiko/_context_selector', [
            'konteksList'   => $konteksList,
            'activeKonteks' => $activeKonteks
        ]) ?>
    <?php endif; ?>

    <!-- CARD KONTEKS AKTIF -->
    <?php if ($activeKonteks): ?>
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="row small text-muted">
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Satuan Kerja</strong><br>
                        <?= esc($activeKonteks['nama_satuan_kerja']) ?>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Tahun</strong><br>
                        <?= esc($activeKonteks['tahun']) ?>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Kegiatan</strong><br>
                        <?= esc($activeKonteks['kegiatan']) ?>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Sasaran Strategis</strong><br>
                        <?= esc($activeKonteks['uraian_sasaran']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">

            <label class="fw-semibold mb-0">
                Filter Kategori
            </label>

            <form method="get" class="d-flex gap-2 align-items-center">

                <input type="hidden" name="id_konteks"
                    value="<?= esc($activeKonteks['id_konteks'] ?? '') ?>">

                <select name="filter_kategori"
                    class="form-select form-select-sm"
                    style="width:220px">

                    <option value="">Semua Kategori</option>

                    <?php foreach ($kategoriList as $k): ?>
                        <option value="<?= $k['id_kategori_risiko'] ?>"
                            <?= ($filterKategori == $k['id_kategori_risiko']) ? 'selected' : '' ?>>
                            <?= esc($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <button class="btn btn-sm btn-primary">
                    Terapkan
                </button>

            </form>

        </div>
    </div>

    <!-- CONTENT CARD -->
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">
                <small class="text-muted">
                    Menampilkan <?= count($data) ?> dari <?= $pager->getTotal('identifikasi') ?> data
                </small>

                <?= $pager->links('identifikasi', 'bootstrap_pagination') ?>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="7%">Kode</th>
                            <th width="20%">Proses Bisnis</th>
                            <th width="25%">Pernyataan Risiko</th>
                            <th width="15%">Kategori Risiko</th>
                            <th width="15%">Area Dampak</th>
                            <th width="15%">Sumber Risiko</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="ti ti-alert-circle fs-1 text-muted"></i>
                                        </div>

                                        <?php if (!$activeKonteks): ?>
                                            <h6 class="text-muted mb-2">Belum ada konteks yang dipilih</h6>
                                            <p class="text-muted small mb-0">
                                                Silakan pilih konteks terlebih dahulu untuk melihat atau menambahkan Identifikasi Risiko.
                                            </p>
                                        <?php else: ?>
                                            <h6 class="text-muted mb-2">Belum ada data Identifikasi Risiko</h6>
                                            <p class="text-muted small mb-0">
                                                Klik tombol <strong>+ Risiko</strong> untuk menambahkan data baru.
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($data as $row): ?>
                                <tr>
                                <tr class="cursor-pointer risiko-row"
                                    data-id="<?= $row['id_identifikasi'] ?>">

                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['kode_proses']) ?></td>
                                    <td class="truncate" title="<?= esc($row['uraian_proses']) ?>">
                                        <?= esc($row['uraian_proses']) ?>
                                    </td>
                                    <td class="truncate" title="<?= esc($row['pernyataan_risiko']) ?>">
                                        <?= esc($row['pernyataan_risiko']) ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['nama_kategori'])): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary">
                                                <?= esc($row['nama_kategori']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['area_dampak_list'])): ?>
                                            <?php foreach (explode(', ', $row['area_dampak_list']) as $area): ?>
                                                <span class="badge bg-success-subtle text-success border border-success me-1">
                                                    <?= esc($area) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['sumber_risiko'] === 'Internal'): ?>
                                            <span class="badge bg-info-subtle text-info border border-info">
                                                Internal
                                            </span>
                                        <?php elseif ($row['sumber_risiko'] === 'Eksternal'): ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning">
                                                Eksternal
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
<?= view('identifikasi_risiko/identifikasi_form', [
    'listProses'      => $listProses,
    'activeKonteks'   => $activeKonteks,
    'areaDampakList'  => $areaDampakList,
    'kategoriList'    => $kategoriList
]) ?>
<script src="<?= base_url('assets/js/identifikasi-risiko.alert.js') ?>"></script>
<?= $this->endSection() ?>
<script>
    document.querySelectorAll('.risiko-row').forEach(row => {
        row.addEventListener('click', function() {

            const id = this.dataset.id;

            fetch("<?= site_url('identifikasi-risiko/detail') ?>/" + id)
                .then(r => r.json())
                .then(data => {

                    irFormMode = 'edit';

                    document.querySelector('[name="id_identifikasi"]').value = data.id_identifikasi;
                    document.querySelector('[name="kode_risiko"]').value = data.kode_risiko;
                    document.querySelector('[name="pernyataan_risiko"]').value = data.pernyataan_risiko;
                    document.querySelector('[name="penyebab_risiko"]').value = data.penyebab_risiko;
                    document.querySelector('[name="dampak_risiko"]').value = data.dampak_risiko;
                    document.querySelector('[name="id_kategori_risiko"]').value = data.id_kategori_risiko;

                    document.getElementById('formIdentifikasiRisiko').action =
                        "<?= site_url('identifikasi-risiko/update') ?>/" + data.id_identifikasi;

                    new bootstrap.Offcanvas('#offcanvasRisiko').show();
                });
        });
    });
</script>