-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: curul501
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_initiative` int(11) NOT NULL DEFAULT '0',
  `id_representative` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT now(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `commentable_id` int(11) DEFAULT NULL,
  `commentable_type` varchar(255) DEFAULT NULL,
  `tendency` int(11) DEFAULT NULL,
  `reply_to` int(11) DEFAULT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'aproved',
  `sendmail` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions`
--

DROP TABLE IF EXISTS `commissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions` (
  `id_commission` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `secretario` varchar(255) NOT NULL,
  PRIMARY KEY (`id_commission`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions`
--

LOCK TABLES `commissions` WRITE;
/*!40000 ALTER TABLE `commissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `commissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions2initiatives`
--

DROP TABLE IF EXISTS `commissions2initiatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions2initiatives` (
  `id_commission` int(11) NOT NULL,
  `id_initiative` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions2initiatives`
--

LOCK TABLES `commissions2initiatives` WRITE;
/*!40000 ALTER TABLE `commissions2initiatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `commissions2initiatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions2representatives`
--

DROP TABLE IF EXISTS `commissions2representatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions2representatives` (
  `id_commission` int(11) NOT NULL,
  `id_representative` int(11) NOT NULL,
  `id_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions2representatives`
--

LOCK TABLES `commissions2representatives` WRITE;
/*!40000 ALTER TABLE `commissions2representatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `commissions2representatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initiative2political_party`
--

DROP TABLE IF EXISTS `initiative2political_party`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initiative2political_party` (
  `id_initiative` int(11) NOT NULL,
  `id_political_party` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initiative2political_party`
--

LOCK TABLES `initiative2political_party` WRITE;
/*!40000 ALTER TABLE `initiative2political_party` DISABLE KEYS */;
/*!40000 ALTER TABLE `initiative2political_party` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initiative2representatives`
--

DROP TABLE IF EXISTS `initiative2representatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initiative2representatives` (
  `id_initiative` int(11) NOT NULL,
  `id_representative` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initiative2representatives`
--

LOCK TABLES `initiative2representatives` WRITE;
/*!40000 ALTER TABLE `initiative2representatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `initiative2representatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initiatives`
--

DROP TABLE IF EXISTS `initiatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initiatives` (
  `id_initiative` int(11) NOT NULL AUTO_INCREMENT,
  `id_legislature` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `presented_at` timestamp NULL DEFAULT NULL,
  `description` text NOT NULL,
  `title` text NOT NULL,
  `short_title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `presented_by` varchar(255) DEFAULT NULL,
  `additional_resources` text,
  `additional_resources_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `official_vote_up` int(11) DEFAULT '0',
  `official_vote_down` int(11) DEFAULT '0',
  `voted_at` timestamp NULL DEFAULT NULL,
  `official_vote_abstentions` int(11) DEFAULT NULL,
  `comments_count` int(11) DEFAULT '0',
  `number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_initiative`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initiatives`
--

LOCK TABLES `initiatives` WRITE;
/*!40000 ALTER TABLE `initiatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `initiatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initiatives2status`
--

DROP TABLE IF EXISTS `initiatives2status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initiatives2status` (
  `id_initiative` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_initiative`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initiatives2status`
--

LOCK TABLES `initiatives2status` WRITE;
/*!40000 ALTER TABLE `initiatives2status` DISABLE KEYS */;
/*!40000 ALTER TABLE `initiatives2status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initiatives2topics`
--

DROP TABLE IF EXISTS `initiatives2topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initiatives2topics` (
  `id_initiative` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initiatives2topics`
--

LOCK TABLES `initiatives2topics` WRITE;
/*!40000 ALTER TABLE `initiatives2topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `initiatives2topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `legislatures`
--

DROP TABLE IF EXISTS `legislatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `legislatures` (
  `id_legislature` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_legislature`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `legislatures`
--

LOCK TABLES `legislatures` WRITE;
/*!40000 ALTER TABLE `legislatures` DISABLE KEYS */;
/*!40000 ALTER TABLE `legislatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT now(),
  `action` varchar(45) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `political_parties`
--

DROP TABLE IF EXISTS `political_parties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `political_parties` (
  `id_political_party` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `url_logo` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT now(),
  PRIMARY KEY (`id_political_party`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `political_parties`
--

LOCK TABLES `political_parties` WRITE;
/*!40000 ALTER TABLE `political_parties` DISABLE KEYS */;
/*!40000 ALTER TABLE `political_parties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `positions` (
  `id_position` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_position`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `representatives`
--

DROP TABLE IF EXISTS `representatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `representatives` (
  `id_representative` int(11) NOT NULL AUTO_INCREMENT,
  `id_political_party` int(11) NOT NULL,
  `id_legislature` int(11) NOT NULL,
  `id_position` int(11) DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `biography` text,
  `birthday` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `substitute` varchar(255) DEFAULT NULL,
  `election_type` varchar(255) DEFAULT NULL,
  `old_commissions` varchar(255) DEFAULT NULL,
  `circumscription` varchar(255) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_representative`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representatives`
--

LOCK TABLES `representatives` WRITE;
/*!40000 ALTER TABLE `representatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `representatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_migrations` (
  `version` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_migrations`
--

LOCK TABLES `schema_migrations` WRITE;
/*!40000 ALTER TABLE `schema_migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `schema_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'un status puede ser en comision',
  `description` text NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id_topic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(45) NOT NULL DEFAULT 'member',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `avatar_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='usuarios del sistema, ejemplo administradores, y usuarios qu /* comment truncated */ /*e se registren en el portal*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits2initiatives`
--

DROP TABLE IF EXISTS `visits2initiatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits2initiatives` (
  `id_visit` int(11) NOT NULL AUTO_INCREMENT,
  `id_initiative` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  PRIMARY KEY (`id_visit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits2initiatives`
--

LOCK TABLES `visits2initiatives` WRITE;
/*!40000 ALTER TABLE `visits2initiatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits2initiatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits2representatives`
--

DROP TABLE IF EXISTS `visits2representatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits2representatives` (
  `id_visit` int(11) NOT NULL AUTO_INCREMENT,
  `id_representative` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT now(),
  PRIMARY KEY (`id_visit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits2representatives`
--

LOCK TABLES `visits2representatives` WRITE;
/*!40000 ALTER TABLE `visits2representatives` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits2representatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votes` (
  `id_vote` int(11) NOT NULL AUTO_INCREMENT,
  `id_initiative` int(11) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '1',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'TRUE a favor, FALSE en contra',
  `created_at` timestamp NOT NULL DEFAULT now(),
  PRIMARY KEY (`id_vote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes2comments`
--

DROP TABLE IF EXISTS `votes2comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votes2comments` (
  `id_vote` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_commnet` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'true=favor false=contra',
  `created_at` timestamp NOT NULL DEFAULT now(),
  PRIMARY KEY (`id_vote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes2comments`
--

LOCK TABLES `votes2comments` WRITE;
/*!40000 ALTER TABLE `votes2comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes2comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes_users`
--

DROP TABLE IF EXISTS `votes_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votes_users` (
  `id_vote` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_initiative` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'true= favor false=contra\n',
  `created_at` timestamp NOT NULL DEFAULT now(),
  PRIMARY KEY (`id_vote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes_users`
--

LOCK TABLES `votes_users` WRITE;
/*!40000 ALTER TABLE `votes_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-12 18:59:39
