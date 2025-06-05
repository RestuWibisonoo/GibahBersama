<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit(json_encode(['success' => false, 'message' => 'Unauthorized - Please login first']));
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

// Get and validate input
$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid JSON input']));
}

$postId = filter_var($input['postId'] ?? null, FILTER_VALIDATE_INT);
$action = $input['action'] ?? '';

if (!$postId || $postId < 1 || !in_array($action, ['add', 'remove'])) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid request parameters']));
}

try {
    $userId = $_SESSION['user_id'];
    
    // Check if post exists
    $stmt = $pdo->prepare("SELECT id FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        exit(json_encode(['success' => false, 'message' => 'Post not found']));
    }
    
    if ($action === 'add') {
        // Check if already bookmarked
        $stmt = $pdo->prepare("SELECT id FROM bookmarks WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$userId, $postId]);
        if ($stmt->fetch()) {
            exit(json_encode(['success' => true, 'message' => 'Already bookmarked']));
        }
        
        $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$userId, $postId]);
    } else {
        $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$userId, $postId]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Bookmark updated']);
} catch (PDOException $e) {
    error_log("Bookmark error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}