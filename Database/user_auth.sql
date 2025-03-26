-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 05:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `department`, `section`) VALUES
(64, 'CSE', 'A'),
(65, 'CSE', 'B'),
(66, 'CSE', 'C'),
(67, 'ECE', 'A'),
(68, 'ECE', 'B'),
(69, 'ECE', 'C'),
(70, 'EEE', 'A'),
(71, 'EEE', 'B'),
(72, 'EEE', 'C'),
(73, 'Civil', 'A'),
(74, 'Civil', 'B'),
(75, 'Civil', 'C'),
(76, 'Mechanical', 'A'),
(77, 'Mechanical', 'B'),
(79, 'MBA', 'A'),
(80, 'MBA', 'B'),
(81, 'MBA', 'C'),
(84, 'MCA', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `submit_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `semester_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `semester_name`) VALUES
(12, '1-1'),
(13, '1-2'),
(14, '2-1'),
(15, '2-2'),
(16, '3-1'),
(17, '3-2'),
(18, '4-1'),
(19, '4-2');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `faculty_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `branch_id`, `semester_id`, `faculty_name`) VALUES
(29, 'MEFA', 65, 18, 'Bhavya'),
(30, 'EDA-R', 66, 15, 'C.Rama Mohan'),
(31, 'DBMS', 64, 14, 'A.E.Kokila'),
(32, 'DBMS', 65, 14, 'A.E.Kokila'),
(33, 'DBMS', 66, 14, 'Sunandha'),
(34, 'DBMS', 68, 15, 'A.E.Kokila'),
(35, 'MEFA', 71, 18, 'Bhavya'),
(36, 'DLD', 68, 14, 'Chandra Mohan Reddy'),
(38, 'DSA', 64, 14, 'Ramamohan'),
(39, 'MAD', 64, 18, 'Dr Sunil kumar');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `topic_explained` text NOT NULL,
  `rating` varchar(255) NOT NULL,
  `suggestion` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `roll_no` varchar(10) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `date`, `subject_id`, `faculty_name`, `topic_explained`, `rating`, `suggestion`, `user_id`, `period`, `user_email`, `roll_no`, `submitted_at`) VALUES
(259, '2025-03-04', 29, 'Bhavya', 'a', 'Excellent', 'a', 20, 1, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(260, '2025-03-04', 32, 'Sunandha', 'b', 'Excellent', 'b', 20, 2, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(261, '2025-03-04', 32, 'Sunandha', 'c', 'Very Good', 'c', 20, 3, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(262, '2025-03-04', 29, 'Bhavya', 'd', 'Good', 'd', 20, 4, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(263, '2025-03-04', 32, 'Sunandha', 'e', 'Good', 'e', 20, 5, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(264, '2025-03-04', 29, 'Bhavya', 'f', 'Excellent', 'f', 20, 6, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(265, '2025-03-04', 32, 'Sunandha', 'g', 'Very Good', 'g', 20, 7, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(266, '2025-03-04', 29, 'Bhavya', 'a', 'Excellent', 'a', 20, 1, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(267, '2025-03-04', 32, 'Sunandha', 'b', 'Excellent', 'b', 20, 2, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(268, '2025-03-04', 32, 'Sunandha', 'c', 'Very Good', 'c', 20, 3, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(269, '2025-03-04', 29, 'Bhavya', 'd', 'Good', 'd', 20, 4, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(270, '2025-03-04', 32, 'Sunandha', 'e', 'Good', 'e', 20, 5, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(271, '2025-03-04', 29, 'Bhavya', 'f', 'Excellent', 'f', 20, 6, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(272, '2025-03-04', 32, 'Sunandha', 'g', 'Very Good', 'g', 20, 7, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(273, '2025-03-04', 29, 'Bhavya', 'a', 'Excellent', 'a', 20, 1, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(274, '2025-03-04', 32, 'Sunandha', 'b', 'Excellent', 'b', 20, 2, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(275, '2025-03-04', 32, 'Sunandha', 'c', 'Very Good', 'c', 20, 3, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(276, '2025-03-04', 29, 'Bhavya', 'd', 'Good', 'd', 20, 4, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(277, '2025-03-04', 32, 'Sunandha', 'e', 'Good', 'e', 20, 5, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(278, '2025-03-04', 29, 'Bhavya', 'f', 'Excellent', 'f', 20, 6, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(279, '2025-03-04', 32, 'Sunandha', 'g', 'Very Good', 'g', 20, 7, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(280, '2025-03-04', 29, 'Bhavya', 'a', 'Excellent', 'a', 20, 1, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(281, '2025-03-04', 32, 'Sunandha', 'b', 'Excellent', 'b', 20, 2, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(282, '2025-03-04', 32, 'Sunandha', 'c', 'Very Good', 'c', 20, 3, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(283, '2025-03-04', 29, 'Bhavya', 'd', 'Good', 'd', 20, 4, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(284, '2025-03-04', 32, 'Sunandha', 'e', 'Good', 'e', 20, 5, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(285, '2025-03-04', 29, 'Bhavya', 'f', 'Excellent', 'f', 20, 6, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(286, '2025-03-04', 32, 'Sunandha', 'g', 'Very Good', 'g', 20, 7, '21711a0593@necn.ac.in', '', '2025-03-06 06:28:53'),
(287, '2025-03-04', 34, 'A.E.Kokila', 'storage', 'Very Good', 'a', 22, 1, '21711a0592@necn.ac.in', '', '2025-03-06 06:28:53'),
(289, '2025-03-04', 34, 'A.E.Kokila', 'database', 'Good', 'c', 22, 3, '21711a0592@necn.ac.in', '', '2025-03-06 06:28:53'),
(291, '2025-03-04', 34, 'A.E.Kokila', 'uml', 'Very Good', 'e', 22, 5, '21711a0592@necn.ac.in', '', '2025-03-06 06:28:53'),
(293, '2025-03-04', 34, 'A.E.Kokila', 'diagrams', 'Good', 'g', 22, 7, '21711a0592@necn.ac.in', '', '2025-03-06 06:28:53'),
(294, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Excellent', 'b', 23, 1, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(295, '2025-03-05', 31, 'A.E.Kokila', 'aa', 'Very Good', 'bb', 23, 2, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(296, '2025-03-05', 31, 'A.E.Kokila', 'aa', 'Good', 'b', 23, 3, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(297, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Excellent', 'bb', 23, 4, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(298, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Very Good', 'b', 23, 5, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(299, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Very Good', 'bb', 23, 6, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(300, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Excellent', 'b', 23, 7, '21711a0529@necn.ac.in', '', '2025-03-06 06:28:53'),
(301, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Excellent', 'b', 24, 1, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(302, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Very Good', 'b', 24, 2, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(303, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Good', 'b', 24, 3, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(304, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Very Good', 'b', 24, 4, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(305, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Good', 'b', 24, 5, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(306, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Very Good', 'b', 24, 6, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(307, '2025-03-05', 31, 'A.E.Kokila', 'a', 'Excellent', 'b', 24, 7, '21711a0560@necn.ac.in', '', '2025-03-06 06:28:53'),
(308, '2025-03-06', 31, 'A.E.Kokila', 'ert', 'Class Not H', '', 25, 1, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(309, '2025-03-06', 38, 'Rajendra', 'fgh', 'Very Good', '', 25, 2, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(310, '2025-03-06', 31, 'A.E.Kokila', 'ghgj', 'Class Not H', '', 25, 3, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(311, '2025-03-06', 38, 'Rajendra', 'dgh', 'Poor', '', 25, 4, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(312, '2025-03-06', 31, 'A.E.Kokila', 'dshg', 'Satisfactor', '', 25, 5, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(313, '2025-03-06', 38, 'Rajendra', 'sdfg', 'Good', '', 25, 6, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(314, '2025-03-06', 31, 'A.E.Kokila', 'fhhhhhhhhhhhhhh', 'Excellent', '', 25, 7, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(315, '2025-03-06', 31, 'A.E.Kokila', '.', 'Excellent', '', 25, 1, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(316, '2025-03-06', 38, 'Rajendra', '.', 'Class Not Held', '', 25, 2, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(317, '2025-03-06', 31, 'A.E.Kokila', '.', 'Class Not Held', '', 25, 3, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(318, '2025-03-06', 38, 'Rajendra', '.', 'Very Good', '', 25, 4, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(319, '2025-03-06', 38, 'Rajendra', '.', 'Poor', '', 25, 5, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(320, '2025-03-06', 38, 'Rajendra', '.', 'Good', '', 25, 6, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(321, '2025-03-06', 38, 'Rajendra', '.', 'Satisfactory', '', 25, 7, '21711a0504@necn.ac.in', '', '2025-03-06 06:28:53'),
(322, '2025-03-06', 31, 'A.E.Kokila', 'dffgh', 'Excellent', '', 26, 1, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(323, '2025-03-06', 38, 'Rajendra', 'dffgh', 'Good', '', 26, 2, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(324, '2025-03-06', 31, 'A.E.Kokila', 'dffgh', 'Good', '', 26, 3, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(325, '2025-03-06', 38, 'Rajendra', 'dffgh', 'Satisfactory', '', 26, 4, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(326, '2025-03-06', 38, 'Rajendra', '.', 'Class Not Held', '', 26, 5, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(327, '2025-03-06', 31, 'A.E.Kokila', '.', 'Poor', '', 26, 6, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(328, '2025-03-06', 38, 'Rajendra', '.', 'Poor', '', 26, 7, '21711a0512@necn.ac.in', '', '2025-03-06 10:58:36'),
(329, '2025-03-17', 31, 'A.E.Kokila', 'wer', 'Very Good', 'dfg', 29, 1, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(330, '2025-03-17', 38, 'Rajendra', 'fgh', 'Excellent', 'hj', 29, 2, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(331, '2025-03-17', 31, 'A.E.Kokila', 'dfg', 'Good', 'dhj', 29, 3, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(332, '2025-03-17', 31, 'A.E.Kokila', 'gh', 'Satisfactory', 'fgh', 29, 4, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(333, '2025-03-17', 31, 'A.E.Kokila', 'khg', 'Poor', 'fgh', 29, 5, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(334, '2025-03-17', 38, 'Rajendra', 'sgh', 'Class Not Held', 'fgh', 29, 6, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(335, '2025-03-17', 31, 'A.E.Kokila', 'fgju', 'Poor', '', 29, 7, '21711a0523@necn.ac.in', '', '2025-03-17 14:19:41'),
(336, '2025-03-19', 38, 'Rajendra', 'gfhg', 'Good', '', 30, 1, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48'),
(337, '2025-03-19', 31, 'A.E.Kokila', 'fddfgdfg', 'Good', '', 30, 2, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48'),
(338, '2025-03-19', 31, 'A.E.Kokila', 'vnhgh', 'Good', '', 30, 3, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48'),
(339, '2025-03-19', 38, 'Rajendra', 'vnbcnm', 'Good', '', 30, 4, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48'),
(340, '2025-03-19', 31, 'A.E.Kokila', 'ghghhh', 'Good', '', 30, 5, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48'),
(341, '2025-03-19', 38, 'Rajendra', 'hghggjhj', 'Good', '', 30, 6, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48'),
(342, '2025-03-19', 31, 'A.E.Kokila', 'dgfgfgf', 'Class Not Held', '', 30, 7, '21711a0517@necn.ac.in', '', '2025-03-19 10:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `rollno` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `department` varchar(50) NOT NULL,
  `section` varchar(10) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `verified` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `rollno`, `email`, `password`, `created_at`, `department`, `section`, `branch_name`, `semester`, `verified`) VALUES
(3, 'admin', '', 'admin@example.com', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', '2025-01-10 10:10:37', '', '', '', '', NULL),
(13, 'sita', '', 'sita@gmail.com', '$2y$10$r61XthGZ4xYOY5HUHA.Q3OKNysFbuQFvkgh3AoyG6nYZAmZ.C1YMW', '2025-02-04 11:02:26', 'CSE', '', '', '', NULL),
(15, 'Malavika', '', 'malavika@gmail.com', '$2y$10$Fx5qIsa1T0JABEEmvqNp/eLXrSpMWLN42PrUXoeHFk2M136rcf1lS', '2025-02-13 02:18:34', 'CSE', '', '', '', NULL),
(16, 'thanvi', '', 'thanvi@gmail.com', '$2y$10$wDNLLnx11BVsGWR9AYKM0eIljZKk7yH55pdTZrc8m/Xa.DWdBjyou', '2025-02-13 05:38:16', 'CSE', '', '', '', 1),
(17, 'Mallika', '', 'mallika@gmail.com', '$2y$10$lU1WinrRnh4cpGFg6qXypuRK0mq1eADitcexWDMHnOWUVNBrdh4i6', '2025-02-15 14:26:05', 'ECE', '', '', '', NULL),
(19, 'K.Malavika', '', '21711a0530@necn.ac.in', '$2y$10$mSHmf1U/PziC3tYDEA6wqOWE3GTXJJ4ScmY0NWEgfBzy64ETxGNcy', '2025-03-04 14:24:25', 'CSE', '', '', '', NULL),
(20, 'Amelia', '', '21711a0593@necn.ac.in', '$2y$10$/4L/kqf3EM/XcTaYeSAtSOm3OPI5XAHAbAjvZiV4Uc/MxOMnDzaYi', '2025-03-04 15:36:58', 'CSE', 'B', 'CSE-B', '', NULL),
(22, 'Ayesha', '', '21711a0592@necn.ac.in', '$2y$10$OAT3p921/pVaR0IUeJyS8u3LUvRovZwXU8kfNywV9MrveGDOVIVVe', '2025-03-04 16:29:08', 'ECE', 'B', 'ECE-B', '4', NULL),
(23, 'kedhari Priya', '', '21711a0529@necn.ac.in', '$2y$10$xKxtTviUhDQLJIdMOw3uQOjv/VSdyruFrAKg7./d.ICXkdGOGpwVK', '2025-03-05 05:19:48', 'CSE', 'A', 'CSE-A', '3', NULL),
(24, 'Thanvi Priya', '', '21711a0560@necn.ac.in', '$2y$10$KKTm5esB3pJHLCppNXTqlO2Yz1V4w3aaJoyYc5SHzMctlq64X8Sta', '2025-03-05 06:46:44', 'CSE', 'A', 'CSE-A', '3', 1),
(25, 'Geethika', '21711A0504', '21711a0504@necn.ac.in', '$2y$10$3kKV4PNs/CjR7xieEK/l0u7ibcZloSNFbVDsNf3zpykYIO0Z4KGkS', '2025-03-06 06:17:39', 'CSE', 'A', 'CSE-A', '3', NULL),
(26, 'Meghana', '21711A0512', '21711a0512@necn.ac.in', '$2y$10$MPmSEumZtdYPHeb6GpmOIempbO28parnLCOxpS8JF6DViGnXwkxn2', '2025-03-06 10:57:26', 'CSE', 'A', 'CSE-A', '3', NULL),
(27, 'Bhanu', '21711A0560', '21711a0521@necn.ac.in', '$2y$10$YyI3PA1iGdw1D76l/098KuSEs1I55qCN5rIanGCe/0XmnOUuTHurC', '2025-03-07 09:17:40', 'CSE', 'A', 'CSE-A', '3', NULL),
(28, 'Vadlamudi Thanvi Priya', '21711A0501', '21711a0501@necn.ac.in', '$2y$10$T78JKVcY0dckjalLJV3LfukdYEY4f5T.x2bsZk9JMp/Bz4wM8hENm', '2025-03-17 13:40:15', 'CSE', 'A', 'CSE-A', '7', 1),
(29, 'Hema latha', '21711A0523', '21711a0523@necn.ac.in', '$2y$10$0N1s2dDL8yUF3KqBGp7XnOXRyaVsNMGpHBoNxL9p319e0Kl7CZnRq', '2025-03-17 14:06:58', 'CSE', 'A', 'CSE-A', '3', 1),
(30, 'D. Pravallika', '21711A0517', '21711a0517@necn.ac.in', '$2y$10$zFxX7M9g7yZfkd4XHmPIbukS1oX2i.EBvKVIthCiq56GSU28QMyaS', '2025-03-19 10:45:37', 'CSE', 'A', 'CSE-A', '3', 1),
(31, 'Manaswini', '21711A0520', '21711a0520@necn.ac.in', '$2y$10$HNR8EInjWqvr3kIlTWVwWui/d7nRI2OdiDlMwVdB1/04sEzn.QM.O', '2025-03-21 14:29:51', 'CSE', 'A', 'CSE-A', '7', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
