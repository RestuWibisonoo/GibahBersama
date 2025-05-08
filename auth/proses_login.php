<?php
session_start();
include "../config/koneksi.php"; // Pastikan koneksi.php benar di-include

// Pastikan form diakses dengan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

// Validasi email dan password yang diterima dari form
if (empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['login_error'] = "Email dan password harus diisi!";
    header("Location: login.php");
    exit();
}

// Ambil email dan password dari form
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Cek apakah email terdaftar
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Cek jika hasilnya ada satu baris (user ditemukan)
    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Bandingkan password yang diterima dengan password yang disimpan (plain text)
        if ($password === $user['password']) {
            // Set session jika login berhasil
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            // Redirect ke halaman home setelah login berhasil
            header("Location: ../home/home.php");
            exit();
        } else {
            // Jika password salah
            $_SESSION['login_error'] = "Email atau password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Jika email tidak ditemukan
        $_SESSION['login_error'] = "Email atau password salah!";
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    // Jika ada kesalahan query, tampilkan pesan error
    $_SESSION['login_error'] = "Terjadi kesalahan: " . $e->getMessage();
    header("Location: login.php");
    exit();
}
?>
