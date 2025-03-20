<?php
include 'koneksi.php'; // Hubungkan ke database
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi</title>
</head>
<body>
    <h1>Forum Diskusi</h1>
    
    <h2>Daftar Post</h2>
    <ul>
        <?php
        // Ambil daftar post dari database
        $query = "SELECT posts.id, posts.title, users.username, posts.created_at 
                  FROM posts 
                  JOIN users ON posts.user_id = users.id 
                  ORDER BY posts.created_at DESC";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>
                    <a href='post.php?id=" . $row['id'] . "'>" . $row['title'] . "</a> 
                    - oleh <b>" . $row['username'] . "</b> 
                    pada " . $row['created_at'] . "
                  </li>";
        }
        ?>
    </ul>

</body>
</html>