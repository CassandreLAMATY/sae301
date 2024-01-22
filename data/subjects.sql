-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jan 22, 2024 at 08:39 AM
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
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sbj_id` int(11) NOT NULL,
  `sbj_name` varchar(80) NOT NULL,
  `sbj_color` varchar(9) NOT NULL,
  `sbj_ref` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`sbj_id`, `sbj_name`, `sbj_color`, `sbj_ref`) VALUES
(1, 'SAE Dév', '#F03E3E', 'WSA301D '),
(2, 'Portfolio', '#F03E3E', 'WSA310'),
(3, 'Anglais', '#FF1E54', 'WRA301'),
(4, 'Anglais Renforcé', '#FC5B5B', 'WRA302'),
(5, 'Design d\'expérience', '#FF4079', 'WRA303D'),
(6, 'Culture numérique', '#FF6C22', 'WRA304'),
(7, 'Stratégies de communication et marketing', '#FF9209', 'WRA305D'),
(8, 'Référencement', '#F4CE14', 'WRA306'),
(9, 'Expression, communication et rhétorique', '#FFE815', 'WRA307'),
(10, 'Écriture multimédia et narration', '#17B644', 'WRA308D'),
(11, 'Création et design interactif (UI)', '#1EFF27', 'WRA309D'),
(12, 'Culture artistique', '#ADFF00', 'WRA310D'),
(13, 'Audiovisuel et Motion design', '#3EF0B0', 'WRA311D'),
(14, 'Développement Front et intégration', '#0F3DB5', 'WRA312D'),
(15, 'Développement Back', '#405EFF', 'WRA313D'),
(16, 'Déploiement de services', '#1EBCFF', 'WRA314D'),
(17, 'Représentation et traitement de l\'information', '#40FFF4', 'WRA315'),
(18, 'Gestion de projet', '#620FB5', 'WRA316'),
(19, 'Economie, gestion et droit du numérique', '#9440FF', 'WRA317'),
(20, 'Projet Personnel et Professionnel', '#B50F86', 'WRA318'),
(21, 'Symfony', '#FF40EC', 'WRA319D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sbj_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `sbj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
