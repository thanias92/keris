// ======================================================
// IDENTIFIKASI RISIKO — CONTEXT SELECTOR MODULE
// ======================================================

const IrContextSelector = {
  elements: {},
  map: {},

  init() {
    const form = document.getElementById("irContextSelectorForm");
    if (!form) return;

    this.map = window.IR_CS_DATA?.konteksMap ?? {};

    this.elements = {
      form,
      sk: document.getElementById("irCsSatuanKerja"),
      pg: document.getElementById("irCsPengelola"),
      kg: document.getElementById("irCsKegiatan"),
      th: document.getElementById("irCsTahun"),
      idEl: document.getElementById("irCsIdKonteks"),
      btnApply: document.getElementById("irCsBtnApply"),
      btnReset: document.getElementById("irCsBtnReset"),
    };

    this.bindEvents();
    this.resolveId(); // set state awal tombol apply
  },

  bindEvents() {
    const { sk, pg, kg, th, form, btnReset } = this.elements;

    [sk, pg, kg, th].forEach((el) => {
      if (el) el.addEventListener("change", () => this.resolveId());
    });

    form.addEventListener("submit", (e) => this.onSubmit(e));

    btnReset?.addEventListener("click", () => {
      document.getElementById("irResetForm")?.submit();
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

    // Tampilkan tombol reset kalau ada filter dipilih ATAU ada konteks aktif
    const hasAnyFilter = vSk || vPg || vKg || vTh;
    const hasActive = window.IR_CS_DATA?.hasActive ?? false;
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
      PkAlert.toast({ text: "Tidak ada konteks yang cocok.", icon: "error" });
    }
  },
};

document.addEventListener("DOMContentLoaded", () => IrContextSelector.init());
