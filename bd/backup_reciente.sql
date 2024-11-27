-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: gestionclinica_db
-- ------------------------------------------------------
-- Server version	8.0.38

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nombre_admin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo_admin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `correo_admin` (`correo_admin`),
  KEY `fk_id_usuario_admin` (`id_usuario`),
  CONSTRAINT `fk_id_usuario_admin` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,'Carlos Hernández','carloshernandez@gmail.com',1);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrador_recepcionista`
--

DROP TABLE IF EXISTS `administrador_recepcionista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador_recepcionista` (
  `id_admin` int NOT NULL,
  `id_recepcionista` int NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id_admin`,`id_recepcionista`),
  KEY `id_recepcionista` (`id_recepcionista`),
  CONSTRAINT `administrador_recepcionista_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `administrador` (`id_admin`),
  CONSTRAINT `administrador_recepcionista_ibfk_2` FOREIGN KEY (`id_recepcionista`) REFERENCES `recepcionista` (`id_recepcionista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador_recepcionista`
--

LOCK TABLES `administrador_recepcionista` WRITE;
/*!40000 ALTER TABLE `administrador_recepcionista` DISABLE KEYS */;
INSERT INTO `administrador_recepcionista` VALUES (1,1,'2024-10-01'),(1,2,'2024-10-02'),(1,3,'2024-10-03');
/*!40000 ALTER TABLE `administrador_recepcionista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cama`
--

DROP TABLE IF EXISTS `cama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cama` (
  `id_cama` int NOT NULL AUTO_INCREMENT,
  `estado` enum('Disponible','Ocupada','Mantenimiento') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Disponible',
  `id_habitacion` int DEFAULT NULL,
  `tipo_cama` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cama`),
  KEY `id_habitacion` (`id_habitacion`),
  CONSTRAINT `cama_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cama`
--

