-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2018 at 01:21 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sandbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT,
  `venueid` int(11) DEFAULT NULL,
  `event_name` varchar(40) DEFAULT NULL,
  `event_description` text,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `daystarttime` time DEFAULT NULL,
  `dayendtime` time DEFAULT NULL,
  `numstaff` decimal(6,2) DEFAULT '1.00',
  `badgepoints_pp` int(16) DEFAULT '1',
  PRIMARY KEY (`eventid`),
  KEY `fk_venues` (`venueid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
CREATE TABLE IF NOT EXISTS `venues` (
  `venueid` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  `pocname` varchar(60) DEFAULT NULL,
  `pocemail` varchar(60) DEFAULT NULL,
  `pocphone` varchar(20) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  PRIMARY KEY (`venueid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

DROP TABLE IF EXISTS `volunteers`;
CREATE TABLE IF NOT EXISTS `volunteers` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `levelid` enum('2','3','4','5','6','7','8','9','10','J','Q','K','A') NOT NULL DEFAULT '2',
  `badgepoints` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`),
  KEY `fk_volunteers_levels` (`levelid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 CHECKSUM=1;

-- --------------------------------------------------------

--
-- Table structure for table `volunteers_events`
--

DROP TABLE IF EXISTS `volunteers_events`;
CREATE TABLE IF NOT EXISTS `volunteers_events` (
  `vid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `volperc` decimal(6,2) DEFAULT '100.00',
  `rating` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`vid`,`eid`),
  KEY `fk_events` (`eid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_venues` FOREIGN KEY (`venueid`) REFERENCES `venues` (`venueid`);

--
-- Constraints for table `volunteers_events`
--
ALTER TABLE `volunteers_events`
  ADD CONSTRAINT `fk_events` FOREIGN KEY (`eid`) REFERENCES `events` (`eventid`),
  ADD CONSTRAINT `fk_vols` FOREIGN KEY (`vid`) REFERENCES `volunteers` (`vid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
