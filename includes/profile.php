<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/koneksi.php';

// Ambil data pengguna saat ini
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
$stmt->execute();
$current_user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include('../includes/header.php'); ?>

<!-- Hapus sidebar dari sini -->

<!-- Main Profile Section -->
<main class="flex-1 image p-10">
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="home.php" class="text-gray-600 hover:text-gray-800 text-xl">&larr;</a>
        </div>

        <!-- User Info -->
        <div class="flex items-center space-x-4 mb-6">
            <img src="<?= htmlspecialchars($current_user['profile_pic'] ?? 'https://placehold.co/80x80') ?>"
                 alt="Profile Picture"
                 class="w-16 h-16 rounded-full border" />
            <div>
                <h2 class="text-xl font-bold"><?= htmlspecialchars($current_user['display_name']) ?></h2>
                <p class="text-gray-500">@<?= htmlspecialchars($current_user['username']) ?></p>
            </div>
        </div>

        <!-- Stats Table -->
        <div class="grid grid-cols-4 text-center border-t border-b py-4 text-sm font-medium">
            <div>
                <p>Followers</p>
                <p class="text-gray-600">0</p>
            </div>
            <div>
                <p>Following</p>
                <p class="text-gray-600">0</p>
            </div>
            <div>
                <p>Friends</p>
                <p class="text-gray-600">0</p>
            </div>
            <div>
                <p>Threads</p>
                <p class="text-gray-600">0</p>
            </div>
        </div>
    </div>
</main>
