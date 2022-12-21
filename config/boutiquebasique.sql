-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 déc. 2022 à 10:52
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutiquebasique`
--
CREATE DATABASE IF NOT EXISTS `boutiquebasique` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `boutiquebasique`;

-- --------------------------------------------------------

--
-- Structure de la table `categoryproduit`
--

CREATE TABLE `categoryproduit` (
                                   `CATEGORY_ID` int(11) NOT NULL,
                                   `CATEGORY_NAME` varchar(100) NOT NULL,
                                   `CATEGORY_LOGO` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categoryproduit`
--

INSERT INTO `categoryproduit` (`CATEGORY_ID`, `CATEGORY_NAME`, `CATEGORY_LOGO`) VALUES
                                                                                    (1, 'forgeron', 'forgeron.jpg'),
                                                                                    (2, 'marchand ambulant', 'marchandambulant.png'),
                                                                                    (3, 'boulanger', 'boulanger.jpg'),
                                                                                    (4, 'alchimiste', 'alchimiste.png'),
                                                                                    (5, 'chasseur', 'chasseur.jpg'),
                                                                                    (6, 'dompteur', 'dompteur.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
                          `CLIENT_ID` int(11) NOT NULL,
                          `CLIENT_PRENOM` varchar(50) NOT NULL,
                          `CLIENT_NOM` varchar(50) NOT NULL,
                          `CLIENT_NAISSANCE` date DEFAULT NULL,
                          `CLIENT_MAIL` varchar(200) NOT NULL,
                          `CLIENT_PASSWORD` varchar(200) NOT NULL,
                          `CLIENT_ROLE` enum('CLIENT','ADMIN') NOT NULL DEFAULT 'CLIENT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`CLIENT_ID`, `CLIENT_PRENOM`, `CLIENT_NOM`, `CLIENT_NAISSANCE`, `CLIENT_MAIL`, `CLIENT_PASSWORD`, `CLIENT_ROLE`) VALUES
                                                                                                                                           (3, 'Hugo', 'DECRYPT', '2000-07-14', 'hdecrypt@gmail.com', '$2y$10$zj5c5Xn14uNi26AE2sY3qOGChaD4IKh3iLh1iMgfvsHAuLTPYISZ.', 'CLIENT'),
                                                                                                                                           (4, 'Daniel', 'GAGNANT', '1994-07-25', 'dgagnant@gmail.com', '$2y$10$9SdmIl4Fs7WMj4wQcL9pDuN565P42MAsy94foA7YookfXtfbSC7mG', 'CLIENT'),
                                                                                                                                           (5, 'Melchior', 'CHEVALIER', '2010-10-14', 'mchevalier@gmail.com', '$2y$10$pOHj/oMK5xNx8yWN9ldL.uz3Cdm5rmOtOJx/fVLgYKk1fr2UWZa16', 'CLIENT'),
                                                                                                                                           (11, 'Mathias', 'GHANEM', '1998-06-07', 'mghanam@gmail.com', '1234', 'CLIENT'),
                                                                                                                                           (16, 'titi', 'GROSMINET', '1991-07-13', 'tgrominet@gmail.com', '1234', 'CLIENT'),
                                                                                                                                           (17, 'Salima', 'THEUSE', '1612-06-28', 'stheuse@gmail.com', '$2y$10$OqZGZLP2sMyHfUwxuDakKe1q3wkwrBuQnjMuLtV/PmyCL/DJJNNWu', 'CLIENT'),
                                                                                                                                           (29, 'ADMIN', 'ADMIN', '2022-11-29', 'admin@boutiquebasique.com', '$2y$10$dfWohK3ItMGxr2KxjNHoOu1gQ1D6ssXO51ylKcLtTqTgVZnpjZevu', 'ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
                            `COMMANDE_ID` int(11) NOT NULL,
                            `CLIENT_ID` int(11) NOT NULL,
                            `COMMANDE_DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`COMMANDE_ID`, `CLIENT_ID`, `COMMANDE_DATE`) VALUES
                                                                         (1, 3, '2016-09-01 00:00:00'),
                                                                         (2, 3, '2018-07-04 00:00:00'),
                                                                         (3, 4, '2019-09-04 00:00:00'),
                                                                         (4, 4, '2022-06-05 00:00:00'),
                                                                         (6, 17, '2022-10-28 00:00:00'),
                                                                         (7, 17, '2022-10-28 00:00:00'),
                                                                         (8, 4, '2022-11-07 00:00:00'),
                                                                         (9, 4, '2022-11-07 10:40:14'),
                                                                         (10, 4, '2022-11-07 16:21:21'),
                                                                         (11, 17, '2022-11-08 17:02:04'),
                                                                         (12, 17, '2022-11-09 13:17:29'),
                                                                         (13, 17, '2022-11-09 13:18:02'),
                                                                         (14, 17, '2022-11-09 14:44:31'),
                                                                         (16, 17, '2022-11-17 16:08:55'),
                                                                         (20, 5, '2022-11-22 11:43:10'),
                                                                         (21, 5, '2022-11-22 11:49:14'),
                                                                         (26, 5, '2022-11-22 14:41:30'),
                                                                         (28, 5, '2022-11-22 14:44:21'),
                                                                         (31, 5, '2022-11-22 14:57:34'),
                                                                         (33, 5, '2022-11-22 15:00:53'),
                                                                         (34, 5, '2022-11-22 15:28:28'),
                                                                         (35, 5, '2022-11-22 16:29:15'),
                                                                         (36, 17, '2022-11-23 15:00:55'),
                                                                         (37, 17, '2022-11-23 15:36:10'),
                                                                         (38, 17, '2022-11-24 14:06:56'),
                                                                         (39, 5, '2022-11-28 17:56:27'),
                                                                         (40, 4, '2022-11-29 14:14:07'),
                                                                         (41, 4, '2022-12-21 10:17:12');

-- --------------------------------------------------------

--
-- Structure de la table `lignecommande`
--

CREATE TABLE `lignecommande` (
                                 `COMMANDE_ID` int(11) NOT NULL,
                                 `PRODUIT_ID` int(11) NOT NULL,
                                 `QUANTITE` int(11) NOT NULL,
                                 `PRIX` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `lignecommande`
--

INSERT INTO `lignecommande` (`COMMANDE_ID`, `PRODUIT_ID`, `QUANTITE`, `PRIX`) VALUES
                                                                                  (1, 1, 1, '1801'),
                                                                                  (1, 4, 1, '550'),
                                                                                  (2, 2, 2, '50'),
                                                                                  (3, 3, 2, '900'),
                                                                                  (4, 1, 1, '1801'),
                                                                                  (6, 2, 2, '40'),
                                                                                  (6, 13, 1, '190'),
                                                                                  (6, 19, 1, '27'),
                                                                                  (6, 22, 1, '55'),
                                                                                  (7, 19, 2, '27'),
                                                                                  (7, 22, 1, '55'),
                                                                                  (8, 2, 1, '40'),
                                                                                  (8, 19, 1, '27'),
                                                                                  (9, 13, 1, '190'),
                                                                                  (9, 19, 1, '27'),
                                                                                  (10, 2, 2, '40'),
                                                                                  (10, 13, 3, '190'),
                                                                                  (10, 19, 1, '27'),
                                                                                  (10, 22, 1, '55'),
                                                                                  (11, 2, 1, '40'),
                                                                                  (11, 19, 1, '27'),
                                                                                  (12, 28, 1, '55'),
                                                                                  (13, 13, 1, '190'),
                                                                                  (13, 19, 1, '27'),
                                                                                  (14, 2, 1, '40'),
                                                                                  (14, 19, 1, '27'),
                                                                                  (16, 1, 2, '1218'),
                                                                                  (16, 2, 3, '40'),
                                                                                  (20, 1, 3, '1218'),
                                                                                  (21, 3, 3, '1050'),
                                                                                  (21, 4, 1, '580'),
                                                                                  (21, 19, 3, '27'),
                                                                                  (26, 1, 2, '1218'),
                                                                                  (26, 2, 1, '40'),
                                                                                  (28, 1, 2, '1218'),
                                                                                  (28, 13, 1, '190'),
                                                                                  (31, 1, 1, '1218'),
                                                                                  (33, 3, 1, '1050'),
                                                                                  (33, 4, 2, '580'),
                                                                                  (34, 4, 2, '580'),
                                                                                  (35, 1, 1, '1218'),
                                                                                  (35, 2, 1, '40'),
                                                                                  (35, 3, 1, '1050'),
                                                                                  (36, 1, 2, '1218'),
                                                                                  (36, 3, 1, '1050'),
                                                                                  (36, 4, 1, '580'),
                                                                                  (37, 1, 1, '1218'),
                                                                                  (37, 2, 1, '40'),
                                                                                  (37, 4, 1, '580'),
                                                                                  (38, 1, 1, '1218'),
                                                                                  (38, 2, 2, '40'),
                                                                                  (39, 1, 1, '1218'),
                                                                                  (39, 2, 1, '40'),
                                                                                  (40, 1, 3, '1218'),
                                                                                  (40, 2, 1, '40'),
                                                                                  (41, 1, 1, '1218');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
                           `PRODUIT_ID` int(11) NOT NULL,
                           `PRODUIT_NOM` varchar(50) NOT NULL,
                           `PRODUIT_PRIX` decimal(10,0) NOT NULL,
                           `PRODUIT_IMAGE` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`PRODUIT_ID`, `PRODUIT_NOM`, `PRODUIT_PRIX`, `PRODUIT_IMAGE`) VALUES
                                                                                         (1, 'SUPER ORDINATEUR', '1218', 'superordi.webp'),
                                                                                         (2, 'souris ergonomique', '40', 'sourisergo.jfif'),
                                                                                         (3, 'ecran plat 2m x 2m', '1057', 'ecranplat.jpg'),
                                                                                         (4, 'enceinte sono ultra puissante', '580', 'enceintesono.jpg'),
                                                                                         (13, 'CLAVIER RETROECLAIRE', '190', 'clavier.webp'),
                                                                                         (19, 'SuperSouris', '27', 'supersouris.webp'),
                                                                                         (22, 'clef usb 20 go', '55', 'clefusbpro.jpg'),
                                                                                         (28, 'SOURIS GAMER', '55', 'sourisgamer.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
    ADD PRIMARY KEY (`CLIENT_ID`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
    ADD PRIMARY KEY (`COMMANDE_ID`),
  ADD KEY `FK_CLIENT_COMMANDE` (`CLIENT_ID`);

--
-- Index pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
    ADD PRIMARY KEY (`COMMANDE_ID`,`PRODUIT_ID`),
  ADD KEY `FK_LIGNECOMMANDE_PRODUIT` (`PRODUIT_ID`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
    ADD PRIMARY KEY (`PRODUIT_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
    MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
    MODIFY `COMMANDE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
    MODIFY `PRODUIT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
    ADD CONSTRAINT `FK_CLIENT_COMMANDE` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`CLIENT_ID`);

--
-- Contraintes pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
    ADD CONSTRAINT `FK_LIGNECOMMANDE_COMMANDE` FOREIGN KEY (`COMMANDE_ID`) REFERENCES `commande` (`COMMANDE_ID`),
  ADD CONSTRAINT `FK_LIGNECOMMANDE_PRODUIT` FOREIGN KEY (`PRODUIT_ID`) REFERENCES `produit` (`PRODUIT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
