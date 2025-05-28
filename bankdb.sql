-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 11:03 PM
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
-- Database: `bankdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `acc_number` varchar(32) NOT NULL,
  `type` varchar(64) NOT NULL,
  `balance` int(11) NOT NULL,
  `iban` varchar(32) NOT NULL,
  `currency` enum('Euro','Lek','Dollar') NOT NULL,
  `commission` double(32,0) NOT NULL,
  `category` enum('Regular','Student') NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `acc_number`, `type`, `balance`, `iban`, `currency`, `commission`, `category`, `user_id`) VALUES
(3, '1000003', 'Checking', 5000010, 'AL1591000003159753', 'Euro', 1, 'Regular', 5),
(5, '1000005', 'Checking', 50, 'AL1591000005159753', 'Euro', 1, 'Regular', 5);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `sender_acc` int(11) NOT NULL,
  `receiver_acc` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','teller','manager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastName`, `username`, `email`, `phoneNumber`, `password`, `role`) VALUES
(5, 'Shpetim', 'Shabanaj', 'shpetim10', 'sshabanaj23@epoka.edu.al', '+355 68 763 433', '$2y$10$zqc0CM3B3PlMYeI7REDH2ezQLbNtjw3wzeXZEY5uUcNOHpzAiy5wG', 'user'),
(7, 'Arjan', 'Muka', 'armuka', 'armuka23@epoka.edu.al', '+355 67 8521 445', '$2y$10$p6venEgZT/ZszQbXh6Ni9eU8FaX.lWTCA3RoFL3uuv0q3QEqTT5q6', 'manager'),
(8, 'Artjol', 'Zaimi', 'artjol', 'tole123@gmail.com', '+355 68 2451 253', '$2y$10$Dy8PttjROLD3EfHONwj3w.HH3aq.IxZ4nNpo9/pb6FfNR9B2Pd5n2', 'teller'),
(9, 'Nikola', 'Rigo', 'niko', 'nrigo23@epoka.edu.al', '+355 67 661 6126', '$2y$10$7fq.iXQViL2hZXQZSp0VbuYNrf6kjA7ssMcKbvkPFknxqpDS94TQi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_acc` (`sender_acc`),
  ADD KEY `receiver_acc` (`receiver_acc`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_acc`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`receiver_acc`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
