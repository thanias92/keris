<?php if ($activeKonteks): ?>
    <!-- ===== FILTER ===== -->
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
            <form method="get" action="<?= site_url('identifikasi-risiko') ?>"
                class="d-flex gap-2 align-items-center">

                <label class="fw-semibold mb-0">Filter Kategori</label>

                <select name="filter_kategori" class="form-select form-select-sm" style="width:220px"
                    onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategoriList as $k): ?>
                        <option value="<?= $k['id_kategori_risiko'] ?>"
                            <?= ($filterKategori == $k['id_kategori_risiko']) ? 'selected' : '' ?>>
                            <?= esc($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if ($filterKategori): ?>
                    <a href="<?= site_url('identifikasi-risiko') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-x"></i> Reset
                    </a>
                <?php endif; ?>

            </form>
        </div>
    </div>
<?php endif; ?>

<!-- ===== TABLE ===== -->
<div id="irTableWrapper">
    <?= view('identifikasi_risiko/_table_section', [
        'data'          => $data,
        'pager'         => $pager,
        'activeKonteks' => $activeKonteks,
    ]) ?>
</div>