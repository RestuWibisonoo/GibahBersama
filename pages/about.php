<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeakUp!</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="text-white">

    <!-- Navbar -->
    <nav class="flex justify-between items-center p-6 bg-white shadow-md">
        <div class="text-2xl font-bold text-black">SpeakUp!</div>
        <div class="hidden md:flex space-x-6">
            <a href="#" class="text-black hover:text-gray-600">Groups</a>
            <a href="#" class="text-black hover:text-gray-600">Trending</a>
            <a href="#" class="text-black hover:text-gray-600">Discover</a>
        </div>
        <div class="flex items-center space-x-4 relative">
            <!-- Notifikasi -->
            <div class="notif-container relative cursor-pointer">
                <img src="assets/notif.png" alt="Notifikasi" class="w-6 h-6" id="notifIcon">
                <div class="notif-popup absolute w-48">
                    <p>Tidak ada notifikasi baru</p>
                </div>
            </div>
            
            <input type="text" placeholder="Search" class="px-3 py-1 text-black border border-gray-300 rounded-md">
            <button onclick="window.location.href='login.html'" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800">Login</button>
        </div>
    </nav>

    <!-- About Us Section -->
    <section class="relative bg-cover bg-center h-screen" style="background-image: url('assets/backgroundus.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center text-white py-32">
            <h1 class="text-5xl font-bold mb-4">About Us</h1>
            <p class="text-xl max-w-3xl mx-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, doloremque iste dolore mollitia molestias quasi pariatur sapiente eum, repellendus quidem distinctio, totam optio fugiat. Et eaque placeat assumenda qui reiciendis?</p>
        </div>
    </section>

    <!-- Footer (optional) -->
    <footer class="bg-black text-white py-6 text-center">
        <p>&copy; 2025 SpeakUp! All rights reserved.</p>
    </footer>

</body>
</html>
