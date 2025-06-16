-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2025 at 04:26 AM
-- Server version: 10.5.29-MariaDB
-- PHP Version: 8.3.20

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
-- Table structure for table `pr_users`
--

CREATE TABLE `pr_users` (
  `s` int(20) NOT NULL,
  `display_name` varchar(200) NOT NULL,
  `first_name` varchar(600) NOT NULL,
  `middle_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `profile_picture` varchar(200) NOT NULL DEFAULT 'user.png',
  `mobile_number` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` varchar(4000) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `last_login` varchar(500) NOT NULL,
  `created_date` varchar(200) NOT NULL,
  `preference` varchar(200) NOT NULL,
  `bank_name` varchar(500) NOT NULL,
  `bank_accname` varchar(500) NOT NULL,
  `bank_number` int(20) DEFAULT NULL,
  `loyalty` int(20) DEFAULT 0,
  `wallet` int(20) NOT NULL DEFAULT 0,
  `affliate` varchar(200) NOT NULL DEFAULT '',
  `seller` int(20) NOT NULL DEFAULT 0,
  `facebook` varchar(500) NOT NULL,
  `twitter` varchar(500) NOT NULL,
  `instagram` varchar(500) NOT NULL,
  `linkedln` varchar(500) NOT NULL,
  `kin_name` varchar(500) NOT NULL,
  `kin_number` varchar(200) NOT NULL,
  `kin_email` varchar(500) NOT NULL,
  `biography` varchar(5000) NOT NULL,
  `kin_relationship` varchar(200) NOT NULL,
  `downloads` varchar(450) NOT NULL,
  `reset_token` varchar(450) NOT NULL,
  `reset_token_expiry` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pr_users`
--

INSERT INTO `pr_users` (`s`, `display_name`, `first_name`, `middle_name`, `last_name`, `profile_picture`, `mobile_number`, `email`, `password`, `gender`, `address`, `type`, `status`, `last_login`, `created_date`, `preference`, `bank_name`, `bank_accname`, `bank_number`, `loyalty`, `wallet`, `affliate`, `seller`, `facebook`, `twitter`, `instagram`, `linkedln`, `kin_name`, `kin_number`, `kin_email`, `biography`, `kin_relationship`, `downloads`, `reset_token`, `reset_token_expiry`) VALUES
(5, 'ProjectHub', 'Project', '', 'Hub', '67fd76aa1457c.png', '', 'hello@projectreporthub.ng', '$2y$10$hofxCh0hO8xcFSOBIx9IvOQ.uvSeENF939nF7iF4PZU4a4yQoC1eG', '', '', 'admin', 'active', '2025-05-26 19:29:45', '', '', '', '', NULL, 0, 53809, '0', 0, '', '', '', '', '', '', '', '', '', '', 'be6aeafcb576a79d94da8c4cc0946ac9350c1dfb33dda1f9c0f5911bf1c59910', '2025-05-01 09:18:19'),
(34, 'ikedike2002', 'Ikechukwu', 'Nnamdi', 'Anaekwe', '682e49cc5ebe2.jpg', '08033782777', 'ikedike2002@yahoo.com', '$2y$10$YtKzSBys2HLxLl5hnnvLfuqM1PbHca5AHOEohn2WQyTjQgW1/y2mm', 'Male', '61-65 Egbe- Isolo Road, Iyana Ejigbo Shopping Arcade, Block A, Suite 19, Iyana Ejigbo Bus Stop, Ejigbo, Lagos.', 'sub-admin', 'active', '2025-05-23 17:00:03', '2025-05-21 22:46:52', '', 'Opay', 'Anaekwe Everistus Nnamdi', 2147483647, 0, 0, '0', 1, '', '', '', '', 'Nnamdi', '08033782777', 'ikedike2002@yahoo.com', 'I am freelancer', '', '0', '', ''),
(35, 'Foraminifera Ventures', 'Anaekwe', 'Everistus Nnamdi', 'Ikechukwu', '6830a152119eb.png', '08033782777', 'six33fourng@gmail.com', '$2y$10$cuVhYvP5ALu/3AiDUINtBeicApF39Vn03wY67FKVMajK2b59D0Bdm', 'Male', '10 Wale Ariwo-Ola St, Graceland Estate, Bucknor, Ejigbo, Lagos 102214, Lagos, Nigeria', 'user', 'active', '2025-05-23 17:26:04', '2025-05-23 17:24:50', '', 'gt bank', 'Anaekwe Everistus Nnamdi Ikechukwu', 1234567890, 0, 0, '0', 1, 'https://www.projectreporthub.ng/signup', 'https://www.projectreporthub.ng/signup', 'https://www.projectreporthub.ng/', 'https://www.projectreporthub.ng/', 'Anaekwe Ikechukwu', '08033782777', 'ikedike2002@yahoo.com', 'It is me', '', '0', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pr_users`
--
ALTER TABLE `pr_users`
  ADD PRIMARY KEY (`s`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pr_users`
--
ALTER TABLE `pr_users`
  MODIFY `s` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
