-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 12 jan. 2024 à 09:48
-- Version du serveur : 10.8.8-MariaDB-1:10.8.8+maria~ubu2204
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae301`
--

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

CREATE TABLE `cards` (
  `crd_id` int(11) NOT NULL,
  `crd_typ_id` int(11) NOT NULL,
  `crd_created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `crd_title` varchar(100) NOT NULL,
  `crd_desc` varchar(255) DEFAULT NULL,
  `crd_sbj_id` int(11) DEFAULT NULL,
  `crd_from` datetime DEFAULT NULL,
  `crd_to` datetime NOT NULL,
  `is_validated` smallint(6) NOT NULL DEFAULT 0,
  `validated_by` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cards`
--

INSERT INTO `cards` (`crd_id`, `crd_typ_id`, `crd_created_at`, `crd_title`, `crd_desc`, `crd_sbj_id`, `crd_from`, `crd_to`, `is_validated`, `validated_by`) VALUES
(1, 1, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 6, '2024-01-11 09:22:08', '2024-01-16 16:46:30', 0, NULL),
(2, 3, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 13, NULL, '2024-01-12 10:08:52', 0, NULL),
(3, 4, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 20, NULL, '2024-01-27 11:02:52', 0, NULL),
(4, 2, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 18, NULL, '2024-01-11 11:02:52', 0, NULL),
(5, 1, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 6, NULL, '2024-01-11 11:02:52', 0, NULL),
(6, 1, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 6, NULL, '2024-01-11 11:02:52', 0, NULL),
(7, 2, '2024-01-11 11:03:46', 'Rendu de fin de Semestre', 'coucou les loulous', 6, NULL, '2024-01-11 11:02:52', 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`crd_id`),
  ADD KEY `IDX_4C258FD107D7A9E` (`crd_typ_id`),
  ADD KEY `IDX_4C258FD25EC5B4E` (`crd_sbj_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cards`
--
ALTER TABLE `cards`
  MODIFY `crd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `FK_4C258FD107D7A9E` FOREIGN KEY (`crd_typ_id`) REFERENCES `types` (`typ_id`),
  ADD CONSTRAINT `FK_4C258FD25EC5B4E` FOREIGN KEY (`crd_sbj_id`) REFERENCES `subjects` (`sbj_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
