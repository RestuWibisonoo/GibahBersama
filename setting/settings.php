<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Default active tab
$active_tab = $_GET['tab'] ?? 'account';

include('../includes/header.php');
?>

<div class="flex-1 flex p-4 space-x-4">
    <!-- Profile Section -->
    <div class="bg-white p-4 rounded-lg w-2/3">
        <?php if ($active_tab === 'account'): ?>
            <h2 class="text-xl font-bold mb-4">Account Settings</h2>
            <div class="flex flex-col items-center">
                <img src="<?= htmlspecialchars('../assets/img/profile_pict/' . $user['profile_pic']) ?>"
                    alt="User profile icon" class="w-24 h-24 mb-4 rounded-full border-2 border-gray-300 object-cover"
                    onerror="this.src='../assets/img/profile_pict/default.jpg'">

                <form method="POST" action="update_account.php" enctype="multipart/form-data" class="w-full space-y-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                            class="w-full p-2 border rounded" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Display Name</label>
                        <input type="text" name="display_name" value="<?= htmlspecialchars($user['display_name']) ?>"
                            class="w-full p-2 border rounded" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                            class="w-full p-2 border rounded" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Bio</label>
                        <textarea name="bio"
                            class="w-full p-2 border rounded"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Profile Picture</label>
                        <input type="file" name="profile_pic" class="w-full p-2 border rounded" accept="image/*">
                    </div>

                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Save Changes
                    </button>
                </form>
            </div>

        <?php elseif ($active_tab === 'password'): ?>
            <h2 class="text-xl font-bold mb-4">Password & Security</h2>
            <form method="POST" action="update_password.php" class="w-full space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">New Password</label>
                    <input type="password" name="new_password" class="w-full p-2 border rounded" required minlength="8">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="w-full p-2 border rounded" required minlength="8">
                </div>

                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    Change Password
                </button>
            </form>

        <?php else: ?>
            <h2 class="text-xl font-bold mb-4">Account Information</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600">Username</p>
                    <p class="font-medium"><?= htmlspecialchars($user['username']) ?></p>
                </div>

                <div>
                    <p class="text-gray-600">Display Name</p>
                    <p class="font-medium"><?= htmlspecialchars($user['display_name']) ?></p>
                </div>

                <div>
                    <p class="text-gray-600">Email</p>
                    <p class="font-medium"><?= htmlspecialchars($user['email']) ?></p>
                </div>

                <div>
                    <p class="text-gray-600">Bio</p>
                    <p class="font-medium"><?= htmlspecialchars($user['bio'] ?? 'No bio provided') ?></p>
                </div>

                <div>
                    <p class="text-gray-600">Account Status</p>
                    <p class="font-medium capitalize"><?= htmlspecialchars($user['status']) ?></p>
                </div>

                <div>
                    <p class="text-gray-600">Member Since</p>
                    <p class="font-medium"><?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Settings Menu -->
    <div class="bg-white p-4 rounded-lg w-1/3">
        <div class="border-b pb-2 mb-2 text-lg font-semibold">Settings</div>
        <ul>
            <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer <?= $active_tab === 'account' ? 'bg-purple-200 font-medium' : '' ?>"
                onclick="changeTab('account')">Account</li>

            <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer <?= $active_tab === 'password' ? 'bg-purple-200 font-medium' : '' ?>"
                onclick="changeTab('password')">Password & Security</li>

            <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer" onclick="changeTab('help')">
                Help</li>

            <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer"
                onclick="changeTab('about')">About</li>

            <li class="py-2 mb-2 text-center hover:bg-gray-200 rounded-full cursor-pointer">
                <a href="../auth/logout.php" class="block w-full">Logout</a>
            </li>
        </ul>
    </div>
</div>

<script>
    function changeTab(tabName) {
        // Update URL and reload
        window.location.href = `?tab=${tabName}`;
    }
</script>

<?php include('../includes/footer.php'); ?>