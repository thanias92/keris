// ======================================================
// IDENTIFIKASI RISIKO — RISIKO MODULE
// Prefix: ir
// Pakai: PkAlert, PkAjax
// ======================================================

let IR_URL = {};
let irBankCache = [];
let irSuggestIndex = -1;

document.addEventListener("DOMContentLoaded", function () {
  IR_URL = {
    store: baseUrl + "identifikasi-risiko/store",
    update: (id) => baseUrl + `identifikasi-risiko/update/${id}`,
    delete: (id) => baseUrl + `identifikasi-risiko/delete/${id}`,
    detail: (id) => baseUrl + `identifikasi-risiko/detail/${id}`,
    detailArea: (id) => baseUrl + `identifikasi-risiko/detail-area/${id}`,
    bankRisiko: baseUrl + "identifikasi-risiko/bank-risiko",
    ajaxTable: baseUrl + "identifikasi-risiko/table",
  };

  irLoadBankRisiko();
  irBindRowClick();
  irInitAutocomplete();

  document
    .getElementById("offcanvasRisiko")
        ?.addEventListener("hidden.bs.offcanvas", irResetForm);
    
    document.addEventListener("change", function (e) {
      if (!e.target.classList.contains("ir-area-dampak")) return;
      if (e.target.checked) {
        document.querySelectorAll(".ir-area-dampak").forEach((cb) => {
          if (cb !== e.target) cb.checked = false;
        });
      }
    });
});

/* ======================================================
   LOAD BANK RISIKO
====================================================== */
function irLoadBankRisiko() {
  PkAjax.get({
    url: IR_URL.bankRisiko,
    onSuccess(data) {
      irBankCache = data;
    },
  });
}

/* ======================================================
   AUTOCOMPLETE
====================================================== */
function irInitAutocomplete() {
  const textarea = document.getElementById("irPernyataan");
  const dropdown = document.getElementById("irBankSuggest");
  if (!textarea || !dropdown) return;

  textarea.addEventListener("input", function () {
    const q = this.value.trim();
    irSuggestIndex = -1;
    q.length >= 2 ? irShowSuggest(q) : irHideSuggest();
  });

  textarea.addEventListener("keydown", function (e) {
    const items = dropdown.querySelectorAll(".ir-suggest-item");
    if (!items.length || dropdown.style.display === "none") return;

    if (e.key === "ArrowDown") {
      e.preventDefault();
      irSuggestIndex = Math.min(irSuggestIndex + 1, items.length - 1);
      irHighlight(items);
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      irSuggestIndex = Math.max(irSuggestIndex - 1, 0);
      irHighlight(items);
    } else if (e.key === "Enter" && irSuggestIndex >= 0) {
      e.preventDefault();
      irPickSuggest(items[irSuggestIndex].dataset.value, textarea);
    } else if (e.key === "Escape") {
      irHideSuggest();
    }
  });

  document.addEventListener("click", function (e) {
    if (!textarea.contains(e.target) && !dropdown.contains(e.target)) {
      irHideSuggest();
    }
  });
}

