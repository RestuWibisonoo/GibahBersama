<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body class="flex h-screen bg-gradient-to-r from-blue-500 to-purple-500 items-center justify-center">
    <!-- Left Section -->
    <div class="w-1/2 hidden lg:flex items-center justify-center">
        <h1 class="text-6xl font-bold text-white">Yahh... Pelupa</h1>
    </div>
    <!-- Right Form Section -->
    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="glassmorphism w-3/4 max-w-md">
            <h1 class="text-4xl font-bold text-white text-center mb-8">Forgot Password</h1>
            <form>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white">Email address</label>
                    <input type="email" id="email" placeholder="Enter your email" 
                        class="mt-1 block w-full px-3 py-2 bg-transparent border border-white text-white rounded-md 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-6">
                    <button type="submit" class="w-full py-2 px-4 bg-black text-white font-semibold rounded-md shadow-sm 
                            hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset Password
                    </button>
                </div>
                <div class="mb-4">
                    <button type="button" onclick="window.location.href='login.php'" class="w-full py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-sm 
                            hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Back to Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
