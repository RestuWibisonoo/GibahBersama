<?php
include 'config.php';
$result = $conn->query("SELECT * FROM messages WHERE (sender='Iron Man' AND receiver='You') OR (sender='You' AND receiver='Iron Man') ORDER BY created_at ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Message - SpeakUp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <h2>SpeakUp!</h2>
        <ul>
            <li><a href="#">Home</a></li>
            <li class="active"><a href="#">Message</a></li>
            <li><a href="#">Community</a></li>
            <li><a href="#">Bookmark</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </aside>
    <main class="chat-area">
        <div class="chat-header">
            <h3>Iron Man</h3>
        </div>
        <div class="chat-box">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="<?= $row['sender'] == 'You' ? 'message user' : 'message friend' ?>">
                    <?= htmlspecialchars($row['message']) ?>
                </div>
            <?php endwhile; ?>
        </div>
        <form class="chat-input" action="send_message.php" method="POST">
            <input type="hidden" name="sender" value="You">
            <input type="hidden" name="receiver" value="Iron Man">
            <input type="text" name="message" placeholder="Write a message..." required>
            <button type="submit">➤</button>
        </form>
    </main>
    <aside class="chat-list">
        <h4>Chats</h4>
        <ul>
            <li><strong>Iron Man</strong><br><small>Kadamudu judugada.</small></li>
            <li>Faizal<br><small>Ayo mokel</small></li>
            <li>Sophia<br><small>sap broo??</small></li>
        </ul>
    </aside>
</div>
</body>
</html>
