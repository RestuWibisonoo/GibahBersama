<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fungsi untuk validasi input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Tangani update akun
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    try {
        // Validasi input
        $username = validateInput($_POST['username']);
        $display_name = validateInput($_POST['display_name']);
        $email = validateInput($_POST['email']);
        $bio = validateInput($_POST['bio'] ?? '');

        // Cek apakah username sudah digunakan oleh user lain
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username AND id != :user_id");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Username sudah digunakan oleh user lain.";
            header("Location: setting.php?tab=account");
            exit();
        }

        // Cek apakah email sudah digunakan oleh user lain
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :user_id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Email sudah digunakan oleh user lain.";
            header("Location: setting.php?tab=account");
            exit();
        }

        // Handle upload gambar profil
        $profile_pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_pic'];
            
            // Validasi file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if (!in_array($file['type'], $allowed_types)) {
                $_SESSION['error_message'] = "Hanya file gambar (JPEG, PNG, GIF) yang diizinkan.";
                header("Location: setting.php?tab=account");
                exit();
            }
            
            if ($file['size'] > $max_size) {
                $_SESSION['error_message'] = "Ukuran file terlalu besar. Maksimal 2MB.";
                header("Location: setting.php?tab=account");
                exit();
            }
            
            // Generate nama file unik
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $profile_pic = uniqid('profile_') . '.' . $ext;
            $upload_path = '../assets/profile_pict/' . $profile_pic;
            
            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                $_SESSION['error_message'] = "Gagal mengupload gambar profil.";
                header("Location: setting.php?tab=account");
                exit();
            }
            
            // Hapus gambar lama jika bukan default
            $stmt = $pdo->prepare("SELECT profile_pic FROM users WHERE id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $old_pic = $stmt->fetchColumn();
            
            if ($old_pic && $old_pic !== 'default.jpg' && file_exists('../assets/profile_pict/' . $old_pic)) {
                unlink('../assets/profile_pict/' . $old_pic);
            }
        }

        // Update data user di database
        if ($profile_pic) {
            $stmt = $pdo->prepare("UPDATE users SET 
                                username = :username, 
                                display_name = :display_name, 
                                email = :email, 
                                bio = :bio, 
                                profile_pic = :profile_pic 
                                WHERE id = :user_id");
            $stmt->bindParam(':profile_pic', $profile_pic, PDO::PARAM_STR);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET 
                                username = :username, 
                                display_name = :display_name, 
                                email = :email, 
                                bio = :bio 
                                WHERE id = :user_id");
        }

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':display_name', $display_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success_message'] = "Perubahan berhasil disimpan!";
        header("Location: setting.php?tab=account");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
        header("Location: setting.php?tab=account");
        exit();
    }
}

// Jika akses langsung ke file ini tanpa POST request
header("Location: setting.php");
exit();
?>