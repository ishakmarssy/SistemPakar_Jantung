-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Bulan Mei 2025 pada 17.59
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_pakar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ads`
--

INSERT INTO `ads` (`id`, `position`, `code`) VALUES
(3, 'footer', '<script async src=\"https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4120382468404604\"\r\n     crossorigin=\"anonymous\"></script>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_diagnosa`
--

CREATE TABLE `detail_diagnosa` (
  `id` int(11) NOT NULL,
  `id_hasil` int(11) DEFAULT NULL,
  `id_gejala` varchar(5) DEFAULT NULL,
  `nilai_user` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_diagnosa`
--

INSERT INTO `detail_diagnosa` (`id`, `id_hasil`, `id_gejala`, `nilai_user`) VALUES
(1, 2, 'G01', 0.5),
(2, 2, 'G02', 0.5),
(3, 2, 'G03', 0.2),
(4, 2, 'G04', 0.5),
(5, 2, 'G05', 0.8),
(6, 2, 'G06', 0.5),
(7, 2, 'G07', 0.8),
(8, 2, 'G08', 0.2),
(9, 3, 'G01', 0.2),
(10, 4, 'G05', 0.2),
(11, 5, 'G01', 0.2),
(12, 6, 'G08', 0.8),
(13, 7, 'G08', 0.5),
(14, 8, 'G08', 0.8),
(15, 9, 'G06', 0.8),
(16, 9, 'G08', 0.8),
(17, 10, 'G02', 0.8),
(18, 10, 'G03', 0.5),
(19, 11, 'G08', 0.8),
(20, 12, 'G08', 0.8),
(21, 13, 'G01', 0.2),
(22, 13, 'G02', 0.2),
(23, 13, 'G03', 0.5),
(24, 16, 'G07', 0.2),
(25, 17, 'G07', 0.2),
(26, 19, 'G08', 0.8),
(27, 20, 'G01', 0.2),
(28, 20, 'G02', 0.5),
(29, 20, 'G03', 0.5),
(30, 21, 'G05', 0.5),
(31, 22, 'G08', 0.8),
(32, 23, 'G01', 0.2),
(33, 23, 'G02', 0.5),
(34, 23, 'G03', 0.8),
(35, 24, 'G01', 0.8),
(36, 24, 'G02', 0.8),
(37, 24, 'G03', 0.8),
(38, 24, 'G04', 0.2),
(39, 24, 'G05', 0.5),
(40, 24, 'G06', 0.5),
(41, 24, 'G07', 0.8),
(42, 24, 'G08', 0.5),
(43, 25, 'G06', 0.2),
(44, 25, 'G08', 0.8),
(45, 26, 'G05', 0.5),
(46, 27, 'G01', 0.8),
(47, 27, 'G02', 0.8),
(48, 27, 'G03', 0.8),
(49, 27, 'G04', 0.5),
(50, 27, 'G05', 0.5),
(51, 27, 'G06', 0.2),
(52, 27, 'G07', 0.2),
(53, 27, 'G08', 0.2),
(54, 28, 'G01', 0.8),
(55, 29, 'G01', 0.2),
(56, 29, 'G02', 0.5),
(57, 29, 'G03', 0.8),
(58, 30, 'G06', 0.8),
(59, 30, 'G07', 0.5),
(60, 30, 'G08', 0.2),
(61, 31, 'G04', 0.2),
(62, 31, 'G05', 0.5),
(63, 31, 'G06', 0.8),
(64, 32, 'G02', 0.5),
(65, 32, 'G03', 0.5),
(66, 32, 'G04', 0.5),
(67, 32, 'G07', 0.2),
(68, 33, 'G01', 0.5),
(69, 34, 'G01', 0.5),
(70, 35, 'G01', 0.5),
(71, 36, 'G01', 0.2),
(72, 36, 'G02', 0.5),
(73, 36, 'G03', 0.8),
(74, 37, 'G01', 0.2),
(75, 37, 'G02', 0.5),
(76, 37, 'G03', 0.8),
(77, 38, 'G01', 0.2),
(78, 38, 'G02', 0.5),
(79, 38, 'G03', 0.8),
(80, 39, 'G01', 0.2),
(81, 39, 'G02', 0.5),
(82, 39, 'G03', 0.8),
(83, 40, 'G01', 0.2),
(84, 40, 'G02', 0.5),
(85, 40, 'G03', 0.8),
(86, 41, 'G01', 0.2),
(87, 41, 'G02', 0.5),
(88, 41, 'G03', 0.8),
(89, 42, 'G01', 0.2),
(90, 42, 'G02', 0.5),
(91, 42, 'G03', 0.8),
(92, 43, 'G01', 0.2),
(93, 43, 'G02', 0.5),
(94, 43, 'G03', 0.8),
(95, 44, 'G01', 0.2),
(96, 44, 'G02', 0.5),
(97, 44, 'G03', 0.8),
(98, 45, 'G01', 0.2),
(99, 45, 'G02', 0.5),
(100, 45, 'G03', 0.8),
(101, 46, 'G01', 0.2),
(102, 46, 'G02', 0.5),
(103, 46, 'G03', 0.8),
(104, 47, 'G01', 0.2),
(105, 47, 'G02', 0.5),
(106, 47, 'G03', 0.8),
(107, 48, 'G01', 0.2),
(108, 48, 'G02', 0.5),
(109, 48, 'G03', 0.8),
(110, 49, 'G01', 0.2),
(111, 49, 'G02', 0.5),
(112, 49, 'G03', 0.8),
(113, 50, 'G01', 0.2),
(114, 50, 'G02', 0.5),
(115, 50, 'G03', 0.8),
(116, 51, 'G01', 0.2),
(117, 51, 'G02', 0.5),
(118, 51, 'G03', 0.8),
(119, 52, 'G01', 0.2),
(120, 52, 'G02', 0.5),
(121, 52, 'G03', 0.8),
(122, 53, 'G01', 0.2),
(123, 53, 'G02', 0.5),
(124, 53, 'G03', 0.8),
(125, 54, 'G01', 0.2),
(126, 54, 'G02', 0.5),
(127, 54, 'G03', 0.8),
(128, 55, 'G02', 0.5),
(129, 56, 'G02', 0.5),
(130, 57, 'G01', 0.5),
(131, 58, 'G01', 0.2),
(132, 59, 'G01', 0.2),
(133, 60, 'G01', 0.2),
(134, 61, 'G01', 0.2),
(135, 62, 'G01', 0.2),
(136, 63, 'G01', 0.2),
(137, 64, 'G01', 0.2),
(138, 65, 'G01', 0.2),
(139, 66, 'G01', 0.2),
(140, 67, 'G01', 0.8),
(141, 68, 'G01', 0.8),
(142, 69, 'G01', 0.8),
(143, 70, 'G01', 0.8),
(144, 71, 'G02', 0.5),
(145, 71, 'G07', 0.5),
(146, 71, 'G08', 0.5),
(147, 72, 'G02', 0.5),
(148, 72, 'G07', 0.5),
(149, 72, 'G08', 0.5),
(150, 73, 'G04', 0.8),
(151, 73, 'G05', 0.8),
(152, 73, 'G06', 0.8),
(153, 73, 'G07', 0.8),
(154, 73, 'G08', 0.8),
(155, 74, 'G04', 0.8),
(156, 74, 'G05', 0.8),
(157, 74, 'G06', 0.8),
(158, 74, 'G07', 0.8),
(159, 74, 'G08', 0.8),
(160, 75, 'G01', 0.8),
(161, 75, 'G02', 0.8),
(162, 75, 'G03', 0.5),
(163, 76, 'G01', 0.5),
(164, 76, 'G02', 0.8),
(165, 77, 'G04', 0.5),
(166, 78, 'G05', 0.5),
(167, 79, 'G05', 0.5),
(168, 80, 'G04', 0.5),
(169, 81, 'G04', 0.5),
(170, 82, 'G01', 0.5),
(171, 83, 'G04', 0.5),
(172, 84, 'G05', 0.8),
(173, 85, 'G05', 0.8),
(174, 86, 'G01', 0.5),
(175, 87, 'G02', 0.5),
(176, 88, 'G03', 0.5),
(177, 89, 'G01', 0.5),
(178, 90, 'G04', 0.5),
(179, 91, 'G04', 0.5),
(180, 92, 'G02', 0.5),
(181, 93, 'G01', 0.5),
(182, 94, 'G02', 0.5),
(183, 95, 'G02', 0.5),
(184, 96, 'G04', 0.5),
(185, 97, 'G04', 0.5),
(186, 98, 'G02', 0.5),
(187, 98, 'G03', 0.5),
(188, 99, 'G01', 0.2),
(189, 99, 'G02', 0.5),
(190, 99, 'G03', 0.8),
(191, 99, 'G05', 0.8),
(192, 100, 'G04', 0.5),
(193, 101, 'G06', 0.5),
(194, 102, 'G02', 0.5),
(195, 103, 'G03', 0.5),
(196, 104, 'G02', 0.8),
(197, 1, 'G02', 0.8),
(198, 2, 'G01', 0.5),
(199, 3, 'G01', 0.5),
(200, 1, 'G01', 0.5),
(201, 2, 'G08', 0.5),
(202, 3, 'G01', 0.2),
(203, 3, 'G02', 0.5),
(204, 3, 'G03', 0.8),
(205, 4, 'G05', 0.8),
(206, 4, 'G08', 0.8),
(207, 5, 'G01', 0.8),
(208, 5, 'G02', 0.8),
(209, 5, 'G03', 0.8),
(210, 6, 'G01', 0.2),
(211, 7, 'G05', 0.2),
(212, 7, 'G06', 0.8),
(213, 7, 'G07', 0.5),
(214, 8, 'G01', 0.2),
(215, 8, 'G02', 0.8),
(216, 8, 'G03', 0.8),
(217, 9, 'G01', 0.2),
(218, 9, 'G02', 0.5),
(219, 9, 'G03', 0.2),
(220, 10, 'G08', 0.8),
(221, 11, 'G01', 0.8),
(222, 11, 'G02', 0.8),
(223, 11, 'G03', 0.8),
(224, 12, 'G01', 0.2),
(225, 12, 'G02', 0.8),
(226, 12, 'G03', 0.5),
(227, 13, 'G01', 0.8),
(228, 13, 'G02', 0.8),
(229, 14, 'G01', 0.2),
(230, 14, 'G02', 0.5),
(231, 14, 'G03', 0.8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` varchar(5) NOT NULL,
  `nama_gejala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `nama_gejala`) VALUES
('G01', 'Nyeri dada'),
('G02', 'Sesak napas'),
('G03', 'Keringat berlebih'),
('G04', 'Detak jantung tidak teratur'),
('G05', 'Kelelahan ekstrem'),
('G06', 'Pembengkakan pada kaki atau pergelangan'),
('G07', 'Pusing atau pingsan'),
('G08', 'Mual atau gangguan pencernaan'),
('G09', 'a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_diagnosa`
--

CREATE TABLE `hasil_diagnosa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nama_pasien` varchar(100) DEFAULT NULL,
  `hasil` text DEFAULT NULL,
  `cf_total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil_diagnosa`
--

INSERT INTO `hasil_diagnosa` (`id`, `user_id`, `tanggal`, `nama_pasien`, `hasil`, `cf_total`) VALUES
(1, 3, '2025-04-30 09:22:49', 'Reza Arap', 'Serangan Jantung', 0.4),
(2, 2, '2025-04-30 09:24:35', 'Caken', 'Serangan Jantung', 0.25),
(3, 2, '2025-04-30 12:38:11', 'Caken', 'Serangan Jantung', 0.71608),
(4, 2, '2025-04-30 13:03:55', 'Caken', 'Gagal Jantung', 0.56),
(5, 2, '2025-04-30 13:07:08', 'Caken', 'Serangan Jantung', 0.917632),
(6, 2, '2025-04-30 13:07:45', 'Caken', 'Serangan Jantung', 0.16),
(7, 2, '2025-04-30 13:09:27', 'Caken', 'Gagal Jantung', 0.6646),
(8, 2, '2025-04-30 13:15:35', 'Caken', 'Serangan Jantung', 0.807808),
(9, 3, '2025-04-30 13:31:58', 'Feri Nirwana Irwansyah', 'Serangan Jantung', 0.51952),
(10, 3, '2025-04-30 13:33:28', 'Feri Nirwana Irwansyah', 'Serangan Jantung', 0.4),
(11, 2, '2025-04-30 14:07:08', 'Caken', 'Serangan Jantung', 0.917632),
(12, 2, '2025-04-30 14:33:49', 'Caken', 'Serangan Jantung', 0.74128),
(13, 2, '2025-04-30 14:51:53', 'Caken', 'Serangan Jantung', 0.8416),
(14, 3, '2025-05-01 13:55:00', 'Feri Nirwana Irwansyah', 'Serangan Jantung', 0.71608);

-- --------------------------------------------------------

--
-- Struktur dari tabel `map`
--

CREATE TABLE `map` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `embed_src` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `map`
--

INSERT INTO `map` (`id`, `lokasi`, `embed_src`) VALUES
(1, 'RSUD Masohi', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.181951770028!2d128.9547441107556!3d-3.305114696655842!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d6b98374d1c2111%3A0xa1cfa771502cbf20!2sRSUD%20Masohi!5e0!3m2!1sid!2sid!4v1746177712491!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` varchar(5) NOT NULL,
  `nama_penyakit` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `saran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `nama_penyakit`, `deskripsi`, `saran`) VALUES
('P01', 'Serangan Jantung', 'Serangan jantung terjadi ketika aliran darah ke otot jantung terhambat, biasanya oleh pembekuan darah.', 'Segera cari bantuan medis darurat, hindari aktivitas berat, dan ikuti pengobatan yang direkomendasikan dokter.'),
('P02', 'Gagal Jantung', 'Gagal jantung adalah kondisi saat jantung tidak mampu memompa darah secara efektif ke seluruh tubuh.', 'Lakukan kontrol tekanan darah, konsumsi obat secara teratur, hindari garam berlebihan, dan rutin cek ke dokter.'),
('P03', 'Angina Stabil', 'Angina stabil adalah nyeri dada yang terjadi ketika jantung tidak mendapatkan cukup oksigen saat aktivitas fisik.', 'Istirahat yang cukup, konsumsi obat nitrogliserin jika perlu, dan ubah gaya hidup menjadi lebih sehat.'),
('P04', 'Aritmia', '- a', '- b');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `id_penyakit` varchar(5) DEFAULT NULL,
  `id_gejala` varchar(5) DEFAULT NULL,
  `cf_pakar` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `id_penyakit`, `id_gejala`, `cf_pakar`) VALUES
