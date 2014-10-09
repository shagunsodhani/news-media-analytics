-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2014 at 02:25 AM
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
  `urlId` int(11) NOT NULL,
  `headline` text NOT NULL,
  PRIMARY KEY (`urlId`),
  UNIQUE KEY `urlId_3` (`urlId`),
  KEY `urlId` (`urlId`),
  KEY `urlId_2` (`urlId`),
  KEY `urlId_4` (`urlId`),
  KEY `urlId_5` (`urlId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `urlId` int(11) NOT NULL,
  `sourceId` int(11) NOT NULL,
  `timeCombId` int(11) NOT NULL,
  PRIMARY KEY (`urlId`,`sourceId`),
  KEY `timeCombId` (`timeCombId`),
  KEY `urlId` (`urlId`),
  KEY `sourceId` (`sourceId`),
  KEY `timeCombId_2` (`timeCombId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `timeId` int(11) NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`timeId`),
  KEY `timeId` (`timeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timeComb`
--

CREATE TABLE IF NOT EXISTS `timeComb` (
  `timeCombID` int(11) NOT NULL,
  `startDate` int(11) NOT NULL,
  `endDate` int(11) NOT NULL,
  PRIMARY KEY (`timeCombID`),
  KEY `endDate` (`endDate`),
  KEY `startDate` (`startDate`),
  KEY `timeCombID` (`timeCombID`),
  KEY `timeCombID_2` (`timeCombID`),
  KEY `endDate_2` (`endDate`),
  KEY `startDate_2` (`startDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `urlId` int(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`urlId`),
  KEY `urlId` (`urlId`),
  KEY `urlId_2` (`urlId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `source`
--
ALTER TABLE `source`
  ADD CONSTRAINT `source_ibfk_1` FOREIGN KEY (`urlId`) REFERENCES `urls` (`urlId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
