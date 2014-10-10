-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2014 at 06:03 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `headline`
--

CREATE TABLE IF NOT EXISTS `headline` (
  `headlineId` int(11) NOT NULL,
  `headline` text NOT NULL,
  PRIMARY KEY (`headlineId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapping`
--

CREATE TABLE IF NOT EXISTS `mapping` (
  `urlId` int(11) NOT NULL,
  `headlineId` int(11) NOT NULL,
  `timeCombId` int(11) NOT NULL,
  `sourceId` int(11) NOT NULL,
  PRIMARY KEY (`urlId`,`headlineId`,`timeCombId`,`sourceId`),
  KEY `headlineId` (`headlineId`),
  KEY `timeCombId` (`timeCombId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `timeId` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`timeId`),
  UNIQUE KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timeComb`
--

CREATE TABLE IF NOT EXISTS `timeComb` (
  `timeCombId` int(11) NOT NULL,
  `startDate` int(11) NOT NULL,
  `endDate` int(11) NOT NULL,
  PRIMARY KEY (`timeCombId`),
  KEY `startDate` (`startDate`,`endDate`),
  KEY `endDate` (`endDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `url`
--

CREATE TABLE IF NOT EXISTS `url` (
  `urlId` int(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`urlId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mapping`
--
ALTER TABLE `mapping`
  ADD CONSTRAINT `mapping_ibfk_5` FOREIGN KEY (`urlId`) REFERENCES `url` (`urlId`),
  ADD CONSTRAINT `mapping_ibfk_3` FOREIGN KEY (`timeCombId`) REFERENCES `timeComb` (`timeCombId`),
  ADD CONSTRAINT `mapping_ibfk_4` FOREIGN KEY (`headlineId`) REFERENCES `headline` (`headlineId`);

--
-- Constraints for table `timeComb`
--
ALTER TABLE `timeComb`
  ADD CONSTRAINT `timeComb_ibfk_2` FOREIGN KEY (`endDate`) REFERENCES `time` (`timeId`),
  ADD CONSTRAINT `timeComb_ibfk_1` FOREIGN KEY (`startDate`) REFERENCES `time` (`timeId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
