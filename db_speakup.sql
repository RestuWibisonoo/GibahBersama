-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jun 2025 pada 09.22
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
(30, 37, 9, 'halo bro', '2025-05-28 06:00:31', '2025-05-28 06:00:31'),
(31, 37, 9, 'halo', '2025-05-28 06:24:02', '2025-05-28 06:24:02'),
(32, 37, 9, 'halo', '2025-05-28 06:24:43', '2025-05-28 06:24:43'),
(33, 37, 9, 'test', '2025-05-28 06:30:40', '2025-05-28 06:30:40'),
(34, 37, 10, 'tyugweugsfadhbfdsagsfdaguiyhbsdf', '2025-05-28 06:58:42', '2025-05-28 06:58:42'),
(35, 37, 10, 'tyugweugsfadhbfdsagsfdaguiyhbsdf', '2025-05-28 06:58:45', '2025-05-28 06:58:45'),
(36, 38, 10, 'asdsda', '2025-05-28 06:59:09', '2025-05-28 06:59:09'),
(37, 40, 11, 'enggak', '2025-05-28 08:45:25', '2025-05-28 08:45:25'),
(38, 40, 9, 'iya asik', '2025-05-28 08:46:04', '2025-05-28 08:46:04'),
(39, 44, 10, 'asdsadasd', '2025-06-04 16:51:58', '2025-06-04 16:51:58'),
(40, 44, 10, 'awokawokawokawokawokawkoawkoawok', '2025-06-04 17:45:42', '2025-06-04 17:45:42'),
(41, 49, 10, 'sgdfsdgsfd', '2025-06-04 19:34:32', '2025-06-04 19:34:32'),
(42, 49, 10, 'jaloasdsad', '2025-06-04 19:34:41', '2025-06-04 19:34:41'),
(43, 49, 10, 'dsfadsfdfadfsadfdfas', '2025-06-04 19:45:57', '2025-06-04 19:45:57'),
(44, 49, 10, 'halooo', '2025-06-04 19:46:01', '2025-06-04 19:46:01'),
(45, 50, 10, 'afds', '2025-06-04 19:46:28', '2025-06-04 19:46:28'),
(46, 50, 10, 'dsafadfs', '2025-06-04 19:48:06', '2025-06-04 19:48:06'),
(47, 50, 10, 'asdfaf', '2025-06-04 19:55:55', '2025-06-04 19:55:55'),
(48, 50, 10, 'sdafafs', '2025-06-04 19:56:03', '2025-06-04 19:56:03'),
(49, 52, 10, 'asdasd', '2025-06-04 19:58:24', '2025-06-04 19:58:24'),
(50, 52, 10, 'asfd', '2025-06-04 19:58:49', '2025-06-04 19:58:49'),
(51, 52, 10, 'asd', '2025-06-04 19:58:57', '2025-06-04 19:58:57'),
(52, 50, 10, 'asdffasd', '2025-06-04 19:59:13', '2025-06-04 19:59:13'),
(56, 52, 10, 'asddas', '2025-06-04 20:02:52', '2025-06-04 20:02:52'),
(57, 52, 10, '123', '2025-06-04 20:11:09', '2025-06-04 20:11:09'),
(58, 52, 10, 'asdf', '2025-06-04 20:20:32', '2025-06-04 20:20:32'),
(59, 52, 10, '123', '2025-06-04 20:20:40', '2025-06-04 20:20:40'),
(60, 52, 10, 'asdadssa', '2025-06-04 20:24:45', '2025-06-04 20:24:45'),
(61, 52, 10, 'asdffsda', '2025-06-04 20:25:41', '2025-06-04 20:25:41'),
(62, 52, 10, 'asd', '2025-06-04 20:36:50', '2025-06-04 20:36:50'),
(63, 53, 10, '123', '2025-06-04 20:48:43', '2025-06-04 20:48:43'),
(64, 53, 10, 'afsd', '2025-06-04 20:51:56', '2025-06-04 20:51:56'),
(65, 53, 10, 'asdsad', '2025-06-04 20:53:06', '2025-06-04 20:53:06'),
(66, 53, 10, 'asdfsdaf', '2025-06-04 20:59:21', '2025-06-04 20:59:21'),
(67, 53, 10, '123', '2025-06-04 20:59:27', '2025-06-04 20:59:27'),
(68, 53, 10, '123', '2025-06-04 20:59:35', '2025-06-04 20:59:35'),
(69, 53, 10, '123333', '2025-06-04 21:00:20', '2025-06-04 21:00:20'),
(70, 53, 10, 'asdads', '2025-06-04 21:02:24', '2025-06-04 21:02:24'),
(71, 53, 10, 'asdasdasdassaads1231321123123123', '2025-06-04 21:02:39', '2025-06-04 21:02:39'),
(72, 53, 10, 'adsasdads', '2025-06-04 21:02:48', '2025-06-04 21:02:48'),
(73, 53, 10, 'asdads', '2025-06-04 21:03:01', '2025-06-04 21:03:01'),
(74, 53, 10, 'asdasd', '2025-06-04 21:03:06', '2025-06-04 21:03:06'),
(75, 53, 10, 'asd', '2025-06-04 21:18:08', '2025-06-04 21:18:08'),
(76, 53, 10, 'asfd', '2025-06-04 21:23:19', '2025-06-04 21:23:19'),
(77, 53, 10, 'halo', '2025-06-04 21:30:42', '2025-06-04 21:30:42'),
(78, 55, 10, 'hah', '2025-06-05 06:45:02', '2025-06-05 06:45:02'),
(79, 56, 13, 'halo', '2025-06-05 06:53:35', '2025-06-05 06:53:35'),
(80, 56, 13, 'p', '2025-06-05 06:55:10', '2025-06-05 06:55:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(5, 10, 44, '2025-06-04 18:15:46'),
(6, 10, 46, '2025-06-04 19:14:01'),
(7, 10, 53, '2025-06-04 21:16:11'),
(11, 13, 55, '2025-06-05 06:52:14'),
(12, 13, 56, '2025-06-05 06:53:41');

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
(37, 9, 'ini adalah testing pertama', 'test123', NULL, '2025-05-22 07:31:05', '2025-06-04 17:46:02', 13),
(38, 10, 'ini user 2', 'aaa', NULL, '2025-05-28 06:58:33', '2025-06-05 06:55:46', 30),
(39, 9, 'asdf', 'sdaf', NULL, '2025-05-28 07:01:23', '2025-06-04 21:23:07', 18),
(40, 11, 'Ayo kita mencari tahu matematika', 'matematika asik', NULL, '2025-05-28 08:45:08', '2025-05-28 08:45:08', 0),
(41, 10, 'halo', 'halo', NULL, '2025-06-03 09:24:18', '2025-06-04 21:23:06', 16),
(42, 10, 'test', 'test', NULL, '2025-06-03 09:25:38', '2025-06-03 09:25:38', 0),
(43, 10, 'asddas', 'asddasdas', NULL, '2025-06-04 16:51:05', '2025-06-04 16:51:05', 0),
(44, 10, 'dassda', 'sdadsads', NULL, '2025-06-04 16:51:08', '2025-06-04 21:23:07', 26),
(45, 10, 'asdsdfasfads', 'asdfffsdaasd', NULL, '2025-06-04 18:29:29', '2025-06-04 18:29:29', 0),
(46, 10, 'sdfafdg', 'sdfadsfsdfafsdfdsfsdasdafdsfsdfsdfds', NULL, '2025-06-04 19:13:58', '2025-06-04 19:13:58', 0),
(47, 10, 'asdffdsfsda', 'sasdfadsfafdsdfasdsaffdasdfsdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdfdf', NULL, '2025-06-04 19:22:11', '2025-06-04 19:22:11', 0),
(48, 10, 'asd', 'asddasdasdasdsaasdasdasaaaaaaaaaaaaaaaa', NULL, '2025-06-04 19:22:38', '2025-06-04 19:22:38', 0),
(49, 10, 'dfssdfasfdfas', 'fdsafsddfasfdsafdfdfdsdfasasdfadffsasfadfdsasdfasfaddfsdaasdffsdafdsafsdadasfasd', NULL, '2025-06-04 19:33:43', '2025-06-04 19:46:01', 5),
(50, 10, 'asdasdfasff', 'sdfafadsfsadfsdasdfasadffdsadsfdasfasafsd', NULL, '2025-06-04 19:46:08', '2025-06-04 19:59:13', 8),
(52, 10, 'test 123', 'iya halo', NULL, '2025-06-04 19:56:24', '2025-06-04 21:23:07', 24),
(53, 10, 'asdf', '123', NULL, '2025-06-04 20:48:41', '2025-06-05 02:22:58', 21),
(54, 13, 'temennya wowo ga ada yg bener', 'awokawokawok', NULL, '2025-06-05 02:24:11', '2025-06-05 02:24:11', 0),
(55, 13, 'WOWO tektok', '\"Saya lagi membayangkan Prabowo mendaki Semeru. Terus pas nyampe di puncak dia mengibarkan bendera merah putih lalu dia berteriak, \"Titiek kembalilah ke pelukanku\". \r\n\r\nTerus habis itu dia menggelinding ke bawah seperti seekor landak. Pas nyampe di bawah dia langsung membeli jagung bakar.\"', NULL, '2025-06-05 02:27:17', '2025-06-05 02:27:17', 0),
(56, 10, 'halo', 'oi', NULL, '2025-06-05 06:44:53', '2025-06-05 06:54:33', 3),
(57, 13, 'a', 'a', NULL, '2025-06-05 06:55:18', '2025-06-05 06:55:18', 0);

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
(9, 'user1', 'user1', 'user1@gmail.com', 'aaa', 'profile_682ed29fe8738.jpg', NULL, 'user', 'active', '2025-05-22 02:30:39', '2025-05-22 02:30:39'),
(10, 'user2', 'user2', 'user2@gmail.com', 'aaa', 'profile_684081c73a785.png', 'hello', 'user', 'active', '2025-05-28 01:58:12', '2025-06-04 17:26:31'),
(11, 'ridwan', 'iwan', 'ridwan@gmail.com', 'aaa', 'profile_6836cce373dc9.jpg', NULL, 'user', 'active', '2025-05-28 03:44:19', '2025-05-28 03:44:19'),
(12, 'user3', 'user3', 'user3@gmail.com', 'aaa', 'profile_683f41e5211e7.jpg', NULL, 'user', 'active', '2025-06-03 13:41:41', '2025-06-03 13:41:41'),
(13, 'fufufafa', 'fufufafa', 'gibran@gmail.com', 'fufufafa', 'profile_684140238b293.jpg', 'halo', 'user', 'active', '2025-06-04 21:23:40', '2025-06-05 06:58:43');

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
-- Indeks untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_bookmark` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- Ketidakleluasaan untuk tabel `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
