-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 07:05 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stlukes_admissions`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'dbea80a41684bed3beb7decca3c96e7e');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `kcpe_index` varchar(30) NOT NULL,
  `kcpe_marks` int(11) NOT NULL,
  `county` varchar(50) NOT NULL,
  `is_orphan` tinyint(1) NOT NULL DEFAULT 0,
  `guardian_name` varchar(100) NOT NULL,
  `guardian_phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `applied_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `student_name`, `kcpe_index`, `kcpe_marks`, `county`, `is_orphan`, `guardian_name`, `guardian_phone`, `email`, `applied_at`) VALUES
(1, 'STEPHEN WALUKE', '36621124016', 311, 'Other', 0, 'PETER WALUKETELO', '0112345678', 'WALUKETELO@GMAIL.COM', '2025-11-15 22:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `category` enum('All','Campus','Events','Sports','Academics','Other') NOT NULL DEFAULT 'All',
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `filename`, `caption`, `category`, `uploaded_at`) VALUES
(3, 'img_6918dba2b1dbd.jpg', 'HANDBALL CHAMPIONSHIP CELEBRATION', 'Sports', '2025-11-15 22:59:30'),
(4, 'img_6918dba2ca10f.jpg', 'CERTIFICATE AWARD TO THE HANDBALL COACH , MR OPICHO', 'Sports', '2025-11-15 22:59:30'),
(5, 'img_6918dba2e1661.jpg', 'HANDBALL CHAMPIONSHIP CELEBRATION', 'Sports', '2025-11-15 22:59:30'),
(6, 'img_6918dba2ecf7b.jpg', 'HANDBALL CHAMPIONSHIP CELEBRATION CHIEF PRINCIPAL', 'Sports', '2025-11-15 22:59:30'),
(9, 'img_6918dcd2f23fa.jpg', 'ROBOTICS CODE FESTIVALS CHAMPIONS 2025', 'Academics', '2025-11-15 23:04:34'),
(10, 'img_6918dfea17e2b.jpg', 'tree planting', 'Events', '2025-11-15 23:17:46'),
(11, 'img_6918dfeb23ed9.jpg', 'tree planting', 'Events', '2025-11-15 23:17:47'),
(12, 'img_6918dfeb476f2.jpg', 'tree planting', 'Events', '2025-11-15 23:17:47'),
(13, 'img_6918e1edae60d.jpg', 'ITS ROBOTICS TIME!!', 'All', '2025-11-15 23:26:21'),
(14, 'img_6918e1edbfc62.jpg', 'ITS ROBOTICS TIME!!', 'All', '2025-11-15 23:26:21'),
(15, 'img_6918e1ede3607.jpg', 'ITS ROBOTICS TIME!!', 'All', '2025-11-15 23:26:21'),
(16, 'img_6918e1ee04647.jpg', 'ITS ROBOTICS TIME!!', 'All', '2025-11-15 23:26:22'),
(17, 'img_6919481aa9107.jpg', 'SCOUTS TEAM WITH CHIEF PRINCIPAL AND COACH', 'All', '2025-11-16 06:42:18'),
(18, 'img_6919481adb923.jpg', 'HANDBALL TEAM WITH CHIEF PRINCIPAL AND COACH', 'All', '2025-11-16 06:42:18'),
(19, 'img_69194b124ad43.jpg', '', 'All', '2025-11-16 06:54:58'),
(20, 'img_6919535488cad.jpg', 'ACADEMIC TRIP TO MASENO UNIVERSITY', 'Academics', '2025-11-16 07:30:12'),
(21, 'img_69195396821a9.jpg', 'FILM PRODUCTION  MENTOSHIP PROGRAM', 'Academics', '2025-11-16 07:31:18'),
(22, 'img_69195438b9ed3.jpg', 'KSEF 2024 REGIONAL AWARDS', 'Academics', '2025-11-16 07:34:00'),
(23, 'img_6919546f79385.jpg', 'KIMILILI SUBCOUNTY KSEF CHAMPIONS 2024', 'Academics', '2025-11-16 07:34:55'),
(24, 'img_691954cbd3b7c.jpg', 'CODING TIME', 'Academics', '2025-11-16 07:36:27'),
(25, 'img_69195595778c2.jpg', 'HANDBALL CHAMPS 2025', 'Sports', '2025-11-16 07:39:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
