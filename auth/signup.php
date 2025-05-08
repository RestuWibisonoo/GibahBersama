<?php
session_start();

// Hapus pesan sukses jika tidak berasal dari redirect proses
if (!isset($_GET['from']) || $_GET['from'] != 'proses') {
    unset($_SESSION['success']);
}

// Ambil error dan input lama jika ada
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old_input'] ?? [];

// Hapus session error dan input lama setelah digunakan
unset($_SESSION['errors'], $_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/auth.css"> <!-- Link ke CSS eksternal -->
</head>
<body class="flex h-screen bg-gradient-to-r from-blue-500 to-purple-500 items-center justify-center">
    <div class="w-1/2 hidden lg:flex items-center justify-center">
        <h1 class="text-6xl font-bold text-white">Join Us!</h1>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="glassmorphism w-3/4 max-w-md">
            <h1 class="text-4xl font-bold text-white text-center mb-8">Sign Up</h1>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                    <?= $_SESSION['error'] ?>
                </div>
            <?php unset($_SESSION['error']); endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                    <?= $_SESSION['success'] ?>
                </div>
            <?php endif; ?>

            <form action="proses_signup.php" method="POST">
                <?php
                function input($field) {
                    global $old;
                    return htmlspecialchars($old[$field] ?? '');
                }

                function error($field) {
                    global $errors;
                    if (isset($errors[$field])) {
                        return '<p class="text-sm text-red-200 mt-1">' . $errors[$field] . '</p>';
                    }
                    return '';
                }
                ?>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Full Name</label>
                    <input type="text" name="name" value="<?= input('name') ?>" class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md" placeholder="Full Name">
                    <?= error('name') ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Username</label>
                    <input type="text" name="username" value="<?= input('username') ?>" class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md" placeholder="Username">
                    <?= error('username') ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Email</label>
                    <input type="email" name="email" value="<?= input('email') ?>" class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md" placeholder="example@gmail.com">
                    <?= error('email') ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Password</label>
                    <input type="password" name="password" class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md" placeholder="Password (at least 3 characters)">
                    <?= error('password') ?>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-white">Confirm Password</label>
                    <input type="password" name="confirm_password" class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md" placeholder="Confirm your password">
                    <?= error('confirm_password') ?>
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full py-2 px-4 bg-black text-white font-semibold rounded-md hover:bg-gray-800">Sign Up</button>
                </div>

                <div class="mb-4">
                    <button type="button" onclick="window.location.href='login.php'" class="w-full py-2 px-4 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
                        Already have an account? Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
