-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 28 Mai 2020 à 21:14
-- Version du serveur :  5.7.30-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.4

-- ------------------------------------------------------
-- La base de données a été conçue et codée par Victor SOULIE.
--
-- REMARQUE : je ne suis pas parvenu à faire apparaître les clés étrangères.
-- ------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetPoker`
--

-- --------------------------------------------------------

--
-- Suppression des tables existantes
--

--
-- Suppression de la table `Tournoi`
--
DROP TABLE IF EXISTS `tournoi`;
--
-- Suppression de la table `TableTournoi`
--
DROP TABLE IF EXISTS `tableTournoi`;
--
-- Suppression de la table `Archivage`
--
DROP TABLE IF EXISTS `archivage`;
--
-- Suppression de la table `Utilisateur`
--
DROP TABLE IF EXISTS `utilisateur`;
--
-- Suppression de la table `donneesJoueur`
--
DROP TABLE IF EXISTS `donneesJoueur`;

-- --------------------------------------------------------

--
-- Structure de la table `Tournoi`
--

CREATE TABLE IF NOT EXISTS `tournoi` (
  `id` int(11) NOT NULL,
  `nomTournoi` varchar(30) NOT NULL,
  `buyIn` decimal(11,2) NOT NULL,
  `lieu` varchar(30) NOT NULL,
  `cashPrize` decimal(11,2) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tableTournoi`
--

CREATE TABLE IF NOT EXISTS `tableTournoi` (
  `id` int(11) NOT NULL,
  `nombrePlace` int(2) NOT NULL,
  `numeroTableTournoi` int(2) NOT NULL,
  `idTournoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Archivage`
--

CREATE TABLE IF NOT EXISTS `archivage` (
  `id` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idTournoi` int(11) NOT NULL,
  `gainJoueur` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL,
  `nomUtilisateur` varchar(30) NOT NULL,
  `prenomUtilisateur` varchar(30) NOT NULL,
  `dateNaissance` DATE NOT NULL,
  `nationalite` varchar(10) NOT NULL,
  `genre` varchar(10) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `gain` decimal(11,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `login` varchar(15) NOT NULL,
  `password`varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `donneesJoueur`
--

CREATE TABLE IF NOT EXISTS `donneesJoueur` (
  `id` int(11) NOT NULL,
  `numeroPosition` int(2) NOT NULL,
  `stack` int(1) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idTableTournoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`id`);
--
-- Index pour la table `TableTournoi`
--
ALTER TABLE `tableTournoi`
  ADD PRIMARY KEY (`id`);
--
-- Index pour la table `Archivage`
--
ALTER TABLE `archivage`
  ADD PRIMARY KEY (`id`);
--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);
--
-- Index pour la table `donneesJoueur`
--
ALTER TABLE `donneesJoueur`
  ADD PRIMARY KEY (`id`);
  
-- --------------------------------------------------------

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `TableTournoi`
--
ALTER TABLE `tableTournoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Archivage`
--
ALTER TABLE `archivage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `donneesJoueur`
--
ALTER TABLE `donneesJoueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Insertion contenu 
--

-- --------------------------------------------------------

--
-- Contenu de la table `Tournoi`
--
INSERT INTO `tournoi` (`nomTournoi`, `buyIn`, `lieu`, `cashPrize`, `dateDebut`, `dateFin`, `status`) VALUES
('WORC', 500, 'online', 1000000, '2022-06-06', '2022-06-16', 'termine');
--
INSERT INTO `tournoi` (`nomTournoi`, `buyIn`, `lieu`, `cashPrize`, `dateDebut`, `dateFin`, `status`) VALUES
('GYTO', 300, 'villeneuve-dAscq', 800000, '2022-09-08', '2022-06-16', 'non_commence');
--
INSERT INTO `tournoi` (`nomTournoi`, `buyIn`, `lieu`, `cashPrize`, `dateDebut`, `dateFin`, `status`) VALUES
('OEPL', 1200, 'Hong Kong', 2000000, '2022-06-17', '2022-06-26', 'en_cours');
--
INSERT INTO `tournoi` (`nomTournoi`, `buyIn`, `lieu`, `cashPrize`, `dateDebut`, `dateFin`, `status`) VALUES
('PZJL', 1200, 'Hong Kong', 2000000, '2022-06-17', '2022-06-26', 'non_commence');

-- --------------------------------------------------------

--
-- Contenu de la table `TableTournoi`
--
INSERT INTO `tableTournoi` (`nombrePlace`, `numeroTableTournoi`, `idTournoi`) VALUES
(7, 1, 3);
--
INSERT INTO `tableTournoi` (`nombrePlace`, `numeroTableTournoi`, `idTournoi`) VALUES
(5, 2, 3);

-- --------------------------------------------------------

--
-- Contenu de la table `Archivage`
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(1, 1, 50000);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(2, 1, 125000);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(5, 1, 12300);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(2, 2, -15000);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(4, 2, 8900);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(1, 3, 16978);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(2, 3, 123.2);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(3, 3, 1200.50);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(3, 4, 89000);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(4, 3, 197000);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(5, 3, 4500);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(8, 3, 400);
--
INSERT INTO `archivage` (`idUtilisateur`, `idTournoi`, `gainJoueur`) VALUES
(9, 3, 89500);

-- --------------------------------------------------------

--
-- Contenu de la table `Utilisateur`
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('soulie', 'victor', '2001-02-26', 'français', 'homme', 'victor.soulie@centrale.centralelille.fr', 3500000, 'joueur', 'victor', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('lussato', 'ethan', '2001-09-17', 'français', 'homme', 'ethan.lussato@centrale.centralelille.fr', 1200, 'joueur', 'ethan', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('boulogne', 'florian', '2000-06-01', 'français', 'homme', 'florian.boulogne@centrale.centralelille.fr', -5600, 'joueur', 'florian', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('feng', 'yanli', '2001-12-13', 'français', 'homme', 'yanli.feng@centrale.centralelille.fr', 160000, 'joueur', 'feng', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('cao', 'youwei', '2002-05-06', 'français', 'homme', 'youwei.cao@centrale.centralelille.fr', -150000, 'joueur', 'youwei', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('dupond', 'marie', '1999-05-06', 'belge', 'femme', 'marie.dupond@centrale.centralelille.fr', 12300, 'joueur', 'marie', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('tintin', 'jeanne', '1987-05-06', 'espagnol', 'femme', 'jeanne.tintin@centrale.centralelille.fr', 78300, 'joueur', 'jeanne', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('tom', 'tom', '2002-05-06', 'français', 'homme', 'tom.tom@centrale.centralelille.fr', 0, 'admin', 'tom', 'mysql');
--
INSERT INTO `utilisateur` (`nomUtilisateur`, `prenomUtilisateur`, `dateNaissance`, `nationalite`, `genre`, `mail`, `gain`, `status`, `login`, `password`) VALUES ('ilg', 'ilg', '2002-05-06', 'français', 'femme', 'ilg.ilg@centrale.centralelille.fr', 0, 'croupier', 'ilg', 'mysql');

-- --------------------------------------------------------

--
-- Contenu de la table `DonneesJoueur`
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (1, 5200, 1, 1);
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (2, 7800, 5, 1);
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (3, 800, 4, 1);
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (4, 10000, 2, 1);
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (5, 10000, 3, 1);
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (1, 10000, 6, 2);
--
INSERT INTO `donneesJoueur` (`numeroPosition`, `stack`, `idUtilisateur`, `idTableTournoi`) VALUES (4, 5000, 7, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

