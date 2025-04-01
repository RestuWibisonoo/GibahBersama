<?php
session_start();

// Clear success message jika datang dari halaman lain
if (!isset($_GET['from']) || $_GET['from'] != 'proses') {
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="flex h-screen bg-gradient-to-r from-blue-500 to-purple-500 items-center justify-center">
    <!-- Left Text Section -->
    <div class="w-1/2 hidden lg:flex items-center justify-center">
        <h1 class="text-6xl font-bold text-white">Join Us!</h1>
    </div>
    
    <!-- Right Form Section -->
    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="glassmorphism w-3/4 max-w-md">
            <h1 class="text-4xl font-bold text-white text-center mb-8">Sign Up</h1>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                    <?= $_SESSION['error']; 
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                    <?= $_SESSION['success']; 
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="proses-signup.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-white">Username</label>
                    <input type="text" id="username" name="username" placeholder="Your username" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md shadow-sm 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white">Email address</label>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md shadow-sm 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md shadow-sm 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-white">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md shadow-sm 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                
                <div class="mb-4">
                    <button type="submit" class="w-full py-2 px-4 bg-black text-white font-semibold rounded-md shadow-sm 
                        hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign Up
                    </button>
                </div>
                
                <div class="mb-4">
                    <button type="button" onclick="window.location.href='login.php'" class="w-full py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-sm 
                        hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Already have an account? Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>