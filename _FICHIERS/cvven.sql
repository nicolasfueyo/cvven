-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 08 mai 2021 à 19:16
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cvven`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendriervacances`
--

CREATE TABLE `calendriervacances` (
  `id` int(11) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `calendriervacances`
--

INSERT INTO `calendriervacances` (`id`, `date_debut`, `date_fin`) VALUES
(1, '2021-07-03', '2021-08-28'),
(2, '2021-12-25', '2022-01-08');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `prix_total` float NOT NULL,
  `date_entree` date NOT NULL,
  `date_sortie` date NOT NULL,
  `etat` varchar(20) NOT NULL,
  `type_sejour` varchar(20) NOT NULL,
  `menage_fin_sejour_inclus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `utilisateur_id`, `prix_total`, `date_entree`, `date_sortie`, `etat`, `type_sejour`, `menage_fin_sejour_inclus`) VALUES
(8, 5, 1730, '2021-07-10', '2021-07-17', 'VALIDE', 'PENSION COMPLETE', 1),
(10, 5, 980, '2021-08-07', '2021-08-14', 'VALIDE', 'PENSION COMPLETE', 0),
(11, 6, 3080, '2021-07-10', '2021-07-17', 'VALIDE', 'PENSION COMPLETE', 0),
(12, 6, 4325, '2021-07-10', '2021-07-17', 'VALIDE', 'PENSION COMPLETE', 1),
(15, 6, 2150, '2021-07-10', '2021-07-17', 'NON-VALIDE', 'DEMI-PENSION', 1),
(16, 6, 1050, '2021-07-10', '2021-07-17', 'NON-VALIDE', 'DEMI-PENSION', 0),
(19, 6, 795, '2021-07-10', '2021-07-17', 'VALIDE', 'PENSION COMPLETE', 1),
(20, 6, 2100, '2021-07-10', '2021-07-17', 'NON-VALIDE', 'DEMI-PENSION', 0),
(22, 6, 690, '2021-07-17', '2021-07-24', 'NON-VALIDE', 'DEMI-PENSION', 1),
(25, 6, 2385, '0000-00-00', '0000-00-00', 'NON-VALIDE', 'PENSION COMPLETE', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reservation_logement`
--

CREATE TABLE `reservation_logement` (
  `id` int(11) NOT NULL,
  `id_typelogement` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservation_logement`
--

INSERT INTO `reservation_logement` (`id`, `id_typelogement`, `id_reservation`, `quantite`) VALUES
(7, 2, 8, 2),
(9, 5, 10, 1),
(10, 3, 11, 4),
(11, 2, 12, 13),
(14, 1, 15, 2),
(15, 1, 16, 1),
(18, 3, 19, 1),
(19, 1, 20, 2),
(21, 4, 22, 1);

-- --------------------------------------------------------

--
-- Structure de la table `typelogement`
--

CREATE TABLE `typelogement` (
  `id` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `nb_personnes` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `nb_logements` int(11) NOT NULL,
  `prix_par_nuitee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `typelogement`
--

INSERT INTO `typelogement` (`id`, `nom`, `nb_personnes`, `description`, `nb_logements`, `prix_par_nuitee`) VALUES
(1, 'Logement', 4, 'Entrée, douche et wc, 2 chambres à 2 lits avec coin toilette et balcon', 40, 150),
(2, 'Chambre double', 2, 'Entrée, douche et wc, 1 lit double', 15, 100),
(3, 'Chambre de 3 lits simples', 3, '3 lits séparés par une cloison mobile avec coin toilette, wc, douche.', 8, 90),
(4, 'Chambre de 4 lits simples', 4, 'Lits séparés par une cloison mobile avec douche, wc et balcon.', 12, 95),
(5, 'Logement à mobilité réduite', 1, 'Logement adapté pour les personnes à mobilité réduite', 1, 120);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `mdp` varchar(256) DEFAULT NULL,
  `prenom` varchar(32) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `adresse` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `email`, `mdp`, `prenom`, `tel`, `role`, `adresse`) VALUES
(3, 'Admin', 'admin@gmail.com', '$2y$10$pQdEFOkHgdST497jgJifwOXnYAz60VQFbLHIEah46ARp41VJg4/gS', 'Admin', '123456789', 'ADMIN', 'Test'),
(5, 'FUEYO', 'bf@gmail.com', '$2y$10$XwC079m.12AZCiSm4QZ7COIexFOAjNv78gOPmKcJAtHagXHr7j.UG', 'Benoit', '123456780', 'CLIENT', '9 rue de paris'),
(6, 'fueyo ', 'nicolas93100.fueyo@gmail.com', '$2y$10$.Ay8sCxhCyr2WajsIMqfeOBI.9oLqV79UNK9aPWYQ2UC47UUX8nrW', 'charles', '897987979', 'CLIENT', '9 rien ');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `calendriervacances`
--
ALTER TABLE `calendriervacances`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `reservation_logement`
--
ALTER TABLE `reservation_logement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_typelogement` (`id_typelogement`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Index pour la table `typelogement`
--
ALTER TABLE `typelogement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_uindex` (`email`),
  ADD UNIQUE KEY `user_tel_uindex` (`tel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `calendriervacances`
--
ALTER TABLE `calendriervacances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `reservation_logement`
--
ALTER TABLE `reservation_logement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `typelogement`
--
ALTER TABLE `typelogement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `reservation_logement`
--
ALTER TABLE `reservation_logement`
  ADD CONSTRAINT `reservation_logement_ibfk_1` FOREIGN KEY (`id_typelogement`) REFERENCES `typelogement` (`id`),
  ADD CONSTRAINT `reservation_logement_ibfk_2` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
