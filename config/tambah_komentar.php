<?php
include 'koneksi.php'; // Hubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $content = mysqli_real_escape_string($koneksi, $_POST['content']);

    // Cari user berdasarkan username
    $user_query = "SELECT id FROM users WHERE username = '$username'";
    $user_result = mysqli_query($koneksi, $user_query);
    
    if (mysqli_num_rows($user_result) > 0) {
        $user = mysqli_fetch_assoc($user_result);
        $user_id = $user['id'];

        // Simpan komentar ke database
        $query = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";
        mysqli_query($koneksi, $query);
    }
}

// Kembali ke halaman post
header("Location: post.php?id=$post_id");
exit;
?>
