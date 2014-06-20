-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 20, 2014 at 05:43 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `codesnippet`
--

-- --------------------------------------------------------

--
-- Table structure for table `code`
--

CREATE TABLE `code` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `code`
--

INSERT INTO `code` (`code_id`, `description`, `title`, `deleted`, `date_created`) VALUES
(1, 'test2', 'test', 0, '2014-06-20 10:40:23'),
(2, 'test2', 'test', 0, '2014-06-20 10:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `code_revision`
--

CREATE TABLE `code_revision` (
  `code_revision_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code_id` int(11) NOT NULL,
  `rev` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`code_revision_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `code_id` (`code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_to_code`
--

CREATE TABLE `tag_to_code` (
  `tag_to_code_id` int(11) NOT NULL AUTO_INCREMENT,
  `code_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deleted_by_user_id` int(11) NOT NULL,
  `date_deleted` datetime NOT NULL,
  PRIMARY KEY (`tag_to_code_id`),
  UNIQUE KEY `deleted_by_user_id` (`deleted_by_user_id`),
  KEY `code_id` (`code_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_last_login` datetime NOT NULL,
  PRIMARY KEY (`user_Id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_Id`, `username`, `email`, `first_name`, `last_name`, `password`, `deleted`, `date_created`, `date_last_login`) VALUES
(1, 'pvienneau', 'pvienneau@carbure.co', 'Patrick', 'Vienneau', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 0, '2014-06-20 00:00:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `code_revision`
--
ALTER TABLE `code_revision`
  ADD CONSTRAINT `code_revision_ibfk_2` FOREIGN KEY (`code_id`) REFERENCES `code` (`code_id`),
  ADD CONSTRAINT `code_revision_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_Id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_Id`);

--
-- Constraints for table `tag_to_code`
--
ALTER TABLE `tag_to_code`
  ADD CONSTRAINT `tag_to_code_ibfk_2` FOREIGN KEY (`deleted_by_user_id`) REFERENCES `user` (`user_Id`),
  ADD CONSTRAINT `tag_to_code_ibfk_1` FOREIGN KEY (`code_id`) REFERENCES `code` (`code_id`);
