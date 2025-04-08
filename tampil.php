<?php
include 'config.php';

$sql = "SELECT * FROM community ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SpeakUp! Community</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="sidebar">
    <h1>SpeakUp!</h1>
    <a href="#">🏠 Home</a>
    <a href="#">📩 Message</a>
    <a href="#" class="active">👥 Community</a>
    <a href="#">🔖 Bookmark</a>
    <a href="#">⚙️ Settings</a>
</div>

<div class="main">
    <div class="search-bar">
        <input type="text" placeholder="Search">
    </div>

    <div class="question-box">
        <form action="proses.php" method="POST">
            <input type="text" name="username" placeholder="Nama pengguna..." required>
            <textarea name="content" placeholder="Do You Have a Question?" required></textarea>
            <button type="submit">Kirim</button>
        </form>
    </div>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="post">
            <div class="username"><b><?= htmlspecialchars($row['username']) ?></b></div>
            <div class="content"><?= htmlspecialchars($row['content']) ?></div>
        </div>
    <?php } ?>
</div>

<div class="sidebar-right">
    <h3>Trending</h3>

    <div class="trending-item">
        <span>Sains</span>
        <b>Penemuan baru tentang lubang hitam</b>
        <div>78 rb diskusi</div>
    </div>
    <div class="trending-item">
        <span>Kesehatan</span>
        <b>Manfaat minum air putih 8 gelas sehari</b>
        <div>92 rb diskusi</div>
    </div>
    <div class="trending-item">
        <span>Bisnis</span>
        <b>Tips sukses membangun startup</b>
        <div>83 rb diskusi</div>
    </div>
</div>

</body>
</html>