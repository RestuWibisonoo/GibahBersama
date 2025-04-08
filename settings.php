<?php
session_start();
require 'config/koneksi.php'; // Pastikan file koneksi.php sudah benar

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil username dari sesi
$username = $_SESSION['username'];

// Ambil data pengguna dari database
$query = "SELECT id, username, email, profile_pic FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data ditemukan
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User tidak ditemukan!";
    exit();
}
?>

<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings - SpeakUp!</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <a href="settings.php" class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-300 rounded-lg px-4 py-3">
                    <img src="icons/setting-click.png" class="w-6 h-6" alt="Settings" />
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="flex items-center justify-between bg-gray-200 p-4 shadow">
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search" class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <img src="icons/search.png" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/profile.png" width="28" height="28" />
                    </a>
                    <a href="logout.php" class="p-3 rounded-full hover:bg-gray-200">
                        <img src="icons/logout.png" width="28" height="28" alt="Logout" />
                    </a>
                </div>
            </header>

            <!-- Profile Section -->
            <div class="flex-1 flex p-4 space-x-4">
                <div class="bg-white p-4 rounded-lg w-2/3">
                    <div class="flex flex-col items-center">
                        <img src="uploads/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" class="w-24 h-24 mb-4 rounded-full border-2 border-gray-300">
                        <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full"><?php echo $user['username']; ?></div>
                        <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full"><?php echo $user['email']; ?></div>
                        <form action="update_profile.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <div class="mb-2">
                                <label class="block text-sm font-semibold mb-1">Username</label>
                                <input type="text" name="username" value="<?php echo $user['username']; ?>" class="w-full px-4 py-2 border rounded-lg">
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-semibold mb-1">Email</label>
                                <input type="email" name="email" value="<?php echo $user['email']; ?>" class="w-full px-4 py-2 border rounded-lg">
                            </div>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-2">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
