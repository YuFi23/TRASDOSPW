-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 07:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caffe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,2) NOT NULL CHECK (`harga` >= 0),
  `kategori` enum('makanan','minuman','snack') NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `deskripsi`, `harga`, `kategori`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Nasi Goreng', 'Nasi goreng spesial dengan topping telur', 25000.00, 'makanan', 'DSC_0140.JPG', '2024-12-03 13:10:10', '2024-12-03 18:05:25'),
(2, 'Es Teh Manis', 'Minuman es teh manis segar', 8000.00, 'minuman', 'UKSW [KoleksiLogo.com].png', '2024-12-03 13:10:10', '2024-12-03 18:06:45'),
(3, 'Kentang Goreng', 'Cemilan kentang goreng crispy', 15000.00, 'snack', 'Fakultas_Teknologi_Informasi_UKSW_-_Kritis_Kreatif_Inovatif.png', '2024-12-03 13:10:10', '2024-12-03 18:06:56'),
(4, 'Kentang Gosong', 'Cemilan kentang goreng crispy', 10000.00, 'makanan', '91d9ee7c55cf5db5842eeeb31aa99537.jpg', '2024-12-03 18:03:39', '2024-12-03 18:03:39');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `nomor_meja` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL CHECK (`jumlah` > 0),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama_pelanggan`, `nama_menu`, `nomor_meja`, `jumlah`, `created_at`, `updated_at`, `total_harga`) VALUES
(4, 'adit', 'Nasi Goreng', 4, 1, '2024-12-03 16:35:07', '2024-12-03 16:35:07', NULL),
(6, 'yerky', 'Nasi Goreng', 5, 2, '2024-12-03 16:41:54', '2024-12-03 16:41:54', NULL),
(11, 'muti', 'Nasi Goreng', 7, 2, '2024-12-03 16:46:39', '2024-12-03 16:46:39', NULL),
(14, 'tea', 'Nasi Goreng', 9, 2, '2024-12-03 16:50:17', '2024-12-03 16:50:17', NULL),
(17, 'yaya', 'Nasi Goreng', 1, 1, '2024-12-03 17:48:19', '2024-12-03 17:48:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_reservations`
--

CREATE TABLE `table_reservations` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `table_number` int(11) NOT NULL,
  `reservation_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_reservations`
--

INSERT INTO `table_reservations` (`id`, `user_name`, `table_number`, `reservation_time`) VALUES
(1, 'adit', 4, '2024-12-03 16:33:19'),
(2, 'adit', 4, '2024-12-03 16:35:07'),
(3, 'adit', 4, '2024-12-03 16:35:12'),
(4, 'adit', 4, '2024-12-03 16:35:52'),
(5, 'yerky', 5, '2024-12-03 16:41:54'),
(6, 'muti', 7, '2024-12-03 16:46:39'),
(7, 'muti', 7, '2024-12-03 16:48:56'),
(8, 'tea', 9, '2024-12-03 16:50:17'),
(9, 'tea', 9, '2024-12-03 16:52:34'),
(10, 'pan', 10, '2024-12-03 16:52:50'),
(11, 'yaya', 1, '2024-12-03 17:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@cafe.com', 'password_hash_admin', 'admin', NULL, '2024-12-03 13:10:10', '2024-12-03 13:10:10'),
(2, 'john_doe', 'john@example.com', 'password_hash_user', 'user', NULL, '2024-12-03 13:10:10', '2024-12-03 13:10:10'),
(3, 'yerkysabana', 'yerkysabana1994@gmail.com', '$2y$10$aff3Ro9pkotFcpZC.rpWGObBtLXJxPHerhYh3ABrnXlKczCkZKC7O', 'admin', NULL, '2024-12-03 13:13:55', '2024-12-03 13:15:10'),
(4, 'Yerky', 'yerky_syahbana@yahoo.com', '$2y$10$BPAyL8b9Vp/Xe6kXpz53MetfXxvEbfzaEibv0ye4Tf.tvoLT7/MS.', 'user', NULL, '2024-12-03 13:14:50', '2024-12-03 13:14:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_menu` (`nama_menu`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama_menu` (`nama_menu`);

--
-- Indexes for table `table_reservations`
--
ALTER TABLE `table_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `table_reservations`
--
ALTER TABLE `table_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`nama_menu`) REFERENCES `menu` (`nama_menu`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
