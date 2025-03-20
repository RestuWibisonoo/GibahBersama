<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SpeakUp!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
    </style>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-500 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/5 bg-white p-6">
            <h1 class="text-3xl font-bold mb-10">SpeakUp!</h1>
            <nav class="space-y-6">
                <a href="home.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/home.png" class="w-6 h-6" alt="Home" />
                    <span>Home</span>
                </a>
                <a href="message.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/message.png" class="w-6 h-6" alt="Message" />
                    <span>Message</span>
                </a>
                <a href="community.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/community.png" class="w-6 h-6" alt="Community" />
                    <span>Community</span>
                </a>
                <a href="bookmark.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/bookmark.png" class="w-6 h-6" alt="Bookmark" />
                    <span>Bookmark</span>
                </a>
                <a href="#" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-300 rounded-lg px-4 py-3">
                    <img src="icons/setting-click.png" class="w-6 h-6" alt="Settings" />
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="flex items-center justify-between bg-gray-200 p-4 shadow">
                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search" class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <img src="icons/search.png" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                </div>

                <!-- Navigasi Tanpa JS -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/note.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/notification.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/globe.png" width="28" height="28" />
                    </a>
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/profile.png" width="28" height="28" />
                    </a>
                    <a href="login.php" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/logout.png" width="28" height="28" />
                    </a>
                </div>
            </header>

            <!-- User Profile Section -->
            <!-- Content -->
            <div class="flex-1 flex p-4 space-x-4">
                <!-- Profile Section -->
                <div class="bg-white p-4 rounded-lg w-2/3">
                    <div class="flex flex-col items-center">
                        <img src="https://placehold.co/100x100" alt="User profile icon" class="w-24 h-24 mb-4 rounded-full border-2 border-gray-300">
                        <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full">Username</div>
                        <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full">Display Name</div>
                        <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full">Bio</div>
                    </div>
                </div>
                <!-- Settings Section -->
                <div class="bg-white p-4 rounded-lg w-1/3">
                    <div class="border-b pb-2 mb-2 text-lg font-semibold">Settings</div>
                    <ul>
                        <li class="py-2 bg-purple-200 mb-2 rounded-full text-center font-medium">Account</li>
                        <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer">Password & Security</li>
                        <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer">Display & Language</li>
                        <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer">Help</li>
                        <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer">About</li>
                    </ul>
                </div>
            </div>            
        </main>
    </div>
</body>
</html>