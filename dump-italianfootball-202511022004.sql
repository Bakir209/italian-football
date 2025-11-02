-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: italianfootball
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `home_team_id` int(11) NOT NULL,
  `away_team_id` int(11) NOT NULL,
  `home_score` int(11) NOT NULL DEFAULT 0,
  `away_score` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_home_team` (`home_team_id`),
  KEY `fk_away_team` (`away_team_id`),
  CONSTRAINT `fk_away_team` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `fk_home_team` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` VALUES (1,'2025-11-02',16,2,1,2),(2,'2025-11-01',11,3,1,2),(3,'2025-11-01',8,9,1,0),(4,'2025-11-01',4,12,0,0),(5,'2025-11-02',7,14,2,2);
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_team` (`team_id`),
  CONSTRAINT `fk_team` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` VALUES (1,'Riccardo','Orsolini','Italian','Right Winger',6),(2,'Hakan','Çalhanoğlu','Turkish','Midfielder',2),(3,'André-Frank','Anguissa','Cameroonian','Midfielder',4),(4,'Federico','Bonazzoli','Italian','Forward',11),(5,'Christian','Pulisic','American','Right Winger',1),(6,'Nicolás','Paz','Argentinian','Midfielder',12),(7,'Dusan','Vlahovic','Serbian','Striker',3),(8,'Kenan','Yildiz','Turkish','Winger',3),(9,'Nicolò','Zaniolo','Italian','Winger',8),(10,'Giovanni','Simeone','Argentinian','Striker',7),(11,'Ché','Adams','Scottish','Forward',7),(12,'Juan','Cuadrado','Colombian','Midfielder',14),(13,'Federico','Dimarco','Italian','Left-Back',2),(14,'Jari','Vandeputte','Belgian','Midfielder',11),(15,'Marcus','Thuram','French','Striker',2),(16,'Mile','Svilar','Serbian','Goalkeeper',5);
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playerstatistics`
--

DROP TABLE IF EXISTS `playerstatistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playerstatistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `goals` int(11) NOT NULL DEFAULT 0,
  `assists` int(11) NOT NULL DEFAULT 0,
  `yellow_cards` int(11) NOT NULL DEFAULT 0,
  `red_cards` int(11) NOT NULL DEFAULT 0,
  `passes` int(11) NOT NULL DEFAULT 0,
  `dribbles` int(11) NOT NULL DEFAULT 0,
  `tackles` int(11) NOT NULL DEFAULT 0,
  `saves` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_match` (`match_id`),
  KEY `fk_player` (`player_id`),
  KEY `fk_team_stats` (`team_id`),
  CONSTRAINT `fk_match` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_player` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  CONSTRAINT `fk_team_stats` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playerstatistics`
--

LOCK TABLES `playerstatistics` WRITE;
/*!40000 ALTER TABLE `playerstatistics` DISABLE KEYS */;
INSERT INTO `playerstatistics` VALUES (1,2,7,3,1,0,0,0,30,1,0,0),(2,2,8,3,0,1,0,0,45,3,1,0),(3,2,4,11,1,0,1,0,25,0,0,0),(4,2,14,11,0,1,0,0,60,2,2,0),(5,5,10,7,1,0,0,0,35,2,0,0),(6,5,11,7,1,0,0,0,20,1,0,0),(7,5,16,7,0,1,0,0,55,1,3,0),(8,5,12,14,1,0,0,0,40,4,1,0),(9,5,6,14,0,1,1,0,50,5,2,0);
/*!40000 ALTER TABLE `playerstatistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `stadium` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'AC Milan','Milan','Giuseppe Meazza'),(2,'Inter Milan','Milan','Giuseppe Meazza'),(3,'Juventus','Turin','Allianz Stadium'),(4,'Napoli','Naples','Diego Armando Maradona'),(5,'AS Roma','Rome','Stadio Olimpico'),(6,'Bologna','Bologna','Stadio Renato Dall\'Ara'),(7,'Torino','Turin','Olimpico Grande Torino'),(8,'Udinese','Udine','Bluenergy Stadium'),(9,'Atalanta','Bergamo','Gewiss Stadium'),(10,'Fiorentina','Florence','Artemio Franchi'),(11,'Cremonese','Cremona','Stadio Giovanni Zini'),(12,'Como','Como','Stadio Giuseppe Sinigaglia'),(13,'Parma','Parma','Stadio Ennio Tardini'),(14,'Pisa','Pisa','Arena Garibaldi'),(15,'Lecce','Lecce','Via del Mare'),(16,'Hellas Verona','Verona','Marcantonio Bentegodi'),(17,'Sassuolo','Sassuolo','MAPEI Stadium'),(18,'Cagliari','Cagliari','Unipol Domus'),(19,'Lazio','Rome','Stadio Olimpico'),(20,'Genoa','Genoa','Stadio Luigi Ferraris');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin_user','admin@seriea.it','$2y$10$HASHEDPASSWORD1',1),(2,'data_editor','editor@seriea.it','$2y$10$HASHEDPASSWORD2',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'italianfootball'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-02 20:04:53
