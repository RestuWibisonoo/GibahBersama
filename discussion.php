<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<title>SpeakUp!</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
	</head>
	<body class="bg-purple-100 font-sans">
		<div class="flex h-screen">
			<!-- Sidebar -->
			<aside class="w-1/5 bg-white p-6">
                <h1 class="text-3xl font-bold mb-10">SpeakUp!</h1>
                <nav class="space-y-6">
                    <a href="#"
                        class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-300 rounded-lg px-4 py-3">
                        <img src="icons/home-click.png" class="w-6 h-6" alt="Home" />
                        <span>Home</span>
                    </a>
                    <a href="message.html"
                        class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                        <img src="icons/message.png" class="w-6 h-6" alt="Message" />
                        <span>Message</span>
                    </a>
                    <a href="community.html"
                        class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                        <img src="icons/community.png" class="w-6 h-6" alt="Community" />
                        <span>Community</span>
                    </a>
                    <a href="bookmark.html"
                        class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                        <img src="icons/bookmark.png" class="w-6 h-6" alt="Bookmark" />
                        <span>Bookmark</span>
                    </a>
                    <a href="settings.html"
                        class="nav-button flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                        <img src="icons/setting.png" class="w-6 h-6" alt="Settings" />
                        <span>Settings</span>
                    </a>
                </nav>
            </aside>

			<!-- Main Content -->
			<main class="flex-1 flex flex-col">
				<!-- Top Bar -->
                <header class="flex items-center justify-between bg-gray-200 p-4 shadow">
                    <!-- Left side (Back Button and Search Bar) -->
                    <div class="flex items-center space-x-4">
                        <!-- Back Button -->
                        <a href="#" class="p-2 rounded-full hover:bg-gray-200">
                            <img src="icons/back.png" width="24" height="24" alt="Back" />
                        </a>
            
                        <!-- Search Bar -->
                        <div class="flex-1 relative">
                            <input type="text" placeholder="Search"
                                class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <img src="icons/search.png"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                        </div>
                    </div>
            
                    <!-- Right side (Icons and Navigation) -->
                    <div class="flex items-center space-x-4">
                        <a href="#" onclick="openPopup()" class="p-3 rounded-full hover:bg-gray-200">
                            <img src="icons/note.png" width="28" height="28" />
                        </a>
                        <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                            <img src="icons/notification.png" width="28" height="28" />
                        </a>
                        <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                            <img src="icons/globe.png" width="28" height="28" />
                        </a>
                        <a href="#" class="p-3 rounded-full hover:bg-gray-200">
                            <img src="icons/profile.png" width="28" height="28" />
                        </a>
                        <a href="login.html" class="p-3 rounded-full hover:bg-gray-200">
                            <img src="icons/logout.png" width="28" height="28" />
                        </a>
                    </div>
                </header>

				<!-- Content -->
				<div class="flex-1 flex p-4 space-x-4">
					<!-- Questions and Replies -->
					<div class="w-2/3 bg-white p-4 rounded-lg shadow space-y-4">
						<div class="border-b border-gray-300 pb-4">
							<div class="flex items-center space-x-2 mb-2">
								<img alt="User avatar" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/5tx3EbgMWlO9B9ZoGiHdbzB12Ds1aDMzTXaHWSr8vEU.jpg" width="40" />
								<div>
									<p class="font-bold">Display Name</p>
									<p class="text-gray-500">@username</p>
								</div>
							</div>
							<p class="mb-4">Apa yang menyebabkan naga tidak bisa dijadikan hewan qurban?</p>
							<button class="flex items-center space-x-1 text-purple-500">
								<i class="fas fa-pen"></i>
								<span>Answer</span>
							</button>
						</div>
						<div class="border-b border-gray-300 pb-4">
							<div class="flex items-center space-x-2 mb-2">
								<img alt="User avatar" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/5tx3EbgMWlO9B9ZoGiHdbzB12Ds1aDMzTXaHWSr8vEU.jpg" width="40" />
								<div>
									<p class="font-bold">Display Name</p>
									<p class="text-gray-500">@username</p>
								</div>
							</div>
							<p class="mb-4">Naga bukan hewan ternak kak, selain itu naga berkuku tajam dan bertaring</p>
							<button class="flex items-center space-x-1 text-purple-500">
								<i class="fas fa-pen"></i>
								<span>Answer</span>
							</button>
						</div>
						<div>
							<div class="flex items-center space-x-2 mb-2">
								<img alt="User avatar" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/5tx3EbgMWlO9B9ZoGiHdbzB12Ds1aDMzTXaHWSr8vEU.jpg" width="40" />
								<div>
									<p class="font-bold">Display Name</p>
									<p class="text-gray-500">@username</p>
								</div>
							</div>
							<p class="mb-4">Kalau kita ternak naga, terus kuku sama taringnya dipotong boleh?</p>
							<button class="flex items-center space-x-1 text-purple-500">
								<i class="fas fa-pen"></i>
								<span>Answer</span>
							</button>
						</div>
					</div>

					<!-- Trending -->
					<div class="w-1/3 space-y-4">
						<div class="bg-white p-4 rounded-lg shadow">
							<h2 class="font-bold mb-4">Trending</h2>
							<div class="space-y-2">
								<div>
									<p class="text-gray-500">Pendidikan</p>
									<p class="font-bold">Semua seputar pendidikan</p>
									<p class="text-gray-500">104 rb diskusi</p>
								</div>
								<div>
									<p class="text-gray-500">Pendidikan</p>
									<p class="font-bold">Semua seputar pendidikan</p>
									<p class="text-gray-500">104 rb diskusi</p>
								</div>
								<div>
									<p class="text-gray-500">Pendidikan</p>
									<p class="font-bold">Semua seputar pendidikan</p>
									<p class="text-gray-500">104 rb diskusi</p>
								</div>
								<div>
									<p class="text-gray-500">Pendidikan</p>
									<p class="font-bold">Semua seputar pendidikan</p>
									<p class="text-gray-500">104 rb diskusi</p>
								</div>
								<div>
									<p class="text-gray-500">Pendidikan</p>
									<p class="font-bold">Semua seputar pendidikan</p>
									<p class="text-gray-500">104 rb diskusi</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</body>
</html>
