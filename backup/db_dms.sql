-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2025 at 01:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE `tbl_documents` (
  `doc_id` int NOT NULL,
  `doc_subject` varchar(255) NOT NULL,
  `doc_from` varchar(200) NOT NULL,
  `doc_number` varchar(100) NOT NULL,
  `doc_date` date NOT NULL,
  `doc_file` varchar(255) NOT NULL,
  `status` enum('receiving','pending_director','pending_deputy','pending_officer','pending_teacher','completed','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'receiving',
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doc_history`
--

CREATE TABLE `tbl_doc_history` (
  `history_id` int NOT NULL,
  `doc_id` int NOT NULL,
  `action_by` int NOT NULL,
  `action_to` int DEFAULT NULL,
  `action_type` enum('create','forward','comment','approve','reject') NOT NULL,
  `comment` text,
  `action_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `role` enum('admin','director','deputy','officer','teacher') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tbl_doc_history`
--
ALTER TABLE `tbl_doc_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `doc_id` (`doc_id`),
  ADD KEY `action_by` (`action_by`),
  ADD KEY `action_to` (`action_to`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  MODIFY `doc_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_doc_history`
--
ALTER TABLE `tbl_doc_history`
  MODIFY `history_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD CONSTRAINT `tbl_documents_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `tbl_users` (`user_id`);

--
-- Constraints for table `tbl_doc_history`
--
ALTER TABLE `tbl_doc_history`
  ADD CONSTRAINT `tbl_doc_history_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `tbl_documents` (`doc_id`),
  ADD CONSTRAINT `tbl_doc_history_ibfk_2` FOREIGN KEY (`action_by`) REFERENCES `tbl_users` (`user_id`),
  ADD CONSTRAINT `tbl_doc_history_ibfk_3` FOREIGN KEY (`action_to`) REFERENCES `tbl_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
