-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: pharmacy
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `access_log`
--

DROP TABLE IF EXISTS `access_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_log` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `ShopId` int(11) NOT NULL,
  `AccessPage` varchar(255) NOT NULL,
  `AccessCount` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `CurrentDateTime` timestamp NULL DEFAULT current_timestamp(),
  `IP` varchar(255) NOT NULL,
  `OS` varchar(255) NOT NULL,
  `Browser` varchar(255) NOT NULL,
  `Device` varchar(255) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `ISP` varchar(300) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ShopId` (`ShopId`),
  KEY `UserId` (`UserId`),
  KEY `id_no_2` (`UserId`),
  KEY `shop_id_2` (`ShopId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_log`
--

LOCK TABLES `access_log` WRITE;
/*!40000 ALTER TABLE `access_log` DISABLE KEYS */;
INSERT INTO `access_log` VALUES (1,0,0,'test',0,'0000-00-00','','2025-07-19 18:32:56','','','','','','','');
/*!40000 ALTER TABLE `access_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controller_information`
--

DROP TABLE IF EXISTS `controller_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controller_information` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) DEFAULT '0',
  `User` varchar(25) NOT NULL,
  `Password` text NOT NULL,
  `DecryptPassword` varchar(255) NOT NULL,
  `Designation` varchar(255) DEFAULT '0',
  `Phone` varchar(55) NOT NULL,
  `Address` text NOT NULL,
  `Admin` enum('Yes','No') NOT NULL DEFAULT 'No',
  `EditAccess` enum('Yes','No') NOT NULL DEFAULT 'No',
  `DeleteAccess` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Block` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Picture` varchar(255) NOT NULL DEFAULT '../public/assets/no_image.png',
  `CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastLogin` timestamp NULL DEFAULT NULL,
  `Token` varchar(300) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Phone` (`Phone`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controller_information`
--

LOCK TABLES `controller_information` WRITE;
/*!40000 ALTER TABLE `controller_information` DISABLE KEYS */;
INSERT INTO `controller_information` VALUES (1,'Shafayet Test','admin','$argon2i$v=19$m=65536,t=4,p=1$TlUwa3lwYkNYejF6TXNvVg$Kn/dKz/pn++Cb2+ZeDpES8h8M6q6cIiRz46oSPJH9Y8','123','Developer','01982985490','Mirpur-dhaka-bangladesh','No','Yes','Yes','No','../public/assets/no_image.png','2025-05-01 15:15:51','2025-05-04 10:44:57','461b9a59e436438f0f4bf7c8b52f25e74cd68659');
/*!40000 ALTER TABLE `controller_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controller_permission`
--

DROP TABLE IF EXISTS `controller_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controller_permission` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `MenuId` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `Creator` int(11) NOT NULL,
  `CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastUpdate` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `UserId` (`UserId`),
  KEY `user_id_2` (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controller_permission`
--

LOCK TABLES `controller_permission` WRITE;
/*!40000 ALTER TABLE `controller_permission` DISABLE KEYS */;
INSERT INTO `controller_permission` VALUES (1,1,'1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0','2022-10-27',2,'2022-04-25 04:50:34','2025-01-31 16:06:41');
/*!40000 ALTER TABLE `controller_permission` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-20  0:33:29
