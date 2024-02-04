-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jan 2024 pada 06.07
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_authentication`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kesehatan`
--

CREATE TABLE `kesehatan` (
  `id` int(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `nomor_kamar` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kesehatan`
--

INSERT INTO `kesehatan` (`id`, `nama`, `tingkat`, `nomor_kamar`, `keterangan`) VALUES
(10, 'YOotVl7xm+6pYmjMy89uUHpwZUdxKzAwUEJXU0hRN0s3YzRhblE9PQ==', 'YeI6i0wRMjg5vBOC9uIVOmZSZVhuVjhJUFhHRXRzUnUvNklGZHc9PQ==', 'flJUf5Yq7rgPuX0Nv6V+uTlmemFDNGNwQzdRbmxDSWRZcHJuRXc9PQ==', 'SSzOgWlhzusoRP1KMh8ONDd4NFVzc2dRdytBTURTRXMzdFRsSStFaThSMXRMWmgrMkR0R1FIRHpqU289');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_kamar` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `nomor_kamar`, `keterangan`, `foto`) VALUES
(38, 'hjOQQ1qIU+n4B7EoEMh3Y2lxb2NFcGo3eDZwY0syZTBEd0FqeFE9PQ==', 'jqOPZzKD8uODCQlfthkFIlNvb2htR1ArRmUydXpBSVc3RlAwSlE9PQ==', 'BtFw6xKj28Ldib4UVoDmxlAwSkVYMUZ4L1k4QTJXcGdLT0hOV0E9PQ==', 'uploads/asrama/ec16b047775b859d566bcb60c5ccad5f9eccbf1b311c45f15de235d57253f3d3'),
(39, 'GRLQ9Xriye8a2OU/wEb+R2liZHQ2TlVNajY5MEVpM0lqZ2MvOFE9PQ==', 'gVXxLv/aHYWCZmSx4epZLnZZdzZKMFpyN2pjdGRvMUI3RHUycFE9PQ==', '6pb2RVUnJ0VuIuX7nkMCEkhtZUoydXR0dG9PL0ZkQmJQVEdlQUE9PQ==', 'uploads/asrama/a533d53f333bb69d413e2756b68f0b31c5b4f7b6ed279fbede590f4fe8e459f7');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password_hash`) VALUES
(9, 'vergie', '$2y$10$7dE.81KQJsJ/vkAIJk3V.uRiJMR3LLaihPkzhXscALwNi5vanQ83S'),
(12, 'M45t3r', '$2y$10$zIT/XPd0rKlkZFY9EnPWhO.ClgucKk1nbtopBkabF.1WaLgWfTpb6'),
(13, 'admin', '$2y$10$hc0rhvHT32y3RwZW.gdSvupqr28r9NV9bmIbdIo/3UPWcf6kSQC8m'),
(14, 'anang', '$2y$10$Jev1AtXpZWzuyaDY8ZTNSObHfWpX4hNjcNpLI.WHxBaYLsFidB/vK');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kesehatan`
--
ALTER TABLE `kesehatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kesehatan`
--
ALTER TABLE `kesehatan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
