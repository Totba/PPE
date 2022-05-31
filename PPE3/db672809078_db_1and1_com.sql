-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : db672809078.db.1and1.com
-- Généré le : mar. 31 mai 2022 à 21:48
-- Version du serveur :  5.7.38-log
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db672809078`
--
CREATE DATABASE IF NOT EXISTS `db672809078` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db672809078`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `Id_Categorie` int(11) NOT NULL,
  `capacite` varchar(50) DEFAULT NULL,
  `nom_categorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`Id_Categorie`, `capacite`, `nom_categorie`) VALUES
(1, '200', 'Grande'),
(2, '100', 'Moyenne'),
(3, '50', 'Petite'),
(4, '25', 'Micro');

-- --------------------------------------------------------

--
-- Structure de la table `date_p`
--

CREATE TABLE `date_p` (
  `Id_Date_P` int(11) NOT NULL,
  `datereserv` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `date_p`
--

INSERT INTO `date_p` (`Id_Date_P`, `datereserv`) VALUES
(1, '2021-12-18'),
(2, '2021-12-31');

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

CREATE TABLE `demande` (
  `Id_Demande` int(11) NOT NULL,
  `nb_personne` int(11) DEFAULT NULL,
  `date_resa` date DEFAULT NULL,
  `staut_demande` varchar(50) DEFAULT NULL,
  `Id_Tranche` int(11) NOT NULL,
  `Id_Salle` int(11) NOT NULL,
  `Id_Structure` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `demande`
--

INSERT INTO `demande` (`Id_Demande`, `nb_personne`, `date_resa`, `staut_demande`, `Id_Tranche`, `Id_Salle`, `Id_Structure`) VALUES
(1, 20, '2021-12-18', 'O', 3, 2, 3),
(2, 10, '2021-12-31', 'O', 2, 1, 1),
(3, 5, '2021-12-23', 'N', 1, 2, 1),
(4, 100, '2021-12-24', 'N', 3, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `Id_Periode` int(11) NOT NULL,
  `nom_periode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `periode`
--

INSERT INTO `periode` (`Id_Periode`, `nom_periode`) VALUES
(1, 'Journée'),
(2, 'Soirée'),
(3, '1/2 journee');

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `Id_Tranche` int(11) NOT NULL,
  `Id_Salle` int(11) NOT NULL,
  `Id_Date_P` int(11) NOT NULL,
  `Id_Demande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `planning`
--

INSERT INTO `planning` (`Id_Tranche`, `Id_Salle`, `Id_Date_P`, `Id_Demande`) VALUES
(3, 2, 1, 1),
(2, 1, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `Id_Profil` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `mdp` varchar(150) DEFAULT NULL,
  `mail` varchar(75) DEFAULT NULL,
  `Type_profil` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`Id_Profil`, `login`, `mdp`, `mail`, `Type_profil`) VALUES
(1, 'houeixa', 'a0be2a5cbd36805bb86b0207b58fe9ae99bc3eb567eb093f21b08c21e722fd3cfa4f1df893ce07f303732762dc1aef68e1fa0ecbc605cfef1e0bbda00bec1f38', 'houeixa@saintemarie-cholet.eu', '1'),
(2, 'Zone', 'c01e7b64d3ba8c9e30a249148d46d2bcb39b9dc378330553833dd96da88926b2fa2476664ffb5fd5f3bb0fda29d2cb3e0004b7c0f2b302d0b2ba94585a629664', 'guicheteaue@saintemarie-cholet.eu', '0'),
(3, 'martino', '9393feff98ea38da3dd152295caf77a9231a910f865e7e666701440a54c3b5cded26d04cc7a2a560791618cd63d93cf062befc9318e94a1fcc4b4bda8619eb8e', 'onneilmartin@gmail.com', '0'),
(4, 'theo', 'a0be2a5cbd36805bb86b0207b58fe9ae99bc3eb567eb093f21b08c21e722fd3cfa4f1df893ce07f303732762dc1aef68e1fa0ecbc605cfef1e0bbda00bec1f38', 'theodesmoulins@gmail.com', '1'),
(12, 'visiteur', '88ddd10e52b94a99acec2fd35b0188912852d2c82d67a5b15576180e2fcbe360d78dd9a8183a51bb74f6b5591985ad20ee005968b58d9b84462f920daa059051', 'visiteur@gmail.com', '0'),
(13, 'enzo', '6c824f130d1e4c32c9339797ff0ed77a3ea6700d26f101265122191b91e5647512ac5394a7bb03d87933f058330740971a2df582d39dda3782c264e6661e29c0', 'enzo.guicheteau@outlook.com', '0'),
(14, 'qhfMOL', '86923a2cf127cdd4338e6d2b4ecbff7bbb31784bcf16f3d8dc940ad6198cf1172404dbb010ae8457ee40d0c374fa3a69e021b2803aa030b1989a24fc24651a6d', 'qsfhoefh@gmail.com', '0');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `Id_Salle` int(11) NOT NULL,
  `nom_salle` varchar(50) DEFAULT NULL,
  `description` text,
  `nom_image` varchar(50) DEFAULT NULL,
  `Id_Categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`Id_Salle`, `nom_salle`, `description`, `nom_image`, `Id_Categorie`) VALUES
