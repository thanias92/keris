const IrContextSelector = {
  elements: {},
  map: {},

  init() {
    const form = document.getElementById("irContextSelectorForm");
    if (!form) return;

    this.map = window.IR_CS_DATA?.konteksMap ?? {};

    this.elements = {
      form,
      sk: document.getElementById("irCsTimKerja"),
      pg: document.getElementById("irCsPengelola"),
      kg: document.getElementById("irCsKegiatan"),
      th: document.getElementById("irCsTahun"),
      idEl: document.getElementById("irCsIdKonteks"),
      btnApply: document.getElementById("irCsBtnApply"),
      btnReset: document.getElementById("irCsBtnReset"),
    };

    this.bindEvents();
    this.filterDropdownOptions();
    this.resolveId();
  },

  bindEvents() {
    const { sk, pg, kg, th, form, btnReset } = this.elements;

    if (sk) {
      sk.addEventListener("change", () => {
        if (pg) pg.value = "";
        if (kg) kg.value = "";
        if (th) th.value = "";

        this.filterDropdownOptions();
        this.resolveId();
      });
    }

    [pg, kg, th].forEach((el) => {
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

    const hasAnyFilter = vSk || vPg || vKg || vTh; // ✅ WAJIB ADA

    idEl.value = "";
    btnApply.disabled = true;
    btnApply.title = "Pilih filter terlebih dahulu";

    if (btnReset) {
      btnReset.style.display = "";
    }

    if (!hasAnyFilter) return;

    for (const [id, k] of Object.entries(this.map)) {
      const matchSk = !vSk || String(k.id_tim) === vSk;
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

  filterDropdownOptions() {
    const { sk, pg, kg, th } = this.elements;
    const map = this.map;

    const selectedTim = sk?.value;

    const reset = (el) => {
      if (!el) return;
      const placeholder = "– Pilih –";
      el.innerHTML = `<option value="">${placeholder}</option>`;
    };

    // reset semua dropdown selain tim
    reset(pg);
    reset(kg);
    reset(th);

    if (!selectedTim) return;

    const pgSet = new Map();
    const kgSet = new Map();
    const thSet = new Set();

    Object.values(map).forEach((k) => {
      if (String(k.id_tim) !== String(selectedTim)) return;

      if (k.pengelola_risiko_id) {
        pgSet.set(k.pengelola_risiko_id, k.nama_pengelola);
      }

      if (k.id_kegiatan) {
        kgSet.set(k.id_kegiatan, k.nama_kegiatan);
      }

      if (k.tahun) {
        thSet.add(k.tahun);
      }
    });

    const append = (el, mapData) => {
      mapData.forEach((val, key) => {
        const opt = document.createElement("option");
        opt.value = key;
        opt.textContent = val;
        el.appendChild(opt);
      });
    };

    append(pg, pgSet);
    append(kg, kgSet);

    thSet.forEach((tahun) => {
      const opt = document.createElement("option");
      opt.value = tahun;
      opt.textContent = tahun;
      th.appendChild(opt);
    });

    // restore selected value dari URL
    const params = new URLSearchParams(window.location.search);

    if (pg && params.get("pg")) pg.value = params.get("pg");
    if (kg && params.get("kg")) kg.value = params.get("kg");
    if (th && params.get("th")) th.value = params.get("th");
  },

  onSubmit(e) {
    e.preventDefault();

    const { sk, pg, kg, th } = this.elements;

    const params = new URLSearchParams();

    if (sk?.value) params.append("sk", sk.value);
    if (pg?.value) params.append("pg", pg.value);
    if (kg?.value) params.append("kg", kg.value);
    if (th?.value) params.append("th", th.value);

    window.location.href = baseUrl + "identifikasi-risiko?" + params.toString();
  },
};

document.addEventListener("DOMContentLoaded", () => IrContextSelector.init());
