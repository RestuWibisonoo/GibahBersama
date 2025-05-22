<?php
session_start();
require_once '../config/koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

include('../includes/header.php'); // Menyisipkan layout
?>

<!-- Content Settings -->
<div class="flex-1 flex p-4 space-x-4">
    <!-- Profile Section -->
    <div class="bg-white p-4 rounded-lg w-2/3">
        <div class="flex flex-col items-center">
            <img src="https://placehold.co/100x100" alt="User profile icon" class="w-24 h-24 mb-4 rounded-full border-2 border-gray-300">
            <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full">
                <?= htmlspecialchars($user['username'] ?? 'N/A') ?>
            </div>
            <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full">
                <?= htmlspecialchars($user['display_name'] ?? 'Display Name') ?>
            </div>
            <div class="bg-purple-200 w-full text-center py-2 mb-2 rounded-full">
                <?= htmlspecialchars($user['bio'] ?? 'No Bio') ?>
            </div>
        </div>
    </div>

    <!-- Settings Menu -->
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

</body>
</html>
