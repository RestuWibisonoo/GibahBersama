<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

$active_page = 'bookmark';
include('../includes/header.php'); // Sidebar + Topbar
?>

<!-- Konten Halaman Bookmark -->
<section class="flex-1 flex overflow-hidden">
    <!-- Left Content (Scrollable) -->
    <article class="w-2/3 p-6 space-y-6 overflow-y-auto h-full">
        <div class="flex items-center space-x-3 bg-white p-4 rounded-lg shadow">
            <i class="fas fa-user text-gray-400 text-xl"></i>
            <input type="text" placeholder="Do You Have a Question?"
                class="flex-1 border-none focus:outline-none text-lg" />
            <a href="#" class="p-2 rounded-full hover:bg-gray-200">
                <img src="../assets/img/icons/outline/write.png" width="24" height="24" alt="Write Icon" />
            </a>
        </div>

        <!-- Post Section -->
        <div class="space-y-6">
            <!-- Post 1 -->
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
                <p>Bagaimana cara terbaik mengelola keuangan untuk pemula?</p>
                <div class="flex items-center space-x-2">
                    <button class="text-blue-500">Answer</button>
                    <i class="fas fa-pen text-gray-400"></i>
                </div>
            </div>
        </div>
    </article>

    <!-- Right Content (Trending) -->
    <aside class="w-1/3 p-6 overflow-y-auto h-full">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-bold mb-4">Trending</h2>
            <div class="space-y-2">
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

</body>
</html>
