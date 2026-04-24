function setText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value ?? "-";
}

let currentId = null;

/* =========================
   INIT
========================= */
document.addEventListener("DOMContentLoaded", function () {
  const role = window.USER_ROLE || "operator";

  // hanya tampilkan footer untuk ketua
  const footer = document.getElementById("plFooterKetua");
  if (footer) {
    footer.style.display = role === "ketua" ? "block" : "none";
  }
});

/* =========================
   CLICK ROW
========================= */
document.addEventListener("click", function (e) {
  const row = e.target.closest(".pl-row");
  if (!row) return;

  const id = row.dataset.id;
  if (!id) return;

  openPelaporanDetail(id);
});

/* =========================
   OPEN DETAIL
========================= */
function openPelaporanDetail(id) {
  currentId = id;

  fetch(`/pelaporan-risiko/detail/${id}`)
    .then((res) => res.json())
    .then((data) => {
      setText("plInfoTahun", data.tahun);
      setText("plInfoTimKerja", data.nama_tim);
      setText("plInfoPengelola", data.nama_pengelola);
      setText("plInfoSasaran", data.sasaran_strategis);

      setText(
        "plInfoProses",
        (data.kode_proses ? data.kode_proses + " — " : "") +
          (data.uraian_proses ?? ""),
      );

      setText("plInfoSasaranKinerja", data.sasaran_kinerja);
      setText("plInfoRisiko", data.pernyataan_risiko);
      setText("plInfoPenyebab", data.penyebab_risiko);
      setText("plInfoDampak", data.dampak_risiko);

      setText("plInfoProb", data.level_kemungkinan);
      setText("plInfoImpact", data.level_dampak);

      document.getElementById("plPreviewNilai").textContent =
        data.nilai_risiko || 0;
      document.getElementById("plPreviewBadge").textContent =
        data.nama_selera || "";

      setText("plInfoPengendalian", data.uraian_pengendalian);
      setText("plInfoEfektivitas", data.efektivitas);

      setText("plInfoRtp", data.uraian_rtp);
      setText("plTargetOutput", data.target_output);
      setText("plTargetWaktu", data.target_waktu);

      setText("plRealisasiOutput", data.realisasi_output);
      setText("plRealisasiWaktu", data.realisasi_waktu);
      setText("plStatus", data.status);

      document.getElementById("plCatatan").value = "";

      bootstrap.Offcanvas.getOrCreateInstance(
        document.getElementById("plOffcanvas"),
      ).show();
    })
    .catch(() => {
      Swal.fire("Error", "Gagal load detail", "error");
    });
}

/* =========================
   APPROVE
========================= */
function plApprove() {
  if (!currentId) return;

  Swal.fire({
    title: "Approve data ini?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Ya",
  }).then((res) => {
    if (!res.isConfirmed) return;

    fetch(`/pelaporan-risiko/approve/${currentId}`, {
      method: "POST",
    })
      .then(() => {
        Swal.fire("Berhasil", "Data di-approve", "success").then(() =>
          location.reload(),
        );
      })
      .catch(() => Swal.fire("Error", "Gagal approve", "error"));
  });
}

/* =========================
   REJECT
========================= */
function plReject() {
  if (!currentId) return;

  const alasan = document.getElementById("plCatatan").value.trim();

  if (!alasan) {
    Swal.fire("Warning", "Catatan wajib diisi", "warning");
    return;
  }

  fetch(`/pelaporan-risiko/reject/${currentId}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ alasan }),
  })
    .then(() => {
      Swal.fire("Berhasil", "Data ditolak", "success").then(() =>
        location.reload(),
      );
    })
    .catch(() => Swal.fire("Error", "Gagal reject", "error"));
}
