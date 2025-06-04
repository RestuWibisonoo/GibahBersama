<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'])) {
    try {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi password baru
        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "Password baru dan konfirmasi password tidak cocok.";
            header("Location: setting.php?tab=password");
            exit();
        }

        if (strlen($new_password) < 8) {
            $_SESSION['error_message'] = "Password harus minimal 8 karakter.";
            header("Location: setting.php?tab=password");
            exit();
        }

        // Verifikasi password saat ini
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($current_password, $user['password'])) {
            $_SESSION['error_message'] = "Password saat ini salah.";
            header("Location: setting.php?tab=password");
            exit();
        }

        // Update password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success_message'] = "Password berhasil diubah!";
        header("Location: setting.php?tab=password");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
        header("Location: setting.php?tab=password");
        exit();
    }
}

// Jika akses langsung ke file ini tanpa POST request
header("Location: setting.php");
exit();
?>