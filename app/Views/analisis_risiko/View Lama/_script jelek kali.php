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
            modal.dataset.mode = 'view';

            const btn = e.relatedTarget;
            const p = Number(btn.dataset.p || 0);
            const d = Number(btn.dataset.d || 0);
            const nilai = p * d;

            //Nilai Risiko
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

        function enableNumberedList(textareaId) {
            const el = document.getElementById(textareaId);

            if (el.dataset.numbering === 'on') return;
            el.dataset.numbering = 'on';

            el.addEventListener('keydown', function(e) {
                if (e.key !== 'Enter') return;

                const start = el.selectionStart;
                const text = el.value.substring(0, start);
                const lines = text.split('\n');
                const lastLine = lines[lines.length - 1];

                const match = lastLine.match(/^(\d+)\.\s+/);
                if (!match) return; // bukan list → enter normal

                e.preventDefault();

                const next = parseInt(match[1]) + 1;
                el.value =
                    el.value.substring(0, start) +
                    '\n' + next + '. ' +
                    el.value.substring(start);

                el.selectionStart = el.selectionEnd =
                    start + (`\n${next}. `.length);
            });
        }

        /* ===============================
         * MODE EDIT
         * =============================== */
        btnEdit.addEventListener('click', () => {
            modal.dataset.mode = 'edit';

            fields.forEach(id => document.getElementById(id).disabled = false);
            enableNumberedList('modalPengendalian');
            enableNumberedList('modalCatatan');

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