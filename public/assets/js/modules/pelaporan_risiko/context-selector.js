document.addEventListener("DOMContentLoaded", function () {
  const typeEl = document.getElementById("plCsType");
  const single = document.getElementById("plSingle");
  const range = document.getElementById("plRange");
  const startEl = document.getElementById("plStart");
  const endEl = document.getElementById("plEnd");

  if (!typeEl) return;

  function setMonthPlaceholder(input, label) {
    input.addEventListener("focus", function () {
      input.type = "month";
    });
    input.addEventListener("blur", function () {
      if (!input.value) input.type = "text";
    });
    if (!input.value) {
      input.type = "text";
      input.placeholder = label;
    }
  }

  if (startEl) setMonthPlaceholder(startEl, "Pilih bulan awal");
  if (endEl) setMonthPlaceholder(endEl, "Pilih bulan akhir");

  function toggleMode() {
    const isRange = typeEl.value === "range";
    single.style.display = isRange ? "none" : "block";
    range.style.display = isRange ? "block" : "none";
  }

  typeEl.addEventListener("change", toggleMode);

  if (startEl && endEl) {
    startEl.addEventListener("change", function () {
      if (!startEl.value) return;
      const s = new Date(startEl.value);
      const exactEnd = new Date(s);
      exactEnd.setMonth(s.getMonth() + 2);
      const exactEndStr = exactEnd.toISOString().slice(0, 7);
      endEl.min = exactEndStr;
      endEl.max = exactEndStr;
      endEl.value = exactEndStr;
      endEl.type = "month";
    });

    endEl.addEventListener("change", function () {
      if (!startEl.value || !endEl.value) return;
      const s = new Date(startEl.value);
      const e = new Date(endEl.value);
      const diff =
        (e.getFullYear() - s.getFullYear()) * 12 +
        (e.getMonth() - s.getMonth());
      if (diff !== 2) {
        alert("Harus memilih rentang tepat 3 bulan");
        endEl.value = "";
        endEl.type = "text";
      }
    });
  }

  const timSelect = document.getElementById("plCsTimKerja");
  const pengelolaSelect = document.getElementById("plCsPengelola");

  if (timSelect && pengelolaSelect && window.PL_CS_DATA) {
    const konteksMap = window.PL_CS_DATA.konteksMap;

    function filterPengelola() {
      const selectedTim = timSelect.value;

      // simpan value lama
      const currentPengelola = pengelolaSelect.value;

      // reset
      pengelolaSelect.innerHTML =
        '<option value="">– Pilih Pengelola –</option>';

      const added = new Set();

      Object.values(konteksMap).forEach((item) => {
        if (
          item.id_tim == selectedTim &&
          item.pengelola_risiko_id &&
          !added.has(item.pengelola_risiko_id)
        ) {
          added.add(item.pengelola_risiko_id);

          const opt = document.createElement("option");
          opt.value = item.pengelola_risiko_id;
          opt.textContent = item.nama_pengelola;

          // restore selected value
          if (item.pengelola_risiko_id == currentPengelola) {
            opt.selected = true;
          }

          pengelolaSelect.appendChild(opt);
        }
      });
    }

    timSelect.addEventListener("change", filterPengelola);
    filterPengelola();
  }

  toggleMode();
});
