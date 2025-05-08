<?php
session_start();
include "../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan bersihkan data input
    $name              = trim($_POST['name']);
    $username          = trim($_POST['username']);
    $email             = trim($_POST['email']);
    $password          = $_POST['password'];
    $confirm_password  = $_POST['confirm_password'];

    $errors = [];

    // Validasi data input
    if (empty($name))                     $errors['name'] = "Nama lengkap harus diisi";
    if (empty($username))                 $errors['username'] = "Username harus diisi";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Format email tidak valid";
    if (strlen($password) < 3)            $errors['password'] = "Password minimal 3 karakter";
    if ($password !== $confirm_password)  $errors['confirm_password'] = "Konfirmasi password tidak cocok";

    // Cek email sudah terdaftar
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) $errors['email'] = "Email sudah terdaftar";

    // Cek username sudah digunakan
    $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) $errors['username'] = "Username telah digunakan";

    // Jika terdapat error, kembalikan ke halaman signup
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        header("Location: signup.php");
        exit();
    }

    // Salin default.jpg ke file baru yang unik di folder yang sama
    $default_path    = "../assets/img/profile_pict/default.jpg";
    $target_dir      = "../assets/img/profile_pict/";
    $unique_filename = uniqid("profile_") . ".jpg";
    $target_path     = $target_dir . $unique_filename;

    if (!copy($default_path, $target_path)) {
        $_SESSION['error'] = "Gagal menyalin foto default.";
        header("Location: signup.php");
        exit();
    }

    // Siapkan data untuk disimpan ke database
    $profile_pic = $unique_filename; // hanya simpan nama file-nya
    $role        = "user";
    $created_at  = date('Y-m-d H:i:s');
    $updated_at  = date('Y-m-d H:i:s');

    // Simpan data ke tabel users
    $stmt = $pdo->prepare("INSERT INTO users 
        (username, email, password, profile_pic, role, created_at, updated_at, display_name) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt->execute([
        $username,
        $email,
        $password,
        $profile_pic,
        $role,
        $created_at,
        $updated_at,
        $name
    ])) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login";
        header("Location: login.php?from=proses");
        exit();
    } else {
        $_SESSION['error'] = "Gagal melakukan registrasi.";
        header("Location: signup.php");
        exit();
    }
}

// Jika akses langsung tanpa POST
header("Location: signup.php");
exit();
?>
