-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2026 at 12:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

CREATE DATABASE IF NOT EXISTS iti_php_project;
USE iti_php_project;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iti_php_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `room_id`, `notes`, `status`, `total_price`, `created_at`) VALUES
(1, 2, 2, 'No sugar', 'pending', 35.00, '2026-03-15 23:32:49'),
(2, 3, 3, '', 'processing', 30.00, '2026-03-15 23:32:49'),
(3, 4, 4, 'Extra hot', 'completed', 45.00, '2026-03-15 23:32:49'),
(4, 1, 5, '', 'pending', 38.00, '2026-03-15 23:32:49'),
(5, 3, 3, 'notes on order', 'completed', 70.00, '2026-03-15 23:39:40'),
(6, 1, 1, 'en', 'pending', 63.00, '2026-03-15 23:53:00'),
(7, 3, 1, '', 'pending', 10.00, '2026-03-16 01:59:29'),
(8, 3, 1, '', 'pending', 32.00, '2026-03-16 02:15:36'),
(9, 1, 1, '', 'pending', 38.00, '2026-03-16 02:44:56'),
(10, 1, 1, '', 'cancelled', 27.00, '2026-03-16 02:48:33'),
(11, 2, 1, '', 'pending', 30.00, '2026-03-16 02:49:39'),
(12, 3, 1, '', 'pending', 15.00, '2026-03-16 03:00:44'),
(13, 4, 1, '', 'pending', 126.00, '2026-03-16 03:11:58'),
(14, 1, 1, '', 'pending', 75.00, '2026-03-16 03:12:17'),
(15, 2, 1, '', 'cancelled', 50.00, '2026-03-16 03:16:16'),
(16, 3, 3, '', 'pending', 34.00, '2026-03-16 02:49:30'),
(17, 4, 1, '', 'pending', 50.00, '2026-03-16 03:52:22'),
(18, 1, 2, '', 'pending', 40.00, '2026-03-16 02:52:59'),
(19, 2, 1, '', 'pending', 50.00, '2026-03-16 04:23:31'),
(20, 1, 2, 'test', 'pending', 25.00, '2026-03-16 05:36:40'),
(21, 2, 1, '', 'pending', 25.00, '2026-03-16 05:37:08'),
(22, 3, 1, '', 'cancelled', 32.00, '2026-03-16 05:37:17'),
(23, 4, 1, '', 'pending', 52.00, '2026-03-16 11:44:07'),
(24, 1, 1, '', 'cancelled', 33.00, '2026-03-16 12:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 10.00),
(2, 1, 2, 1, 15.00),
(3, 1, 8, 1, 10.00),
(4, 2, 4, 1, 25.00),
(5, 2, 9, 1, 5.00),
(6, 3, 4, 1, 25.00),
(7, 3, 8, 2, 10.00),
(8, 4, 3, 1, 20.00),
(9, 4, 7, 1, 18.00),
(10, 5, 1, 2, 10.00),
(11, 5, 2, 2, 15.00),
(12, 5, 3, 1, 20.00),
(13, 6, 1, 2, 10.00),
(14, 6, 7, 1, 18.00),
(15, 6, 4, 1, 25.00),
(16, 7, 1, 1, 10.00),
(17, 8, 1, 2, 10.00),
(18, 8, 10, 1, 12.00),
(19, 9, 3, 2, 20.00),
(20, 9, 4, 1, 25.00),
(21, 10, 3, 1, 20.00),
(22, 10, 7, 1, 18.00),
(23, 11, 2, 1, 15.00),
(24, 11, 5, 1, 12.00),
(25, 12, 6, 1, 12.00),
(26, 12, 7, 1, 18.00),
(27, 13, 2, 1, 15.00),
(28, 14, 3, 1, 20.00),
(29, 14, 8, 1, 10.00),
(30, 14, 5, 1, 12.00),
(31, 14, 10, 2, 12.00),
(32, 14, 9, 1, 8.00),
(33, 14, 2, 1, 15.00),
(34, 15, 4, 3, 25.00),
(35, 16, 2, 2, 15.00),
(36, 16, 3, 1, 20.00),
(37, 17, 1, 1, 10.00),
(38, 17, 5, 2, 12.00),
(39, 18, 1, 1, 10.00),
(40, 18, 2, 1, 15.00),
(41, 18, 4, 1, 25.00),
(42, 19, 3, 1, 20.00),
(43, 19, 5, 1, 20.00),
(44, 20, 1, 1, 10.00),
(45, 20, 2, 1, 15.00),
(46, 21, 4, 2, 25.00),
(47, 22, 1, 1, 10.00),
(48, 22, 2, 1, 15.00),
(49, 23, 4, 1, 25.00),
(50, 24, 8, 2, 10.00),
(51, 24, 5, 1, 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`, `is_available`) VALUES
(1, 'Tea', 10.00, 'Tea.png', 1, 1),
(2, 'Coffee', 15.00, 'Coffee.png', 1, 1),
(3, 'Latte', 20.00, 'Latte.png', 1, 1),
(4, 'Cappuccino', 25.00, 'Cappuccino.png', 1, 1),
(5, 'Pepsi', 12.00, 'Pepsi.png', 2, 1),
(6, '7UP', 12.00, '7up.png', 2, 1),
(7, 'Orange Juice', 18.00, 'OrangeJuice.png', 2, 1),
(8, 'Chips', 10.00, 'Chips.png', 3, 1),
(9, 'Biscuits', 8.00, 'Biscuits.png', 3, 1),
(10, 'Chocolate', 12.00, 'Chocolate.png', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`) VALUES
(1, 'Hot Drinks'),
(2, 'Cold Drinks'),
(3, 'Snacks'),
(4, 'Desserts');


-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `name`) VALUES
(1, 101, 'Room 101'),
(2, 102, 'Room 102'),
(3, 103, 'Room 103'),
(4, 104, 'Room 104'),
(5, 105, 'Room 105');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `ext` varchar(10) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `room_id`, `ext`, `role`, `image`) VALUES
(1, 'Admin', 'admin@cafeteria.com', '$2y$10$dD2IoDSwbV66Kv5zVt0MtOLRJzI9Blddp.jeEQctZZ2f4OUC0MlRS', 1, '101', 'admin', 'NULL'),
(2, 'Ahmed Mohamed', 'ahmed@cafeteria.com', '$2y$10$dD2IoDSwbV66Kv5zVt0MtOLRJzI9Blddp.jeEQctZZ2f4OUC0MlRS', 2, '102', 'user', 'NULL'),
(3, 'Sara Ali', 'sara@cafeteria.com', '$2y$10$dD2IoDSwbV66Kv5zVt0MtOLRJzI9Blddp.jeEQctZZ2f4OUC0MlRS', 3, '103', 'user', 'NULL'),
(4, 'Omar Khaled', 'omar@cafeteria.com', '$2y$10$dD2IoDSwbV66Kv5zVt0MtOLRJzI9Blddp.jeEQctZZ2f4OUC0MlRS', 4, '104', 'user', 'NULL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
