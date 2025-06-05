<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die('<script>alert("Silakan login untuk menjawab"); window.parent.postMessage({type: "CLOSE_POPUP"}, "*");</script>');
}

include '../config/koneksi.php';

$post_id = $_GET['post_id'] ?? 0;

// Validasi post_id
if (!is_numeric($post_id) || $post_id <= 0) {
    die('<script>alert("ID posting tidak valid"); window.parent.postMessage({type: "CLOSE_POPUP"}, "*");</script>');
}

// Ambil data post dan validasi keberadaan
try {
    $post_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name 
                               FROM posts 
                               JOIN users ON posts.user_id = users.id 
                               WHERE posts.id = ?");
    $post_stmt->execute([$post_id]);
    $post = $post_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        die('<script>alert("Posting tidak ditemukan"); window.parent.postMessage({type: "CLOSE_POPUP"}, "*");</script>');
    }

    // Ambil data user
    $user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $user_stmt->execute([$_SESSION['user_id']]);
    $current_user = $user_stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('<script>alert("Terjadi kesalahan database"); window.parent.postMessage({type: "CLOSE_POPUP"}, "*");</script>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawab Postingan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        textarea {
            resize: none;
            min-height: 150px;
        }
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
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="p-4">
    <div class="answer-container">
        <form id="answerForm" method="POST" class="flex flex-col h-full">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">

            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
                        class="w-10 h-10 rounded-full" alt="Profile"
                        onerror="this.onerror=null;this.src='https://placehold.co/40x40'">
                    <div>
                        <p class="font-semibold"><?= htmlspecialchars($current_user['display_name'] ?? 'User') ?></p>
                        <p class="text-gray-500 text-sm">@<?= htmlspecialchars($current_user['username']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Post being answered -->
            <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 mb-1">Menjawab:</p>
                <h3 class="font-medium"><?= htmlspecialchars($post['title']) ?></h3>
                <p class="text-sm text-gray-700 mt-1"><?= htmlspecialchars($post['content']) ?></p>
            </div>

            <!-- Answer content -->
            <textarea name="content"
                class="flex-grow w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tulis jawaban Anda di sini..."
                required><?= isset($_SESSION['old_answer']) ? htmlspecialchars($_SESSION['old_answer']) : '' ?></textarea>

            <!-- Error/Success Messages -->
            <div id="messageContainer" class="my-2"></div>

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
                    <button type="button" onclick="window.parent.postMessage({type: 'CLOSE_POPUP'}, '*')"
                        class="px-4 py-2 text-gray-700 mr-2 rounded-full hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors">
                        Kirim Jawaban
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('answerForm');
            const submitBtn = document.getElementById('submitBtn');
            const messageContainer = document.getElementById('messageContainer');
            const originalBtnText = submitBtn.innerHTML;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Disable button during submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Mengirim... <span class="btn-loading"></span>';
                messageContainer.innerHTML = '';

                try {
                    const formData = new FormData(form);
                    const response = await fetch('../home/proses_answer.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (!result.success) {
                        throw new Error(result.message || 'Gagal mengirim jawaban');
                    }

                    // Show success message
                    messageContainer.innerHTML = `
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            ${result.message || 'Jawaban berhasil dikirim!'}
                        </div>
                    `;

                    // Close popup after 1 second and refresh parent
                    setTimeout(() => {
                        window.parent.postMessage({
                            type: 'ANSWER_POSTED',
                            success: true,
                            post_id: <?= $post_id ?>
                        }, '*');
                        window.parent.postMessage({type: 'CLOSE_POPUP'}, '*');
                    }, 1000);

                } catch (error) {
                    console.error('Error:', error);
                    messageContainer.innerHTML = `
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            ${error.message || 'Terjadi kesalahan saat mengirim jawaban'}
                        </div>
                    `;
                    
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        });
    </script>
</body>
</html>