<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = validateInput($_POST['username']);
        $display_name = validateInput($_POST['display_name']);
        $email = validateInput($_POST['email']);
        $bio = validateInput($_POST['bio'] ?? '');

        // Cek username unik
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username AND id != :user_id");
        $stmt->execute([':username' => $username, ':user_id' => $user_id]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Username already taken";
            header("Location: settings.php?tab=account");
            exit();
        }

        // Cek email unik
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :user_id");
        $stmt->execute([':email' => $email, ':user_id' => $user_id]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Email already registered";
            header("Location: settings.php?tab=account");
            exit();
        }

        // Handle upload gambar
        $profile_pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profile_pic'];
            
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if (!in_array($file['type'], $allowed_types)) {
                $_SESSION['error_message'] = "Only JPG, PNG, GIF images allowed";
                header("Location: settings.php?tab=account");
                exit();
            }
            
            if ($file['size'] > $max_size) {
                $_SESSION['error_message'] = "Image too large (max 2MB)";
                header("Location: settings.php?tab=account");
                exit();
            }
            
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $profile_pic = uniqid('profile_') . '.' . $ext;
            $upload_path = '../assets/img/profile_pict/' . $profile_pic;
            
            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                $_SESSION['error_message'] = "Failed to upload image";
                header("Location: settings.php?tab=account");
                exit();
            }
            
            // Hapus gambar lama jika bukan default
            $stmt = $pdo->prepare("SELECT profile_pic FROM users WHERE id = :user_id");
            $stmt->execute([':user_id' => $user_id]);
            $old_pic = $stmt->fetchColumn();
            
            if ($old_pic && $old_pic !== 'default.jpg' && file_exists('../assets/img/profile_pict/' . $old_pic)) {
                unlink('../assets/img/profile_pict/' . $old_pic);
            }
        }

        // Update database
        $update_data = [
            ':username' => $username,
            ':display_name' => $display_name,
            ':email' => $email,
            ':bio' => $bio,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE users SET 
                username = :username, 
                display_name = :display_name, 
                email = :email, 
                bio = :bio";

        if ($profile_pic) {
            $sql .= ", profile_pic = :profile_pic";
            $update_data[':profile_pic'] = $profile_pic;
        }

        $sql .= " WHERE id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($update_data);

        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: settings.php?tab=account");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Database error: " . $e->getMessage();
        header("Location: settings.php?tab=account");
        exit();
    }
}

header("Location: settings.php");
exit();
?>