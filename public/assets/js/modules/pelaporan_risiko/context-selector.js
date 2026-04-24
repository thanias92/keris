const PlContextSelector = {
  elements: {},
  map: {},
  bulan: [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "Mei",
    "Jun",
    "Jul",
    "Agu",
    "Sep",
    "Okt",
    "Nov",
    "Des",
  ],

  init() {
    const form = document.getElementById("plContextSelectorForm");
    if (!form) return;

    this.map = window.PL_CS_DATA?.konteksMap ?? {};

    this.elements = {
      form,
      sk: document.getElementById("plCsTimKerja"),
      pg: document.getElementById("plCsPengelola"),
      bulan: document.getElementById("plCsBulan"),
      tahun: document.getElementById("plCsTahun"),
      display: document.getElementById("plPeriodeDisplay"),
      dropdown: document.getElementById("plPeriodeDropdown"),
      monthGrid: document.getElementById("plMonthGrid"),
      yearLabel: document.getElementById("plYearLabel"),
      idEl: document.getElementById("plCsIdKonteks"),
    };

    this.renderPeriode();
    this.bindEvents();
    this.resolveId();
  },

  bindEvents() {
    const { sk, pg, display, dropdown, form } = this.elements;

    [sk, pg].forEach((el) => {
      if (el) el.addEventListener("change", () => this.resolveId());
    });

    display.addEventListener("click", () => {
      dropdown.classList.toggle("d-none");
    });

    document.addEventListener("click", (e) => {
      if (!e.target.closest(".pl-period")) {
        dropdown.classList.add("d-none");
      }
    });

    form.addEventListener("submit", (e) => this.onSubmit(e));
  },

  renderPeriode() {
    const { bulan, tahun, display, monthGrid, yearLabel } = this.elements;

    const currentYear = parseInt(tahun.value);
    const currentMonth = parseInt(bulan.value) - 1;

    yearLabel.textContent = currentYear;

    display.value = this.bulan[currentMonth] + " " + currentYear;

    monthGrid.innerHTML = "";

    this.bulan.forEach((b, i) => {
      const el = document.createElement("div");
      el.className = "pl-month" + (i === currentMonth ? " active" : "");
      el.textContent = b;

      el.onclick = () => {
        bulan.value = (i + 1).toString().padStart(2, "0");
        this.renderPeriode();
        this.resolveId();
      };

      monthGrid.appendChild(el);
    });
  },

  resolveId() {
    const { sk, pg, tahun, idEl } = this.elements;

    const vSk = sk?.value ?? "";
    const vPg = pg?.value ?? "";
    const vTh = tahun?.value ?? "";

    idEl.value = "";

    for (const [id, k] of Object.entries(this.map)) {
      const matchSk = !vSk || String(k.id_tim) === vSk;
      const matchPg = !vPg || String(k.pengelola_risiko_id) === vPg;
      const matchTh = !vTh || String(k.tahun) === vTh;

      if (matchSk && matchPg && matchTh) {
        idEl.value = id;
        return;
      }
    }
  },

  onSubmit(e) {
    const { idEl } = this.elements;
    if (!idEl.value) {
      e.preventDefault();
      alert("Konteks tidak ditemukan");
    }
  },
};

document.addEventListener("DOMContentLoaded", () => PlContextSelector.init());
