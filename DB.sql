-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: PA
-- ------------------------------------------------------
-- Server version       10.11.6-MariaDB-0+deb12u1

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
-- Table structure for table `ABO`
--

DROP TABLE IF EXISTS `ABO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ABO` (
  `id_ABO` int(11) NOT NULL,
  `montant` int(11) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ABO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAPTCHA`
--

DROP TABLE IF EXISTS `CAPTCHA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAPTCHA` (
  `id_CAPTCHA` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) DEFAULT NULL,
  `reponse1` varchar(100) NOT NULL,
  `reponse2` varchar(100) NOT NULL DEFAULT `reponse1`,
  `reponse3` varchar(100) NOT NULL DEFAULT `reponse1`,
  `reponse4` varchar(100) NOT NULL DEFAULT `reponse1`,
  `reponse5` varchar(100) NOT NULL DEFAULT `reponse1`,
  PRIMARY KEY (`id_CAPTCHA`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CHOIX`
--

DROP TABLE IF EXISTS `CHOIX`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CHOIX` (
  `id_CHOIX` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) DEFAULT NULL,
  `choix_text` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0 COMMENT '1 si c''est une réponse correcte, 0 sinon',
  PRIMARY KEY (`id_CHOIX`),
  KEY `id_question` (`id_question`),
  CONSTRAINT `CHOIX_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `QUESTIONS` (`id_question`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CLASSE`
--

DROP TABLE IF EXISTS `CLASSE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASSE` (
  `id_CLASSE` int(11) NOT NULL,
  `type` char(1) DEFAULT NULL,
  `nom` varchar(10) DEFAULT NULL,
  `annee` char(9) DEFAULT NULL,
  `id_ecole` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_CLASSE`),
  KEY `id_ecole` (`id_ecole`),
  CONSTRAINT `CLASSE_ibfk_1` FOREIGN KEY (`id_ecole`) REFERENCES `ECOLE` (`id_ECOLE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `COURS`
--

DROP TABLE IF EXISTS `COURS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURS` (
  `id_COURS` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  `niveau` enum('debutant','intermediaire','avance') DEFAULT 'debutant',
  `prix` int(11) DEFAULT NULL,
  `id_USER` int(11) NOT NULL,
  `path_image_pres` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_COURS`),
  KEY `id_user` (`id_USER`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ECOLE`
--

DROP TABLE IF EXISTS `ECOLE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ECOLE` (
  `id_ECOLE` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `directeur` varchar(100) DEFAULT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `tel` char(10) DEFAULT NULL,
  `id_reseau` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ECOLE`),
  KEY `id_reseau` (`id_reseau`),
  CONSTRAINT `ECOLE_ibfk_1` FOREIGN KEY (`id_reseau`) REFERENCES `RESEAU` (`id_RESEAU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ELEVE`
--

DROP TABLE IF EXISTS `ELEVE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ELEVE` (
  `id_ELEVE` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `niveau` char(1) DEFAULT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `elo` int(11) DEFAULT NULL,
  `mot_de_passe` varchar(60) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ELEVE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GROUPE`
--

DROP TABLE IF EXISTS `GROUPE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GROUPE` (
  `id_GROUPE` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `créateur` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `taille` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_GROUPE`),
  KEY `créateur` (`créateur`),
  CONSTRAINT `GROUPE_ibfk_1` FOREIGN KEY (`créateur`) REFERENCES `USER` (`id_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LIKES_COURS`
--

DROP TABLE IF EXISTS `LIKES_COURS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LIKES_COURS` (
  `id_like` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  PRIMARY KEY (`id_like`),
  KEY `id_user` (`id_user`),
  KEY `id_cours` (`id_cours`),
  CONSTRAINT `LIKES_COURS_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_USER`),
  CONSTRAINT `LIKES_COURS_ibfk_2` FOREIGN KEY (`id_cours`) REFERENCES `COURS` (`id_COURS`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LOGS`
--

DROP TABLE IF EXISTS `LOGS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LOGS` (
  `id_LOGS` int(11) NOT NULL AUTO_INCREMENT,
  `act` text DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_LOGS`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `LOGS_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_USER`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MEMBRE`
--

DROP TABLE IF EXISTS `MEMBRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MEMBRE` (
  `id_MEMBRE` int(11) NOT NULL,
  `accept_news` tinyint(1) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `groupe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_MEMBRE`),
  KEY `user` (`user`),
  KEY `groupe` (`groupe`),
  CONSTRAINT `MEMBRE_ibfk_1` FOREIGN KEY (`user`) REFERENCES `USER` (`id_USER`),
  CONSTRAINT `MEMBRE_ibfk_2` FOREIGN KEY (`groupe`) REFERENCES `GROUPE` (`id_GROUPE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `NEWS`
--

DROP TABLE IF EXISTS `NEWS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NEWS` (
  `id_NEWS` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `sent_at` timestamp NULL DEFAULT current_timestamp(),
  `sent_by` int(11) DEFAULT NULL,
  `sent_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_NEWS`),
  KEY `sent_by` (`sent_by`),
  KEY `sent_to` (`sent_to`),
  CONSTRAINT `NEWS_ibfk_1` FOREIGN KEY (`sent_by`) REFERENCES `USER` (`id_USER`),
  CONSTRAINT `NEWS_ibfk_2` FOREIGN KEY (`sent_to`) REFERENCES `GROUPE` (`id_GROUPE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PARAGRAPHE`
--

DROP TABLE IF EXISTS `PARAGRAPHE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PARAGRAPHE` (
  `id_paragraphe` int(11) NOT NULL AUTO_INCREMENT,
  `id_titre` int(11) NOT NULL,
  `contenu` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_paragraphe`),
  KEY `id_titre` (`id_titre`),
  CONSTRAINT `PARAGRAPHE_ibfk_1` FOREIGN KEY (`id_titre`) REFERENCES `TITRE` (`id_titre`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `QUESTIONS`
--

DROP TABLE IF EXISTS `QUESTIONS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `QUESTIONS` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `id_quizz` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  PRIMARY KEY (`id_question`),
  KEY `id_quizz` (`id_quizz`),
  CONSTRAINT `QUESTIONS_ibfk_1` FOREIGN KEY (`id_quizz`) REFERENCES `QUIZZ` (`id_QUIZZ`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `QUIZZ`
--

DROP TABLE IF EXISTS `QUIZZ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `QUIZZ` (
  `id_QUIZZ` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `id_cours` int(11) DEFAULT NULL,
  `path_img_pres` varchar(255) DEFAULT NULL,
  `path_content` varchar(255) DEFAULT NULL,
  `temps_limit` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_QUIZZ`),
  KEY `id_cours` (`id_cours`),
  CONSTRAINT `QUIZZ_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `COURS` (`id_COURS`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `RESEAU`
--

DROP TABLE IF EXISTS `RESEAU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RESEAU` (
  `id_RESEAU` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `responsable` varchar(150) DEFAULT NULL,
  `tel` char(10) DEFAULT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `id_abo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_RESEAU`),
  KEY `id_abo` (`id_abo`),
  CONSTRAINT `RESEAU_ibfk_1` FOREIGN KEY (`id_abo`) REFERENCES `ABO` (`id_ABO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `RESULTATS_QUIZZ`
--

DROP TABLE IF EXISTS `RESULTATS_QUIZZ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RESULTATS_QUIZZ` (
  `id_resultat` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_quizz` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `date_reponse` timestamp NULL DEFAULT current_timestamp(),
  `elo_avant` int(11) DEFAULT NULL,
  `elo_apres` int(11) DEFAULT NULL,
  `id_question` int(11) NOT NULL,
  `id_choice` int(11) NOT NULL,
  `is_selected` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_resultat`),
  KEY `id_user` (`id_user`),
  KEY `id_quizz` (`id_quizz`),
  KEY `FK_resultats_quiz_question` (`id_question`),
  KEY `FK_resultats_quiz_choice` (`id_choice`),
  CONSTRAINT `FK_resultats_quiz_choice` FOREIGN KEY (`id_choice`) REFERENCES `CHOIX` (`id_CHOIX`),
  CONSTRAINT `FK_resultats_quiz_question` FOREIGN KEY (`id_question`) REFERENCES `QUESTIONS` (`id_question`),
  CONSTRAINT `RESULTATS_QUIZZ_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_USER`),
  CONSTRAINT `RESULTATS_QUIZZ_ibfk_2` FOREIGN KEY (`id_quizz`) REFERENCES `QUIZZ` (`id_QUIZZ`)
) ENGINE=InnoDB AUTO_INCREMENT=432 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SECTIONS`
--

DROP TABLE IF EXISTS `SECTIONS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SECTIONS` (
  `id_section` int(11) NOT NULL AUTO_INCREMENT,
  `id_cours` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_section`),
  KEY `id_cours` (`id_cours`),
  CONSTRAINT `SECTIONS_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `COURS` (`id_COURS`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TICKET`
--

DROP TABLE IF EXISTS `TICKET`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TICKET` (
  `id_TICKET` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  PRIMARY KEY (`id_TICKET`),
  KEY `id_admin` (`id_admin`),
  KEY `id_client` (`id_client`),
  CONSTRAINT `TICKET_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `USER` (`id_USER`),
  CONSTRAINT `TICKET_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `USER` (`id_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TITRE`
--

DROP TABLE IF EXISTS `TITRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TITRE` (
  `id_titre` int(11) NOT NULL AUTO_INCREMENT,
  `id_section` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_titre`),
  KEY `id_section` (`id_section`),
  CONSTRAINT `TITRE_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `SECTIONS` (`id_section`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER` (
  `id_USER` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `validation_mail` tinyint(1) NOT NULL DEFAULT 0,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `elo` int(11) NOT NULL DEFAULT 0,
  `id_classe` int(11) DEFAULT 1,
  `path_pp` varchar(255) DEFAULT 'https://schoolpea.com/Images/PP_IMAGES/PP_TEST.jpg',
  `role` enum('classique','prof','admin') NOT NULL DEFAULT 'classique',
  `last_active` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `banni` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_USER`),
  KEY `idx_user_email` (`email`),
  KEY `idx_user_id_classe` (`id_classe`),
  CONSTRAINT `USER_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `CLASSE` (`id_CLASSE`),
  CONSTRAINT `fk_user_classe` FOREIGN KEY (`id_classe`) REFERENCES `CLASSE` (`id_CLASSE`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `date_heure` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_messages_author` (`author`),
  CONSTRAINT `fk_messages_author` FOREIGN KEY (`author`) REFERENCES `USER` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-07 15:36:31