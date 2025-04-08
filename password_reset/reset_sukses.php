<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
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
    <!-- Left Section -->
    <div class="w-1/2 hidden lg:flex items-center justify-center">
        <h1 class="text-6xl font-bold text-white">Yahh... Pelupa</h1>
    </div>
    <!-- Right Message Section -->
    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="glassmorphism w-3/4 max-w-md">
            <h1 class="text-4xl font-bold text-white text-center mb-8">Reset Password</h1>
            <p class="text-lg text-white text-center mb-6">Kami telah mengirimkan email untuk mereset password Anda. Silakan cek email Anda untuk melanjutkan.</p>
            <div class="mb-4">
                <button type="button" onclick="window.location.href='login.php'" class="w-full py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-sm 
                        hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Login
                </button>
            </div>
        </div>
    </div>
</body>
</html>