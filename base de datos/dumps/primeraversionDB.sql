-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: db.organisado.com.ar
-- Generation Time: Jan 06, 2014 at 08:43 PM
-- Server version: 5.1.56
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `organisado`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `creator` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `gmaps_lat` varchar(45) DEFAULT NULL,
  `gmaps_long` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `events`
--


-- --------------------------------------------------------

--
-- Table structure for table `invitees`
--

DROP TABLE IF EXISTS `invitees`;
CREATE TABLE IF NOT EXISTS `invitees` (
  `email` varchar(255) NOT NULL,
  `event` int(11) NOT NULL,
  PRIMARY KEY (`email`,`event`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invitees`
--


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `name` varchar(255) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_list`
--

DROP TABLE IF EXISTS `item_list`;
CREATE TABLE IF NOT EXISTS `item_list` (
  `item` varchar(255) NOT NULL,
  `event` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`item`,`event`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

DROP TABLE IF EXISTS `organizers`;
CREATE TABLE IF NOT EXISTS `organizers` (
  `email` int(11) NOT NULL,
  `evento` int(11) NOT NULL,
  PRIMARY KEY (`email`,`evento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organizers`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` bit(1) NOT NULL,
  `password_hash` char(32) NOT NULL,
  `enabled` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `first_name`, `last_name`, `birthdate`, `gender`, `password_hash`, `enabled`) VALUES
('leo', 'lacaga', 'San Carlos de Bariloche', '1111-11-11', '\0', '', 0),
('leola@todo', 'Jasmin', 'Iguazu', '1810-05-25', '', '', 0),
('Quintana', 'Farias', 'San Carlos de ', '0000-00-00', '', '', 0),
('tu@vieja', 'Tu Vieja', 'San Carlos de Bariloche', '0000-00-00', '\0', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

DROP TABLE IF EXISTS `wall`;
CREATE TABLE IF NOT EXISTS `wall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `event` varchar(45) NOT NULL,
  `message` varchar(45) NOT NULL,
  `attachment_url` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `wall`
--

COMMIT;
