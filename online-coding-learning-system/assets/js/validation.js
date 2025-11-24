// assets/js/validation.js

document.addEventListener("DOMContentLoaded", () => {
  const forms = document.querySelectorAll("form");

  forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      let valid = true;

      form.querySelectorAll("input[required]").forEach((input) => {
        const errorMsg = form.querySelector(`[data-error-for="${input.id}"]`);
        if (!input.value.trim()) {
          valid = false;
          if (errorMsg) errorMsg.textContent = "This field is required.";
        } else if (input.type === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
          valid = false;
          if (errorMsg) errorMsg.textContent = "Enter a valid email.";
        } else if (input.type === "password" && input.value.length < 8) {
          valid = false;
          if (errorMsg) errorMsg.textContent = "Password must be at least 8 characters.";
        } else {
          if (errorMsg) errorMsg.textContent = "";
        }
      });

      if (!valid) {
        e.preventDefault();
      }
    });
  });
});
