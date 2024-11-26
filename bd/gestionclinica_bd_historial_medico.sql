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
-- Table structure for table `historial_medico`
--

DROP TABLE IF EXISTS `historial_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_medico` (
  `cedula` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_cita` int DEFAULT NULL,
  `id_medico` int DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `altura` decimal(10,2) DEFAULT NULL,
  `presion_arterial` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frecuencia_cardiaca` int DEFAULT NULL,
  `tipo_sangre` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `antecedentes_personales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `otros_antecedentes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `antecedentes_no_patologicos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `otros_antecedentes_no_patologicos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `condicion_general` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `examenes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `laboratorios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `diagnostico` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `receta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `recomendaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tratamiento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fecha_cita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_departamento_referencia` int DEFAULT NULL,
  PRIMARY KEY (`cedula`),
  KEY `id_cita` (`id_cita`),
  KEY `id_medico` (`id_medico`),
  KEY `fk_departamento_referencia` (`id_departamento_referencia`),
  CONSTRAINT `fk_departamento_referencia` FOREIGN KEY (`id_departamento_referencia`) REFERENCES `departamento` (`id_departamento`),
  CONSTRAINT `historial_medico_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  CONSTRAINT `historial_medico_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_medico`
--

LOCK TABLES `historial_medico` WRITE;
/*!40000 ALTER TABLE `historial_medico` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_medico` ENABLE KEYS */;
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
