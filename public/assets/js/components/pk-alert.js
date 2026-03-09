// ======================================================
// PK ALERT COMPONENT
// Wrapper SweetAlert2 untuk digunakan di semua modul
// ======================================================

const PkAlert = {
  confirm({
    title = "Konfirmasi",
    text,
    confirmText = "Ya",
    cancelText = "Batal",
    icon = "question",
    confirmColor = "#2f80ed",
  } = {}) {
    return Swal.fire({
      title,
      text,
      icon,
      showCancelButton: true,
      confirmButtonText: confirmText,
      cancelButtonText: cancelText,
      confirmButtonColor: confirmColor,
    });
  },

  success({ title = "Berhasil", text, confirmText = "Oke" } = {}) {
    return Swal.fire({
      title,
      text,
      icon: "success",
      confirmButtonText: confirmText,
      confirmButtonColor: "#2f80ed",
    });
  },

  error({
    title = "Gagal",
    text = "Terjadi kesalahan.",
    confirmText = "Oke",
  } = {}) {
    return Swal.fire({
      title,
      text,
      icon: "error",
      confirmButtonText: confirmText,
      confirmButtonColor: "#2f80ed",
    });
  },

  warning({
    title,
    text,
    confirmText = "Hapus",
    cancelText = "Batal",
    confirmColor = "#e53e3e",
  } = {}) {
    return Swal.fire({
      title,
      text,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: confirmText,
      cancelButtonText: cancelText,
      confirmButtonColor: confirmColor,
    });
  },
};
