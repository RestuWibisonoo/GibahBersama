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

// Get user's bookmarked posts with bookmark status
$bookmarks_sql = "SELECT posts.*, 
                 users.username, 
                 users.display_name, 
                 users.profile_pic,
                 1 AS is_bookmarked
                 FROM posts
                 JOIN bookmarks ON posts.id = bookmarks.post_id
                 JOIN users ON posts.user_id = users.id
                 WHERE bookmarks.user_id = :user_id
                 ORDER BY bookmarks.created_at DESC";
$bookmarks_stmt = $pdo->prepare($bookmarks_sql);
$bookmarks_stmt->bindParam(':user_id', $current_user['id'], PDO::PARAM_INT);
$bookmarks_stmt->execute();

// Get trending posts with bookmark status
$trending_sql = "SELECT posts.*, 
                users.username, 
                users.display_name, 
                users.profile_pic,
                EXISTS(SELECT 1 FROM bookmarks WHERE bookmarks.user_id = :current_user_id AND bookmarks.post_id = posts.id) AS is_bookmarked
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                ORDER BY posts.views DESC 
                LIMIT 5";
$trending_stmt = $pdo->prepare($trending_sql);
$trending_stmt->bindParam(':current_user_id', $current_user['id'], PDO::PARAM_INT);
$trending_stmt->execute();
$trending_posts = $trending_stmt->fetchAll(PDO::FETCH_ASSOC);

$active_page = 'bookmark';
include('../includes/header.php');
?>

