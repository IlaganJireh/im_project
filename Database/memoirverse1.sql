-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2024 at 02:14 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memoirverse1`
--

-- --------------------------------------------------------

--
-- Table structure for table `diary_entries`
--

DROP TABLE IF EXISTS `diary_entries`;
CREATE TABLE IF NOT EXISTS `diary_entries` (
  `entry_id` char(36) NOT NULL,
  `entry` text NOT NULL,
  `entry_date` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `history_id` char(36) DEFAULT NULL,
  `time_created` datetime NOT NULL,
  `time_updated` datetime NOT NULL,
  `entry_image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diary_entries`
--

INSERT INTO `diary_entries` (`entry_id`, `entry`, `entry_date`, `user_id`, `history_id`, `time_created`, `time_updated`, `entry_image`, `image_url`) VALUES
('51912479-3002-11ef-8ed0-18c04d52362d', 'asd', '2024-06-21 19:13:18', '2', NULL, '2024-06-21 19:13:18', '2024-06-21 19:13:18', NULL, NULL),
('566b659e-3002-11ef-8ed0-18c04d52362d', 'he', '2024-06-21 19:13:26', '2', NULL, '2024-06-21 19:13:26', '2024-06-21 19:13:26', NULL, NULL),
('5b2c56ce-3002-11ef-8ed0-18c04d52362d', 'ye', '2024-06-21 19:13:34', '2', NULL, '2024-06-21 19:13:34', '2024-06-21 19:13:34', NULL, NULL),
('72856d54-3005-11ef-8ed0-18c04d52362d', 'asd', '2024-06-21 19:35:42', '2', NULL, '2024-06-21 19:35:42', '2024-06-21 19:35:42', NULL, NULL),
('759571dd-3005-11ef-8ed0-18c04d52362d', 'adsasd', '2024-06-21 19:35:47', '2', NULL, '2024-06-21 19:35:47', '2024-06-21 19:35:47', NULL, NULL),
('79196e9a-3005-11ef-8ed0-18c04d52362d', 'YE', '2024-06-21 19:35:53', '2', NULL, '2024-06-21 19:35:53', '2024-06-21 19:35:53', NULL, NULL),
('e47f637a-3005-11ef-8ed0-18c04d52362d', 'asd', '2024-06-21 19:38:53', '2', NULL, '2024-06-21 19:38:53', '2024-06-21 19:38:53', NULL, NULL),
('838842c8-3006-11ef-8ed0-18c04d52362d', 'asd', '2024-06-21 19:43:20', '2', NULL, '2024-06-21 19:43:20', '2024-06-21 19:43:20', '', NULL),
('868a5664-3006-11ef-8ed0-18c04d52362d', 'yes', '2024-06-21 19:43:25', '2', NULL, '2024-06-21 19:43:25', '2024-06-21 19:43:25', '', NULL),
('8a994ee2-3006-11ef-8ed0-18c04d52362d', 'ads', '2024-06-21 19:43:32', '2', NULL, '2024-06-21 19:43:32', '2024-06-21 19:43:32', 'uploads/img_6675d7e47a57b.jpg', NULL),
('9a68827d-3006-11ef-8ed0-18c04d52362d', 'DENZEL PUTANG INA MO', '2024-06-21 19:43:59', '2', NULL, '2024-06-21 19:43:59', '2024-06-21 19:43:59', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mood`
--

DROP TABLE IF EXISTS `mood`;
CREATE TABLE IF NOT EXISTS `mood` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mood_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mood` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `reset_token_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `time_created` timestamp NOT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `lastName`, `firstName`, `password`, `dob`, `reset_token_hash`, `reset_token_expires_at`, `time_created`, `time_updated`) VALUES
(1, '', 'trinidadkianleeb@gmail.com', 'trinidad', 'kian lee', '$2y$10$PI488G2xmuAjj9jypSh6gOK25l1B63rbrCQuKgIxK7/P9yhjIZxGa', '2004-08-10', NULL, NULL, '0000-00-00 00:00:00', '2024-06-13 11:49:12'),
(2, '', 'nigga@g', 'Escuro', '123', '$2y$10$n0ecn4JGX2Gmm5vXWFvrCeOZEt07enQ7xO/UiySo.sN05/ALVkP6y', '1111-11-11', NULL, NULL, '0000-00-00 00:00:00', '2024-06-14 20:58:38'),
(3, '', 'yehey@gmail.com', '123', '123', '$2y$10$XMYQcIlf6Wk0Vpe1B4YIGuTt.Q.SqAR0PNmqQ3AJY8GVfLkrCEVuy', '1111-11-11', NULL, NULL, '0000-00-00 00:00:00', '2024-06-15 07:33:45'),
(4, '', '1@gmail', 'Escuro123', '1123', '$2y$10$FTIx0x75h0q6ZDqkfFGqYOA4xZIAvqwQlgJBpZUxiC6hopUq1JpFS', '1111-11-11', NULL, NULL, '0000-00-00 00:00:00', '2024-06-21 19:50:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
