-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2018 at 01:19 PM
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

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventid`, `venueid`, `event_name`, `event_description`, `startdate`, `enddate`, `daystarttime`, `dayendtime`, `numstaff`, `badgepoints_pp`) VALUES
(1, 1, 'October Hike', 'Event for hikers through the park', '2018-10-20', '2018-10-20', '10:00:00', '17:00:00', '1.00', 50),
(2, 1, 'Fall Harvest', 'Large event for the public', '2018-09-19', '2018-09-22', '10:00:00', '17:00:00', '26.00', 300),
(3, 2, 'Bear Fair', 'Event about Bears', '2018-05-26', '2018-05-27', '10:00:00', '17:00:00', '3.50', 150),
(4, 2, 'Arsinec', 'Something acrid is coming', '2018-08-11', '2018-09-08', '21:00:00', '23:00:00', '0.00', 240),
(5, 1, 'testing event', 'to see what saves', '2018-04-26', '2018-05-04', '14:00:00', '17:00:00', '6.00', 25),
(6, 2, 'Bear test 2', 'Event to find the venue', '2018-03-06', '2018-03-08', '09:00:00', '00:00:00', '15.00', 100),
(7, 2, 'Test Event', 'undefined q is unknown but may save', '2018-05-19', '2018-05-20', '06:00:00', '12:00:00', '9.00', 400),
(8, 2, 'Logans Birthday Party', 'He is going to be 12', '2018-07-28', '2018-07-28', '12:00:00', '17:00:00', '2.50', 75),
(9, 3, 'Kids Party', 'Birthdays for all and beach', '2018-07-28', '2018-07-31', '12:00:00', '15:00:00', '2.50', 200),
(10, 1, 'Another Tea', 'A chance for the Director to dance in public', '2018-07-07', '2018-07-07', '15:00:00', '19:00:00', '2.00', 50),
(11, 5, 'fooinig around', 'just whta this says', '2018-05-12', '2018-05-13', '07:00:00', '12:00:00', '3.00', 200),
(12, 7, 'Flowers and Stuff', 'A bunch of flowers and people sneezing in fancy gardens', '2018-05-20', '2018-05-21', '10:30:00', '17:00:00', '4.00', 125),
(13, 8, 'Books and old stuff', 'Contemplaqting the value of those old things call books', '2018-07-12', '2018-07-13', '17:00:00', '19:00:00', '2.00', 25),
(14, 11, 'Putts Against Butts', 'An event to stop smokling in Central MD', '2018-06-13', '2018-06-14', '07:30:00', '16:00:00', '8.00', 100),
(15, 12, 'Hoe Down', 'Looking for a few Hoes to have good ol time pickin and grinnin', '2018-09-13', '2018-09-15', '08:00:00', '18:00:00', '24.00', 150),
(16, 13, 'Basketball Game', 'Need Crowd control for these jackals', '2018-05-16', '2018-05-16', '18:30:00', '22:00:00', '16.00', 50);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

DROP TABLE IF EXISTS `logins`;
CREATE TABLE IF NOT EXISTS `logins` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `userpwd` varchar(20) DEFAULT NULL,
  `roleid` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  KEY `fk_roles` (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`userid`, `username`, `userpwd`, `roleid`) VALUES
(7, 'jbuck', 'pwdjb', 2),
(8, 'mmurph22', 'pwd', 2),
(10, 'lam', 'default', 3);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleid`, `rolename`) VALUES
(1, 'Administrator'),
(2, 'Volunteer'),
(3, 'Coordinator');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `taskid` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) DEFAULT NULL,
  `task_name` varchar(60) DEFAULT NULL,
  `task_description` text,
  `numstaff` decimal(6,2) NOT NULL DEFAULT '1.00',
  `eventperc` decimal(6,2) NOT NULL DEFAULT '1.00',
  `badgepoints` int(16) DEFAULT NULL,
  PRIMARY KEY (`taskid`),
  KEY `fk_task_event` (`eventid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskid`, `eventid`, `task_name`, `task_description`, `numstaff`, `eventperc`, `badgepoints`) VALUES
