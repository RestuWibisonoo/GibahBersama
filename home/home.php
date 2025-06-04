<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/koneksi.php';

// Get current user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
$stmt->execute();
$current_user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get all posts with user data
$posts_sql = "SELECT posts.*, users.username, users.display_name, users.profile_pic 
              FROM posts 
              JOIN users ON posts.user_id = users.id 
              ORDER BY posts.created_at DESC";
$posts_result = $pdo->query($posts_sql);

// Get trending posts
$trending_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name, users.profile_pic
                                FROM posts 
                                JOIN users ON posts.user_id = users.id 
                                ORDER BY posts.views DESC LIMIT 5");
$trending_stmt->execute();
$trending_posts = $trending_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('../includes/header.php'); ?>

<div class="flex p-4 space-x-4">
    <!-- Main Content -->
    <div class="w-2/3 p-6 space-y-6">
        <div class="main-content bg-white-200 p-6 rounded-lg shadow overflow-y-auto max-h-[calc(100vh-150px)]">
            <!-- Post Creation Box -->
            <div class="flex items-center space-x-3 bg-white p-4 rounded-lg shadow">
                <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
                    class="w-10 h-10 rounded-full" alt="User profile"
                    onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                <input type="text" placeholder="Do You Have a Question?"
                    class="flex-1 border-none focus:outline-none text-lg" onclick="openPopup()" readonly />
                <a href="#" class="p-2 rounded-full hover:bg-gray-200" onclick="openPopup()">
                    <img src="../assets/img/icons/outline/write.png" width="24" height="24" alt="Write Icon" />
                </a>
            </div>

            <!-- Posts Feed -->
            <div class="space-y-6 mt-4">
                <?php while ($post = $posts_result->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="bg-white p-4 rounded-lg shadow space-y-2">
                        <div class="flex items-center space-x-2">
                            <img alt="User profile picture" class="w-10 h-10 rounded-full"
                                src="../assets/img/profile_pict/<?= htmlspecialchars($post['profile_pic'] ?? 'default.jpg') ?>"
                                onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                            <div>
                                <p class="font-bold"><?= htmlspecialchars($post['display_name'] ?? 'User') ?></p>
                                <p class="text-gray-500">@<?= htmlspecialchars($post['username']) ?></p>
                                <a href="discussion.php?post_id=<?= $post['id'] ?>"
                                    class="text-blue-600 font-medium hover:underline block">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </div>
                        </div>
                        <p><?= htmlspecialchars($post['content']) ?></p>

                        <?php if (!empty($post['image'])): ?>
                            <div class="mt-2">
                                <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post image"
                                    class="post-image rounded-lg" />
                            </div>
                        <?php endif; ?>

                        <div class="flex items-center space-x-2 cursor-pointer mt-2"
                            onclick="openPopup(<?= $post['id'] ?>)">
                            <button
                                class="px-4 py-2 border border-gray-400 text-gray-800 rounded-full flex items-center bg-transparent hover:bg-gray-100">
                                <img src="../assets/img/icons/outline/write.png" alt="Pen Icon" class="mr-2"
                                    style="width: 16px; height: 16px;">
                                Answer
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Trending Section -->
    <div class="w-1/3 space-y-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-bold mb-4">Trending</h2>
            <div class="space-y-2">
                <?php foreach ($trending_posts as $trending_post): ?>
                    <div>
                        <p class="font-bold"><?= htmlspecialchars($trending_post['title']) ?></p>
                        <p class="text-gray-500"><?= $trending_post['views'] ?> views</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->
<div id="popupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative">
        <button onclick="closePopup()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times text-xl"></i>
        </button>
        <iframe id="popupIframe" src="" class="w-full h-[500px] rounded-lg" frameborder="0"></iframe>
    </div>
</div>

<script>
    function openPopup(postId = null) {
        const modal = document.getElementById("popupModal");
        const iframe = document.getElementById("popupIframe");

        if (postId) {
            iframe.src = `answer.php?post_id=${postId}`;
        } else {
            iframe.src = 'posts.php';
        }

        modal.classList.remove("hidden");
        document.body.classList.add('overflow-hidden');
    }

    function closePopup() {
        const modal = document.getElementById("popupModal");
        modal.classList.add("hidden");
        document.body.classList.remove('overflow-hidden');
        document.getElementById("popupIframe").src = '';
    }

    window.addEventListener('message', function (event) {
        if (event.data.type === 'ANSWER_POSTED' && event.data.success) {
            closePopup();
            const answersContainer = document.getElementById("answers-container");
            if (answersContainer && event.data.post_id) {
                fetch(`get_answers.php?post_id=${event.data.post_id}`)
                    .then(response => response.text())
                    .then(html => {
                        answersContainer.innerHTML = html;
                    });
            }
        }

        if (event.data.type === 'POST_CREATED' && event.data.success) {
            closePopup();
            location.reload();
        }
    });
</script>

<?php include('../includes/footer.php'); ?>