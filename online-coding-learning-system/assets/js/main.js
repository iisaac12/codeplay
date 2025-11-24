// assets/js/main.js

document.addEventListener("DOMContentLoaded", () => {
  // Mobile nav toggle
  const navToggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".app-nav, .nav");
  if (navToggle && nav) {
    navToggle.addEventListener("click", () => {
      nav.classList.toggle("open");
    });
  }

  // Modal close buttons
  document.querySelectorAll("[data-close]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".modal");
      if (modal) {
        modal.classList.remove("open");
        modal.setAttribute("aria-hidden", "true");
      }
    });
  });

  // Toast notifications (global trigger)
  const toast = document.getElementById("toast");
  if (toast) {
    window.showToast = (message, type = "success") => {
      toast.querySelector("span").textContent = message;
      toast.classList.add("show");
      setTimeout(() => toast.classList.remove("show"), 2500);
    };
  }
});