(1, 'P01', 'G01', 0.6),
(2, 'P01', 'G02', 0.5),
(3, 'P01', 'G04', 0.4),
(4, 'P02', 'G01', 0.8),
(5, 'P02', 'G02', 0.7),
(6, 'P02', 'G03', 0.6),
(7, 'P02', 'G08', 0.5),
(8, 'P03', 'G02', 0.6),
(9, 'P03', 'G05', 0.7),
(10, 'P03', 'G06', 0.6),
(11, 'P03', 'G07', 0.5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_photo` longblob NOT NULL,
  `cover_photo` longblob NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`, `email`, `profile_photo`, `cover_photo`, `role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Ishak Marasabessy', '', 0x75706c6f6164732f33366566343165332d636636342d346139322d386261652d6133396132376534636535322e6a7067, 0x75706c6f6164732f65353065366439312d303534632d343632302d613232652d3831653339303061636161352e6a7067, 'admin'),
(2, 'user123', '6ad14ba9986e3615423dfca256d04e3f', 'Ishak Marasabessy', '', 0x75706c6f6164732f33366566343165332d636636342d346139322d386261652d6133396132376534636535322e6a7067, 0x75706c6f6164732f65353065366439312d303534632d343632302d613232652d3831653339303061636161352e6a7067, 'user'),
(3, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'Feri Nirwana Irwansyah', 'isahkmarssy@gmail.com', 0x75706c6f6164732f6e65776269652e706e67, 0x75706c6f6164732f436173686261636b2d31352d726962752d706173616e672d7370616e64756b2d64692d546f6b6f2d50726f6d6f73692d4f74746f5061792e6a706567, 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_diagnosa`
--
ALTER TABLE `detail_diagnosa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_hasil` (`id_hasil`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indeks untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `id_penyakit` (`id_penyakit`),
  ADD KEY `id_gejala` (`id_gejala`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_diagnosa`
--
ALTER TABLE `detail_diagnosa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `map`
--
ALTER TABLE `map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_diagnosa`
--
ALTER TABLE `detail_diagnosa`
  ADD CONSTRAINT `detail_diagnosa_ibfk_1` FOREIGN KEY (`id_hasil`) REFERENCES `hasil_diagnosa` (`id`);

--
-- Ketidakleluasaan untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `rule_ibfk_1` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`),
  ADD CONSTRAINT `rule_ibfk_2` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
