-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2025 at 12:12 PM
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
-- Table structure for table `pr_manual_payments`
--

CREATE TABLE `pr_manual_payments` (
  `s` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(45) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `amount` int(11) NOT NULL,
  `proof` varchar(4500) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date_created` varchar(45) NOT NULL,
  `rejection_reason` varchar(4500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pr_manual_payments`
--
ALTER TABLE `pr_manual_payments`
  ADD PRIMARY KEY (`s`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pr_manual_payments`
--
ALTER TABLE `pr_manual_payments`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
