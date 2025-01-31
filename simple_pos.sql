-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 25, 2025 at 03:21 PM
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
-- Database: `simple_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `manager` int(11) NOT NULL,
  `shop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`manager`, `shop`) VALUES
(21, 10),
(22, 11),
(23, 12);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `shop` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `sell_price`, `shop`) VALUES
(11, 'Sukari', 8000, 10),
(12, 'Unga', 3500, 10),
(13, 'Cocacola crates', 13500, 10);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`shop_id`, `name`, `owner`) VALUES
(10, 'Muleba one', 20),
(11, 'Kiboto shop', 20),
(12, 'Safina electronics', 20);

-- --------------------------------------------------------

--
-- Table structure for table `unit_purchases`
--

CREATE TABLE `unit_purchases` (
  `purchase_id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `price_per_item` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `items` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_purchases`
--

INSERT INTO `unit_purchases` (`purchase_id`, `product`, `owner`, `price_per_item`, `time`, `items`) VALUES
(26, 13, 20, 10000, '2025-01-07 06:41:04', 1),
(27, 13, 20, 10000, '2025-01-07 06:41:34', 1),
(28, 13, 20, 10000, '2025-01-07 06:42:01', 3),
(29, 11, 20, 5000, '2025-01-07 06:42:54', 1),
(30, 11, 20, 5000, '2025-01-07 06:45:03', 3),
(31, 11, 20, 5000, '2025-01-07 13:47:30', 2),
(32, 11, 20, 5000, '2025-01-08 08:10:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `unit_sales`
--

CREATE TABLE `unit_sales` (
  `sale_id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `manager` int(11) NOT NULL,
  `price_per_unit` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_sales`
--

INSERT INTO `unit_sales` (`sale_id`, `product`, `manager`, `price_per_unit`, `time`, `units`) VALUES
(21, 11, 21, 8000, '2025-01-07 13:25:27', 1),
(22, 11, 21, 8000, '2025-01-07 13:26:04', 1),
(23, 11, 21, 8000, '2025-01-07 13:29:16', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'MANAGER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `password`, `phone`, `role`) VALUES
(18, 'fari', 'Faraji', '$2y$10$DWMiZ3shqUjeRYeLpt7Dku89gTw4SWusAP86lb5xlXLpVpYVNvyRe', '0625989195', 'ADMIN'),
(19, 'azi', 'Azim', '$2y$10$kZprMaxbL8SBc48hcag3OOW5l0oVMI08R0EGO49m0AAXLClEjEP9O', '0755464074', 'ADMIN'),
(20, 'mama', 'Ashura', '$2y$10$JdPZDodZjjTkn4nLTC5Q7.U39VkN.N7tkoMKjo0xVvRD4pBovaUEu', '0755778818', 'ADMIN'),
(21, 'maabuba', 'Mama abuba', '$2y$10$hs6jXb7frwRjzX7LjGVDCuSzGPsTkpkO73Ov4ADf8Ck2ZfYrCuBnC', '9877665', 'MANAGER'),
(22, 'maaziali', 'Mama aziali', '$2y$10$0KcoeeFgxq923o8hKoR7jOWrTUxP7GTuuAFCpn3xHi70REUuvbIF2', '897798', 'MANAGER'),
(23, 'manaswi', 'Mama Naswiru', '$2y$10$AV9zH8FgMwH5xJxH7T.4fO.UUBI5DaTi0uwe/AgjejaRE/7pnenHW', '787467', 'MANAGER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`manager`,`shop`),
  ADD UNIQUE KEY `manager` (`manager`),
  ADD UNIQUE KEY `shop` (`shop`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `shop` (`shop`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`shop_id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `unit_purchases`
--
ALTER TABLE `unit_purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `product` (`product`),
  ADD KEY `manager` (`owner`);

--
-- Indexes for table `unit_sales`
--
ALTER TABLE `unit_sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `product` (`product`),
  ADD KEY `manager` (`manager`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `unit_purchases`
--
ALTER TABLE `unit_purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `unit_sales`
--
ALTER TABLE `unit_sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `managers`
--
ALTER TABLE `managers`
  ADD CONSTRAINT `managers_ibfk_1` FOREIGN KEY (`manager`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `managers_ibfk_2` FOREIGN KEY (`shop`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shop`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit_purchases`
--
ALTER TABLE `unit_purchases`
  ADD CONSTRAINT `unit_purchases_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_purchases_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit_sales`
--
ALTER TABLE `unit_sales`
  ADD CONSTRAINT `unit_sales_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_sales_ibfk_2` FOREIGN KEY (`manager`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
