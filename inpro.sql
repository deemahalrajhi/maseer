-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2024 at 06:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `gates_info`
--

CREATE TABLE `gates_info` (
  `id` int(30) NOT NULL,
  `gate` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `last_modified` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gates_info`
--

INSERT INTO `gates_info` (`id`, `gate`, `status`, `last_modified`) VALUES
(1, 'Gate 1', 'closed', '2024-01-22 11:07'),
(2, 'Gate 2', 'opened', '2024-01-22 10:42'),
(3, 'Gate 3', 'opened', '2024-01-22 10:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `number_id` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `number_id`, `phone`, `password`, `type`) VALUES
(6, '123456789', '123456789', '$2y$10$Yy7QZq1KcPVGimPGFRL9Fug.qqNgPjHbcOHqB9p0wXCpHw9qcf5QC', 'user'),
(7, '0000', '0000', '$2y$10$1eowjO7Iy30CSy4AwNFyXOqaEvpwnlAdboN1kdDKkikoFu6XVViIK', 'admin'),
(8, '12345678901', '', '$2y$10$Yy7QZq1KcPVGimPGFRL9Fug.qqNgPjHbcOHqB9p0wXCpHw9qcf5QC', 'admin'),
(9, '09876543210', '', '$2y$10$RCC5qvtTaMZ2f13SY.3pDeeH2/Us/ORzT4Rrh3FJVG74tOsXoPbuG', 'admin'),
(11, 'rizwan2', '123', '$2y$10$q.MIbB7UmOO1dbQ3X1VLQepTbid531hX.Aj5IH82hNU45KTsUIzqy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gates_info`
--
ALTER TABLE `gates_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gates_info`
--
ALTER TABLE `gates_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
