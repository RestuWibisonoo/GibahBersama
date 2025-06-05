<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Database connection
require_once __DIR__ . '/../config/koneksi.php';

// Get current user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $current_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$current_user) {
        header("Location: ../auth/login.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    header("Location: ../error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeakUp! - <?= htmlspecialchars($current_user['display_name'] ?? 'User') ?></title>

    <!-- Favicon -->
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #3B82F6;
            --secondary: #8B5CF6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            min-height: 100vh;
        }

        /* Popup Modal */
        #popupModal {
            transition: all 0.3s ease;
            z-index: 9999;
        }

        /* Alert Messages */
        .alert {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #B91C1C;
            border-left: 4px solid #EF4444;
        }

        /* Sidebar */
        .sidebar {
            width: 20%;
            min-width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Main Content */
        .main-content {
            width: 80%;
            overflow-y: auto;
        }

        /* Navigation Links */
        .nav-link {
            transition: all 0.2s ease;
            border-radius: 0.5rem;
        }

        .nav-link:hover {
            background-color: #F3F4F6;
            transform: translateX(4px);
        }

        .nav-link.active {
            background-color: #EFF6FF;
            color: #3B82F6;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Popup Modal Structure -->
    <div id="popupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl relative mx-4">
            <button onclick="closePopup()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
            <iframe id="popupIframe" src="" class="w-full h-[80vh] rounded-lg" frameborder="0"></iframe>
        </div>
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar p-6">
            <h1 class="text-3xl font-bold mb-10 text-center">SpeakUp!</h1>

            <nav class="space-y-4">
                <a href="../home/home.php"
                    class="nav-link flex items-center space-x-3 p-3 <?= basename($_SERVER['PHP_SELF']) === 'home.php' ? 'active' : '' ?>">
                    <img src="../assets/img/icons/outline/home.png" class="w-6 h-6" alt="Home">
                    <span>Home</span>
                </a>

                <a href="../message/message.php"
                    class="nav-link flex items-center space-x-3 p-3 <?= basename($_SERVER['PHP_SELF']) === 'message.php' ? 'active' : '' ?>">
                    <img src="../assets/img/icons/outline/message.png" class="w-6 h-6" alt="Messages">
                    <span>Messages</span>
                </a>

                <a href="../community/community.php"
                    class="nav-link flex items-center space-x-3 p-3 <?= basename($_SERVER['PHP_SELF']) === 'community.php' ? 'active' : '' ?>">
                    <img src="../assets/img/icons/outline/community.png" class="w-6 h-6" alt="Community">
                    <span>Community</span>
                </a>

                <a href="../bookmark/bookmark.php"
                    class="nav-link flex items-center space-x-3 p-3 <?= basename($_SERVER['PHP_SELF']) === 'bookmark.php' ? 'active' : '' ?>">
                    <img src="../assets/img/icons/outline/bookmark.png" class="w-6 h-6" alt="Bookmarks">
                    <span>Bookmarks</span>
                </a>

                <a href="../setting/settings.php"
                    class="nav-link flex items-center space-x-3 p-3 <?= basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : '' ?>">
                    <img src="../assets/img/icons/outline/setting.png" class="w-6 h-6" alt="Settings">
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content flex flex-col">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm p-4 flex items-center justify-between sticky top-0 z-50">
                <!-- Categories -->
                <div class="flex space-x-2">
                    <a href="#" class="px-4 py-2 rounded-md hover:bg-gray-100 transition">For You</a>
                    <a href="#" class="px-4 py-2 rounded-md hover:bg-gray-100 transition">Following</a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-6"> <!-- Tambah space-x-6 untuk jarak lebih lebar -->
                    <!-- Create Post Button -->
                    <button onclick="openPopup()" class="p-3 rounded-full hover:bg-gray-100 transition text-lg"
                        title="Create Post">
                        <img src="../assets/img/icons/outline/note.png" width="28" height="28" alt="Create Post">
                    </button>

                    <!-- Notification Button -->
                    <button class="p-3 rounded-full hover:bg-gray-100 transition relative text-lg"
                        title="Notifications">
                        <img src="../assets/img/icons/outline/notification.png" width="28" height="28"
                            alt="Notifications">
                        <span
                            class="absolute top-0 right-0 bg-red-500 text-white text-sm rounded-full w-6 h-6 flex items-center justify-center transform translate-x-1 -translate-y-1">3</span>
                    </button>

                    <!-- Profile Button -->
                    <a href="#" class="p-3 rounded-full hover:bg-gray-100 transition text-lg" title="Profile">
                        <img src="../assets/img/profile_pict/<?= htmlspecialchars($current_user['profile_pic'] ?? 'default.jpg') ?>"
                            class="w-10 h-10 rounded-full" alt="Profile"
                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=<?= urlencode($current_user['display_name'] ?? 'User') ?>&background=random'">
                    </a>

                    <!-- Logout Button -->
                    <a href="../auth/logout.php" class="p-3 rounded-full hover:bg-gray-100 transition text-lg"
                        title="Logout">
                        <img src="../assets/img/icons/outline/logout.png" width="28" height="28" alt="Logout">
                    </a>
                </div>
            </header>

            <!-- JavaScript for Popup Functionality -->
            <script>
                // Popup Functions
                function openPopup(postId = null) {
                    const modal = document.getElementById("popupModal");
                    const iframe = document.getElementById("popupIframe");

                    if (postId) {
                        iframe.src = `../home/answer.php?post_id=${postId}`;
                    } else {
                        iframe.src = '../home/posts.php';
                    }

                    modal.classList.remove("hidden");
                    document.body.style.overflow = 'hidden';
                }

                function closePopup() {
                    document.getElementById("popupModal").classList.add("hidden");
                    document.body.style.overflow = 'auto';
                    document.getElementById("popupIframe").src = '';
                }

                // Close when clicking outside
                document.getElementById('popupModal').addEventListener('click', function (e) {
                    if (e.target === this) {
                        closePopup();
                    }
                });

                // Handle messages from iframe
                window.addEventListener('message', function (event) {
                    switch (event.data.type) {
                        case 'CLOSE_POPUP':
                            closePopup();
                            break;

                        case 'POST_CREATED':
                            if (event.data.success) {
                                closePopup();
                                window.location.reload();
                            }
                            break;

                        case 'ANSWER_POSTED':
                            if (event.data.success && event.data.post_id) {
                                closePopup();
                                // You can add specific handling for answers here
                            }
                            break;
                    }
                });
            </script>