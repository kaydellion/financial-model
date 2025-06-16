-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 16, 2025 at 10:00 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `financial_model`
--

-- --------------------------------------------------------

--
-- Table structure for table `fm_affiliate_products`
--

DROP TABLE IF EXISTS `fm_affiliate_products`;
CREATE TABLE IF NOT EXISTS `fm_affiliate_products` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(450) NOT NULL,
  `product_id` varchar(4500) NOT NULL,
  `affiliate_link` varchar(450) NOT NULL,
  `affiliate_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_affiliate_products`
--

INSERT INTO `fm_affiliate_products` (`id`, `user_id`, `product_id`, `affiliate_link`, `affiliate_id`) VALUES
(1, '44', 'PH936003', 'http://text/financial-model/product?slug=finance-impact&affiliate=QUZGLUVGMDU4Mjc0RUUyQQ==', 'AFF-EF058274EE2A'),
(2, '44', 'PH868524', 'http://text/financial-model/product?slug=how-to-be-a-good-caterer&affiliate=QUZGLUVGMDU4Mjc0RUUyQQ==', 'AFF-EF058274EE2A');

-- --------------------------------------------------------

--
-- Table structure for table `fm_affliate_purchases`
--

DROP TABLE IF EXISTS `fm_affliate_purchases`;
CREATE TABLE IF NOT EXISTS `fm_affliate_purchases` (
  `s` int NOT NULL AUTO_INCREMENT,
  `order_no` int NOT NULL,
  `amount` int NOT NULL,
  `affiliate` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_affliate_purchases`
--

INSERT INTO `fm_affliate_purchases` (`s`, `order_no`, `amount`, `affiliate`, `date`) VALUES
(1, 25, 540, 'AFF-EF058274EE2A', '2025-06-11 05:28:41'),
(2, 27, 2940, 'AFF-EF058274EE2A', '2025-06-11 05:39:27'),
(3, 26, 540, 'AFF-EF058274EE2A', '2025-06-11 05:39:24'),
(4, 28, 2940, 'AFF-EF058274EE2A', '2025-06-11 05:49:55'),
(5, 29, 2940, 'AFF-EF058274EE2A', '2025-06-11 09:09:23'),
(6, 30, 540, 'AFF-EF058274EE2A', '2025-06-12 05:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `fm_aff_alerts`
--

DROP TABLE IF EXISTS `fm_aff_alerts`;
CREATE TABLE IF NOT EXISTS `fm_aff_alerts` (
  `s` int NOT NULL AUTO_INCREMENT,
  `message` varchar(5000) NOT NULL,
  `user` varchar(200) NOT NULL,
  `link` varchar(5000) NOT NULL,
  `date` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_aff_alerts`
--

INSERT INTO `fm_aff_alerts` (`s`, `message`, `user`, `link`, `date`, `type`, `status`) VALUES
(1, 'You have earned ?2940 from Order ID: ORD684904ac23d06', '44', 'wallet.php', '2025-06-11 05:39:27', 'wallet', 1),
(2, 'You have earned ?540 from Order ID: ORD684904ac23d06', '44', 'wallet.php', '2025-06-11 05:39:24', 'wallet', 1),
(3, 'You have earned ?2940 from Order ID: ORD68490adfb31fc', '44', 'wallet.php', '2025-06-11 09:09:23', 'wallet', 0),
(4, 'You have earned ?540 from Order ID: ORD68490adfb31fc', '44', 'wallet.php', '2025-06-12 05:13:15', 'wallet', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fm_alerts`
--

DROP TABLE IF EXISTS `fm_alerts`;
CREATE TABLE IF NOT EXISTS `fm_alerts` (
  `s` int NOT NULL AUTO_INCREMENT,
  `message` varchar(5000) NOT NULL,
  `link` varchar(5000) NOT NULL,
  `date` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_alerts`
--

INSERT INTO `fm_alerts` (`s`, `message`, `link`, `date`, `type`, `status`) VALUES
(1, 'A new user has been registered( Fopefoluwa)', 'users.php', '2025-05-23 04:06:57', 'New User', 1),
(2, 'A new user has been registered(ola)', 'users.php', '2025-05-23 09:19:11', 'New User', 1),
(3, 'A new user has been registered(ola)', 'users.php', '2025-05-23 10:00:57', 'New User', 1),
(4, 'A new user has been registered( Fopefoluwa)', 'users.php', '2025-05-28 13:32:24', 'New User', 1),
(5, 'A new user has been registered( Fopefoluwa)', 'users.php', '2025-05-28 14:21:45', 'New User', 1),
(6, 'A new user has been registered( Fopefoluwa)', 'users.php', '2025-05-28 20:09:19', 'New User', 1),
(7, 'A new user has been registered(tonik)', 'users.php', '2025-05-28 20:27:09', 'New User', 1),
(8, 'A new user has been registered(tonik)', 'users.php', '2025-05-29 20:03:29', 'New User', 1),
(9, 'A new user has been registered( Fopefoluwa)', 'users.php', '2025-05-29 20:23:49', 'New User', 1),
(10, 'Admin Commission of ?10000 from Subscription Plan', 'profits.php', '', 'profits', 1),
(11, 'Admin Commission of ?1500 from Order ID: ORD683bf49ddee91', 'profits.php', '2025-06-01 10:06:01', 'profits', 1),
(12, 'Admin Commission of ?3000 from Order ID: ORD683c708b21305', 'profits.php', '2025-06-04 16:37:52', 'profits', 1),
(13, 'Admin Commission of ?375 from Order ID: ORD6840738ecdeb8', 'profits.php', '2025-06-04 17:29:52', 'profits', 1),
(14, 'Admin Commission of ?6000 from Order ID: ORD6840738ecdeb8', 'profits.php', '2025-06-04 17:29:10', 'profits', 1),
(15, 'A new dispute has been submitted (TKT1749483913)', 'ticket.php?ticket_number=TKT1749483913', '2025-06-09 16:45:13', 'New Dispute', 1),
(16, 'Admin Commission of ?4000 from Order ID: ORD6845970c566fb', 'profits.php', '2025-06-09 16:26:14', 'profits', 1),
(17, 'Admin Commission of ?375 from Order ID: ORD6840767a0e07a', 'profits.php', '2025-06-10 08:42:25', 'profits', 1),
(18, 'Admin Commission of ?6750 from Order ID: ORD6840767a0e07a', 'profits.php', '2025-06-10 08:42:25', 'profits', 1),
(19, 'Admin Commission of ?375 from Order ID: ORD6840767a0e07a', 'profits.php', '2025-06-10 08:56:19', 'profits', 1),
(20, 'Admin Commission of ?6750 from Order ID: ORD6840767a0e07a', 'profits.php', '2025-06-10 08:56:19', 'profits', 1),
(21, 'Admin Commission of ?6750 from Order ID: ORD68470455a3b69', 'profits.php', '2025-06-10 21:26:42', 'profits', 1),
(22, '44', 'You have earned ?540 from Order ID: ORD6849035616a21', 'wallet.php', '2025-06-11 05:28:41', 1),
(23, 'Admin Commission of ?6750 from Order ID: ORD6849035616a21', 'profits.php', '2025-06-11 05:28:41', 'profits', 1),
(24, 'Admin Commission of ?36750 from Order ID: ORD684904ac23d06', 'profits.php', '2025-06-11 05:39:27', 'profits', 1),
(25, 'Admin Commission of ?6750 from Order ID: ORD684904ac23d06', 'profits.php', '2025-06-11 05:39:24', 'profits', 1),
(26, '44', 'You have earned ?2940 from Order ID: ORD68490aba8a582', 'wallet.php', '2025-06-11 05:49:55', 1),
(27, 'Admin Commission of ?36750 from Order ID: ORD68490aba8a582', 'profits.php', '2025-06-11 05:49:55', 'profits', 1),
(28, 'New Withdrawal Request - &#8358;6000', 'withdrawals.php', '2025-06-11 05:53:42', 'New Withdrawal', 1),
(29, 'A new dispute has been submitted (TKT1749738594)', 'ticket.php?ticket_number=TKT1749738594', '2025-06-12 15:29:54', 'New Dispute', 1),
(30, 'Admin Commission of ?36750 from Order ID: ORD68490adfb31fc', 'profits.php', '2025-06-11 09:09:23', 'profits', 1),
(31, 'Admin Commission of ?6750 from Order ID: ORD68490adfb31fc', 'profits.php', '2025-06-12 05:13:15', 'profits', 1),
(32, 'Admin Commission of ?500 from Order ID: ORD68490adfb31fc', 'profits.php', '2025-06-13 18:19:10', 'profits', 1),
(33, 'A new user has been registered(Kunle Ara Pharmacy)', 'users.php', '2025-06-13 18:33:17', 'New User', 1),
(34, 'A new user has been registered(Kunle Ara Pharmacy)', 'users.php', '2025-06-13 18:51:35', 'New User', 1),
(35, 'Admin Commission of ?500 from Order ID: ORD684c65decfb34', 'profits.php', '2025-06-13 18:58:14', 'profits', 1),
(36, 'Admin Commission of ?1200 from Order ID: ORD684c5dfb6863e', 'profits.php', '2025-06-13 19:38:09', 'profits', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fm_categories`
--

DROP TABLE IF EXISTS `fm_categories`;
CREATE TABLE IF NOT EXISTS `fm_categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `category_name` varchar(450) NOT NULL,
  `slug` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_categories`
--

INSERT INTO `fm_categories` (`id`, `parent_id`, `category_name`, `slug`) VALUES
(1, NULL, 'Agriculture', 'agriculture'),
(2, NULL, 'Animals & Pets', 'animals-pets'),
(3, NULL, 'Beauty & Well-being', 'beauty-well-being'),
(4, NULL, 'Childcare & Education', 'childcare-education'),
(5, NULL, 'Cleaning, Repair & Services', 'cleaning-repair-services'),
(6, NULL, 'Construction', 'construction'),
(7, NULL, 'E-Commerce', 'e-commerce'),
(8, NULL, 'Education & Training', 'education-training'),
(9, NULL, 'Electronics & Technology', 'electronics-technology'),
(10, NULL, 'Entertainment & Recreation', 'entertainment-recreation'),
(11, NULL, 'Finance & Professional Services', 'finance-professional-services'),
(12, NULL, 'Food & Beverage', 'food-beverage'),
(13, NULL, 'Franchise', 'franchise'),
(14, NULL, 'Healthcare', 'healthcare'),
(15, NULL, 'Hobbies & Crafts', 'hobbies-crafts'),
(16, NULL, 'Home & Garden', 'home-garden'),
(17, NULL, 'Home Services', 'home-services'),
(18, NULL, 'Hospitality', 'hospitality'),
(19, NULL, 'Legal Services & Government', 'legal-services-government'),
(20, NULL, 'Manufacturing', 'manufacturing'),
(21, NULL, 'Marketing & Consulting Agency', 'marketing-consulting-agency'),
(22, NULL, 'Marketplace', 'marketplace'),
(23, NULL, 'Media & Publishing', 'media-publishing'),
(24, NULL, 'Real Estate', 'real-estate'),
(25, NULL, 'Restaurants & Bars', 'restaurants-bars'),
(26, NULL, 'Retail', 'retail'),
(27, NULL, 'Shopping & Fashion', 'shopping-fashion'),
(28, NULL, 'Sport', 'sport'),
(29, NULL, 'Travel & Vacation', 'travel-vacation'),
(30, NULL, 'Utilities', 'utilities'),
(31, NULL, 'Vehicles & Transportation', 'vehicles-transportation'),
(32, 1, 'Crop Farming', 'crop-farming'),
(33, 1, 'Livestock Farming', 'livestock-farming'),
(34, 1, 'Aquaculture', 'aquaculture'),
(35, 1, 'Agro-Processing', 'agro-processing'),
(36, 1, 'Agribusiness Services', 'agribusiness-services'),
(37, 1, 'Forestry', 'forestry'),
(38, 2, 'Pet Grooming', 'pet-grooming'),
(39, 2, 'Pet Boarding & Daycare', 'pet-boarding-daycare'),
(40, 2, 'Veterinary Services', 'veterinary-services'),
(41, 2, 'Pet Products Manufacturing', 'pet-products-manufacturing'),
(42, 2, 'Animal Breeding', 'animal-breeding'),
(43, 3, 'Beauty Salons & Spas', 'beauty-salons-spas'),
(44, 3, 'Wellness Centers', 'wellness-centers'),
(45, 3, 'Cosmetics & Skincare Products', 'cosmetics-skincare-products'),
(46, 3, 'Fitness & Nutrition Services', 'fitness-nutrition-services'),
(47, 3, 'Personal Care Products', 'personal-care-products'),
(48, 4, 'Daycare Centers', 'daycare-centers'),
(49, 4, 'Early Childhood Education', 'early-childhood-education'),
(50, 4, 'Private Tutoring', 'private-tutoring'),
(51, 4, 'Learning Centers', 'learning-centers'),
(52, 4, 'Educational Products & Toys', 'educational-products-toys'),
(53, 5, 'Home Cleaning Services', 'home-cleaning-services'),
(54, 5, 'Commercial Cleaning', 'commercial-cleaning'),
(55, 5, 'Maintenance & Repair Services', 'maintenance-repair-services'),
(56, 5, 'Handyman Services', 'handyman-services'),
(57, 5, 'Laundry & Dry Cleaning', 'laundry-dry-cleaning'),
(58, 6, 'Residential Construction', 'residential-construction'),
(59, 6, 'Commercial Construction', 'commercial-construction'),
(60, 6, 'Construction Materials Supply', 'construction-materials-supply'),
(61, 6, 'Architecture & Design Services', 'architecture-design-services'),
(62, 6, 'Renovation & Remodeling', 'renovation-remodeling'),
(63, 7, 'Online Retail Stores', 'online-retail-stores'),
(64, 7, 'Marketplace Platforms', 'marketplace-platforms'),
(65, 7, 'Dropshipping', 'dropshipping'),
(66, 7, 'Subscription Box Services', 'subscription-box-services'),
(67, 7, 'Digital Product Stores', 'digital-product-stores'),
(68, 8, 'Online Courses', 'online-courses'),
(69, 8, 'Vocational Training', 'vocational-training'),
(70, 8, 'Corporate Training Solutions', 'corporate-training-solutions'),
(71, 8, 'Language Schools', 'language-schools'),
(72, 8, 'Educational Software', 'educational-software'),
(73, 9, 'Consumer Electronics', 'consumer-electronics'),
(74, 9, 'IT Services & Solutions', 'it-services-solutions'),
(75, 9, 'Software Development', 'software-development'),
(76, 9, 'Hardware Manufacturing', 'hardware-manufacturing'),
(77, 9, 'Tech Consulting', 'tech-consulting'),
(78, 10, 'Event Planning & Management', 'event-planning-management'),
(79, 10, 'Sports & Recreation Centers', 'sports-recreation-centers'),
(80, 10, 'Amusement Parks', 'amusement-parks'),
(81, 10, 'Music & Performance Arts', 'music-performance-arts'),
(82, 10, 'Film & Video Production', 'film-video-production'),
(83, 11, 'Accounting & Bookkeeping', 'accounting-bookkeeping'),
(84, 11, 'Financial Planning & Advisory', 'financial-planning-advisory'),
(85, 11, 'Insurance Brokerage', 'insurance-brokerage'),
(86, 11, 'Tax Services', 'tax-services'),
(87, 11, 'Consulting Firms', 'consulting-firms'),
(88, 11, 'Banking', 'banking'),
(89, 12, 'Restaurants & Catering', 'restaurants-catering'),
(90, 12, 'Food Processing & Manufacturing', 'food-processing-manufacturing'),
(91, 12, 'Beverage Production', 'beverage-production'),
(92, 12, 'Food Delivery Services', 'food-delivery-services'),
(93, 12, 'Food Retail', 'food-retail'),
(94, 13, 'Franchise Consulting', 'franchise-consulting'),
(95, 13, 'Franchise Resales', 'franchise-resales'),
(96, 13, 'Franchise Development Services', 'franchise-development-services'),
(97, 13, 'Franchise Financing', 'franchise-financing'),
(98, 13, 'Franchise Opportunities', 'franchise-opportunities'),
(99, 14, 'Hospitals & Clinics', 'hospitals-clinics'),
(100, 14, 'Medical Equipment Supply', 'medical-equipment-supply'),
(101, 14, 'Pharmaceuticals', 'pharmaceuticals'),
(102, 14, 'Telemedicine Services', 'telemedicine-services'),
(103, 14, 'Health & Wellness Coaching', 'health-wellness-coaching'),
(104, 15, 'Arts & Crafts Supplies', 'arts-crafts-supplies'),
(105, 15, 'Hobby Classes & Workshops', 'hobby-classes-workshops'),
(106, 15, 'DIY Products', 'diy-products'),
(107, 15, 'Creative Studios', 'creative-studios'),
(108, 15, 'Craft Retail', 'craft-retail'),
(109, 16, 'Gardening & Landscaping Services', 'gardening-landscaping-services'),
(110, 16, 'Home Improvement', 'home-improvement'),
(111, 16, 'Furniture & Home Decor', 'furniture-home-decor'),
(112, 16, 'Gardening Products', 'gardening-products'),
(113, 16, 'Interior Design', 'interior-design'),
(114, 17, 'Plumbing Services', 'plumbing-services'),
(115, 17, 'Electrical Services', 'electrical-services'),
(116, 17, 'Pest Control', 'pest-control'),
(117, 17, 'HVAC Services', 'hvac-services'),
(118, 17, 'Roofing & Siding', 'roofing-siding'),
(119, 18, 'Hotels & Resorts', 'hotels-resorts'),
(120, 18, 'Vacation Rentals', 'vacation-rentals'),
(121, 18, 'Bed & Breakfast', 'bed-breakfast'),
(122, 18, 'Event Hosting Venues', 'event-hosting-venues'),
(123, 18, 'Hospitality Consulting', 'hospitality-consulting'),
(124, 19, 'Law Firms', 'law-firms'),
(125, 19, 'Legal Consulting', 'legal-consulting'),
(126, 19, 'Government Contracting', 'government-contracting'),
(127, 19, 'Compliance & Regulatory Services', 'compliance-regulatory-services'),
(128, 19, 'Public Administration Consulting', 'public-administration-consulting'),
(129, 20, 'Industrial Production', 'industrial-production'),
(130, 20, 'Consumer Goods Manufacturing', 'consumer-goods-manufacturing'),
(131, 20, 'Food Manufacturing', 'food-manufacturing'),
(132, 20, 'Automotive Manufacturing', 'automotive-manufacturing'),
(133, 20, 'Chemical Manufacturing', 'chemical-manufacturing'),
(134, 21, 'Digital Marketing', 'digital-marketing'),
(135, 21, 'PR & Media Relations', 'pr-media-relations'),
(136, 21, 'Market Research', 'market-research'),
(137, 21, 'Advertising Agencies', 'advertising-agencies'),
(138, 21, 'Business Consulting', 'business-consulting'),
(139, 22, 'B2B Marketplaces', 'b2b-marketplaces'),
(140, 22, 'B2C Marketplaces', 'b2c-marketplaces'),
(141, 22, 'Wholesale Platforms', 'wholesale-platforms'),
(142, 22, 'Niche Marketplaces', 'niche-marketplaces'),
(143, 22, 'Digital Goods Marketplaces', 'digital-goods-marketplaces'),
(144, 23, 'Print & Digital Publishing', 'print-digital-publishing'),
(145, 23, 'Content Creation & Writing', 'content-creation-writing'),
(146, 23, 'Podcast & Broadcasting Services', 'podcast-broadcasting-services'),
(147, 23, 'Media Production Studios', 'media-production-studios'),
(148, 23, 'Advertising Sales', 'advertising-sales'),
(149, 24, 'Residential Real Estate', 'residential-real-estate'),
(150, 24, 'Commercial Real Estate', 'commercial-real-estate'),
(151, 24, 'Real Estate Investment', 'real-estate-investment'),
(152, 24, 'Property Management', 'property-management'),
(153, 24, 'Real Estate Development', 'real-estate-development'),
(154, 25, 'Fine Dining', 'fine-dining'),
(155, 25, 'Fast Food Chains', 'fast-food-chains'),
(156, 25, 'Cafes & Coffee Shops', 'cafes-coffee-shops'),
(157, 25, 'Bars & Nightclubs', 'bars-nightclubs'),
(158, 25, 'Food Trucks', 'food-trucks'),
(159, 26, 'Apparel & Clothing Stores', 'apparel-clothing-stores'),
(160, 26, 'General Retail Stores', 'general-retail-stores'),
(161, 26, 'Specialty Retail', 'specialty-retail'),
(162, 26, 'Department Stores', 'department-stores'),
(163, 26, 'Convenience Stores', 'convenience-stores'),
(164, 27, 'Fashion Design', 'fashion-design'),
(165, 27, 'Apparel Manufacturing', 'apparel-manufacturing'),
(166, 27, 'E-Commerce Fashion', 'e-commerce-fashion'),
(167, 27, 'Retail Boutiques', 'retail-boutiques'),
(168, 27, 'Fashion Accessories', 'fashion-accessories'),
(169, 28, 'Sports Equipment Retail', 'sports-equipment-retail'),
(170, 28, 'Gyms & Fitness Centers', 'gyms-fitness-centers'),
(171, 28, 'Sports Coaching & Training', 'sports-coaching-training'),
(172, 28, 'Sports Event Management', 'sports-event-management'),
(173, 28, 'Team Merchandise Sales', 'team-merchandise-sales'),
(174, 29, 'Travel Agencies', 'travel-agencies'),
(175, 29, 'Tour Operators', 'tour-operators'),
(176, 29, 'Cruise Lines', 'cruise-lines'),
(177, 29, 'Vacation Rental Platforms', 'vacation-rental-platforms'),
(178, 29, 'Adventure Travel Services', 'adventure-travel-services'),
(179, 30, 'Energy Supply (Electricity, Gas)', 'energy-supply-electricity-gas-'),
(180, 30, 'Water Services', 'water-services'),
(181, 30, 'Waste Management', 'waste-management'),
(182, 30, 'Renewable Energy Solutions', 'renewable-energy-solutions'),
(183, 30, 'Utility Consulting Services', 'utility-consulting-services'),
(184, 31, 'Auto Dealerships', 'auto-dealerships'),
(185, 31, 'Car Rentals', 'car-rentals'),
(186, 31, 'Logistics & Freight Services', 'logistics-freight-services'),
(187, 31, 'Public Transportation', 'public-transportation'),
(188, 31, 'Vehicle Maintenance Services', 'vehicle-maintenance-services');

-- --------------------------------------------------------

--
-- Table structure for table `fm_comments`
--

DROP TABLE IF EXISTS `fm_comments`;
CREATE TABLE IF NOT EXISTS `fm_comments` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_id` varchar(45) NOT NULL,
  `comments` varchar(4500) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `commented_time` varchar(45) NOT NULL,
  `parent_comment_id` varchar(45) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_comments`
--

INSERT INTO `fm_comments` (`s`, `blog_id`, `comments`, `user_id`, `commented_time`, `parent_comment_id`) VALUES
(5, '2', 'ok', '5', '2025-06-12 09:42:52', ''),
(11, '2', 'ok', '5', '2025-06-12 14:09:19', '5'),
(12, '2', 'ok', '5', '2025-06-12 14:22:45', '11');

-- --------------------------------------------------------

--
-- Table structure for table `fm_country`
--

DROP TABLE IF EXISTS `fm_country`;
CREATE TABLE IF NOT EXISTS `fm_country` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint DEFAULT NULL,
  `phonecode` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_country`
--

INSERT INTO `fm_country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `fm_disputes`
--

DROP TABLE IF EXISTS `fm_disputes`;
CREATE TABLE IF NOT EXISTS `fm_disputes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `recipient_id` int NOT NULL,
  `ticket_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_reference` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `issue` text COLLATE utf8mb4_general_ci,
  `status` enum('pending','under-review','resolved','awaiting-response') COLLATE utf8mb4_general_ci DEFAULT 'under-review',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_disputes`
--

INSERT INTO `fm_disputes` (`id`, `user_id`, `recipient_id`, `ticket_number`, `category`, `order_reference`, `issue`, `status`, `created_at`) VALUES
(1, 5, 0, 'TKT1749483620', 'Login/Access Problems', 'ORD6840767a0e07a', 'fee', 'under-review', '2025-06-09 15:40:20'),
(2, 5, 0, 'TKT1749483913', 'Login/Access Problems', 'ORD6840767a0e07a', 'fee', 'under-review', '2025-06-09 15:45:13'),
(3, 5, 0, 'TKT1749738594', 'Refund Issues', 'ORD6840767a0e07a', '', 'under-review', '2025-06-12 14:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `fm_dispute_messages`
--

DROP TABLE IF EXISTS `fm_dispute_messages`;
CREATE TABLE IF NOT EXISTS `fm_dispute_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dispute_id` varchar(110) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sender_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `file` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_dispute_messages`
--

INSERT INTO `fm_dispute_messages` (`id`, `dispute_id`, `sender_id`, `message`, `file`, `created_at`) VALUES
(1, 'TKT1749483620', 5, 'fee', '', '2025-06-09 15:40:20'),
(2, 'TKT1749483913', 5, 'fee', '', '2025-06-09 15:45:13'),
(3, 'TKT1749738594', 5, '', '', '2025-06-12 14:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `fm_doc_file`
--

DROP TABLE IF EXISTS `fm_doc_file`;
CREATE TABLE IF NOT EXISTS `fm_doc_file` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_id` varchar(45) NOT NULL,
  `doc_typeid` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` varchar(450) NOT NULL,
  `filename` varchar(450) NOT NULL,
  `uploaded_at` varchar(45) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_doc_file`
--

INSERT INTO `fm_doc_file` (`s`, `report_id`, `doc_typeid`, `price`, `filename`, `uploaded_at`) VALUES
(1, 'PH957958', '13', '', 'doc_6837b36995955.sql', '2025-05-29 02:07:53'),
(2, 'PH036858', '10', '', 'doc_6837ce218573a.sql', '2025-05-29 04:01:53'),
(3, 'PH638104', '4', '', 'doc_6837cefc4d0a6.png', '2025-05-29 04:05:32'),
(4, 'PH865421', '9', '', 'doc_6837d8ad739a6.sql', '2025-05-29 04:46:53'),
(5, 'PH480872', '4', '', 'doc_6837da3a0fa80.sql', '2025-05-29 04:53:30'),
(7, 'PH936003', '4', '', 'doc_683d48ba546a9.pdf', '2025-06-02 07:46:18'),
(9, 'PH571862', '6', '600', 'doc_683edf4c39ceb.png', '2025-06-03 12:41:00'),
(10, 'PH571862', '8', '600', 'doc_683edf4c3cfb7.sql', '2025-06-03 12:41:00'),
(11, 'PH598879', '13', '4000', 'doc_683f1d9b433ff.webp', '2025-06-03 17:06:51'),
(12, 'PH598879', '8', '500', 'doc_683f1d9b44bd4.png', '2025-06-03 17:06:51'),
(13, 'PH868524', '13', '49000', 'doc_68433c38aea64.pdf', '2025-06-07 13:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `fm_evidence`
--

DROP TABLE IF EXISTS `fm_evidence`;
CREATE TABLE IF NOT EXISTS `fm_evidence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dispute_id` int DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_evidence`
--

INSERT INTO `fm_evidence` (`id`, `dispute_id`, `file_path`, `uploaded_at`) VALUES
(1, 2, '684701898042b.png', '2025-06-09 15:45:13'),
(2, 3, '684ae4625c5b4.pdf', '2025-06-12 14:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `fm_followers`
--

DROP TABLE IF EXISTS `fm_followers`;
CREATE TABLE IF NOT EXISTS `fm_followers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `seller_id` varchar(45) NOT NULL,
  `followed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` varchar(450) NOT NULL,
  `subcategory_id` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_followers`
--

INSERT INTO `fm_followers` (`id`, `user_id`, `seller_id`, `followed_at`, `category_id`, `subcategory_id`) VALUES
(2, '5', '5', '2025-06-14 07:21:56', '', ''),
(3, '5', '5', '2025-06-14 07:22:28', '', ''),
(4, '5', '5', '2025-06-14 07:22:40', '', ''),
(6, '5', '46', '2025-06-14 07:39:57', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fm_forum_posts`
--

DROP TABLE IF EXISTS `fm_forum_posts`;
CREATE TABLE IF NOT EXISTS `fm_forum_posts` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `title` varchar(450) NOT NULL,
  `article` mediumtext NOT NULL,
  `categories` varchar(450) NOT NULL,
  `featured_image` varchar(650) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` varchar(45) NOT NULL,
  `views` varchar(45) NOT NULL,
  `slug` varchar(4500) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_forum_posts`
--

INSERT INTO `fm_forum_posts` (`s`, `user_id`, `title`, `article`, `categories`, `featured_image`, `created_at`, `views`, `slug`) VALUES
(1, '9', 'School Report', 'Here are 10 top tips to assist you with school report writing:\\\\r\\\\nEnsure nothing is a total surprise. A parent should not be finding out via the report anything which will come as a total shock – good or bad! If their child has been off task 80% of the time, they shouldn’t be finding out just before the holidays. This doesn’t help them to support changes. The report should build on and confirm the ongoing conversations, adding to the parental engagement which has gone beforehand throughout the year.\\\\r\\\\nKeep it simple. Avoid the jargon and acronyms which abound in education. Add details and simple explanations where necessary. A glossary of terms relevant to the school could even be part of the template. This can be especially helpful if you have your own assessment terms. You may also want to add a quick guide to terms such as “fronted adverbials” also.\\\\r\\\\nBe specific. Statements should be simple, and in layman’s terms, but be based on solid evidence. “Joshua did well this year” is not specific enough. Parents may like to hear such a lovely statement, but it gives them nothing to engage with. They will end up asking Joshua what he did well in… which Joshua may also not be sure of the details.\\\\r\\\\nUse the ‘4 parts’ rule. Each statement in a school report should include 4 elements: the achievement/success; evidence of that success; the target; resources to help meet the target. So, a four-part phrase might be: “Joshua has progressed well in handwriting. He is now joining most of his letters in each word. His next step is to keep the sizing of his handwriting consistent. A great website to help model this is…” All too often we stop after 3 parts: success, evidence, target. This leaves parents stuck when they want to support that target. Directing them to resources that match the school’s curriculum helps the parents.\\\\r\\\\nFollow school guidance. Every school has their own ideas about what should be included. How many words to include, for example, and usually a template. If you’re new to a school but want to get started on reports early, make sure to ask for some examples from last year to get a sense of what is expected. You may think you got the reports done before the holidays, but there is nothing more deflating than finding you need to rewrite them completely.\\\\r\\\\nThere is a place for automation. Teachers may have been stung by old report writing software. It may have messed up genders or come up with some grammatically terrible sentences. Many modern assessment platforms have much more advanced techniques and tools available now. You spend the term and year updating data for the graphs and assessment information. Why not then allow the system to take some of your workload? Your assessment knows exactly where the pupils are, based on your RAG ratings of statements and such. They will output sentences to reports which follow your own school’s curriculum, and it knows who is a girl or a boy! And gets the names right every time. Technology, at its very best, is efficient, which leaves you more time to write the personal statement parts.\\\\r\\\\nAdd resources and links. Again, some systems have a reporting online option. This links parents to resources that are curriculum-linked. This means that for each target they are directed to high-quality resources to use at home. This can turn your school report writing into a significant part of your teaching. Also, your learning and assessment cycle. Parents being involved in their child’s education makes a huge difference. Where you are printing reports, you can add short links. These could be simple recommended resources such as YouTube channels, websites and even apps, which you know are educationally sound.\\\\r\\\\nMake the layout easy to follow. The school template can be important in making sure reports are easy to understand. If there are grades for some subjects and not others, a design change can help to make that seem strange. As with marketing rules, there are ways to bring the parent’s eye to the key information they need to see. At Learning Ladders, we have worked really hard to ensure our reports stand out. They are based on these principles outlined. You may not have control over your school template, but you can ensure sentences are concise and paragraphs are not too long. These make the report much easier to read.\\\\r\\\\nDon’t overdo it. A few key successes and a few targets are great. Make it manageable. A list of 20 successes might seem wonderful but will be very overwhelming. For the core subjects, 3-5 successes and 3 key targets are plenty. For foundation subjects, 3 successes and 1 or 2 things to work on would be perfect.\\\\r\\\\nTreat it like a parent’s evening. When writing the personal part of the report, I like to pretend the parent is in front of me, as though I am saying everything to their face, imagining their reaction. That helps me to be enthusiastic and realistic – which comes across even on the page. This also helps me to write each pupil’s report statement in one go, rather than going back and forth to edit (which is when I am more likely to make mistakes!). I also try to imagine their questions and add a bit of context or answer those upfront, as part of the report.', '1,13', '6849c15122ae7_image25.png', '2025-06-11 16:39:47', '0', 'school-report'),
(2, '9', 'Climate Modelling', 'Climate model data with different scenario data were needed to quantify the relative climate change of meteorological variables between the current and future time from baseline period. Regional climate model, REMO (Jacob and Podzun, 1997) originally developed by the Max Planck Institute of Meteorology (MPI-M) in Hamburg, was used as for this study. The REMO climate model data of 0.5 degree resolution (Fig. 6.2) were selected over the others to take the advantages such as (1) REMO has been used in various different geographical parts of the world for climate change detection and provides better result, (2) it has resulted good fit with observation data for baseline periods for studies carried out in Africa (Haensler et al., 2011), and (3) REMO has relatively higher resolution (i.e., 0.5° by 0.5°) than most of GCM used in the region. Even though the REMO climate model data should be used for all SRES emission scenario to achieve a better understanding of climate change, however, due to the availability of climate model data only the mentioned three SRES scenarios (B1, A1B-LU, and A1B-Nlu) was used in the study.', '1', '6849c134e4a3a_665ac55d44a4ce832f889137c63a42fbdc4db858.png', '2025-06-11 17:34:19', '0', 'climate-modelling'),
(3, '9', 'E-commerce', '1. How to sell on the Internet with an online shop\\\\\\\\r\\\\\\\\nThis article (in Spanish) was written by Miguel Florido, responsible for the Marketing and Web blog. In this guide he explains the 30 most important factors for your e-commerce to start selling from the first day. It is a general list of do’s and don’ts about everything you need to check so that your shop runs perfectly. Read “Cómo vender por Internet con una tienda online”\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n2. My online shop doesn’t sell: 7 possible culprits\\\\\\\\r\\\\\\\\nFranck Scipion is the CEO of Lifestyle al Cuadrado and is one of the most followed entrepreneurship bloggers within the Spanish-speaking community. This post (in Spanish) is a great complement to the previous one because it shows a more precise analysis about what may be happening to your online shop if you are not making sales. Read “Mi tienda online no vende: 7 posibles culpables”\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n3. Absolute value: 5 common beliefs that marketers should rethink\\\\\\\\r\\\\\\\\nThis article is in English and was written in the Bazaar Voice blog. We think it is really interesting since it refutes some “absolute truths” about marketing for e-commerce. Read “Absolute value: 5 common beliefs that marketers should rethink”\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n4. 5 keys to describing products + 3 real examples\\\\\\\\r\\\\\\\\nRosa Morel is a copywriter and tells us how to sell with words in her blog. In this article (in Spanish) she explains how to write a product card . Do not forget that a card’s copywriting can be the trigger that leads a client to clicking the button . Read “5 claves para describir productos + 3 ejemplos reales”\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n5. Mobile E-commerce Copywriting: How to be a welcome addition to your visitors’ mobile experiences\\\\\\\\r\\\\\\\\nJoanna Wiebe is another copywriter and one of the people in charge of the CopyHackers blog. We have selected this article because it deals with a very important topic that is very much on the rise right now: selling through your phone. Had you ever thought about how to write for such a small screen? Read “Mobile Ecommerce Copywriting: How to be a welcome addition to your visitors’ mobile experiences”', '21,22,27', '6849c0f9e6569_seller.png', '2025-06-11 17:49:45', '0', 'e-commerce'),
(5, '9', 'Bank', 'There are basically three levels of debt stress:\\\\r\\\\n\\\\r\\\\nLevel 1 is when you\\\\\\\'re managing things just fine, but you\\\\\\\'d greatly prefer it if you didn\\\\\\\'t have to dedicate so much of your budget to debt payments. Maybe you decide to tough it out. Maybe you decide to change things up with a balance transfer. Nothing major.\\\\r\\\\nLevel 2 is when you\\\\\\\'re actively not okay and you can\\\\\\\'t keep doing things the way you\\\\\\\'ve been doing them. This is the \\\\\\\"talk to a credit counselor and see what your options are\\\\\\\" stage.\\\\r\\\\nLevel 3 is when you\\\\\\\'re genuinely considering whether or not you should move to a cabin in the woods just to get away from all the debt collection calls. It\\\\\\\'s bad bad.\\\\r\\\\nWhen things have gotten Level 3 bad, you may be considering more drastic options, like bankruptcy or debt settlement. These are the options that have some significant drawbacks, especially when it comes to your credit, but once things have gotten this bad you\\\\\\\'re probably past the point of worrying about your credit (or what\\\\\\\'s left of it). \\\\r\\\\n\\\\r\\\\nSettling your debt allows you get out of debt while repaying less than what you owe. When repaying your debts in full just isn\\\\\\\'t possible, it\\\\\\\'s a valid way to clear the deck and let you start rebuilding your finances. That said, not every type of debt can be settled. So if you\\\\\\\'re considering debt settlement, here\\\\\\\'s what you need to know about which debts can (and can\\\\\\\'t) be settled.', '11', '6849c077a3401_Sterling-Bank.jpg', '2025-06-11 18:02:56', '0', 'bank');

-- --------------------------------------------------------

--
-- Table structure for table `fm_guidance`
--

DROP TABLE IF EXISTS `fm_guidance`;
CREATE TABLE IF NOT EXISTS `fm_guidance` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_id` varchar(45) NOT NULL,
  `video_filename` varchar(450) NOT NULL,
  `uploaded_at` varchar(45) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_guidance`
--

INSERT INTO `fm_guidance` (`s`, `report_id`, `video_filename`, `uploaded_at`) VALUES
(1, 'PH036858', 'video_6837ce2183792.mp4', '2025-05-29 04:01:53'),
(2, 'PH638104', 'video_6837cefc4bc97.mov', '2025-05-29 04:05:32'),
(4, 'PH936003', 'video_683d48ba50b87.mp4', '2025-06-02 07:46:18'),
(5, 'PH936003', 'video_683d48fe1c90f.mp4', '2025-06-02 07:47:26'),
(6, 'PH571862', 'video_683efeb82aeea.mp4', '2025-06-03 14:55:04'),
(7, 'PH936003', 'video_683eff0502ea4.mp4', '2025-06-03 14:56:21'),
(8, 'PH936003', 'video_683eff5307215.mp4', '2025-06-03 14:57:39'),
(9, 'PH480872', 'video_683eff9fe1eee.mov', '2025-06-03 14:58:55'),
(10, 'PH480872', 'video_683f0ff32b02f.mov', '2025-06-03 16:08:35'),
(11, 'PH598879', 'video_683f1d9b41f81.mp4', '2025-06-03 17:06:51'),
(14, 'PH868524', 'video_6844253cf387e.mp4', '2025-06-07 12:40:44');

-- --------------------------------------------------------

--
-- Table structure for table `fm_loyalty_purchases`
--

DROP TABLE IF EXISTS `fm_loyalty_purchases`;
CREATE TABLE IF NOT EXISTS `fm_loyalty_purchases` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `loyalty_id` varchar(45) NOT NULL,
  `amount` varchar(450) NOT NULL,
  `start_date` varchar(45) NOT NULL,
  `end_date` varchar(45) NOT NULL,
  `payment_reference` varchar(45) NOT NULL,
  `downloads` varchar(450) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_loyalty_purchases`
--

INSERT INTO `fm_loyalty_purchases` (`s`, `user_id`, `loyalty_id`, `amount`, `start_date`, `end_date`, `payment_reference`, `downloads`) VALUES
(1, '5', '21', '10000', '2025-05-31 15:51:52', '2026-05-31 15:51:52', 'PH-1748703024125-419', '40');

-- --------------------------------------------------------

--
-- Table structure for table `fm_manual_payments`
--

DROP TABLE IF EXISTS `fm_manual_payments`;
CREATE TABLE IF NOT EXISTS `fm_manual_payments` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(45) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `amount` int NOT NULL,
  `proof` varchar(4500) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date_created` varchar(45) NOT NULL,
  `rejection_reason` varchar(4500) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_manual_payments`
--

INSERT INTO `fm_manual_payments` (`s`, `order_id`, `user_id`, `amount`, `proof`, `status`, `date_created`, `rejection_reason`) VALUES
(1, 'ORD6840767a0e07a', '5', 7125, '68459709c264b.png', 'approved', '2025-06-08 14:58:33', ''),
(2, 'ORD6849035616a21', '5', 6750, '684a57242bedf.pdf', 'pending', '2025-06-12 05:27:16', 'fake receipt'),
(3, 'ORD68490aba8a582', '5', 36750, '68490add5b512.pdf', 'approved', '2025-06-11 05:49:33', '');

-- --------------------------------------------------------

--
-- Table structure for table `fm_notifications`
--

DROP TABLE IF EXISTS `fm_notifications`;
CREATE TABLE IF NOT EXISTS `fm_notifications` (
  `s` int NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `date` varchar(500) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_notifications`
--

INSERT INTO `fm_notifications` (`s`, `user`, `message`, `date`, `status`) VALUES
(1, '9', 'You have received ?0 from Order ID: ORD683bf49ddee91', '2025-06-01 10:06:01', 0),
(2, '9', 'You have received ?0 from Order ID: ORD683c708b21305', '2025-06-04 16:37:52', 0),
(3, '9', 'You have received ?0 from Order ID: ORD6840738ecdeb8', '2025-06-04 17:29:52', 0),
(4, '9', 'You have received ?0 from Order ID: ORD6840738ecdeb8', '2025-06-04 17:29:10', 0),
(5, '9', 'You have received ?0 from Order ID: ORD6845970c566fb', '2025-06-09 16:26:14', 0),
(6, '9', 'You have received ?0 from Order ID: ORD6840767a0e07a', '2025-06-10 08:42:25', 0),
(7, '9', 'You have received ?0 from Order ID: ORD6840767a0e07a', '2025-06-10 08:42:25', 0),
(8, '9', 'You have received ?0 from Order ID: ORD6840767a0e07a', '2025-06-10 08:56:19', 0),
(9, '9', 'You have received ?0 from Order ID: ORD6840767a0e07a', '2025-06-10 08:56:19', 0),
(10, '9', 'You have received ?0 from Order ID: ORD68470455a3b69', '2025-06-10 21:26:42', 0),
(11, '9', 'You have received ?0 from Order ID: ORD6849035616a21', '2025-06-11 05:28:41', 0),
(12, '9', 'You have received ?0 from Order ID: ORD684904ac23d06', '2025-06-11 05:39:27', 0),
(13, '9', 'You have received ?0 from Order ID: ORD684904ac23d06', '2025-06-11 05:39:24', 0),
(14, '9', 'You have received ?0 from Order ID: ORD68490aba8a582', '2025-06-11 05:49:55', 0),
(15, '44', 'Your withdrawal requested made on Jun 11 2025 05:53:42 for an amount of ?6000 has been paid ', '2025-06-11 09:40:37', 1),
(16, '9', 'You have received ?0 from Order ID: ORD68490adfb31fc', '2025-06-11 09:09:23', 0),
(17, '9', 'You have received ?0 from Order ID: ORD68490adfb31fc', '2025-06-12 05:13:15', 0),
(18, '6', 'You have received ?0 from Order ID: ORD68490adfb31fc', '2025-06-13 18:19:10', 0),
(19, '6', 'You have received ?0 from Order ID: ORD684c65decfb34', '2025-06-13 18:58:14', 0),
(20, '46', 'You have received ?2800 from Order ID: ORD684c5dfb6863e', '2025-06-13 19:38:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fm_orders`
--

DROP TABLE IF EXISTS `fm_orders`;
CREATE TABLE IF NOT EXISTS `fm_orders` (
  `s` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(500) NOT NULL,
  `user` int NOT NULL,
  `status` varchar(500) NOT NULL,
  `total_amount` int NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_orders`
--

INSERT INTO `fm_orders` (`s`, `order_id`, `user`, `status`, `total_amount`, `date`) VALUES
(1, 'ORD683bf49ddee91', 5, 'paid', 1500, '2025-06-01 15:21:59'),
(2, 'ORD683c708b21305', 5, 'paid', 3000, '2025-06-04 16:24:10'),
(3, 'ORD6840738ecdeb8', 5, 'paid', 6375, '2025-06-04 16:30:18'),
(4, 'ORD6840767a0e07a', 5, 'paid', 7125, '2025-06-10 07:56:19'),
(5, 'ORD6845970c566fb', 5, 'paid', 4000, '2025-06-09 15:54:51'),
(6, 'ORD68470455a3b69', 5, 'paid', 6750, '2025-06-10 20:27:08'),
(7, 'ORD6849035616a21', 5, 'paid', 6750, '2025-06-11 04:28:41'),
(8, 'ORD684904ac23d06', 5, 'paid', 43500, '2025-06-11 04:40:03'),
(9, 'ORD68490aba8a582', 5, 'paid', 36750, '2025-06-11 04:49:55'),
(10, 'ORD68490adfb31fc', 5, 'paid', 44000, '2025-06-13 17:19:28'),
(11, 'ORD684c5dfb6863e', 5, 'paid', 4000, '2025-06-13 18:38:24'),
(12, 'ORD684c65decfb34', 46, 'paid', 500, '2025-06-13 18:07:38'),
(13, 'ORD684c6d689f9a0', 46, 'unpaid', 0, '2025-06-13 18:26:48'),
(14, 'ORD684c7f9f9d6cf', 5, 'unpaid', 0, '2025-06-13 19:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `fm_order_items`
--

DROP TABLE IF EXISTS `fm_order_items`;
CREATE TABLE IF NOT EXISTS `fm_order_items` (
  `s` int NOT NULL AUTO_INCREMENT,
  `report_id` varchar(200) NOT NULL,
  `item_id` int NOT NULL,
  `price` int NOT NULL DEFAULT '0',
  `original_price` int NOT NULL,
  `loyalty_id` int NOT NULL,
  `affiliate_id` varchar(200) NOT NULL,
  `order_id` varchar(500) NOT NULL,
  `item_type` varchar(4500) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_order_items`
--

INSERT INTO `fm_order_items` (`s`, `report_id`, `item_id`, `price`, `original_price`, `loyalty_id`, `affiliate_id`, `order_id`, `item_type`, `date`) VALUES
(9, 'PH598879', 11, 3000, 4000, 21, '0', 'ORD683c708b21305', 'support_doc', '2025-06-04 16:37:52'),
(10, 'PH868524', 14, 6000, 8000, 21, '0', 'ORD6840738ecdeb8', 'support_doc', '2025-06-04 17:29:10'),
(11, 'PH598879', 8, 375, 500, 21, '0', 'ORD6840738ecdeb8', 'main_file', '2025-06-04 17:29:52'),
(20, 'PH598879', 12, 375, 500, 21, '0', 'ORD6840767a0e07a', 'support_doc', '2025-06-05 02:49:28'),
(22, 'PH868524', 11, 6750, 9000, 21, '0', 'ORD6840767a0e07a', 'main_file', '2025-06-08 14:46:50'),
(23, 'PH598879', 11, 4000, 4000, 0, '0', 'ORD6845970c566fb', 'support_doc', '2025-06-09 16:26:14'),
(24, 'PH868524', 11, 6750, 9000, 21, '0', 'ORD68470455a3b69', 'main_file', '2025-06-10 21:26:42'),
(25, 'PH868524', 11, 6750, 9000, 21, 'AFF-EF058274EE2A', 'ORD6849035616a21', 'main_file', '2025-06-11 05:22:45'),
(26, 'PH868524', 11, 6750, 9000, 21, 'AFF-EF058274EE2A', 'ORD684904ac23d06', 'main_file', '2025-06-11 05:39:24'),
(27, 'PH868524', 13, 36750, 49000, 21, 'AFF-EF058274EE2A', 'ORD684904ac23d06', 'support_doc', '2025-06-11 05:39:27'),
(28, 'PH868524', 13, 36750, 49000, 21, 'AFF-EF058274EE2A', 'ORD68490aba8a582', 'support_doc', '2025-06-11 05:49:10'),
(29, 'PH868524', 13, 36750, 49000, 21, 'AFF-EF058274EE2A', 'ORD68490adfb31fc', 'support_doc', '2025-06-11 09:09:23'),
(30, 'PH868524', 11, 6750, 9000, 21, 'AFF-EF058274EE2A', 'ORD68490adfb31fc', 'main_file', '2025-06-12 05:13:15'),
(31, 'PH598879', 8, 500, 500, 0, '0', 'ORD68490adfb31fc', 'main_file', '2025-06-13 18:19:10'),
(32, 'PH598879', 8, 500, 500, 0, '0', 'ORD684c65decfb34', 'main_file', '2025-06-13 18:58:14'),
(33, 'PH598879', 11, 4000, 4000, 0, '0', 'ORD684c5dfb6863e', 'support_doc', '2025-06-13 19:38:09');

-- --------------------------------------------------------

--
-- Table structure for table `fm_product_reports`
--

DROP TABLE IF EXISTS `fm_product_reports`;
CREATE TABLE IF NOT EXISTS `fm_product_reports` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` varchar(45) NOT NULL,
  `user_id` varchar(4500) NOT NULL,
  `reason` varchar(4500) NOT NULL,
  `report_date` varchar(45) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_product_reports`
--

INSERT INTO `fm_product_reports` (`s`, `product_id`, `user_id`, `reason`, `report_date`) VALUES
(1, 'PH598879', '5', 'bad', '2025-06-05 03:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `fm_product_views`
--

DROP TABLE IF EXISTS `fm_product_views`;
CREATE TABLE IF NOT EXISTS `fm_product_views` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `report_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_product_views`
--

INSERT INTO `fm_product_views` (`s`, `user_id`, `report_id`) VALUES
(1, '5', 'PH936003'),
(2, '5', 'PH936003'),
(3, '5', 'PH936003'),
(4, '5', 'PH936003'),
(5, '5', 'PH477211'),
(6, '5', 'PH477211'),
(7, '5', 'PH477211'),
(8, '5', 'PH477211'),
(9, '5', 'PH477211'),
(10, '5', 'PH477211'),
(11, '5', 'PH477211'),
(12, '5', 'PH477211'),
(13, '5', 'PH477211'),
(14, '5', 'PH477211'),
(15, '5', 'PH477211'),
(16, '5', 'PH477211'),
(17, '5', 'PH477211'),
(18, '5', 'PH477211'),
(19, '5', 'PH477211'),
(20, '5', 'PH477211'),
(21, '5', 'PH477211'),
(22, '5', 'PH477211'),
(23, '5', 'PH477211'),
(24, '5', 'PH480872'),
(25, '5', 'PH477211'),
(26, '5', 'PH477211'),
(27, '5', 'PH477211'),
(28, '5', 'PH477211'),
(29, '5', 'PH477211'),
(30, '5', 'PH477211'),
(31, '5', 'PH477211'),
(32, '5', 'PH477211'),
(33, '5', 'PH477211'),
(34, '5', 'PH477211'),
(35, '5', 'PH477211'),
(36, '5', 'PH477211'),
(37, '5', 'PH477211'),
(38, '5', 'PH477211'),
(39, '5', 'PH477211'),
(40, '5', 'PH477211'),
(41, '5', 'PH480872'),
(42, '5', 'PH936003'),
(43, '5', 'PH936003'),
(44, '5', 'PH477211'),
(45, '5', 'PH477211'),
(46, '5', 'PH477211'),
(47, '5', 'PH477211'),
(48, '5', 'PH477211'),
(49, '5', 'PH477211'),
(50, '5', 'PH477211'),
(51, '5', 'PH477211'),
(52, '5', 'PH477211'),
(53, '5', 'PH477211'),
(54, '5', 'PH477211'),
(55, '5', 'PH477211'),
(56, '5', 'PH477211'),
(57, '5', 'PH477211'),
(58, '5', 'PH477211'),
(59, '5', 'PH477211'),
(60, '5', 'PH477211'),
(61, '5', 'PH477211'),
(62, '5', 'PH477211'),
(63, '5', 'PH477211'),
(64, '5', 'PH477211'),
(65, '5', 'PH477211'),
(66, '5', 'PH936003'),
(67, '5', 'PH480872'),
(68, '5', 'PH477211'),
(69, '5', 'PH480872'),
(70, '5', 'PH480872'),
(71, '5', 'PH477211'),
(72, '5', 'PH477211'),
(73, '5', 'PH477211'),
(74, '5', 'PH477211'),
(75, '5', 'PH477211'),
(76, '5', 'PH477211'),
(77, '5', 'PH477211'),
(78, '5', 'PH477211'),
(79, '5', 'PH477211'),
(80, '5', 'PH477211'),
(81, '5', 'PH477211'),
(82, '5', 'PH477211'),
(83, '5', 'PH477211'),
(84, '5', 'PH477211'),
(85, '5', 'PH477211'),
(86, '5', 'PH477211'),
(87, '5', 'PH477211'),
(88, '5', 'PH477211'),
(89, '5', 'PH477211'),
(90, '5', 'PH477211'),
(91, '5', 'PH477211'),
(92, '5', 'PH477211'),
(93, '5', 'PH477211'),
(94, '5', 'PH477211'),
(95, '5', 'PH477211'),
(96, '5', 'PH477211'),
(97, '5', 'PH477211'),
(98, '5', 'PH477211'),
(99, '5', 'PH477211'),
(100, '5', 'PH477211'),
(101, '5', 'PH477211'),
(102, '5', 'PH477211'),
(103, '5', 'PH477211'),
(104, '5', 'PH477211'),
(105, '5', 'PH477211'),
(106, '5', 'PH477211'),
(107, '5', 'PH477211'),
(108, '5', 'PH477211'),
(109, '5', 'PH477211'),
(110, '5', 'PH477211'),
(111, '5', 'PH477211'),
(112, '5', 'PH477211'),
(113, '5', 'PH477211'),
(114, '5', 'PH477211'),
(115, '5', 'PH477211'),
(116, '5', 'PH477211'),
(117, '5', 'PH477211'),
(118, '5', 'PH477211'),
(119, '5', 'PH477211'),
(120, '5', 'PH477211'),
(121, '5', 'PH477211'),
(122, '5', 'PH477211'),
(123, '5', 'PH477211'),
(124, '5', 'PH477211'),
(125, '5', 'PH477211'),
(126, '5', 'PH477211'),
(127, '5', 'PH477211'),
(128, '5', 'PH477211'),
(129, '5', 'PH477211'),
(130, '5', 'PH477211'),
(131, '5', 'PH477211'),
(132, '5', 'PH477211'),
(133, '5', 'PH598879'),
(134, '5', 'PH598879'),
(135, '5', 'PH598879'),
(136, '5', 'PH598879'),
(137, '5', 'PH598879'),
(138, '5', 'PH598879'),
(139, '5', 'PH598879'),
(140, '5', 'PH598879'),
(141, '5', 'PH598879'),
(142, '5', 'PH598879'),
(143, '5', 'PH598879'),
(144, '5', 'PH598879'),
(145, '5', 'PH598879'),
(146, '5', 'PH598879'),
(147, '5', 'PH598879'),
(148, '5', 'PH598879'),
(149, '5', 'PH598879'),
(150, '5', 'PH598879'),
(151, '5', 'PH598879'),
(152, '5', 'PH598879'),
(153, '5', 'PH598879'),
(154, '5', 'PH598879'),
(155, '5', 'PH598879'),
(156, '5', 'PH598879'),
(157, '5', 'PH598879'),
(158, '5', 'PH598879'),
(159, '5', 'PH598879'),
(160, '5', 'PH598879'),
(161, '5', 'PH598879'),
(162, '5', 'PH598879'),
(163, '5', 'PH598879'),
(164, '5', 'PH598879'),
(165, '5', 'PH598879'),
(166, '5', 'PH598879'),
(167, '5', 'PH598879'),
(168, '5', 'PH598879'),
(169, '5', 'PH598879'),
(170, '5', 'PH598879'),
(171, '5', 'PH598879'),
(172, '5', 'PH598879'),
(173, '5', 'PH598879'),
(174, '5', 'PH868524'),
(175, '5', 'PH868524'),
(176, '5', 'PH868524'),
(177, '5', 'PH868524'),
(178, '5', 'PH868524'),
(179, '5', 'PH598879'),
(180, '5', 'PH598879'),
(181, '5', 'PH868524'),
(182, '5', 'PH598879'),
(183, '5', 'PH598879'),
(184, '5', 'PH868524'),
(185, '5', 'PH868524'),
(186, '5', 'PH868524'),
(187, '5', 'PH868524'),
(188, '5', 'PH598879'),
(189, '5', 'PH868524'),
(190, '5', 'PH598879'),
(191, '5', 'PH598879'),
(192, '5', 'PH598879'),
(193, '5', 'PH598879'),
(194, '5', 'PH598879'),
(195, '5', 'PH598879'),
(196, '5', 'PH598879'),
(197, '5', 'PH598879'),
(198, '5', 'PH598879'),
(199, '5', 'PH598879'),
(200, '5', 'PH598879'),
(201, '5', 'PH598879'),
(202, '5', 'PH598879'),
(203, '5', 'PH598879'),
(204, '5', 'PH598879'),
(205, '5', 'PH598879'),
(206, '5', 'PH598879'),
(207, '5', 'PH598879'),
(208, '5', 'PH598879'),
(209, '5', 'PH598879'),
(210, '5', 'PH598879'),
(211, '5', 'PH598879'),
(212, '5', 'PH868524'),
(213, '5', 'PH598879'),
(214, '5', 'PH598879'),
(215, '5', 'PH868524'),
(216, '5', 'PH868524'),
(217, '5', 'PH868524'),
(218, '5', 'PH598879'),
(219, '5', 'PH598879'),
(220, '5', 'PH598879'),
(221, '5', 'PH598879'),
(222, '5', 'PH598879'),
(223, '5', 'PH598879'),
(224, '5', 'PH598879'),
(225, '5', 'PH868524'),
(226, '5', 'PH868524'),
(227, '5', 'PH868524'),
(228, '5', 'PH868524'),
(229, '5', 'PH868524'),
(230, '5', 'PH868524'),
(231, '5', 'PH868524'),
(232, '5', 'PH868524'),
(233, '5', 'PH868524'),
(234, '5', 'PH868524'),
(235, '5', 'PH868524'),
(236, '5', 'PH868524'),
(237, '5', 'PH868524'),
(238, '5', 'PH598879'),
(239, '5', 'PH868524'),
(240, '5', 'PH868524'),
(241, '5', 'PH868524'),
(242, '5', 'PH868524'),
(243, '5', 'PH598879'),
(244, '5', 'PH598879'),
(245, '46', 'PH868524'),
(246, '46', 'PH598879'),
(247, '46', 'PH598879'),
(248, '5', 'PH598879'),
(249, '5', 'PH598879'),
(250, '5', 'PH598879'),
(251, '5', 'PH598879'),
(252, '5', 'PH868524'),
(253, '5', 'PH868524'),
(254, '5', 'PH868524'),
(255, '5', 'PH868524'),
(256, '5', 'PH598879'),
(257, '5', 'PH868524'),
(258, '5', 'PH598879'),
(259, '5', 'PH598879'),
(260, '5', 'PH598879'),
(261, '5', 'PH868524');

-- --------------------------------------------------------

--
-- Table structure for table `fm_profits`
--

DROP TABLE IF EXISTS `fm_profits`;
CREATE TABLE IF NOT EXISTS `fm_profits` (
  `s` int NOT NULL AUTO_INCREMENT,
  `amount` int NOT NULL,
  `report_id` varchar(200) NOT NULL,
  `order_id` varchar(500) NOT NULL,
  `type` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_profits`
--

INSERT INTO `fm_profits` (`s`, `amount`, `report_id`, `order_id`, `type`, `date`) VALUES
(1, 10000, '21', '21', 'Subscription Payment', '2025-05-31 15:51:52'),
(2, 1500, 'PH477211', 'ORD683bf49ddee91', 'Order Payment', '2025-06-01 10:06:01'),
(3, 3000, 'PH598879', 'ORD683c708b21305', 'Order Payment', '2025-06-04 16:37:52'),
(4, 375, 'PH598879', 'ORD6840738ecdeb8', 'Order Payment', '2025-06-04 17:29:52'),
(5, 6000, 'PH868524', 'ORD6840738ecdeb8', 'Order Payment', '2025-06-04 17:29:10'),
(6, 4000, 'PH598879', 'ORD6845970c566fb', 'Order Payment', '2025-06-09 16:26:14'),
(7, 375, 'PH598879', 'ORD6840767a0e07a', 'Order Payment', '2025-06-10 08:42:25'),
(8, 6750, 'PH868524', 'ORD6840767a0e07a', 'Order Payment', '2025-06-10 08:42:25'),
(9, 375, 'PH598879', 'ORD6840767a0e07a', 'Order Payment', '2025-06-10 08:56:19'),
(10, 6750, 'PH868524', 'ORD6840767a0e07a', 'Order Payment', '2025-06-10 08:56:19'),
(11, 6750, 'PH868524', 'ORD68470455a3b69', 'Order Payment', '2025-06-10 21:26:42'),
(12, 6750, 'PH868524', 'ORD6849035616a21', 'Order Payment', '2025-06-11 05:28:41'),
(13, 36750, 'PH868524', 'ORD684904ac23d06', 'Order Payment', '2025-06-11 05:39:27'),
(14, 6750, 'PH868524', 'ORD684904ac23d06', 'Order Payment', '2025-06-11 05:39:24'),
(15, 36750, 'PH868524', 'ORD68490aba8a582', 'Order Payment', '2025-06-11 05:49:55'),
(16, 36750, 'PH868524', 'ORD68490adfb31fc', 'Order Payment', '2025-06-11 09:09:23'),
(17, 6750, 'PH868524', 'ORD68490adfb31fc', 'Order Payment', '2025-06-12 05:13:15'),
(18, 500, 'PH598879', 'ORD68490adfb31fc', 'Order Payment', '2025-06-13 18:19:10'),
(19, 500, 'PH598879', 'ORD684c65decfb34', 'Order Payment', '2025-06-13 18:58:14'),
(20, 1200, 'PH598879', 'ORD684c5dfb6863e', 'Order Payment', '2025-06-13 19:38:09');

-- --------------------------------------------------------

--
-- Table structure for table `fm_reports`
--

DROP TABLE IF EXISTS `fm_reports`;
CREATE TABLE IF NOT EXISTS `fm_reports` (
  `s` int NOT NULL AUTO_INCREMENT,
  `id` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(60000) NOT NULL,
  `methodology` longtext NOT NULL,
  `use_case` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category` int NOT NULL,
  `subcategory` int NOT NULL,
  `pricing` varchar(500) NOT NULL,
  `price` int NOT NULL DEFAULT '0',
  `tags` varchar(500) NOT NULL,
  `loyalty` int NOT NULL DEFAULT '0',
  `user` int NOT NULL,
  `created_date` varchar(200) NOT NULL,
  `updated_date` varchar(450) NOT NULL,
  `status` varchar(200) NOT NULL,
  `alt_title` varchar(450) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_reports`
--

INSERT INTO `fm_reports` (`s`, `id`, `title`, `description`, `methodology`, `use_case`, `category`, `subcategory`, `pricing`, `price`, `tags`, `loyalty`, `user`, `created_date`, `updated_date`, `status`, `alt_title`) VALUES
(5, 'PH598879', 'Financial Impact', '<p>Facing the daunting task of choosing your final year Banking and Finance project? You\'re not alone! This comprehensive resource offers an extensive collection of over 1,500 meticulously curated thesis and dissertation topics specifically tailored for</p>', '', '169,163', 18, 119, 'free', 500, 'good', 0, 46, '2025-06-03 17:06:51', '2025-06-06 18:06:29', 'approved', 'financial-impace'),
(6, 'PH868524', 'How to be a good caterer', 'It has been said that to be the best, you must learn from the best.\r\n\r\nWe often hear of success stories such as that of world-renowned chef Joël Robuchon, who started off as an apprentice chef at the tender age of 15, only to later take on the job of head chef at Harmony-Lafayette restaurant in Paris when he turned 28. Just a year later, he attained his first Michelin star, and has been named chef of the century.\r\n\r\nYou must be wondering, what does it take to be a culinary genius like him? The chef himself once said in an interview that it takes an incredible amount of hard work. He also emphasized on being determined –when he first made up his mind to be a chef, he made sure to be the best.\r\n\r\nBut that’s not the only trait you need to make it to the top. What else does one need in order to become the next Alain Ducasse, Wolfgang Puck or Anthony Bourdain? Here are seven habits you can adopt to set yourself on track for an extraordinary career as a chef.', '', '16,15', 16, 109, 'paid', 9000, 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE', 1, 9, '2025-06-04 17:28:22', '2025-06-07 13:11:54', 'approved', 'how-to-be-a-good-caterer');

-- --------------------------------------------------------

--
-- Table structure for table `fm_reports_files`
--

DROP TABLE IF EXISTS `fm_reports_files`;
CREATE TABLE IF NOT EXISTS `fm_reports_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_id` varchar(200) NOT NULL,
  `title` varchar(500) NOT NULL,
  `pages` int NOT NULL DEFAULT '20',
  `updated_at` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_reports_files`
--

INSERT INTO `fm_reports_files` (`id`, `report_id`, `title`, `pages`, `updated_at`) VALUES
(1, 'PH480872', '6837da3a0e26f.pptx', 5, '2025-05-29 04:53:30'),
(4, 'PH936003', '683d48fe17bc2.pdf', 3, '2025-06-02 07:47:26'),
(7, 'PH571862', '683ee6cad817a.docx', 6, '2025-06-03 13:12:58'),
(8, 'PH598879', '683ee6cad817a.docx', 6, '2025-06-03 13:12:58'),
(11, 'PH868524', '684074261d64b.pdf', 4, '2025-06-04 17:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `fm_reports_images`
--

DROP TABLE IF EXISTS `fm_reports_images`;
CREATE TABLE IF NOT EXISTS `fm_reports_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_id` varchar(200) NOT NULL,
  `picture` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` varchar(600) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_reports_images`
--

INSERT INTO `fm_reports_images` (`id`, `report_id`, `picture`, `updated_at`) VALUES
(1, 'PH036858', '6837b7ede92e0.webp', '2025-05-29 02:27:09'),
(2, 'PH036858', '6837ce218029d.webp', '2025-05-29 04:01:53'),
(3, 'PH638104', '6837cefc49f85.jpg', '2025-05-29 04:05:32'),
(4, 'PH865421', '6837d8ad71200.jpg', '2025-05-29 04:46:53'),
(5, 'PH480872', '6837da3a0b904.jpg', '2025-05-29 04:53:30'),
(6, 'PH936003', '6839dcc20f0ff.webp', '2025-05-30 17:28:50'),
(7, 'PH477211', '683a0b89bb748.jpg', '2025-05-30 20:48:25'),
(8, 'PH477211', '67cc371e73b3e.jpg', '2025-05-30 20:48:25'),
(9, 'PH477211', '6807c535e4998.jpg', '2025-05-30 20:48:25'),
(10, 'PH477211', '67a79d57c9eeb.jpeg', '2025-05-30 20:48:25'),
(11, 'PH936003', '683d48ba46291.png', '2025-06-02 07:46:18'),
(12, 'PH936003', '683d48ba46e0f.png', '2025-06-02 07:46:18'),
(13, 'PH936003', '683d48ba476d2.png', '2025-06-02 07:46:18'),
(14, 'PH936003', '683d48fe0e2c2.png', '2025-06-02 07:47:26'),
(15, 'PH936003', '683d48fe0f53b.png', '2025-06-02 07:47:26'),
(16, 'PH936003', '683d48fe0fedb.png', '2025-06-02 07:47:26'),
(17, 'PH571862', '683edf4c29451.png', '2025-06-03 12:41:00'),
(18, 'PH571862', 'default3.jpg', '2025-06-03 12:41:00'),
(19, 'PH598879', '683f1d9b3c174.webp', '2025-06-03 17:06:51'),
(20, 'PH598879', '683f1d9b3c545.jpg', '2025-06-03 17:06:51'),
(21, 'PH868524', '684074261be4c.jpg', '2025-06-04 17:28:22'),
(22, 'PH598879', '6840de712dcab.jpg', '2025-06-05 01:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `fm_reviews`
--

DROP TABLE IF EXISTS `fm_reviews`;
CREATE TABLE IF NOT EXISTS `fm_reviews` (
  `s` int NOT NULL AUTO_INCREMENT,
  `report_id` varchar(200) NOT NULL,
  `user` int NOT NULL,
  `rating` int NOT NULL,
  `review` varchar(2000) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_reviews`
--

INSERT INTO `fm_reviews` (`s`, `report_id`, `user`, `rating`, `review`, `date`) VALUES
(1, 'PH598879', 5, 3, 'wow', '2025-06-05 04:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `fm_site_settings`
--

DROP TABLE IF EXISTS `fm_site_settings`;
CREATE TABLE IF NOT EXISTS `fm_site_settings` (
  `s` int NOT NULL AUTO_INCREMENT,
  `site_name` varchar(2000) NOT NULL,
  `site_keywords` varchar(2000) NOT NULL,
  `site_url` varchar(2000) NOT NULL,
  `site_description` varchar(20000) NOT NULL,
  `site_logo` varchar(2000) NOT NULL,
  `site_mail` varchar(200) NOT NULL,
  `site_number` varchar(200) NOT NULL,
  `paystack_key` varchar(500) NOT NULL,
  `commision_fee` int NOT NULL,
  `site_prefix` varchar(20) NOT NULL,
  `affliate_percentage` int NOT NULL,
  `account_name` varchar(200) NOT NULL,
  `account_number` int NOT NULL,
  `site_bank` varchar(600) NOT NULL,
  `google_map` varchar(200) NOT NULL DEFAULT 'AIzaSyBAz868BQ8JaQBr_a-osQLCgeNL6e7AZjs',
  `brevo_key` varchar(500) NOT NULL DEFAULT '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',
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_site_settings`
--

INSERT INTO `fm_site_settings` (`s`, `site_name`, `site_keywords`, `site_url`, `site_description`, `site_logo`, `site_mail`, `site_number`, `paystack_key`, `commision_fee`, `site_prefix`, `affliate_percentage`, `account_name`, `account_number`, `site_bank`, `google_map`, `brevo_key`) VALUES
(1, 'Financial Models Store', 'Financial Forecasting & Modelling in the World!', 'http://text/financial-model/', 'The One Stop Shop for Financial Forecasting & Modelling in the World!', '681de063aae66.jpg', 'hello@financialmodels.store', '+2348033782777 ', 'pk_test_0247e0d23d7cd2b8dc92f6922a53a049e39c74c2', 30, 'fm_', 8, 'Kyneli Business Support Services', 1014522865, 'Zenith Bank Plc', 'AIzaSyBAz868BQ8JaQBr_a-osQLCgeNL6e7AZjs', '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');

-- --------------------------------------------------------

--
-- Table structure for table `fm_subscription_plans`
--

DROP TABLE IF EXISTS `fm_subscription_plans`;
CREATE TABLE IF NOT EXISTS `fm_subscription_plans` (
  `s` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(450) NOT NULL,
  `price` varchar(45) NOT NULL,
  `description` varchar(4500) NOT NULL,
  `discount` varchar(45) NOT NULL,
  `downloads` varchar(45) NOT NULL,
  `duration` varchar(45) NOT NULL,
  `no_of_duration` int NOT NULL,
  `status` varchar(45) NOT NULL,
  `benefits` varchar(450) NOT NULL,
  `image` varchar(45) NOT NULL,
  `created_at` varchar(45) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_subscription_plans`
--

INSERT INTO `fm_subscription_plans` (`s`, `name`, `price`, `description`, `discount`, `downloads`, `duration`, `no_of_duration`, `status`, `benefits`, `image`, `created_at`) VALUES
(20, 'Premium Plan', '15000', 'Unlock maximum value with our Premium Loyalty Plan â€“ enjoy an exclusive thirty percent (30%) off fifty (50) downloads for a period of one (1) year. Perfect for frequent buyers who want premium benefits and unbeatable deals.', '30', '50', 'Yearly', 1, 'active', 'Exclusive Training, Priority Support, Early Access Reports', '67fedc4acfd8c.jpeg', '2025-05-22 10:50:53'),
(21, 'Enterprise Plan', '10000', 'Unlock exclusive savings with our Enterprise Plan! Enjoy a twenty-five percent (25%) off forty (40) downloads for one (1) year. Designed for high-volume users who want the best value while maximizing efficiency and cost savings.', '25', '40', 'Yearly', 1, 'active', 'Exclusive Training, Priority Support, Early Access Reports', '67fedc4ad2f37.jpeg', '2025-05-22 10:54:03'),
(22, 'Classic Plan', '5000', 'Enjoy twenty percent (20%) off twenty (20) purchases for one (1) year. Perfect for regular buyers looking for great value and consistent savings!', '20', '20', 'Yearly', 1, 'active', 'Exclusive Training, Priority Support, Early Access Reports', 'deafult5.jpg', '2025-05-22 10:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `fm_suspend`
--

DROP TABLE IF EXISTS `fm_suspend`;
CREATE TABLE IF NOT EXISTS `fm_suspend` (
  `s` int UNSIGNED NOT NULL,
  `user_id` varchar(450) NOT NULL,
  `suspend_date` varchar(450) NOT NULL,
  `suspend_reason` varchar(4500) NOT NULL,
  `suspend_end` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_suspend`
--

INSERT INTO `fm_suspend` (`s`, `user_id`, `suspend_date`, `suspend_reason`, `suspend_end`) VALUES
(0, '39', '2025-06-12 18:26:49', 'fake', '2025-06-17 18:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `fm_type_business_docs`
--

DROP TABLE IF EXISTS `fm_type_business_docs`;
CREATE TABLE IF NOT EXISTS `fm_type_business_docs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_type_business_docs`
--

INSERT INTO `fm_type_business_docs` (`id`, `name`) VALUES
(1, 'Pitch Decks & Investor Presentations'),
(2, 'Value Proposition'),
(3, 'One Page Business Proposal'),
(4, 'SWOT Analysis'),
(5, 'Industry Review Report'),
(6, 'Canvas'),
(7, 'PESTEL Analysis'),
(8, 'Marketing Mix (4 Ps)'),
(9, 'BCG Matrix'),
(10, 'Porter\'s Five Forces'),
(11, 'Marketing Plan'),
(12, 'Standard Operating Procedures (SOPs)'),
(13, 'eBooks and Guides'),
(14, 'Online Courses & Video Tutorials');

-- --------------------------------------------------------

--
-- Table structure for table `fm_users`
--

DROP TABLE IF EXISTS `fm_users`;
CREATE TABLE IF NOT EXISTS `fm_users` (
  `s` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `display_name` varchar(200) NOT NULL,
  `first_name` varchar(600) NOT NULL,
  `middle_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `company_name` varchar(450) NOT NULL,
  `company_profile` varchar(4500) NOT NULL,
  `country` varchar(450) NOT NULL,
  `profile_picture` varchar(200) NOT NULL DEFAULT 'user.png',
  `specialization` varchar(500) NOT NULL,
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
  `bank_number` bigint DEFAULT NULL,
  `branch_name` varchar(500) NOT NULL,
  `account_type` varchar(100) NOT NULL,
  `aba_ach` varchar(100) NOT NULL,
  `sort_code` varchar(100) NOT NULL,
  `ifsc_code` varchar(100) NOT NULL,
  `iban` varchar(100) NOT NULL,
  `swift_bic` varchar(100) NOT NULL,
  `loyalty` int DEFAULT '0',
  `wallet` int NOT NULL DEFAULT '0',
  `affliate` varchar(200) NOT NULL DEFAULT '',
  `seller` int NOT NULL DEFAULT '0',
  `facebook` varchar(500) NOT NULL,
  `twitter` varchar(500) NOT NULL,
  `instagram` varchar(500) NOT NULL,
  `linkedln` varchar(500) NOT NULL,
  `kin_name` varchar(500) NOT NULL,
  `kin_number` varchar(200) NOT NULL,
  `kin_email` varchar(500) NOT NULL,
  `biography` varchar(5000) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `kin_relationship` varchar(200) NOT NULL,
  `downloads` varchar(450) NOT NULL,
  `reset_token` varchar(450) NOT NULL,
  `reset_token_expiry` varchar(450) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_users`
--

INSERT INTO `fm_users` (`s`, `title`, `display_name`, `first_name`, `middle_name`, `last_name`, `company_name`, `company_profile`, `country`, `profile_picture`, `specialization`, `mobile_number`, `email`, `password`, `gender`, `address`, `type`, `status`, `last_login`, `created_date`, `preference`, `bank_name`, `bank_accname`, `bank_number`, `branch_name`, `account_type`, `aba_ach`, `sort_code`, `ifsc_code`, `iban`, `swift_bic`, `loyalty`, `wallet`, `affliate`, `seller`, `facebook`, `twitter`, `instagram`, `linkedln`, `kin_name`, `kin_number`, `kin_email`, `biography`, `designation`, `kin_relationship`, `downloads`, `reset_token`, `reset_token_expiry`) VALUES
(5, 'mr', 'ola', 'oladunni', 'james', 'yemi', '', '', '', '6842de9083470.jpg', '16', '08122793508', 'oladunni@gmail.com', '$2y$10$BLQIzPHSM95UAi8DjSXiVOE0cZ9.3sbRyFeTlZZ.jqSEk0sbFzwfS', 'Female', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'user', 'active', '2025-06-05 02:46:29', '2025-05-23 09:19:12', '', 'Opay', 'Ibrahim Fopefoluwa Favour', 8122793508, 'Iwo road', 'Savings', '7890              ', '                          ', '', '', '', 21, 0, '0', 1, '', '', '', '', 'oladunni james bade', '09081551454', 'oladunni@gmail.com', 'good', 'Sister                          ', '', '14', '', ''),
(6, 'mr', 'ola', 'oladunni', 'james', 'yemi', '', '', '', '6830394987815.png', 'Healthcare', '(090) 815-5145', 'oladunni6@gmail.com', '$2y$10$IWCPqfvdyH/Q3b0ZsR8X3Oo96uPO6VBgWEj08xosKPB057EOucICu', 'Female', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'admin', 'active', '2025-05-28 05:20:16', '2025-05-23 10:00:57', '', 'Opay', 'Ibrahim Fopefoluwa Favour', 8122793508, 'Iwo road', 'Savings', '', '', '', '', '', 0, 0, '0', 0, 'fop', '', '', '', 'oladunni james bade', '09081551454', 'oladunni@gmail.com', 'good', 'Sister', '', '0', '', ''),
(9, '', 'ProjectHub', 'Project', '', 'Hub', '', '', '', '684e8636c8e3b.webp', '', '', 'hello@projectreporthub.ng', '$2y$10$hofxCh0hO8xcFSOBIx9IvOQ.uvSeENF939nF7iF4PZU4a4yQoC1eG', '', '', 'admin', 'active', '2025-06-03 07:53:21', '', '', '', '', NULL, '', '', '', '', '', '', '', 0, 53809, '0', 0, '', '', '', '', '', '', '', '', '', '', '', 'be6aeafcb576a79d94da8c4cc0946ac9350c1dfb33dda1f9c0f5911bf1c59910', '2025-05-01 09:18:19'),
(34, '', 'ikedike2002', 'Ikechukwu', 'Nnamdi', 'Anaekwe', '', '', '', '682e49cc5ebe2.jpg', '', '08033782777', 'ikedike2002@yahoo.com', '$2y$10$YtKzSBys2HLxLl5hnnvLfuqM1PbHca5AHOEohn2WQyTjQgW1/y2mm', 'Male', '61-65 Egbe- Isolo Road, Iyana Ejigbo Shopping Arcade, Block A, Suite 19, Iyana Ejigbo Bus Stop, Ejigbo, Lagos.', 'sub-admin', 'active', '2025-05-23 17:00:03', '2025-05-21 22:46:52', '', 'Opay', 'Anaekwe Everistus Nnamdi', 2147483647, '', '', '', '', '', '', '', 0, 0, '0', 1, '', '', '', '', 'Nnamdi', '08033782777', 'ikedike2002@yahoo.com', 'I am freelancer', '', '', '0', '', ''),
(35, '', 'Foraminifera Ventures', 'Anaekwe', 'Everistus Nnamdi', 'Ikechukwu', '', '', '', '6830a152119eb.png', '', '08033782777', 'six33fourng@gmail.com', '$2y$10$cuVhYvP5ALu/3AiDUINtBeicApF39Vn03wY67FKVMajK2b59D0Bdm', 'Male', '10 Wale Ariwo-Ola St, Graceland Estate, Bucknor, Ejigbo, Lagos 102214, Lagos, Nigeria', 'user', 'active', '2025-05-23 17:26:04', '2025-05-23 17:24:50', '', 'gt bank', 'Anaekwe Everistus Nnamdi Ikechukwu', 1234567890, '', '', '', '', '', '', '', 0, 0, '0', 1, 'https://www.projectreporthub.ng/signup', 'https://www.projectreporthub.ng/signup', 'https://www.projectreporthub.ng/', 'https://www.projectreporthub.ng/', 'Anaekwe Ikechukwu', '08033782777', 'ikedike2002@yahoo.com', 'It is me', '', '', '0', '', ''),
(36, 'Mr', ' Fopefoluwa', 'Ibrahim Fopefoluwa', 'favour', 'Kolapo Ishola Estate', '', '', '', '.png', '', '(081) 227-9350', 'fopsycute19@gmail.com', '$2y$10$3tg5kvPcbVE.dpEraUWP1OQQ5pP8mgtztDI7X3lx.A8ZFSI6hht1y', 'Male', 'Kolapo Ishola Estate', 'user', 'inactive', '2025-05-28 13:32:24', '2025-05-28 13:32:24', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567', '5678899', '677889', '67888', '890877', 0, 0, '', 0, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'fopsycute18@gmail.com', 'good', 'sister', '', '0', '', ''),
(37, 'Mr', ' Fopefoluwa', 'Ibrahim Fopefoluwa', 'favour', 'Kolapo Ishola Estate', '', '', '', '.jpg', '', '(081) 227-9350', 'fopsycute@gmail.com', '$2y$10$T7tfeYjLmjc1LakjapKA9uvd6VYn4eCt1IpvwdRUEy/SkiSJQyfTa', 'Male', 'Kolapo Ishola Estate', 'user', 'inactive', '2025-05-28 14:21:45', '2025-05-28 14:21:45', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567', '5678899', '677889', '67888', '890877', 0, 0, '', 0, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'fopsycute18@gmail.com', 'good', 'sister', '', '0', '', ''),
(38, 'Mr', ' Fopefoluwa', 'Ibrahim Fopefoluwa', 'favour', 'Kolapo Ishola Estate', '', '', '', '.jpg', '', '(081) 227-9350', 'fopsycute2@gmail.com', '$2y$10$RSLP9n3ZzWPPiu3SrVkyxeRA7Rn6ZsPdYH.qqWFc4HtbvxaKKuOou', 'Male', 'Kolapo Ishola Estate', 'user', 'inactive', '2025-05-28 20:09:19', '2025-05-28 20:09:19', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567', '5678899', '677889', '67888', '890877', 0, 0, '', 0, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'fopsycute18@gmail.com', 'good', 'sister', '', '0', '', ''),
(39, '', 'tonik', '', '', '', 'ToniTONI', 'good', '156', '.jpg', '16', '08122793508', '', '$2y$10$wQbMtXDwcfakQJC9G.HAt.wBm8xUzi9C2acAWgge6vHpvQknbeKnW', '', 'Kolapo Ishola Estate', 'user', 'suspended', '2025-05-28 20:27:09', '2025-05-28 20:27:09', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567', '5678899', '677889', '123456', '890877', 0, 0, '0', 0, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'favourfope001@gmail.com', '', 'sister', '', '0', '', ''),
(40, '', 'tonik', '', '', '', 'ToniTONI', 'good', '156', '6838af8140435.jpg', '17', '08122793508', 'tony248@gmail.com', '$2y$10$EzrF/BSOvJ.GUPWcHMlNG.fdYpvFL2.nv.0PKuxcwC69LwQsNdZ5.', '', 'Kolapo Ishola Estate', 'user', 'active', '2025-05-29 20:03:29', '2025-05-29 20:03:29', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567  ', '5678899  ', '677889', '123456', '890877', 0, 0, '0', 1, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'favourfope001@gmail.com', '', 'sister  ', '', '0', '', ''),
(41, 'Mr', ' Fopefoluwa', 'Ibrahim Fopefoluwa', 'favour', 'Kolapo Ishola Estate', '', '', '', '6838b4455e9c6.png', '', '(081) 227-9350', 'fopsycute26@gmail.com', '$2y$10$0ph85XN/zJsty5E761x6ju2Kplb2Xs5Lwn74zGuyrndMnJzZymVvi', 'Male', 'Kolapo Ishola Estate', 'user', 'inactive', '2025-05-29 20:23:49', '2025-05-29 20:23:49', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567', '5678899', '677889', '67888', '890877', 0, 0, '', 0, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'fopsycute18@gmail.com', 'good', 'sister', '', '0', '', ''),
(42, '', 'Ibrahim', 'Ibrahim', 'Favour', '', '', '', '', '', '', '09081551454', 'favourfope003@gmail.com', '$2y$10$pXttV4nt3jjgHxR8GIXC4.BLRX4jyw.TioLTsxzUYmuTNZkVYn6k.', 'Male', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'affiliate', 'active', '2025-05-31 13:00:39', '2025-05-31 13:00:39', '', '', '', 0, '', '', '', '', '', '', '', 0, 0, 'AFF-FA6E2DB70717', 0, '', '', '', '', '', '', '', '', '', '', '0', '', ''),
(44, '', 'oladunni', 'oladunni', 'james', 'bade', '', '', '156', '', '', '09081551454', 'favourfope@gmail.com', '$2y$10$GQS8g4a.ouZcqJD.shEIwe04M.O52mEi4nesqQoKe9T3pMeMvdhZe', 'Male', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'affiliate', 'active', '2025-06-10 21:25:59', '2025-05-31 13:17:51', '', 'Opay', 'Ibrahim Fopefoluwa Favour', 8122793508, '', '', '', '', '', '', '', 0, 4980, 'AFF-EF058274EE2A', 0, '', '', '', '', '', '', '', '', '', '', '0', '', ''),
(45, '', 'Kunle Ara Pharmacy', '', '', '', 'Kunle Ara Pharmacy', 'Kunle Ara Pharmacy Limited (Kunle Ara) is a leading retail and wholesale pharmacy in Nigeria, dedicated to providing genuine and high-quality drugs, medicines, medical appliances, and a wide range of health, beauty, and food products at unbeatable prices. Since incorporation in 1995, our commitment to excellence and innovation in the pharmaceutical industry ensures that we deliver exceptional value and service to our customers.', '156', '684c60dde0e31.jpg', '18', '08122793508', 'kunle@gmail.com', '$2y$10$NEj1EZMwMS0kfWJMQL1w8eHjD27kSzxH7Xk/yzlVwFhtaNjxG36xO', '', 'Kolapo Ishola Estate', 'user', 'inactive', '2025-06-13 18:33:17', '2025-06-13 18:33:17', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567', '5678899', '677889', '123456', '890877', 0, 0, '0', 0, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'favourfope001@gmail.com', '', 'sister', '', '0', '', ''),
(46, '', 'Kunle Ara Pharmacy', '', '', '', 'Kunle Ara Pharmacy', 'Kunle Ara Pharmacy Limited (Kunle Ara) is a leading retail and wholesale pharmacy in Nigeria, dedicated to providing genuine and high-quality drugs, medicines, medical appliances, and a wide range of health, beauty, and food products at unbeatable prices. Since incorporation in 1995, our commitment to excellence and innovation in the pharmaceutical industry ensures that we deliver exceptional value and service to our customers.', '156', '684c6527c1818.jpg', '18', '08122793508', 'kunleara@gmail.com', '$2y$10$iZLHNHQtPY.inWjW34yKIewlMYIdkOKUegHBobL7bSrHu0CQW5wne', '', 'Kolapo Ishola Estate', 'user', 'active', '2025-06-13 18:54:23', '2025-06-13 18:51:35', '', 'opay', 'ibrahim fope favour', 8122793508, 'iwo road', 'Savings', '234567 ', '5678899 ', '677889', '123456', '890877', 0, 2800, '0', 1, 'fopsy', 'fopsy', 'fopsy', 'fopsy', 'Ibrahim Fopefoluwa Favour', '08122793508', 'favourfope001@gmail.com', '', 'sister ', '', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fm_use_cases`
--

DROP TABLE IF EXISTS `fm_use_cases`;
CREATE TABLE IF NOT EXISTS `fm_use_cases` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fm_use_cases`
--

INSERT INTO `fm_use_cases` (`id`, `name`, `parent_id`) VALUES
(1, 'Business Planning and Operations', NULL),
(2, 'Investment and Valuation', NULL),
(3, 'Strategic Decision-Making', NULL),
(4, 'Financing and Fundraising', NULL),
(5, 'Risk Management and Compliance', NULL),
(6, 'E-commerce and Retail', NULL),
(7, 'Real Estate and Construction', NULL),
(8, 'Technology and SaaS', NULL),
(9, 'Education and Training', NULL),
(11, 'Start-up financial projections', 1),
(12, 'Revenue forecasting', 1),
(13, 'Expense tracking and control', 1),
(14, 'Cash flow management', 1),
(15, 'Budgeting for operational efficiency', 1),
(16, 'Break-even analysis', 1),
(17, 'Business turnaround planning', 1),
(18, 'Scenario planning for economic shifts', 1),
(19, 'Product pricing strategy', 1),
(20, 'Unit economics modelling', 1),
(21, 'Capacity planning for production', 1),
(22, 'Supply chain cost analysis', 1),
(23, 'Workforce optimization', 1),
(24, 'Expansion feasibility studies', 1),
(25, 'Franchise business modelling', 1),
(26, 'Discounted cash flow (DCF) analysis', 2),
(27, 'Comparable company analysis', 2),
(28, 'Precedent transaction analysis', 2),
(29, 'Initial public offering (IPO) readiness', 2),
(30, 'Venture capital ROI calculation', 2),
(31, 'Angel investment evaluations', 2),
(32, 'Private equity deal assessment', 2),
(33, 'Stock portfolio analysis', 2),
(34, 'Mutual fund performance modelling', 2),
(35, 'Cryptocurrency price projections', 2),
(36, 'Bond valuation models', 2),
(37, 'Real estate IRR and NPV analysis', 2),
(38, 'Real estate rental income forecasting', 2),
(39, 'Renewable energy project financing', 2),
(40, 'Start-up’s pre-money and post-money valuation', 2),
(41, 'Mergers and acquisitions (M&A) analysis', 3),
(42, 'Divestiture planning', 3),
(43, 'Cost-benefit analysis of new ventures', 3),
(44, 'Market entry financial projections', 3),
(45, 'Outsourcing decision modelling', 3),
(46, 'Strategic partnership evaluation', 3),
(47, 'Intellectual property valuation', 3),
(48, 'Capital allocation strategy', 3),
(49, 'Impact of economic policies on business', 3),
(50, 'Exit strategy modelling for founders', 3),
(111, 'Loan amortization schedules', 4),
(112, 'Debt refinancing models', 4),
(113, 'Equity vs. debt funding analysis', 4),
(114, 'Pitch deck financial projections', 4),
(115, 'Investor return modelling', 4),
(116, 'Working capital management', 4),
(117, 'Bank loan repayment strategies', 4),
(118, 'Crowdfunding financial forecasting', 4),
(119, 'Corporate bond issuance projections', 4),
(120, 'Convertible debt impact modelling', 4),
(121, 'Sensitivity analysis for critical variables', 5),
(122, 'Stress testing financial health', 5),
(123, 'Fraud detection in financial records', 5),
(124, 'Regulatory compliance cost modelling', 5),
(125, 'Contingency planning for risk scenarios', 5),
(126, 'Credit risk assessment for customers', 5),
(127, 'Currency exchange rate risk models', 5),
(128, 'Industry-specific risk modelling (e.g., oil p', 5),
(129, 'Political risk impact on business operations', 5),
(130, 'Insurance premium cost-benefit analysis', 5),
(131, 'Sales funnel conversion rate forecasting', 6),
(132, 'Customer lifetime value (LTV) analysis', 6),
(133, 'Inventory turnover optimization', 6),
(134, 'Return on advertising spend (ROAS) modelling', 6),
(135, 'Subscription model revenue forecasting', 6),
(136, 'Seasonal sales impact modelling', 6),
(137, 'Affiliate marketing ROI projections', 6),
(138, 'Omnichannel retail financial analysis', 6),
(139, 'Dynamic pricing strategy modelling', 6),
(140, 'Inventory financing projections', 6),
(141, 'Property development feasibility studies', 7),
(142, 'Real estate investment trust (REIT) modelling', 7),
(143, 'Commercial lease revenue projections', 7),
(144, 'Home loan affordability analysis', 7),
(145, 'Mortgage-backed securities (MBS) modelling', 7),
(146, 'Infrastructure project financing', 7),
(147, 'Cost estimation for new construction', 7),
(148, 'Land acquisition ROI projections', 7),
(149, 'Urban redevelopment financial plans', 7),
(150, 'Facility management cost analysis', 7),
(151, 'Software-as-a-Service (SaaS) revenue models', 8),
(152, 'Churn rate impact on subscriptions', 8),
(153, 'Cloud cost scaling models', 8),
(154, 'User acquisition cost (CAC) forecasting', 8),
(155, 'Mobile app monetization modelling', 8),
(156, 'Technology product lifecycle ROI', 8),
(157, 'Digital transformation cost-benefit analysis', 8),
(158, 'Blockchain project financial projections', 8),
(159, 'Start-up burn rate calculation', 8),
(160, 'Data center cost efficiency analysis', 8),
(161, 'Tuition fee optimization for schools', 9),
(162, 'Student enrolment revenue projections', 9),
(163, 'EdTech start-up ROI modelling', 9),
(164, 'Scholarship fund allocation plans', 9),
(165, 'Training program cost-benefit analysis', 9),
(166, 'Online course revenue forecasts', 9),
(167, 'Research grant financial management', 9),
(168, 'Non-profit funding allocation models', 9),
(169, 'Academic institution budget planning', 9),
(170, 'Faculty and resource optimization for univers', 9);

-- --------------------------------------------------------

--
-- Table structure for table `fm_wallet_history`
--

DROP TABLE IF EXISTS `fm_wallet_history`;
CREATE TABLE IF NOT EXISTS `fm_wallet_history` (
  `s` int NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL,
  `amount` int NOT NULL,
  `reason` varchar(500) NOT NULL,
  `status` varchar(600) NOT NULL,
  `date` varchar(500) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_wallet_history`
--

INSERT INTO `fm_wallet_history` (`s`, `user`, `amount`, `reason`, `status`, `date`) VALUES
(1, '9', 0, 'Payment from Order ID: ORD683bf49ddee91', 'credit', '2025-06-01 10:06:01'),
(2, '9', 0, 'Payment from Order ID: ORD683c708b21305', 'credit', '2025-06-04 16:37:52'),
(3, '9', 0, 'Payment from Order ID: ORD6840738ecdeb8', 'credit', '2025-06-04 17:29:52'),
(4, '9', 0, 'Payment from Order ID: ORD6840738ecdeb8', 'credit', '2025-06-04 17:29:10'),
(5, '9', 0, 'Payment from Order ID: ORD6845970c566fb', 'credit', '2025-06-09 16:26:14'),
(6, '9', 0, 'Payment from Order ID: ORD6840767a0e07a', 'credit', '2025-06-10 08:42:25'),
(7, '9', 0, 'Payment from Order ID: ORD6840767a0e07a', 'credit', '2025-06-10 08:42:25'),
(8, '9', 0, 'Payment from Order ID: ORD6840767a0e07a', 'credit', '2025-06-10 08:56:19'),
(9, '9', 0, 'Payment from Order ID: ORD6840767a0e07a', 'credit', '2025-06-10 08:56:19'),
(10, '9', 0, 'Payment from Order ID: ORD68470455a3b69', 'credit', '2025-06-10 21:26:42'),
(11, '44', 540, 'Affiliate Earnings from Order ID: ORD6849035616a21', 'credit', '2025-06-11 05:28:41'),
(12, '9', 0, 'Payment from Order ID: ORD6849035616a21', 'credit', '2025-06-11 05:28:41'),
(13, '44', 2940, 'Affiliate Earnings from Order ID: ORD684904ac23d06', 'credit', '2025-06-11 05:39:27'),
(14, '9', 0, 'Payment from Order ID: ORD684904ac23d06', 'credit', '2025-06-11 05:39:27'),
(15, '44', 540, 'Affiliate Earnings from Order ID: ORD684904ac23d06', 'credit', '2025-06-11 05:39:24'),
(16, '9', 0, 'Payment from Order ID: ORD684904ac23d06', 'credit', '2025-06-11 05:39:24'),
(17, '44', 2940, 'Affiliate Earnings from Order ID: ORD68490aba8a582', 'credit', '2025-06-11 05:49:55'),
(18, '9', 0, 'Payment from Order ID: ORD68490aba8a582', 'credit', '2025-06-11 05:49:55'),
(19, '44', 2940, 'Affiliate Earnings from Order ID: ORD68490adfb31fc', 'credit', '2025-06-11 09:09:23'),
(20, '9', 0, 'Payment from Order ID: ORD68490adfb31fc', 'credit', '2025-06-11 09:09:23'),
(21, '44', 540, 'Affiliate Earnings from Order ID: ORD68490adfb31fc', 'credit', '2025-06-12 05:13:15'),
(22, '9', 0, 'Payment from Order ID: ORD68490adfb31fc', 'credit', '2025-06-12 05:13:15'),
(23, '6', 0, 'Payment from Order ID: ORD68490adfb31fc', 'credit', '2025-06-13 18:19:10'),
(24, '6', 0, 'Payment from Order ID: ORD684c65decfb34', 'credit', '2025-06-13 18:58:14'),
(25, '46', 2800, 'Payment from Order ID: ORD684c5dfb6863e', 'credit', '2025-06-13 19:38:09');

-- --------------------------------------------------------

--
-- Table structure for table `fm_wishlist`
--

DROP TABLE IF EXISTS `fm_wishlist`;
CREATE TABLE IF NOT EXISTS `fm_wishlist` (
  `s` int NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `product` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fm_withdrawal`
--

DROP TABLE IF EXISTS `fm_withdrawal`;
CREATE TABLE IF NOT EXISTS `fm_withdrawal` (
  `s` int NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL,
  `amount` int NOT NULL,
  `date` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `bank` varchar(2000) NOT NULL,
  `bank_name` varchar(2000) NOT NULL,
  `bank_number` varchar(2000) NOT NULL,
  PRIMARY KEY (`s`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fm_withdrawal`
--

INSERT INTO `fm_withdrawal` (`s`, `user`, `amount`, `date`, `status`, `bank`, `bank_name`, `bank_number`) VALUES
(1, '44', 6000, '2025-06-11 05:53:42', 'paid', 'Opay', 'Ibrahim Fopefoluwa Favour', '8122793508');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
