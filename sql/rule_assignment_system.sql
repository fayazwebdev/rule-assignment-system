-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2026 at 12:03 PM
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
-- Database: `rule_assignment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `created_at`) VALUES
(1, 'Group A', '2026-04-17 05:17:52'),
(2, 'Group B', '2026-04-17 06:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `group_rule_assignments`
--

CREATE TABLE `group_rule_assignments` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `tier` tinyint(4) NOT NULL
) ;

--
-- Dumping data for table `group_rule_assignments`
--

INSERT INTO `group_rule_assignments` (`id`, `group_id`, `rule_id`, `parent_id`, `tier`) VALUES
(1, 1, 3, NULL, 1),
(2, 1, 1, NULL, 1),
(3, 1, 3, 2, 2),
(4, 1, 4, 2, 2),
(5, 1, 2, 2, 2),
(6, 1, 4, 5, 3),
(7, 2, 1, NULL, 1),
(8, 2, 3, 7, 2),
(9, 2, 2, 7, 2),
(10, 2, 4, 9, 3),
(11, 2, 4, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `rule_id` int(11) NOT NULL,
  `rule_name` varchar(255) NOT NULL,
  `rule_type` enum('CONDITION','DECISION') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`rule_id`, `rule_name`, `rule_type`, `created_at`, `updated_at`) VALUES
(1, 'Income Check', 'CONDITION', '2026-04-17 05:14:39', '2026-04-17 05:14:39'),
(2, 'Credit Score Check', 'CONDITION', '2026-04-17 05:44:15', '2026-04-17 05:44:15'),
(3, 'Approve Loan', 'DECISION', '2026-04-17 05:44:15', '2026-04-17 05:44:15'),
(4, 'Reject Loan', 'DECISION', '2026-04-17 05:44:15', '2026-04-17 05:44:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_rule_assignments`
--
ALTER TABLE `group_rule_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_id` (`group_id`,`parent_id`,`rule_id`),
  ADD KEY `rule_id` (`rule_id`),
  ADD KEY `idx_group` (`group_id`),
  ADD KEY `idx_parent` (`parent_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`rule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `group_rule_assignments`
--
ALTER TABLE `group_rule_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `rule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_rule_assignments`
--
ALTER TABLE `group_rule_assignments`
  ADD CONSTRAINT `group_rule_assignments_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_rule_assignments_ibfk_2` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`rule_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_rule_assignments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `group_rule_assignments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
