const SS_URL = window.SS_CONFIG?.url || {};
let ssModal = null;
let currentPage = 1;
let perPage = 10;
let rawData = [];

document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("ssForm");
  ssModal = bootstrap.Offcanvas.getOrCreateInstance(el);

  document.getElementById("ssPerPage").onchange = (e) => {
    perPage = parseInt(e.target.value);
    currentPage = 1;
    renderTable();
  };

  loadTable();
});

function setMode(mode) {
  const isView = mode === "view";
  document.getElementById("ssMode").value = mode;

  document.getElementById("ssKode").disabled = isView;
  document.getElementById("ssUraian").disabled = isView;

  document.getElementById("ssBtnEdit").classList.toggle("d-none", !isView);
  document.getElementById("ssBtnSimpan").classList.toggle("d-none", isView);
  document
    .getElementById("ssBtnBatal")
    .classList.toggle("d-none", mode !== "edit");

  const hasId = !!document.getElementById("ssId").value;
  document
    .getElementById("ssBtnDelete")
    .classList.toggle("d-none", !(isView && hasId));
}

function loadTable() {
  fetch(SS_URL.table)
    .then((r) => r.json())
    .then((data) => {
      rawData = data;
      renderTable();
    });
}

function renderTable() {
  const start = (currentPage - 1) * perPage;
  const slice = rawData.slice(start, start + perPage);
  let html = "";

  slice.forEach((row, i) => {
    html += `<tr class="ss-row" data-id="${row.id}" data-kode="${row.kode_sasaran}" data-uraian="${row.uraian_sasaran}">
<td>${start + i + 1}</td>
<td>${row.kode_sasaran}</td>
<td>${row.uraian_sasaran}</td>
</tr>`;
  });

  document.getElementById("ssTableBody").innerHTML =
    html || '<tr><td colspan="3">Tidak ada data</td></tr>';
}

document.addEventListener("click", (e) => {
  const row = e.target.closest(".ss-row");
  if (row) {
    document.getElementById("ssId").value = row.dataset.id;
    document.getElementById("ssKode").value = row.dataset.kode;
    document.getElementById("ssUraian").value = row.dataset.uraian;
    setMode("view");
    ssModal.show();
  }

  if (e.target.id === "btnTambah") {
    document.getElementById("ssId").value = "";
    document.getElementById("ssKode").value = "";
    document.getElementById("ssUraian").value = "";
    setMode("edit");
    ssModal.show();
  }

  if (e.target.id === "ssBtnEdit") setMode("edit");

  if (e.target.id === "ssBtnSimpan") {
    const id = document.getElementById("ssId").value;
    const kode = document.getElementById("ssKode").value;
    const uraian = document.getElementById("ssUraian").value;

    if (!kode || !uraian) {
      Swal.fire("Validasi", "Lengkapi semua field", "warning");
      return;
    }

    const url = id ? SS_URL.update(id) : SS_URL.store;

    fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `kode=${encodeURIComponent(kode)}&uraian=${encodeURIComponent(uraian)}`,
    })
      .then(() => {
        Swal.fire("Berhasil", "Data disimpan", "success");
        ssModal.hide();
        loadTable();
      })
      .catch(() => Swal.fire("Error", "Gagal", "error"));
  }

  if (e.target.id === "ssBtnDelete") {
    const id = document.getElementById("ssId").value;
    fetch(SS_URL.delete(id), { method: "POST" }).then(() => {
      Swal.fire("Berhasil", "Dihapus", "success");
      ssModal.hide();
      loadTable();
    });
  }

  if (e.target.id === "ssBtnClose") ssModal.hide();
});
