/* URL & CSRF */
let RTP_CAN_EDIT = false;
const USER = window.APP_USER || {};
const RTP_URL = window.RTP_CONFIG?.url || {};
let rtpCsrfToken = window.RTP_CONFIG?.csrf?.token || "";
const rtpCsrfName = window.RTP_CONFIG?.csrf?.name || "csrf_token";

/* MODE MANAGEMENT */
function rtpSetMode(mode) {
  const isView = mode === "view";
  const isEdit = mode === "edit";
  const isCreate = mode === "create";

  document.getElementById("rtpMode").value = mode;

  const createBox = document.getElementById("rtpCreateContainer");
  const timelineBox = document.getElementById("rtpTimelineContainer");

  if (isCreate) {
    createBox.classList.remove("d-none");
    timelineBox.classList.add("d-none");
  }

  if (isView) {
    createBox.classList.add("d-none");
    timelineBox.classList.remove("d-none");
  }

  if (isEdit) {
    createBox.classList.remove("d-none");
    timelineBox.classList.add("d-none");
  }

  document
    .querySelectorAll("#rtpCreateContainer textarea, #rtpCreateContainer input")
    .forEach((el) => (el.disabled = isView));

  document.getElementById("rtpBtnEdit").classList.toggle("d-none", !isView);
  document.getElementById("rtpBtnHapus").classList.toggle("d-none", !isView);
  document.getElementById("rtpBtnBatal").classList.toggle("d-none", !isEdit && !isCreate);
  document.getElementById("rtpBtnSimpan").classList.toggle("d-none", isView);
  document.getElementById("rtpBtnTutup").classList.toggle("d-none", isEdit || isCreate);
  
  const addWrapper = document.getElementById("rtpAddWrapper");
  if (addWrapper) addWrapper.classList.toggle("d-none", isView);

  document.getElementById("rtpOffcanvasTitle").textContent = isCreate
    ? "Tambah RTP"
    : isEdit
      ? "Edit RTP"
      : "Detail RTP";
}

/* RESET FORM */
function rtpResetForm() {
  document.getElementById("rtpForm").reset();
  document.getElementById("rtpForm").classList.remove("was-validated");

  document.getElementById("rtpId").value = "";
  document.getElementById("rtpIdEvaluasi").value = "";

  document.getElementById("rtpCreateContainer")?.replaceChildren();
  document.getElementById("rtpTimelineContainer")?.replaceChildren();

  [
    "rtpInfoTahun",
    "rtpInfoTimKerja",
    "rtpInfoPengelola",
    "rtpInfoSasaran",
    "rtpInfoProses",
    "rtpInfoPernyataan",
    "rtpInfoPenyebab",
    "rtpInfoDampakRisiko",
    "rtpInfoProb",
    "rtpInfoImpact",
    "rtpInfoPenanggungjawab",
  ].forEach((id) => {
    const el = document.getElementById(id);
    if (el) el.textContent = "-";
  });

  // Reset preview skor aktual
  const nilaiEl = document.getElementById("rtpPreviewNilai");
  const badgeEl = document.getElementById("rtpPreviewBadge");
  if (nilaiEl) {
    nilaiEl.textContent = "0";
    nilaiEl.style.color = "";
  }
  if (badgeEl) {
    badgeEl.textContent = "";
    badgeEl.style.backgroundColor = "";
  }

  // Reset preview skor residu
  rtpResetResidu();
}

/* RTP CARD MANAGER */

document.getElementById("rtpAddBtn")?.addEventListener("click", function () {
  rtpAddCard();
});

function rtpAddCard(data = {}) {
  const tpl = document.getElementById("rtpCardTemplate");
  const container = document.getElementById("rtpCreateContainer");

  const node = tpl.content.cloneNode(true);

  const textarea = node.querySelector("textarea[name='uraian_rtp[]']");
  const output = node.querySelector('input[name="target_output[]"]');
  const waktu = node.querySelector('input[name="target_waktu[]"]');

  textarea.value = data.uraian_rtp || "";
  output.value = data.target_output || "";
  waktu.value = data.target_waktu ? data.target_waktu.substring(0, 7) : "";

  node.querySelector(".rtp-card-remove").addEventListener("click", function () {
    this.closest(".rtp-card").remove();
  });

  container.appendChild(node);
}

/* RESET RESIDU PREVIEW */
function rtpResetResidu() {
  const nilaiEl = document.getElementById("rtpResiduNilai");
  const badgeEl = document.getElementById("rtpResiduBadge");
  if (nilaiEl) {
    nilaiEl.textContent = "0";
    nilaiEl.style.color = "";
  }
  if (badgeEl) {
    badgeEl.textContent = "";
    badgeEl.style.backgroundColor = "";
  }
}

