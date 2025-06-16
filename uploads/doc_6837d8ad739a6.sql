-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2025 at 02:33 AM
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
-- Table structure for table `pr_categories`
--

CREATE TABLE `pr_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pr_categories`
--

INSERT INTO `pr_categories` (`id`, `parent_id`, `category_name`, `slug`) VALUES
(1, NULL, 'Administrations', 'administrations'),
(2, NULL, 'Agriculture', 'agriculture'),
(3, NULL, 'Arts', 'arts'),
(4, NULL, 'Biological Sciences', 'biological-sciences'),
(5, NULL, 'Dentistry', 'dentistry'),
(6, NULL, 'Education', 'education'),
(7, NULL, 'Engineering', 'engineering'),
(8, NULL, 'Environmental Sciences', 'environmental-sciences'),
(9, NULL, 'Health Sciences  & Technology', 'health-sciences-technology'),
(10, NULL, 'Law', 'law'),
(11, NULL, 'Medical Sciences', 'medical-sciences'),
(12, NULL, 'Pharmaceutical Sciences', 'pharmaceutical-sciences'),
(13, NULL, 'Physical Sciences', 'physical-sciences'),
(14, NULL, 'Social Sciences', 'social-sciences'),
(15, NULL, 'Veterinary Medicine', 'veterinary-medicine'),
(16, 1, 'Accountancy', 'accountancy'),
(17, 1, 'Actuarial Science', 'actuarial-science'),
(18, 1, 'Business Administration', 'business-administration'),
(19, 1, 'Business Management', 'business-management'),
(20, 1, 'Banking & Finance', 'banking-finance'),
(21, 1, 'Hospitality & Tourism', 'hospitality-tourism'),
(22, 1, 'Marketing', 'marketing'),
(23, 1, 'Insurance', 'insurance'),
(24, 1, 'Industrial Relations & Personnel Management', 'industrial-relations-personnel-management'),
(25, 1, 'Office Technology & Management', 'office-technology-management'),
(26, 1, 'Entrepreneurship', 'entrepreneurship'),
(27, 2, 'Agricultural Economics', 'agricultural-economics'),
(28, 2, 'Soil Science', 'soil-science'),
(29, 2, 'Agricultural Extension', 'agricultural-extension'),
(30, 2, 'Agronomy', 'agronomy'),
(31, 2, 'Animal Science', 'animal-science'),
(32, 2, 'Crop Science', 'crop-science'),
(33, 2, 'Food Science & Technology', 'food-science-technology'),
(34, 2, 'Fisheries', 'fisheries'),
(35, 2, 'Forest Resources Management (forestry)', 'forest-resources-management-forestry-'),
(36, 2, 'Home Science, Nutrition & Dietetics', 'home-science-nutrition-dietetics'),
(37, 3, 'Music', 'music'),
(38, 3, 'Arabic & Islamic Studies', 'arabic-islamic-studies'),
(39, 3, 'Archeology', 'archeology'),
(40, 3, 'Christian Religious Studies', 'christian-religious-studies'),
(41, 3, 'English & Literary Studies', 'english-literary-studies'),
(42, 3, 'Fine & Applied Arts (creative Arts)', 'fine-applied-arts-creative-arts-'),
(43, 3, 'Foreign Languages & Literature', 'foreign-languages-literature'),
(44, 3, 'History & International Studies', 'history-international-studies'),
(45, 3, 'Linguistics & Nigerian Languages', 'linguistics-nigerian-languages'),
(46, 3, 'Mass Communication (communication & Language Arts)', 'mass-communication-communication-language-arts-'),
(47, 3, 'Theatre & Film Studies', 'theatre-film-studies'),
(71, 3, 'Archeology & Tourism', 'archeology-tourism'),
(80, 4, 'Biochemistry', 'biochemistry'),
(81, 4, 'Botany', 'botany'),
(82, 4, 'Microbiology', 'microbiology'),
(83, 4, 'Marine Biology', 'marine-biology'),
(84, 4, 'Cell Biology & Genetics', 'cell-biology-genetics'),
(85, 4, 'Zoology', 'zoology'),
(86, 5, 'Child Dental Health', 'child-dental-health'),
(87, 5, 'Preventive Dentistry', 'preventive-dentistry'),
(88, 5, 'Restorative Dentistry', 'restorative-dentistry'),
(89, 5, 'Oral & Maxillofacial Surgery', 'oral-maxillofacial-surgery'),
(90, 6, 'Education & Social Science', 'education-social-science'),
(91, 6, 'Adult Education & Extra-Mural Studies', 'adult-education-extra-mural-studies'),
(92, 6, 'Arts Education', 'arts-education'),
(93, 6, 'Education & Accountancy', 'education-accountancy'),
(94, 6, 'Education & Computer Science', 'education-computer-science'),
(95, 6, 'Education & Economics', 'education-economics'),
(96, 6, 'Education & Mathematics', 'education-mathematics'),
(97, 6, 'Education & Physics', 'education-physics'),
(98, 6, 'Education & Religious Studies', 'education-religious-studies'),
(99, 6, 'Education & Biology', 'education-biology'),
(100, 6, 'Education & Chemistry', 'education-chemistry'),
(101, 6, 'Education & English Language', 'education-english-language'),
(102, 6, 'Education & French', 'education-french'),
(103, 6, 'Education & Geography/Physics', 'education-geography-physics'),
(104, 6, 'Education & Political Science', 'education-political-science'),
(105, 6, 'Educational Foundations', 'educational-foundations'),
(106, 6, 'Educational / Psychology Guidance & Counselling', 'educational-psychology-guidance-counselling'),
(107, 6, 'Health & Physical Education', 'health-physical-education'),
(108, 6, 'Library & Information Science', 'library-information-science'),
(109, 6, 'Science Education', 'science-education'),
(110, 6, 'Social Sciences Education', 'social-sciences-education'),
(111, 6, 'Vocational Teacher Education (Technical Education)', 'vocational-teacher-education-technical-education-'),
(112, 6, 'Religion', 'religion'),
(113, 6, 'Igbo Linguistics', 'igbo-linguistics'),
(114, 6, 'Educational Management', 'educational-management'),
(115, 7, 'Civil Engineering', 'civil-engineering'),
(116, 7, 'Agricultural & Bioresources Engineering', 'agricultural-bioresources-engineering'),
(117, 7, 'Chemical Engineering', 'chemical-engineering'),
(118, 7, 'Computer Engineering', 'computer-engineering'),
(119, 7, 'Electrical Engineering', 'electrical-engineering'),
(120, 7, 'Electronic Engineering', 'electronic-engineering'),
(121, 7, 'Marine Engineering', 'marine-engineering'),
(122, 7, 'Mechanical Engineering', 'mechanical-engineering'),
(123, 7, 'Metallurgical & Materials Engineering', 'metallurgical-materials-engineering'),
(124, 7, 'Petroleum & Gas Engineering', 'petroleum-gas-engineering'),
(125, 7, 'Systems Engineering', 'systems-engineering'),
(126, 7, 'Structural Engineering', 'structural-engineering'),
(127, 7, 'Production & Industrial Engineering', 'production-industrial-engineering'),
(128, 8, 'Architecture', 'architecture'),
(129, 8, 'Estate Management', 'estate-management'),
(130, 8, 'Quantity Surveying', 'quantity-surveying'),
(131, 8, 'Building', 'building'),
(132, 8, 'Geoinformatics & Surveying', 'geoinformatics-surveying'),
(133, 8, 'Urban & Regional Planning', 'urban-regional-planning'),
(134, 9, 'Nursing Sciences', 'nursing-sciences'),
(135, 9, 'Health Administration & Management', 'health-administration-management'),
(136, 9, 'Medical Laboratory Sciences', 'medical-laboratory-sciences'),
(137, 9, 'Medical Radiography & Radiological Sciences', 'medical-radiography-radiological-sciences'),
(138, 9, 'Medical Rehabilitation', 'medical-rehabilitation'),
(139, 10, 'Commercial & Property Law', 'commercial-property-law'),
(140, 10, 'International & Jurisprudence', 'international-jurisprudence'),
(141, 10, 'Private & Public Law', 'private-public-law'),
(142, 10, 'Paralegal', 'paralegal'),
(143, 11, 'Anatomy', 'anatomy'),
(144, 11, 'Anesthesia', 'anesthesia'),
(145, 11, 'Chemical Pathology', 'chemical-pathology'),
(146, 11, 'Community Medicine', 'community-medicine'),
(147, 11, 'Dermatology', 'dermatology'),
(148, 11, 'Hematology & Immunology', 'hematology-immunology'),
(149, 11, 'Medical Biochemistry', 'medical-biochemistry'),
(150, 11, 'Medical Microbiology', 'medical-microbiology'),
(151, 11, 'Medicine', 'medicine'),
(152, 11, 'Morbid Anatomy', 'morbid-anatomy'),
(153, 11, 'Obstetrics & Gynecology', 'obstetrics-gynecology'),
(154, 11, 'Ophthalmology', 'ophthalmology'),
(155, 11, 'Otolaryngology', 'otolaryngology'),
(156, 11, 'Pediatrics', 'pediatrics'),
(157, 11, 'Pharmacology & Therapeutics', 'pharmacology-therapeutics'),
(158, 11, 'Physiology', 'physiology'),
(159, 11, 'Radiation Medicine', 'radiation-medicine'),
(160, 11, 'Surgery', 'surgery'),
(161, 11, 'Psychological Medicine', 'psychological-medicine'),
(162, 11, 'Child Dental Health', 'child-dental-health-1'),
(163, 12, 'Pharmacognosy', 'pharmacognosy'),
(164, 12, 'Clinical Pharmacy & Pharmacy Management', 'clinical-pharmacy-pharmacy-management'),
(165, 12, 'Pharmaceutical Chemistry & Industrial Pharmacy', 'pharmaceutical-chemistry-industrial-pharmacy'),
(166, 12, 'Pharmaceutical Technology & Industrial Pharmacy', 'pharmaceutical-technology-industrial-pharmacy'),
(167, 12, 'Pharmaceutics', 'pharmaceutics'),
(168, 12, 'Pharmacology & Toxicology', 'pharmacology-toxicology'),
(169, 13, 'Computer Science', 'computer-science'),
(170, 13, 'Mathematics', 'mathematics'),
(171, 13, 'Geology', 'geology'),
(172, 13, 'Physics & Astronomy', 'physics-astronomy'),
(173, 13, 'Geophysics', 'geophysics'),
(174, 13, 'Pure & Industrial Chemistry', 'pure-industrial-chemistry'),
(175, 13, 'Statistics', 'statistics'),
(176, 14, 'Economics', 'economics'),
(177, 14, 'Geography', 'geography'),
(178, 14, 'Philosophy', 'philosophy'),
(179, 14, 'Political Science', 'political-science'),
(180, 14, 'Psychology', 'psychology'),
(181, 14, 'Public Administration & Local Government', 'public-administration-local-government'),
(182, 14, 'Religion', 'religion-1'),
(183, 14, 'Social Work & Development', 'social-work-development'),
(184, 14, 'Sociology/anthropology', 'sociology-anthropology'),
(185, 14, 'CrimInology & Security Studies', 'criminology-security-studies'),
(186, 15, 'Veterinary Anatomy', 'veterinary-anatomy'),
(187, 15, 'Animal Health & Production', 'animal-health-production'),
(188, 15, 'Veterinary Physiology/pharmacology', 'veterinary-physiology-pharmacology'),
(189, 15, 'Veterinary Parasitology & Entomology', 'veterinary-parasitology-entomology'),
(190, 15, 'Veterinary Pathology & Microbiology', 'veterinary-pathology-microbiology'),
(191, 15, 'Veterinary Public Health & Preventive Medicine', 'veterinary-public-health-preventive-medicine'),
(192, 15, 'Veterinary Surgery', 'veterinary-surgery'),
(193, 15, 'Veterinary Medicine', 'veterinary-medicine-1'),
(194, 15, 'Veterinary Obstetrics & Reproductive Diseases', 'veterinary-obstetrics-reproductive-diseases'),
(195, 15, 'Veterinary Teaching Hospital', 'veterinary-teaching-hospital'),
(198, 11, 'Nursing & Midwifery', 'nursing-midwifery'),
(199, 2, 'Agricultural Education', 'agricultural-education'),
(200, 2, 'Agricultural Engineering', 'agricultural-engineering'),
(201, 2, 'Agricultural Science', 'agricultural-science'),
(202, 2, 'Animal Production', 'animal-production'),
(203, 2, 'Crop Production', 'crop-production'),
(204, 2, 'Water Resources Management & Agrometerorology', 'water-resources-management-agrometerorology'),
(205, 7, 'Automobile Engineering', 'automobile-engineering'),
(206, 7, 'Biomedical Engineering', 'biomedical-engineering'),
(207, 7, 'Engineering Physics', 'engineering-physics'),
(208, 7, 'Food Science and Engineering', 'food-science-and-engineering'),
(209, 7, 'Information Communication Engineering', 'information-communication-engineering'),
(210, 7, 'Mechatronics Engineering', 'mechatronics-engineering'),
(211, 7, 'Water Resources & Environmental Engineering', 'water-resources-environmental-engineering'),
(212, 7, 'Software Engineering', 'software-engineering'),
(213, 10, 'Law', 'law-1'),
(214, 10, 'Civil Law', 'civil-law'),
(215, 10, 'Sharia & Islamic Law', 'sharia-islamic-law'),
(216, 6, 'Agricultural Education', 'agricultural-education-1'),
(217, 6, 'Business Education', 'business-education'),
(218, 6, 'Early Childhood Education', 'early-childhood-education'),
(219, 6, 'Education & Arabic', 'education-arabic'),
(220, 6, 'Education & Business Administration', 'education-business-administration'),
(221, 6, 'Education & Christian Religious Studies', 'education-christian-religious-studies'),
(222, 6, 'Education & Fine Art', 'education-fine-art'),
(223, 6, 'Education & Geography', 'education-geography'),
(224, 6, 'Education & History', 'education-history'),
(225, 6, 'Education & Integrated Science', 'education-integrated-science'),
(226, 6, 'Education & Introductory Technology', 'education-introductory-technology'),
(227, 6, 'Education & Islamic Studies', 'education-islamic-studies'),
(228, 6, 'Education & Music', 'education-music'),
(229, 6, 'Environmental Education', 'environmental-education'),
(230, 6, 'Special Education', 'special-education'),
(231, 3, 'Igbo', 'igbo'),
(232, 3, 'Hausa', 'hausa'),
(233, 3, 'Yoruba', 'yoruba'),
(234, 3, 'French', 'french'),
(235, 3, 'Communication Arts', 'communication-arts'),
(236, 3, 'Media & Communication Studies', 'media-communication-studies'),
(237, 14, 'Curriculum Studies', 'curriculum-studies'),
(238, 14, 'Demography & Social Statistics', 'demography-social-statistics'),
(239, 14, 'Home Economics', 'home-economics'),
(240, 1, 'Human Resource Management', 'human-resource-management'),
(241, 14, 'Peace & Conflict Resolution', 'peace-conflict-resolution'),
(242, 1, 'Project Management', 'project-management'),
(243, 1, 'Taxation', 'taxation'),
(244, 3, 'Tourism Studies', 'tourism-studies'),
(245, 13, 'Urban and Regional Planning', 'urban-and-regional-planning'),
(246, 13, 'Management Information System', 'management-information-system'),
(247, 13, 'Cyber security Science', 'cyber-security-science'),
(248, 13, 'Building Technology', 'building-technology'),
(249, 13, 'Estate Management', 'estate-management-1'),
(250, 13, 'Human Nutrition & Dietetics', 'human-nutrition-dietetics'),
(251, 13, 'Architecture', 'architecture-1'),
(252, 4, 'Bio-Informatics', 'bio-informatics'),
(253, 13, 'Biology', 'biology'),
(254, 13, 'Chemistry', 'chemistry'),
(255, 13, 'Geography', 'geography-1'),
(256, 13, 'Library & Information Science', 'library-information-science-1'),
(257, 13, 'Information Systems & Technology', 'information-systems-technology'),
(258, 13, 'Information Resource Management', 'information-resource-management');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pr_categories`
--
ALTER TABLE `pr_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pr_categories`
--
ALTER TABLE `pr_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pr_categories`
--
ALTER TABLE `pr_categories`
  ADD CONSTRAINT `pr_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `pr_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
