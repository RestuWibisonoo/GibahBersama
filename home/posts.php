<?php
session_start();

// Cek jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Terjadi kesalahan saat mengambil data pengguna: " . $e->getMessage();
    header("Location: login.php");
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
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 300px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex items-center justify-center">

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']); ?>
            <?php unset($_SESSION['success']); ?>
        </div>
        <script>
            // Kirim pesan ke parent untuk menutup popup dan refresh
            window.parent.postMessage({ type: 'POST_CREATED', success: true }, '*');
        </script>
    <?php endif; ?>


    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($_SESSION['error']); ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="proses_posts.php" class="absolute inset-0 bg-white p-6 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-4">
                <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
                    class="w-10 h-10 rounded-full" alt="User profile"
                    onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                <h2 class="text-lg font-semibold">Apa Yang Ingin Anda Diskusikan?</h2>
            </div>
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
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/add-image.png" alt="Add Images" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/smile.png" alt="Smile" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/gift.png" alt="Gift" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/location.png" alt="Location" class="w-6 h-6" />
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
            const form = document.getElementById('postForm');
            const submitBtn = document.getElementById('submitBtn');
            const originalBtnText = submitBtn.innerHTML;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Posting <span class="btn-loading"></span>';

                try {
                    const response = await fetch('proses_posts.php', {
                        method: 'POST',
                        body: new FormData(form)
                    });
                    const result = await response.json();

                    if (result.status === 'success') {
                        window.parent.postMessage({ type: 'POST_CREATED', success: true }, '*');
                    } else {
                        alert(result.message || 'Gagal menyimpan postingan');
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    alert('Terjadi kesalahan jaringan');
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            });
        });
    </script>


</body>

</html>