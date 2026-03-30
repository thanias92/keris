// ======================================================
// EVALUASI RISIKO — CONTEXT SELECTOR MODULE
// ======================================================

const ErContextSelector = {
  elements: {},
  map: {},

  init() {
    const form = document.getElementById("erContextSelectorForm");
    if (!form) return;

    this.map = window.ER_CS_DATA?.konteksMap ?? {};

    this.elements = {
      form,
      sk: document.getElementById("erCsSatuanKerja"),
      pg: document.getElementById("erCsPengelola"),
      kg: document.getElementById("erCsKegiatan"),
      th: document.getElementById("erCsTahun"),
      idEl: document.getElementById("erCsIdKonteks"),
      btnApply: document.getElementById("erCsBtnApply"),
      btnReset: document.getElementById("erCsBtnReset"),
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
      document.getElementById("erResetForm")?.submit();
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
    const hasActive = window.ER_CS_DATA?.hasActive ?? false;

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

document.addEventListener("DOMContentLoaded", () => ErContextSelector.init());