<style>
    /* Prevent scrolling on the body */
    body {
        overflow: hidden;
    }
    
    /* Hide scrollbar but keep functionality */
    .main-content, aside {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .main-content::-webkit-scrollbar, aside::-webkit-scrollbar {
        display: none;
    }
    
    /* Ensure content is scrollable */
    .main-content, aside {
        overflow-y: auto;
    }
    
    /* Post styling */
    .post-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    /* Trending post styling */
    .trending-post {
        padding: 0.75rem;
        border-radius: 0.375rem;
        transition: background-color 0.2s;
    }
    
    .trending-post:hover {
        background-color: rgba(0,0,0,0.02);
    }
</style>

<!-- Konten Halaman Bookmark -->
<section class="flex-1 flex overflow-hidden">
    <!-- Left Content (Scrollable) -->
    <article class="w-2/3 p-6 space-y-6 overflow-y-auto h-full">
        <!-- Bookmarked Posts Section -->
        <div class="space-y-6">
            <?php if ($bookmarks_stmt->rowCount() > 0): ?>
                <?php while ($post = $bookmarks_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="post-container" id="post-<?= $post['id'] ?>">
                        <div class="flex items-center space-x-2">
                            <img alt="User profile picture" class="w-10 h-10 rounded-full"
                                src="../assets/img/profile_pict/<?= htmlspecialchars($post['profile_pic'] ?? 'default.jpg') ?>"
                                onerror="this.onerror=null;this.src='https://placehold.co/40x40'" />
                            <div>
                                <p class="font-bold"><?= htmlspecialchars($post['display_name'] ?? 'User') ?></p>
                                <p class="text-gray-500">@<?= htmlspecialchars($post['username']) ?></p>
                                <a href="../discussion.php?post_id=<?= $post['id'] ?>"
                                    class="text-blue-600 font-medium hover:underline block">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </div>
                        </div>
                        <p class="mt-2"><?= htmlspecialchars($post['content']) ?></p>

                        <?php if (!empty($post['image'])): ?>
                            <div class="mt-2">
                                <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post image"
                                    class="rounded-lg w-full max-h-96 object-contain" />
                            </div>
                        <?php endif; ?>

                        <!-- Action buttons -->
                        <div class="flex justify-between items-center mt-4">
                            <!-- Answer button -->
                            <div class="flex items-center space-x-2 cursor-pointer"
                                onclick="openPopup(<?= $post['id'] ?>)">
                                <button
                                    class="px-4 py-2 border border-gray-400 text-gray-800 rounded-full flex items-center bg-transparent hover:bg-gray-100">
                                    <img src="../assets/img/icons/outline/write.png" alt="Pen Icon" class="mr-2"
                                        style="width: 16px; height: 16px;">
                                    Answer
                                </button>
                            </div>
                            
                            <!-- Right side buttons -->
                            <div class="flex items-center space-x-2">
                                <!-- Bookmark button (already bookmarked) -->
                                <button class="p-2 rounded-full hover:bg-gray-100 bookmark-btn"
                                        data-post-id="<?= $post['id'] ?>"
                                        onclick="toggleBookmark(this, <?= $post['id'] ?>)">
                                    <img src="../assets/img/icons/full/bookmark.png" width="20" height="20" alt="Bookmark">
                                </button>
                                
                                <!-- Three-dot menu (only for post owner/admin) -->
                                <?php if ($current_user['id'] == $post['user_id'] || $current_user['role'] == 'admin'): ?>
                                    <div class="relative">
                                        <button class="p-2 rounded-full hover:bg-gray-100 menu-trigger">
                                            <img src="../assets/img/icons/outline/more.png" width="20" height="20" alt="More options">
                                        </button>
                                        
                                        <div class="absolute right-0 bottom-full mb-2 w-48 bg-white rounded-md shadow-lg hidden z-10 border border-gray-200">
                                            <div class="py-1">
                                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                                                   onclick="deletePost(<?= $post['id'] ?>)">Delete Post</a>
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
                    <img src="../assets/img/icons/outline/bookmark.png" alt="No bookmarks" class="w-16 h-16 mx-auto opacity-50">
                    <h3 class="text-xl font-medium mt-4">No bookmarks yet</h3>
                    <p class="text-gray-500 mt-2">Save interesting posts by clicking the bookmark icon</p>
                    <a href="../home.php" class="text-blue-600 hover:underline mt-4 inline-block">Explore posts</a>
                </div>
            <?php endif; ?>
        </div>
    </article>

    <!-- Right Content (Trending) - Updated Version -->
    <div class="w-1/3 p-6 overflow-y-auto h-full space-y-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-bold mb-4">Trending</h2>
            <div class="space-y-2">
                <?php foreach ($trending_posts as $trending_post): ?>
                    <a href="../discussion.php?post_id=<?= $trending_post['id'] ?>" class="block hover:bg-gray-50 p-2 rounded">
                        <p class="font-bold"><?= htmlspecialchars($trending_post['title']) ?></p>
                        <p class="text-gray-500"><?= $trending_post['views'] ?> views</p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

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
    // Bookmark functionality
    async function toggleBookmark(button, postId) {
        const icon = button.querySelector('img');
        const isBookmarked = icon.src.includes('full/bookmark.png');
        const postElement = document.getElementById(`post-${postId}`);
        
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
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                if (isBookmarked) {
                    // Change icon to outline
                    icon.src = "../assets/img/icons/outline/bookmark.png";
                    
                    // If in bookmarks page, remove the post
                    if (postElement && window.location.pathname.includes('bookmark.php')) {
                        postElement.remove();
                        
                        // If no more bookmarks, show empty state
                        if (document.querySelectorAll('.post-container').length === 0) {
                            location.reload();
                        }
                    }
                } else {
                    // Change icon to full
                    icon.src = "../assets/img/icons/full/bookmark.png";
                }
            } else {
                alert(result.message || 'Error updating bookmark');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while processing your request');
        }
    }
    
    // Menu toggle
    document.addEventListener('click', function(e) {
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
    
    // Delete post function
    function deletePost(postId) {
        if (confirm('Are you sure you want to delete this post?')) {
            fetch('../post/delete_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ postId: postId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById(`post-${postId}`).remove();
                    
                    // If no more bookmarks, show empty state
                    if (document.querySelectorAll('.post-container').length === 0) {
                        location.reload();
                    }
                } else {
                    alert(data.message || 'Error deleting post');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the post');
            });
        }
    }
    
    // Popup functions
    function openPopup(postId = null) {
        const modal = document.getElementById("popupModal");
        const iframe = document.getElementById("popupIframe");

        if (postId) {
            iframe.src = `../answer.php?post_id=${postId}`;
        } else {
            iframe.src = '../posts.php';
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
                fetch(`../get_answers.php?post_id=${event.data.post_id}`)
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