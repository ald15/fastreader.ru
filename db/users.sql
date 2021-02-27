-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 26, 2021 at 08:05 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_p`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `best_speed` int(11) NOT NULL DEFAULT '0',
  `avatar` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user_avatar_1.png',
  `rank` varchar(255) NOT NULL DEFAULT 'Новичок',
  `level` int(11) NOT NULL DEFAULT '1',
  `xp` int(11) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL DEFAULT '0',
  `about_me` char(255) NOT NULL DEFAULT 'Всем привет! Я новый пользователь Fast Reader',
  `last_speed` int(11) NOT NULL DEFAULT '0',
  `daily_speed` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `c_email` int(1) NOT NULL DEFAULT '0',
  `c_about_me` int(1) NOT NULL DEFAULT '1',
  `c_stat` int(1) NOT NULL DEFAULT '1',
  `monthly_speed_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `monthly_speed_date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `reg_date` char(10) NOT NULL,
  `ex_stat` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `best_speed`, `avatar`, `rank`, `level`, `xp`, `admin`, `about_me`, `last_speed`, `daily_speed`, `c_email`, `c_about_me`, `c_stat`, `monthly_speed_value`, `monthly_speed_date`, `reg_date`, `ex_stat`) VALUES
(40, 'example1', 'example1@fastreader.ru', '$2y$10$LUIrQ2JLLXk/5ZCdji0hmORTSC/MkwE98s9DqplwxgBpYAO9X9TjG', 0, 'user_avatar_1.png', 'Новичок', 1, 0, 0, 'Всем привет! Я новый пользователь Fast Reader', 0, '', 0, 1, 1, '', '', '22.04.2020', '0 0 0 0 0'),
(41, 'example2', 'example2@fastreader.ru', '$2y$10$pa6ONz4xODBqBJiyAqpWRuOqrpNK.X12w2JFSOsoCJWs/utjTW1ya', 0, 'user_avatar_1.png', 'Новичок', 1, 26, 0, 'Всем привет! Я новый пользователь Fast Reader', 0, '', 0, 1, 1, '', '', '22.04.2020', '0 2 0 0 0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
