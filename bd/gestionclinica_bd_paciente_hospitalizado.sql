-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: gestionclinica_bd
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `paciente_hospitalizado`
--

DROP TABLE IF EXISTS `paciente_hospitalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente_hospitalizado` (
  `cedula` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_cama` int NOT NULL,
  `id_medico` int NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_egreso` datetime DEFAULT NULL,
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `estado_pacienteH` enum('Hospitalizado','No hospitalizado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Hospitalizado',
  PRIMARY KEY (`cedula`,`id_cama`),
  KEY `id_cama` (`id_cama`),
  KEY `id_medico` (`id_medico`),
  CONSTRAINT `paciente_hospitalizado_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `paciente` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `paciente_hospitalizado_ibfk_2` FOREIGN KEY (`id_cama`) REFERENCES `cama` (`id_cama`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `paciente_hospitalizado_ibfk_3` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_hospitalizado`
--

LOCK TABLES `paciente_hospitalizado` WRITE;
/*!40000 ALTER TABLE `paciente_hospitalizado` DISABLE KEYS */;
INSERT INTO `paciente_hospitalizado` VALUES ('1234',1,1,'2024-11-17 10:45:00',NULL,'Cirugia','Hospitalizado'),('123456789',6,4,'2024-10-25 09:40:00',NULL,'Embarazo','Hospitalizado'),('456789123',4,3,'2024-11-16 12:30:00',NULL,'Cirugia','Hospitalizado'),('9000',14,2,'2024-10-24 08:15:00',NULL,'Cirugia','Hospitalizado'),('987654321',10,1,'2024-11-10 15:35:00',NULL,'Embarazo','Hospitalizado'),('E-8-217872',2,2,'2024-11-15 11:00:00',NULL,'Embarazo','Hospitalizado');
/*!40000 ALTER TABLE `paciente_hospitalizado` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-24 20:31:54
