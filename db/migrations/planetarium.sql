-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2020 at 06:43 PM
-- Server version: 8.0.22-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `planetarium`
--

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `category_ID` int NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `mod_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CelestialBodies`
--

CREATE TABLE `CelestialBodies` (
  `body_ID` int NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `spectral_type` char(1) COLLATE utf8_polish_ci NOT NULL,
  `approx_size` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `distance` float NOT NULL,
  `primary_approval_id` int NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `reviewer` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `comment_id` int NOT NULL,
  `post_id` int NOT NULL,
  `post_type` int NOT NULL,
  `user_id` int NOT NULL,
  `comment_content` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ForumPosts`
--

CREATE TABLE `ForumPosts` (
  `post_ID` int NOT NULL,
  `user_id` int NOT NULL,
  `post_content` varchar(2555) COLLATE utf8_polish_ci NOT NULL,
  `post_date` date NOT NULL,
  `category_id` int NOT NULL,
  `body_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Galleries`
--

CREATE TABLE `Galleries` (
  `gallery_ID` int NOT NULL,
  `post_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE `Images` (
  `image_ID` int NOT NULL,
  `gallery_id` int NOT NULL,
  `image_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `role_ID` int NOT NULL,
  `user_role` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_ID` int NOT NULL,
  `user_login` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `role_id` int NOT NULL,
  `user_img` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `user_hash` varbinary(255) NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_ID`),
  ADD KEY `mod_id` (`mod_id`);

--
-- Indexes for table `CelestialBodies`
--
ALTER TABLE `CelestialBodies`
  ADD PRIMARY KEY (`body_ID`),
  ADD KEY `reviewer` (`reviewer`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ForumPosts`
--
ALTER TABLE `ForumPosts`
  ADD PRIMARY KEY (`post_ID`),
  ADD KEY `user_id` (`user_id`,`category_id`,`body_id`),
  ADD KEY `ForumPosts_ibfk_1` (`body_id`),
  ADD KEY `ForumPosts_ibfk_2` (`category_id`);

--
-- Indexes for table `Galleries`
--
ALTER TABLE `Galleries`
  ADD PRIMARY KEY (`gallery_ID`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`image_ID`),
  ADD KEY `gallery_id` (`gallery_id`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`role_ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CelestialBodies`
--
ALTER TABLE `CelestialBodies`
  MODIFY `body_ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumPosts`
--
ALTER TABLE `ForumPosts`
  MODIFY `post_ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Roles`
--
ALTER TABLE `Roles`
  MODIFY `role_ID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Categories`
--
ALTER TABLE `Categories`
  ADD CONSTRAINT `Categories_ibfk_1` FOREIGN KEY (`mod_id`) REFERENCES `Users` (`user_ID`);

--
-- Constraints for table `CelestialBodies`
--
ALTER TABLE `CelestialBodies`
  ADD CONSTRAINT `CelestialBodies_ibfk_1` FOREIGN KEY (`reviewer`) REFERENCES `Users` (`user_ID`);

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `ForumPosts` (`post_ID`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_ID`);

--
-- Constraints for table `ForumPosts`
--
ALTER TABLE `ForumPosts`
  ADD CONSTRAINT `ForumPosts_ibfk_1` FOREIGN KEY (`body_id`) REFERENCES `CelestialBodies` (`body_ID`),
  ADD CONSTRAINT `ForumPosts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_ID`),
  ADD CONSTRAINT `ForumPosts_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_ID`);

--
-- Constraints for table `Galleries`
--
ALTER TABLE `Galleries`
  ADD CONSTRAINT `Galleries_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `ForumPosts` (`post_ID`);

--
-- Constraints for table `Images`
--
ALTER TABLE `Images`
  ADD CONSTRAINT `Images_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `Galleries` (`gallery_ID`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`role_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
