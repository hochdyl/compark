-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 14 déc. 2019 à 11:47
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `compark`
--
CREATE DATABASE IF NOT EXISTS `compark` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `compark`;

-- --------------------------------------------------------

--
-- Structure de la table `composant`
--

DROP TABLE IF EXISTS `composant`;
CREATE TABLE IF NOT EXISTS `composant` (
  `id_compo` int(11) NOT NULL AUTO_INCREMENT,
  `nom_compo` varchar(50) NOT NULL,
  `commentaire_compo` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_compo`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `composant`
--

INSERT INTO `composant` (`id_compo`, `nom_compo`, `commentaire_compo`) VALUES
(1, 'Clavier Logitech K120', 'Serie 2017'),
(2, 'Clavier Microsoft', NULL),
(3, 'Ecran iiyama', 'reference : ProLite E2483HS'),
(4, 'Souris Logitech G203', NULL),
(5, 'Souris Microsoft', 'Souris a boule'),
(6, 'Processeur Intel Core i5 7600k', '7ème generation'),
(7, 'Processeur Intel Core i3 2600k', 'Vieux processeur'),
(8, 'Carte mère Gigabyte H310M', NULL),
(9, 'Carte mère MSI B360M', 'Nouvelle carte mère pour les PC salle 136 - pas encore installée'),
(10, 'Mémoire RAM DDR3 2x2Go', NULL),
(11, 'Mémoire RAM DDR3 2x4Go', NULL),
(12, 'Aliementation Cooler Master 400W', 'Equiper sur tout les ordinateurs'),
(13, 'Disque Dur HDD 250Go', 'Fonctionne lentement, espace limité'),
(14, 'Disque Dur HDD 500Go', NULL),
(15, 'Disque Dur SSD 250Go', 'Rapide !'),
(16, 'Lecteur de disque Asus', NULL),
(17, 'Windows 10', NULL),
(18, 'Windows 7', NULL),
(19, 'Linux', NULL),
(20, 'Imprimante Brother HL', 'Bac encre type GK879L'),
(21, 'Serveur Apache', 'Heberge le site du lycée');

-- --------------------------------------------------------

--
-- Structure de la table `installation`
--

DROP TABLE IF EXISTS `installation`;
CREATE TABLE IF NOT EXISTS `installation` (
  `id_inst` int(11) NOT NULL AUTO_INCREMENT,
  `refcompo` int(11) NOT NULL,
  `refordi` int(11) NOT NULL,
  `OKHS` varchar(2) DEFAULT NULL,
  `commentaire_inst` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_inst`),
  KEY `fk_compo` (`refcompo`),
  KEY `fk_ordi` (`refordi`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `installation`
--

INSERT INTO `installation` (`id_inst`, `refcompo`, `refordi`, `OKHS`, `commentaire_inst`) VALUES
(5, 2, 1, 'OK', NULL),
(6, 2, 2, 'OK', NULL),
(7, 2, 3, 'OK', NULL),
(8, 2, 4, 'OK', NULL),
(9, 3, 1, 'OK', NULL),
(10, 3, 2, 'OK', NULL),
(11, 3, 3, 'OK', NULL),
(12, 3, 4, 'OK', NULL),
(13, 4, 1, 'OK', NULL),
(14, 4, 2, 'OK', NULL),
(15, 5, 3, 'OK', NULL),
(16, 5, 4, 'HS', NULL),
(17, 18, 1, 'OK', NULL),
(18, 18, 2, 'OK', NULL),
(19, 18, 3, 'OK', NULL),
(20, 18, 4, 'OK', NULL),
(21, 1, 5, 'OK', NULL),
(22, 3, 5, 'HS', NULL),
(23, 14, 5, 'HS', NULL),
(24, 15, 5, 'HS', NULL),
(25, 20, 5, 'OK', NULL),
(26, 16, 5, 'OK', NULL),
(27, 11, 5, 'OK', NULL),
(28, 6, 5, 'HS', NULL),
(29, 4, 5, 'OK', NULL),
(30, 17, 5, 'OK', NULL),
(64, 12, 5, 'OK', ''),
(65, 7, 5, 'OK', NULL),
(66, 8, 5, 'OK', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ordinateur`
--

DROP TABLE IF EXISTS `ordinateur`;
CREATE TABLE IF NOT EXISTS `ordinateur` (
  `id_ordi` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ordi` varchar(50) NOT NULL,
  `commentaire_ordi` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_ordi`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ordinateur`
--

INSERT INTO `ordinateur` (`id_ordi`, `nom_ordi`, `commentaire_ordi`) VALUES
(1, 'PC Salle 204-1', 'Machine Virtuelle'),
(2, 'PC Salle 204-2', 'Machine Virtuelle'),
(3, 'PC Salle 204-3', 'Machine Virtuelle'),
(4, 'PC Salle 204-4', 'Machine Virtuelle'),
(5, 'PC Salle 136-1', NULL),
(6, 'PC Salle 136-2', NULL),
(7, 'PC Salle 136-3', 'Clavier changer recemment'),
(8, 'PC Salle 136-4', NULL),
(10, 'PC Salle 136-6', 'Alimentation morte'),
(11, 'PC Salle 136-7', 'Drivers non a jour'),
(12, 'PC Salle 136-8', NULL),
(13, 'PC Salle 326-1', 'PC Serveur');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `installation`
--
ALTER TABLE `installation`
  ADD CONSTRAINT `fk_compo` FOREIGN KEY (`refcompo`) REFERENCES `composant` (`id_compo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ordi` FOREIGN KEY (`refordi`) REFERENCES `ordinateur` (`id_ordi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
