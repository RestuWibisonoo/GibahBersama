<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    header("Location: reset_sukses.php");
    exit();
}
?>