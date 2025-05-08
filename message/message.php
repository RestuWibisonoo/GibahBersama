<?php
session_start();
require_once '../config/koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get recent chats
$query_chats = "
    SELECT 
        m.sender_id, 
        m.receiver_id, 
        u.username, 
        u.display_name, 
        u.profile_pic, 
        m.content as message,
        m.created_at as timestamp 
    FROM messages m
    JOIN users u ON (u.id = m.sender_id OR u.id = m.receiver_id) AND u.id != ?
    WHERE m.id IN (
        SELECT MAX(id) 
        FROM messages 
        WHERE sender_id = ? OR receiver_id = ?
        GROUP BY LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)
    )
    ORDER BY m.created_at DESC";
    
$stmt_chats = $pdo->prepare($query_chats);
$stmt_chats->execute([$user_id, $user_id, $user_id]);
$chats = $stmt_chats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeakUp! - Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .chat-container {
            height: calc(100vh - 200px);
            overflow-y: auto;
        }
        .chat-list-container {
            height: calc(100vh - 150px);
            overflow-y: auto;
        }
        #search-results {
            position: absolute;
            width: calc(100% - 2rem);
            background: white;
            z-index: 100;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-height: 300px;
            overflow-y: auto;
        }
        .search-result-item:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/5 bg-white p-6">
            <h1 class="text-3xl font-bold mb-10">SpeakUp!</h1>
            <nav class="space-y-6">
                <a href="home.php" class="flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/home.png" class="w-6 h-6" alt="Home">
                    <span>Home</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold bg-gray-200 rounded-lg px-4 py-3">
                    <img src="icons/message-click.png" class="w-6 h-6" alt="Message">
                    <span>Message</span>
                </a>
                <a href="community.php" class="flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/community.png" class="w-6 h-6" alt="Community">
                    <span>Community</span>
                </a>
                <a href="bookmark.php" class="flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/bookmark.png" class="w-6 h-6" alt="Bookmark">
                    <span>Bookmark</span>
                </a>
                <a href="settings.php" class="flex items-center space-x-3 text-gray-700 hover:text-black w-full text-lg font-semibold">
                    <img src="icons/setting.png" class="w-6 h-6" alt="Settings">
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Bar (Simplified) -->
            <header class="flex items-center justify-between bg-white p-4 shadow">
                <div class="flex items-center">
                    <img id="current-chat-user-pic" class="w-10 h-10 rounded-full" src="assets/default-profile.jpg" alt="User">
                    <span id="current-chat-user" class="ml-3 text-lg font-semibold">Select a chat</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="p-2 rounded-full hover:bg-gray-200">
                        <img src="icons/note.png" width="24" height="24">
                    </a>
                    <a href="#" class="p-2 rounded-full hover:bg-gray-200">
                        <img src="icons/notification.png" width="24" height="24">
                    </a>
                    <a href="profile.php" class="p-2 rounded-full hover:bg-gray-200">
                        <img src="icons/profile.png" width="24" height="24">
                    </a>
                </div>
            </header>

            <!-- Main Chat Section -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Chat Area -->
                <div class="flex-1 flex flex-col bg-white">
                    <div class="flex-1 overflow-y-auto p-4 chat-container" id="messages-container">
                        <div class="text-center text-gray-500 py-10">Select a conversation to start chatting</div>
                    </div>
                    
                    <div class="border-t p-4">
                        <div class="flex items-center">
                            <input type="text" id="message-input" class="flex-1 border rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type a message...">
                            <button id="send-button" class="ml-2 bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Chat List with Search -->
                <div class="w-1/3 bg-gray-100 border-l flex flex-col">
                    <div class="p-4 border-b">
                        <div class="relative">
                            <input type="text" id="user-search" placeholder="Search or start new chat..." 
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <div id="search-results" class="hidden mt-1"></div>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto chat-list-container" id="chat-list">
                        <?php foreach ($chats as $chat): ?>
                            <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer chat-item"
                                 data-user-id="<?php echo $chat['sender_id'] == $user_id ? $chat['receiver_id'] : $chat['sender_id']; ?> "
                                 data-username="<?php echo htmlspecialchars($chat['username']); ?>"
                                 data-display-name="<?php echo htmlspecialchars($chat['display_name']); ?>"
                                 data-profile-pic="<?php echo htmlspecialchars($chat['profile_pic']); ?>">
                                <img class="w-10 h-10 rounded-full" src="<?php echo htmlspecialchars($chat['profile_pic']); ?>" alt="User">
                                <div class="ml-3">
                                    <p class="font-semibold"><?php echo htmlspecialchars($chat['display_name']); ?></p>
                                    <p class="text-sm text-gray-500 truncate max-w-xs"><?php echo htmlspecialchars($chat['message']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    $(document).ready(function() {
        let currentChatUserId = null;
        
        // Instant search functionality
        $('#user-search').on('input', function() {
            const query = $(this).val().trim();
            
            if (query.length < 2) {
                $('#search-results').addClass('hidden').empty();
                return;
            }
            
            $.ajax({
                url: 'proses_message.php',
                type: 'POST',
                data: { 
                    action: 'instant_search',
                    query: query
                },
                beforeSend: function() {
                    $('#search-results').html('<div class="p-3 text-gray-500"><i class="fas fa-spinner fa-spin"></i> Searching...</div>').removeClass('hidden');
                },
                success: function(response) {
                    $('#search-results').html(response);
                    if (!response || response.includes('no-results')) {
                        setTimeout(() => $('#search-results').addClass('hidden'), 1500);
                    }
                },
                error: function() {
                    $('#search-results').html('<div class="p-3 text-red-500"><i class="fas fa-exclamation-circle"></i> Search error</div>');
                }
            });
        });
        
        // Click on search result
        $(document).on('click', '.search-result-item', function() {
            const userId = $(this).data('user-id');
            const username = $(this).data('username');
            const displayName = $(this).data('display-name');
            const profilePic = $(this).data('profile-pic');
            
            // Check if chat exists
            let chatItem = $(`.chat-item[data-user-id="${userId}"]`);
            
            if (chatItem.length === 0) {
                // Create new chat if doesn't exist
                const newChat = `...`;
                $('#chat-list').prepend(newChat);
                chatItem = $(newChat);
            }
            
            // Set as active chat
            chatItem.addClass('bg-blue-100');
            $('.chat-item').not(chatItem).removeClass('bg-blue-100');
            
            // Load messages
            $('#current-chat-user').text(displayName);
            $('#current-chat-user-pic').attr('src', profilePic);
            loadMessages(userId);
            
            // Reset search
            $('#user-search').val('');
            $('#search-results').addClass('hidden').empty();
        });

        function loadMessages(userId) {
            currentChatUserId = userId;
            
            $.ajax({
                url: 'proses_message.php',
                type: 'POST',
                data: { 
                    action: 'get_messages',
                    receiver_id: userId
                },
                beforeSend: function() {
                    $('#messages-container').html('<div class="text-center py-10"><i class="fas fa-spinner fa-spin text-blue-500"></i> Loading messages...</div>');
                },
                success: function(response) {
                    $('#messages-container').html(response);
                    scrollToBottom();
                },
                error: function() {
                    $('#messages-container').html('<div class="text-center text-red-500 py-10">Error loading messages</div>');
                }
            });
        }

        function sendMessage() {
            const message = $('#message-input').val().trim();
            
            if (!message || !currentChatUserId) return;
            
            $.ajax({
                url: 'proses_message.php',
                type: 'POST',
                data: {
                    action: 'send_message',
                    receiver_id: currentChatUserId,
                    message: message
                },
                success: function() {
                    $('#message-input').val('');
                    loadMessages(currentChatUserId);
                },
                error: function() {
                    alert('Failed to send message');
                }
            });
        }
        
        $('#send-button').click(sendMessage);
        $('#message-input').keypress(function(e) {
            if (e.which === 13) sendMessage();
        });

        function scrollToBottom() {
            const container = $('#messages-container');
            container.scrollTop(container[0].scrollHeight);
        }
    });
    </script>
</body>
</html>
