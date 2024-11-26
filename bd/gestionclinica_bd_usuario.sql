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
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contrasenia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `contrasenia` (`contrasenia`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (2,'a@a.com','$2y$10$O42R2qV1yg2z1AI4Gj3Bx.apU6XFDDUeFIpfoz8XFvjcIeTAsJIS6','paciente'),(3,'moisos03@gmail.com','$2y$10$vciBarRSptqYPwth3BBhHOOc2iVqosrGlzSQ/Sp.H2cnmzDYK2q7K','paciente'),(4,'juanito@gmail.com','$2y$10$oGiry.tle3fTYTHOnyDC3uCDN8TZcD7SJ9.jv/oIC.ddvqZfUDNcW','paciente'),(6,'asdasd@asdsad.com','12345678','paciente'),(7,'albertito@hotmail.com','$2y$10$LPjt7onv9Pf14auyUqTpvuwsx9bos18cpYMlTBkbgDCVZfuS8tDX2','paciente'),(9,'yeafer@gmail.com','$2y$10$ByS.f3b0SNpZnggO1IRlCe2rZZz3bywviReszxadAYtMCSeAwG9rG','paciente'),(12,'aasdasda@gm.com','$2y$10$fQaDODArmp9CleCW/px4lu8WFaN0xIP2Wj3OkJSIALS.dvovEnAwK','medico'),(14,'elon@x.com','$2y$10$mqO3Z4sTuy8co/.mDYGLHuzXfUcdjzk6uFQvb0TI4Y61ZBJ/mcIcS','Administrador'),(15,'nicotes33@gmail.com','$2y$10$5lcOrZe62y0WMQlz.1Jz0uKtkPs8680UZkYhS595t3qs6QW5Tqu1O','Farmaceutico'),(16,'carlosmendoza@gmail.com','$2y$10$tdc89.hSRWb0gRYbeq.ZcOpp8Lf0AQ3QxVwUZ0ySXtQ5C.a8gsiby','Médico'),(17,'elenarodriguez@gmail.com','$2y$10$LdiIUZV2PtW9fbG393kA3.V7UFMB5RPrpfr4sZyS8hSw7orSqnqfu','Médico'),(18,'javiergomez@gmail.com','$2y$10$tMycfin1gvM/qTJsZzy0p.Aj/j7UoLBe8OmXolJduv3vSroQ1P0je','Médico'),(19,'marianaperez@gmail.com','$2y$10$85lYnOtCskL/JULs3TI2Eu/p2UlBaTLIyuJT5vHVIALDdkulUWjkG','Médico'),(20,'fernandoortiz@gmail.com','$2y$10$riZb3zwWkl88/Bl30vLJXuYmfZ4.C9KXQbtV2hxE.zDmM3iwCEhxO','Médico'),(21,'sofiaramirez@gmail.com','$2y$10$AxJ23Vb3Wf8VCwqMcZypv.spCiyGGj72bPwp8HrJfi.GX/WT.wI5C','Médico'),(22,'albertofernandez@gmail.com','$2y$10$2UYTgEbUIRfqFKDRoDVNVOojh8zIeIwhMuenL3SYNpOeQmSt/DAd.','Médico'),(23,'lauracastillo@gmail.com','$2y$10$Y71b4gjUUU/So98RU2Yb6uZvFm.KBxG9f1vQYLca9wx/ZndyiKks2','Médico'),(24,'pedrolongo1@gmail.com','$2y$10$.oRfGCCbCokM7k1gJqNZKuBtH93zUOUsPACqqHc9BkJnBdcbix3Re','Médico'),(25,'lauramartinez@gmail.com','$2y$10$/iU/9uIdbFHS4aRXsU9nvuTqE4iA6W58GtDxMRjXU8pR8ZNK46.v6','Médico'),(26,'javierrodriguez@gmail.com','$2y$10$2x/A15Jy40HJBOWd2QAn9urU3j8Hibyg4QrMqaFcka6MptY/aahju','Médico'),(27,'beatrizgomez@gmail.com','$2y$10$deVrSMgrXlVpBE2wCQ8weuVPAiLYljOSneS6YnyGz6cQAjpww3x4u','Médico'),(28,'manuellopez@gmail.com','$2y$10$3UFKOp7X0mpnr6bGuYbub.K4HGFWFAs.k8cziqcJs2p2qJzOeyboO','Médico'),(29,'isabelsanchez@gmail.com','$2y$10$qQWa68phNMyKITmXJS9jleEjFwqRIkt9W9Muia21w3viwq5ChsV.W','Médico'),(30,'carlosfernandez@gmail.com','$2y$10$rYLlKNkpwlQN4tb1wBowfeNvNGk0Ry/sm2hxMGMTt7a11oVuBvvS2','Médico'),(31,'luisitocomunica@gmail.com','$2y$10$wJIrdqvex0Prg3XQboE8duaawuWX.D1HzujPNl8t9irni8l5WOKdK','Paciente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-24 20:31:55
