-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2023 at 04:42 PM
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

--
-- Dumping data for table `aggregate_alevels`
--

INSERT INTO `aggregate_alevels` (`roll_no`, `elang`, `general_paper`, `maths`, `physics`, `chemistry`, `business`, `economics`, `further_maths`, `biology`, `computer`, `accounting`, `gpa`) VALUES
('1004D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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

--
-- Dumping data for table `eleven_neb`
--

INSERT INTO `eleven_neb` (`roll_no`, `nepali`, `nepali_pr`, `english`, `english_pr`, `maths`, `maths_pr`, `physics`, `physics_pr`, `chemistry`, `chemistry_pr`, `computer`, `computer_pr`, `biology`, `biology_pr`, `gpa`) VALUES
('1001A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1002B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1003C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1004D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1005E', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1006F', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1007G', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1008H', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1009I', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1010J', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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

--
-- Dumping data for table `nine_neb`
--

INSERT INTO `nine_neb` (`roll_no`, `english`, `nepali`, `maths`, `science`, `social`, `hpe`, `omaths`, `computer`, `economics`, `geography`, `gpa`) VALUES
('1001A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1002B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1003C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1004D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1005E', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1006F', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1007G', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1008H', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1009I', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1010J', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sat`
--

CREATE TABLE `sat` (
  `roll_no` varchar(5) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sat`
--

INSERT INTO `sat` (`roll_no`, `score`) VALUES
('1001A', 0),
('1002B', 0),
('1003C', 0),
('1004D', 0),
('1005E', 0),
('1006F', 0),
('1007G', 0),
('1008H', 0),
('1009I', 0),
('1010J', 0);

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

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`roll_no`, `first_name`, `middle_name`, `last_name`, `dob`, `sex`, `municipality`, `district`, `province`, `joining_date`, `school_system`, `high_school_system`, `standard_test`, `batch`) VALUES
('1001A', 'John', '', 'Doe', '2002-05-10', 'Male', 'Kathmandu', 'Kathmandu', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000A'),
('1002B', 'Jane', '', 'Smith', '2003-02-18', 'Female', 'Lalitpur', 'Lalitpur', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000B'),
('1003C', 'David', '', 'Johnson', '2001-11-25', 'Male', 'Patan', 'Patan', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000C'),
('1004D', 'Sarah', '', 'Williams', '2002-09-07', 'Female', 'Kirtipur', 'Kathmandu', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000D'),
('1005E', 'Michael', '', 'Brown', '2003-07-12', 'Male', 'Bhaktapur', 'Bhaktapur', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000E'),
('1006F', 'Emily', '', 'Jones', '2002-04-05', 'Female', 'Kathmandu', 'Kathmandu', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000F'),
('1007G', 'James', '', 'Davis', '2001-10-01', 'Male', 'Lalitpur', 'Lalitpur', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000G'),
('1008H', 'Olivia', '', 'Miller', '2002-06-28', 'Female', 'Patan', 'Patan', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000H'),
('1009I', 'Liam', '', 'Wilson', '2003-04-22', 'Male', 'Kirtipur', 'Kathmandu', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000I'),
('1010J', 'Ava', '', 'Taylor', '2002-12-15', 'Female', 'Bhaktapur', 'Bhaktapur', 'Bagmati', '2022-08-15', 'NEB', 'NEB', 'SAT', '1000J'),
('9999N', 'Nikas', '', 'Ghimire', '2023-06-22', 'Male', '', 'Darchula', 'Province 2', '2023-05-31', 'neb', 'alevels', 'none', '9000N');

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

--
-- Dumping data for table `ten_neb`
--

INSERT INTO `ten_neb` (`roll_no`, `english`, `nepali`, `maths`, `science`, `social`, `hpe`, `omaths`, `computer`, `economics`, `geography`, `gpa`) VALUES
('1001A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1002B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1003C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1004D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1005E', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1006F', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1007G', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1008H', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1009I', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1010J', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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

--
-- Dumping data for table `twelve_neb`
--

INSERT INTO `twelve_neb` (`roll_no`, `nepali`, `nepali_pr`, `english`, `english_pr`, `maths`, `maths_pr`, `physics`, `physics_pr`, `chemistry`, `chemistry_pr`, `computer`, `computer_pr`, `biology`, `biology_pr`, `gpa`) VALUES
('1001A', 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
('1002B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1003C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1004D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1005E', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1006F', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1007G', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1008H', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1009I', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('1010J', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
