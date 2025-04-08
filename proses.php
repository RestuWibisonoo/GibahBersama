<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $content = $_POST['content'];

    $sql = "INSERT INTO community (username, content) VALUES ('$username', '$content')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: tampil.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>