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

// Get current user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$current_user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get all posts with user data and bookmark status
$posts_sql = "SELECT posts.*, 
              users.username, 
              users.display_name, 
              users.profile_pic,
              EXISTS(SELECT 1 FROM bookmarks WHERE bookmarks.user_id = :current_user_id AND bookmarks.post_id = posts.id) AS is_bookmarked
              FROM posts 
              JOIN users ON posts.user_id = users.id 
              ORDER BY posts.created_at DESC";
$posts_stmt = $pdo->prepare($posts_sql);
$posts_stmt->bindParam(':current_user_id', $current_user['id'], PDO::PARAM_INT);
$posts_stmt->execute();

// Get trending posts
$trending_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name, users.profile_pic
                                FROM posts 
                                JOIN users ON posts.user_id = users.id 
                                ORDER BY posts.views DESC LIMIT 5");
$trending_stmt->execute();
$trending_posts = $trending_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('../includes/header.php'); ?>

<style>
    .main-content-container {
        height: calc(100vh - 64px);
        /* Adjust based on header height */
    }

    .posts-feed {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .posts-feed::-webkit-scrollbar {
        display: none;
    }

    .post-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .post-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .trending-card {
        position: sticky;
        top: 80px;
    }
</style>

<div class="main-content-container flex p-4 gap-4">
    <!-- Main Content -->
    <div class="w-2/3">
        <!-- Post Creation Box -->
        <div class="flex items-center space-x-3 bg-white p-4 rounded-lg shadow mb-4">
            <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
                class="w-10 h-10 rounded-full object-cover" alt="User profile"
                onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
            <input type="text" placeholder="Do You Have a Question?"
                class="flex-1 border-none focus:outline-none text-lg cursor-pointer bg-gray-50 rounded-full px-4 py-2"
                onclick="openPopup()" readonly />
            <button class="p-2 rounded-full hover:bg-gray-100 transition" onclick="openPopup()">
                <img src="../assets/img/icons/outline/write.png" width="24" height="24" alt="Write Icon" />
            </button>
        </div>

        <!-- Posts Feed -->
        <div class="posts-feed space-y-4 bg-gray-50 p-4 rounded-lg shadow overflow-y-auto"
            style="max-height: calc(100vh - 180px)">
            <?php while ($post = $posts_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="post-card bg-white p-4 rounded-lg shadow space-y-2 relative" id="post-<?= $post['id'] ?>">
                    <div class="flex items-center space-x-2">
                        <img alt="User profile picture" class="w-10 h-10 rounded-full object-cover"
                            src="../assets/img/profile_pict/<?= htmlspecialchars($post['profile_pic'] ?? 'default.jpg') ?>"
                            onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                        <div>
                            <p class="font-bold"><?= htmlspecialchars($post['display_name'] ?? 'User') ?></p>
                            <p class="text-gray-500 text-sm">@<?= htmlspecialchars($post['username']) ?></p>
                            <a href="discussion.php?post_id=<?= $post['id'] ?>"
                                class="text-blue-600 font-medium hover:underline block">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </div>
                    </div>
                    <p class="text-gray-800"><?= htmlspecialchars($post['content']) ?></p>

                    <?php if (!empty($post['image'])): ?>
                        <div class="mt-2">
                            <img src="../uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post image"
                                class="post-image rounded-lg w-full border border-gray-200" />
                        </div>
                    <?php endif; ?>

                    <!-- Action buttons -->
                    <div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-100">
                        <!-- Answer button -->
                        <button onclick="openPopup(<?= $post['id'] ?>)"
                            class="px-4 py-2 border border-gray-300 text-gray-800 rounded-full flex items-center bg-transparent hover:bg-gray-100 transition">
                            <img src="../assets/img/icons/outline/write.png" alt="Pen Icon" class="mr-2 w-4 h-4">
                            Answer
                        </button>

                        <!-- Right side buttons -->
                        <div class="flex items-center space-x-2">
                            <!-- Bookmark button -->
                            <button class="p-2 rounded-full hover:bg-gray-100 transition bookmark-btn"
                                data-post-id="<?= $post['id'] ?>" onclick="toggleBookmark(this, <?= $post['id'] ?>)">
                                <img src="../assets/img/icons/<?= $post['is_bookmarked'] ? 'full' : 'outline' ?>/bookmark.png"
                                    width="20" height="20" alt="Bookmark"
                                    class="<?= $post['is_bookmarked'] ? 'opacity-100' : 'opacity-70 hover:opacity-100' ?>">
                            </button>

                            <!-- Three-dot menu -->
                            <?php if ($current_user['id'] == $post['user_id'] || $current_user['role'] == 'admin'): ?>
                                <div class="relative">
                                    <button class="p-2 rounded-full hover:bg-gray-100 transition menu-trigger">
                                        <img src="../assets/img/icons/outline/more.png" width="20" height="20"
                                            alt="More options">
                                    </button>

                                    <div
                                        class="absolute right-0 bottom-full mb-2 w-48 bg-white rounded-md shadow-lg hidden z-10 border border-gray-200">
                                        <div class="py-1">
                                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition"
                                                onclick="deletePost(<?= $post['id'] ?>)">Delete Post</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Trending Section -->
    <div class="w-1/3">
        <div class="trending-card bg-white p-4 rounded-lg shadow-lg">
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
    // Bookmark functionality
    async function toggleBookmark(button, postId) {
        const icon = button.querySelector('img');
        const isBookmarked = icon.src.includes('full/bookmark.png');

        try {
            const response = await fetch('../bookmark/bookmark_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    postId: postId,
                    action: isBookmarked ? 'remove' : 'add'
                })
            });

            const result = await response.json();

            if (result.success) {
                if (isBookmarked) {
                    // Change to outline icon
                    icon.src = "../assets/img/icons/outline/bookmark.png";
                    icon.classList.remove('opacity-100');
                    icon.classList.add('opacity-70');
                } else {
                    // Change to full icon
                    icon.src = "../assets/img/icons/full/bookmark.png";
                    icon.classList.remove('opacity-70');
                    icon.classList.add('opacity-100');
                }
            } else {
                showAlert(result.message || 'Error processing bookmark', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('An error occurred while processing your request', 'error');
        }
    }

    // Delete post function
    function deletePost(postId) {
        if (confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
            fetch('../post/delete_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ postId: postId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`post-${postId}`).remove();
                        showAlert('Post deleted successfully', 'success');
                    } else {
                        showAlert(data.message || 'Error deleting post', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred while deleting the post', 'error');
                });
        }
    }

    // Alert function
    function showAlert(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg`;
        alertDiv.textContent = message;

        if (type === 'success') {
            alertDiv.classList.add('bg-green-100', 'text-green-800');
        } else {
            alertDiv.classList.add('bg-red-100', 'text-red-800');
        }

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Fungsi untuk menutup popup answer
    function closeAnswerPopup() {
        const popup = window.open('', 'AnswerPopup');
        if (popup) popup.close();
    }

    // Handle message dari popup answer
    window.addEventListener('message', function (event) {
        if (event.data.type === 'ANSWER_POSTED' && event.data.success) {
            // Refresh halaman setelah 500ms
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
    });

    // Menu toggle
    document.addEventListener('click', function (e) {
        if (e.target.closest('.menu-trigger')) {
            const menu = e.target.closest('.menu-trigger').nextElementSibling;
            document.querySelectorAll('.absolute').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        } else if (!e.target.closest('.absolute')) {
            document.querySelectorAll('.absolute').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>

<?php include('../includes/footer.php'); ?>