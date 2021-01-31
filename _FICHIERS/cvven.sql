-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cvven
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `calendriervacances`
--

DROP TABLE IF EXISTS `calendriervacances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendriervacances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_jour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendriervacances`
--

LOCK TABLES `calendriervacances` WRITE;
/*!40000 ALTER TABLE `calendriervacances` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendriervacances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) NOT NULL,
  `prix_total` float NOT NULL,
  `date_entree` date NOT NULL,
  `date_sortie` date NOT NULL,
  `etat` varchar(20) NOT NULL,
  `type_sejour` varchar(20) NOT NULL,
  `menage_fin_sejour_inclus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_logement`
--

DROP TABLE IF EXISTS `reservation_logement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_typelogement` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_typelogement` (`id_typelogement`),
  KEY `id_reservation` (`id_reservation`),
  CONSTRAINT `reservation_logement_ibfk_1` FOREIGN KEY (`id_typelogement`) REFERENCES `typelogement` (`id`),
  CONSTRAINT `reservation_logement_ibfk_2` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_logement`
--

LOCK TABLES `reservation_logement` WRITE;
/*!40000 ALTER TABLE `reservation_logement` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_logement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typelogement`
--

DROP TABLE IF EXISTS `typelogement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typelogement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `nbpersonnes` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `nbLogements` int(11) NOT NULL,
  `prixParNuitee` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typelogement`
--

LOCK TABLES `typelogement` WRITE;
/*!40000 ALTER TABLE `typelogement` DISABLE KEYS */;
/*!40000 ALTER TABLE `typelogement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `mdp` varchar(256) DEFAULT NULL,
  `prenom` varchar(32) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `adresse` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_uindex` (`email`),
  UNIQUE KEY `user_tel_uindex` (`tel`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (2,'FUEYO RODRIGUEZ','lala@gmail.com','$2y$10$pt0o.20oLOkWZNIl7WIVkeKLkXI.xa2DK5ySnM59bYaSUogwE9Jzu','Nicolas','12122121','CLIENT','9');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-31 21:55:45
