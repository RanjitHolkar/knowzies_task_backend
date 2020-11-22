-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2020 at 02:42 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emp_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1:‘Not Started’,2:In-Progress,2:Completed',
  `added_date_time` datetime NOT NULL,
  `updated_date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `added_by` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL COMMENT '0:Not Delete, 1:Delete',
  `description` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `start_date`, `end_date`, `user_id`, `status`, `added_date_time`, `updated_date_time`, `added_by`, `is_delete`, `description`, `comment`) VALUES
(1, 'Create Dashboard', '2020-11-10', '2020-12-10', 4, 1, '2020-11-22 09:08:06', '2020-11-22 04:04:36', 1, 1, 'jwdlslfdfl', ''),
(2, 'Create Dashboard', '2020-11-10', '2020-12-10', 3, 2, '2020-11-22 09:09:35', '2020-11-22 06:40:23', 3, 0, 'jwdlslfdfl dsfsadfasd', 'qeadsfdsf'),
(3, 'sdcxb', '2020-11-12', '2020-11-28', 0, 1, '2020-11-22 12:26:54', '2020-11-22 06:56:54', 1, 0, 'xfgcbx xbcbxvcb', ''),
(4, 'TestTask', '2020-11-11', '2020-11-26', 7, 1, '2020-11-22 07:09:53', '2020-11-22 13:39:53', 1, 0, 'qnjkwds', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` text CHARACTER SET latin1 NOT NULL,
  `is_delete` tinyint(1) NOT NULL COMMENT '0:Not Delete,1:Delete',
  `added_date_time` datetime NOT NULL,
  `updated_date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `role` int(11) NOT NULL COMMENT '1:Manager,2:Employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `emp_code`, `email`, `password`, `is_delete`, `added_date_time`, `updated_date_time`, `added_by`, `birth_date`, `role`) VALUES
(1, 'Ranjit', 'Holkar', '0', 'ranjitholkar81@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0, '2020-11-21 11:00:01', '2020-11-21 05:30:01', 1, '2020-11-05', 1),
(3, 'Ranjit', 'Holkar', '1', 'ranjitholkar75@gmail.com', '07915049cc58ac3fba135a2a81d54fd1', 0, '2020-11-21 11:44:59', '2020-11-21 18:14:59', 1, '2020-11-18', 2),
(4, 'Ranjit', 'Holkar', '12', 'ranjitholkar7m5@gmail.com', '07915049cc58ac3fba135a2a81d54fd1', 0, '2020-11-21 11:47:41', '2020-11-21 18:17:41', 1, '2020-11-18', 2),
(5, 'Ranjitad', 'Holkar', '32', 'ranjitholkaaar75@gmail.com', '07915049cc58ac3fba135a2a81d54fd1', 1, '2020-11-21 11:49:45', '2020-11-21 19:06:45', 1, '2020-11-18', 2),
(6, 'Ranjit', 'ndl', '001', 'dsz@gmail.com', '07915049cc58ac3fba135a2a81d54fd1', 0, '2020-11-22 08:19:08', '2020-11-22 02:49:08', 1, '1960-02-19', 2),
(7, 'Test', 'Employee', 'testEmp', 'test1@gmail.com', '12bce374e7be15142e8172f668da00d8', 0, '2020-11-22 07:09:21', '2020-11-22 13:39:21', 1, '2020-11-19', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `emp_code` (`emp_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
