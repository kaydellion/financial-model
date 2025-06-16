-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 31, 2025 at 03:13 PM
-- Server version: 10.5.29-MariaDB
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectr_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `pr_order_items`
--

CREATE TABLE `pr_order_items` (
  `s` int(20) NOT NULL,
  `report_id` varchar(200) NOT NULL,
  `item_id` int(20) NOT NULL,
  `price` int(20) NOT NULL DEFAULT 0,
  `original_price` int(20) NOT NULL,
  `loyalty_id` int(20) NOT NULL,
  `affiliate_id` varchar(200) NOT NULL,
  `order_id` varchar(500) NOT NULL,
  `date` varchar(600) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pr_order_items`
--

INSERT INTO `pr_order_items` (`s`, `report_id`, `item_id`, `price`, `original_price`, `loyalty_id`, `affiliate_id`, `order_id`, `date`) VALUES
(92, 'PH339317', 77, 100, 100, 0, '0', 'ORD682e4a176a390', '2025-05-21 22:48:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pr_order_items`
--
ALTER TABLE `pr_order_items`
  ADD PRIMARY KEY (`s`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pr_order_items`
--
ALTER TABLE `pr_order_items`
  MODIFY `s` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
