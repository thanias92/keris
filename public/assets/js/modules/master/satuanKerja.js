const SK_URL = window.SK_CONFIG?.url || {};
let skModal = null;
let currentPage = 1;
let perPage = 10;
let rawData = [];

document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("skForm");
  if (el && typeof bootstrap !== "undefined") {
    skModal = bootstrap.Offcanvas.getOrCreateInstance(el);
    el.addEventListener("show.bs.offcanvas", () => {
      el.style.transform = "none";
      el.style.visibility = "visible";
    });
    el.addEventListener("shown.bs.offcanvas", () => {
      el.style.transform = "none";
    });
  }
  document.getElementById("skPerPage").onchange = (e) => {
    perPage = parseInt(e.target.value);
    currentPage = 1;
    renderTable();
  };
  loadTable();
});

function setMode(mode) {
  const isView = mode === "view";
  const isEdit = mode === "edit";
  document.getElementById("skMode").value = mode;
  document.getElementById("skNama").disabled = isView;
  document.getElementById("skTahun").disabled = isView;
  document.getElementById("skBtnEdit").classList.toggle("d-none", !isView);
  document.getElementById("skBtnBatal").classList.toggle("d-none", !isEdit);
  document.getElementById("skBtnSimpan").classList.toggle("d-none", isView);
  const hasId = !!document.getElementById("skId").value;
  document
    .getElementById("skBtnDelete")
    .classList.toggle("d-none", !(isView && hasId));
}

function loadTable() {
  fetch(SK_URL.table)
    .then((r) => r.json())
    .then((data) => {
      rawData = data;
      renderTable();
    });
}

function renderTable() {
  const start = (currentPage - 1) * perPage;
  const end = start + perPage;
  const slice = rawData.slice(start, end);
  let html = "";
  if (!slice.length) {
    html = '<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>';
  } else {
    slice.forEach((row, i) => {
      html += `<tr class="sk-row" data-id="${row.id}" data-nama="${row.nama_satuan_kerja}">
<td>${start + i + 1}</td>
<td>${row.nama_satuan_kerja}</td>
<td>${new Date().getFullYear()}</td>
</tr>`;
    });
  }
  document.getElementById("skTableBody").innerHTML = html;
  renderInfo();
  renderPagination();
}

function renderInfo() {
  const total = rawData.length;
  const from = (currentPage - 1) * perPage + 1;
  const to = Math.min(currentPage * perPage, total);
  document.getElementById("skInfo").innerText =
    `Menampilkan ${from}-${to} dari ${total} data`;
}

function renderPagination() {
  const totalPage = Math.ceil(rawData.length / perPage);
  let html = "";
  for (let i = 1; i <= totalPage; i++) {
    html += `<li class="page-item ${i === currentPage ? "active" : ""}">
<a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
</li>`;
  }
  document.getElementById("skPagination").innerHTML = html;
}

function goPage(p) {
  currentPage = p;
  renderTable();
}

document.addEventListener("click", (e) => {
  const row = e.target.closest(".sk-row");
  if (row) {
    document.getElementById("skId").value = row.dataset.id;
    document.getElementById("skNama").value = row.dataset.nama;
    document.getElementById("skTahun").value = new Date().getFullYear();
    setMode("view");
    skModal.show();
  }

  if (e.target.id === "btnTambah") {
    document.getElementById("skId").value = "";
    document.getElementById("skNama").value = "";
    document.getElementById("skTahun").value = new Date().getFullYear();
    setMode("edit");
    skModal.show();
  }

  if (e.target.id === "skBtnEdit") {
    setMode("edit");
  }

  if (e.target.id === "skBtnBatal") {
    setMode("view");
  }

  if (e.target.id === "skBtnSimpan") {
    const id = document.getElementById("skId").value;
    const nama = document.getElementById("skNama").value;
    if (!nama) {
      Swal.fire("Validasi", "Nama wajib diisi", "warning");
      return;
    }
    const url = id ? SK_URL.update(id) : SK_URL.store;
    fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `nama=${encodeURIComponent(nama)}`,
    })
      .then((res) => {
        if (!res.ok) throw new Error();
        return res.json();
      })
      .then(() => {
        Swal.fire("Berhasil", "Data disimpan", "success");
        skModal.hide();
        loadTable();
      })
      .catch(() => {
        Swal.fire("Error", "Gagal menyimpan data", "error");
      });
  }

  if (e.target.id === "skBtnDelete") {
    const id = document.getElementById("skId").value;
    if (!id) return;

    Swal.fire({
      title: "Hapus data?",
      text: "Data tidak bisa dikembalikan",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (!result.isConfirmed) return;

      fetch(SK_URL.delete(id), { method: "POST" })
        .then((res) => {
          if (!res.ok) throw new Error();
          return res.json();
        })
        .then(() => {
          Swal.fire("Berhasil", "Data berhasil dihapus", "success");
          skModal.hide();
          loadTable();
        })
        .catch(() => {
          Swal.fire("Error", "Gagal menghapus data (500)", "error");
        });
    });
  }
});
