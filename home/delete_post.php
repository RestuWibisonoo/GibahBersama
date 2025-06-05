<?php
// delete_post.php
session_start();
require_once __DIR__.'/../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$postId = filter_var($input['postId'] ?? null, FILTER_VALIDATE_INT);

if (!$postId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
    exit();
}

try {
    // Check if post exists and user has permission
    $stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();
    
    if (!$post) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Post not found']);
        exit();
    }
    
    // Check if user is owner or admin
    $userStmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $userStmt->execute([$_SESSION['user_id']]);
    $user = $userStmt->fetch();
    
    if ($post['user_id'] != $_SESSION['user_id'] && $user['role'] != 'admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Permission denied']);
        exit();
    }
    
    // Delete the post (cascade will handle related answers and bookmarks)
    $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $deleteStmt->execute([$postId]);
    
    echo json_encode(['success' => true, 'message' => 'Post deleted successfully']);
} catch (PDOException $e) {
    error_log("Delete post error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}