/* POPULATE INFO KONTEKS & RISIKO */
function rtpPopulateInfo(d) {
  const set = (id, val) => {
    const el = document.getElementById(id);
    if (el) el.textContent = val || "-";
  };

  set("rtpInfoTahun", d.tahun);
  set("rtpInfoTimKerja", d.nama_tim);
  set("rtpInfoPengelola", d.nama_pengelola);
  set("rtpInfoSasaran", d.sasaran_strategis);
  set("rtpInfoProses",(d.kode_proses ? d.kode_proses + " — " : "") + (d.uraian_proses ?? ""),);
  set("rtpInfoPernyataan", d.pernyataan_risiko);
  set("rtpInfoPenyebab", d.penyebab_risiko);
  set("rtpInfoDampakRisiko", d.dampak_risiko);
  set("rtpInfoProb", d.level_kemungkinan);
  set("rtpInfoImpact", d.level_dampak);

  // Penanggung jawab — derive dari satuan kerja
  set("rtpInfoPenanggungjawab",d.nama_tim ? "Ketua " + d.nama_tim : "-",);

  // Preview skor risiko aktual
  const nilaiEl = document.getElementById("rtpPreviewNilai");
  const badgeEl = document.getElementById("rtpPreviewBadge");
  if (nilaiEl) {
    nilaiEl.textContent = d.nilai_risiko || "0";
    nilaiEl.style.color = d.warna_risiko || d.warna_selera || "";
  }
  if (badgeEl) {
    badgeEl.textContent = d.nama_selera || "";
    badgeEl.style.backgroundColor = d.warna_risiko || d.warna_selera || "";
  }
}

