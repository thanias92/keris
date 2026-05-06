document.addEventListener("DOMContentLoaded", function () {
  const typeEl = document.getElementById("plCsType");
  const single = document.getElementById("plSingle");
  const range = document.getElementById("plRange");
  const startEl = document.getElementById("plStart");
  const endEl = document.getElementById("plEnd");
  const periodeEl = document.getElementById("plCsPeriode");

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
      s.setMonth(s.getMonth() + 2);
      endEl.max = s.toISOString().slice(0, 7);
    });

    endEl.addEventListener("change", function () {
      if (!startEl.value || !endEl.value) return;
      const s = new Date(startEl.value);
      const e = new Date(endEl.value);
      const diff =
        (e.getFullYear() - s.getFullYear()) * 12 +
        (e.getMonth() - s.getMonth());
      if (diff < 0) {
        alert("Range tidak valid");
        endEl.value = "";
        endEl.type = "text";
        return;
      }
      if (diff > 2) {
        alert("Maksimal 3 bulan berturut-turut");
        endEl.value = "";
        endEl.type = "text";
      }
    });
  }

  toggleMode();
});
