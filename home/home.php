<?php
// Start session and check authentication
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../config/koneksi.php';

// Get current user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$current_user) {
        throw new Exception("User not found");
    }
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Database error']));
} catch (Exception $e) {
    header("Location: ../auth/logout.php");
    exit();
}

// Handle POST requests (for AJAX operations)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'delete_post':
                $postId = (int)($_POST['post_id'] ?? 0);
                
                // Verify post exists and user has permission
                $stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
                $stmt->execute([$postId]);
                $post = $stmt->fetch();
                
                if (!$post) {
                    echo json_encode(['status' => 'error', 'message' => 'Post not found']);
                    exit();
                }
                
                if ($post['user_id'] != $_SESSION['user_id'] && $current_user['role'] != 'admin') {
                    echo json_encode(['status' => 'error', 'message' => 'Permission denied']);
                    exit();
                }
                
                // Delete the post
                $pdo->prepare("DELETE FROM posts WHERE id = ?")->execute([$postId]);
                
                echo json_encode(['status' => 'success', 'message' => 'Post deleted']);
                exit();
                
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                exit();
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit();
    }
}

// Get all posts for display
try {
    $posts_sql = "SELECT posts.*, 
                 users.username, 
                 users.display_name, 
                 users.profile_pic,
                 COUNT(answers.id) AS answer_count,
                 EXISTS(SELECT 1 FROM bookmarks WHERE bookmarks.user_id = ? AND bookmarks.post_id = posts.id) AS is_bookmarked
                 FROM posts 
                 JOIN users ON posts.user_id = users.id
                 LEFT JOIN answers ON posts.id = answers.post_id
                 GROUP BY posts.id
                 ORDER BY posts.created_at DESC";
    
    $posts_stmt = $pdo->prepare($posts_sql);
    $posts_stmt->execute([$_SESSION['user_id']]);
    
    // Get trending posts
    $trending_stmt = $pdo->prepare("SELECT posts.*, users.username, users.display_name, users.profile_pic
                                   FROM posts 
                                   JOIN users ON posts.user_id = users.id 
                                   ORDER BY posts.views DESC LIMIT 5");
    $trending_stmt->execute();
    $trending_posts = $trending_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $posts = [];
    $trending_posts = [];
}

include('../includes/header.php');
?>

<!-- HTML Structure -->
<div class="main-content-container flex p-4 gap-4">
    <!-- Main Content -->
    <div class="w-full md:w-2/3">
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
            <?php if ($posts_stmt && $posts_stmt->rowCount() > 0): ?>
                <?php while ($post = $posts_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="post-card bg-white p-4 rounded-lg shadow space-y-2 relative" id="post-<?= $post['id'] ?>">
                        <!-- Post Content -->
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
                                    class="rounded-lg w-full border border-gray-200" />
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-100">
                            <button onclick="openPopup(<?= $post['id'] ?>)"
                                class="px-4 py-2 border border-gray-300 text-gray-800 rounded-full flex items-center bg-transparent hover:bg-gray-100 transition">
                                <img src="../assets/img/icons/outline/write.png" alt="Pen Icon" class="mr-2 w-4 h-4">
                                Answer <?= $post['answer_count'] > 0 ? '('.$post['answer_count'].')' : '' ?>
                            </button>

                            <div class="flex items-center space-x-2">
                                <!-- Bookmark Button -->
                                <button class="p-2 rounded-full hover:bg-gray-100 transition bookmark-btn"
                                    data-post-id="<?= $post['id'] ?>" onclick="toggleBookmark(this, <?= $post['id'] ?>)">
                                    <img src="../assets/img/icons/<?= $post['is_bookmarked'] ? 'full' : 'outline' ?>/bookmark.png"
                                        width="20" height="20" alt="Bookmark"
                                        class="<?= $post['is_bookmarked'] ? 'opacity-100' : 'opacity-70 hover:opacity-100' ?>">
                                </button>

                                <?php if ($current_user['id'] == $post['user_id'] || $current_user['role'] == 'admin'): ?>
                                    <div class="relative">
                                        <button class="p-2 rounded-full hover:bg-gray-100 transition menu-trigger">
                                            <img src="../assets/img/icons/outline/more.png" width="20" height="20" alt="More options">
                                        </button>
                                        <div class="absolute right-0 bottom-full mb-2 w-48 bg-white rounded-md shadow-lg hidden z-10 border border-gray-200">
                                            <div class="py-1">
                                                <button onclick="confirmDelete(<?= $post['id'] ?>)"
                                                    class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100 transition">
                                                    Delete Post
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bg-white p-8 rounded-lg shadow text-center">
                    <p class="text-gray-500">No discussions found. Be the first to start one!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Trending Section -->
    <div class="hidden md:block md:w-1/3">
        <div class="trending-card bg-white p-4 rounded-lg shadow-lg">
            <h2 class="font-bold text-xl mb-4">Trending Discussions</h2>
            <div class="space-y-3">
                <?php if (!empty($trending_posts)): ?>
                    <?php foreach ($trending_posts as $trending_post): ?>
                        <a href="discussion.php?post_id=<?= $trending_post['id'] ?>"
                            class="block hover:bg-gray-50 p-3 rounded-lg transition">
                            <p class="font-bold text-gray-800"><?= htmlspecialchars($trending_post['title']) ?></p>
                            <p class="text-gray-500 text-sm"><?= $trending_post['views'] ?> views • 
                                <?= date('M j', strtotime($trending_post['created_at'])) ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">No trending discussions yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Improved delete function with proper JSON handling
async function confirmDelete(postId) {
    if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
        return;
    }

    const postElement = document.getElementById(`post-${postId}`);
    if (postElement) {
        postElement.style.opacity = '0.5';
        postElement.style.pointerEvents = 'none';
    }

    try {
        const formData = new FormData();
        formData.append('action', 'delete_post');
        formData.append('post_id', postId);

        const response = await fetch('home.php', {
            method: 'POST',
            body: formData
        });

        // First check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error('Invalid response from server');
        }

        const data = await response.json();

        if (data.status === 'success') {
            if (postElement) {
                postElement.style.transition = 'opacity 0.3s ease';
                postElement.style.opacity = '0';
                setTimeout(() => postElement.remove(), 300);
            }
            showAlert('Post deleted successfully', 'success');
        } else {
            throw new Error(data.message || 'Failed to delete post');
        }
    } catch (error) {
        console.error('Delete error:', error);
        if (postElement) {
            postElement.style.opacity = '1';
            postElement.style.pointerEvents = 'auto';
        }
        showAlert(error.message || 'An error occurred while deleting the post', 'error');
    }
}

// Bookmark function
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

        // Check response content type
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Invalid response from server');
        }

        const result = await response.json();

        if (result.success) {
            icon.src = `../assets/img/icons/${isBookmarked ? 'outline' : 'full'}/bookmark.png`;
            icon.classList.toggle('opacity-70', isBookmarked);
            icon.classList.toggle('opacity-100', !isBookmarked);
        } else {
            throw new Error(result.message || 'Error processing bookmark');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert(error.message || 'An error occurred', 'error');
    }
}

// Alert function
function showAlert(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
    }`;
    alertDiv.textContent = message;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

// Menu toggle
document.addEventListener('click', function(e) {
    if (e.target.closest('.menu-trigger')) {
        const menu = e.target.closest('.menu-trigger').nextElementSibling;
        document.querySelectorAll('.absolute').forEach(m => m !== menu && m.classList.add('hidden'));
        menu.classList.toggle('hidden');
    } else if (!e.target.closest('.absolute')) {
        document.querySelectorAll('.absolute').forEach(menu => menu.classList.add('hidden'));
    }
});
</script>

<?php include('../includes/footer.php'); ?>