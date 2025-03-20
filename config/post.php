<?php
include 'koneksi.php'; // Hubungkan ke database

// Periksa apakah ada ID post di URL
if (!isset($_GET['id'])) {
    die("Post tidak ditemukan.");
}

$post_id = $_GET['id']; // Ambil ID dari URL

// Ambil data post dari database
$query = "SELECT posts.*, users.username FROM posts 
          JOIN users ON posts.user_id = users.id 
          WHERE posts.id = $post_id";
$result = mysqli_query($koneksi, $query);
$post = mysqli_fetch_assoc($result);

// Jika post tidak ditemukan
if (!$post) {
    die("Post tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post['title']; ?></title>
</head>
<body>

    <h1><?= $post['title']; ?></h1>
    <p>Oleh <b><?= $post['username']; ?></b> pada <?= $post['created_at']; ?></p>
    <hr>
    <p><?= nl2br($post['content']); ?></p>
    <hr>

    <h2>Komentar</h2>
    <ul>
        <?php
        // Ambil komentar yang terkait dengan post ini
        $query = "SELECT comments.content, users.username, comments.created_at 
                  FROM comments 
                  JOIN users ON comments.user_id = users.id 
                  WHERE comments.post_id = $post_id 
                  ORDER BY comments.created_at ASC";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li><b>" . $row['username'] . "</b> (" . $row['created_at'] . ")<br>" . $row['content'] . "</li><hr>";
        }
        ?>
    </ul>

    <!-- Form Tambah Komentar -->
    <h3>Tambahkan Komentar</h3>
    <form action="tambah_komentar.php" method="POST">
        <input type="hidden" name="post_id" value="<?= $post_id; ?>">
        <input type="text" name="username" placeholder="Nama Anda" required><br><br>
        <textarea name="content" placeholder="Isi komentar..." required></textarea><br><br>
        <button type="submit">Kirim</button>
    </form>

</body>
</html>
