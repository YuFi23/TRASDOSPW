-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Des 2024 pada 16.46
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbtiket`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','manager') NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id`, `username`, `email`, `password`, `role`, `avatar`, `created_at`) VALUES
(1, 'yerky memeg', 'yerkymmg@gmail.com', '$2y$10$9Y/5NLyoe/fK1AT49TjbVeLyx8XC/CtuJrF/3k5ZH93PgU9BC5P72', 'user', NULL, '2024-11-21 12:53:29'),
(2, 'YuFi', 'example@example.com', '$2y$10$ihSztVUt.al3jQhNaxpKguNRVs6wFz7yAHCvlJXlwXwbacNlgRVsC', 'admin', NULL, '2024-11-21 12:54:23'),
(3, 'yerky', 'yerkysabana1994@gmail.com', '$2y$10$cl4vat0vA2AiVcajH5yJxuvDgSuflGfLyI12VTOXQPJcSKIMIBY9i', 'admin', NULL, '2024-11-21 13:54:48'),
(4, 'yerkysabana', 'yerky_syahbana@yahoo.com', '$2y$10$zTz.TwQPPrqfepatNmg/neUIZ/qXjnrk7rXpvuJRdtJ6MmumiCOmq', 'user', NULL, '2024-11-21 14:05:52'),
(7, 'zidanmemeg', 'zidanmemeg@gmail.com', '$2y$10$WIvDq.MR6LYt4hqCLmvbHOtcDFUs7V/ND25/5wofEZ678IIt8XEJ6', 'user', NULL, '2024-11-27 14:36:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `concerts`
--

CREATE TABLE `concerts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_data` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konser`
--

CREATE TABLE `konser` (
  `id` int(11) NOT NULL,
  `nama_artis` varchar(100) NOT NULL,
  `tempat` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `concert_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konser`
--

INSERT INTO `konser` (`id`, `nama_artis`, `tempat`, `tanggal`, `harga`, `gambar`, `stock`, `concert_name`) VALUES
(9, 'yerky', 'glora bungkarno', '2025-07-07', 0.00, '1732725851_WhatsApp Image 2024-02-26 at 19.23.54_4cc0cf80.jpg', 990, NULL),
(11, 'matia', 'blotongan', '2025-06-06', 0.00, '1733226745_WhatsApp Image 2024-02-26 at 19.23.54_4cc0cf80.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `concert_id` int(11) NOT NULL,
  `ticket_type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ticket_code` varchar(255) NOT NULL,
  `kode_tiket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `concert_id`, `ticket_type`, `name`, `email`, `phone`, `payment_status`, `created_at`, `ticket_code`, `kode_tiket`) VALUES
(40, 9, 'Regular', 'Yerki Sabana', 'yerkysabana1994@gmail.com', '081327450149', 'Validated', '2024-11-27 16:44:40', '', ''),
(41, 9, 'Regular', 'Yerki Sabana', 'yerkysabana1994@gmail.com', '081327450149', 'Validated', '2024-12-03 10:06:39', '', ''),
(42, 9, 'VIP', 'ADIT', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 10:20:07', '', ''),
(43, 9, 'Regular', 'Yerki Sabana', 'yerkysabana1994@gmail.com', '081327450149', 'Validated', '2024-12-03 10:39:07', '', ''),
(49, 9, 'Regular', 'Yerki Sabana', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 11:16:06', '', ''),
(52, 9, 'VIP', 'Yerki Sabana', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:12:45', '', ''),
(53, 9, 'VIP', 'Yerki', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:14:14', '', ''),
(54, 9, 'Regular', 'asasa', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:15:27', '', ''),
(55, 9, 'VIP', 'asa', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:16:41', '', ''),
(56, 9, 'VIP', 'Yerki Sabana', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:17:50', '', ''),
(57, 11, 'VIP', 'Yerki Sabana', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:18:27', '', ''),
(58, 9, 'VIP', 'Yerki Sabana', 'yerky_syahbana@yahoo.com', '081327450149', 'Validated', '2024-12-03 12:20:32', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `concert_id` int(11) NOT NULL,
  `ticket_type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `tipe_kursi` varchar(50) NOT NULL,
  `jumlah_pesanan` int(11) NOT NULL,
  `nama_konser` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id` int(11) NOT NULL,
  `namakonser` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id`, `namakonser`, `price`) VALUES
(3, 'newjeans 19 november', 1000000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `concerts`
--
ALTER TABLE `concerts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `konser`
--
ALTER TABLE `konser`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_concert_id` (`concert_id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concert_id` (`concert_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `concerts`
--
ALTER TABLE `concerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konser`
--
ALTER TABLE `konser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_concert_id` FOREIGN KEY (`concert_id`) REFERENCES `konser` (`id`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`concert_id`) REFERENCES `konser` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
