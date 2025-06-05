<?php
$host = 'localhost';
$db   = 'db_speakup'; // Ganti dengan nama database Anda
$user = 'root';       // Ganti dengan username database Anda
$pass = '';           // Ganti dengan password database Anda

try {
    // Data Source Name (DSN)
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    // Buat instance PDO
    $pdo = new PDO($dsn, $user, $pass);

    // Set atribut error mode agar lempar exception saat error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Matikan emulasi prepared statement untuk keamanan ekstra
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
