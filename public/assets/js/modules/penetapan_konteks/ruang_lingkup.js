document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formRuangLingkup");
  const timSelect = document.getElementById("rl_tim");
  const kegiatanSelect = document.getElementById("rl_kegiatan");

  if (!form) return;

  // =========================================
  // YEAR PICKER
  // =========================================
  $('input[name="tahun"]').datepicker({
    format: "yyyy",
    minViewMode: 2,
    autoHide: true,
    zIndex: 9999,
  });

  // =========================================
  // AUTO SET TIM OPERATOR
  // =========================================
  const user = window.APP_USER || {};

  if (user.role === "operator" && user.id_tim) {
    timSelect.value = user.id_tim;
    timSelect.setAttribute("disabled", true);

    loadKegiatan(user.id_tim);
  }

  // =========================================
  // ADMIN CHANGE TIM
  // =========================================
  timSelect.addEventListener("change", function () {
    const idTim = this.value;

    kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';

    if (!idTim) return;

    loadKegiatan(idTim);
  });

  // =========================================
  // LOAD KEGIATAN
  // =========================================
  async function loadKegiatan(idTim) {
    try {
      const response = await fetch(
        window.KONTEKS_CONFIG.url.getKegiatan(idTim),
        {
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
        },
      );

      const result = await response.json();

      kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';

      result.forEach((item) => {
        kegiatanSelect.innerHTML += `
        <option value="${item.id_kegiatan}">
          ${item.nama_kegiatan}
        </option>
      `;
      });
    } catch (err) {
      console.error("Gagal load kegiatan", err);
    }
  }

  // =========================================
  // SUBMIT CREATE DRAFT
  // =========================================
  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    try {
      const formData = new FormData(form);

      // disabled select tidak ikut terkirim
      if (timSelect.disabled) {
        formData.set("id_tim", timSelect.value);
      }

      formData.append(
        window.KONTEKS_CONFIG.csrf.name,
        window.KONTEKS_CONFIG.csrf.token,
        );
        
    const confirmResult = await Swal.fire({
      title: "Simpan ruang lingkup?",
      text: "Draft konteks akan dibuat dan dilanjutkan ke halaman konteks",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Ya, simpan",
      cancelButtonText: "Batal",
      reverseButtons: true,
      customClass: {
        popup: "swal-mantis",
      },
    });

    if (!confirmResult.isConfirmed) {
      return;
    }

      const response = await fetch(window.KONTEKS_CONFIG.url.createDraft, {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
      });

      const result = await response.json();

      if (result.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Berhasil",
          text: "Ruang lingkup berhasil disimpan",
          confirmButtonText: "Lanjut",
          customClass: {
            popup: "swal-mantis",
          },
        }).then(() => {
          window.location.href = `/penetapan-konteks/konteks/${result.id}`;
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Gagal",
          text: result.message || "Gagal menyimpan ruang lingkup",
          customClass: {
            popup: "swal-mantis",
          },
        });
      }
    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: "error",
        title: "Terjadi Kesalahan",
        text: "Tidak dapat menyimpan ruang lingkup",
        customClass: {
          popup: "swal-mantis",
        },
      });
    }
  });
});