LOCK TABLES `cama` WRITE;
/*!40000 ALTER TABLE `cama` DISABLE KEYS */;
INSERT INTO `cama` VALUES (1,'Disponible',1,'Estándar'),(2,'Disponible',1,'Estándar'),(3,'Disponible',1,'Estándar'),(4,'Disponible',1,'Estándar'),(5,'Disponible',1,'Estándar'),(6,'Disponible',2,'UCI'),(7,'Disponible',2,'UCI'),(8,'Disponible',2,'UCI'),(9,'Disponible',2,'Especial'),(10,'Disponible',2,'Especial'),(11,'Disponible',2,'Especial'),(12,'Disponible',2,'Especial'),(13,'Disponible',2,'Pediátrica'),(14,'Disponible',2,'Pediátrica'),(15,'Disponible',2,'Pediátrica');
/*!40000 ALTER TABLE `cama` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cita` (
  `id_cita` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pendiente',
  `motivo` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_cita` date DEFAULT NULL,
  `diagnostico` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tratamiento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `cedula` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_medico` int DEFAULT NULL,
  `id_servicio` int DEFAULT NULL,
  `especialidad_referencia` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hora_cita` time DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  KEY `cedula` (`cedula`),
  KEY `id_medico` (`id_medico`),
  KEY `id_servicio` (`id_servicio`),
  CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (1,'Atendida','Me siento mal, me duele el cuerpo','2024-11-28',NULL,NULL,'8-1002-2121',5,5,NULL,'14:00:00'),(2,'Atendida','Me siento mal unu','2024-11-28',NULL,NULL,'8-1002-2121',5,5,NULL,'14:45:00');
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `ClienteID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Provincia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ClienteID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Juan Pérez','Panamá'),(2,'Ana Gómez','Chiriquí'),(3,'Carlos Morales','Veraguas'),(4,'Marta García','Coclé'),(5,'Pedro Sánchez','Panamá'),(6,'Laura Torres','Chiriquí'),(7,'Luis Fernández','Veraguas'),(8,'María Rodríguez','Coclé'),(9,'Jorge Herrera','Panamá'),(10,'Claudia Méndez','Panamá Oeste'),(11,'Raúl Castillo','Chiriquí'),(12,'Natalia López','Veraguas'),(13,'Roberto Díaz','Coclé'),(14,'Lucía Suárez','Panamá Oeste');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra_medicamento`
--

DROP TABLE IF EXISTS `compra_medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra_medicamento` (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `detalles_compra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `cedula_paciente` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `cedula_paciente` (`cedula_paciente`),
  CONSTRAINT `compra_medicamento_ibfk_1` FOREIGN KEY (`cedula_paciente`) REFERENCES `paciente` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra_medicamento`
--

LOCK TABLES `compra_medicamento` WRITE;
/*!40000 ALTER TABLE `compra_medicamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra_medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `CompraID` int NOT NULL AUTO_INCREMENT,
  `ClienteID` int NOT NULL,
  `FechaCompra` date NOT NULL,
  `TotalCompra` decimal(10,2) NOT NULL,
  PRIMARY KEY (`CompraID`),
  KEY `ClienteID` (`ClienteID`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`ClienteID`) REFERENCES `clientes` (`ClienteID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
INSERT INTO `compras` VALUES (1,1,'2024-01-10',150.50),(2,1,'2024-02-14',200.00),(3,5,'2024-03-12',300.75),(4,9,'2024-04-21',180.20),(5,2,'2024-01-05',250.00),(6,6,'2024-02-15',325.50),(7,11,'2024-03-22',110.30),(8,3,'2024-01-18',190.75),(9,7,'2024-03-17',225.00),(10,12,'2024-05-30',150.00),(11,4,'2024-01-23',80.00),(12,8,'2024-03-14',60.50),(13,13,'2024-04-10',95.00),(14,10,'2024-02-25',300.00),(15,14,'2024-05-05',120.75);
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento` (
  `id_departamento` int NOT NULL AUTO_INCREMENT,
  `nombre_departamento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (0,'Sin referencia','--','especialidad'),(1,'Pediatría','Atención médica especializada en niños y adolescentes, incluyendo seguimiento del desarrollo y tratamiento de enfermedades.','Especialidad'),(2,'Cardiología','Diagnóstico, tratamiento y prevención de enfermedades cardiovasculares, realizando procedimientos como electrocardiogramas y ecocardiogramas.','Especialidad'),(3,'Oncología','Diagnóstico y tratamiento de diferentes tipos de cáncer, ofreciendo servicios como consultas, quimioterapia y radioterapia.','Especialidad'),(4,'Odontología','Servicios de salud dental, como consultas de rutina, tratamientos de conducto y ortodoncia.','General'),(5,'Medicina General','Atención médica integral para problemas de salud comunes, exámenes de laboratorio y vacunación.','General'),(6,'Dermatología','Diagnóstico y tratamiento de enfermedades de la piel, el cabello y las uñas, incluyendo consultas y biopsias.','Especialidad');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examenes`
--

DROP TABLE IF EXISTS `examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examenes` (
  `id_examen` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `costo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_examen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examenes`
--

LOCK TABLES `examenes` WRITE;
/*!40000 ALTER TABLE `examenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `examenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `monto` decimal(10,2) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `detalles_factura` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_cita` int DEFAULT NULL,
  `id_recepcionista` int DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `id_cita` (`id_cita`),
  KEY `fk_factura_recepcionista` (`id_recepcionista`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  CONSTRAINT `fk_factura_recepcionista` FOREIGN KEY (`id_recepcionista`) REFERENCES `recepcionista` (`id_recepcionista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `farmaceutico`
--

DROP TABLE IF EXISTS `farmaceutico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `farmaceutico` (
  `id_farmaceutico` int NOT NULL AUTO_INCREMENT,
  `nombre_farmaceutico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo_farmaceutico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_farmaceutico`),
  UNIQUE KEY `correo_farmaceutico` (`correo_farmaceutico`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `farmaceutico_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `farmaceutico`
--

LOCK TABLES `farmaceutico` WRITE;
/*!40000 ALTER TABLE `farmaceutico` DISABLE KEYS */;
INSERT INTO `farmaceutico` VALUES (1,'Juan Gómez','juangomez@gmail.com',2);
/*!40000 ALTER TABLE `farmaceutico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habitacion`
--

DROP TABLE IF EXISTS `habitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitacion` (
  `id_habitacion` int NOT NULL AUTO_INCREMENT,
  `capacidad_disponible` int NOT NULL,
  `ubicacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_habitacion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitacion`
--

LOCK TABLES `habitacion` WRITE;
/*!40000 ALTER TABLE `habitacion` DISABLE KEYS */;
INSERT INTO `habitacion` VALUES (1,5,'Segundo piso','General'),(2,10,'Cuarto piso','Privada');
/*!40000 ALTER TABLE `habitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_medico`
--

DROP TABLE IF EXISTS `historial_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_medico` (
  `cedula` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_cita` int NOT NULL,
  `id_medico` int NOT NULL,
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
  `tratamiento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fecha_cita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_departamento_referencia` int DEFAULT NULL,
  PRIMARY KEY (`cedula`,`id_cita`,`id_medico`),
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
INSERT INTO `historial_medico` VALUES ('8-1002-2121',1,5,70.00,166.00,'120',76,'O+','','Sin especificar','','Sin especificar','Sin especificar','Sin especificar','Sin especificar','Sin especificar',NULL,'Sin especificar','2024-11-27 02:34:02',2),('8-1002-2121',2,5,70.00,166.00,'123',76,'O+','','Sin especificar','','Sin especificar','Sin especificar','Sin especificar','Sin especificar','Hola',NULL,'si','2024-11-27 02:43:22',0);
/*!40000 ALTER TABLE `historial_medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horario` (
  `id_hora` int NOT NULL AUTO_INCREMENT,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  PRIMARY KEY (`id_hora`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` VALUES (1,'06:00:00','14:00:00'),(2,'14:00:00','22:00:00');
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento`
--

DROP TABLE IF EXISTS `medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicamento` (
  `id_medicamento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `cant_stock` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  PRIMARY KEY (`id_medicamento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento`
--

LOCK TABLES `medicamento` WRITE;
/*!40000 ALTER TABLE `medicamento` DISABLE KEYS */;
INSERT INTO `medicamento` VALUES (1,'Paracetamol','Analgésico general',100,5.99,'2025-04-12'),(2,'Amoxicilina','Antibiótico',50,12.99,'2025-06-15'),(3,'Ibuprofeno','Antiinflamatorio',75,8.99,'2025-08-20');
/*!40000 ALTER TABLE `medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medico` (
  `id_medico` int NOT NULL AUTO_INCREMENT,
  `nombre_medico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo_medico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_hora` int DEFAULT NULL,
  `id_departamento` int DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  KEY `id_hora` (`id_hora`),
  KEY `id_departamento` (`id_departamento`),
  KEY `medico_usuario_fk` (`id_usuario`),
  CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`id_hora`) REFERENCES `horario` (`id_hora`),
  CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  CONSTRAINT `medico_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (1,'Carlos Mendoza','carlosmendoza@gmail.com',1,1,5),(2,'Elena Rodríguez','elenarodriguez@gmail.com',2,1,6),(3,'Beatriz Castillo','beatrizcastillo@gmail.com',1,1,7),(4,'Javier Gómez','javiergomez@gmail.com',1,2,8),(5,'Mariana Pérez','marianaperez@gmail.com',2,2,9),(6,'Manuel López','manuellopez@gmail.com',2,2,10),(7,'Fernando Ortiz','fernandoortiz@gmail.com',1,3,11),(8,'Sofía Ramírez','sofiaramirez@gmail.com',2,3,12),(9,'Ricardo Torres ','ricardotorres@gmail.com',1,3,13),(10,'Alberto Fernández','albertofernandez@gmail.com',1,4,14),(11,'Laura Castillo','lauracastillo@gmail.com',2,4,15),(12,'Ana Ortega','anaortega@gmail.com',2,4,16),(13,'Laura Martínez','lauramartinez@gmail.com',1,5,17),(14,'Javier Rodríguez','javierrodriguez@gmail.com',2,5,18),(15,'Pedro Méndez','pedromendez@gmail.com',2,5,19),(16,'Isabel Sánchez','isablesanchez@gmail.com',1,6,20),(17,'Carlos Fernández','carlosfernandez@gmail.com',2,6,21),(18,'Elena Morales','elenamorales@gmail.com',1,6,22);
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `paciente` VALUES ('10-321-6789','Ana Méndez','anamendez@gmail.com','1989-04-17','Residencial del Sol, Casa 11, Chorrera','6120-4432',35,23,'Femenino',1),('10-345-6789','Carla Espinosa','carlaespinosa@gmail.com','1993-06-06','Villa Norte, Casa 3, Chorrera','6902-4531',31,24,'Femenino',2),('10-345-8901','Camila Torres','camilatorres@gmail.com','1988-05-25','Barrio Nuevo, Casa 23, Chorrera','6890-2314',36,25,'Femenino',3),('10-567-8901','Laura Rosales','laurarosales@gmail.com','1987-08-21','Villa del Mar, Casa 7, Chorrera','6432-7890',37,26,'Femenino',4),('10-654-3210','María López','marialopez@gmail.com','1985-11-22','Villa Los Ángeles, Casa 2, Chorrera','6897-5412',39,33,'Femenino',4),('10-678-1234','Daniela Gutiérrez','danielagutierrez@gmail.com','1992-12-18','Edificio Pacífico, Piso 9, Apartamento 18, Chorrera','6578-3210',31,27,'Femenino',5),('3-123-7890','Sebastián Ríos','sebastianrios@gmail.com','1991-10-09','Barrio Nuevo, Casa 19, Colón','6897-2301',33,28,'Masculino',5),('3-234-5678','Luis Ortega','luisortega@gmail.com','1997-12-11','Edificio Estrella, Piso 2, Apartamento 4, Colón','6789-5412',26,29,'Masculino',6),('3-234-6578','Martín Ruiz','martinruiz@gmail.com','1995-03-28','Edificio Rivera, Piso 6, Apartamento 10, Colón','6123-6578',29,30,'Masculino',1),('3-456-7891','Pablo Morales','pablomorales@gmail.com','1993-06-10','Edificio Sol, Piso 8, Apartamento 15, Colón','6678-4321',31,43,'Masculino',2),('3-890-2345','Valeria Sánchez','valeriasanchez@gmail.com','1991-09-03','Edificio Central, Piso 5, Apartamento 12, Colón','6678-3412',33,31,'Femenino',2),('6-987-1234','Rosa Jiménez','rosajimenez@gmail.com','1998-08-30','Avenida Libertad, Casa 10, Chiriquí','6453-1209',26,32,'Femenino',3),('8-1002-2121','Odeth Arevalo','odetharevalo26@gmail.com','2004-08-26','Panamá, Pacora, Condado Real','6639-7771',20,44,'Femenino',6),('8-123-4567','Andrés Castillo','andrescastillo@gmail.com','1990-03-15','Calle 12, Casa 34, Panamá','6124-9876',34,34,'Masculino',5),('8-123-6789','Ricardo Vargas','ricardovargas@gmail.com','1994-02-18','Avenida Real, Casa 20, Panamá','6198-9876',30,35,'Masculino',5),('8-345-8901','Elena Martínez','elenamartinez@gmail.com','1990-07-13','Barrio Centro, Casa 12, Panamá','6678-9087',34,36,'Femenino',6),('8-678-1234','Diego Pérez','diegoperez@gmail.com','1996-07-19','Calle Principal, Casa 8, Panamá','6589-1209',28,37,'Masculino',6),('8-678-2345','Juan Vega','juanvega@gmail.com','1991-01-05','Edificio Luna, Piso 3, Apartamento 7, Panamá','6901-5678',33,38,'Masculino',5),('8-765-1234','Carlos Hernández','carloshernandez@gmail.com','1995-10-20','Avenida Central, Edificio Estrella, Piso 5, Apartamento 502, Ciudad de Panamá, Panamá','6123-4567',29,1,'Masculino',1),('8-789-1234','Natalia Quintero','nataliaquintero@gmail.com','1999-11-05','Residencial Verde, Casa 4, Panamá','6890-4321',25,41,'Femenino',4),('8-890-2345','Gabriela Herrera','gabrielaherrera@gmail.com','1997-04-22','Residencial Bahía, Casa 5, Panamá','6124-8765',27,42,'Femenino',3);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `paciente_hospitalizado` VALUES ('10-321-6789',2,13,'2024-11-17 11:00:00',NULL,'Embarazo','Hospitalizado'),('10-345-6789',4,8,'2024-11-20 12:30:00',NULL,'Cirugia','Hospitalizado'),('10-345-8901',6,14,'2024-10-25 09:40:00',NULL,'Embarazo','Hospitalizado'),('3-123-7890',14,9,'2024-10-24 08:15:00',NULL,'Cirugia','Hospitalizado'),('3-234-5678',10,15,'2024-11-25 15:35:00',NULL,'Fractura de pierna','Hospitalizado'),('8-765-1234',1,4,'2024-11-24 10:45:00',NULL,'Cirugia','Hospitalizado');
/*!40000 ALTER TABLE `paciente_hospitalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ubicacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recepcionista`
--

DROP TABLE IF EXISTS `recepcionista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recepcionista` (
  `id_recepcionista` int NOT NULL AUTO_INCREMENT,
  `nombre_recepcionista` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo_recepcionista` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_recepcionista`),
  UNIQUE KEY `correo_recepcionista` (`correo_recepcionista`),
  KEY `fk_id_usuario` (`id_usuario`),
  CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recepcionista`
--

LOCK TABLES `recepcionista` WRITE;
/*!40000 ALTER TABLE `recepcionista` DISABLE KEYS */;
INSERT INTO `recepcionista` VALUES (1,'Ana Rodríguez','anarodriguez@gmail.com',3),(2,'Abigail Jones','abigailjones@gmail.com',4);
/*!40000 ALTER TABLE `recepcionista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receta`
--

DROP TABLE IF EXISTS `receta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receta` (
  `id_receta` int NOT NULL AUTO_INCREMENT,
  `id_cita` int DEFAULT NULL,
  `id_medicamento` int DEFAULT NULL,
  `dosis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duracion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frecuencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pendiente',
  PRIMARY KEY (`id_receta`),
  KEY `id_cita` (`id_cita`),
  KEY `id_medicamento` (`id_medicamento`),
  CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamento` (`id_medicamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receta`
--

LOCK TABLES `receta` WRITE;
/*!40000 ALTER TABLE `receta` DISABLE KEYS */;
INSERT INTO `receta` VALUES (1,1,1,'2','1 semana','cada 8 horas','Pendiente'),(2,2,2,'2','3 semanas','cada 8 horas','Pendiente');
/*!40000 ALTER TABLE `receta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referencia_especialidad`
--

DROP TABLE IF EXISTS `referencia_especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referencia_especialidad` (
  `id_referencia` int NOT NULL DEFAULT '0',
  `cedula_paciente` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_departamento` int NOT NULL,
  `fecha_referencia` date NOT NULL,
  `id_medico` int NOT NULL,
  PRIMARY KEY (`id_referencia`),
  KEY `cedula_paciente_fk` (`cedula_paciente`),
  KEY `departamento_fk` (`id_departamento`),
  KEY `medico_fk` (`id_medico`),
  CONSTRAINT `cedula_paciente_fk` FOREIGN KEY (`cedula_paciente`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `departamento_fk` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  CONSTRAINT `medico_fk` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referencia_especialidad`
--

LOCK TABLES `referencia_especialidad` WRITE;
/*!40000 ALTER TABLE `referencia_especialidad` DISABLE KEYS */;
INSERT INTO `referencia_especialidad` VALUES (0,'8-1002-2121',0,'2024-11-27',5),(1,'8-1002-2121',2,'2024-11-27',5);
/*!40000 ALTER TABLE `referencia_especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restablecer_contrasenia`
--

DROP TABLE IF EXISTS `restablecer_contrasenia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restablecer_contrasenia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  CONSTRAINT `restablecer_contrasenia_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restablecer_contrasenia`
--

LOCK TABLES `restablecer_contrasenia` WRITE;
/*!40000 ALTER TABLE `restablecer_contrasenia` DISABLE KEYS */;
/*!40000 ALTER TABLE `restablecer_contrasenia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restablecimiento_tokens`
--

DROP TABLE IF EXISTS `restablecimiento_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restablecimiento_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `usado` tinyint(1) DEFAULT '0',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  UNIQUE KEY `correo` (`correo`),
  CONSTRAINT `restablecimiento_tokens_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restablecimiento_tokens`
--

LOCK TABLES `restablecimiento_tokens` WRITE;
/*!40000 ALTER TABLE `restablecimiento_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `restablecimiento_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguro`
--

DROP TABLE IF EXISTS `seguro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguro` (
  `id_seguro` int NOT NULL AUTO_INCREMENT,
  `nombre_aseguradora` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contacto_aseguradora` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion_aseguradora` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_seguro`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro`
--

LOCK TABLES `seguro` WRITE;
/*!40000 ALTER TABLE `seguro` DISABLE KEYS */;
INSERT INTO `seguro` VALUES (1,'SaludMax','0800-123-4567','Av. Siempre Viva 123, Ciudad Salud'),(2,'AseguraVida','0800-987-6543','Calle Ficticia 456, Ciudad Salud'),(3,'Medicos del Mundo','contacto@medicosmundos.com','Calle Ejemplo 789, Ciudad Salud'),(4,'Salud Total','0800-555-1212','Calle Central 101, Ciudad Salud'),(5,'Protección Salud','0800-444-3333','Calle Secundaria 202, Ciudad Salud'),(6,'Ninguno',NULL,NULL);
/*!40000 ALTER TABLE `seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguro_paciente`
--

DROP TABLE IF EXISTS `seguro_paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguro_paciente` (
  `cedula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_seguro` int NOT NULL,
  `numero_poliza` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `deducible_anual` decimal(10,2) NOT NULL,
  `coaseguro` decimal(5,2) NOT NULL,
  `limite_cobertura` decimal(15,2) DEFAULT NULL,
  `monto_utilizado` decimal(15,2) DEFAULT '0.00',
  `activo` enum('Activo','Inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Activo',
  PRIMARY KEY (`cedula`),
  UNIQUE KEY `numero_poliza` (`numero_poliza`),
  KEY `id_seguro` (`id_seguro`),
  CONSTRAINT `seguro_paciente_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `seguro_paciente_ibfk_2` FOREIGN KEY (`id_seguro`) REFERENCES `seguro` (`id_seguro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro_paciente`
--

LOCK TABLES `seguro_paciente` WRITE;
/*!40000 ALTER TABLE `seguro_paciente` DISABLE KEYS */;
/*!40000 ALTER TABLE `seguro_paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio` (
  `id_servicio` int NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `costo` decimal(10,2) DEFAULT NULL,
  `id_departamento` int DEFAULT NULL,
  PRIMARY KEY (`id_servicio`),
  KEY `fk_departamento` (`id_departamento`),
  CONSTRAINT `fk_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (1,'Consulta pediátrica de control y seguimiento','Revisión integral del estado de salud y desarrollo del niño, examen físico, vacunación y orientación a los padres.',70.00,1),(2,'Atención de urgencias pediátricas','Evaluación y tratamiento inmediato de problemas de salud agudos en niños y adolescentes.',100.00,1),(3,'Terapia de rehabilitación infantil','Sesiones de terapia física, ocupacional o del lenguaje para el desarrollo de habilidades motoras y cognitivas.',80.00,1),(4,'Consulta cardiológica','Evaluación del estado cardiovascular, diagnóstico de enfermedades y recomendaciones de tratamiento.',90.00,2),(5,'Electrocardiograma','Examen para evaluar la actividad eléctrica del corazón.',50.00,2),(6,'Ecocardiograma','Estudio de imagen que permite visualizar la estructura y funcionamiento del corazón.',100.00,2),(7,'Consulta oncológica','Evaluación integral del paciente, diagnóstico y planificación del tratamiento del cáncer.',120.00,3),(8,'Quimioterapia','Administración de medicamentos citotóxicos para el tratamiento del cáncer.',650.00,3),(9,'Radioterapia','Aplicación de radiación ionizante para el tratamiento del cáncer.',180.00,3),(10,'Consulta odontológica de rutina','Examen oral, limpieza dental y orientación sobre higiene bucal.',50.00,4),(11,'Endodoncia (tratamiento de conducto)','Procedimiento para tratar infecciones en el interior del diente.',200.00,4),(12,'Ortodoncia (tratamiento de brackets)','Uso de aparatos dentales para corregir la posición de los dientes.',2500.00,4),(13,'Consulta médica general','Evaluación y atención de problemas de salud comunes.',60.00,5),(14,'Examen de laboratorio básico','Análisis de sangre, orina u otras muestras para diagnóstico.',40.00,5),(15,'Aplicación de vacunas','Inmunización contra enfermedades prevenibles.',30.00,5),(16,'Consulta dermatológica','Evaluación y diagnóstico de problemas de piel, cabello y uñas.',80.00,6),(17,'Biopsia de piel','Extracción de una pequeña muestra de piel para análisis.',100.00,6),(18,'Tratamiento de acné','Terapias para el manejo de acné y otras afecciones de la piel.',60.00,6);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes_examenes`
--

DROP TABLE IF EXISTS `solicitudes_examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes_examenes` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `cedula` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `id_examen` int NOT NULL,
  `id_medico` int NOT NULL,
  `fecha_solicitud` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Pendiente','Realizado','Cancelado') COLLATE utf8mb4_general_ci DEFAULT 'Pendiente',
  `fecha_realizacion` datetime DEFAULT NULL,
  `resultado` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_solicitud`),
  KEY `cedula` (`cedula`),
  KEY `id_examen` (`id_examen`),
  KEY `id_medico` (`id_medico`),
  CONSTRAINT `solicitudes_examenes_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `solicitudes_examenes_ibfk_2` FOREIGN KEY (`id_examen`) REFERENCES `examenes` (`id_examen`),
  CONSTRAINT `solicitudes_examenes_ibfk_3` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes_examenes`
--

LOCK TABLES `solicitudes_examenes` WRITE;
/*!40000 ALTER TABLE `solicitudes_examenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes_examenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suministro_medicamento`
--

DROP TABLE IF EXISTS `suministro_medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suministro_medicamento` (
  `id_proveedor` int NOT NULL,
  `id_medicamento` int NOT NULL,
  `fecha` date NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`,`id_medicamento`,`fecha`),
  KEY `id_medicamento` (`id_medicamento`),
  CONSTRAINT `suministro_medicamento_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  CONSTRAINT `suministro_medicamento_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamento` (`id_medicamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suministro_medicamento`
--

LOCK TABLES `suministro_medicamento` WRITE;
/*!40000 ALTER TABLE `suministro_medicamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `suministro_medicamento` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'carloshernandez@gmail.com','$2y$10$aHuoou5eteishPI7jBT4DulP76Fet8MdfzAcWjTRhsb9GL0OGNROu','Administrador'),(2,'juangomez@gmail.com','$2y$10$QucQBCwnuwSMtV4XT.nFW.ZkfqVwKsYKZbjLRVzxW6fxaoneb7GtK','Farmaceutico'),(3,'anarodriguez@gmail.com','$2y$10$tJIAmF/jJiapwlCX6/HkFeyGZrjUr66l8IZuMnVzWxe8tyjGrRjiS','Recepcionista'),(4,'abigailjones@gmail.com','$2y$10$MDrIWGtgbVcrK.besi2GbuawMCvUHHji5s9xOPTG//0EtwmMQnifa','Recepcionista'),(5,'carlosmendoza@gmail.com','$2y$10$1GHdtO0qPlmjEAFcbsF7b.hLC5JCWH4mZjCGBsOKhicf5G5RXN.xe','Médico'),(6,'elenarodriguez@gmail.com','$2y$10$jm4ShMvJLnSmCEPsyaE3muRnpdStfIA4H/WYWo65uguC/vQHVsYF2','Médico'),(7,'beatrizcastillo@gmail.com','$2y$10$43vftZr.z0H524fwGK5OMuguC90dHH8UtgRzmvdtPq5dgh.jY3LiC','Médico'),(8,'javiergomez@gmail.com','$2y$10$XTv6Vm61txGRqNgWZvrzmuJNFCat48WK8.Bn2gCrfEoHwDX2GqgXu','Médico'),(9,'marianaperez@gmail.com','$2y$10$0thVysUqDCRa27bvu8/5Q.JaEzajWtkUoYC2duBpSGCuzPsx4bfoS','Médico'),(10,'manuellopez@gmail.com','$2y$10$dMDGqbwCpXoxJHHmJwP7g.gpWcuaqvQrc43o1IJumQNyQvohMUlX.','Médico'),(11,'fernandoortiz@gmail.com','$2y$10$YmX78SD3CabpvIgIvSn0U.LFtq1O6Prvy8SllvFEo3ZIPqz4wXMDG','Médico'),(12,'sofiaramirez@gmail.com','$2y$10$YvpaTMJ/D4TJp99MEl0r0eBuCyYAGPKQNyyl.ehOh6l3eZgjehh.G','Médico'),(13,'ricardotorres@gmail.com','$2y$10$6rhitVVba145kCcMNtudteUj/S5oGvlb.i6Pphxs4DvR/soL/uUA6','Médico'),(14,'albertofernandez@gmail.com','$2y$10$Th2Sgjta/LhwjcOrZMfiDe463MzSOpUP2CgkQ86tHrf0YI2uTEMHC','Médico'),(15,'lauracastillo@gmail.com','$2y$10$M3NVg3ZXktSKgMXte25oVeddRoz3aYULbawFwK1M.61iFLgQccorK','Médico'),(16,'anaortega@gmail.com','$2y$10$CSvTgKj2hx6k.CU2S7tXVOFNUmjf/duIdFKtCVEbpmQeGiqMqVbv.','Médico'),(17,'lauramartinez@gmail.com','$2y$10$50lK4KGAOxMhysb9uGuCieDbjxar8fHVFht8PBbDmt008a2qAj9y.','Médico'),(18,'javierrodriguez@gmail.com','$2y$10$nXd5bZb6JFbSCFaog3e0Cudst4nrCqmOd17bpYduHy0QIG7dft0mG','Médico'),(19,'pedromendez@gmail.com','$2y$10$kysFt0i.4lvKZ2fToQWJReyvjY.1kYbueBocjvpsDzYowrDF0tT9W','Médico'),(20,'isablesanchez@gmail.com','$2y$10$lrh0o0j8nhPw4e2vIesAmeM6AaNO5I1w4iIWjilHFvm7jv5414iu.','Médico'),(21,'carlosfernandez@gmail.com','$2y$10$ahzcvmN3TmrAhD9fEY9XHOTbWKKnJbDZLuYOA0pKaKe3oR.MOBaze','Médico'),(22,'elenamorales@gmail.com','$2y$10$OhI5zEu8Y7CptP43EJxN5u/iFECeRzUk47DKHwfcNQsWRAoQxPZxe','Médico'),(23,'anamendez@gmail.com','$2y$10$diYGTrkTrB8si0iNNyzKzO5n1i8DjI2tPPcW.lQLupIEJd1WbyO2W','Paciente'),(24,'carlaespinosa@gmail.com','$2y$10$8lC4Vjxer3D/cJh5M0qjYeRpF0LPcMYY43pEf4xbWcWGwoqNqx1UC','Paciente'),(25,'camilatorres@gmail.com','$2y$10$g0u1h4XyLl8kjramq9UvpuDzlwiKVmfwJQYLV6Sl36l398cg1g9zS','Paciente'),(26,'laurarosales@gmail.com','$2y$10$7WyxqaVZiG5v9SNUCr./ZOjYHn.nLHE08GyBVFfVd8TnbAXM/.r/y','Paciente'),(27,'danielagutierrez@gmail.com','$2y$10$81ktHi/B/sIeuV6ue1y7kOC7bStW9atxziDxgfMnPSTeckyLtflyW','Paciente'),(28,'sebastianrios@gmail.com','$2y$10$Pw0G6QqApR7gU68M1.EnSO3PTEm9LQ0Tdcd4WEIaoIdnMu8sPIZTG','Paciente'),(29,'luisortega@gmail.com','$2y$10$t6OfOYKuYoRCtKlh5Nin/.CQdbcZo9A5qEEzaOpyqxrl8cqATFK/S','Paciente'),(30,'martinruiz@gmail.com','$2y$10$tpFtUVOfEFqkjK6wrnb.xen1Mk1zQtSMEELGQIpUkQa4J4OzI22Ey','Paciente'),(31,'valeriasanchez@gmail.com','$2y$10$FsZhr5No0mhTkuRgfmgXu.Qy0j6G3Rv2II6ZubezZOqqLl1.JV12.','Paciente'),(32,'rosajimenez@gmail.com','$2y$10$0bNgTW/r6kgrxRS13gn4tufnESthvEo7wbwINdgxa0THj19UGTQSa','Paciente'),(33,'marialopez@gmail.com','$2y$10$QDr3/q2PIWWvPZPFhtNAfeaEs6AXcfbfmtn.V1TIcNqdolQe5o6Wq','Paciente'),(34,'andrescastillo@gmail.com','$2y$10$Fny.oM3hSYfMpAS1XaMaVuQH8fR6De.VQV6LqbXHfRa.AI/nvZI/u','Paciente'),(35,'ricardovargas@gmail.com','$2y$10$NM0.bhNskErnAn39m.4hwukodjBUWS4ZRdw/JtbBgtrvD9/dV1vwC','Paciente'),(36,'elenamartinez@gmail.com','$2y$10$/lgnbEUHepmKiSEvhee.IO6v03Tcj0DSg7IeCNan0/W8dXUtUhJPq','Paciente'),(37,'diegoperez@gmail.com','$2y$10$KQixKQBmDV9uestQ5MC5BO8w/WQfBb64cizIDSS.UVQ2lLEiaaMI2','Paciente'),(38,'juanvega@gmail.com','$2y$10$rdvG5Nsue7SYzeDTvh8u7.Af4pgSv1YV6YJ55J.KMYk9WPeRcbcrG','Paciente'),(41,'nataliaquintero@gmail.com','$2y$10$NHX9nftnbF41QAV2IGSqPuImxNuAIdYLpdQkiiu2gCG.mGAqgEFxW','Paciente'),(42,'gabrielaherrera@gmail.com','$2y$10$GWoGge54w9oCvsCaLAcfY.QqR45k5qt4vgMEzPeh0g8DiFm8fuLn.','Paciente'),(43,'pablomorales@gmail.com','$2y$10$X87zidEPYqEO7c42qnrM8elt0z.KhAWqdkApu0eRcGPw5xy4XKaci','Paciente'),(44,'odetharevalo26@gmail.com','$2y$10$sPa9f9kGjfZAxBgAQCTeIOJSDmn2mjvOS8NdiGaEW9Be.rZZ/XJlG','Paciente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'gestionclinica_db'
--

--
-- Dumping routines for database 'gestionclinica_db'
--
/*!50003 DROP PROCEDURE IF EXISTS `BuscarCitas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarCitas`(IN `busqueda` VARCHAR(255))
BEGIN
    SELECT * 
    FROM cita
    WHERE 
        estado LIKE CONCAT('%', busqueda, '%') OR
        recordatorio LIKE CONCAT('%', busqueda, '%') OR
        fecha_cita LIKE CONCAT('%', busqueda, '%') OR
        diagnostico LIKE CONCAT('%', busqueda, '%') OR
        tratamiento LIKE CONCAT('%', busqueda, '%') OR
        cedula LIKE CONCAT('%', busqueda, '%') OR
        id_medico LIKE CONCAT('%', busqueda, '%');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerDatosRecetas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDatosRecetas`()
BEGIN
    SELECT 
        r.id_receta,
        c.fecha_cita AS fecha,
        p.nombre_paciente,
        m.nombre AS nombre_medicamento,
        m.cant_stock,
        med.nombre_medico,
        r.estado
    FROM receta r
    INNER JOIN cita c ON r.id_cita = c.id_cita
    INNER JOIN paciente p ON c.cedula = p.cedula
    INNER JOIN medico med ON c.id_medico = med.id_medico
    INNER JOIN medicamento m ON r.id_medicamento = m.id_medicamento
    ORDER BY c.fecha_cita;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerHorarios` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerHorarios`()
BEGIN
    SELECT CONCAT(DATE_FORMAT(hora_inicio, '%H:%i'), ' - ', DATE_FORMAT(hora_fin, '%H:%i')) AS Horario
    FROM Horario;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-26 22:07:22
