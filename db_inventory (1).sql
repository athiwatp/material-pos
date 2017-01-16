-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2017 at 08:00 AM
-- Server version: 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `customer_code` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_credit_limit` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_code`, `customer_name`, `customer_company`, `customer_address`, `customer_email`, `customer_contact`, `customer_credit_limit`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Robert Soriano', '', '', '', '', 0, 1, NULL, NULL),
(2, NULL, 'Joshua Soriano', '', '', '', '', 0, 1, NULL, NULL),
(3, NULL, 'Mark Soriano', '', '', '', '', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_history`
--

CREATE TABLE `customer_history` (
  `chistory_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `action` int(11) NOT NULL DEFAULT '0'COMMENT
) ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `payment_id` int(11) NOT NULL,
  `payment_amount` double NOT NULL,
  `or_number` varchar(255) NOT NULL,
  `account_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`payment_id`, `payment_amount`, `or_number`, `account_id`, `notes`, `created_at`) VALUES
(1, 1, '00000001', 4, '', '2017-01-15 12:42:01'),
(2, 11479, '00000001', 4, '', '2017-01-15 12:42:15'),
(3, 750, '00000002', 4, 'payment for a cute text', '2017-01-15 13:37:39'),
(4, 500, '00000002', 4, 'another payment', '2017-01-15 13:38:31'),
(5, 500, '00000002', 4, 'an other', '2017-01-15 13:46:03'),
(6, 50, '00000002', 4, 'another payment', '2017-01-15 13:46:42'),
(7, 1, '00000002', 4, 'just another payment', '2017-01-15 13:49:12'),
(8, 100, '00000002', 4, 'another payment', '2017-01-15 13:53:36'),
(9, 100, '00000002', 4, 'none', '2017-01-15 13:54:30'),
(10, 100, '00000002', 4, 'none', '2017-01-15 13:55:41'),
(11, 200, '00000002', 4, 'another payment', '2017-01-15 14:15:05'),
(12, 100, '00000002', 4, 'sd', '2017-01-15 14:16:02'),
(13, 5, '00000002', 4, 'uhouh', '2017-01-15 14:17:48'),
(14, 50, '00000002', 4, 'dsf', '2017-01-15 14:18:01'),
(15, 5, '00000002', 4, 'hjk', '2017-01-15 14:18:50'),
(16, 5, '00000002', 4, 'wer', '2017-01-15 14:22:15'),
(17, 5, '00000002', 4, 'g', '2017-01-15 14:22:46'),
(18, 5, '00000002', 4, 'tyh', '2017-01-15 14:23:03'),
(19, 1, '00000002', 4, 'r', '2017-01-15 14:23:20'),
(20, 1, '00000002', 4, 'j', '2017-01-15 14:23:39'),
(21, 1, '00000002', 4, 'tt', '2017-01-15 14:24:05'),
(22, 2, '00000002', 4, 'ds', '2017-01-15 14:24:20'),
(23, 3, '00000002', 4, 'asdf', '2017-01-15 14:24:38'),
(24, 5, '00000002', 4, 'ry', '2017-01-15 14:24:57'),
(25, 52, '00000002', 4, 'another 52', '2017-01-15 14:28:42'),
(26, 100, '00000002', 4, 'qwe', '2017-01-15 14:29:09'),
(27, 50, '00000002', 4, 'hj', '2017-01-15 14:30:02'),
(28, 855, '00000003', 4, 'qwe', '2017-01-15 14:30:59'),
(29, 85, '00000003', 4, 'gyu', '2017-01-15 14:32:10'),
(30, 521, '00000003', 4, 'qwe', '2017-01-15 14:32:43'),
(31, 200, '00000003', 4, '234', '2017-01-15 14:47:31'),
(32, 123, '00000003', 4, 'qwe', '2017-01-15 14:48:01'),
(33, 2, '00000002', 4, '3', '2017-01-15 14:54:13'),
(34, 2, '00000003', 4, '3hg', '2017-01-15 14:55:43'),
(35, 1, '00000003', 4, 'w', '2017-01-15 14:56:24'),
(36, 1, '00000003', 4, 'yy', '2017-01-15 14:57:11'),
(37, 10, '00000003', 4, 'gg', '2017-01-15 14:57:36'),
(38, 1, '00000003', 4, 'i', '2017-01-15 14:58:15'),
(39, 2, '00000003', 4, 'ss', '2017-01-15 14:58:39'),
(40, 50, '00000003', 4, '4', '2017-01-15 15:01:49'),
(41, 200, '00000004', 4, 'sdasd', '2017-01-15 15:29:55'),
(42, 100, '00000004', 4, 'ty', '2017-01-15 15:32:16'),
(43, 100, '00000004', 4, 'none lang', '2017-01-15 15:37:06'),
(44, 100, '00000004', 4, 'rft', '2017-01-15 15:37:56'),
(45, 100, '00000004', 4, 'dfgdfg', '2017-01-15 15:38:46'),
(46, 100, '00000004', 4, 'qwe', '2017-01-15 15:41:12'),
(47, 100, '00000004', 4, 'ddd', '2017-01-15 15:41:58'),
(48, 12, '00000004', 4, 'qweqwe', '2017-01-15 15:42:21'),
(49, 12, '00000004', 4, 'qew', '2017-01-15 15:43:03'),
(50, 2, '00000004', 4, 'w', '2017-01-15 15:43:27'),
(51, 2, '00000004', 4, 'f', '2017-01-15 15:44:03'),
(52, 2, '00000004', 4, '22', '2017-01-15 15:44:55'),
(53, 250, '00000004', 4, 'qweqe', '2017-01-15 15:45:21'),
(54, 238, '00000004', 4, 'Some of the remaining blanace', '2017-01-15 15:46:36'),
(55, 100, '00000004', 4, 'another cute payment', '2017-01-15 15:47:41'),
(56, 23, '00000004', 4, 'adasdadadadada', '2017-01-15 15:48:23'),
(57, 23, '00000004', 4, '23232', '2017-01-15 15:48:42'),
(58, 2, '00000004', 4, '23', '2017-01-15 15:49:55'),
(59, 2, '00000004', 4, '222', '2017-01-15 15:50:19'),
(60, 2, '00000004', 4, 'asd', '2017-01-15 15:50:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT '0',
  `manufacturer_id` int(11) NOT NULL DEFAULT '1',
  `product_price` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_name`, `product_quantity`, `manufacturer_id`, `product_price`, `created_at`, `updated_at`) VALUES
