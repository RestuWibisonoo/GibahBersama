<?php
// delete_post.php
session_start();
require_once __DIR__.'/../config/koneksi.php';

header('Content-Type: application/json');

// Validasi session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

// Validasi input
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$postId = isset($input['postId']) ? (int)$input['postId'] : 0;

if ($postId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid post ID']);
    exit;
}

try {
    // Mulai transaction
    $pdo->beginTransaction();

    // 1. Cek kepemilikan post
    $stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();

    if (!$post) {
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
        exit;
    }

    // 2. Cek role user
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($post['user_id'] != $_SESSION['user_id'] && $user['role'] != 'admin') {
        echo json_encode(['status' => 'error', 'message' => 'Permission denied']);
        exit;
    }

    // 3. Hapus bookmark terkait terlebih dahulu (optional, cascade seharusnya sudah menangani)
    $pdo->prepare("DELETE FROM bookmarks WHERE post_id = ?")->execute([$postId]);

    // 4. Hapus answers terkait (optional, cascade seharusnya sudah menangani)
    $pdo->prepare("DELETE FROM answers WHERE post_id = ?")->execute([$postId]);

    // 5. Baru hapus post
    $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $deleteStmt->execute([$postId]);

    // Commit transaction jika semua berhasil
    $pdo->commit();

    echo json_encode(['status' => 'success', 'message' => 'Post deleted successfully']);
    
} catch (PDOException $e) {
    // Rollback jika ada error
    $pdo->rollBack();
    error_log("Delete post error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    error_log("Delete post general error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred']);
}