-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 03, 2025 at 02:22 PM
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
-- Database: `c2c_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `cleaner_profiles`
--

CREATE TABLE `cleaner_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `experience` text NOT NULL,
  `preferred_cleaning_time` enum('morning','afternoon','evening') NOT NULL,
  `cleaning_frequency` enum('weekly','biweekly','monthly') NOT NULL,
  `language_preference` enum('english','mandarin','malay','tamil') NOT NULL,
  `expertise` int(11) DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cleaner_profiles`
--

INSERT INTO `cleaner_profiles` (`profile_id`, `user_id`, `phone`, `address`, `experience`, `preferred_cleaning_time`, `cleaning_frequency`, `language_preference`, `expertise`, `rating`, `status`) VALUES
(2, 2, '90908765', 'Sengkang Ave 12', '5 years', 'evening', 'monthly', 'tamil', 1, 5.0, 'active'),
(3, 8, '87651234', 'Clementi Ave 8', '2 years', 'evening', 'monthly', 'mandarin', 3, 3.5, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cleaning_services`
--

CREATE TABLE `cleaning_services` (
  `job_id` int(11) NOT NULL,
  `cleaner_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('offered','suspended') NOT NULL DEFAULT 'offered',
  `views` int(11) NOT NULL DEFAULT 0,
  `shortlisted` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cleaning_services`
--

INSERT INTO `cleaning_services` (`job_id`, `cleaner_id`, `title`, `description`, `price`, `status`, `views`, `shortlisted`, `category_id`) VALUES
(1, 2, 'Dog grooming', 'Stress free & gentle experience', 50.00, 'offered', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `homeowner_id` int(11) NOT NULL,
  `cleaner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`category_id`, `name`, `description`, `status`) VALUES
(1, 'Pet Cleaning', 'Dedicated for all pet lovers', 'active'),
(2, 'Window services', 'Cleaning high-rise windows', 'active'),
(3, 'Sofa Cleaning', 'Deep cleaning for your sofa ', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','cleaner','homeowner','manager') NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Ridhwan Putra', 'RidhwanPutra@gmail.com', 'Pass1234', 'admin', 'active'),
(2, 'Angelica Chand', 'Angelica@gmail.com', 'Pass1234', 'cleaner', 'active'),
(3, 'Phoo', 'Phoo@gmail.com', 'Pass1234', 'homeowner', 'active'),
(4, 'Mei Yuen', 'My@gmail.com', 'Pass1234', 'manager', 'active'),
(5, 'Harshita', 'Harshita@gmail.com', 'Pass1234', 'admin', 'active'),
(8, 'Cleaner2', 'Cleaner2@gmail.com', 'Pass1234', 'cleaner', 'active'),
(9, 'Waldo', 'Waldo@gmail.com', 'Pass1234', 'cleaner', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `address` varchar(50) NOT NULL,
  `preferred_cleaning_time` enum('morning','afternoon','evening') NOT NULL,
  `cleaning_frequency` enum('weekly','biweekly','monthly') NOT NULL,
  `language_preference` enum('english','mandarin','malay','tamil') NOT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`profile_id`, `user_id`, `phone`, `address`, `preferred_cleaning_time`, `cleaning_frequency`, `language_preference`, `status`) VALUES
(1, 1, '90094516', 'Jurong West St 61', 'morning', 'weekly', 'malay', 'active'),
(2, 3, '87651234', 'Boon Lay Drive Ave 7', 'afternoon', 'biweekly', 'english', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cleaner_profiles`
--
ALTER TABLE `cleaner_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_cleaner_profiles_expertise` (`expertise`);

--
-- Indexes for table `cleaning_services`
--
ALTER TABLE `cleaning_services`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `cleaner_id` (`cleaner_id`),
  ADD KEY `cleaning_services_ibfk_2` (`category_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `unique_favorite` (`homeowner_id`,`cleaner_id`),
  ADD KEY `cleaner_id` (`cleaner_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cleaner_profiles`
--
ALTER TABLE `cleaner_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cleaning_services`
--
ALTER TABLE `cleaning_services`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cleaner_profiles`
--
ALTER TABLE `cleaner_profiles`
  ADD CONSTRAINT `cleaner_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cleaner_profiles_expertise` FOREIGN KEY (`expertise`) REFERENCES `service_categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cleaner_profiles_preferred_service_category` FOREIGN KEY (`expertise`) REFERENCES `service_categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `cleaning_services`
--
ALTER TABLE `cleaning_services`
  ADD CONSTRAINT `cleaning_services_ibfk_1` FOREIGN KEY (`cleaner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cleaning_services_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`homeowner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`cleaner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
