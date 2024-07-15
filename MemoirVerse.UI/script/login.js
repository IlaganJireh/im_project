document.addEventListener("DOMContentLoaded", function () {
  document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault();

    let emailInput = document.querySelector('input[type="email"]');
    let passwordInput = document.querySelector('input[type="password"]');

    if (emailInput.value.trim() === "") {
      alert("Please enter your email.");
      return;
    }
    if (passwordInput.value.trim() === "") {
      alert("Please enter your password.");
      return;
    }

    this.submit();
  });
});