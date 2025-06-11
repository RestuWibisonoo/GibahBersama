<?php
session_start();
require_once '../config/koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user data from database
$stmt = $pdo->prepare("
    SELECT id, username, display_name, email, profile_pic, bio, role, status, created_at 
    FROM users 
    WHERE id = :user_id
");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if user not found
if (!$user) {
    $_SESSION['error_message'] = "User account not found";
    header("Location: ../auth/login.php");
    exit();
}

// Set active tab (default: account)
$active_tab = isset($_GET['tab']) ? htmlspecialchars($_GET['tab']) : 'account';

// Display success/error messages
$success_message = '';
$error_message = '';

if (isset($_SESSION['success_message'])) {
    $success_message = htmlspecialchars($_SESSION['success_message']);
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $error_message = htmlspecialchars($_SESSION['error_message']);
    unset($_SESSION['error_message']);
}

// Include header
include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- SIDEBAR MENU -->
            <div class="w-full md:w-1/4 bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-bold mb-4 border-b pb-2">Settings</h2>
                <ul class="space-y-2">
                    <!-- Account Tab -->
                    <li>
                        <a href="?tab=account"
                            class="block px-4 py-2 rounded-lg hover:bg-purple-50 transition <?= $active_tab === 'account' ? 'bg-purple-100 text-purple-700 font-medium' : '' ?>">
                            <i class="fas fa-user-circle mr-2"></i> Account Settings
                        </a>
                    </li>

                    <!-- Password Tab -->
                    <li>
                        <a href="?tab=password"
                            class="block px-4 py-2 rounded-lg hover:bg-purple-50 transition <?= $active_tab === 'password' ? 'bg-purple-100 text-purple-700 font-medium' : '' ?>">
                            <i class="fas fa-lock mr-2"></i> Password & Security
                        </a>
                    </li>

                    <!-- Help Tab -->
                    <li>
                        <a href="?tab=help"
                            class="block px-4 py-2 rounded-lg hover:bg-purple-50 transition <?= $active_tab === 'help' ? 'bg-purple-100 text-purple-700 font-medium' : '' ?>">
                            <i class="fas fa-question-circle mr-2"></i> Help Center
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="border-t mt-2 pt-2">
                        <a href="../auth/logout.php"
                            class="block px-4 py-2 rounded-lg hover:bg-red-50 text-red-600 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="w-full md:w-3/4 bg-white rounded-lg shadow p-6">
                <!-- Success/Error Messages -->
                <?php if (!empty($success_message)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <?= $success_message ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <?= $error_message ?>
                    </div>
                <?php endif; ?>

                <!-- ACCOUNT SETTINGS TAB -->
                <?php if ($active_tab === 'account'): ?>
                    <h2 class="text-2xl font-bold mb-6">Account Settings</h2>

                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Profile Picture Section -->
                        <div class="md:w-1/3 flex flex-col items-center">
                            <img src="<?= htmlspecialchars('../assets/img/profile_pict/' . ($user['profile_pic'] ?? 'default.jpg')) ?>"
                                alt="Profile Picture"
                                class="w-32 h-32 rounded-full object-cover border-4 border-purple-200 mb-4"
                                onerror="this.src='../assets/img/profile_pict/default.jpg'">

                            <form method="POST" action="update_account.php" enctype="multipart/form-data" class="w-full">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Change Profile
                                        Picture</label>
                                    <input type="file" name="profile_pic" accept="image/jpeg,image/png,image/gif"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                    <p class="text-xs text-gray-500 mt-1">JPEG, PNG or GIF (Max 2MB)</p>
                                </div>
                        </div>

                        <!-- Account Details Form -->
                        <div class="md:w-2/3">
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                                    <input type="text" name="display_name"
                                        value="<?= htmlspecialchars($user['display_name']) ?>"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                    <textarea name="bio" rows="3"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <button type="submit"
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition font-medium">
                                Save Changes
                            </button>
                            </form>
                        </div>
                    </div>

                    <!-- PASSWORD SETTINGS TAB -->
                <?php elseif ($active_tab === 'password'): ?>
                    <h2 class="text-2xl font-bold mb-6">Password & Keamanan</h2>

                    <?php if (isset($error_message)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <?= $error_message ?>
                            <?php if (strpos($error_message, 'salah') !== false): ?>
                                <div class="mt-2 text-sm">
                                    <p>Troubleshooting:</p>
                                    <ul class="list-disc pl-5">
                                        <li>Periksa Caps Lock</li>
                                        <li>Pastikan tidak ada spasi di awal/akhir</li>
                                        <li>Coba ketik password di text editor dulu</li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="update_password.php" class="max-w-lg">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                                <input type="password" name="current_password"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                    required placeholder="Masukkan password saat ini">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="new_password" minlength="8"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                    required placeholder="Minimal 8 karakter">
                                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" minlength="8"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                    required placeholder="Ketik ulang password baru">
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition font-medium">
                                    Ubah Password
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- HELP TAB -->
                <?php elseif ($active_tab === 'help'): ?>
                    <h2 class="text-2xl font-bold mb-6">Help Center</h2>
                    <div class="prose max-w-none">
                        <div class="space-y-4">
                            <div class="p-4 border rounded-lg">
                                <h3 class="font-bold text-lg text-purple-700"><i
                                        class="fas fa-question-circle mr-2"></i>FAQs</h3>
                                <p class="mt-2">Find answers to common questions in our <a href="#"
                                        class="text-purple-600 hover:underline">Frequently Asked Questions</a> section.</p>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h3 class="font-bold text-lg text-purple-700"><i class="fas fa-envelope mr-2"></i>Contact
                                    Support</h3>
                                <p class="mt-2">Need personalized help? <a href="#"
                                        class="text-purple-600 hover:underline">Contact our support team</a>.</p>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h3 class="font-bold text-lg text-purple-700"><i class="fas fa-users mr-2"></i>Community
                                    Forum</h3>
                                <p class="mt-2">Join our <a href="#" class="text-purple-600 hover:underline">community
                                        forum</a> to connect with other users.</p>
                            </div>
                        </div>
                    </div>

                    <!-- DEFAULT TAB (Account Info) -->
                <?php else: ?>
                    <h2 class="text-2xl font-bold mb-6">Account Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Username</p>
                                <p class="font-medium"><?= htmlspecialchars($user['username']) ?></p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Display Name</p>
                                <p class="font-medium"><?= htmlspecialchars($user['display_name']) ?></p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Role</p>
                                <p class="font-medium capitalize"><?= htmlspecialchars($user['role']) ?></p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium capitalize"><?= htmlspecialchars($user['status']) ?></p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="font-medium"><?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($user['bio'])): ?>
                        <div class="mt-6">
                            <p class="text-sm text-gray-500">Bio</p>
                            <p class="font-medium"><?= htmlspecialchars($user['bio']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>

</html>