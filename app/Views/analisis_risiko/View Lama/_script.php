<script>
    document.addEventListener('DOMContentLoaded', () => {

        const modal = document.getElementById('modalAnalisisRisiko');
        const form = document.getElementById('formAnalisisRisiko');

        const btnEdit = document.getElementById('btnEdit');
        const btnSimpan = document.getElementById('btnSimpan');

        const fields = [
            'modalP',
            'modalD',
            'modalEfektivitas',
            'modalPengendalian',
            'modalCatatan'
        ];

        const safe = v => (v && v !== 'null') ? v : '';

        /* ===============================
         * VIEW MODE
         * =============================== */
        modal.addEventListener('show.bs.modal', e => {

            const btn = e.relatedTarget;
            const p = Number(btn.dataset.p || 0);
            const d = Number(btn.dataset.d || 0);
            const nilai = p * d;

            document.getElementById('modalId').value = btn.dataset.id;
            document.getElementById('modalKode').innerText = btn.dataset.kode;
            document.getElementById('modalPernyataan').innerText = btn.dataset.pernyataan;

            document.getElementById('modalP').value = btn.dataset.p || 1;
            document.getElementById('modalD').value = btn.dataset.d || 1;
            document.getElementById('modalEfektivitas').value = btn.dataset.efektivitas || 'Efektif';

            document.getElementById('modalPengendalian').value = safe(btn.dataset.pengendalian);
            document.getElementById('modalCatatan').value = safe(btn.dataset.catatan);

            const badge = document.getElementById('modalNilaiRisiko');
            badge.innerText = nilai || '-';
            badge.className =
                'badge fs-4 px-3 py-2 ' +
                (nilai <= 5 ? 'bg-primary' : nilai <= 10 ? 'bg-success' : nilai <= 14 ? 'bg-warning' : nilai <= 19 ? 'bg-orange' : 'bg-danger');

            document.getElementById('modalLevelRisiko').innerText =
                nilai <= 5 ? 'Sangat Rendah' :
                nilai <= 10 ? 'Rendah' :
                nilai <= 14 ? 'Sedang' :
                nilai <= 19 ? 'Tinggi' : 'Sangat Tinggi';

            fields.forEach(id => document.getElementById(id).disabled = true);

            btnEdit.classList.remove('d-none');
            btnSimpan.classList.add('d-none');
        });

        /* ===============================
         * EDIT MODE
         * =============================== */
        btnEdit.addEventListener('click', () => {
            fields.forEach(id => document.getElementById(id).disabled = false);
            btnEdit.classList.add('d-none');
            btnSimpan.classList.remove('d-none');
        });

        /* ===============================
         * SAVE (FIXED & STABLE)
         * =============================== */
        btnSimpan.addEventListener('click', () => {

            // ⚠️ WAJIB: enable dulu supaya ikut terkirim
            fields.forEach(id => document.getElementById(id).disabled = false);

            const formData = new FormData(form);

            fetch("<?= base_url('analisis-risiko/store') ?>", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(r => {

                    if (!r || r.status !== 'ok') {
                        Swal.fire('Gagal', 'Data tidak tersimpan', 'error');
                        return;
                    }

                    const id = formData.get('id_identifikasi');

                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    const link = row.querySelector('.open-analisis');

                    // UPDATE TABEL
                    row.querySelector('.col-p').innerText = r.data.kemungkinan;
                    row.querySelector('.col-d').innerText = r.data.dampak;
                    row.querySelector('.col-pengendalian').innerText = r.data.pengendalian;
                    row.querySelector('.col-efektivitas').innerText = r.data.efektivitas;

                    // 🔥 SINKRON DATASET (INI YANG HILANG SELAMA INI)
                    link.dataset.p = r.data.kemungkinan;
                    link.dataset.d = r.data.dampak;
                    link.dataset.pengendalian = r.data.pengendalian;
                    link.dataset.catatan = formData.get('catatan_analisis');
                    link.dataset.efektivitas = r.data.efektivitas;

                    bootstrap.Modal.getInstance(modal).hide();

                    Swal.fire('Berhasil', 'Analisis risiko berhasil disimpan', 'success');
                })
        });

    });
</script>