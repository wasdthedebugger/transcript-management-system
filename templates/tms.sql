-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2023 at 07:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `aggregate_alevels`
--

CREATE TABLE `aggregate_alevels` (
  `roll_no` varchar(5) NOT NULL,
  `elang` float DEFAULT NULL,
  `general_paper` float DEFAULT NULL,
  `maths` float DEFAULT NULL,
  `physics` float DEFAULT NULL,
  `chemistry` float DEFAULT NULL,
  `business` float DEFAULT NULL,
  `economics` float DEFAULT NULL,
  `further_maths` float DEFAULT NULL,
  `biology` float DEFAULT NULL,
  `computer` float DEFAULT NULL,
  `accounting` float DEFAULT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eleven_neb`
--

CREATE TABLE `eleven_neb` (
  `roll_no` varchar(5) NOT NULL,
  `nepali` float DEFAULT NULL,
  `nepali_pr` float DEFAULT NULL,
  `english` float DEFAULT NULL,
  `english_pr` float DEFAULT NULL,
  `maths` float DEFAULT NULL,
  `maths_pr` float DEFAULT NULL,
  `physics` float DEFAULT NULL,
  `physics_pr` float DEFAULT NULL,
  `chemistry` float DEFAULT NULL,
  `chemistry_pr` float DEFAULT NULL,
  `computer` float DEFAULT NULL,
  `computer_pr` float DEFAULT NULL,
  `biology` float DEFAULT NULL,
  `biology_pr` float DEFAULT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `msauth`
--

CREATE TABLE `msauth` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('super_admin','teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msauth`
--

INSERT INTO `msauth` (`id`, `email`, `user_type`) VALUES
(19, 'wasdthedebugger@outlook.com', 'super_admin');

-- --------------------------------------------------------

--
-- Table structure for table `nine_neb`
--

CREATE TABLE `nine_neb` (
  `roll_no` varchar(5) NOT NULL,
  `english` float DEFAULT NULL,
  `nepali` float DEFAULT NULL,
  `maths` float DEFAULT NULL,
  `science` float DEFAULT NULL,
  `social` float DEFAULT NULL,
  `hpe` float DEFAULT NULL,
  `omaths` float DEFAULT NULL,
  `computer` float DEFAULT NULL,
  `economics` float DEFAULT NULL,
  `geography` float DEFAULT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sat`
--

CREATE TABLE `sat` (
  `roll_no` varchar(5) NOT NULL,
  `score` int(11) NOT NULL,
  `maths` int(11) NOT NULL,
  `english` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `roll_no` char(5) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `municipality` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `school_system` varchar(50) DEFAULT NULL,
  `high_school_system` varchar(50) DEFAULT NULL,
  `standard_test` varchar(50) DEFAULT NULL,
  `batch` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ten_neb`
--

CREATE TABLE `ten_neb` (
  `roll_no` varchar(5) NOT NULL,
  `english` float DEFAULT NULL,
  `nepali` float DEFAULT NULL,
  `maths` float DEFAULT NULL,
  `science` float DEFAULT NULL,
  `social` float DEFAULT NULL,
  `hpe` float DEFAULT NULL,
  `omaths` float DEFAULT NULL,
  `computer` float DEFAULT NULL,
  `economics` float DEFAULT NULL,
  `geography` float DEFAULT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `twelve_neb`
--

CREATE TABLE `twelve_neb` (
  `roll_no` varchar(5) NOT NULL,
  `nepali` float DEFAULT NULL,
  `nepali_pr` float DEFAULT NULL,
  `english` float DEFAULT NULL,
  `english_pr` float DEFAULT NULL,
  `maths` float DEFAULT NULL,
  `maths_pr` float DEFAULT NULL,
  `physics` float DEFAULT NULL,
  `physics_pr` float DEFAULT NULL,
  `chemistry` float DEFAULT NULL,
  `chemistry_pr` float DEFAULT NULL,
  `computer` float DEFAULT NULL,
  `computer_pr` float DEFAULT NULL,
  `biology` float DEFAULT NULL,
  `biology_pr` float DEFAULT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('super_admin','teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`) VALUES
(1, 'admin', 'admin123', 'admin@admin.com', 'super_admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aggregate_alevels`
--
ALTER TABLE `aggregate_alevels`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `eleven_neb`
--
ALTER TABLE `eleven_neb`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `msauth`
--
ALTER TABLE `msauth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nine_neb`
--
ALTER TABLE `nine_neb`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `sat`
--
ALTER TABLE `sat`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `ten_neb`
--
ALTER TABLE `ten_neb`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `twelve_neb`
--
ALTER TABLE `twelve_neb`
  ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `msauth`
--
ALTER TABLE `msauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
