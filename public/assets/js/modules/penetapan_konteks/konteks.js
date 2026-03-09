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
    this.initTahunCombobox();
    this.initSasaranCombobox();
    this.initPeraturanCombobox();
    this.initPemangkuCombobox();
    this.initFormSubmit();
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

  // ======================================================
  // KAB/KOTA COMBOBOX
  // ======================================================

  initKabKotaCombobox() {
    Combobox.init({
      boxId: "pkKabKotaBox",
      inputId: "pkKabKotaInput",
      hiddenId: "pkKabKotaValue",
      optionsSelector: ".pk-option",
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
  // SATUAN KERJA COMBOBOX
  // ======================================================

  initSatuanKerjaCombobox() {
    Combobox.init({
      boxId: "pkSatuanKerjaBox",
      inputId: "pkSatuanKerjaInput",
      hiddenId: "pkSatuanKerjaValue",
      optionsSelector: ".pk-option",

      onSelect: (value) => {
        KonteksModule.resetKegiatan();

        KonteksModule.loadPengelolaBySatuanKerja(value);
        KonteksModule.loadKegiatanBySatuanKerja(value);
      },
    });
  },

  // ======================================================
  // KEGIATAN
  // ======================================================

  resetKegiatan() {
    const input = document.getElementById("pkKegiatanInput");
    const hidden = document.getElementById("pkKegiatanValue");
    const wrapper = document.getElementById("pkKegiatanOptions");

    if (input) input.value = "";
    if (hidden) hidden.value = "";

    if (wrapper) {
      wrapper.innerHTML =
        '<div class="pk-option text-muted">Pilih satuan kerja terlebih dahulu</div>';
    }
  },

  loadKegiatanBySatuanKerja(id) {
    if (!id) return;

    const wrapper = document.getElementById("pkKegiatanOptions");
    const input = document.getElementById("pkKegiatanInput");
    const hidden = document.getElementById("pkKegiatanValue");
    const dropdown = document.querySelector(
      "#pkKegiatanBox .pk-combobox-dropdown",
    );

    $.get("/penetapan-konteks/konteks/get-kegiatan/" + id, function (res) {
      wrapper.innerHTML = "";
      input.value = "";
      hidden.value = "";

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

        div.addEventListener("mousedown", function (e) {
          e.preventDefault();
          e.stopPropagation();
          input.value = item.nama_kegiatan;
          hidden.value = item.id_kegiatan;
          dropdown.classList.remove("open");
        });

        wrapper.appendChild(div);
      });

      // buka/tutup dropdown saat klik input
      input.onclick = () => dropdown.classList.toggle("open");
      input.oninput = function () {
        const q = this.value.toLowerCase();
        wrapper.querySelectorAll(".pk-option").forEach((o) => {
          o.style.display = o.innerText.toLowerCase().includes(q) ? "" : "none";
        });
        dropdown.classList.add("open");
      };

      document.addEventListener(
        "click",
        function (e) {
          if (!document.getElementById("pkKegiatanBox").contains(e.target)) {
            dropdown.classList.remove("open");
          }
        },
        { once: false },
      );
    });
  },

  initTahunCombobox() {
    Combobox.init({
      boxId: "pkTahunBox",
      inputId: "pkTahunInput",
      hiddenId: "pkTahun",
      optionsSelector: ".pk-option",
    });
  },

  // ======================================================
  // SASARAN STRATEGIS
  // ======================================================

  initSasaranCombobox() {
    Combobox.init({
      boxId: "pkSasaranBox",
      inputId: "pkSasaranInput",
      hiddenId: "pkSasaranValue",
      optionsSelector: ".pk-option",
    });
  },

  // ======================================================
  // PERATURAN MULTI SELECT
  // ======================================================

  initPeraturanCombobox() {
    const tags = document.getElementById("pkPeraturanTags");

    Combobox.init({
      boxId: "pkPeraturanBox",
      inputId: "pkPeraturanInput",
      hiddenId: null,
      optionsSelector: ".pk-option",

      onSelect: (value, text) => {
        // cegah duplikat
        if (tags.querySelector(`[data-id="${value}"]`)) return;

        const index = tags.querySelectorAll(".pk-law-item").length + 1;

        const tag = document.createElement("div");
        tag.className = "pk-law-item";
        tag.dataset.id = value;
        tag.innerHTML = `
          <div class="pk-law-number">${index}.</div>
          <div class="pk-law-title">${text}</div>
          <span class="pk-tag-remove">×</span>
        `;

        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "peraturan[]";
        hidden.value = value;
        tag.appendChild(hidden);

        tags.appendChild(tag);

        // sembunyikan option yang sudah dipilih dari dropdown
        const option = document.querySelector(
          `#pkPeraturanBox .pk-option[data-value="${value}"]`,
        );
        if (option) option.style.display = "none";

        tag.querySelector(".pk-tag-remove").onclick = () => {
          tag.remove();
          // tampilkan kembali option di dropdown
          if (option) option.style.display = "";
          KonteksModule.reindexPeraturan();
        };

        document.getElementById("pkPeraturanInput").value = "";
      },
    });
  },

  reindexPeraturan() {
    const items = document.querySelectorAll("#pkPeraturanTags .pk-law-item");

    items.forEach((el, i) => {
      const num = el.querySelector(".pk-law-number");
      if (num) num.innerText = i + 1 + ".";
    });
  },

  // ======================================================
  // PEMANGKU TAG INPUT
  // ======================================================
  initPemangkuCombobox() {
    const container = document.getElementById("pkPemangkuTags");

    Combobox.init({
      boxId: "pkPemangkuBox",
      inputId: "pkPemangkuInput",
      hiddenId: null,
      optionsSelector: ".pk-option",

      onSelect: (value, text) => {
        if (container.querySelector(`[data-id="${value}"]`)) return;

        const option = document.querySelector(
          `#pkPemangkuBox .pk-option[data-value="${value}"]`,
        );
        const role = option?.dataset.role || "";

        let group = container.querySelector(
          `.pk-pemangku-group[data-role="${CSS.escape(role)}"]`,
        );

        if (!group) {
          group = document.createElement("div");
          group.className = "pk-pemangku-group";
          group.dataset.role = role;
          group.innerHTML = `
            <div class="pk-pemangku-title">${role}</div>
            <div class="pk-pemangku-items"></div>
          `;
          container.appendChild(group);
        }

        const list = group.querySelector(".pk-pemangku-items");

        const item = document.createElement("div");
        item.className = "pk-pemangku-item";
        item.dataset.id = value;
        item.innerHTML = `
          <span>${text}</span>
          <span class="pk-tag-remove">×</span>
        `;

        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "pemangku[]";
        hidden.value = value;
        item.appendChild(hidden);

        list.appendChild(item);

        item.querySelector(".pk-tag-remove").onclick = function () {
          item.remove();
          if (list.children.length === 0) {
            group.remove();
          }
        };

        document.getElementById("pkPemangkuInput").value = "";
      },
    });
  },

  // ======================================================
  // FORM SUBMIT (CREATE / UPDATE)
  // ======================================================

  initFormSubmit() {
    const form = document.getElementById("pkFormKonteks");
    if (!form) return;

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      PkAlert.confirm({
        text: "Simpan data konteks ini?",
        confirmText: "Simpan",
      }).then((result) => {
        if (!result.isConfirmed) return;

        const mode = document.getElementById("pkMode").value;
        const url =
          mode === "edit"
            ? "/penetapan-konteks/konteks/update"
            : "/penetapan-konteks/konteks/store";

        PkAjax.post({
          url,
          data: $(form).serialize(),
          onSuccess(res) {
            if (res.status !== "success") return;
            bootstrap.Offcanvas.getInstance(
              document.getElementById("offcanvasKonteks"),
            ).hide();
            KonteksModule.refreshTable();
            PkAlert.success({ text: res.message });
          },
        });
      });
    });
  },

  // ======================================================
  // DELETE
  // ======================================================

  deleteKonteks(id) {
    PkAlert.warning({
      title: "Hapus data ini?",
      text: "Data yang dihapus tidak bisa dikembalikan.",
      confirmText: "Hapus",
    }).then((result) => {
      if (!result.isConfirmed) return;

      PkAjax.post({
        url: "/penetapan-konteks/konteks/delete",
        data: { id_konteks: id },
        onSuccess(res) {
          if (res.status !== "success") return;
          bootstrap.Offcanvas.getInstance(
            document.getElementById("offcanvasKonteks"),
          )?.hide();
          KonteksModule.refreshTable();
          PkAlert.success({ title: "Terhapus", text: res.message });
        },
      });
    });
  },

  // ======================================================
  // REFRESH TABLE (AJAX)
  // ======================================================

  refreshTable() {
    $.get("/penetapan-konteks/konteks/table", function (html) {
      $("#pkKonteksTableWrapper").html(html);
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

window.pkOpenViewMode = function (el) {
  const row = JSON.parse(el.dataset.row);
  const id = row.id_konteks;

  // set mode & id
  document.getElementById("pkMode").value = "view";
  document.getElementById("pkId").value = id;

  // set title
  document.getElementById("pkOffcanvasTitle").innerText = "Detail Konteks";

  // tampilkan button mode view
  document.getElementById("pkBtnCreate").style.display = "none";
  document.getElementById("pkBtnView").style.display = "flex";
  document.getElementById("pkBtnEdit").style.display = "none";

  // tombol hapus
  document.getElementById("pkBtnDelete").onclick = () => {
    KonteksModule.deleteKonteks(id);
  };

  // tombol switch ke edit
  document.getElementById("pkBtnSwitchEdit").onclick = () => {
    document.getElementById("pkMode").value = "edit";
    document.getElementById("pkOffcanvasTitle").innerText = "Edit Konteks";
    document.getElementById("pkBtnView").style.display = "none";
    document.getElementById("pkBtnEdit").style.display = "flex";
  };

  // load detail via AJAX lalu isi form
  $.get(`/penetapan-konteks/konteks/detail/${id}`, (res) => {
    const k = res.konteks;

    // isi hidden fields
    document.getElementById("pkSatuanKerjaValue").value = k.id_satuan_kerja;
    document.getElementById("pkSatuanKerjaInput").value =
      k.nama_satuan_kerja ?? "";
    document.getElementById("pkTahun").value = k.tahun;
    document.getElementById("pkTahunInput").value = k.tahun;
    document.getElementById("pkSasaranValue").value = k.id_sasaran_strategis;
    document.getElementById("pkSasaranInput").value = k.uraian_sasaran ?? "";
    document.getElementById("pkKegiatanValue").value = k.id_kegiatan;
    document.getElementById("pkKegiatanInput").value = k.nama_kegiatan ?? "";
  });

  // buka offcanvas
  new bootstrap.Offcanvas(document.getElementById("offcanvasKonteks")).show();
};

window.pkOpenCreateMode = function () {
  const mode = document.getElementById("pkMode");
  if (!mode) return;

  mode.value = "create";

  document.getElementById("pkOffcanvasTitle").innerText = "Tambah Konteks";

  document.getElementById("pkBtnCreate").style.display = "flex";
  document.getElementById("pkBtnView").style.display = "none";
  document.getElementById("pkBtnEdit").style.display = "none";

  const form = document.getElementById("pkFormKonteks");
  if (form) form.reset();
};
