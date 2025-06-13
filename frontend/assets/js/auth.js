document.addEventListener("DOMContentLoaded", function () {
  // LOGIN
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(loginForm);
      const data = Object.fromEntries(formData.entries());

      console.log("Logging in with:", data);

      const response = await fetch("http://localhost/hexashop/backend/public/v1/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
        credentials: "include"
      });

      const result = await response.json();
      if (!response.ok) {
        alert("Login failed: " + (result.message || "Unknown error"));
        return;
      }

      alert(result.message || "Login successful!");
      // window.location.href = "#home";
    });
  }

  // REGISTER
 /*  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      console.log("Registering with:", data);
      const formData = new FormData(registerForm);
      const data = Object.fromEntries(formData.entries());


      const response = await fetch("http://localhost/hexashop/backend/public/v1/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
        credentials: "include"
      });

      const result = await response.json();
      if (!response.ok) {
        alert("Registration failed: " + (result.message || "Unknown error"));
        return;
      }

      alert(result.message || "Registration successful!");
      // window.location.href = "#login";
    });
  } */
});
