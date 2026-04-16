const PT_URL = window.PT_CONFIG?.url || {};
let ptModal = null;
let rawData = [];

document.addEventListener("DOMContentLoaded", () => {
  ptModal = bootstrap.Offcanvas.getOrCreateInstance(
    document.getElementById("ptForm"),
  );

  loadTable();
  loadDropdown();
});

function loadDropdown() {
  fetch("/master/satuan-kerja/table")
    .then((r) => r.json())
    .then((data) => {
      let html = '<option value="">Pilih</option>';
      data.forEach((d) => {
        html += `<option value="${d.id}">${d.nama_satuan_kerja}</option>`;
      });
      document.getElementById("ptSatuanKerja").innerHTML = html;
    });

  fetch("/master/pengelola/table")
    .then((r) => r.json())
    .then((data) => {
      let html = '<option value="">Pilih</option>';
      data.forEach((d) => {
        html += `<option value="${d.id}">${d.nama}</option>`;
      });
      document.getElementById("ptPengelola").innerHTML = html;
    });
}

function loadTable() {
  fetch(PT_URL.table)
    .then((r) => r.json())
    .then((data) => {
      rawData = data;
      render();
    });
}

function render() {
  let html = "";
  rawData.forEach((d, i) => {
    html += `<tr class="pt-row"
data-id="${d.id}"
data-p="${d.pengelola_id}"
data-sk="${d.satuan_kerja_id}"
data-t="${d.tahun}"
data-k="${d.is_ketua_tim}">
<td>${i + 1}</td>
<td>${d.nama_pengelola}</td>
<td>${d.nama_satuan_kerja}</td>
<td>${d.tahun}</td>
<td>${d.is_ketua_tim ? "✔" : ""}</td>
</tr>`;
  });
  document.getElementById("ptTableBody").innerHTML = html;
}

document.addEventListener("click", (e) => {
  if (e.target.closest(".pt-row")) {
    const r = e.target.closest(".pt-row");
    document.getElementById("ptId").value = r.dataset.id;
    document.getElementById("ptPengelola").value = r.dataset.p;
    document.getElementById("ptSatuanKerja").value = r.dataset.sk;
    document.getElementById("ptTahun").value = r.dataset.t;
    document.getElementById("ptKetua").checked = r.dataset.k === "true";
    ptModal.show();
  }

  if (e.target.id === "btnTambah") {
    document.getElementById("ptId").value = "";
    document.getElementById("ptPengelola").value = "";
    document.getElementById("ptSatuanKerja").value = "";
    document.getElementById("ptTahun").value = new Date().getFullYear();
    document.getElementById("ptKetua").checked = false;
    ptModal.show();
  }

  if (e.target.id === "ptBtnSimpan") {
    const id = document.getElementById("ptId").value;
    const body = new URLSearchParams({
      pengelola_id: document.getElementById("ptPengelola").value,
      satuan_kerja_id: document.getElementById("ptSatuanKerja").value,
      tahun: document.getElementById("ptTahun").value,
      is_ketua_tim: document.getElementById("ptKetua").checked ? 1 : 0,
    });

    fetch(id ? PT_URL.update(id) : PT_URL.store, {
      method: "POST",
      body,
    }).then(() => {
      Swal.fire("Berhasil", "", "success");
      ptModal.hide();
      loadTable();
    });
  }

  if (e.target.id === "ptBtnDelete") {
    fetch(PT_URL.delete(document.getElementById("ptId").value), {
      method: "POST",
    }).then(() => {
      ptModal.hide();
      loadTable();
    });
  }

  if (e.target.id === "ptBtnClose") ptModal.hide();
});
