<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You need to login first']);
    exit;
}

require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
$content = trim($_POST['content'] ?? '');
$user_id = $_SESSION['user_id'];

if (!$post_id || $post_id < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid post ID']);
    exit;
}

if (empty($content)) {
    echo json_encode(['status' => 'error', 'message' => 'Answer content cannot be empty']);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO answers (post_id, user_id, content, created_at) 
                           VALUES (:post_id, :user_id, :content, NOW())");
    $stmt->execute([
        ':post_id' => $post_id,
        ':user_id' => $user_id,
        ':content' => $content
    ]);

    $answer_id = $pdo->lastInsertId();

    $post_owner_stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = :post_id");
    $post_owner_stmt->execute([':post_id' => $post_id]);
    $post_owner = $post_owner_stmt->fetch();

    if ($post_owner && $post_owner['user_id'] != $user_id) {
        $notif_stmt = $pdo->prepare("INSERT INTO notifications 
            (user_id, actor_id, type, target_id, created_at) 
            VALUES (:user_id, :actor_id, 'answer', :target_id, NOW())");
        $notif_stmt->execute([
            ':user_id' => $post_owner['user_id'],
            ':actor_id' => $user_id,
            ':target_id' => $post_id
        ]);
    }

    $pdo->commit();

    echo json_encode(['status' => 'success', 'message' => 'Answer posted', 'answer_id' => $answer_id]);
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log('Error posting answer: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Failed to post answer']);
}
