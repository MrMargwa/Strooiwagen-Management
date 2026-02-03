-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2026 at 09:50 AM
-- Server version: 8.4.7
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strooiwagen-management-database`
--
CREATE DATABASE IF NOT EXISTS `strooiwagen-management-database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `strooiwagen-management-database`;

-- --------------------------------------------------------

--
-- Table structure for table `roads`
--

DROP TABLE IF EXISTS `road_salting_frequency`;
DROP TABLE IF EXISTS `roads`;
CREATE TABLE `roads` (
  `ID` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `salting_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `road_salting_frequency`
--

CREATE TABLE `road_salting_frequency` (
  `ID` int NOT NULL,
  `road_id` int NOT NULL,
  `temp_min` int NOT NULL,
  `temp_max` int NOT NULL,
  `salting_frequency` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roads`
--

INSERT INTO `roads` (`ID`, `name`, `location`, `salting_time`) VALUES
(1, 'A7', 'Leeuwarden - Groningen', '06:00-22:00'),
(2, 'A31', 'Leeuwarden - Sneek', '06:00-20:00'),
(3, 'N31', 'Dokkum - Harlingen', '07:00-19:00'),
(4, 'N33', 'Assen - Leeuwarden', '06:00-21:00'),
(5, 'N356', 'Sneek - Bolsward', '07:00-18:00'),
(6, 'N359', 'Heerenveen - Kampen', '06:00-20:00'),
(7, 'Herenweg', 'Leeuwarden centrum', '07:00-19:00'),
(8, 'Straatweg', 'Harlingen - Den Hoorn', '07:00-18:00'),
(9, 'Lemsterweg', 'Lemmer - Sneek', '06:30-20:00'),
(10, 'Franeker ringweg', 'Franeker centrum', '07:00-19:00');

--
-- Dumping data for table `road_salting_frequency`
--

INSERT INTO `road_salting_frequency` (`ID`, `road_id`, `temp_min`, `temp_max`, `salting_frequency`) VALUES
(1, 1, -5, 0, 4),
(2, 1, -10, -5, 2),
(3, 2, -5, 0, 3),
(4, 2, -10, -5, 2),
(5, 3, -5, 0, 3),
(6, 3, -10, -5, 2),
(7, 4, -5, 0, 4),
(8, 4, -10, -5, 2),
(9, 5, -5, 0, 2),
(10, 5, -10, -5, 1),
(11, 6, -5, 0, 3),
(12, 6, -10, -5, 2),
(13, 7, -5, 0, 5),
(14, 7, -10, -5, 3),
(15, 8, -5, 0, 2),
(16, 8, -10, -5, 1),
(17, 9, -5, 0, 3),
(18, 9, -10, -5, 2),
(19, 10, -5, 0, 4),
(20, 10, -10, -5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roads`
--
ALTER TABLE `roads`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `road_salting_frequency`
--
ALTER TABLE `road_salting_frequency`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_salting_frequencies_road_id` (`road_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roads`
--
ALTER TABLE `roads`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `road_salting_frequency`
--
ALTER TABLE `road_salting_frequency`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `road_salting_frequency`
--
ALTER TABLE `road_salting_frequency`
  ADD CONSTRAINT `fk_salting_frequencies_road_id` FOREIGN KEY (`road_id`) REFERENCES `roads` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;