-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql12.freesqldatabase.com
-- Generation Time: Jan 10, 2025 at 05:49 PM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql12756836`
--

-- --------------------------------------------------------
-- Drop existing tables if they exist
DROP TABLE IF EXISTS user_reports;
DROP TABLE IF EXISTS user_presentations;
DROP TABLE IF EXISTS user_images;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS user_notifications;

--
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `current_login` tinyint(1) DEFAULT '0',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `current_login`, `reset_token`, `reset_token_expiry`) VALUES
(0, 'John', 'John23@gmail.com', '1$aaaaaa', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_images`
--
 CREATE TABLE `user_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `user_images`
--

INSERT INTO `user_images` (`id`, `user_id`, `image_path`, `image_type`) VALUES
(1, 1, 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images\\mrr_by_bu.png', 'MRR by BU'),
(2, 1, 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images\\churn_rate_stacked_bar_chart.png', 'Churn Rate'),
(3, 1, 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images\\revenue_by_product_pie_chart.png', 'Revenue by Product'),
(4, 1, 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images\\sentiment_distribution_bar_chart.png', 'Sentiment Distribution'),
(5, 1, 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images\\wordcloud.png', 'Word Cloud'),
(6, 1, 'static/images/revenue_by_item_currency.png', 'Revenue by Item and Currency'),
(7, 1, 'static/images/revenue_quantity_by_bu.png', 'Revenue and Quantity by BU'),
(8, 1, 'static/images/top_customers_by_revenue.png', 'Top Customers by Revenue'),
(9, 1, 'C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images\\revenue_by_product_bar_chart.png', 'Revenue by Product');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `sender_id`, `receiver_id`, `report_id`, `status`, `created_at`) VALUES
(0, 7, 1, 0, 'accepted', '2025-01-09 23:57:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_presentations`
--

CREATE TABLE `user_presentations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `presentation_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_presentations`
--

INSERT INTO `user_presentations` (`id`, `user_id`, `presentation_path`, `created_at`) VALUES
(0, 1, 'static/presentations/user1_presentation.pptx', '2025-01-10 17:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_reports`
--

CREATE TABLE `user_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `report_pdf` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_reports`
--

INSERT INTO `user_reports` (`id`, `user_id`, `report_path`, `created_at`, `report_pdf`) VALUES
(0, 1, 'static/reports/monthly_report.pdf', '2025-01-09 23:57:09', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
