<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        <h1 class="text-6xl font-bold text-white">Speak Up!</h1>
    </div>
    <!-- Right Form Section -->
    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="glassmorphism w-3/4 max-w-md">
            <h1 class="text-4xl font-bold text-white text-center mb-8">Login</h1>
            <form action="proses-login.php" method="post">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white">Email address</label>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md shadow-sm 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md shadow-sm 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <!-- Login button -->
                    <button type="submit" class="w-full py-2 px-4 bg-black text-white font-semibold rounded-md shadow-sm 
                            hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Login   
                    </button>
                </div>
                <div class="mb-4">
                    <!-- Sign Up button -->
                    <button type="button" onclick="window.location.href='signup.php'" class="w-full py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-sm 
                            hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign Up
                    </button>
                </div>
                <div class="mb-4">
                    <!-- Forgot Password button -->
                    <button type="button" onclick="window.location.href='forgot-password.php'" class="w-full py-2 px-4 border border-white text-white font-semibold rounded-md shadow-sm 
                            hover:bg-gray-100 hover:text-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Forgot Password?
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
