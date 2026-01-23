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
         * HELPER
         * =============================== */
        const safe = v => (v && v !== 'null') ? v : '';

        /* ===============================
         * APPLY NUMBERING (BASED ON SELECTION)
         * =============================== */
        function applyNumbering(textarea) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;

            if (start === end) return;

            const value = textarea.value;
            const selected = value.substring(start, end);

            const lines = selected
                .split('\n')
                .map(l => l.trim())
                .filter(l => l !== '');

            if (!lines.length) return;

            const numbered = lines
                .map((l, i) => `${i + 1}. ${l}`)
                .join('\n');

            textarea.value =
                value.substring(0, start) +
                numbered +
                value.substring(end);

            textarea.selectionStart = start;
            textarea.selectionEnd = start + numbered.length;
        }

        /* ===============================
         * MODE VIEW (DEFAULT)
         * =============================== */
        modal.addEventListener('show.bs.modal', e => {
            modal.dataset.mode = 'view';

            const btn = e.relatedTarget;
            const p = Number(btn.dataset.p || 0);
            const d = Number(btn.dataset.d || 0);
            const nilai = p * d;

            // NILAI RISIKO
            const nilaiBox = document.getElementById('modalNilaiRisiko');
            nilaiBox.innerText = nilai || '-';

            nilaiBox.className = 'badge fs-4 px-3 py-2 ' + (
                nilai <= 5 ? 'bg-primary' :
                nilai <= 10 ? 'bg-success' :
                nilai <= 14 ? 'bg-warning' :
                nilai <= 19 ? 'bg-orange' :
                'bg-danger'
            );

            document.getElementById('modalLevelRisiko').innerText =
                nilai <= 5 ? 'Sangat Rendah' :
                nilai <= 10 ? 'Rendah' :
                nilai <= 14 ? 'Sedang' :
                nilai <= 19 ? 'Tinggi' :
                'Sangat Tinggi';

            // ISI DATA
            document.getElementById('modalId').value = btn.dataset.id;
            document.getElementById('modalKode').innerText = btn.dataset.kode;
            document.getElementById('modalPernyataan').innerText = btn.dataset.pernyataan;

            document.getElementById('modalP').value = btn.dataset.p || 1;
            document.getElementById('modalD').value = btn.dataset.d || 1;
            document.getElementById('modalEfektivitas').value =
                btn.dataset.efektivitas || 'Efektif';

            document.getElementById('modalPengendalian').value =
                safe(btn.dataset.pengendalian);

            document.getElementById('modalCatatan').value =
                safe(btn.dataset.catatan);

            // DISABLE FIELD
            fields.forEach(id => {
                const el = document.getElementById(id);
                el.disabled = true;
            });

            // DISABLE BUTTON NUMBERING
            document.querySelectorAll('.btn-numbering')
                .forEach(b => b.disabled = true);

            // BUTTON STATE
            btnEdit.classList.remove('d-none');
            btnSimpan.classList.add('d-none');
        });

        /* ===============================
         * MODE EDIT
         * =============================== */
        btnEdit.addEventListener('click', () => {
            modal.dataset.mode = 'edit';

            fields.forEach(id => {
                const el = document.getElementById(id);
                el.disabled = false;
            });

            // ENABLE BUTTON NUMBERING
            document.querySelectorAll('.btn-numbering').forEach(btn => {
                btn.disabled = false;
                btn.onclick = () => {
                    const target = document.getElementById(btn.dataset.target);
                    applyNumbering(target);
                };
            });

            btnEdit.classList.add('d-none');
            btnSimpan.classList.remove('d-none');
        });

        /* ===============================
         * SUBMIT AJAX
         * =============================== */
        form.addEventListener('submit', e => {
            e.preventDefault();

            if (modal.dataset.mode !== 'edit') return;

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

                    // SYNC DATASET
                    const link = row.querySelector('.open-analisis');
                    link.dataset.pengendalian = r.data.pengendalian;
                    link.dataset.catatan = formData.get('catatan_analisis');
                    link.dataset.p = r.data.kemungkinan;
                    link.dataset.d = r.data.dampak;
                    link.dataset.efektivitas = r.data.efektivitas;

                    // CLOSE MODAL
                    bootstrap.Modal.getInstance(modal).hide();

                    // ALERT
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