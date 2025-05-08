<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('<script>alert("Please login to answer"); window.parent.closeAnswerPopup();</script>');
}

include '../config/koneksi.php';

$post_id = $_GET['post_id'] ?? 0;

$post_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name 
                           FROM posts 
                           JOIN users ON posts.user_id = users.id 
                           WHERE posts.id = ?");
$post_stmt->execute([$post_id]);
$post = $post_stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die('<script>alert("Post not found"); window.parent.closeAnswerPopup();</script>');
}

$user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->execute([$_SESSION['user_id']]);
$current_user = $user_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff; font-family: 'Inter', sans-serif; }
        textarea { resize: none; min-height: 150px; }
        .answer-container { display: flex; flex-direction: column; height: 100%; }
        .btn-loading::after {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-left: 8px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="p-4">
    <div class="answer-container">
        <form method="POST" id="answerForm" class="flex flex-col h-full">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <img src="<?= htmlspecialchars($current_user['profile_pic'] ?? 'https://placehold.co/40x40') ?>" 
                         class="w-10 h-10 rounded-full" alt="Profile">
                    <div>
                        <p class="font-semibold"><?= htmlspecialchars($current_user['display_name'] ?? 'User') ?></p>
                        <p class="text-gray-500 text-sm">@<?= htmlspecialchars($current_user['username']) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Post being answered -->
            <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 mb-1">Replying to:</p>
                <h3 class="font-medium"><?= htmlspecialchars($post['title']) ?></h3>
                <p class="text-sm text-gray-700 mt-1"><?= htmlspecialchars($post['content']) ?></p>
            </div>
            
            <!-- Answer content -->
            <textarea name="content" class="flex-grow w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                     placeholder="Write your answer here..." required></textarea>
            
            <!-- Footer -->
            <div class="flex justify-between items-center border-t pt-4 mt-4">
                <div class="flex space-x-3">
                    <button type="button" class="text-gray-500 hover:text-blue-500 p-2 rounded-full hover:bg-gray-100">
                        <i class="fas fa-image"></i>
                    </button>
                    <button type="button" class="text-gray-500 hover:text-blue-500 p-2 rounded-full hover:bg-gray-100">
                        <i class="fas fa-smile"></i>
                    </button>
                </div>
                <div>
                    <button type="button" onclick="window.parent.closeAnswerPopup()" 
                            class="px-4 py-2 text-gray-700 mr-2 rounded-full hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                            class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors">
                        Post Answer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('answerForm');
        const submitBtn = document.getElementById('submitBtn');
        const originalBtnText = submitBtn.innerHTML;
        
        const textarea = document.querySelector('textarea');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Posting <span class="btn-loading"></span>';
            
            try {
                const response = await fetch('proses_answer.php', {
                    method: 'POST',
                    body: new FormData(form)
                });
                const result = await response.json();
                
                if (result.status === 'success') {
                    window.parent.postMessage({
                        type: 'ANSWER_POSTED',
                        success: true,
                        post_id: <?= $post_id ?>
                    }, '*');
                } else {
                    alert(result.message || 'Failed to post answer');
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Network error occurred. Please try again.');
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    });
    </script>
</body>
</html>
