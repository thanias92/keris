/**
 * pelaporan.js
 * Pelaporan Risiko — Offcanvas detail, Approve, Reject
 */

/* ======================================================
   HELPER
====================================================== */
function setText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value ?? "-";
}

/* ======================================================
   STATE
====================================================== */
let currentId = null;

/* ======================================================
   KLIK ROW → BUKA OFFCANVAS
====================================================== */
document.addEventListener("click", function (e) {
  const row = e.target.closest(".pl-row");
  if (!row) return;

  const id = row.dataset.id;
  if (!id) return;

  openPelaporanDetail(id);
});

/* ======================================================
   OPEN DETAIL
====================================================== */
function openPelaporanDetail(id) {
  currentId = id;

  fetch(`/pelaporan-risiko/detail/${id}`)
    .then((res) => {
      if (!res.ok) throw new Error("Server error: " + res.status);
      return res.json();
    })
    .then((data) => {
      // ===== KONTEKS =====
      setText("plInfoTahun", data.tahun);
      setText("plInfoSatker", data.nama_satuan_kerja);
      setText("plInfoPengelola", data.nama_pengelola);
      setText("plInfoSasaran", data.sasaran_strategis);

      // ===== RISIKO =====
      setText(
        "plInfoProses",
        (data.kode_proses ? data.kode_proses + " — " : "") +
          (data.uraian_proses ?? ""),
      );
      setText("plInfoSasaranKinerja", data.sasaran_kinerja);
      setText("plInfoRisiko", data.pernyataan_risiko);
      setText("plInfoPenyebab", data.penyebab_risiko);
      setText("plInfoDampak", data.dampak_risiko);

      // ===== RISIKO AKTUAL =====
      setText("plInfoProb", data.level_kemungkinan);
      setText("plInfoImpact", data.level_dampak);

      const nilaiEl = document.getElementById("plPreviewNilai");
      const badgeEl = document.getElementById("plPreviewBadge");

      if (nilaiEl) {
        nilaiEl.textContent = data.nilai_risiko || "0";
        nilaiEl.style.color = data.warna_risiko || "";
      }
      if (badgeEl) {
        badgeEl.textContent = data.nama_selera || "";
        badgeEl.style.backgroundColor = data.warna_risiko || "";
      }

      // ===== PENGENDALIAN =====
      setText("plInfoPengendalian", data.uraian_pengendalian);
      setText("plInfoEfektivitas", data.efektivitas);

      // ===== RTP =====
      setText("plInfoRtp", data.uraian_rtp);
      setText("plTargetOutput", data.target_output);
      setText("plTargetWaktu", data.target_waktu);

      // ===== REALISASI =====
      setText("plRealisasiOutput", data.realisasi_output);
      setText("plRealisasiWaktu", data.realisasi_waktu);
      setText("plStatus", data.status);

      // Reset textarea catatan
      const catatan = document.getElementById("plCatatan");
      if (catatan) catatan.value = "";

      // Tampilkan offcanvas
      const offcanvasEl = document.getElementById("plOffcanvas");
      if (offcanvasEl) {
        bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl).show();
      }
    })
    .catch((err) => {
      console.error("Gagal load detail:", err);
      Swal.fire({
        icon: "error",
        title: "Gagal",
        text: "Tidak dapat memuat detail RTP.",
      });
    });
}

/* ======================================================
   APPROVE
====================================================== */
function plApprove() {
  if (!currentId) return;

  Swal.fire({
    title: "Approve RTP ini?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Ya, Approve",
    cancelButtonText: "Batal",
    reverseButtons: true,
  }).then((result) => {
    if (!result.isConfirmed) return;

    fetch(`/pelaporan-risiko/approve/${currentId}`, {
      method: "POST",
    })
      .then((res) => {
        if (!res.ok) throw new Error("Server error: " + res.status);
        return res.json();
      })
      .then(() => {
        bootstrap.Offcanvas.getInstance(
          document.getElementById("plOffcanvas"),
        )?.hide();

        Swal.fire({
          icon: "success",
          title: "Berhasil di-approve",
          timer: 1200,
          showConfirmButton: false,
        }).then(() => location.reload());
      })
      .catch(() => {
        Swal.fire({ icon: "error", title: "Gagal approve" });
      });
  });
}

/* ======================================================
   REJECT
====================================================== */
function plReject() {
  if (!currentId) return;

  const alasan = document.getElementById("plCatatan")?.value?.trim();

  if (!alasan) {
    Swal.fire({
      icon: "warning",
      title: "Catatan wajib diisi",
      text: "Masukkan alasan penolakan terlebih dahulu.",
    });
    return;
  }

  Swal.fire({
    title: "Reject RTP ini?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, Reject",
    cancelButtonText: "Batal",
    confirmButtonColor: "#dc3545",
    reverseButtons: true,
  }).then((result) => {
    if (!result.isConfirmed) return;

    fetch(`/pelaporan-risiko/reject/${currentId}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ alasan }),
    })
      .then((res) => {
        if (!res.ok) throw new Error("Server error: " + res.status);
        return res.json();
      })
      .then(() => {
        bootstrap.Offcanvas.getInstance(
          document.getElementById("plOffcanvas"),
        )?.hide();

        Swal.fire({
          icon: "success",
          title: "Berhasil di-reject",
          timer: 1200,
          showConfirmButton: false,
        }).then(() => location.reload());
      })
      .catch(() => {
        Swal.fire({ icon: "error", title: "Gagal reject" });
      });
  });
}
