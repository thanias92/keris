document.addEventListener("DOMContentLoaded", function () {
  const offcanvasEl = document.getElementById("offcanvasProsesBisnis");
  if (!offcanvasEl) return;

  // Reset tombol saat load
  document.getElementById("pbBtnView").style.display = "none";
  document.getElementById("pbBtnEdit").style.display = "none";

  // Hide tombol + Proses kalau sudah ada data
  const hasExistingData =
    document.querySelectorAll('#pbFormSync input[type="checkbox"]:checked')
      .length > 0;

  if (hasExistingData) {
    const btnAdd = document.querySelector(
      '[data-bs-target="#offcanvasProsesBisnis"]',
    );
    if (btnAdd) btnAdd.style.display = "none";
  }

  function hasData() {
    return (
      document.querySelectorAll('#pbFormSync input[type="checkbox"]:checked')
        .length > 0
    );
  }

  function setCreateMode() {
    document
      .querySelectorAll('#pbFormSync input[type="checkbox"]')
      .forEach((el) => (el.disabled = false));
    document.getElementById("pbBtnView").style.display = "none";
    document.getElementById("pbBtnEdit").style.display = "flex";
  }

  function setViewMode() {
    document
      .querySelectorAll('#pbFormSync input[type="checkbox"]')
      .forEach((el) => (el.disabled = true));
    document.getElementById("pbBtnView").style.display = "flex";
    document.getElementById("pbBtnEdit").style.display = "none";
  }

  function setEditMode() {
    document
      .querySelectorAll('#pbFormSync input[type="checkbox"]')
      .forEach((el) => (el.disabled = false));
    document.getElementById("pbBtnView").style.display = "none";
    document.getElementById("pbBtnEdit").style.display = "flex";
  }

  let originalChecked = [];

  // Saat offcanvas dibuka
  offcanvasEl.addEventListener("show.bs.offcanvas", () => {
    originalChecked = Array.from(
      document.querySelectorAll('#pbFormSync input[type="checkbox"]:checked'),
    ).map((el) => el.value);

    if (hasData()) {
      setViewMode();
    } else {
      setCreateMode();
    }
  });

  // Row click → buka offcanvas view mode
  document
    .querySelectorAll("#pkProsesBisnisTableWrapper tbody tr")
    .forEach((row) => {
      row.style.cursor = "pointer";
      row.addEventListener("click", () => {
        new bootstrap.Offcanvas(offcanvasEl).show();
      });
    });

  document
    .getElementById("pbBtnSwitchEdit")
    ?.addEventListener("click", () => setEditMode());

  document.getElementById("pbBtnCancelEdit")?.addEventListener("click", () => {
    document
      .querySelectorAll('#pbFormSync input[type="checkbox"]')
      .forEach((el) => {
        el.checked = originalChecked.includes(el.value);
      });
    if (originalChecked.length > 0) {
      setViewMode();
    } else {
      setCreateMode();
    }
  });

  document
    .getElementById("pbBtnSimpan")
    ?.addEventListener("click", function () {
      const form = document.getElementById("pbFormSync");
      const params = new URLSearchParams(new FormData(form));

      PkAlert.confirm({ text: "Simpan perubahan proses bisnis ini?" }).then(
        (result) => {
          if (!result.isConfirmed) return;

          PkAjax.post({
            url: "/penetapan-konteks/proses-bisnis/sync",
            data: params.toString(),
            onSuccess(res) {
              if (res.status !== "success") return;
              bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide();
              PkAlert.toast({ text: res.message, icon: "success" });
              refreshTable();
            },
          });
        },
      );
    });

  document
    .getElementById("pbBtnDelete")
    ?.addEventListener("click", function () {
      PkAlert.warning({
        title: "Hapus semua proses bisnis?",
        text: "Semua proses bisnis pada konteks ini akan dihapus.",
        confirmText: "Hapus",
      }).then((result) => {
        if (!result.isConfirmed) return;

        const idKonteks = document.querySelector(
          '#pbFormSync input[name="id_konteks"]',
        ).value;

        PkAjax.post({
          url: "/penetapan-konteks/proses-bisnis/sync",
          data: `id_konteks=${idKonteks}`,
          onSuccess(res) {
            if (res.status !== "success") return;
            bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide();
            PkAlert.toast({
              text: "Semua proses bisnis berhasil dihapus.",
              icon: "success",
            });
            refreshTable();

            // Tampilkan kembali tombol + Proses
            const btnAdd = document.querySelector(
              '[data-bs-target="#offcanvasProsesBisnis"]',
            );
            if (btnAdd) btnAdd.style.display = "";
          },
        });
      });
    });

  function refreshTable() {
    PkAjax.get({
      url: "/penetapan-konteks/proses-bisnis/table",
      onSuccess(html) {
        $("#pkProsesBisnisTableWrapper").html(html);

        // Re-bind row click setelah refresh
        document
          .querySelectorAll("#pkProsesBisnisTableWrapper tbody tr")
          .forEach((row) => {
            row.style.cursor = "pointer";
            row.addEventListener("click", () => {
              new bootstrap.Offcanvas(offcanvasEl).show();
            });
          });
      },
    });
  }
});
