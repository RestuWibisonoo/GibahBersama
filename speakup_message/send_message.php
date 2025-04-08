<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_POST["sender"];
    $receiver = $_POST["receiver"];
    $message = $_POST["message"];

    $sql = "INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $sender, $receiver, $message);
    $stmt->execute();
    $stmt->close();
}

header("Location: message.php");
exit();
?>
