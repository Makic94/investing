-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 10, 2021 at 03:03 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investing`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Stock Market'),
(2, 'Cryptocurrency Market'),
(3, 'Options Trading'),
(4, 'Day Trading'),
(5, 'Long-Term Trading'),
(6, 'YOLO Bets');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `user_id`, `comment`, `time`) VALUES
(39, 76, 78, 'First comment test', '2021-03-10 14:59:29'),
(40, 76, 79, 'second comment test', '2021-03-10 15:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsid` int(3) NOT NULL,
  `name` varchar(256) NOT NULL,
  `path` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `newsid`, `name`, `path`) VALUES
(48, 77, 'C:wamp64	mpphp1F4A.tmp', 'tmpuserimages/1615388273.8566.png'),
(47, 76, 'C:wamp64	mpphpD0AC.tmp', 'server/1615388253.7684.png');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` int(3) NOT NULL,
  `author` int(3) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `title` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `category`, `author`, `time`, `deleted`, `text`, `title`) VALUES
(76, 1, 79, '2021-03-10 15:57:33', 0, 'test test test test test test test test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test test', 'Stock Market Wednesday'),
(77, 6, 79, '2021-03-10 15:57:53', 1, 'test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test testtest test test test test test', 'Wall Street Bets');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` enum('owner','user') NOT NULL DEFAULT 'user',
  `gender` varchar(8) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`, `gender`, `date`) VALUES
(79, 'test2', 'test2@gmail.com', '$2y$10$zJb67o6TE84onHYeZiU4Ye.M6dW5O749AHTH/ke.oJJ8hUu0Rt9sa', 'user', 'male', '2021-03-10 14:56:29'),
(78, 'test', 'test@gmail.com', '$2y$10$EXDeS1beFlOf9xBzyc7Pge7wz82n1OGeWDpRnlkQTBBiRtxIEaNHO', 'owner', 'male', '2021-03-10 14:55:21');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vnews`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vnews`;
CREATE TABLE IF NOT EXISTS `vnews` (
`id` int(3) unsigned
,`category` int(3)
,`author` int(3)
,`time` datetime
,`deleted` tinyint(1)
,`text` text
,`title` varchar(30)
,`username` varchar(20)
,`name` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure for view `vnews`
--
DROP TABLE IF EXISTS `vnews`;

DROP VIEW IF EXISTS `vnews`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vnews`  AS  select `news`.`id` AS `id`,`news`.`category` AS `category`,`news`.`author` AS `author`,`news`.`time` AS `time`,`news`.`deleted` AS `deleted`,`news`.`text` AS `text`,`news`.`title` AS `title`,`users`.`username` AS `username`,`categories`.`name` AS `name` from ((`news` join `users` on((`news`.`author` = `users`.`id`))) join `categories` on((`news`.`category` = `categories`.`id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
