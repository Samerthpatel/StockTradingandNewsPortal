-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2022 at 11:22 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deployment`
--

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `id` int NOT NULL,
  `version` text NOT NULL,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stable` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `version`
--

INSERT INTO `version` (`id`, `version`, `type`, `stable`, `date`) VALUES
(1, '1', 'database', 'passing', 'April 26, 2022 11:34:pm'),
(2, '1', 'dmz', 'passing', 'April 27, 2022 12:19:pm'),
(3, '1', 'frontend', 'passing', 'May 1, 2022 9:33:pm'),
(4, '2', 'database', 'passing', 'May 2, 2022 11:45:am'),
(5, '2', 'dmz', 'passing', 'May 2, 2022 11:46:am'),
(6, '2', 'frontend', 'passing', 'May 2, 2022 11:09:pm'),
(7, '3', 'database', 'passing', 'May 2, 2022 11:10:pm'),
(8, '3', 'frontend', 'passing', 'May 2, 2022 11:26:pm'),
(9, '6', 'frontend', 'passing', 'May 3, 2022 12:18:pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
