const KG_URL = window.KEGIATAN_CONFIG?.url || {};
let kgModal = null;
let currentPage = 1;
let perPage = 10;
let rawData = [];

document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("kgForm");
  if (el && typeof bootstrap !== "undefined") {
    kgModal = bootstrap.Offcanvas.getOrCreateInstance(el);
    el.addEventListener("show.bs.offcanvas", () => {
      el.style.transform = "none";
      el.style.visibility = "visible";
    });
    el.addEventListener("shown.bs.offcanvas", () => {
      el.style.transform = "none";
    });
  }

  document.getElementById("kgForm").addEventListener("click", (e) => {
    if (e.target.id === "kgForm") {
      kgModal.hide();
    }
  });

  document.getElementById("kgPerPage").onchange = (e) => {
    perPage = parseInt(e.target.value);
    currentPage = 1;
    renderTable();
  };

  loadTable();
  loadSatuanKerja();
});

function setMode(mode) {
  const isView = mode === "view";
  const isEdit = mode === "edit";

  document.getElementById("kgMode").value = mode;
  document.getElementById("kgNama").disabled = isView;
  document.getElementById("kgSatuanKerja").disabled = isView;

  document.getElementById("kgBtnEdit").classList.toggle("d-none", !isView);
  document.getElementById("kgBtnBatal").classList.toggle("d-none", !isEdit);
  document.getElementById("kgBtnSimpan").classList.toggle("d-none", isView);

  const hasId = !!document.getElementById("kgId").value;
  document
    .getElementById("kgBtnDelete")
    .classList.toggle("d-none", !(isView && hasId));
}

function loadSatuanKerja() {
  fetch("/master/satuan-kerja/table")
    .then((r) => r.json())
    .then((data) => {
      let html = '<option value="">Pilih</option>';
      data.forEach((d) => {
        html += `<option value="${d.id}">${d.nama_satuan_kerja}</option>`;
      });
      document.getElementById("kgSatuanKerja").innerHTML = html;
    });
}

function loadTable() {
  fetch(KG_URL.table)
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
    html = '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
  } else {
    slice.forEach((row, i) => {
      html += `<tr class="kg-row" data-id="${row.id}" data-nama="${row.nama_kegiatan}" data-sk="${row.id_satuan_kerja}">
<td>${start + i + 1}</td>
<td>${row.nama_kegiatan}</td>
<td>${row.nama_satuan_kerja || "-"}</td>
<td>${new Date().getFullYear()}</td>
</tr>`;
    });
  }

  document.getElementById("kgTableBody").innerHTML = html;
  renderInfo();
  renderPagination();
}

function renderInfo() {
  const total = rawData.length;
  const from = (currentPage - 1) * perPage + 1;
  const to = Math.min(currentPage * perPage, total);
  document.getElementById("kgInfo").innerText =
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
  document.getElementById("kgPagination").innerHTML = html;
}

function goPage(p) {
  currentPage = p;
  renderTable();
}

document.addEventListener("click", (e) => {
  const row = e.target.closest(".kg-row");
  if (row) {
    document.getElementById("kgId").value = row.dataset.id;
    document.getElementById("kgNama").value = row.dataset.nama;
    document.getElementById("kgSatuanKerja").value = row.dataset.sk || "";
    setMode("view");
    kgModal.show();
  }

  if (e.target.id === "btnTambah") {
    document.getElementById("kgId").value = "";
    document.getElementById("kgNama").value = "";
    document.getElementById("kgSatuanKerja").value = "";
    setMode("edit");
    kgModal.show();
  }

  if (e.target.id === "kgBtnEdit") {
    setMode("edit");
  }

  if (e.target.id === "kgBtnBatal") {
    setMode("view");
  }

  if (e.target.id === "kgBtnSimpan") {
    const id = document.getElementById("kgId").value;
    const nama = document.getElementById("kgNama").value;
    const sk = document.getElementById("kgSatuanKerja").value;

    if (!nama || !sk) {
      Swal.fire("Validasi", "Lengkapi semua field", "warning");
      return;
    }

    const url = id ? KG_URL.update(id) : KG_URL.store;

    fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `nama=${encodeURIComponent(nama)}&id_satuan_kerja=${sk}`,
    })
      .then((res) => {
        if (!res.ok) throw new Error();
        return res.json();
      })
      .then(() => {
        Swal.fire("Berhasil", "Data disimpan", "success");
        kgModal.hide();
        loadTable();
      })
      .catch(() => {
        Swal.fire("Error", "Gagal menyimpan data", "error");
      });
  }

  if (e.target.id === "kgBtnDelete") {
    const id = document.getElementById("kgId").value;
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

      fetch(KG_URL.delete(id), { method: "POST" })
        .then((res) => {
          if (!res.ok) throw new Error();
          return res.json();
        })
        .then(() => {
          Swal.fire("Berhasil", "Data berhasil dihapus", "success");
          kgModal.hide();
          loadTable();
        })
        .catch(() => {
          Swal.fire("Error", "Gagal menghapus data", "error");
        });
    });
  }

  if (e.target.id === "kgBtnClose") {
    kgModal.hide();
  }
});
