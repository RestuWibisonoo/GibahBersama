<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi
        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "New passwords don't match";
            header("Location: settings.php?tab=password");
            exit();
        }

        if (strlen($new_password) < 8) {
            $_SESSION['error_message'] = "Password must be at least 8 characters";
            header("Location: settings.php?tab=password");
            exit();
        }

        // Verifikasi password saat ini
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :user_id AND status = 'active'");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current_password, $user['password'])) {
            $_SESSION['error_message'] = "Current password is incorrect";
            header("Location: settings.php?tab=password");
            exit();
        }

        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $stmt->execute([
            ':password' => $hashed_password,
            ':user_id' => $user_id
        ]);

        $_SESSION['success_message'] = "Password changed successfully!";
        header("Location: settings.php?tab=password");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Database error: " . $e->getMessage();
        header("Location: settings.php?tab=password");
        exit();
    }
}

header("Location: settings.php");
exit();
?>