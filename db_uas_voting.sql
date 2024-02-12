-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.infinityfree.com
-- Waktu pembuatan: 11 Feb 2024 pada 21.05
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_35960711_db_uas_voting`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `position_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `candidates`
--

INSERT INTO `candidates` (`id`, `nama`, `image`, `visi`, `misi`, `position_id`) VALUES
(7, 'Anies - Muhaimin', 'tes-kandidat1.PNG', '<p><strong>Indonesia Adil Makmur untuk Semua</strong></p>', '<ol><li>Memastikan Ketersediaan kebutuhan pokok dan biaya hidup murah melalui kemandirian pangan, ketahanan energi, dan kedaulatan air.</li><li>Mewujudkan keadilan ekologis berkelanjutan untuk generasi mendatang.</li><li>Membangun kota dan desa berbasis kawasan yang manusiawi, berkeadilan, dan saling memajukan.</li></ol>', 3),
(8, 'Prabowo - Gibran', 'tes-kandidat2.PNG', '<p><strong>Bersama Indonesia Maju Menuju Indonesia Emas 2045</strong></p>', '<ol><li>Memperkokoh ideologi Pancasila, demokrasi, dan hak asasi manusia (HAM).</li><li>Melanjutkan hilirisasi dan mengembangkan industri berbasis sumber daya alam untuk meningkatkan nilai tambah di dalam negeri.</li><li>Membangun dari desa dan dari bawah untuk pertumbuhan ekonomi, pemerataan ekonomi, dan pemberantasan kemiskinan.</li></ol>', 3),
(9, 'Ganjar - Mahfud', 'tes-kandidat3.PNG', '<p><strong>Gerak Cepat Menuju Indonesia Unggul</strong></p>', '<ol><li>Menjadi indonesia yang sehat, terdidik, dan sejahtera.</li><li>Indonesia unggul dalam bidang inovasi dan teknologi.</li><li>Ekonomi yang tangguh dan berdikari.</li></ol>', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `positions`
--

INSERT INTO `positions` (`id`, `posisi`, `start_date`, `end_date`) VALUES
(3, 'Presiden & Wakil Presiden', '2024-02-10', '2024-02-14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `nama`, `password`, `is_admin`) VALUES
(4, 'admin@mail.com', 'Admin', '0192023a7bbd73250516f069df18b500', '1'),
(5, 'haris@mail.com', 'Haris', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(6, 'falih@mail.com', 'Falih', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(7, 'garda@mail.com', 'Garda', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(8, 'rizal@mail.com', 'Rizal', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(9, 'indri@mail.com', 'Indri', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(10, 'haifa@mail.com', 'Haifa', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(11, 'aurel@mail.com', 'Aurel', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(12, 'rachman@mail.com', 'Rachman', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(13, 'naila@mail.com', 'Naila', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(15, 'naufal@mail.com', 'Naufal', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(16, 'harisrachman@mail.com', 'Haris Rachman', 'e10adc3949ba59abbe56e057f20f883e', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `candidate_id` int(11) UNSIGNED NOT NULL,
  `voted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `candidate_id`, `voted_at`) VALUES
(4, 5, 8, '2024-02-10 10:07:16'),
(5, 12, 7, '2024-02-10 10:07:43'),
(6, 7, 9, '2024-02-10 10:13:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indeks untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
