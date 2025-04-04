<!DOCTYPE html>
<html lang="en">

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
                <a href="home.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/home.png" class="w-6 h-6" alt="Home" />
                    <span>Home</span>
                </a>
                <a href="message.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/message.png" class="w-6 h-6" alt="Message" />
                    <span>Message</span>
                </a>
                <a href="community.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/community.png" class="w-6 h-6" alt="Community" />
                    <span>Community</span>
                </a>
                <a href="#"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-300 rounded-lg px-4 py-3">
                    <img src="icons/bookmark-click.png" class="w-6 h-6" alt="Bookmark" />
                    <span>Bookmark</span>
                </a>
                <a href="settings.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/setting.png" class="w-6 h-6" alt="Settings" />
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
                    <input type="text" placeholder="Search"
                        class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <img src="icons/search.png"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
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

            <!-- Tabs and Content -->
            <section class="flex-1 flex overflow-hidden">
                <!-- Left Content (Scrollable) -->
                <article class="w-2/3 p-6 space-y-6 overflow-y-auto h-full">
                    <div class="flex items-center space-x-3 bg-white p-4 rounded-lg shadow">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                        <input type="text" placeholder="Do You Have a Question?"
                            class="flex-1 border-none focus:outline-none text-lg" />
                        <a href="#" class="p-2 rounded-full hover:bg-gray-200">
                            <img src="icons/write.png" width="24" height="24" alt="Write Icon" />
                        </a>
                    </div>

                    <!-- Post Section (Scrollable) -->
                    <div class="space-y-6">
                        <!-- Post 2 -->
                        <div class="bg-white p-4 rounded-lg shadow space-y-2">
                            <div class="flex items-center space-x-2">
                                <img alt="User profile picture" class="w-10 h-10 rounded-full"
                                    src="https://upload.wikimedia.org/wikipedia/commons/9/91/Indonesian_Coordinating_Minister_Luhut_Binsar_Pandjaitan_in_Washington%2C_D.C._on_4_August_2023_-_%28cropped%29.jpg" />
                                <div>
                                    <p class="font-bold">Nick Name</p>
                                    <p class="text-gray-500">@username</p>
                                </div>
                            </div>
                            <p>Kenapa ketika kita menghirup napas dalam-dalam, rasanya lebih lega?</p>
                            <div class="flex items-center space-x-2">
                                <button class="text-blue-500">Answer</button>
                                <i class="fas fa-pen text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Post 3 -->
                        <div class="bg-white p-4 rounded-lg shadow space-y-2">
                            <div class="flex items-center space-x-2">
                                <img alt="User profile picture" class="w-10 h-10 rounded-full"
                                    src="https://upload.wikimedia.org/wikipedia/commons/9/91/Indonesian_Coordinating_Minister_Luhut_Binsar_Pandjaitan_in_Washington%2C_D.C._on_4_August_2023_-_%28cropped%29.jpg" />
                                <div>
                                    <p class="font-bold">Nick Name</p>
                                    <p class="text-gray-500">@username</p>
                                </div>
                            </div>
                            <p>Bagaimana cara terbaik mengelola keuangan untuk pemula?</p>
                            <div class="flex items-center space-x-2">
                                <button class="text-blue-500">Answer</button>
                                <i class="fas fa-pen text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Right Content (Scrollable Trending) -->
                <aside class="w-1/3 p-6 overflow-y-auto h-full">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h2 class="font-bold mb-4">Trending</h2>
                        <div class="space-y-2">
                            <!-- Trending Topics -->
                            <div>
                                <p class="text-gray-500">Sains</p>
                                <p class="font-bold">Penemuan baru tentang lubang hitam</p>
                                <p class="text-gray-500">78 rb diskusi</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Kesehatan</p>
                                <p class="font-bold">Manfaat minum air putih 8 gelas sehari</p>
                                <p class="text-gray-500">92 rb diskusi</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Bisnis</p>
                                <p class="font-bold">Tips sukses membangun startup</p>
                                <p class="text-gray-500">83 rb diskusi</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Astronomi</p>
                                <p class="font-bold">NASA akan meluncurkan misi ke Mars</p>
                                <p class="text-gray-500">45 rb diskusi</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Teknologi</p>
                                <p class="font-bold">Bagaimana AI akan mengubah dunia kerja?</p>
                                <p class="text-gray-500">120 rb diskusi</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>
        </main>
    </div>

</body>

</html>