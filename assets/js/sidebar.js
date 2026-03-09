document.addEventListener("DOMContentLoaded", function () {
  const currentUrl = window.location.href;
  const submenu = document.getElementById("submenu-manajemen-risiko");

  if (!submenu) return;

  const links = submenu.querySelectorAll("a");

  links.forEach(link => {
    if (currentUrl.includes(link.getAttribute("href"))) {
      submenu.classList.add("show");

      const trigger = document.querySelector(
        '[data-bs-target="#submenu-manajemen-risiko"]'
      );

      trigger.classList.remove("collapsed");
      trigger.setAttribute("aria-expanded", "true");

      link.classList.add("active");
    }
  });
});
