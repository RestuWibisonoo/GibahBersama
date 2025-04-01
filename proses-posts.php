<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Ambil data dari form
    $user_id = $_SESSION['user_id']; // Sesuaikan dengan session user yang login
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Validasi input
    if (empty($title) || empty($content)) {
        header("Location: posts.php?error=Harap isi semua field");
        exit();
    }
    
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, created_at, updated_at) 
                              VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
        
        // Bind parameters
        $stmt->bind_param("iss", $user_id, $title, $content);
        
        // Execute query
        if ($stmt->execute()) {
            header("Location: posts.php?success=Posting berhasil disimpan");
        } else {
            header("Location: posts.php?error=Gagal menyimpan posting");
        }
        
        $stmt->close();
    } catch (Exception $e) {
        header("Location: posts.php?error=Terjadi kesalahan: " . $e->getMessage());
    }
    
    $conn->close();
} else {
    header("Location: posts.php");
}
?>