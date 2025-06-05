<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];

// Check if user owns the post or is admin
$stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
$stmt->execute([$postId]);
$post = $stmt->fetch();

if (!$post) {
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

// Get current user role
$userStmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$userStmt->execute([$_SESSION['user_id']]);
$user = $userStmt->fetch();

if ($post['user_id'] != $_SESSION['user_id'] && $user['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'You are not authorized to delete this post']);
    exit;
}

// Delete the post
$deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
if ($deleteStmt->execute([$postId])) {
    echo json_encode(['success' => true, 'message' => 'Post deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting post']);
}