/* HITUNG SKOR RESIDU (live preview) */
function rtpHitungResidu() {
  const selK = document.getElementById("rtpKemungkinanResidu");
  const selD = document.getElementById("rtpDampakResidu");

  const idK = selK?.value;
  const idD = selD?.value;

  if (!idK || !idD) {
    rtpResetResidu();
    return;
  }

  fetch(RTP_URL.preview, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_kemungkinan=${idK}&id_dampak=${idD}`,
  })
    .then((r) => r.json())
    .then((res) => {
      if (res.status !== "success") {
        rtpResetResidu();
        return;
      }
      const nilaiEl = document.getElementById("rtpResiduNilai");
      const badgeEl = document.getElementById("rtpResiduBadge");
      if (nilaiEl) {
        nilaiEl.textContent = res.nilai_risiko;
        nilaiEl.style.color = res.warna;
      }
      if (badgeEl) {
        badgeEl.textContent = res.nama_selera;
        badgeEl.style.backgroundColor = res.warna;
        badgeEl.style.color = "#fff";
      }
    });
}
document.getElementById("rtpKemungkinanResidu")?.addEventListener("change", rtpHitungResidu);
document.getElementById("rtpDampakResidu")?.addEventListener("change", rtpHitungResidu);

/* LOAD DETAIL RTP (view/edit mode) */
function rtpLoadDetail(idRtp) {
  return fetch(RTP_URL.detail(idRtp))
    .then((r) => r.json())
    .then((d) => {
      document.getElementById("rtpId").value = d.id_rtp;
      document.getElementById("rtpIdEvaluasi").value = d.id_evaluasi;

      // Set dropdown residu
      const selK = document.getElementById("rtpKemungkinanResidu");
      const selD = document.getElementById("rtpDampakResidu");
      if (selK) selK.value = d.id_kemungkinan_residu ?? "";
      if (selD) selD.value = d.id_dampak_residu ?? "";

      rtpPopulateInfo(d);
      rtpHitungResidu();

      // Populate timeline (view mode)
      if (d.rtp_list && d.rtp_list.length > 0) {
        rtpRenderTimeline(d.rtp_list);
      }

      // Populate cards (edit mode) — siapkan dulu, rtpSetMode yang atur visibilitas
      const container = document.getElementById("rtpCreateContainer");
      container.innerHTML = "";
      if (d.rtp_list && d.rtp_list.length > 0) {
        d.rtp_list.forEach((rtp) => rtpAddCard(rtp));
      } else {
        rtpAddCard();
      }

      return d;
    });
}

/* BATAL */
function rtpBatal() {
  const id = document.getElementById("rtpId").value;
  if (id) {
    rtpLoadDetail(id).then(() => rtpSetMode("view"));
  } else {
    bootstrap.Offcanvas.getInstance(
      document.getElementById("rtpOffcanvas"),
    ).hide();
  }
}

/* OPEN ROW — klik baris tabel (RTP sudah ada) */
document.addEventListener("click", function (e) {
  // Klik baris RTP yang sudah ada
  const rtpRow = e.target.closest("tr[data-rtp]");
  if (rtpRow) {
    const idRtp = rtpRow.dataset.rtp;

    // Baris kosong (belum ada RTP) → arahkan ke mode tambah
    if (!idRtp || idRtp === "") {
      const idEvaluasi = rtpRow.dataset.idEvaluasi;
      if (!idEvaluasi) return;
      rtpResetForm();
      bootstrap.Offcanvas.getOrCreateInstance(
        document.getElementById("rtpOffcanvas"),
      ).show();
      document.getElementById("rtpIdEvaluasi").value = idEvaluasi;
      fetch(RTP_URL.detailEvaluasi(idEvaluasi))
        .then((r) => r.json())
        .then((d) => {
          rtpPopulateInfo(d);
          rtpSetMode("create");
          rtpAddCard();
        });
      return;
    }

    // Baris dengan RTP
    rtpResetForm();
    bootstrap.Offcanvas.getOrCreateInstance(
      document.getElementById("rtpOffcanvas"),
    ).show();
    rtpLoadDetail(idRtp).then(() => rtpSetMode("view"));
    return;
  }
});

function rtpRenderTimeline(list = []) {
  const container = document.getElementById("rtpTimelineContainer");
  if (!container) return;
  container.innerHTML = "";

  const wrapper = document.createElement("div");
  wrapper.className = "rtp-timeline";

  list.forEach((r, i) => {
    const item = document.createElement("div");
    item.className = "rtp-timeline-item";

    item.innerHTML = `
      <div class="rtp-timeline-row">
        <div class="rtp-timeline-content">
          <div><span class="rtp-timeline-label">Output :</span> ${r.target_output ?? "-"}</div>
          <div><span class="rtp-timeline-label">Target :</span> ${r.target_waktu ?? "-"}</div>
        </div>
      </div>
    `;

    wrapper.appendChild(item);
  });

  container.appendChild(wrapper);
}

function rtpHapus() {
  const id = document.getElementById("rtpId").value;
  if (!id) return;

  Swal.fire({
    title: "Hapus RTP ini?",
    text: "Data akan dihapus permanen.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, Hapus",
    cancelButtonText: "Batal",
    confirmButtonColor: "#dc3545",
    reverseButtons: true,
  }).then((result) => {
    if (!result.isConfirmed) return;

    $.ajax({
      url: RTP_URL.delete(id),
      method: "POST",
      data: { [rtpCsrfName]: rtpCsrfToken },
      processData: true,
      contentType: "application/x-www-form-urlencoded",
      headers: { "X-Requested-With": "XMLHttpRequest" },
      success(res) {
        if (res.csrf_token) rtpCsrfToken = res.csrf_token;
        bootstrap.Offcanvas.getInstance(
          document.getElementById("rtpOffcanvas"),
        ).hide();
        Swal.fire({
          icon: "success",
          title: "Berhasil dihapus",
          timer: 1200,
          showConfirmButton: false,
        }).then(() => location.reload());
      },
      error() {
        Swal.fire({ icon: "error", title: "Gagal menghapus" });
      },
    });
  });
}

/* SUBMIT (STORE / UPDATE) */
document.getElementById("rtpForm")?.addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const mode = document.getElementById("rtpMode").value;
  const id = document.getElementById("rtpId").value;

  if (!form.checkValidity()) {
    form.classList.add("was-validated");
    return;
  }

  Swal.fire({
    title: mode === "edit" ? "Simpan Perubahan?" : "Simpan RTP?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Simpan",
    cancelButtonText: "Batal",
    reverseButtons: true,
  }).then((result) => {
    if (!result.isConfirmed) return;

    const freshData = new FormData(form);
    freshData.append(rtpCsrfName, rtpCsrfToken);

    $.ajax({
      url: mode === "edit" ? RTP_URL.update(id) : RTP_URL.store,
      method: "POST",
      data: freshData,
      processData: false,
      contentType: false,
      headers: { "X-Requested-With": "XMLHttpRequest" },

      success(res) {
        if (res.csrf_token) rtpCsrfToken = res.csrf_token;
        bootstrap.Offcanvas.getInstance(
          document.getElementById("rtpOffcanvas"),
        ).hide();
        Swal.fire({
          icon: "success",
          title: "Berhasil disimpan",
          timer: 1200,
          showConfirmButton: false,
        }).then(() => location.reload());
      },

      error(xhr) {
        const msg = xhr.responseJSON?.message ?? "Terjadi kesalahan.";
        Swal.fire({ icon: "error", title: "Gagal", text: msg });
      },
    });
  });
});


