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

        /* ===============================
         * MODE VIEW (DEFAULT)
         * =============================== */
        modal.addEventListener('show.bs.modal', function(e) {
            const nilai = (btn.dataset.p || 0) * (btn.dataset.d || 0);
            document.getElementById('modalNilaiRisiko').innerText = nilai || '-';

            const badge = document.getElementById('modalBadgeRisiko');
            badge.innerText = nilai || '-';

            badge.className = 'badge fs-6 px-3 py-2 ' + (
                nilai <= 5 ? 'bg-primary' :
                nilai <= 10 ? 'bg-success' :
                nilai <= 14 ? 'bg-warning' :
                nilai <= 19 ? 'bg-orange' :
                'bg-danger'
            );

            const btn = e.relatedTarget;

            modal.dataset.mode = 'view';

            // isi data
            document.getElementById('modalId').value = btn.dataset.id;
            document.getElementById('modalKode').innerText = btn.dataset.kode;
            document.getElementById('modalPernyataan').innerText = btn.dataset.pernyataan;

            document.getElementById('modalP').value = btn.dataset.p || 1;
            document.getElementById('modalD').value = btn.dataset.d || 1;
            document.getElementById('modalEfektivitas').value = btn.dataset.efektivitas || 'Efektif';
            document.getElementById('modalPengendalian').value = btn.dataset.pengendalian || '';
            document.getElementById('modalCatatan').value = btn.dataset.catatan || '';

            // disable semua field
            fields.forEach(id => document.getElementById(id).disabled = true);

            // tombol
            btnEdit.classList.remove('d-none');
            btnSimpan.classList.add('d-none');
        });

        /* ===============================
         * MODE EDIT
         * =============================== */
        btnEdit.addEventListener('click', () => {
            modal.dataset.mode = 'edit';

            fields.forEach(id => document.getElementById(id).disabled = false);

            btnEdit.classList.add('d-none');
            btnSimpan.classList.remove('d-none');
        });

        /* ===============================
         * SUBMIT AJAX (EDIT ONLY)
         * =============================== */
        form.addEventListener('submit', e => {
            e.preventDefault();

            if (modal.dataset.mode !== 'edit') return;

            const formData = new FormData(form);

            fetch("<?= base_url('analisis-risiko/store') ?>", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(r => {
                    if (r.status !== 'ok') return;

                    const row = document.querySelector(
                        `tr[data-id="${formData.get('id_identifikasi')}"]`
                    );

                    row.querySelector('.col-p').innerText = r.data.kemungkinan;
                    row.querySelector('.col-d').innerText = r.data.dampak;
                    row.querySelector('.col-pengendalian').innerText = r.data.pengendalian;
                    row.querySelector('.col-efektivitas').innerText = r.data.efektivitas;

                    const badge = row.querySelector('.col-nilai span');
                    badge.innerText = r.data.nilai;

                    // 🔥 sync dataset
                    const link = row.querySelector('.open-analisis');
                    link.dataset.pengendalian = r.data.pengendalian;
                    link.dataset.catatan = formData.get('catatan_analisis');
                    link.dataset.p = r.data.kemungkinan;
                    link.dataset.d = r.data.dampak;
                    link.dataset.efektivitas = r.data.efektivitas;

                    // 1️⃣ tutup modal dulu
                    bootstrap.Modal.getInstance(modal).hide();

                    // 2️⃣ baru tampilkan SweetAlert
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Analisis risiko berhasil diperbarui'
                        });
                    }, 300);
                });
        });
    });
</script>