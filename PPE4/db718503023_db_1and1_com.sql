-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : db718503023.db.1and1.com
-- Généré le : mar. 31 mai 2022 à 21:51
-- Version du serveur :  5.5.60-0+deb7u1-log
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db718503023`
--
CREATE DATABASE IF NOT EXISTS `db718503023` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db718503023`;

-- --------------------------------------------------------

--
-- Structure de la table `ANIMAL`
--

CREATE TABLE `ANIMAL` (
  `codeespece` smallint(6) NOT NULL DEFAULT '0',
  `nombapteme` varchar(10) NOT NULL DEFAULT '',
  `sexe` varchar(10) DEFAULT NULL,
  `datenaissance` date DEFAULT NULL,
  `datedeces` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ANIMAL`
--

INSERT INTO `ANIMAL` (`codeespece`, `nombapteme`, `sexe`, `datenaissance`, `datedeces`) VALUES
(4, 'Ratio', 'F', '2018-11-29', '2017-01-01'),
(1, 'Palu', 'M', '2020-02-18', '2017-01-01'),
(1, 'Marie', 'M', '2021-06-10', '2017-01-01'),
(1, 'Bobo', 'M', '2020-04-05', '2017-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `animaloccuperenclos`
--

CREATE TABLE `animaloccuperenclos` (
  `codeespece` smallint(6) NOT NULL DEFAULT '0',
  `nombapteme` varchar(10) NOT NULL DEFAULT '',
  `codeenclos` smallint(6) NOT NULL DEFAULT '0',
  `datedebut` date NOT NULL DEFAULT '0000-00-00',
  `encours` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animaloccuperenclos`
--

INSERT INTO `animaloccuperenclos` (`codeespece`, `nombapteme`, `codeenclos`, `datedebut`, `encours`) VALUES
(1, 'Marie', 3, '2022-05-20', 1),
(1, 'Marie', 2, '2022-04-29', 0),
(1, 'Bobo', 2, '2022-04-29', 1),
(1, 'Bobo', 0, '2022-04-29', 1),
(4, 'Ratio', 3, '2022-04-28', 1),
(2, 'Bobo', 1, '2022-04-28', 1),
(2, 'Palu', 1, '2022-04-28', 1),
(5, 'Marie', 4, '2022-04-28', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cohabiter`
--

CREATE TABLE `cohabiter` (
  `codeespece` smallint(6) NOT NULL DEFAULT '0',
  `codeespece_1` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cohabiter`
--

INSERT INTO `cohabiter` (`codeespece`, `codeespece_1`) VALUES
(1, 1),
(1, 4),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ENCLOS`
--

CREATE TABLE `ENCLOS` (
  `codeenclos` smallint(6) NOT NULL DEFAULT '0',
  `nom` varchar(50) DEFAULT NULL,
  `superficie` decimal(7,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ENCLOS`
--

INSERT INTO `ENCLOS` (`codeenclos`, `nom`, `superficie`) VALUES
(4, 'Enclos5', '22521.00'),
(3, 'Enclos4', '150.00'),
(2, 'Enclos3', '400.00'),
(1, 'Enclos2', '250.00'),
(0, 'Enclos1', '280.00');

-- --------------------------------------------------------

--
-- Structure de la table `ESPECE`
--

CREATE TABLE `ESPECE` (
  `codeespece` smallint(6) NOT NULL DEFAULT '0',
  `libelle` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ESPECE`
--

INSERT INTO `ESPECE` (`codeespece`, `libelle`) VALUES
(4, 'Tigre'),
(1, 'Ratons laveurs');

-- --------------------------------------------------------

--
-- Structure de la table `especepouvoirvivreenclos`
--

CREATE TABLE `especepouvoirvivreenclos` (
  `codeespece` smallint(6) NOT NULL DEFAULT '0',
  `codeenclos` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `especepouvoirvivreenclos`
--

INSERT INTO `especepouvoirvivreenclos` (`codeespece`, `codeenclos`) VALUES
(1, 0),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `prendresoin`
--

CREATE TABLE `prendresoin` (
  `codeespece` smallint(6) NOT NULL DEFAULT '0',
  `matricule` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `prendresoin`
--

INSERT INTO `prendresoin` (`codeespece`, `matricule`) VALUES
(1, 1),
(1, 2),
(1, 4),
(4, 1),
(4, 3),
(4, 4),
(5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `SOIGNANT`
--

CREATE TABLE `SOIGNANT` (
  `matricule` smallint(6) NOT NULL DEFAULT '0',
  `nomsoignant` varchar(50) DEFAULT NULL,
  `prenomsoignant` varchar(50) DEFAULT NULL,
  `telsoignant` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `SOIGNANT`
--

INSERT INTO `SOIGNANT` (`matricule`, `nomsoignant`, `prenomsoignant`, `telsoignant`) VALUES
(2, 'Crepelière', 'Jules', '4564864'),
(1, 'dfhdf', 'Alexandre', '5544477'),
(4, 'Desmoulins', 'Théo', '652454814'),
(3, 'Houeix', 'Antoine', '5665445');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ANIMAL`
--
ALTER TABLE `ANIMAL`
  ADD PRIMARY KEY (`codeespece`,`nombapteme`);

--
-- Index pour la table `animaloccuperenclos`
--
ALTER TABLE `animaloccuperenclos`
  ADD PRIMARY KEY (`codeespece`,`nombapteme`,`codeenclos`,`datedebut`),
  ADD KEY `codeenclos` (`codeenclos`);

--
-- Index pour la table `cohabiter`
--
ALTER TABLE `cohabiter`
  ADD PRIMARY KEY (`codeespece`,`codeespece_1`),
  ADD KEY `codeespece_1` (`codeespece_1`);

--
-- Index pour la table `ENCLOS`
--
ALTER TABLE `ENCLOS`
  ADD PRIMARY KEY (`codeenclos`);

--
-- Index pour la table `ESPECE`
--
ALTER TABLE `ESPECE`
  ADD PRIMARY KEY (`codeespece`);

--
-- Index pour la table `especepouvoirvivreenclos`
--
ALTER TABLE `especepouvoirvivreenclos`
  ADD PRIMARY KEY (`codeespece`,`codeenclos`),
  ADD KEY `codeenclos` (`codeenclos`);

--
-- Index pour la table `prendresoin`
--
ALTER TABLE `prendresoin`
  ADD PRIMARY KEY (`codeespece`,`matricule`),
  ADD KEY `matricule` (`matricule`);

--
-- Index pour la table `SOIGNANT`
--
ALTER TABLE `SOIGNANT`
  ADD PRIMARY KEY (`matricule`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
