<?php
$host = "localhost"; // Server database (biasanya "localhost")
$user = "root"; // Username database (default: "root" jika pakai XAMPP)
$pass = ""; // Password database (kosong jika pakai XAMPP)
$db   = "db_speakup"; // Ganti dengan nama database Anda

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Periksa koneksi
// if (!$koneksi) {
//     die("Koneksi ke database gagal: " . mysqli_connect_error());
// } else {
//     echo "Koneksi berhasil!";
// }
// ?>
