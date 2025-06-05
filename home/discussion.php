<?php
session_start();
require_once '../config/koneksi.php';

// Redirect ke error.php jika post_id tidak valid
if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    header("Location: error.php?code=400&message=ID postingan tidak valid");
    exit();
}

$post_id = (int) $_GET['post_id'];

try {
    // Ambil data post dan user pembuat
    $stmt = $pdo->prepare("
        SELECT posts.*, users.username, users.display_name, users.profile_pic 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = :post_id
    ");
    $stmt->execute(['post_id' => $post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        header("Location: error.php?code=404&message=Postingan tidak ditemukan");
        exit();
    }

    // Update view count
    $update_stmt = $pdo->prepare("UPDATE posts SET views = views + 1 WHERE id = :post_id");
    $update_stmt->execute(['post_id' => $post_id]);

    // Ambil semua jawaban untuk post ini
    $stmt = $pdo->prepare("
        SELECT answers.*, users.username, users.display_name, users.profile_pic 
        FROM answers 
        JOIN users ON answers.user_id = users.id 
        WHERE answers.post_id = :post_id
        ORDER BY answers.created_at ASC
    ");
    $stmt->execute(['post_id' => $post_id]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get current user data if logged in
    $current_user = null;
    if (isset($_SESSION['username'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get trending posts (same as home)
    $trending_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name, users.profile_pic
                                  FROM posts 
                                  JOIN users ON posts.user_id = users.id 
                                  ORDER BY posts.views DESC LIMIT 5");
    $trending_stmt->execute();
    $trending_posts = $trending_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    header("Location: error.php?code=500&message=Terjadi kesalahan pada server");
    exit();
}

$page_title = htmlspecialchars($post['title']) . " - Diskusi";
include('../includes/header.php');
?>

<!-- Main Content -->
<div class="flex p-4 space-x-4">
    <!-- Questions and Replies -->
    <div class="w-2/3 bg-white p-6 rounded-lg shadow space-y-4">
        <!-- Post Content -->
        <div class="border-b border-gray-300 pb-4">
            <div class="flex items-center space-x-3 mb-2">
                <img src="../assets/img/profile_pict/<?= htmlspecialchars($post['profile_pic'] ?? 'default.jpg') ?>"
                    class="w-10 h-10 rounded-full" alt="User profile"
                    onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                <div>
                    <p class="font-bold"><?= htmlspecialchars($post['display_name']) ?></p>
                    <p class="text-sm text-gray-500">@<?= htmlspecialchars($post['username']) ?></p>
                </div>
            </div>
            <h1 class="text-xl font-semibold"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <?php if (!empty($post['image'])): ?>
                <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post Image"
                    class="rounded-lg mt-3 max-w-full h-auto">
            <?php endif; ?>
        </div>

        <!-- Jawaban -->
        <div class="space-y-6" id="answers-container">
            <h2 class="text-lg font-semibold">Answer (<?= count($answers) ?>)</h2>
            <?php if (count($answers) > 0): ?>
                <?php foreach ($answers as $answer): ?>
                    <div class="border-t pt-4">
                        <div class="flex items-center space-x-3 mb-2">
                            <img src="../assets/img/profile_pict/<?= htmlspecialchars($answer['profile_pic'] ?? 'default.jpg') ?>"
                                class="w-10 h-10 rounded-full" alt="User profile"
                                onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                            <div>
                                <p class="font-semibold"><?= htmlspecialchars($answer['display_name']) ?></p>
                                <p class="text-sm text-gray-500">@<?= htmlspecialchars($answer['username']) ?> -
                                    <?= date('d M Y H:i', strtotime($answer['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-800"><?= nl2br(htmlspecialchars($answer['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">Belum ada jawaban. Jadilah yang pertama menjawab!</p>
            <?php endif; ?>
        </div>
        <!-- Form Jawaban -->
        <div class="border-t pt-4 sticky bottom-0 bg-white">
            <?php if (isset($_SESSION['user_id'])): ?>
                <form id="answerForm" method="POST" class="space-y-2" onsubmit="submitAnswer(event)">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <textarea name="content" rows="2" class="w-full border rounded p-2 text-sm"
                        placeholder="Tulis jawaban kamu..." required></textarea>
                    <div id="answerMessage" class="hidden"></div>
                    <button type="submit"
                        class="px-4 py-2 border border-gray-300 text-gray-800 rounded-full flex items-center bg-transparent hover:bg-gray-100">
                        <img src="../assets/img/icons/outline/write.png" alt="Pen Icon" class="mr-2 w-4 h-4">
                        Answer
                    </button>
                </form>
            <?php else: ?>
                <p class="text-gray-600 text-sm">
                    Silakan <a href="../auth/login.php" class="text-purple-600 hover:underline">login</a>
                    untuk menjawab diskusi ini.
                </p>
            <?php endif; ?>
        </div>
    </div>


    <!-- Trending Section -->
    <div class="w-1/3">
        <div class="trending-card bg-white p-4 rounded-lg shadow-lg sticky top-4">
            <h2 class="font-bold text-xl mb-4">Trending Discussions</h2>
            <div class="space-y-3">
                <?php foreach ($trending_posts as $trending_post): ?>
                    <a href="discussion.php?post_id=<?= $trending_post['id'] ?>"
                        class="block hover:bg-gray-50 p-3 rounded-lg transition">
                        <p class="font-bold text-gray-800"><?= htmlspecialchars($trending_post['title']) ?></p>
                        <p class="text-gray-500 text-sm"><?= $trending_post['views'] ?> views •
                            <?= date('M j', strtotime($trending_post['created_at'])) ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function submitAnswer(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const messageDiv = document.getElementById('answerMessage');

        fetch('proses_answer.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan pesan sukses
                    messageDiv.innerHTML = `
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                            ${data.message}
                        </div>
                    `;
                    messageDiv.classList.remove('hidden');

                    // Reset form
                    form.reset();

                    // Reload halaman setelah 1 detik
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    // Tampilkan pesan error
                    messageDiv.innerHTML = `
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                            ${data.message}
                        </div>
                    `;
                    messageDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                messageDiv.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                        Terjadi kesalahan jaringan
                    </div>
                `;
                messageDiv.classList.remove('hidden');
            });
    }
</script>

<?php include('../includes/footer.php'); ?>