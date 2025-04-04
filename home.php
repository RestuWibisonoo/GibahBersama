<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

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
                <a href="#"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-300 rounded-lg px-4 py-3">
                    <img src="icons/home-click.png" class="w-6 h-6" alt="Home" />
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
                <a href="bookmark.php"
                    class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/bookmark.png" class="w-6 h-6" alt="Bookmark" />
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
                <!-- Kategori -->
                <div class="flex space-x-4">
                    <a href="#" class="px-4 py-2 bg-white rounded-md hover:bg-gray-100">For You</a>
                    <a href="#" class="px-4 py-2 hover:bg-gray-100">Friends</a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search"
                        class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <img src="icons/search.png"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                </div>

                <!-- Navigasi -->
                <div class="flex items-center space-x-4">
                    <a href="#" onclick="openPopup()" class="p-3 rounded-full hover:bg-gray-200">
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
            <section class="flex justify-between overflow-hidden h-full">
                <!-- Left Content -->
                <article class="w-2/3 p-6 space-y-6 overflow-y-auto">
                    <div class="flex items-center space-x-3 bg-white p-4 rounded-lg shadow">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                        <input type="text" placeholder="Do You Have a Question?"
                            class="flex-1 border-none focus:outline-none text-lg" />
                        <a href="#" class="p-2 rounded-full hover:bg-gray-200">
                            <img src="icons/write.png" width="24" height="24" alt="Write Icon" />
                        </a>
                    </div>

                    <!-- Post Section -->
                    <!-- kalau bisa posts.php bisa muncul seperti di sini ini -->
                    <div class="space-y-6">
                        <div class="bg-white p-4 rounded-lg shadow space-y-2">
                            <div class="flex items-center space-x-2">
                                <img alt="User profile picture" class="w-10 h-10 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/9/91/Indonesian_Coordinating_Minister_Luhut_Binsar_Pandjaitan_in_Washington%2C_D.C._on_4_August_2023_-_%28cropped%29.jpg" />
                                <div>
                                    <p class="font-bold">Display Name</p>
                                    <p class="text-gray-500">@username</p>
                                    <p class="text-gray-700">Title</p>
                                </div>
                            </div>
                            <p>Apa yang menyebabkan naga tidak bisa dijadikan hewan qurban?</p>
                            <div class="flex items-center space-x-2 cursor-pointer" onclick="window.location.href='discussion.html'">
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

    <!-- Pop-up Modal -->
    <div id="popupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-lg relative">
            <iframe src="posts.php" class="w-full h-[300px]" frameborder="0"></iframe>
        </div>
    </div>

    <script>
        function openPopup() {
            document.getElementById("popupModal").classList.remove("hidden");
        }

        function closePopup() {
            document.getElementById("popupModal").classList.add("hidden");
        }
    </script>

</body>

</html>