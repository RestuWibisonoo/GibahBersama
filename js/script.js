// Login Form Submission
document.addEventListener("DOMContentLoaded", function () {
    let loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let username = document.getElementById("username").value;
            let password = document.getElementById("password").value;
            
            if (username === "admin" && password === "password123") {
                alert("Login berhasil!");
                window.location.href = "index.html";
            } else {
                alert("Username atau password salah.");
            }
        });
    }
});

// Signup Form Validation
document.addEventListener("DOMContentLoaded", function () {
    let signupForm = document.getElementById("signupForm");
    if (signupForm) {
        signupForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirmPassword").value;

            if (password !== confirmPassword) {
                alert("Password tidak cocok!");
            } else {
                alert("Akun berhasil dibuat!");
                window.location.href = "login.html";
            }
        });
    }
});

// Forgot Password
document.addEventListener("DOMContentLoaded", function () {
    let forgotForm = document.getElementById("forgotForm");
    if (forgotForm) {
        forgotForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let email = document.getElementById("email").value;
            alert("Link reset password telah dikirim ke " + email);
        });
    }
});

// Search Functionality (Index Page)
document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("search");
    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            let filter = searchInput.value.toLowerCase();
            let discussions = document.querySelectorAll(".discussion-item");

            discussions.forEach(function (item) {
                let title = item.querySelector("h3").innerText.toLowerCase();
                if (title.includes(filter)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }
});
