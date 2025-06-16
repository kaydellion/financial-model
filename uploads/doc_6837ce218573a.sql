-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2025 at 01:04 AM
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
-- Table structure for table `pr_reports_files`
--

CREATE TABLE `pr_reports_files` (
  `id` int(20) NOT NULL,
  `report_id` varchar(200) NOT NULL,
  `title` varchar(500) NOT NULL,
  `pages` int(20) NOT NULL DEFAULT 20,
  `updated_at` varchar(200) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pr_reports_files`
--

INSERT INTO `pr_reports_files` (`id`, `report_id`, `title`, `pages`, `updated_at`) VALUES
(77, 'PH339317', '682e4809d00a7.docx', 28, '2025-05-21 22:39:21'),
(78, 'PH037292', '682ee4df51c10.docx', 49, '2025-05-22 09:48:31'),
(79, 'PH475464', '682eea6182fa9.docx', 50, '2025-05-22 10:12:01'),
(80, 'PH023238', '682eefd9044be.docx', 109, '2025-05-22 10:35:21'),
(81, 'PH283496', '682efd2e4ac01.docx', 58, '2025-05-22 11:32:14'),
(82, 'PH453649', '682f00ab55be7.doc', 73, '2025-05-22 11:47:07'),
(83, 'PH713380', '682f9ea3b5e36.docx', 88, '2025-05-22 23:01:07'),
(84, 'PH275412', '68303888ae49b.docx', 53, '2025-05-23 09:57:44'),
(85, 'PH898603', '68305da29d192.docx', 22, '2025-05-23 12:36:02'),
(86, 'PH052890', '683437ffe67ba.docx', 58, '2025-05-26 10:44:31'),
(87, 'PH641629', '683466f5a5321.docx', 58, '2025-05-26 14:04:53'),
(88, 'PH083293', '6834bad1035ba.docx', 57, '2025-05-26 20:02:41'),
(89, 'PH664832', '68358a8f6cc95.docx', 47, '2025-05-27 10:49:03'),
(90, 'PH751185', '68359e1106de6.docx', 35, '2025-05-27 12:12:17'),
(91, 'PH891845', '6835dda41f3f0.docx', 23, '2025-05-27 16:43:32'),
(92, 'PH383291', '6835e9f54e99d.docx', 15, '2025-05-27 17:36:05'),
(93, 'PH747666', '6836437309c7a.docx', 57, '2025-05-27 23:57:55'),
(94, 'PH341135', '68364f5a75b8f.docx', 47, '2025-05-28 00:48:42'),
(95, 'PH794204', '6836ce2ad80ae.docx', 47, '2025-05-28 09:49:46'),
(96, 'PH056002', '6836dceea582b.docx', 48, '2025-05-28 10:52:46'),
(97, 'PH752715', '6837103d37773.docx', 47, '2025-05-28 14:31:41'),
(98, 'PH615576', '68372cb8a5dba.docx', 47, '2025-05-28 16:33:12'),
(99, 'PH690286', '68373d87cc88a.docx', 34, '2025-05-28 17:44:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pr_reports_files`
--
ALTER TABLE `pr_reports_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pr_reports_files`
--
ALTER TABLE `pr_reports_files`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
