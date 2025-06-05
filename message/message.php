<?php
session_start();
require_once '../config/koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

include('../includes/header.php'); // Menyisipkan layout
?>

<!-- Mulai konten khusus halaman Message -->
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
            <?php
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

            foreach ($chats as $chat):
                $chatUserId = $chat['sender_id'] == $user_id ? $chat['receiver_id'] : $chat['sender_id'];
            ?>
            <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer chat-item"
                 data-user-id="<?= $chatUserId ?>"
                 data-username="<?= htmlspecialchars($chat['username']) ?>"
                 data-display-name="<?= htmlspecialchars($chat['display_name']) ?>"
                 data-profile-pic="<?= htmlspecialchars($chat['profile_pic']) ?>">
                <img class="w-10 h-10 rounded-full" src="<?= htmlspecialchars($chat['profile_pic']) ?>" alt="User">
                <div class="ml-3">
                    <p class="font-semibold"><?= htmlspecialchars($chat['display_name']) ?></p>
                    <p class="text-sm text-gray-500 truncate max-w-xs"><?= htmlspecialchars($chat['message']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Akhir konten Message -->

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // JavaScript/jQuery sama seperti sebelumnya
</script>
</body>
</html>
