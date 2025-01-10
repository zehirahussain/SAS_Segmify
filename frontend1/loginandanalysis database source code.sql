-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 02:24 AM
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
-- Database: `loginandanalysis`
--

-- --------------------------------------------------------
-- Drop existing tables if they exist
DROP TABLE IF EXISTS user_reports;
DROP TABLE IF EXISTS user_presentations;
DROP TABLE IF EXISTS user_images;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS user_notifications;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `current_login` tinyint(1) DEFAULT 0,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `current_login`, `reset_token`, `reset_token_expiry`) VALUES
(7, 'ss', 's@s.com', '123', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_images`
--

CREATE TABLE `user_images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_presentations`
--

CREATE TABLE `user_presentations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `presentation_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_presentations`
--

INSERT INTO `user_presentations` (`id`, `user_id`, `presentation_path`, `created_at`) VALUES
(26, 1, 'static/presentations/user1_presentation.pptx', '2024-12-15 00:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_reports`
--

CREATE TABLE `user_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `report_pdf` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reports`
--

INSERT INTO `user_reports` (`id`, `user_id`, `report_path`, `created_at`, `report_pdf`) VALUES
(1, 2, 'static/reports/monthly_report.pdf', '2024-10-19 21:39:10', NULL),
(2, 3, 'static/reports/monthly_report.pdf', '2024-10-19 21:47:02', NULL),
(3, 2, 'static/reports/monthly_report.pdf', '2024-10-19 22:20:21', NULL),
(4, 3, 'static/reports/monthly_report.pdf', '2024-10-19 22:22:24', NULL),
(5, 2, 'static/reports/monthly_report.pdf', '2024-10-19 22:24:57', NULL),
(6, 1, 'static/reports/monthly_report.pdf', '2024-12-14 17:18:49', NULL),
(7, 1, 'static/reports/monthly_report.pdf', '2024-12-14 22:18:59', NULL),
(8, 2, 'static/reports/monthly_report.pdf', '2024-12-14 22:19:51', NULL),
(9, 2, 'static/reports/monthly_report.pdf', '2024-12-14 22:29:14', NULL),
(10, 2, 'static/reports/monthly_report.pdf', '2024-12-14 22:36:53', NULL),
(11, 2, 'static/reports/monthly_report.pdf', '2024-12-14 22:38:24', NULL),
(12, 2, 'static/reports/monthly_report.pdf', '2024-12-14 22:41:26', NULL),
(13, 2, 'static/reports/monthly_report.pdf', '2024-12-14 23:04:57', NULL),
(14, 2, 'static/reports/monthly_report.pdf', '2024-12-15 00:21:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_images`
--
ALTER TABLE `user_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `user_presentations`
--
ALTER TABLE `user_presentations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_images`
--
ALTER TABLE `user_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_presentations`
--
ALTER TABLE `user_presentations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_reports`
--
ALTER TABLE `user_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_images`
--
ALTER TABLE `user_images`
  ADD CONSTRAINT `user_images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_ibfk_3` FOREIGN KEY (`report_id`) REFERENCES `user_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_presentations`
--
ALTER TABLE `user_presentations`
  ADD CONSTRAINT `user_presentations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD CONSTRAINT `user_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
