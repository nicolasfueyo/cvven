-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 03 fév. 2021 à 21:02
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
  `date_jour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `calendriervacances`
--

INSERT INTO `calendriervacances` (`id`, `date_jour`) VALUES
(1, '2021-02-06'),
(2, '2021-02-07'),
(3, '2021-02-08'),
(4, '2021-02-09'),
(5, '2021-02-10'),
(6, '2021-02-11'),
(7, '2021-02-12'),
(8, '2021-02-13'),
(9, '2021-02-14'),
(10, '2021-02-15'),
(11, '2021-02-16'),
(12, '2021-02-17'),
(13, '2021-02-18'),
(14, '2021-02-19'),
(15, '2021-02-20'),
(16, '2021-02-21');

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
(2, 'FUEYO RODRIGUEZ', 'lala@gmail.com', '$2y$10$pt0o.20oLOkWZNIl7WIVkeKLkXI.xa2DK5ySnM59bYaSUogwE9Jzu', 'Nicolas', '12122121', 'CLIENT', '9');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation_logement`
--
ALTER TABLE `reservation_logement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `typelogement`
--
ALTER TABLE `typelogement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
