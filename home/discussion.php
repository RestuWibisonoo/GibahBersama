<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../config/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: home.php");
    exit();
}

$post_id = (int) $_GET['id'];

// Ambil detail post
$post_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name, users.profile_pic 
                            FROM posts 
                            JOIN users ON posts.user_id = users.id 
                            WHERE posts.id = :id");
$post_stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
$post_stmt->execute();
$post = $post_stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header("Location: home.php");
    exit();
}

// Tambah view count
$update_views_stmt = $pdo->prepare("UPDATE posts SET views = views + 1 WHERE id = :post_id");
$update_views_stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$update_views_stmt->execute();

// Ambil semua jawaban
$answers_stmt = $pdo->prepare("SELECT answers.*, users.username, users.display_name, users.profile_pic
                                FROM answers 
                                JOIN users ON answers.user_id = users.id 
                                WHERE answers.post_id = :post_id 
                                ORDER BY answers.created_at ASC");
$answers_stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$answers_stmt->execute();

// Trending post
$trending_stmt = $pdo->prepare("SELECT * FROM posts ORDER BY views DESC LIMIT 5");
$trending_stmt->execute();
$trending_posts = $trending_stmt->fetchAll(PDO::FETCH_ASSOC);

$active_page = ''; // or set to something like 'detail'
include('../includes/header.php');
?>

<!-- Main Content -->
<div class="flex-1 flex p-4 space-x-4">
    <!-- Questions and Replies -->
    <div class="w-2/3 bg-white p-4 rounded-lg shadow space-y-4">
        <!-- Post Content -->
        <div class="border-b border-gray-300 pb-4">
            <div class="flex items-center space-x-2 mb-2">
                <img src="<?= htmlspecialchars($post['profile_pic'] ?? 'https://placehold.co/40x40') ?>" class="w-10 h-10 rounded-full">
                <div>
                    <p class="font-bold"><?= htmlspecialchars($post['display_name']) ?></p>
                    <p class="text-gray-500">@<?= htmlspecialchars($post['username']) ?></p>
                    <p class="text-gray-700 font-medium"><?= htmlspecialchars($post['title']) ?></p>
                </div>
            </div>
            <p class="mb-4"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <?php if (!empty($post['image'])): ?>
            <div class="mt-2">
                <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post image" class="rounded-lg">
            </div>
            <?php endif; ?>
            <button class="flex items-center space-x-1 text-purple-500 mt-2">
                <i class="fas fa-pen"></i>
                <span>Answer</span>
            </button>
        </div>

        <!-- Answers Section -->
        <div class="border-b border-gray-300 pb-4 space-y-4">
            <?php if ($answers_stmt->rowCount() > 0): ?>
                <?php while ($answer = $answers_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div>
                    <div class="flex items-center space-x-2 mb-1">
                        <img src="<?= htmlspecialchars($answer['profile_pic'] ?? 'https://placehold.co/40x40') ?>" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-bold"><?= htmlspecialchars($answer['display_name']) ?></p>
                            <p class="text-gray-500">@<?= htmlspecialchars($answer['username']) ?></p>
                        </div>
                    </div>
                    <p><?= nl2br(htmlspecialchars($answer['content'])) ?></p>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-500">Belum ada jawaban untuk pertanyaan ini.</p>
            <?php endif; ?>
        </div>

        <!-- Answer Form -->
        <div class="mt-4">
            <form action="proses_answer.php" method="POST">
                <textarea name="content" rows="4" class="w-full p-2 border rounded-lg" placeholder="Type your answer..." required></textarea>
                <input type="hidden" name="post_id" value="<?= htmlspecialchars($post['id']) ?>">
                <button type="submit" class="mt-2 bg-blue-500 text-white p-2 rounded-lg">Submit Answer</button>
            </form>
        </div>
    </div>

    <!-- Trending Sidebar -->
    <div class="w-1/3 space-y-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-bold mb-4">Trending</h2>
            <div class="space-y-2">
                <?php foreach ($trending_posts as $tpost): ?>
                <div>
                    <p class="font-bold"><?= htmlspecialchars($tpost['title']) ?></p>
                    <p class="text-gray-500"><?= (int) $tpost['views'] ?> views</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>
