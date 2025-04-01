<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SpeakUp! Full Screen Pop Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-white min-h-screen flex items-center justify-center">
    <!-- Fullscreen Modal -->
    <form method="POST" action="proses-posts.php" class="absolute inset-0 bg-white p-6 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-4">
                <img alt="User avatar" class="rounded-full" height="40" src="https://placehold.co/40x40" width="40" />
                <h2 class="text-lg font-semibold">Apa Yang Ingin Anda Diskusikan?</h2>
            </div>
            <button type="button" onclick="parent.closePopup()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Input untuk Title -->
        <input name="title" class="w-full bg-transparent border-b border-gray-300 focus:outline-none py-2 text-lg font-medium" 
            placeholder="Judul Diskusi" type="text" required />
        
        <!-- Input untuk Konten -->
        <textarea name="content" class="mt-4 w-full bg-transparent border-b border-gray-300 focus:outline-none py-2 h-64"
            placeholder="Apa Yang Ingin Anda Diskusikan?" required></textarea>
        
        <div class="flex justify-between items-center border-t pt-4 mt-auto">
            <div class="flex space-x-4 text-gray-500">
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/add-image.png" alt="Add Images" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/smile.png" alt="Smile" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/gift.png" alt="Gift" class="w-6 h-6" />
                </a>
                <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                    <img src="icons/location.png" alt="Location" class="w-6 h-6" />
                </a>
            </div>
            <div class="flex space-x-4">
                <button type="button" class="text-gray-500">Draft</button>
                <button type="submit" name="submit" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-full">Post</button>
            </div>
        </div>
    </form>
</body>
</html>