<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body d-flex align-items-center gap-3">

        <form method="get" class="d-flex gap-2 align-items-center">

            <input type="hidden" name="id_konteks"
                value="<?= esc($activeKonteks['id_konteks'] ?? '') ?>">

            <label class="fw-semibold mb-0">
                Filter Kategori
            </label>

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