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
(1, 'A6', 'Joure', '22'),
(2, 'A7', 'Sneek', '90'),
(3, 'A31', 'Harlingen', '24'),
(4, 'A32', 'Heerenveen', '66'),
(5, 'N31', 'Leeuwarden', '40'),
(6, 'N351', 'Wolvega', '32'),
(7, 'N354', 'Sneek', '30'),
(8, 'N355', 'Buitenpost', '38'),
(9, 'N356', 'Dokkum', '36'),
(10, 'N357', 'Stiens', '25');

INSERT INTO `road_salting_frequency` (`ID`, `road_id`, `temp_min`, `temp_max`, `salting_frequency`) VALUES
(1, 1, -5, 0, 1),
(2, 1, -10, -5, 2),
(3, 1, -15, -10, 3),

(4, 2, -5, 0, 1),
(5, 2, -10, -5, 2),
(6, 2, -15, -10, 3),

(7, 3, -5, 0, 1),
(8, 3, -10, -5, 2),
(9, 3, -15, -10, 3),

(10, 4, -5, 0, 1),
(11, 4, -10, -5, 2),
(12, 4, -15, -10, 3),

(13, 5, -5, 0, 1),
(14, 5, -10, -5, 2),
(15, 5, -15, -10, 3),

(16, 6, -5, 0, 1),
(17, 6, -10, -5, 2),
(18, 6, -15, -10, 3),

(19, 7, -5, 0, 1),
(20, 7, -10, -5, 2),
(21, 7, -15, -10, 3),

(22, 8, -5, 0, 1),
(23, 8, -10, -5, 2),
(24, 8, -15, -10, 3),

(25, 9, -5, 0, 1),
(26, 9, -10, -5, 2),
(27, 9, -15, -10, 3),

(28, 10, -5, 0, 1),
(29, 10, -10, -5, 2),
(30, 10, -15, -10, 3);

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