<?php
session_start();
require_once '../config/koneksi.php';

// Redirect ke error.php jika post_id tidak valid
if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    header("Location: error.php?code=400&message=ID postingan tidak valid");
    exit();
}

$post_id = (int)$_GET['post_id'];

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
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    header("Location: error.php?code=500&message=Terjadi kesalahan pada server");
    exit();
}

$page_title = htmlspecialchars($post['title']) . " - Diskusi";
include('../includes/header.php');
?>

<!-- Main Content -->
<div class="flex-1 flex p-4 space-x-4">
    <!-- Questions and Replies -->
    <div class="w-2/3 bg-white p-6 rounded-lg shadow space-y-4">
        <!-- Post Content -->
        <div class="border-b border-gray-300 pb-4">
            <div class="flex items-center space-x-3 mb-2">
                <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
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
                <img src="../uploads/<?= htmlspecialchars($post['image']) ?>" 
                     alt="Post Image" 
                     class="rounded-lg mt-3 max-w-full h-auto">
            <?php endif; ?>
        </div>

        <!-- Jawaban -->
        <div class="space-y-6">
            <h2 class="text-lg font-semibold">Jawaban (<?= count($answers) ?>)</h2>
            <?php if (count($answers) > 0): ?>
                <?php foreach ($answers as $answer): ?>
                    <div class="border-t pt-4">
                        <div class="flex items-center space-x-3 mb-2">
                <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
                    class="w-10 h-10 rounded-full" alt="User profile"
                    onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                            <div>
                                <p class="font-semibold"><?= htmlspecialchars($answer['display_name']) ?></p>
                                <p class="text-sm text-gray-500">@<?= htmlspecialchars($answer['username']) ?> - 
                                    <?= date('d M Y H:i', strtotime($answer['created_at'])) ?></p>
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
        <div class="border-t pt-6">
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="proses_answer.php" method="POST" class="space-y-4">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <textarea name="content" rows="4" class="w-full border rounded p-2" 
                              placeholder="Tulis jawaban kamu..." required></textarea>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Kirim Jawaban
                    </button>
                </form>
            <?php else: ?>
                <p class="text-gray-600">
                    Silakan <a href="../auth/login.php" class="text-purple-600 hover:underline">login</a> 
                    untuk menjawab diskusi ini.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Trending Section (opsional) -->
    <div class="w-1/3 space-y-4">
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Trending</h3>
            <?php
            try {
                $trending_stmt = $pdo->query("SELECT id, title FROM posts ORDER BY views DESC LIMIT 5");
                while ($trend = $trending_stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <a href="discussion.php?post_id=<?= $trend['id'] ?>" 
                   class="block text-purple-600 hover:underline mb-1">
                    <?= htmlspecialchars($trend['title']) ?>
                </a>
            <?php 
                endwhile;
            } catch (PDOException $e) {
                error_log("Trending query error: " . $e->getMessage());
                echo "<p class='text-gray-500'>Gagal memuat trending</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>