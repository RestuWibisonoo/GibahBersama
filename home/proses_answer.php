<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['content'])) {
    $post_id = (int)$_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    if ($content !== '') {
        $stmt = $pdo->prepare("INSERT INTO answers (post_id, user_id, content, created_at) VALUES (:post_id, :user_id, :content, NOW())");
        $stmt->execute([
            'post_id' => $post_id,
            'user_id' => $user_id,
            'content' => $content
        ]);
    }

    header("Location: discussion.php?post_id=$post_id");
    exit();
} else {
    header('Location: home.php');
    exit();
}
