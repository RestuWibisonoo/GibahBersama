<?php
session_start();
require_once '../config/koneksi.php';

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ambil input password
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi input
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            throw new Exception("Semua kolom password harus diisi");
        }

        if ($new_password !== $confirm_password) {
            throw new Exception("Password baru tidak cocok");
        }

        if (strlen($new_password) < 8) {
            throw new Exception("Password minimal 8 karakter");
        }

        // Ambil password saat ini dari database
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            throw new Exception("User tidak ditemukan");
        }

        // Verifikasi password saat ini (tanpa hashing)
        if ($current_password !== $user['password']) {
            throw new Exception("Password saat ini salah");
        }

        // Update password baru (tanpa hashing)
        $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        if (!$update_stmt->execute([$new_password, $user_id])) {
            throw new Exception("Gagal mengupdate password");
        }

        $_SESSION['success_message'] = "Password berhasil diubah!";
        header("Location: settings.php?tab=password");
        exit();

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: settings.php?tab=password");
        exit();
    }
}

header("Location: settings.php");
exit();
?>