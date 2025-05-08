-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Bulan Mei 2025 pada 08.28
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
-- Struktur dari tabel `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `answers`
--

INSERT INTO `answers` (`id`, `post_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 14, 3, 'asdas', '2025-05-04 04:12:53', '2025-05-04 04:12:53'),
(2, 13, 3, 'asd', '2025-05-04 04:14:19', '2025-05-04 04:14:19'),
(3, 13, 3, 'asdas', '2025-05-04 04:17:17', '2025-05-04 04:17:17'),
(4, 3, 3, 'apakah masuk trending', '2025-05-04 04:17:31', '2025-05-04 04:17:31'),
(5, 3, 3, 'xac', '2025-05-04 04:17:36', '2025-05-04 04:17:36'),
(6, 14, 4, 'asda', '2025-05-04 04:35:25', '2025-05-04 04:35:25'),
(7, 2, 4, 'asdada', '2025-05-04 04:35:39', '2025-05-04 04:35:39'),
(10, 15, 4, 'halah boong', '2025-05-04 08:21:22', '2025-05-04 08:21:22'),
(11, 12, 4, 'boong', '2025-05-04 08:21:37', '2025-05-04 08:21:37'),
(12, 12, 4, 'asdads', '2025-05-04 08:21:43', '2025-05-04 08:21:43'),
(13, 12, 4, 'asda', '2025-05-04 08:21:46', '2025-05-04 08:21:46'),
(14, 12, 4, 'bedsuibcu', '2025-05-04 08:21:48', '2025-05-04 08:21:48'),
(15, 15, 4, 'asdas', '2025-05-04 08:22:52', '2025-05-04 08:22:52'),
(16, 15, 4, 'asjdbajbdajbcjda', '2025-05-04 08:33:15', '2025-05-04 08:33:15'),
(19, 16, 7, 'jajnsaj', '2025-05-04 09:01:47', '2025-05-04 09:01:47'),
(20, 16, 7, 'apa deh ga tau', '2025-05-04 09:05:30', '2025-05-04 09:05:30'),
(21, 16, 7, 'asd', '2025-05-04 09:08:12', '2025-05-04 09:08:12'),
(22, 17, 7, 'sumpah udah muak', '2025-05-04 09:08:31', '2025-05-04 09:08:31'),
(23, 20, 7, 'apa tuh', '2025-05-04 09:21:24', '2025-05-04 09:21:24'),
(24, 22, 7, 'asdas', '2025-05-04 09:33:03', '2025-05-04 09:33:03'),
(25, 25, 7, 'halo', '2025-05-04 09:36:44', '2025-05-04 09:36:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `status` enum('sent','delivered','read') DEFAULT 'sent',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `image`, `created_at`, `updated_at`, `views`) VALUES
(1, 2, 'halo', 'test', NULL, '2025-04-23 16:48:37', '2025-05-04 04:17:00', 1),
(2, 2, 'apakah sudah bisa', 'halo', NULL, '2025-04-23 16:59:51', '2025-05-04 04:35:43', 3),
(3, 3, 'ini postingan user 2', 'apakah bisa melihat?', NULL, '2025-05-03 06:55:22', '2025-05-04 04:17:36', 3),
(4, 2, 'ini sudah di update', 'apakah bisa', NULL, '2025-05-04 03:27:29', '2025-05-04 03:27:29', 0),
(5, 2, 'test', 'close windows', NULL, '2025-05-04 03:28:39', '2025-05-04 03:28:39', 0),
(6, 2, 'asd', 'asd', NULL, '2025-05-04 03:30:31', '2025-05-04 03:30:31', 0),
(7, 2, 'asd', 'dffd', NULL, '2025-05-04 03:31:46', '2025-05-04 03:31:46', 0),
(8, 2, 'halo', 'ya', NULL, '2025-05-04 03:32:44', '2025-05-04 03:32:44', 0),
(9, 2, 'ghd', 'shrfhfgd', NULL, '2025-05-04 03:33:27', '2025-05-04 03:33:27', 0),
(10, 2, 'asd', 'asdads', NULL, '2025-05-04 03:35:02', '2025-05-04 03:35:02', 0),
(11, 2, 'ajak', 'ya', NULL, '2025-05-04 03:36:14', '2025-05-04 03:36:14', 0),
(12, 2, 'asda', 'asdadadsadasda', NULL, '2025-05-04 03:36:43', '2025-05-04 03:36:43', 0),
(13, 6, 'aaa', 'aaa', NULL, '2025-05-04 03:40:05', '2025-05-04 04:40:37', 3),
(14, 3, 'aku lelah', 'pol', NULL, '2025-05-04 03:48:04', '2025-05-04 04:52:35', 23),
(15, 4, 'asd', 'sadasfda', NULL, '2025-05-04 04:54:35', '2025-05-04 05:07:21', 3),
(16, 7, 'user berapa ini', 'n', NULL, '2025-05-04 08:54:48', '2025-05-04 08:54:48', 0),
(17, 7, 'auhdhsd', 'asnjnauausbduabibd', NULL, '2025-05-04 09:08:21', '2025-05-04 09:08:21', 0),
(18, 7, 'asdadasdad', 'asdads', NULL, '2025-05-04 09:09:00', '2025-05-04 09:09:00', 0),
(19, 7, 'test', 'apa ya', NULL, '2025-05-04 09:13:44', '2025-05-04 09:13:44', 0),
(20, 7, 'kenapa seseorang harus membuat seperti ini, apa gunanya?', 'mari kita bahas kegunaan dari hal seperti ini sdbafisfdassssssssssjjjjjjjjjjjjjjjjjjjjjjvvvvvvvvvvvvvvvvv', NULL, '2025-05-04 09:15:12', '2025-05-04 09:15:12', 0),
(21, 7, 'asdsd', 'kkkkkkkk', NULL, '2025-05-04 09:16:31', '2025-05-04 09:16:31', 0),
(22, 7, 'apa aja deh aku juga ga tau lagi, udah dari subuh ini sampe sore wkwk', 'lawak', NULL, '2025-05-04 09:21:17', '2025-05-04 09:21:17', 0),
(24, 7, 'apa aja deh aku juga ga tau lagi, udah dari subuh ini sampe sore wkwkwkwkwk', 'aaa', NULL, '2025-05-04 09:27:32', '2025-05-04 09:27:32', 0),
(25, 7, 'dsdsfsdfsdfsfdfd', 'sdfssdfsf', NULL, '2025-05-04 09:32:57', '2025-05-04 09:32:57', 0),
(26, 7, 'apa aja deh aku juga ga tau lagi, udah dari subuh ini sampe sore wkwk', 'halo', NULL, '2025-05-04 09:36:52', '2025-05-04 09:36:52', 0),
(27, 7, 'halo', 'halo1', NULL, '2025-05-04 09:37:16', '2025-05-04 09:37:16', 0),
(28, 7, 'halo11', '11', NULL, '2025-05-04 09:39:08', '2025-05-04 09:39:08', 0),
(29, 7, 'halo11', 'qq', NULL, '2025-05-04 09:41:02', '2025-05-04 09:41:02', 0),
(30, 7, 'halo11', 'jj', NULL, '2025-05-04 09:41:27', '2025-05-04 09:41:27', 0),
(31, 7, 'aa', 'aa', NULL, '2025-05-04 09:41:46', '2025-05-04 09:41:46', 0),
(32, 7, 'aa', 'aa', NULL, '2025-05-04 09:42:11', '2025-05-04 09:42:11', 0),
(33, 7, 'halo bro', 'apa', NULL, '2025-05-04 09:42:20', '2025-05-04 09:42:20', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indeks untuk tabel `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indeks untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT untuk tabel `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
