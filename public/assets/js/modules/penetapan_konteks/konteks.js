// ======================================================
// KONTEKS MODULE
// ======================================================

const KonteksModule = {
  init() {
    console.log("Konteks module loaded");

    this.initSelect2();
    this.initStrukturOrganisasi();
    this.initKabKotaCombobox();
    this.initSatuanKerjaCombobox();
    this.initKegiatanCombobox();
    this.initYearPicker();
  },

  // ======================================================
  // SELECT2
  // ======================================================

  initSelect2() {
    const offcanvas = document.getElementById("offcanvasKonteks");
    if (!offcanvas) return;

    offcanvas.addEventListener("shown.bs.offcanvas", function () {
      $(".pk-select-search").each(function () {
        if (!$(this).hasClass("select2-hidden-accessible")) {
          $(this).select2({
            width: "100%",
            dropdownParent: $("#offcanvasKonteks"),
            placeholder: "Pilih...",
            minimumResultsForSearch: 0,
          });
        }
      });
    });
  },

  // ======================================================
  // STRUKTUR ORGANISASI
  // ======================================================

  initStrukturOrganisasi() {
    const radios = document.querySelectorAll('input[name="level_struktur"]');
    const kabWrapper = document.getElementById("pkKabKotaWrapper");

    if (!radios.length) return;

    radios.forEach((radio) => {
      radio.addEventListener("change", function () {
        if (this.value === "provinsi") {
          kabWrapper.style.display = "none";

          KonteksModule.clearKabKota();
          KonteksModule.clearPengelola();
          KonteksModule.loadProvinsiPemilik();
        }

        if (this.value === "kabkota") {
          kabWrapper.style.display = "block";

          KonteksModule.clearPemilik();
          KonteksModule.clearPengelola();
        }
      });
    });

    this.loadProvinsiPemilik();
    },
  
  initKabKotaCombobox() {

  const combo = document.getElementById("pkKabKotaBox");
  if (!combo) return;

  const input = document.getElementById("pkKabKotaInput");
  const hidden = document.getElementById("pkKabKotaValue");

  const dropdown = combo.querySelector(".pk-combobox-dropdown");
  const options = combo.querySelectorAll(".pk-option");

  let current = -1;
  let selected = false;

  const open = () => dropdown.classList.add("open");
  const close = () => dropdown.classList.remove("open");

  const removeActive = () =>
    options.forEach(o => o.classList.remove("active"));

  const setActive = (i) => {

    removeActive();

    const visible = [...options].filter(o => o.style.display !== "none");

    if (visible[i]) {
      visible[i].classList.add("active");
      visible[i].scrollIntoView({ block: "nearest" });
    }

  };

  const filter = (keyword) => {

    options.forEach(o => {

      o.style.display = o.innerText.toLowerCase().includes(keyword)
        ? "block"
        : "none";

    });

  };

  const select = (option) => {

    input.value = option.innerText;
    hidden.value = option.dataset.value;

    selected = true;

    close();

  };

  input.addEventListener("focus", () => {
    if (!selected) open();
  });

  input.addEventListener("click", () => {

    if (selected) {

      selected = false;
      input.value = "";
      hidden.value = "";

    }

    open();

  });

  input.addEventListener("input", function () {

    selected = false;

    filter(this.value.toLowerCase());
    open();

    current = -1;

  });

  input.addEventListener("keydown", (e) => {

    const visible = [...options].filter(o => o.style.display !== "none");

    if (e.key === "ArrowDown") {

      e.preventDefault();

      current++;
      if (current >= visible.length) current = 0;

      setActive(current);

    }

    if (e.key === "ArrowUp") {

      e.preventDefault();

      current--;
      if (current < 0) current = visible.length - 1;

      setActive(current);

    }

    if (e.key === "Enter") {

      e.preventDefault();

      if (visible[current]) select(visible[current]);

      if (visible.length === 1) select(visible[0]);

    }

    if (e.key === "Escape") close();

  });

  options.forEach(o => {

    o.addEventListener("click", function () {

      select(this);

    });

  });

  document.addEventListener("click", function (e) {

    if (!combo.contains(e.target)) close();

  });

},

  // ======================================================
  // PEMILIK RISIKO
  // ======================================================

  loadProvinsiPemilik() {
    $.get("/penetapan-konteks/konteks/get-pemilik-provinsi", (res) => {
      if (!res) return;

      this.setPemilikRisiko(res);
    });
  },

  setPemilikRisiko(data) {
    document.getElementById("pkPemilikId").value = data.id || "";

    document.getElementById("pkPemilikNama").innerText = data.nama || "-";
    document.getElementById("pkPemilikNip").innerText = data.nip || "-";
    document.getElementById("pkPemilikJabatan").innerText = data.jabatan || "-";
  },

  clearPemilik() {
    document.getElementById("pkPemilikId").value = "";

    document.getElementById("pkPemilikNama").innerText = "-";
    document.getElementById("pkPemilikNip").innerText = "-";
    document.getElementById("pkPemilikJabatan").innerText = "-";
  },

  clearKabKota() {
    const kab = document.getElementById("pkKabKota");
    if (kab) kab.value = "";
  },

  // ======================================================
  // PENGELOLA RISIKO
  // ======================================================

  loadPengelolaBySatuanKerja(id) {
    if (!id) return;

    $.get(
      "/penetapan-konteks/konteks/get-pengelola-list?satuan=" + id,
      (res) => {
        if (!res || res.length === 0) {
          this.clearPengelola();
          return;
        }

        const data = res[0];

        document.getElementById("pkPengelolaValue").value = data.id;

        document.getElementById("pkPengelolaNama").innerText = data.nama;
        document.getElementById("pkPengelolaNip").innerText = data.nip;
        document.getElementById("pkPengelolaJabatan").innerText = data.jabatan;
      },
    );
  },

  clearPengelola() {
    document.getElementById("pkPengelolaValue").value = "";

    document.getElementById("pkPengelolaNama").innerText = "-";
    document.getElementById("pkPengelolaNip").innerText = "-";
    document.getElementById("pkPengelolaJabatan").innerText = "-";
  },

  // ======================================================
  // SATUAN KERJA COMBOBOX (IMPROVED UX)
  // ======================================================

  initSatuanKerjaCombobox() {
    const combo = document.getElementById("pkSatuanKerjaBox");
    if (!combo) return;

    const input = combo.querySelector(".pk-combobox-input");
    const dropdown = combo.querySelector(".pk-combobox-dropdown");
    const options = combo.querySelectorAll(".pk-option");
    const hidden = document.getElementById("pkSatuanKerjaValue");

    let current = -1;
    let selected = false;

    const open = () => dropdown.classList.add("open");
    const close = () => dropdown.classList.remove("open");

    const removeActive = () =>
      options.forEach((o) => o.classList.remove("active"));

    const setActive = (i) => {
      removeActive();

      const visible = [...options].filter((o) => o.style.display !== "none");

      if (visible[i]) {
        visible[i].classList.add("active");
        visible[i].scrollIntoView({ block: "nearest" });
      }
    };

    const filter = (keyword) => {
      options.forEach((o) => {
        o.style.display = o.innerText.toLowerCase().includes(keyword)
          ? "block"
          : "none";
      });
    };

    const select = (option) => {
      input.value = option.innerText;
      hidden.value = option.dataset.value;

      selected = true;

      KonteksModule.loadPengelolaBySatuanKerja(option.dataset.value);
      KonteksModule.loadKegiatanBySatuanKerja(option.dataset.value);

      close();
    };

    input.addEventListener("focus", () => {
      if (!selected) open();
    });

    input.addEventListener("click", () => {
      if (selected) {
        selected = false;
        input.value = "";
        hidden.value = "";
      }

      open();
    });

    input.addEventListener("input", function () {
      selected = false;

      filter(this.value.toLowerCase());
      open();
      current = -1;
    });

    input.addEventListener("keydown", (e) => {
      const visible = [...options].filter((o) => o.style.display !== "none");

      if (e.key === "ArrowDown") {
        e.preventDefault();

        current++;
        if (current >= visible.length) current = 0;

        setActive(current);
      }

      if (e.key === "ArrowUp") {
        e.preventDefault();

        current--;
        if (current < 0) current = visible.length - 1;

        setActive(current);
      }

      if (e.key === "Enter") {
        e.preventDefault();

        if (visible[current]) select(visible[current]);

        if (visible.length === 1) select(visible[0]);
      }

      if (e.key === "Escape") close();
    });

    options.forEach((o) => {
      o.addEventListener("click", function () {
        select(this);
      });
    });

    document.addEventListener("click", function (e) {
      if (!combo.contains(e.target)) close();
    });
  },

  // ======================================================
  // KEGIATAN
  // ======================================================

  loadKegiatanBySatuanKerja(id) {
    if (!id) return;

    const wrapper = document.getElementById("pkKegiatanOptions");
    const input = document.getElementById("pkKegiatanInput");
    const hidden = document.getElementById("pkKegiatanValue");

    $.get("/penetapan-konteks/konteks/get-kegiatan/" + id, function (res) {
      wrapper.innerHTML = "";

      if (!res || res.length === 0) {
        wrapper.innerHTML =
          '<div class="pk-option text-muted">Tidak ada kegiatan</div>';
        return;
      }

      res.forEach(function (item) {
        const div = document.createElement("div");

        div.className = "pk-option";
        div.innerText = item.nama_kegiatan;
        div.dataset.value = item.id_kegiatan;

        div.onclick = function () {
          input.value = this.innerText;
          hidden.value = this.dataset.value;
        };

        wrapper.appendChild(div);
      });
    });
  },

  // ======================================================
  // YEAR PICKER
  // ======================================================

  initYearPicker() {
    const items = document.querySelectorAll(".pk-year-item");
    const hidden = document.getElementById("pkTahun");

    items.forEach((item) => {
      item.addEventListener("click", function () {
        items.forEach((i) => i.classList.remove("active"));

        this.classList.add("active");

        hidden.value = this.dataset.year;
      });
    });
  },
};

// ======================================================
// INIT
// ======================================================

$(document).ready(function () {
  KonteksModule.init();
});

// ======================================================
// GLOBAL FUNCTION
// ======================================================

window.pkOpenCreateMode = function () {
  const mode = document.getElementById("pkMode");

  if (!mode) return;

  mode.value = "create";

  const title = document.getElementById("pkOffcanvasTitle");

  if (title) title.innerText = "Tambah Konteks";

  const form = document.getElementById("pkFormKonteks");

  if (form) form.reset();
};