function irShowSuggest(q) {
  const dropdown = document.getElementById("irBankSuggest");
  if (!dropdown) return;

  const safeQ = q.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
  const matched = irBankCache
    .filter((item) =>
      item.pernyataan_risiko.toLowerCase().includes(q.toLowerCase()),
    )
    .slice(0, 8);

  if (!matched.length) {
    dropdown.innerHTML = `<div class="ir-suggest-empty">Tidak ada rekomendasi yang cocok</div>`;
    dropdown.style.display = "block";
    return;
  }

  dropdown.innerHTML = matched
    .map((item) => {
      const highlighted = item.pernyataan_risiko.replace(
        new RegExp(`(${safeQ})`, "gi"),
        "<mark>$1</mark>",
      );
      const safeVal = item.pernyataan_risiko.replace(/"/g, "&quot;");
      return `<div class="ir-suggest-item" data-value="${safeVal}">${highlighted}</div>`;
    })
    .join("");

  dropdown.querySelectorAll(".ir-suggest-item").forEach((el) => {
    el.addEventListener("mousedown", function (e) {
      e.preventDefault();
      irPickSuggest(
        this.dataset.value,
        document.getElementById("irPernyataan"),
      );
    });
  });

  dropdown.style.display = "block";
}

function irPickSuggest(value, textarea) {
  textarea.value = value;
  textarea.setSelectionRange(value.length, value.length);
  textarea.focus();
  irHideSuggest();
  irSuggestIndex = -1;
}

function irHighlight(items) {
  items.forEach((el, i) => {
    el.classList.toggle("ir-suggest-active", i === irSuggestIndex);
    if (i === irSuggestIndex) el.scrollIntoView({ block: "nearest" });
  });
}

function irHideSuggest() {
  const el = document.getElementById("irBankSuggest");
  if (el) el.style.display = "none";
}

/* ======================================================
   SET MODE: create | view | edit
====================================================== */
function irSetMode(mode) {
  const btnDelete = document.getElementById("irBtnDelete");
  const btnSwitchEdit = document.getElementById("irBtnSwitchEdit");
  const btnSimpan = document.getElementById("irBtnSimpan");
  const btnCancelEdit = document.getElementById("irBtnCancelEdit");
  const btnTutup = document.getElementById("irBtnTutup");

  [btnDelete, btnSwitchEdit, btnSimpan, btnCancelEdit].forEach((el) => {
    el?.classList.add("d-none");
  });

  // Tutup selalu tampil kecuali mode edit
  btnTutup?.classList.toggle("d-none", mode === "edit");

  if (mode === "create") {
    btnSimpan?.classList.remove("d-none");
  } else if (mode === "view") {
    btnDelete?.classList.remove("d-none");
    btnSwitchEdit?.classList.remove("d-none");
  } else if (mode === "edit") {
    btnDelete?.classList.remove("d-none");
    btnSimpan?.classList.remove("d-none");
    btnCancelEdit?.classList.remove("d-none");
  }

  const isView = mode === "view";
  [
    "irKonteksProses",
    "irPernyataan",
    "irDampak",
    "irPenyebab",
    "irKategori",
  ].forEach((id) => {
    const el = document.getElementById(id);
    if (el) el.disabled = isView;
  });
  document
    .querySelectorAll('input[name="sumber_risiko"]')
    .forEach((r) => (r.disabled = isView));
  document
    .querySelectorAll(".ir-area-dampak")
    .forEach((cb) => (cb.disabled = isView));
}

/* ======================================================
   RESET FORM
====================================================== */
function irResetForm() {
  const form = document.getElementById("irForm");
  if (!form) return;
  form.reset();
  form.classList.remove("was-validated");
  document.getElementById("irMode").value = "create";
  document.getElementById("irId").value = "";
  document.getElementById("irOffcanvasTitle").textContent = "Tambah Risiko";
  document
    .querySelectorAll(".ir-area-dampak")
    .forEach((cb) => (cb.checked = false));
  irHideSuggest();
  irSetMode("create");
}

/* ======================================================
   BIND ROW CLICK
====================================================== */
function irBindRowClick() {
  document.querySelectorAll(".ir-row").forEach((row) => {
    row.addEventListener("click", function () {
      irLoadDetail(this.dataset.id);
    });
  });
}

/* ======================================================
   LOAD DETAIL
====================================================== */
function irLoadDetail(id) {
  Promise.all([
    fetch(IR_URL.detail(id), {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    }).then((r) => r.json()),
    fetch(IR_URL.detailArea(id), {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    }).then((r) => r.json()),
  ])
    .then(([data, areas]) => {
      document.getElementById("irId").value = data.id_identifikasi;
      document.getElementById("irMode").value = "view";
      document.getElementById("irOffcanvasTitle").textContent = "Detail Risiko";

      document.getElementById("irKonteksProses").value =
        data.id_konteks_proses ?? "";
      document.getElementById("irPernyataan").value =
        data.pernyataan_risiko ?? "";
      document.getElementById("irDampak").value = data.dampak_risiko ?? "";
      document.getElementById("irPenyebab").value = data.penyebab_risiko ?? "";
      document.getElementById("irKategori").value =
        data.id_kategori_risiko ?? "";

      document.querySelectorAll('input[name="sumber_risiko"]').forEach((r) => {
        r.checked = r.value === data.sumber_risiko;
      });
      document.querySelectorAll(".ir-area-dampak").forEach((cb) => {
        cb.checked = areas.map(String).includes(String(cb.value));
      });

      irHideSuggest();
      irSetMode("view");
      bootstrap.Offcanvas.getOrCreateInstance(
        document.getElementById("offcanvasRisiko"),
      ).show();
    })
    .catch(() => PkAlert.error({ text: "Gagal memuat detail risiko." }));
}

/* ======================================================
   SWITCH TO EDIT
====================================================== */
document.addEventListener("click", function (e) {
  if (e.target?.id === "irBtnSwitchEdit") {
    document.getElementById("irMode").value = "edit";
    document.getElementById("irOffcanvasTitle").textContent = "Ubah Risiko";
    irSetMode("edit");
  }
});

/* ======================================================
   CANCEL EDIT
====================================================== */
document.addEventListener("click", function (e) {
  if (e.target?.id === "irBtnCancelEdit") {
    const id = document.getElementById("irId").value;
    if (id) irLoadDetail(id);
  }
});

/* ======================================================
   REFRESH TABLE
====================================================== */
function irRefreshTable() {
  PkAjax.get({
    url: IR_URL.ajaxTable,
    onSuccess(html) {
      const wrapper = document.getElementById("irTableWrapper");
      if (wrapper) {
        wrapper.innerHTML = html;
        irBindRowClick();
      }
    },
  });
}

/* ======================================================
   REFRESH CSRF TOKEN
====================================================== */
function irRefreshCsrf(res) {
    if (res && res.csrf_token) {
        window.csrfToken = res.csrf_token;
    }
}

/* ======================================================
   SUBMIT FORM
====================================================== */
document.addEventListener("submit", function (e) {
  if (e.target?.id !== "irForm") return;
  e.preventDefault();

  const form = e.target;
  // Tambahkan CSRF token ke FormData
  const formData = new FormData(form);
  formData.append(csrfName, csrfToken);
  const mode = document.getElementById("irMode").value;
  const id = document.getElementById("irId").value;
  const isEdit = mode === "edit";
  
  // Validasi area dampak wajib dipilih 1
  const areaChecked = document.querySelectorAll(".ir-area-dampak:checked").length;
  if (areaChecked === 0) {
    PkAlert.toast({ text: "Area dampak wajib dipilih.", icon: "warning" });
   return;
    }

  if (!form.checkValidity()) {
    form.classList.add("was-validated");
    return;
  }

  PkAlert.confirm({
    title: isEdit ? "Ubah Risiko?" : "Simpan Risiko?",
    text: isEdit
      ? "Data identifikasi risiko akan diperbarui."
      : "Data identifikasi risiko akan disimpan.",
    icon: isEdit ? "warning" : "question",
    confirmText: isEdit ? "Ubah" : "Simpan",
  }).then((result) => {
    if (!result.isConfirmed) return;

    $.ajax({
      url: isEdit ? IR_URL.update(id) : IR_URL.store,
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: { "X-Requested-With": "XMLHttpRequest" },
      success(res) {
        irRefreshCsrf(res);
        if (res.status === "success") {
          bootstrap.Offcanvas.getInstance(
            document.getElementById("offcanvasRisiko"),
          )?.hide();
          PkAlert.toast({
            text: isEdit
              ? "Risiko berhasil diperbarui."
              : "Risiko berhasil disimpan.",
            icon: "success",
          });
          irRefreshTable();
        } else {
          PkAlert.error({ text: res.message ?? "Terjadi kesalahan." });
        }
      },
      error() {
        PkAlert.error();
      },
    });
  });
});

/* ======================================================
   DELETE
====================================================== */
document.addEventListener("click", function (e) {
  if (!e.target?.closest("#irBtnDelete")) return;

  const id = document.getElementById("irId").value;
  if (!id) return;

  PkAlert.warning({
    title: "Hapus Risiko?",
    text: "Data identifikasi risiko ini akan dihapus permanen.",
    confirmText: "Hapus",
  }).then((result) => {
    if (!result.isConfirmed) return;

    $.ajax({
      url: IR_URL.delete(id),
      method: "POST",
      data: { [csrfName]: csrfToken },
      processData: true,
      contentType: "application/x-www-form-urlencoded",
      headers: { "X-Requested-With": "XMLHttpRequest" },
      success(res) {
        irRefreshCsrf(res);
        if (res.status === "success") {
          bootstrap.Offcanvas.getInstance(
            document.getElementById("offcanvasRisiko"),
          )?.hide();
          PkAlert.toast({ text: "Risiko berhasil dihapus.", icon: "success" });
          irRefreshTable();
        } else {
          PkAlert.error({ text: res.message ?? "Gagal menghapus." });
        }
      },
      error() {
        PkAlert.error();
      },
    });
  });
});

document.addEventListener("click", function (e) {
  if (e.target?.id !== "irBtnRequest") return;

  const pernyataan = document.getElementById("irPernyataan").value.trim();

  if (!pernyataan) {
    PkAlert.toast({ text: "Pernyataan risiko wajib diisi.", icon: "warning" });
    return;
  }

  PkAlert.confirm({
    title: "Kirim ke Bank Risiko?",
    text: "Data akan dikirim sebagai request (pending).",
    icon: "question",
    confirmText: "Kirim",
  }).then((result) => {
    if (!result.isConfirmed) return;

    $.ajax({
      url: baseUrl + "identifikasi-risiko/request-bank-risiko",
      method: "POST",
      data: {
        pernyataan_risiko: pernyataan,
        [csrfName]: csrfToken,
      },
      success(res) {
        if (res.status === "success") {
          PkAlert.toast({
            text: "Berhasil dikirim ke Bank Risiko (pending approval).",
            icon: "success",
          });
        }
      },
      error() {
        PkAlert.error();
      },
    });
  });
});
