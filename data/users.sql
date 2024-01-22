-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jan 22, 2024 at 08:36 AM
-- Server version: 10.8.8-MariaDB-1:10.8.8+maria~ubu2204
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sae301`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL,
  `usr_mail` varchar(100) NOT NULL,
  `usr_pwd` varchar(200) NOT NULL,
  `usr_role` varchar(20) NOT NULL,
  `usr_name` varchar(50) NOT NULL,
  `usr_firstname` varchar(50) NOT NULL,
  `usr_tp` varchar(1) DEFAULT NULL,
  `usr_banned` tinyint(1) NOT NULL DEFAULT 0,
  `usr_pseudo` varchar(8) NOT NULL,
  `usr_semester` varchar(2) NOT NULL,
  `usr_homework_reminder` tinyint(1) NOT NULL,
  `usr_exam_reminder` tinyint(1) NOT NULL,
  `usr_new_reminder` tinyint(1) NOT NULL,
  `usr_modif_reminder` tinyint(1) NOT NULL,
  `usr_cookies` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usr_id`, `usr_mail`, `usr_pwd`, `usr_role`, `usr_name`, `usr_firstname`, `usr_tp`, `usr_banned`, `usr_pseudo`, `usr_semester`, `usr_homework_reminder`, `usr_exam_reminder`, `usr_new_reminder`, `usr_modif_reminder`, `usr_cookies`) VALUES
(1, 'cassandre.lamaty@etudiant.univ-reims.fr', '$2y$13$lhv37vR5/Zkr9lwEnU4Iz.jTV/D9G5NHDWOE.CNSrHuq/vDPldL2.', 'ROLE_ETU', 'Lamaty', 'Cassandre', 'F', 0, 'lama0039', 'S3', 0, 0, 0, 0, 0),
(2, 'artur.moreira-machado@etudiant.univ-reims.fr', '$2y$13$lhv37vR5/Zkr9lwEnU4Iz.jTV/D9G5NHDWOE.CNSrHuq/vDPldL2.', 'ROLE_ETU', 'Moreira Machado', 'Artur', 'E', 0, 'more0210', 'S3', 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
