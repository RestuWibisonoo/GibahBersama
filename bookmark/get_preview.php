<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('<p class="text-gray-500">Please login to view bookmarks</p>');
}

$userId = $_SESSION['user_id'];
$limit = 3;

try {
    $stmt = $pdo->prepare("
        SELECT posts.id, posts.title, users.username 
        FROM bookmarks
        JOIN posts ON bookmarks.post_id = posts.id
        JOIN users ON posts.user_id = users.id
        WHERE bookmarks.user_id = ?
        ORDER BY bookmarks.created_at DESC
        LIMIT ?
    ");
    $stmt->execute([$userId, $limit]);
    $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($bookmarks)) {
        echo '<p class="text-gray-500">No bookmarks yet</p>';
    } else {
        foreach ($bookmarks as $bookmark) {
            echo '<a href="../discussion.php?post_id='.$bookmark['id'].'" class="block hover:bg-gray-50 p-2 rounded">';
            echo '<p class="font-medium truncate">'.htmlspecialchars($bookmark['title']).'</p>';
            echo '<p class="text-gray-500 text-sm">@'.htmlspecialchars($bookmark['username']).'</p>';
            echo '</a>';
        }
    }
} catch (PDOException $e) {
    error_log("Bookmark preview error: " . $e->getMessage());
    echo '<p class="text-gray-500">Error loading bookmarks</p>';
}