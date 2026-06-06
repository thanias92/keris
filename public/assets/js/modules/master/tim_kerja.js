const TK_URL = window.TK_CONFIG?.url || {};
let tkModal = null;
let currentPage = 1;
let perPage = 10;
let rawData = [];

document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("tkForm");
  if (el && typeof bootstrap !== "undefined") {
    tkModal = bootstrap.Offcanvas.getOrCreateInstance(el);
    el.addEventListener("show.bs.offcanvas", () => {
      el.style.transform = "none";
      el.style.visibility = "visible";
    });
    el.addEventListener("shown.bs.offcanvas", () => {
      el.style.transform = "none";
    });
  }
  document.getElementById("tkPerPage").onchange = (e) => {
    perPage = parseInt(e.target.value);
    currentPage = 1;
    renderTable();
  };
  loadTable();
});

function setMode(mode) {
  const hasId = !!document.getElementById("tkId").value;

  document.getElementById("tkMode").value = mode;

  document.getElementById("tkNama").disabled = mode === "view";

  // View
  document
    .getElementById("tkBtnEdit")
    .classList.toggle("d-none", mode !== "view");

  document
    .getElementById("tkBtnDelete")
    .classList.toggle("d-none", !(mode === "view" && hasId));

  // Edit
  document
    .getElementById("tkBtnBatal")
    .classList.toggle("d-none", mode !== "edit");

  // Create & Edit
  document
    .getElementById("tkBtnSimpan")
    .classList.toggle("d-none", mode === "view");

  // Tutup hanya untuk View & Create
  document
    .querySelector('[data-bs-dismiss="offcanvas"]')
    .classList.toggle("d-none", mode === "edit");
}

function loadTable() {
  fetch(TK_URL.table)
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
    html = '<tr><td colspan="2" class="text-center">Tidak ada data</td></tr>';
  } else {
    slice.forEach((row, i) => {
      html += `<tr class="tk-row" data-id="${row.id}" data-nama="${row.nama_tim}">
      <td>${start + i + 1}</td>
      <td>${row.nama_tim}</td>
      </tr>`;
    });
  }
  document.getElementById("tkTableBody").innerHTML = html;
  renderInfo();
  renderPagination();
}

function renderInfo() {
  const total = rawData.length;
  const from = (currentPage - 1) * perPage + 1;
  const to = Math.min(currentPage * perPage, total);
  document.getElementById("tkInfo").innerText =
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
  document.getElementById("tkPagination").innerHTML = html;
}

function goPage(p) {
  currentPage = p;
  renderTable();
}

document.addEventListener("click", (e) => {
  const row = e.target.closest(".tk-row");
  if (row) {
    document.getElementById("tkId").value = row.dataset.id;
    document.getElementById("tkNama").value = row.dataset.nama;
    setMode("view");
    tkModal.show();
  }

  if (e.target.id === "btnTambah") {
    document.getElementById("tkId").value = "";
    document.getElementById("tkNama").value = "";

    setMode("create");
    tkModal.show();
  }

  if (e.target.id === "tkBtnEdit") {
    setMode("edit");
  }

  if (e.target.id === "tkBtnBatal") {
    setMode("view");
  }

  if (e.target.id === "tkBtnSimpan") {
    const id = document.getElementById("tkId").value;
    const nama = document.getElementById("tkNama").value;
    if (!nama) {
      Swal.fire("Validasi", "Nama wajib diisi", "warning");
      return;
    }
    const url = id ? TK_URL.update(id) : TK_URL.store;
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
        tkModal.hide();
        loadTable();
      })
      .catch(() => {
        Swal.fire("Error", "Gagal menyimpan data", "error");
      });
  }

  if (e.target.id === "tkBtnDelete") {
    const id = document.getElementById("tkId").value;
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

      fetch(TK_URL.delete(id), { method: "POST" })
        .then((res) => {
          if (!res.ok) throw new Error();
          return res.json();
        })
        .then(() => {
          Swal.fire("Berhasil", "Data berhasil dihapus", "success");
          tkModal.hide();
          loadTable();
        })
        .catch(() => {
          Swal.fire("Error", "Gagal menghapus data (500)", "error");
        });
    });
  }
});
