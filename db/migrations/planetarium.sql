-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2020 at 01:19 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `mod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `celestialbodies`
--

CREATE TABLE `celestialbodies` (
  `body_ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `spectral_type` char(1) COLLATE utf8_polish_ci NOT NULL,
  `approx_size` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `distance` float NOT NULL,
  `primary_approval_id` int(11) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `reviewer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_content` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forumposts`
--

CREATE TABLE `forumposts` (
  `post_ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_content` varchar(2555) COLLATE utf8_polish_ci NOT NULL,
  `post_date` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `body_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `gallery_ID` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`gallery_ID`, `post_id`) VALUES
(1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_ID` int(11) NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_ID`, `gallery_id`, `image_name`, `image_path`) VALUES
(1, 0, 'blank_avatar.jpg', '/img/blank_avatar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_ID` int(11) NOT NULL,
  `user_role` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_ID`, `user_role`) VALUES
(1, 'admin'),
(2, 'mod'),
(3, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `user_login` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_img` int(11) DEFAULT NULL,
  `user_hash` varbinary(255) NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_ID`),
  ADD KEY `mod_id` (`mod_id`);

--
-- Indexes for table `celestialbodies`
--
ALTER TABLE `celestialbodies`
  ADD PRIMARY KEY (`body_ID`),
  ADD KEY `reviewer` (`reviewer`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forumposts`
--
ALTER TABLE `forumposts`
  ADD PRIMARY KEY (`post_ID`),
  ADD KEY `user_id` (`user_id`,`category_id`,`body_id`),
  ADD KEY `ForumPosts_ibfk_1` (`body_id`),
  ADD KEY `ForumPosts_ibfk_2` (`category_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`gallery_ID`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_ID`),
  ADD KEY `gallery_id` (`gallery_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_img` (`user_img`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `celestialbodies`
--
ALTER TABLE `celestialbodies`
  MODIFY `body_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumposts`
--
ALTER TABLE `forumposts`
  MODIFY `post_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `gallery_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `Categories_ibfk_1` FOREIGN KEY (`mod_id`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `celestialbodies`
--
ALTER TABLE `celestialbodies`
  ADD CONSTRAINT `CelestialBodies_ibfk_1` FOREIGN KEY (`reviewer`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `forumposts` (`post_ID`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `forumposts`
--
ALTER TABLE `forumposts`
  ADD CONSTRAINT `ForumPosts_ibfk_1` FOREIGN KEY (`body_id`) REFERENCES `celestialbodies` (`body_ID`),
  ADD CONSTRAINT `ForumPosts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_ID`),
  ADD CONSTRAINT `ForumPosts_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `Galleries_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `forumposts` (`post_ID`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `Images_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`gallery_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_img` FOREIGN KEY (`user_img`) REFERENCES `images` (`image_ID`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
