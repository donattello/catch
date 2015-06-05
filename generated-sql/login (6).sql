-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2015 at 12:35 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_submitting` int(11) DEFAULT NULL,
  `comment_field` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL,
  `event_user_id` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `event_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_place` varchar(120) NOT NULL,
  `event_number_people` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event_user_id`, `event_type`, `event_date`, `event_place`, `event_number_people`) VALUES
(13, 4, 7, '2015-05-06 12:12:00', '', 0),
(14, 4, 1, '2015-05-21 11:22:57', '', 0),
(15, 4, 1, '2015-05-07 23:01:00', '', 0),
(21, 4, 1, '2015-05-31 05:55:00', '', 0),
(22, 4, 16, '2015-05-31 13:25:00', '', 0),
(23, 4, 14, '2015-05-29 12:45:00', '', 0),
(24, 4, 9, '2015-05-28 13:45:00', '', 0),
(25, 4, 1, '2015-05-26 05:59:00', '', 0),
(26, 4, 1, '2015-05-29 05:59:00', '', 0),
(27, 10, 1, '2015-05-28 03:55:00', 'stokwood', 3),
(28, 10, 12, '2015-05-25 07:15:00', 'stokwood', 1),
(29, 4, 10, '2015-05-31 20:00:00', 'stokwood', 1);

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `friend_t_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE IF NOT EXISTS `sport` (
  `id` int(11) NOT NULL,
  `sport` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`id`, `sport`) VALUES
(1, 'Tennis'),
(2, 'Football'),
(4, 'Basketball'),
(7, 'Netball'),
(9, 'Volleyball'),
(10, 'Badminton'),
(12, 'Gym'),
(14, 'Running'),
(16, 'Cycling'),
(18, 'Rugby');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email, unique',
  `bio` text COLLATE utf8_unicode_ci,
  `user_age` int(2) DEFAULT NULL,
  `user_gender` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `bio`, `user_age`, `user_gender`) VALUES
(4, 'martin', '$2y$10$2fgnLPM..UHAY6hLLu6UJ.Wlb49UKlhKEAGHuf79ERnyZUOZ9MJw.', 'test@test.com', 'The first value you see is “400” in both the h1 and the paragraph. I inserted this to make sure that the browser is showing these fonts at the weights that they were meant to be displayed at, and we saw earlier that the intended weight is 400.\r\n\r\nNext, I set the font size followed but the line height. Notice that I didn’t use any sort of units for the line-height, this is a neat trick that will apply a relative line-height that changes with the font-size.\r\n\r\nFinally, I insert the Google fonts and use my own backups because I don’t think you should ever use the default browser choices for “cursive,” which is what Google uses in its snippet.\r\n', 25, 'male'),
(5, 'username', '$2y$10$MP/kO/xOLw8.XNtSlT4tde/8ZyOi/FiAG7lTAin99hgESjNNSo05K', 'kasd@asd.com', NULL, NULL, NULL),
(6, 'kyle', '$2y$10$.RgCqqzrHD2g47./HwBszexKjh8pi4Dm7P4Kv6LpzSi7RcmxjlNuu', 'kylegoslan@me.com', 'test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2 test bio2  ', 29, 'male'),
(7, 'Edward', '$2y$10$23RO7XqA2WsVz64SRX3Mc.EAYczfExorn5oC77RxuSXxRzcbmjI3i', 'edward@hotmail.co.uk', NULL, NULL, NULL),
(8, 'john', '$2y$10$89Pt615R13zno/6rEIOPBO11qMZ60HqbNw5Cp4EFVVP2E7fpxJqJa', 'john@hotmail.co.uk', NULL, NULL, NULL),
(9, 'tom', '$2y$10$.GrToyM8MlpiKsPpeakhfOf5Lwk11/3dvIJ4oNYqkkdE9oQEEhW1W', 'tom@test.com', NULL, NULL, NULL),
(10, 'john123', '$2y$10$68EgXqX6kmMgEnbDllQfo.od8Ot8O6vOz9J8BSbRMK/udTfRkXqNe', 'john123@test.com', NULL, NULL, NULL),
(17, 'dan123', '$2y$10$p3u1z.fVotQL69A9A4WjwOX/THIK/163emDC0dX6KUpGeyr72Befe', 'dan@test.com', 'I am what i am', 35, 'female'),
(18, 'sam', '$2y$10$eN8dWAoQVwPlpe6N3c3P8eOk7zZNNV7b8qVgwdOEQV5M3cOKiT/Su', 'sam@test.com', NULL, NULL, NULL),
(19, 'Mary', '$2y$10$ANZa/t4GUEoDFk9igOgly.SkuqSCF/KPxt5F3/cmiYEQotQyMFKUe', 'mary@test.co.uk', 'test 1234567890', 60, 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_submitting` (`user_submitting`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_user_id` (`event_user_id`),
  ADD KEY `event_type` (`event_type`);

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`friend_t_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `friend_t_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_submitting`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`event_type`) REFERENCES `sport` (`id`);

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
