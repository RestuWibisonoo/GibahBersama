document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-form");

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        if (email === "" || password === "") {
            alert("Email dan password harus diisi!");
        } else {
            alert("Login berhasil! (Simulasi)");
            window.location.href = "index.html"; // Redirect ke dashboard
        }
    });
});
