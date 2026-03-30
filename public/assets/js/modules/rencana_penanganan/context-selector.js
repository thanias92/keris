// ======================================================
// PENANGANAN RISIKO — CONTEXT SELECTOR MODULE
// ======================================================

const RtpContextSelector = {
  elements: {},
  map: {},

  init() {
    const form = document.getElementById("rtpContextSelectorForm");
    if (!form) return;

    this.map = window.RTP_CS_DATA?.konteksMap ?? {};

    this.elements = {
      form,
      sk: document.getElementById("rtpCsSatuanKerja"),
      pg: document.getElementById("rtpCsPengelola"),
      kg: document.getElementById("rtpCsKegiatan"),
      th: document.getElementById("rtpCsTahun"),
      idEl: document.getElementById("rtpCsIdKonteks"),
      btnApply: document.getElementById("rtpCsBtnApply"),
      btnReset: document.getElementById("rtpCsBtnReset"),
    };

    this.bindEvents();
    this.resolveId();
  },

  bindEvents() {
    const { sk, pg, kg, th, form, btnReset } = this.elements;

    [sk, pg, kg, th].forEach((el) => {
      if (el) el.addEventListener("change", () => this.resolveId());
    });

    form.addEventListener("submit", (e) => this.onSubmit(e));

    btnReset?.addEventListener("click", () => {
      document.getElementById("rtpResetForm")?.submit();
    });
  },

  resolveId() {
    const { sk, pg, kg, th, idEl, btnApply, btnReset } = this.elements;

    const vSk = sk?.value ?? "";
    const vPg = pg?.value ?? "";
    const vKg = kg?.value ?? "";
    const vTh = th?.value ?? "";

    idEl.value = "";
    btnApply.disabled = true;
    btnApply.title = "Pilih filter terlebih dahulu";

    const hasAnyFilter = vSk || vPg || vKg || vTh;
    const hasActive = window.RTP_CS_DATA?.hasActive ?? false;

    if (btnReset) {
      btnReset.style.display = hasActive || hasAnyFilter ? "" : "none";
    }

    if (!hasAnyFilter) return;

    for (const [id, k] of Object.entries(this.map)) {
      const matchSk = !vSk || String(k.id_satuan_kerja) === vSk;
      const matchPg = !vPg || String(k.pengelola_risiko_id) === vPg;
      const matchKg = !vKg || String(k.id_kegiatan) === vKg;
      const matchTh = !vTh || String(k.tahun) === vTh;

      if (matchSk && matchPg && matchKg && matchTh) {
        idEl.value = id;
        btnApply.disabled = false;
        btnApply.title = "Terapkan konteks ini";
        return;
      }
    }

    btnApply.title = "Tidak ada konteks yang cocok";
  },

  onSubmit(e) {
    const { idEl } = this.elements;

    if (!idEl.value) {
      e.preventDefault();
      PkAlert.toast({
        text: "Tidak ada konteks yang cocok.",
        icon: "error",
      });
    }
  },
};

document.addEventListener("DOMContentLoaded", () => RtpContextSelector.init());