(1, 'Salle Etage', 'La salle Étage est certes la plus petite salle mise à disposition par nos soins. Elle est la plus sollicitée pour des événements sportifs de petite taille ou alors pour des entraînements de certaines petites associations ou clubs.', 'salle_des_fetes.jpg', 1),
(2, 'Salle Anjou et Authion ', 'La salle Anjou et Authion à une capacité moyenne d’environ 24 personnes. Elle est efficace pour les évènements de plus grandes tailles mais reste contrainte au niveau espace mais elle est par contre parfaite pour les associations et clubs plus grands.', 'img1.jpg', 2),
(3, 'Salle Maine et Loire ', 'La salle Maine-et-Loire est la plus grande salle que nous vous mettons à disposition. Avec sa capacité de 80 personnes elle permet des évènement plus conséquent et donc est équipée pour cela.', 'img2.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `structure`
--

CREATE TABLE `structure` (
  `Id_Structure` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `IBAN` varchar(50) DEFAULT NULL,
  `profil` varchar(50) DEFAULT NULL,
  `Id_Type_structure` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `structure`
--

INSERT INTO `structure` (`Id_Structure`, `nom`, `IBAN`, `profil`, `Id_Type_structure`) VALUES
(1, 'MESA Inc.', 'FR51426927318173', 'Zone', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tarif`
--

CREATE TABLE `tarif` (
  `Id_Tarif` int(11) NOT NULL,
  `prix` decimal(15,2) DEFAULT NULL,
  `Id_Categorie` int(11) NOT NULL,
  `Id_Type_structure` int(11) NOT NULL,
  `Id_Periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tarif`
--

INSERT INTO `tarif` (`Id_Tarif`, `prix`, `Id_Categorie`, `Id_Type_structure`, `Id_Periode`) VALUES
(1, '0.00', 1, 1, 3),
(2, '0.00', 1, 1, 1),
(3, '0.00', 1, 1, 2),
(4, '9.80', 1, 2, 3),
(5, '14.70', 1, 2, 1),
(6, '9.80', 1, 2, 2),
(7, '14.00', 1, 3, 3),
(8, '21.00', 1, 3, 1),
(9, '14.00', 1, 3, 2),
(10, '17.00', 1, 4, 3),
(11, '25.50', 1, 4, 1),
(12, '17.00', 1, 4, 2),
(13, '30.00', 1, 5, 3),
(14, '45.00', 1, 5, 1),
(15, '30.00', 1, 5, 2),
(16, '0.00', 2, 1, 3),
(17, '0.00', 2, 1, 1),
(18, '0.00', 2, 1, 2),
(19, '19.60', 2, 2, 3),
(20, '29.40', 2, 2, 1),
(21, '19.60', 2, 2, 2),
(22, '28.00', 2, 3, 3),
(23, '42.00', 2, 3, 1),
(24, '28.00', 2, 3, 2),
(25, '34.00', 2, 4, 3),
(26, '51.00', 2, 4, 1),
(27, '34.00', 2, 4, 2),
(28, '60.00', 2, 5, 3),
(29, '90.00', 2, 5, 1),
(30, '60.00', 2, 5, 2),
(31, '0.00', 3, 1, 3),
(32, '0.00', 3, 1, 1),
(33, '0.00', 3, 1, 2),
(34, '39.20', 3, 2, 3),
(35, '58.80', 3, 2, 1),
(36, '39.20', 3, 2, 2),
(37, '56.00', 3, 3, 3),
(38, '84.00', 3, 3, 1),
(39, '56.00', 3, 3, 2),
(40, '68.00', 3, 4, 3),
(41, '102.00', 3, 4, 1),
(42, '68.00', 3, 4, 2),
(43, '120.00', 3, 5, 3),
(44, '180.00', 3, 5, 1),
(45, '120.00', 3, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tranche`
--

CREATE TABLE `tranche` (
  `Id_Tranche` int(11) NOT NULL,
  `nom_tranche` varchar(50) DEFAULT NULL,
  `Id_Periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tranche`
--

INSERT INTO `tranche` (`Id_Tranche`, `nom_tranche`, `Id_Periode`) VALUES
(1, 'Matin', 3),
(2, 'Soirée', 2),
(3, 'Journée', 1),
(4, 'Apres-midi', 3);

-- --------------------------------------------------------

--
-- Structure de la table `type_structure`
--

CREATE TABLE `type_structure` (
  `Id_Type_structure` int(11) NOT NULL,
  `nom_type_structure` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_structure`
--

INSERT INTO `type_structure` (`Id_Type_structure`, `nom_type_structure`) VALUES
(1, 'CD Résidents'),
(2, 'Formation CD Résidents'),
(3, 'CD non résidents'),
(4, 'Mouvement sportif'),
(5, 'Hors mouvement sportif');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`Id_Categorie`);

--
-- Index pour la table `date_p`
--
ALTER TABLE `date_p`
  ADD PRIMARY KEY (`Id_Date_P`);

--
-- Index pour la table `demande`
--
ALTER TABLE `demande`
  ADD PRIMARY KEY (`Id_Demande`),
  ADD KEY `Id_Tranche` (`Id_Tranche`),
  ADD KEY `Id_Salle` (`Id_Salle`),
  ADD KEY `Id_Structure` (`Id_Structure`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`Id_Periode`);

--
-- Index pour la table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`Id_Tranche`,`Id_Salle`,`Id_Date_P`),
  ADD KEY `Id_Salle` (`Id_Salle`),
  ADD KEY `Id_Date_P` (`Id_Date_P`),
  ADD KEY `Id_Demande` (`Id_Demande`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`Id_Profil`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`Id_Salle`),
  ADD KEY `Id_Categorie` (`Id_Categorie`);

--
-- Index pour la table `structure`
--
ALTER TABLE `structure`
  ADD PRIMARY KEY (`Id_Structure`),
  ADD KEY `Id_Type_structure` (`Id_Type_structure`);

--
-- Index pour la table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`Id_Tarif`),
  ADD KEY `Id_Categorie` (`Id_Categorie`),
  ADD KEY `Id_Type_structure` (`Id_Type_structure`),
  ADD KEY `Id_Periode` (`Id_Periode`);

--
-- Index pour la table `tranche`
--
ALTER TABLE `tranche`
  ADD PRIMARY KEY (`Id_Tranche`),
  ADD KEY `Id_Periode` (`Id_Periode`);

--
-- Index pour la table `type_structure`
--
ALTER TABLE `type_structure`
  ADD PRIMARY KEY (`Id_Type_structure`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `Id_Categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `date_p`
--
ALTER TABLE `date_p`
  MODIFY `Id_Date_P` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `demande`
--
ALTER TABLE `demande`
  MODIFY `Id_Demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `periode`
--
ALTER TABLE `periode`
  MODIFY `Id_Periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `Id_Profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `Id_Salle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `structure`
--
ALTER TABLE `structure`
  MODIFY `Id_Structure` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `Id_Tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `tranche`
--
ALTER TABLE `tranche`
  MODIFY `Id_Tranche` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_structure`
--
ALTER TABLE `type_structure`
  MODIFY `Id_Type_structure` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`Id_Tranche`) REFERENCES `tranche` (`Id_Tranche`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`Id_Salle`) REFERENCES `salle` (`Id_Salle`),
  ADD CONSTRAINT `planning_ibfk_3` FOREIGN KEY (`Id_Date_P`) REFERENCES `date_p` (`Id_Date_P`),
  ADD CONSTRAINT `planning_ibfk_4` FOREIGN KEY (`Id_Demande`) REFERENCES `demande` (`Id_Demande`);

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`Id_Categorie`) REFERENCES `categorie` (`Id_Categorie`);

--
-- Contraintes pour la table `structure`
--
ALTER TABLE `structure`
  ADD CONSTRAINT `structure_ibfk_1` FOREIGN KEY (`Id_Type_structure`) REFERENCES `type_structure` (`Id_Type_structure`);

--
-- Contraintes pour la table `tarif`
--
ALTER TABLE `tarif`
  ADD CONSTRAINT `tarif_ibfk_1` FOREIGN KEY (`Id_Categorie`) REFERENCES `categorie` (`Id_Categorie`),
  ADD CONSTRAINT `tarif_ibfk_2` FOREIGN KEY (`Id_Type_structure`) REFERENCES `type_structure` (`Id_Type_structure`),
  ADD CONSTRAINT `tarif_ibfk_3` FOREIGN KEY (`Id_Periode`) REFERENCES `periode` (`Id_Periode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
