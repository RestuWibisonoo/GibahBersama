<?php
session_start();
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    // Cek apakah email terdaftar
    $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password (jika menggunakan password_hash())
        // if (password_verify($password, $user['password'])) {
        
        // Jika masih menggunakan plaintext (tidak direkomendasikan)
        if ($password === $user['password']) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            // Redirect ke halaman home
            header("Location: home.php");
            exit();
        }
    }

    // Jika gagal login
    $_SESSION['login_error'] = "Email atau password salah!";
    header("Location: login.php");
    exit();
}

// Jika akses langsung ke file
header("Location: login.php");
exit();
?>