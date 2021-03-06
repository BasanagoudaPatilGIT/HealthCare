-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2018 at 01:44 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `healthcare`
--
CREATE DATABASE IF NOT EXISTS `healthcare` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `healthcare`;

-- --------------------------------------------------------

--
-- Table structure for table `tab_basic`
--

CREATE TABLE IF NOT EXISTS `tab_basic` (
  `user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `browser_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_access` datetime NOT NULL,
  `id` int(10) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_basic`
--

INSERT INTO `tab_basic` (`user_id`, `browser_name`, `last_access`, `id`) VALUES
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-11 16:36:17', 1),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-12 04:37:16', 2),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-12 07:06:51', 3),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-12 07:28:11', 4),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-14 16:17:41', 5),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-15 05:37:22', 6),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-15 05:37:48', 7),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-15 05:59:39', 8),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-15 07:15:04', 9),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-15 10:11:05', 10),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-15 13:07:14', 11),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-16 03:46:57', 12),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-19 05:39:53', 13),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-19 10:56:40', 14),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-20 17:04:57', 15),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-20 17:08:53', 16),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-22 15:05:51', 17),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-22 17:23:45', 18),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-23 14:05:41', 19),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-23 17:30:36', 20),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-24 15:20:51', 21),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-25 01:34:36', 22),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-25 16:55:28', 23),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-26 05:09:11', 24),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-26 15:15:23', 25),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-27 06:13:14', 26),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-27 08:53:00', 27),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-27 08:55:21', 28),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-27 08:56:48', 29),
('Basanagouda Patil', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-27 11:45:28', 30),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-27 11:56:36', 31),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-28 09:17:57', 32),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-28 10:10:49', 33),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-28 17:17:38', 34),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-29 16:52:11', 35),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-29 16:54:52', 36),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-30 15:52:16', 37),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-08-31 16:18:00', 38),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-09-02 10:38:37', 39),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-09-02 12:46:34', 40),
('Vinod Kadolli', 'Chrome;68.0.3440.106;;Windows 10', '2018-09-02 12:47:49', 41),
('Vinod Kadolli', 'Chrome;69.0.3497.92;;Windows 10', '2018-09-13 09:52:23', 42),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-09-21 06:45:11', 43),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-01 05:22:50', 44),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-01 06:15:20', 45),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-01 09:12:56', 46),
('Basanagouda Patil', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-01 11:01:02', 47),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-01 11:02:20', 48),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-03 05:46:42', 49),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-03 07:12:21', 50),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-03 13:18:18', 51),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-06 06:12:31', 52),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-13 05:37:34', 53),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-15 06:11:36', 54),
('Vinod Kadolli', 'Chrome;69.0.3497.100;;Windows 10', '2018-10-15 07:46:31', 55);

-- --------------------------------------------------------

--
-- Table structure for table `tab_designation`
--

