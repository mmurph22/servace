-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2018 at 01:50 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmurph22`
--

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventid`, `venueid`, `event_name`, `event_description`, `startdate`, `enddate`, `daystarttime`, `dayendtime`, `numstaff`, `badgepoints_pp`) VALUES
(17, 14, 'Housecleaning', 'Need to take out trash and wash for the next season', '2018-07-14', '2018-07-15', '07:00:00', '17:30:00', '8.00', 75),
(18, 14, 'Kids Party', 'For the local kids we will be having a full festival with games and food. Need workers', '2018-08-14', '2018-08-14', '07:30:00', '20:00:00', '24.00', 50),
(19, 15, 'Golf Outing', 'We need caterers as Riverton does not provide any. Multi day event.', '2018-06-10', '2018-06-13', '08:00:00', '15:00:00', '12.00', 125),
(20, 15, 'Home Watch Fest', 'This is an informational session for neighborhoods about home watches. We need setup and breakdown', '2018-02-13', '2018-02-14', '18:30:00', '21:00:00', '4.00', 25);

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venueid`, `venue_name`, `address`, `pocname`, `pocemail`, `pocphone`, `latitude`, `longitude`) VALUES
(14, 'Childrens House', '123 Cherry Yourtown, MD', 'John Houseman', 'jhouseman@servace.org', '444-555-6666', 39.2014, -76.1433),
(15, 'NJ Police Hqs', '123 Smith Road Cinnaminson NJ', 'Sgt Thomas Cater', 'tkater@njsp.org', '444-525-9854', 40, -75);

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`vid`, `firstname`, `lastname`, `email`, `levelid`, `badgepoints`) VALUES
(13, 'Mary', 'Shelley', 'mshelley@gmail.com', '3', 112),
(14, 'Joe', 'Cuban', 'jcuban@usvi.org', '2', 77),
(15, 'Jimmy', 'Noshow', 'jnoshow@slacker.com', '2', 0),
(16, 'Joy', 'Hope', 'hope@gmail.com', '2', 18);

--
-- Dumping data for table `volunteers_events`
--

INSERT INTO `volunteers_events` (`vid`, `eid`, `volperc`, `rating`) VALUES
(13, 17, '100.00', 5),
(14, 17, '50.00', 4),
(14, 20, '100.00', 4),
(15, 17, '100.00', 0),
(16, 20, '100.00', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
