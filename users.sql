-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Bulan Mei 2025 pada 08.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_speakup`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.jpg',
  `bio` text DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `display_name`, `email`, `password`, `profile_pic`, `bio`, `role`, `status`, `created_at`, `updated_at`) VALUES
(2, 'restu', 'Restu Wibisono', 'restu@gmail.com', 'aaa', 'default.jpg', NULL, 'user', 'active', '2025-04-23 11:18:31', '2025-04-23 11:18:31'),
(3, 'user2', 'user2nihbos', 'user2@gmail.com', 'aaa', 'default.jpg', NULL, 'user', 'active', '2025-05-03 01:44:22', '2025-05-03 01:44:22'),
(4, 'user3', 'user3ya', 'user3@gmail.com', 'aaa', 'default.jpg', NULL, 'user', 'active', '2025-05-03 02:16:44', '2025-05-03 07:18:30'),
(5, 'user4', 'user4', 'user4@gmail.com', 'aaa', 'default.jpg', NULL, 'user', 'active', '2025-05-03 02:18:54', '2025-05-03 02:18:54'),
(6, 'Restuu', 'Restu Wibisono', 'restuuu@gmail.com', 'aaa', 'default.jpg', NULL, 'user', 'active', '2025-05-03 22:39:47', '2025-05-03 22:39:47'),
(7, 'user5', 'user5pict', 'user5@gmail.com', 'aaa', 'profile_6817292376ef3.jpg', NULL, 'user', 'active', '2025-05-04 03:45:23', '2025-05-04 03:45:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
