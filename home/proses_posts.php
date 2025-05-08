<?php
session_start();

// Include database connection
require_once '../config/koneksi.php';

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Anda harus login terlebih dahulu';
    header('Location: posts.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Simpan input lama jika gagal
    $_SESSION['old_title'] = $title;
    $_SESSION['old_content'] = $content;

    if (empty($title) || empty($content)) {
        $_SESSION['error'] = 'Harap isi semua field';
        header('Location: posts.php');
        exit();
    }

    $image = NULL;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_path = '../uploads/' . $image_name;

        $check = getimagesize($image_tmp_name);
        if ($check !== false) {
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $image = $image_name;
            } else {
                $_SESSION['error'] = 'Gagal mengupload gambar.';
                header('Location: posts.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'File yang diupload bukan gambar.';
            header('Location: posts.php');
            exit();
        }
    }

    try {
        $query = "INSERT INTO posts (user_id, title, content, image, created_at, updated_at) 
                  VALUES (:user_id, :title, :content, :image, NOW(), NOW())";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        if ($stmt->execute()) {
            unset($_SESSION['old_title'], $_SESSION['old_content']);
            $_SESSION['success'] = 'Posting berhasil disimpan';
        } else {
            $_SESSION['error'] = 'Gagal menyimpan posting';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
    }

    // Kembali ke posts.php agar bisa ditangani oleh popup
    header('Location: posts.php');
    exit();
} else {
    $_SESSION['error'] = 'Request tidak valid';
    header('Location: posts.php');
    exit();
}
?>
