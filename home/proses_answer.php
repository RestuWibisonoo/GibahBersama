<?php
session_start();
require_once '../config/koneksi.php';

// Set header as JSON
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Silakan login untuk menjawab']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (!isset($_POST['post_id']) || !isset($_POST['content'])) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
        exit();
    }

    $post_id = (int)$_POST['post_id'];
    $user_id = (int)$_SESSION['user_id'];
    $content = trim($_POST['content']);

    // Validate content
    if (empty($content)) {
        echo json_encode(['success' => false, 'message' => 'Isi jawaban tidak boleh kosong']);
        exit();
    }

    // Validate post exists
    try {
        $stmt = $pdo->prepare("SELECT id FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Posting tidak ditemukan']);
            exit();
        }

        // Insert answer
        $insert_stmt = $pdo->prepare("INSERT INTO answers (post_id, user_id, content) VALUES (?, ?, ?)");
        $insert_stmt->execute([$post_id, $user_id, $content]);

        echo json_encode([
            'success' => true,
            'message' => 'Jawaban berhasil dikirim',
            'post_id' => $post_id
        ]);
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
}