<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SpeakUp!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        .post-image {
            max-height: 300px;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-500 to-purple-500 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/5 bg-white p-6">
            <h1 class="text-3xl font-bold mb-10">SpeakUp!</h1>
            <nav class="space-y-6">
                <a href="../home/home.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="../assets/img/icons/outline/home.png" class="w-6 h-6" alt="Home" />
                    <span>Home</span>
                </a>
                <a href="../message/message.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="../assets/img/icons/outline/message.png" class="w-6 h-6" alt="Message" />
                    <span>Message</span>
                </a>
                <a href="../community/community.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="../assets/img/icons/outline/community.png" class="w-6 h-6" alt="Community" />
                    <span>Community</span>
                </a>
                <a href="../bookmark/bookmark.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="../assets/img/icons/outline/bookmark.png" class="w-6 h-6" alt="Bookmark" />
                    <span>Bookmark</span>
                </a>
                <a href="../setting/settings.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="../assets/img/icons/outline/setting.png" class="w-6 h-6" alt="Settings" />
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="flex items-center justify-between bg-white p-4 shadow">
                <!-- Kategori -->
                <div class="flex space-x-4">
                    <a href="#" class="px-4 py-2 bg-white rounded-md hover:bg-gray-100">For You</a>
                    <a href="#" class="px-4 py-2 hover:bg-gray-100">Friends</a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search"
                        class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <img src="../assets/img/icons/outline/search.png"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                </div>

                <!-- Navigasi -->
                <div class="flex items-center space-x-4">
                    <a href="#" onclick="openPopup()" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="../assets/img/icons/outline/note.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="../assets/img/icons/outline/notification.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="../assets/img/icons/outline/globe.png" width="28" height="28" />
                    </a>
                    <a href="../includes/profile.php" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="../assets/img/icons/outline/profile.png" width="28" height="28" />
                    </a>
                    <a href="../auth/logout.php" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="../assets/img/icons/outline/logout.png" width="28" height="28" alt="Logout" />
                    </a>
                </div>
            </header>
