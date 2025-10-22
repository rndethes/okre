-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2022 pada 11.50
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ethestech_okr`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `access_team`
--

CREATE TABLE `access_team` (
  `id_access_team` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `access_team`
--

INSERT INTO `access_team` (`id_access_team`, `id_team`, `id_user`) VALUES
(12, 2, 920192),
(13, 1, 310312),
(14, 1, 18129128),
(15, 2, 120),
(16, 4, 920192),
(17, 4, 310312),
(18, 4, 120);

-- --------------------------------------------------------

--
-- Struktur dari tabel `departement`
--

CREATE TABLE `departement` (
  `id_departement` int(11) NOT NULL,
  `no_departement` varchar(100) NOT NULL,
  `nama_departement` varchar(100) NOT NULL,
  `alamat_departement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `departement`
--

INSERT INTO `departement` (`id_departement`, `no_departement`, `nama_departement`, `alamat_departement`) VALUES
(1, 'ET19028', 'Ethes Tech', 'Kandangan, Temanggung'),
(3, 'LD1292', 'Lido', 'Kandangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `key_result`
--

CREATE TABLE `key_result` (
  `id_kr` int(11) NOT NULL,
  `id_okr` int(11) NOT NULL,
  `nama_kr` text NOT NULL,
  `description_kr` text NOT NULL,
  `value_kr` varchar(20) NOT NULL,
  `value_achievment` varchar(20) NOT NULL,
  `precentage` varchar(20) NOT NULL,
  `due_datekey` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `key_result`
--

INSERT INTO `key_result` (`id_kr`, `id_okr`, `nama_kr`, `description_kr`, `value_kr`, `value_achievment`, `precentage`, `due_datekey`) VALUES
(19, 1, 'Nama Produk Selesai 1 Hari', '', '1', '1', '100', '2022-04-29 23:55:00'),
(20, 1, 'Desain dan foto produk lengkap /2 hari', '', '2', '1', '50', '2022-04-30 14:08:00'),
(21, 1, 'Sample produk 50 botol /5 hari', '', '50', '40', '80', '2022-05-03 13:15:00'),
(22, 1, 'Menentukan harga jual /1 hari', '', '1', '1', '100', '2022-04-29 14:15:00'),
(42, 11, 'Memperkenalkan kepada 100 orang langsung /6 hari', 'sudah selesai semua', '100', '100', '100', '2022-05-11 23:59:00'),
(43, 11, 'Menbuat promosi lewat FB dan WA ke grup /6 hari', 'baru lewat WA', '2', '1', '50', '2022-05-11 14:13:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `okr`
--

CREATE TABLE `okr` (
  `id_okr` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `description_okr` text NOT NULL,
  `value_okr` varchar(20) NOT NULL,
  `total_kr` varchar(20) NOT NULL,
  `due_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `okr`
--

INSERT INTO `okr` (`id_okr`, `id_project`, `id_team`, `description_okr`, `value_okr`, `total_kr`, `due_date`) VALUES
(1, 93129313, 1, 'Mencari Produk Pesaing Madu di Pasaran 1/2', '82.5', '4', '2022-04-30 00:00:00'),
(10, 93129313, 1, 'Mempromosikan Madu Kesehatan masyarakat Tmg dll ', '0', '0', '2022-05-30 00:00:00'),
(11, 93129313, 1, 'Mempromosikan Madu Kesehatan untuk internal lido', '75', '2', '2022-05-28 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `id_project` int(11) NOT NULL,
  `nama_project` varchar(100) NOT NULL,
  `id_departement` int(11) NOT NULL,
  `priority_project` varchar(45) NOT NULL,
  `id_team` int(11) NOT NULL,
  `tanggal_awal_project` datetime NOT NULL,
  `tanggal_akhir_project` datetime NOT NULL,
  `description_project` text NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `work_status` varchar(45) NOT NULL,
  `value_project` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`id_project`, `nama_project`, `id_departement`, `priority_project`, `id_team`, `tanggal_awal_project`, `tanggal_akhir_project`, `description_project`, `file`, `work_status`, `value_project`) VALUES
(14311, 'OKR Develpment Softwere', 1, '2', 1, '2022-04-28 00:00:00', '2022-05-31 00:00:00', 'cek', NULL, '3', '0'),
(313123, 'Develpoment OKR', 1, '2', 1, '2022-04-26 00:00:00', '2022-04-30 00:00:00', 'asdasd', NULL, '2', '0'),
(93129313, 'OKR Madu Lido', 1, '2', 1, '2022-04-26 00:00:00', '2022-04-30 00:00:00', ' Maks 5 objective dengan 3 KR untuk OKR Group Madu\r\n• Anggota tim membuat OKR individu dan di beritahukan kepada teman serta diketahui ketua tim (tujuannya agar bisa saling bantu apabila ada kendala)\r\n• Setiap 3 hari akan ada meeting cepat untuk monitor kemajuan\r\n• Score diharapkan mencapai 70 sd 80 % target waktu 3 minggu \r\n• Cara sukses OKR adalah langsung kerja dan tidak ada benar atau salah', 'LIDO_OKR_MADU_.pdf', '2', '52.5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `team`
--

CREATE TABLE `team` (
  `id_team` int(11) NOT NULL,
  `nama_team` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `team`
--

INSERT INTO `team` (`id_team`, `nama_team`, `keterangan`, `created_at`) VALUES
(1, 'Team A', 'Team A adalah Team ...', '2022-04-25 03:58:40'),
(2, 'Team B', 'Team B Lido', '2022-04-26 03:47:57'),
(4, 'Team C', 'Team C', '2022-05-05 09:17:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(45) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_departement` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `tanggal_kontrak` datetime NOT NULL,
  `role_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_user`, `username`, `password`, `nama`, `email`, `no_hp`, `jabatan`, `alamat`, `id_departement`, `foto`, `tanggal_kontrak`, `role_id`) VALUES
(7, '18129128', 'user01', 'user01', 'User P', 'user@gmail', '213123', 'staff', 'Temanggung Jawa Tengah', 1, '1601112310479.jpg', '2022-04-25 00:00:00', '1'),
(8, '920192', 'user02', 'user02', 'user02', 'user@user.com', '0291021', 'staff', 'Temanggung Jawa Tengah', 1, 'ourwork.jpg', '2022-04-26 00:00:00', '2'),
(9, '310312', 'user03', 'user03', 'user03', 'user@user.com', '231', 'staff', 'teamnggung', 1, 'profil1.jpg', '2022-04-26 00:00:00', '3'),
(10, '120', 'user04', 'user04', 'User 04', 'user@user.com', '1231', 'staff', 'sads', 1, 'bg-2.jpg', '2022-04-26 00:00:00', '3');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `access_team`
--
ALTER TABLE `access_team`
  ADD PRIMARY KEY (`id_access_team`);

--
-- Indeks untuk tabel `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_departement`);

--
-- Indeks untuk tabel `key_result`
--
ALTER TABLE `key_result`
  ADD PRIMARY KEY (`id_kr`);

--
-- Indeks untuk tabel `okr`
--
ALTER TABLE `okr`
  ADD PRIMARY KEY (`id_okr`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`);

--
-- Indeks untuk tabel `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id_team`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `access_team`
--
ALTER TABLE `access_team`
  MODIFY `id_access_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `departement`
--
ALTER TABLE `departement`
  MODIFY `id_departement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `key_result`
--
ALTER TABLE `key_result`
  MODIFY `id_kr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `okr`
--
ALTER TABLE `okr`
  MODIFY `id_okr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93129314;

--
-- AUTO_INCREMENT untuk tabel `team`
--
ALTER TABLE `team`
  MODIFY `id_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
