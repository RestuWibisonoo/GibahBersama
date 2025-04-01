<?php
session_start();
include "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username harus diisi";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }

    if (strlen($password) < 3) { // Password minimal 3 karakter
        $errors[] = "Password minimal 3 karakter";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Konfirmasi password tidak cocok";
    }

    // Cek email sudah terdaftar
    $stmt = $koneksi->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Email sudah terdaftar";
    }

    // Jika ada error
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: signup.php");
        exit();
    }

    // Set nilai default
    $profile_pic = "default.jpg";
    $role = "user";
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Insert ke database TANPA HASHING
    $stmt = $koneksi->prepare("INSERT INTO users 
        (username, email, password, profile_pic, role, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        
    $stmt->bind_param("sssssss", 
        $username,
        $email,
        $password, // Password disimpan plaintext
        $profile_pic,
        $role,
        $created_at,
        $updated_at
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login";
        header("Location: login.php?from=proses"); // Tambahkan parameter
        exit();
    } else {
        $_SESSION['error'] = "Gagal melakukan registrasi: " . $stmt->error;
        header("Location: signup.php");
    }

    $stmt->close();
    exit();
}

// Jika akses langsung ke file
header("Location: signup.php");
exit();
?>