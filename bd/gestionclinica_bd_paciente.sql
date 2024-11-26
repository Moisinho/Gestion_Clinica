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
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `cedula` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_paciente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo_paciente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion_paciente` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edad` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_seguro` int DEFAULT NULL,
  PRIMARY KEY (`cedula`),
  KEY `paciente_usuario_fk` (`id_usuario`),
  KEY `fk_id_seguro` (`id_seguro`),
  CONSTRAINT `fk_id_seguro` FOREIGN KEY (`id_seguro`) REFERENCES `seguro` (`id_seguro`),
  CONSTRAINT `paciente_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES ('1','a','a@a.com','2022-12-12','a','1',1,2,'Masculino',4),('1234','Moisés Betancourt','moisos03@gmail.com','2003-02-05','Panama','1234',21,3,'Masculino',3),('123456789','Juan Pérez','juan.perez@example.com','1985-05-15','Calle Falsa 123, Ciudad','555-1234',24,NULL,'Masculino',NULL),('3-1567-2839','Luisito Eduardo Comunica Versallez','luisitocomunica@gmail.com','1998-10-08','Condado, calle 14','8495-2234',26,31,'Masculino',4),('456789123','Luis Martínez','luis.martinez@example.com','1978-03-30','Boulevard de los Sueños 789, Ciudad','555-9012',0,NULL,'Masculino',NULL),('7777','Pedrolongo Juarez','pedrolongo1@gmail.com','2001-11-17','Los Andes','7777',23,24,'Masculino',4),('8-yeafer','Fernando Barrios','yeafer@gmail.com','2003-11-24','Cincuentenario','507121212',20,9,'Masculino',3),('9000','Juan González','juanito@gmail.com','2003-11-15','Pacora','+1 656589281',20,4,'Masculino',2),('987654321','María González','maria.gonzalez@example.com','1990-08-25','Avenida Siempre Viva 456, Ciudad','555-5678',0,NULL,'Masculino',NULL),('asd','aaaaaaaaaaa','asdasd@asdsad.com',NULL,'Pacora','123123',0,NULL,'Masculino',NULL),('E-8-217872','Alberto Rodriguez','albertito@hotmail.com','2004-08-26','Bethania','507556595',20,7,'Masculino',4);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
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
