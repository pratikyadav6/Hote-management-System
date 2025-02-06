-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 09:12 AM
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
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bil_id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `bill_amount` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `order_type` varchar(20) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `cash_received` int(11) NOT NULL DEFAULT 0,
  `change_due` int(11) NOT NULL DEFAULT 0,
  `discount` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `order_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bil_id`, `table_no`, `bill_amount`, `staff_id`, `order_type`, `payment_type`, `cash_received`, `change_due`, `discount`, `date`, `order_no`) VALUES
(1, 1, 150, 6, 'at hotel', 'cash', 200, 50, 0, '2024-08-01 00:00:00', 0),
(2, 1, 210, 6, 'at hotel', 'cash', 250, 40, 0, '2024-08-01 10:58:46', 0),
(3, 1, 300, 1, 'at hotel', 'online', 0, 0, 0, '2024-08-01 11:03:23', 0),
(4, 1, 450, 1, 'at hotel', 'card', 0, 0, 0, '2024-08-01 11:14:46', 0),
(5, 1, 300, 1, 'at hotel', 'card', 0, 0, 0, '2024-08-01 11:15:37', 0),
(6, 1, 360, 1, 'at hotel', 'online', 0, 0, 0, '2024-08-01 11:33:26', 1),
(7, 1, 150, 1, 'at hotel', 'online', 0, 0, 0, '2024-08-01 11:36:14', 2),
(8, 1, 150, 1, 'take away', 'online', 0, 0, 0, '2024-08-01 11:36:52', 3),
(9, 2, 480, 1, 'at hotel', 'online', 0, 0, 0, '2024-08-01 11:38:00', 1),
(10, 1, 150, 1, 'at hotel', 'cash', 200, 90, 90, '2024-08-01 11:55:02', 4),
(11, 1, 780, 1, 'take away', 'cash', 400, 10, 10, '2024-08-01 12:05:55', 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'food'),
(4, 'drinks'),
(5, 'Strater'),
(6, 'ice-cream');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `item_name` varchar(40) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(20) NOT NULL,
  `o_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `item_name`, `description`, `price`, `category`, `o_type`) VALUES
(16, 'pm', 'Panner masala', 'panner masala', 150, 'food', 'main course'),
(17, 'mp', 'Masala Papad', 'Masala Papad', 30, 'food', 'starters'),
(18, 'ct', 'chicken tat', 'chickentat', 210, 'food', 'main course'),
(19, 'r', 'roti', 'roti', 20, 'food', 'main course'),
(20, 'ch', 'Chicken Handi ( HAlF)', 'Chicken Handi ', 300, 'food', 'main course'),
(21, 'mb', 'Masala Papad (Bigg)', 'Masala Papad (Bigg)', 70, 'food', 'starters');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `item_name` varchar(20) NOT NULL,
  `item_code` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `s_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `table_no`, `category`, `item_name`, `item_code`, `quantity`, `price`, `status`, `date`, `s_id`, `order_no`) VALUES
(193, 1, 'food', 'Panner masala', 'pm', 1, 150, 'paid', '2024-08-01 11:35:34', 1, 2),
(194, 1, 'food', 'Panner masala', 'pm', 1, 150, 'paid', '2024-08-01 11:36:41', 1, 3),
(195, 2, 'food', 'Panner masala', 'pm', 1, 150, 'paid', '2024-08-01 11:37:25', 1, 1),
(196, 2, 'food', 'roti', 'r', 5, 20, 'paid', '2024-08-01 11:37:28', 1, 1),
(197, 2, 'food', 'roti', 'r', 1, 20, 'paid', '2024-08-01 11:37:31', 1, 1),
(198, 2, 'food', 'chicken tat', 'ct', 1, 210, 'paid', '2024-08-01 11:37:35', 1, 1),
(199, 1, 'food', 'Panner masala', 'pm', 1, 150, 'paid', '2024-08-01 11:44:29', 1, 4),
(200, 1, 'food', 'Panner masala', 'pm', 2, 150, 'paid', '2024-08-01 11:56:36', 1, 5),
(201, 1, 'food', 'roti', 'r', 3, 20, 'paid', '2024-08-01 11:56:42', 1, 5),
(202, 1, 'food', 'chicken tat', 'ct', 2, 210, 'paid', '2024-08-01 11:58:32', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_type`
--

CREATE TABLE `order_type` (
  `id` int(11) NOT NULL,
  `o_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_type`
--

INSERT INTO `order_type` (`id`, `o_type`) VALUES
(1, 'starters'),
(3, 'main course');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_no` int(11) NOT NULL,
  `table_strength` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `bill_amount` int(10) NOT NULL,
  `order_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_no`, `table_strength`, `floor`, `status`, `bill_amount`, `order_no`) VALUES
(1, 4, 1, 'unreserved', 0, 5),
(2, 4, 2, 'unreserved', 0, 1),
(3, 4, 1, 'unreserved', 0, 0),
(4, 2, 2, 'unreserved', 0, 0),
(5, 3, 1, 'unreserved', 0, 0),
(6, 3, 2, 'unreserved', 0, 0),
(7, 4, 1, 'unreserved', 0, 0),
(8, 4, 1, 'unreserved', 0, 0),
(9, 4, 2, 'unreserved', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `mobile_no`, `type`) VALUES
(1, 'Pratik', 'Yadav', 'ypk@gmail.com', '756efe44439c3927d6d28eefd55c2009', '2147483647', 'admin'),
(2, 'harish', 'patil', 'harish@gmail.com', '202cb962ac59075b964b07152d234b70', '2147483647', 'staff'),
(3, 'suhas', 'patil', 'suhas@gmail.com', '202cb962ac59075b964b07152d234b70', '9171827384', 'staff'),
(5, 'sohan', 'Kulkarni', 'sk@gmail.com', '202cb962ac59075b964b07152d234b70', '9876543212', 'kitchen_manager'),
(6, 'suhas', 'mali', 'sm@gmail.com', '202cb962ac59075b964b07152d234b70', '56789129', 'staff'),
(7, 'rahul', 'patil', 'rp@gmal.com', '202cb962ac59075b964b07152d234b70', '8798098789', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bil_id`),
  ADD KEY `table_no` (`table_no`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_code` (`item_code`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_code` (`item_code`),
  ADD KEY `table_no` (`table_no`);

--
-- Indexes for table `order_type`
--
ALTER TABLE `order_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `order_type`
--
ALTER TABLE `order_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`table_no`) REFERENCES `tables` (`table_no`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`item_code`) REFERENCES `items` (`item_code`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`table_no`) REFERENCES `tables` (`table_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
