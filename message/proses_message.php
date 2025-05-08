<?php
session_start();
require_once 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit(json_encode(['error' => 'Unauthorized']));
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'get_messages':
                if (!isset($_POST['receiver_id'])) {
                    throw new Exception('Receiver ID is required');
                }
                
                $receiver_id = (int)$_POST['receiver_id'];
                
                $stmt = $koneksi->prepare("
                    SELECT m.id, m.sender_id, m.receiver_id, m.content as message, 
                           m.created_at as timestamp, m.status,
                           u.display_name, u.username, u.profile_pic
                    FROM messages m
                    JOIN users u ON m.sender_id = u.id
                    WHERE (m.sender_id = ? AND m.receiver_id = ?)
                       OR (m.sender_id = ? AND m.receiver_id = ?)
                    ORDER BY m.created_at ASC
                ");
                $stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $messages = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                if (empty($messages)) {
                    echo '<div class="text-center text-gray-500 py-4">No messages yet</div>';
                    break;
                }

                foreach ($messages as $msg) {
                    $is_sender = ($msg['sender_id'] == $user_id);
                    $align_class = $is_sender ? 'justify-end' : 'justify-start';
                    $bg_class = $is_sender ? 'bg-blue-500 text-white' : 'bg-gray-300';
                    
                    echo '<div class="flex '.$align_class.' mb-4 message-item" data-message-id="'.$msg['id'].'">';
                    echo '  <div class="max-w-xs">';
                    if (!$is_sender) {
                        echo '    <div class="text-sm font-semibold">'.htmlspecialchars($msg['display_name']).'</div>';
                    }
                    echo '    <div class="'.$bg_class.' p-3 rounded-lg">'.htmlspecialchars($msg['message']).'</div>';
                    echo '    <div class="text-xs text-gray-500 mt-1">'.date('h:i A', strtotime($msg['timestamp'])).'</div>';
                    echo '  </div>';
                    echo '</div>';
                }
                break;

            case 'send_message':
                if (!isset($_POST['receiver_id']) || !isset($_POST['message'])) {
                    throw new Exception('Receiver ID and message are required');
                }
                
                $receiver_id = (int)$_POST['receiver_id'];
                $message = trim($_POST['message']);
                
                if (empty($message)) {
                    throw new Exception('Message cannot be empty');
                }
                
                $stmt = $koneksi->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $user_id, $receiver_id, $message);
                $stmt->execute();
                $stmt->close();
                
                echo json_encode(['success' => true]);
                break;

            case 'instant_search':
                if (!isset($_POST['query']) || strlen(trim($_POST['query'])) < 2) {
                    echo '<div class="p-3 text-gray-500">Type at least 2 characters</div>';
                    break;
                }
                
                $searchTerm = trim($_POST['query']);
                $query = $koneksi->real_escape_string($searchTerm) . '%';
                
                $stmt = $koneksi->prepare("
                    SELECT id, username, display_name, profile_pic 
                    FROM users 
                    WHERE (username LIKE ? OR display_name LIKE ?)
                    AND id != ?
                    AND status = 'active'
                    ORDER BY 
                        CASE 
                            WHEN username LIKE ? THEN 0
                            WHEN display_name LIKE ? THEN 1
                            ELSE 2
                        END
                    LIMIT 5
                ");
                $stmt->bind_param("ssiss", $query, $query, $user_id, $query, $query);
                $stmt->execute();
                $result = $stmt->get_result();
                $users = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                if (empty($users)) {
                    echo '<div class="p-3 text-gray-500">No users found</div>';
                    break;
                }

                $html = '';
                foreach ($users as $user) {
                    $html .= '
                    <div class="p-3 hover:bg-gray-100 cursor-pointer search-result-item border-b border-gray-100"
                         data-user-id="'.$user['id'].'"
                         data-username="'.htmlspecialchars($user['username']).'"
                         data-display-name="'.htmlspecialchars($user['display_name']).'"
                         data-profile-pic="'.htmlspecialchars($user['profile_pic']).'">
                        <div class="flex items-center">
                            <img src="'.htmlspecialchars($user['profile_pic']).'" 
                                 class="w-10 h-10 rounded-full mr-3" 
                                 alt="'.htmlspecialchars($user['display_name']).'">
                            <div>
                                <div class="font-semibold">'.htmlspecialchars($user['display_name']).'</div>
                                <div class="text-sm text-gray-500">@'.htmlspecialchars($user['username']).'</div>
                            </div>
                        </div>
                    </div>';
                }
                
                echo $html;
                break;

            default:
                throw new Exception('Invalid action');
        }
    } catch (Exception $e) {
        header('HTTP/1.1 400 Bad Request');
        exit(json_encode(['error' => $e->getMessage()]));
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    exit(json_encode(['error' => 'Method not allowed']));
}