(1, 'AB1234s', 'Small AB', 29, 1, 125, '2017-01-10 12:05:57', '2017-01-10 12:05:57'),
(2, 'AB123m', 'Medium AB', 45, 1, 500, '2017-01-10 12:06:08', '2017-01-10 12:06:08'),
(3, 'XG-2412', 'OKAYw', 1, 1, 232, '2017-01-10 12:06:17', '2017-01-10 12:06:17'),
(4, 'AB123ms', 'qweea', 42, 1, 123, '2017-01-10 13:00:21', '2017-01-10 13:00:21'),
(5, 'AB123msx', '232', 12, 1, 123, '2017-01-10 13:01:05', '2017-01-10 13:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `product_history`
--

CREATE TABLE `product_history` (
  `phistory_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0'COMMENT
) ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_total` double NOT NULL,
  `transaction_type` int(11) NOT NULL COMMENT '0 = cash, 1 = acct',
  `or_number` varchar(255) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `customer_id`, `sales_total`, `transaction_type`, `or_number`, `account_id`, `created_at`) VALUES
(1, 2, 11480, 1, '00000001', 4, '2017-01-15 12:41:22'),
(2, 1, 2750, 0, '00000002', 4, '2017-01-15 13:12:04'),
(3, 2, 1855, 1, '00000003', 4, '2017-01-15 14:30:36'),
(4, 3, 2234, 1, '00000004', 4, '2017-01-15 15:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `sales_summary`
--

CREATE TABLE `sales_summary` (
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `sale_quantity` int(11) NOT NULL,
  `or_number` varchar(255) NOT NULL DEFAULT '0',
  `total_price` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_summary`
--

INSERT INTO `sales_summary` (`sale_id`, `product_id`, `product_name`, `sale_quantity`, `or_number`, `total_price`, `created_at`) VALUES
(1, 2, 'Medium AB', 20, '00000001', 10000, '2017-01-15 12:41:22'),
(2, 1, 'Small AB', 2, '00000001', 250, '2017-01-15 12:41:22'),
(3, 4, 'qweea', 10, '00000001', 1230, '2017-01-15 12:41:22'),
(4, 2, 'Medium AB', 5, '00000002', 2500, '2017-01-15 13:12:04'),
(5, 1, 'Small AB', 2, '00000002', 250, '2017-01-15 13:12:04'),
(6, 4, 'qweea', 10, '00000003', 1230, '2017-01-15 14:30:36'),
(7, 1, 'Small AB', 5, '00000003', 625, '2017-01-15 14:30:36'),
(8, 1, 'Small AB', 10, '00000004', 1250, '2017-01-15 15:29:43'),
(9, 4, 'qweea', 8, '00000004', 984, '2017-01-15 15:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action_token` char(64) COLLATE utf8_unicode_ci DEFAULT '',
  `access_token` char(64) COLLATE utf8_unicode_ci DEFAULT '',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `failed_attempts` int(11) NOT NULL DEFAULT '0',
  `last_fail_at` datetime DEFAULT NULL,
  `locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `ip`, `username`, `email`, `password`, `action_token`, `access_token`, `activated`, `banned`, `failed_attempts`, `last_fail_at`, `locked_until`) VALUES
(4, '2016-12-24 07:42:15', '2017-01-05 11:56:19', '::1', 'admin', 'sorianorobertc@gmail.com', '$2y$10$mRXj8P1S1p6V357rUWic8ucctb9OQnBwEOPGoZNZVpyWbactn13Bm', 'c000d28e7f6f3a94c6f7a7607ce89798252a81de7dd2b42077edd82e1278d992', 'b5ec3325ad514c2f250d37527d83d69cf364048a3b0f33f61e21b9ec06afc8f4', 1, 0, 0, '2017-01-05 11:56:15', NULL),
(6, '2016-12-24 08:21:15', '2016-12-24 08:21:16', '::1', 'user', 'email@gmail.com', '$2y$10$nv7gPk250AfViNhtG8yq9OtvhwnKyvEgqp9xw0DD/t8oSStnGb34.', '0e9aef6ccdbbea75961a7fb690c5889e5668cd5ef73387fd6ec7e1e99d5dd005', 'b88a5bfec6b6df84b3cefd03142808d5649d77c72b948d1bb5f23e324e9a6b5f', 1, 0, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `sales_summary`
--
ALTER TABLE `sales_summary`
  ADD PRIMARY KEY (`sale_id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_history`
--
ALTER TABLE `customer_history`
  MODIFY `chistory_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_history`
--
ALTER TABLE `product_history`
  MODIFY `phistory_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sales_summary`
--
ALTER TABLE `sales_summary`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
