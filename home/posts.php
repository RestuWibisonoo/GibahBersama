<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/koneksi.php';

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "Pengguna tidak ditemukan!";
        header("Location: ../auth/login.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Terjadi kesalahan saat mengambil data pengguna: " . $e->getMessage();
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SpeakUp! Buat Postingan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-white min-h-screen flex items-center justify-center">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']); ?>
            <?php unset($_SESSION['success']); ?>
        </div>
        <script>
            window.parent.postMessage({ type: 'POST_CREATED', success: true }, '*');
        </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($_SESSION['error']); ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="../home/proses_posts.php" class="absolute inset-0 bg-white p-6 flex flex-col" enctype="multipart/form-data">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-4">
                <img src="../assets/img/profile_pict/<?= htmlspecialchars($user['profile_pic'] ?? 'default.jpg') ?>"
                    class="w-10 h-10 rounded-full" alt="User profile"
                    onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                <h2 class="text-lg font-semibold">Apa Yang Ingin Anda Diskusikan?</h2>
            </div>
            <button type="button" onclick="window.parent.postMessage({type: 'CLOSE_POPUP'}, '*')" 
                    class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <input name="title"
            class="w-full bg-transparent border-b border-gray-300 focus:outline-none py-2 text-lg font-medium"
            placeholder="Judul Diskusi" type="text" required
            value="<?= isset($_SESSION['old_title']) ? htmlspecialchars($_SESSION['old_title']) : '' ?>" />
        <?php unset($_SESSION['old_title']); ?>

        <textarea name="content"
            class="mt-4 w-full bg-transparent border-b border-gray-300 focus:outline-none py-2 h-64"
            placeholder="Apa Yang Ingin Anda Diskusikan?"
            required><?= isset($_SESSION['old_content']) ? htmlspecialchars($_SESSION['old_content']) : '' ?></textarea>
        <?php unset($_SESSION['old_content']); ?>

        <div class="flex justify-between items-center border-t pt-4 mt-auto">
            <div class="flex space-x-4 text-gray-500">
                <label for="image-upload" class="p-3 rounded-full hover:bg-gray-200 cursor-pointer">
                    <img src="../assets/img/icons/outline/add-image.png" alt="Add Images" class="w-6 h-6" />
                    <input id="image-upload" type="file" name="image" accept="image/*" class="hidden" />
                </label>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="../assets/img/icons/outline/smile.png" alt="Smile" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="../assets/img/icons/outline/gift.png" alt="Gift" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="../assets/img/icons/outline/location.png" alt="Location" class="w-6 h-6" />
                </a>
            </div>
            <div class="flex space-x-4">
                <button type="button" class="text-gray-500">Draft</button>
                <button type="submit" name="submit"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-400 transition">Post</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageUpload = document.getElementById('image-upload');
            if (imageUpload) {
                imageUpload.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        // Image preview functionality can be added here
                    }
                });
            }
        });
    </script>
</body>
</html>