CREATE TABLE IF NOT EXISTS `tab_designation` (
  `id` int(10) NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_designation`
--

INSERT INTO `tab_designation` (`id`, `designation`) VALUES
(1, 'Admin'),
(2, 'Doctor');

-- --------------------------------------------------------

--
-- Table structure for table `tab_invoice_d`
--

CREATE TABLE IF NOT EXISTS `tab_invoice_d` (
  `id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `product_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sale_rate` decimal(65,2) NOT NULL,
  `tax_percent` decimal(65,2) NOT NULL,
  `tax_amount` double(65,2) NOT NULL,
  `product_uom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` int(100) NOT NULL,
  `sub_total` decimal(65,2) NOT NULL,
  `total` double(65,2) NOT NULL,
  `user_id` int(100) NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int(255) NOT NULL,
  `batchno` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `invoiceh_id` int(100) NOT NULL,
  `product_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_invoice_d`
--

INSERT INTO `tab_invoice_d` (`id`, `product_id`, `product_code`, `product_name`, `sale_rate`, `tax_percent`, `tax_amount`, `product_uom`, `product_qty`, `sub_total`, `total`, `user_id`, `created_datetime`, `stock`, `batchno`, `invoiceh_id`, `product_type`) VALUES
(1, 2, 'P1001-2', 'Acetaminophen', '4.00', '1.50', 1.20, 'Strips', 1, '80.00', 81.00, 2, '2018-10-01 12:32:50', 10, 'P1001-2-2019-02-28-5-3-4', 1, ''),
(2, 1, 'P1001-1', 'Crocine 120', '3.50', '1.25', 0.04, 'Pcs', 1, '3.50', 4.00, 2, '2018-10-01 12:32:50', 1000, 'P1001-1-2018-11-30-3-2-3', 1, ''),
(3, 1, 'P1001-1', 'Crocine 120', '3.50', '1.25', 8.75, 'Boxs', 1, '700.00', 709.00, 2, '2018-10-01 12:34:09', 4, 'P1001-1-2018-11-30-3-2-3', 2, ''),
(4, 1, 'P1001-1', 'Crocine 120', '3.50', '1.25', 0.04, 'Pcs', 1, '3.50', 4.00, 2, '2018-10-01 12:35:54', 799, 'P1001-1-2018-11-30-3-2-3', 3, ''),
(5, 5, 'P1001-5', 'citrazin', '2.50', '2.00', 0.05, 'Pcs', 1, '2.50', 3.00, 2, '2018-10-01 17:35:42', 10, 'P1001-5-2018-12-28-2-1-2', 4, ''),
(6, 9, 'P1001-8', 'SBL Relaxhed Drop', '0.09', '2.00', 0.90, 'Bottles', 1, '45.00', 46.00, 2, '2018-10-15 17:55:10', 50, 'P1001-8-2019-01-05-50-40-45', 5, 'Liquid'),
(7, 6, 'P1001-6', 'Acebrofylline', '2.00', '2.00', 0.04, 'Pcs', 1, '2.00', 2.00, 2, '2018-10-15 17:55:10', 100, 'P1001-6-2018-10-31-5-3-2', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `tab_invoice_h`
--

CREATE TABLE IF NOT EXISTS `tab_invoice_h` (
  `id` int(100) NOT NULL,
  `fees` double(65,2) NOT NULL,
  `invoice_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_gender` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `patient_phoneno` int(100) NOT NULL,
  `patient_address` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(100) NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_amt` double(65,2) NOT NULL,
  `total_tax_amt` decimal(65,2) NOT NULL,
  `total_gross_amt` decimal(65,2) NOT NULL,
  `created_date` date NOT NULL,
  `age` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_invoice_h`
--

INSERT INTO `tab_invoice_h` (`id`, `fees`, `invoice_no`, `patient_name`, `patient_gender`, `patient_phoneno`, `patient_address`, `user_id`, `created_datetime`, `invoice_amt`, `total_tax_amt`, `total_gross_amt`, `created_date`, `age`) VALUES
(1, 15.00, '#I1001-1', 'Vinayak', 'Male', 2147483647, 'test', 2, '2018-10-01 12:32:50', 100.00, '1.24', '83.50', '2018-10-01', 0),
(2, 141.00, '#I1001-2', 'Ganesh', 'Male', 2147483647, 'test', 2, '2018-10-03 12:34:09', 850.00, '8.75', '700.00', '2018-10-03', 0),
(3, 23.00, '#I1001-3', 'Ganesh', 'Male', 2147483647, '76dgfgdf', 2, '2018-10-03 12:35:54', 27.00, '0.04', '3.50', '2018-10-03', 0),
(4, 1.00, '#I1001-4', 'Vinayak', 'Male', 2147483647, 'test', 2, '2018-10-03 17:35:42', 4.00, '0.05', '2.50', '2018-10-03', 0),
(5, 100.00, '#I1001-5', 'Savita', 'Female', 2147483647, 'Address field', 2, '2018-10-15 17:54:36', 148.00, '0.94', '47.00', '2018-10-15', 23);

-- --------------------------------------------------------

--
-- Table structure for table `tab_mobi_command_master`
--

CREATE TABLE IF NOT EXISTS `tab_mobi_command_master` (
  `mcm_id` int(10) NOT NULL,
  `mcm_command_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mcm_command_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mcm_user_type` int(10) NOT NULL,
  `mcm_is_valid` int(10) NOT NULL,
  PRIMARY KEY (`mcm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_mobi_command_master`
--

INSERT INTO `tab_mobi_command_master` (`mcm_id`, `mcm_command_code`, `mcm_command_name`, `mcm_user_type`, `mcm_is_valid`) VALUES
(1, 'mobi_login', 'Mobile Login', 2, 1),
(2, 'mobi_main_menu', 'Mobile Main/Home Menu', 2, 1),
(3, 'mobi_stock', 'Mobile Stock', 2, 1),
(4, 'mobi_add_prod', 'Mobile Add Product', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tab_mobi_menu_master`
--

CREATE TABLE IF NOT EXISTS `tab_mobi_menu_master` (
  `menu_id` int(10) NOT NULL,
  `menu_command_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menu_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menu_entity_id` int(10) NOT NULL,
  `menu_is_valid` int(10) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tab_product`
--

CREATE TABLE IF NOT EXISTS `tab_product` (
  `id` int(255) NOT NULL,
  `product_code` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` int(255) NOT NULL,
  `createddatetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `qtylimit` int(100) NOT NULL,
  `packdate` date NOT NULL,
  `expirydate` date NOT NULL,
  `stripsinbox` int(10) NOT NULL,
  `pcsinstrip` int(10) NOT NULL,
  `bottlesinbox` int(10) NOT NULL,
  `mlinbottle` int(10) NOT NULL,
  `mrp` decimal(65,2) NOT NULL,
  `salerate` decimal(65,2) NOT NULL,
  `purrate` decimal(65,2) NOT NULL,
  `abtproduct` text COLLATE utf8_unicode_ci NOT NULL,
  `batchno` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tax_percent` double(65,2) NOT NULL,
  `product_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_product`
--

INSERT INTO `tab_product` (`id`, `product_code`, `product_name`, `product_qty`, `createddatetime`, `status`, `user_id`, `qtylimit`, `packdate`, `expirydate`, `stripsinbox`, `pcsinstrip`, `bottlesinbox`, `mlinbottle`, `mrp`, `salerate`, `purrate`, `abtproduct`, `batchno`, `tax_percent`, `product_type`) VALUES
(1, 'P1001-1', 'Crocine 120', 798, '2018-10-01 11:51:50', 'Active', 2, 250, '2018-10-01', '2018-11-30', 10, 20, 1, 1, '3.25', '3.50', '2.50', 'Crocine 120', 'P1001-1-2018-11-30-3-2-3', 1.25, 'Tablet'),
(2, 'P1001-2', 'Acetaminophen', 180, '2018-10-01 11:53:25', 'Active', 2, 100, '2018-10-01', '2019-02-28', 10, 20, 1, 1, '5.00', '4.00', '3.00', 'Acetaminophen', 'P1001-2-2019-02-28-5-3-4', 1.50, 'Tablet'),
(3, 'P1001-3', 'Atorvastatin', 300, '2018-10-01 12:39:56', 'Active', 2, 100, '2018-10-01', '2018-10-31', 10, 10, 1, 1, '4.32', '5.00', '3.00', 'Atorvastatin', 'P1001-3-2018-10-31-4-3-5', 1.00, 'Tablet'),
(4, 'P1001-4', 'Azulene', 201, '2018-10-01 13:14:56', 'Active', 2, 10, '2018-10-01', '2018-10-01', 10, 10, 1, 1, '1.00', '1.00', '1.00', 'a', 'P1001-4-2018-10-01-1-1-1', 1.00, 'Tablet'),
(5, 'P1001-5', 'citrazin', 210, '2018-10-01 14:36:18', 'Active', 2, 100, '2018-10-01', '2018-12-28', 10, 10, 1, 1, '2.00', '2.50', '1.20', 'citrazin', 'P1001-5-2018-12-28-2-1-2', 2.00, 'Tablet'),
(6, 'P1001-6', 'Acebrofylline', 99, '2018-10-01 16:47:09', 'Active', 2, 100, '2018-10-01', '2018-10-31', 10, 10, 1, 1, '5.00', '2.00', '3.00', 'Acebrofylline', 'P1001-6-2018-10-31-5-3-2', 2.00, 'Tablet'),
(7, 'P1001-7', ' Acetaminophen and Codeine', 99, '2018-10-01 16:52:37', 'Active', 2, 200, '2018-09-01', '2018-12-31', 10, 10, 1, 1, '15.23', '14.00', '13.00', ' Acetaminophen and Codeine', 'P1001-7-2018-12-31-15-13-14', 4.00, 'Tablet'),
(8, 'P1001-5', 'citrazin', 1, '2018-10-03 11:38:50', 'Active', 2, 100, '2018-10-01', '2019-04-05', 10, 10, 1, 1, '2.00', '2.50', '1.20', 'citrazin', 'P1001-5-2019-04-05-2-1-2', 0.00, 'Tablet'),
(9, 'P1001-8', 'SBL Relaxhed Drop', 24500, '2018-10-13 13:35:35', 'Active', 2, 5000, '2018-10-13', '2019-01-05', 1, 1, 5, 500, '0.10', '0.09', '0.08', 'SBL Relaxhed Drop', 'P1001-8-2019-01-05-50-40-45', 2.00, 'Liquid'),
(10, 'P1001-9', 'Salactin Paint', 1250, '2018-10-13 15:36:47', 'Active', 2, 2500, '2018-10-13', '2018-11-10', 1, 1, 5, 250, '1.00', '0.98', '0.96', 'Salactin Paint', 'P1001-9-2018-11-10-250-240-245', 2.50, 'Liquid');

-- --------------------------------------------------------

--
-- Table structure for table `tab_registration`
--

CREATE TABLE IF NOT EXISTS `tab_registration` (
  `id` int(10) NOT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_id` int(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `img_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `speciality` int(10) NOT NULL,
  `gender` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imei` int(15) NOT NULL,
  `pc_login` int(10) NOT NULL,
  `mobi_login` int(10) NOT NULL,
  `service_expiry_Date` date NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_registration`
--

INSERT INTO `tab_registration` (`id`, `first_name`, `middle_name`, `last_name`, `user_type`, `email_id`, `password`, `ent_id`, `created_date`, `status`, `img_name`, `mobile_no`, `address`, `speciality`, `gender`, `imei`, `pc_login`, `mobi_login`, `service_expiry_Date`, `username`) VALUES
(1, 'Basanagouda', 'D', 'Patil', '1', 'basupatil71@gmail.com', 'NzI1OTk5OTI4Mg==', 1, '2018-07-31 10:56:03', 'Active', 'Capture.jpg', '7259999282', 'H.No 336/2C Neelambhika Nivas\r\nQuality Buildings Panth nagar \r\nPanth Balekundri BK Belgaum - 591103\r\nState - Karnataka', 29, 'Male', 1, 0, 0, '2120-06-25', 'basupatil71'),
(2, 'Vinod', '', 'Kadolli', '2', 'vinod@gmail.com', 'OTk2NDU0Njc0OQ==', 1001, '2018-08-11 17:43:13', 'Active', 'Capture.jpg', '9964546749', 'Shivaji Nagar\r\nBelagavi', 3, 'Male', 0, 1, 1, '2019-01-01', 'vinod123');

-- --------------------------------------------------------

--
-- Table structure for table `tab_series`
--

CREATE TABLE IF NOT EXISTS `tab_series` (
  `id` int(100) NOT NULL,
  `series_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `continues_count` int(100) NOT NULL,
  `last_updated` date NOT NULL,
  `user_id` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_series`
--

INSERT INTO `tab_series` (`id`, `series_id`, `continues_count`, `last_updated`, `user_id`) VALUES
(1, 'P', 10, '2018-10-13', 1001),
(2, '#I', 6, '2018-10-15', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `tab_speciality`
--

CREATE TABLE IF NOT EXISTS `tab_speciality` (
  `id` int(10) NOT NULL,
  `speciality` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `abtspeciality` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_speciality`
--

INSERT INTO `tab_speciality` (`id`, `speciality`, `abtspeciality`) VALUES
(1, 'Allergist or Immunologist', 'Conducts the diagnosis and treatment of allergic conditions.'),
(2, 'Anesthesiologist', 'Treats chronic pain syndromes; administers anesthesia and monitors the patient during surgery.'),
(3, 'Cardiologist', 'Treats heart disease'),
(4, 'Dermatologist', 'Treats skin diseases, including some skin cancers'),
(5, 'Gastroenterologist', 'Treats stomach disorders'),
(6, 'Hematologist or Oncologist ', 'Treats diseases of the blood and blood-forming tissues (oncology including cancer and other tumors)'),
(7, 'Internal Medicine Physician', 'Treats diseases and disorders of internal structures of the body.'),
(8, 'Nephrologist', 'Treats kidney diseases.'),
(9, 'Neurologist', 'Treats diseases and disorders of the nervous system.'),
(10, 'Neurosurgeon', 'Conducts surgery of the nervous system.'),
(11, 'Obstetrician', 'Treats women during pregnancy and childbirth'),
(12, 'Gynecologist', 'Treats diseases of the female reproductive system and genital tract.'),
(13, 'Nurse Midwifery', 'Manages a woman''s health care, especially during pregnancy, delivery, and the postpartum period.'),
(14, 'Occupational Medicine Physician', 'Diagnoses and treats work-related disease or injury.'),
(15, 'Ophthalmologist', 'Treats eye defects, injuries, and diseases.'),
(16, 'Oral and Maxillofacial Surgeon', 'Surgically treats diseases, injuries, and defects of the hard and soft tissues of the face, mouth, and jaws.'),
(17, 'Orthopedic Surgeon', 'Preserves and restores the function of the musculoskeletal system.'),
(18, 'Otolaryngologist (Head and Neck Surgeon) ', 'Treats diseases of the ear, nose, and throat,and some diseases of the head and neck, including facial plastic surgery.'),
(19, 'Pathologist ', 'Diagnoses and treats the study of the changes in body tissues and organs which cause or are caused by disease'),
(20, 'Pediatrician', 'Treats infants, toddlers, children and teenagers.'),
(21, 'Plastic Surgeon', 'Restores, reconstructs, corrects or improves in the shape and appearance of damaged body structures, especially the face.'),
(22, 'Podiatrist', 'Provides medical and surgical treatment of the foot.'),
(23, 'Psychiatrist', 'Treats patients with mental and emotional disorders.'),
(24, 'Pulmonary Medicine Physician', 'Diagnoses and treats lung disorders.'),
(25, 'Radiation Onconlogist', 'Diagnoses and treats disorders with the use of diagnostic imaging, including X-rays, sound waves, radioactive substances, and magnetic fields.'),
(26, 'Diagnostic Radiologist', 'Diagnoses and medically treats diseases and disorders of internal structures of the body.'),
(27, 'Rheumatologist', 'Treats rheumatic diseases, or conditions characterized by inflammation, soreness and stiffness of muscles, and pain in joints and associated structures'),
(28, 'Urologist', 'Diagnoses and treats the male and female urinary tract and the male reproductive system'),
(29, 'Admin', 'Maintenance of this Application.');

-- --------------------------------------------------------

--
-- Table structure for table `tab_temp_invoice`
--

CREATE TABLE IF NOT EXISTS `tab_temp_invoice` (
  `id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `product_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sale_rate` decimal(65,2) NOT NULL,
  `tax_percent` decimal(65,2) NOT NULL,
  `tax_amount` double(65,2) NOT NULL,
  `product_uom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` int(100) NOT NULL,
  `sub_total` decimal(65,2) NOT NULL,
  `total` double(65,2) NOT NULL,
  `user_id` int(100) NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int(255) NOT NULL,
  `batchno` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tab_temp_invoice`
--

INSERT INTO `tab_temp_invoice` (`id`, `product_id`, `product_code`, `product_name`, `sale_rate`, `tax_percent`, `tax_amount`, `product_uom`, `product_qty`, `sub_total`, `total`, `user_id`, `created_datetime`, `stock`, `batchno`, `product_type`) VALUES
(1, 7, 'P1001-7', ' Acetaminophen and Codeine', '14.00', '4.00', 0.56, 'Pcs', 1, '14.00', 15.00, 2, '2018-10-15 18:02:02', 100, 'P1001-7-2018-12-31-15-13-14', 'Tablet');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