(1, 1, 'Setup Parking', 'Rope off parking area', '3.00', '20.00', 10),
(2, 1, 'Monitor Parking', 'direct traffic in and out', '2.00', '80.00', 100);

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
  `loginid` int(11) NOT NULL,
  PRIMARY KEY (`venueid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venueid`, `venue_name`, `address`, `pocname`, `pocemail`, `pocphone`, `latitude`, `longitude`, `loginid`) VALUES
(1, 'Steppingstone Museum', '461 Quaker Bottom Rd Havre De Grace MD 21078', 'Lara Murphy', 'director@steppingstonemuseum.com', '609-330-9092', 39.6012, -76.1396, 0),
(2, 'My Place', '2823 Orchard Lakes Drive Baldwin MD', 'Logan Murphy', 'logan_murphy@comcast.net', '856-261-5829', 39.5336, -76.4857, 10),
(3, 'Casa De La Nana', '9 W Bayberry St Peahala Pk NJ ', 'Anne Simpson', 'asimpson@comcast.net', '444-555-8748', 39.6049, -74.2103, 0),
(4, 'Fallston High School', 'Caars Mill Road Fallston', 'J Sallinger', 'fake@id.org', '444-333-2222', 39.564, -74.562, 0),
(5, 'foo', 'bar', 'me', 'me@you.org', 'ssdlkkl', 40, -75, 0),
(6, 'Bel Air High School', 'Maitland Avenue Bel Air MD', 'Jerry Smith', 'jsmith@someschool.org', '111-222-5465', 38.6966, -76.5522, 0),
(7, 'Ladew Topiary Gardens', '3535 Jarrettsville Pike, monkton, MD 21111', 'Joe Friendly', 'joef@mail.com', '443-334-4433', 39.5808, -76.5135, 0),
(8, 'Towson U', 'Towson MD', 'Bob Fly', 'bfly@guy.org', '444-777-8888', 39.393, -76.6089, 0),
(9, 'Camden Yards', 'Eutaw St Baltimore MD', 'Boog Powell', 'boogbeef@piggy.org', '544-522-4521', 39.2848, -76.6212, 0),
(10, 'Aberdeen Proving Ground', 'MarylaBlvd, APG, 21005', 'SSgt Russell Cox', 'rcox@mail.mil', '334-524-5214', 39.4844, -76.1433, 0),
(11, 'Montgomery Golf Club', '20908 Golf View Dr Laytonsville,MD', 'Johhny Cash', 'jcash@mib.com', '444-867-5309', 39.2014, -77.1314, 0),
(12, 'Avondale Farms', 'Avondale Road, Westminster, MD', 'Ulysses Pickem', 'upickem@mdfarms.org', '323-525-4584', 39.5651, -77.0438, 0),
(13, 'Bel Air HIGh School', 'Maitlans St Bel Air MD', 'Jen Quincy', 'jquin@bahs.org', '444-444-4444', 39.5319, -76.3466, 0);

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
  `loginid` int(11) NOT NULL,
  PRIMARY KEY (`vid`),
  KEY `fk_volunteers_levels` (`levelid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 CHECKSUM=1;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`vid`, `firstname`, `lastname`, `email`, `levelid`, `badgepoints`, `loginid`) VALUES
(1, 'Mike', 'Murphy', 'm.p.m@comcast.net', 'A', 1779, 8),
(2, 'Baby', 'Jane', 'bj@rockabye.org', 'J', 965, 0),
(3, 'John', 'Brown', 'jbrown@crazyeight.net', '2', 0, 0),
(4, 'Joseph', 'RockingMan', 'rock@man.org', '10', 851, 0),
(5, 'Kaiser', 'Soze', 'ksoze@comcast.net', '6', 400, 0),
(6, 'Selma', 'Chocolate', 'schoc@oasis.org', '7', 562, 0),
(7, 'Joe', 'Smiley', 'jsmile@eyeore.com', '4', 223, 0),
(8, 'Charlie', 'Brown', 'cbrown@peanuts.com', '2', 0, 0),
(9, 'Logan', 'Murphy', 'logan_murphy@comcast.net', '2', 75, 0),
(10, 'Joe', 'Blow', 'jblow@bubble.org', 'A', 2666, 0),
(11, 'Mike', 'Tyson', 'mtyson@bityourear.com', '3', 124, 0),
(12, 'Major', 'Tom', 'mtom@blackstar.com', '2', 75, 0),
(13, 'Joe', 'Buck', 'jb@buck.org', '2', 0, 7);

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
-- Dumping data for table `volunteers_events`
--

INSERT INTO `volunteers_events` (`vid`, `eid`, `volperc`, `rating`) VALUES
(1, 2, '100.00', 5),
(1, 7, '100.00', 5),
(1, 8, '75.00', 5),
(1, 9, '100.00', 0),
(1, 15, '100.00', 0),
(2, 2, '100.00', 5),
(2, 3, '50.00', 0),
(2, 5, '100.00', 0),
(2, 7, '50.00', 0),
(2, 8, '100.00', 0),
(2, 15, '100.00', 0),
(2, 16, '50.00', 5),
(3, 5, '100.00', 0),
(3, 14, '100.00', 0),
(3, 15, '100.00', 0),
(4, 3, '100.00', 0),
(4, 7, '50.00', 0),
(4, 15, '100.00', 0),
(5, 2, '100.00', 0),
(5, 6, '100.00', 0),
(5, 11, '100.00', 3),
(5, 15, '100.00', 0),
(6, 3, '100.00', 0),
(6, 5, '50.00', 0),
(6, 8, '55.00', 0),
(6, 11, '75.00', 0),
(6, 15, '100.00', 0),
(7, 3, '50.00', 5),
(7, 13, '50.00', 5),
(7, 15, '100.00', 0),
(7, 16, '100.00', 5),
(8, 5, '100.00', 0),
(8, 7, '100.00', 0),
(8, 9, '100.00', 0),
(8, 11, '100.00', 0),
(8, 13, '100.00', 0),
(8, 14, '100.00', 0),
(8, 15, '100.00', 0),
(9, 9, '100.00', 0),
(9, 15, '100.00', 0),
(9, 16, '100.00', 5),
(10, 3, '50.00', 0),
(10, 5, '100.00', 0),
(10, 6, '100.00', 0),
(10, 7, '100.00', 5),
(10, 10, '100.00', 0),
(10, 12, '100.00', 5),
(10, 13, '50.00', 5),
(10, 14, '100.00', 5),
(10, 15, '100.00', 0),
(11, 14, '50.00', 4),
(11, 15, '100.00', 0),
(12, 1, '100.00', 0),
(12, 10, '100.00', 0),
(12, 11, '100.00', 0),
(12, 15, '100.00', 0),
(12, 16, '100.00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers_tasks`
--

DROP TABLE IF EXISTS `volunteers_tasks`;
CREATE TABLE IF NOT EXISTS `volunteers_tasks` (
  `vid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `taskperc` decimal(6,2) DEFAULT NULL,
  `rating` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`vid`,`tid`),
  KEY `fk_table_t` (`tid`),
  KEY `fk_table_vid` (`vid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteers_tasks`
--

INSERT INTO `volunteers_tasks` (`vid`, `tid`, `taskperc`, `rating`) VALUES
(1, 2, '100.00', 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_venues` FOREIGN KEY (`venueid`) REFERENCES `venues` (`venueid`);

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `fk_roles` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`);

--
-- Constraints for table `volunteers_events`
--
ALTER TABLE `volunteers_events`
  ADD CONSTRAINT `fk_events` FOREIGN KEY (`eid`) REFERENCES `events` (`eventid`),
  ADD CONSTRAINT `fk_vols` FOREIGN KEY (`vid`) REFERENCES `volunteers` (`vid`);

--
-- Constraints for table `volunteers_tasks`
--
ALTER TABLE `volunteers_tasks`
  ADD CONSTRAINT `fk_table_t` FOREIGN KEY (`tid`) REFERENCES `tasks` (`taskid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
