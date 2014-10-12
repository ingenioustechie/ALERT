-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: alert
-- ------------------------------------------------------
-- Server version	5.5.38-0ubuntu0.14.04.1

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
-- Table structure for table `trainers_workshops`
--

DROP TABLE IF EXISTS `trainers_workshops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trainers_workshops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainerId` int(11) DEFAULT NULL,
  `workshopId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainers_workshops`
--

LOCK TABLES `trainers_workshops` WRITE;
/*!40000 ALTER TABLE `trainers_workshops` DISABLE KEYS */;
/*!40000 ALTER TABLE `trainers_workshops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userGroups`
--

DROP TABLE IF EXISTS `userGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userGroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userGroups`
--

LOCK TABLES `userGroups` WRITE;
/*!40000 ALTER TABLE `userGroups` DISABLE KEYS */;
INSERT INTO `userGroups` VALUES (1,'Volunteer'),(2,'Trainer'),(3,'Admin');
/*!40000 ALTER TABLE `userGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `contactNo` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tempAddress` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `comment` text,
  `createdOn` datetime DEFAULT NULL,
  `modifiedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,NULL,'0000-00-00',2147483647,'mak.gnu@gmail.com',NULL,'Soemthing ',NULL,'2014-10-11 08:58:30','2014-10-11 08:58:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_stages`
--

DROP TABLE IF EXISTS `volunteer_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stageName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_stages`
--

LOCK TABLES `volunteer_stages` WRITE;
/*!40000 ALTER TABLE `volunteer_stages` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_stages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteers_workshops`
--

DROP TABLE IF EXISTS `volunteers_workshops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteers_workshops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `volunteerId` int(11) DEFAULT NULL,
  `workshopId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteers_workshops`
--

LOCK TABLES `volunteers_workshops` WRITE;
/*!40000 ALTER TABLE `volunteers_workshops` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteers_workshops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workshops`
--

DROP TABLE IF EXISTS `workshops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workshops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workshopTypeId` int(11) DEFAULT NULL,
  `workshopDate` date DEFAULT NULL,
  `timeFrom` time DEFAULT NULL,
  `timeTo` time DEFAULT NULL,
  `noOfAttendees` int(10) DEFAULT NULL,
  `clientId` int(11) DEFAULT NULL,
  `dateEnquiry` datetime DEFAULT NULL,
  `contactPerson` varchar(255) DEFAULT NULL,
  `contactNo` bigint(20) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `docter` varchar(255) DEFAULT NULL,
  `noOfCertificate` int(10) DEFAULT NULL,
  `noOfKits` int(10) DEFAULT NULL,
  `noOfCds` int(10) DEFAULT NULL,
  `noOfManuals` int(10) DEFAULT NULL,
  `noOfStickers` int(10) DEFAULT NULL,
  `createOn` datetime DEFAULT NULL,
  `modifiedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workshops`
--

LOCK TABLES `workshops` WRITE;
/*!40000 ALTER TABLE `workshops` DISABLE KEYS */;
INSERT INTO `workshops` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `workshops` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-12 11:58:06
