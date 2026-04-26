const ArContextSelector = {
  elements: {},
  map: {},

  init() {
    const form = document.getElementById("arContextSelectorForm");
    if (!form) return;

    this.map = window.AR_CS_DATA?.konteksMap ?? {};

    this.elements = {
      form,
      sk: document.getElementById("arCsTimKerja"),
      pg: document.getElementById("arCsPengelola"),
      kg: document.getElementById("arCsKegiatan"),
      th: document.getElementById("arCsTahun"),
      btnApply: document.getElementById("arCsBtnApply"),
      btnReset: document.getElementById("arCsBtnReset"),
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
      window.location.href = baseUrl + "analisis-risiko";
    });
  },

  resolveId() {
    const { sk, pg, kg, th, btnApply } = this.elements;

    const vSk = sk?.value ?? "";
    const vPg = pg?.value ?? "";
    const vKg = kg?.value ?? "";
    const vTh = th?.value ?? "";

    const hasAnyFilter = vSk || vPg || vKg || vTh;

    btnApply.disabled = !hasAnyFilter;
    btnApply.title = hasAnyFilter
      ? "Terapkan filter"
      : "Pilih filter terlebih dahulu";
  },

  onSubmit(e) {
    e.preventDefault();

    const { sk, pg, kg, th } = this.elements;

    const params = new URLSearchParams();

    if (sk?.value) params.append("sk", sk.value);
    if (pg?.value) params.append("pg", pg.value);
    if (kg?.value) params.append("kg", kg.value);
    if (th?.value) params.append("th", th.value);

    window.location.href = baseUrl + "analisis-risiko?" + params.toString();
  },

  filterDropdownOptions() {
    const { sk, pg, kg, th } = this.elements;
    const map = this.map;

    const selectedTim = sk?.value;

    const reset = (el) => {
      if (!el) return;
      el.innerHTML = `<option value="">– Pilih –</option>`;
    };

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

    pgSet.forEach((val, key) => {
      const opt = document.createElement("option");
      opt.value = key;
      opt.textContent = val;
      pg.appendChild(opt);
    });

    kgSet.forEach((val, key) => {
      const opt = document.createElement("option");
      opt.value = key;
      opt.textContent = val;
      kg.appendChild(opt);
    });

    thSet.forEach((tahun) => {
      const opt = document.createElement("option");
      opt.value = tahun;
      opt.textContent = tahun;
      th.appendChild(opt);
    });

    const params = new URLSearchParams(window.location.search);

    if (pg && params.get("pg")) pg.value = params.get("pg");
    if (kg && params.get("kg")) kg.value = params.get("kg");
    if (th && params.get("th")) th.value = params.get("th");
  },
};

document.addEventListener("DOMContentLoaded", () => ArContextSelector.init());
