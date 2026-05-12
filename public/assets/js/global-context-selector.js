/* GLOBAL CONTEXT CONFIG */
const GC_URL = window.GC_CONFIG?.url || {};

let gcCsrfToken = window.GC_CONFIG?.csrf?.token || "";
const gcCsrfName = window.GC_CONFIG?.csrf?.name || "";

const GC_DEFAULT = window.GC_CONFIG?.default || {};

const GC_USER = window.GC_CONFIG?.user || {};

document.addEventListener("DOMContentLoaded", () => {
  initGlobalContext();
});

async function initGlobalContext() {
  bindEvents();

  const selectedTim = document.getElementById("ctx_tim").value;

  if (selectedTim) {
    await loadKegiatan(selectedTim, GC_DEFAULT.id_kegiatan);
  }
}

function bindEvents() {
  const tahun = document.getElementById("ctx_tahun");
  const tim = document.getElementById("ctx_tim");
  const kegiatan = document.getElementById("ctx_kegiatan");

  tahun.addEventListener("change", saveGlobalContext);

  tim.addEventListener("change", async function () {
    await loadKegiatan(this.value);

    document.getElementById("ctx_kegiatan").value = "";

    saveGlobalContext();
  });

  kegiatan.addEventListener("change", saveGlobalContext);
}

async function saveGlobalContext() {
  const tahun = document.getElementById("ctx_tahun").value;
  const idTim = document.getElementById("ctx_tim").value;
  const idKegiatan = document.getElementById("ctx_kegiatan").value;

  const formData = new FormData();

  formData.append("tahun", tahun);
  formData.append("id_tim", idTim);
  formData.append("id_kegiatan", idKegiatan);

  formData.append(gcCsrfName, gcCsrfToken);

  try {
    await fetch(GC_URL.set, {
      method: "POST",
      body: formData,
    });
  } catch (err) {
    console.error("Gagal menyimpan global context:", err);
  }
}

async function loadKegiatan(idTim, selectedKegiatan = "") {
  const kegiatanSelect = document.getElementById("ctx_kegiatan");

  kegiatanSelect.innerHTML = '<option value="">Semua Kegiatan</option>';

  if (!idTim) return;

  try {
    const response = await fetch(`${GC_URL.kegiatan}?id_tim=${idTim}`);

    const data = await response.json();

    data.forEach((item) => {
      const option = document.createElement("option");

      option.value = item.id_kegiatan;
      option.textContent = item.nama_kegiatan;

      if (String(selectedKegiatan) === String(item.id_kegiatan)) {
        option.selected = true;
      }

      kegiatanSelect.appendChild(option);
    });
  } catch (err) {
    console.error("Gagal load kegiatan:", err);
  }
}

async function resetGlobalContext() {
  document.getElementById("ctx_tahun").value = new Date().getFullYear();

  document.getElementById("ctx_tim").value = GC_USER.id_tim;

  await loadKegiatan(GC_USER.id_tim);

  document.getElementById("ctx_kegiatan").value = "";

  saveGlobalContext();
}
