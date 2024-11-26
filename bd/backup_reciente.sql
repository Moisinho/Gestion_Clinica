-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: gestionclinica_bd
-- ------------------------------------------------------
-- Server version	9.1.0

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
  `nombre_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `correo_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
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
-- Table structure for table `cama`
--

DROP TABLE IF EXISTS `cama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cama` (
  `id_cama` int NOT NULL AUTO_INCREMENT,
  `estado` enum('Disponible','Ocupada','Mantenimiento') COLLATE utf8mb4_general_ci DEFAULT 'Disponible',
  `id_habitacion` int DEFAULT NULL,
  `tipo_cama` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `estado` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Pendiente',
  `motivo` varchar(5000) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_cita` datetime DEFAULT NULL,
  `diagnostico` text COLLATE utf8mb4_general_ci,
  `tratamiento` text COLLATE utf8mb4_general_ci,
  `cedula` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_medico` int DEFAULT NULL,
  `id_servicio` int DEFAULT NULL,
  `especialidad_referencia` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  KEY `cedula` (`cedula`),
  KEY `id_medico` (`id_medico`),
  KEY `id_servicio` (`id_servicio`),
  CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
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
  `Nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Provincia` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
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
  `detalles_compra` text COLLATE utf8mb4_general_ci,
  `cedula_paciente` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `nombre_departamento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'Pediatría','Atención médica especializada en niños y adolescentes, incluyendo seguimiento del desarrollo y tratamiento de enfermedades.'),(2,'Cardiología','Diagnóstico, tratamiento y prevención de enfermedades cardiovasculares, realizando procedimientos como electrocardiogramas y ecocardiogramas.'),(3,'Oncología','Diagnóstico y tratamiento de diferentes tipos de cáncer, ofreciendo servicios como consultas, quimioterapia y radioterapia.'),(4,'Odontología','Servicios de salud dental, como consultas de rutina, tratamientos de conducto y ortodoncia.'),(5,'Medicina General','Atención médica integral para problemas de salud comunes, exámenes de laboratorio y vacunación.'),(6,'Dermatología','Diagnóstico y tratamiento de enfermedades de la piel, el cabello y las uñas, incluyendo consultas y biopsias.');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
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
  `detalles_factura` text COLLATE utf8mb4_general_ci,
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
  `nombre_farmaceutico` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `correo_farmaceutico` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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
INSERT INTO `farmaceutico` VALUES (1,'Juan Gómez','juangomez@gmail.com',3);
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
  `ubicacion` text COLLATE utf8mb4_general_ci,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `cedula` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cita` int DEFAULT NULL,
  `id_medico` int DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `altura` decimal(10,2) DEFAULT NULL,
  `presion_arterial` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frecuencia_cardiaca` int DEFAULT NULL,
  `tipo_sangre` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `antecedentes_personales` text COLLATE utf8mb4_general_ci,
  `otros_antecedentes` text COLLATE utf8mb4_general_ci,
  `antecedentes_no_patologicos` text COLLATE utf8mb4_general_ci,
  `otros_antecedentes_no_patologicos` text COLLATE utf8mb4_general_ci,
  `condicion_general` text COLLATE utf8mb4_general_ci,
  `examenes` text COLLATE utf8mb4_general_ci,
  `laboratorios` text COLLATE utf8mb4_general_ci,
  `diagnostico` text COLLATE utf8mb4_general_ci,
  `motivo` text COLLATE utf8mb4_general_ci,
  `receta` text COLLATE utf8mb4_general_ci,
  `recomendaciones` text COLLATE utf8mb4_general_ci,
  `tratamiento` text COLLATE utf8mb4_general_ci,
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
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
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
  `nombre_medico` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo_medico` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
INSERT INTO `medico` VALUES (1,'Carlos Mendoza','carlosmendoza@gmail.com',1,1,5),(2,'Elena Rodríguez','elenarodriguez@gmail.com',2,1,6),(3,'Javier Gómez','javiergomez@gmail.com',1,2,7),(4,'Mariana Pérez','marianaperez@gmail.com',2,2,8),(5,'Fernando Ortiz','fernandoortiz@gmail.com',1,3,9),(6,'Sofía Ramírez','sofiaramirez@gmail.com',2,3,10),(7,'Alberto Fernández','albertofernandez@gmail.com',1,4,11),(8,'Laura Castillo','lauracastillo@gmail.com',2,4,12),(9,'Laura Martínez','lauramartinez@gmail.com',1,5,13),(10,'Javier Rodríguez','javierrodriguez@gmail.com',2,5,14),(11,'Isabel Sánchez','isablesanchez@gmail.com',1,6,15),(12,'Carlos Fernández','carlosfernandez@gmail.com',2,6,16),(13,'Beatriz Castillo','beatrizcastillo@gmail.com',1,1,17),(14,'Manuel López','manuellopez@gmail.com',2,2,18),(15,'Ricardo Torres ','ricardotorres@gmail.com',1,3,19),(16,'Ana Ortega','anaortega@gmail.com',2,4,20),(17,'Pedro Méndez','pedromendez@gmail.com',1,5,21),(18,'Elena Morales','elenamorales@gmail.com',2,6,22);
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `cedula` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_paciente` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo_paciente` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion_paciente` text COLLATE utf8mb4_general_ci,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edad` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') COLLATE utf8mb4_general_ci NOT NULL,
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
INSERT INTO `paciente` VALUES ('10-321-6789','Ana Méndez','anamendez@gmail.com','1989-04-17','Residencial del Sol, Casa 11, Chorrera','6120-4432',35,28,'Femenino',1),('10-345-6789','Carla Espinosa','carlaespinosa@gmail.com','1993-06-06','Villa Norte, Casa 3, Chorrera','6902-4531',31,42,'Femenino',2),('10-345-8901','Camila Torres','camilatorres@yahoo.com','1988-05-25','Barrio Nuevo, Casa 23, Chorrera','6890-2314',36,30,'Femenino',3),('10-567-8901','Laura Rosales','laurarosales@gmail.com','1987-08-21','Villa del Mar, Casa 7, Chorrera','6432-7890',37,34,'Femenino',1),('10-678-1234','Daniela Gutiérrez	','danigutierrez@gmail.com','1992-12-18','Edificio Pacífico, Piso 9, Apartamento 18, Chorrera','6578-3210',31,39,'Femenino',5),('3-123-7890','Sebastián Ríos','sebrios@gmail.com','1991-10-09','Barrio Nuevo, Casa 19, Colón','6897-2301',33,41,'Masculino',1),('3-234-5678','Luis Ortega','luisortega@gmail.com','1997-12-11','Edificio Estrella, Piso 2, Apartamento 4, Colón','6789-5412',26,29,'Masculino',2),('3-234-6578','Martín Ruiz','martinruiz@gmail.com','1995-03-28','Edificio Rivera, Piso 6, Apartamento 10, Colón','6123-6578',29,37,'Masculino',3),('3-890-2345','Valeria Sánchez','valesanchez@gmail.com','1991-09-03','Edificio Central, Piso 5, Apartamento 12, Colón','6678-3412',33,32,'Femenino',5),('6-987-1234','Rosa Jiménez','rosajimenez@gmail.com','1998-08-30','Avenida Libertad, Casa 10, Chiriquí','6453-1209',26,26,'Femenino',5),('7-654-3210','María López','marialopez@gmail.com','1985-11-22','Villa Los Ángeles, Casa 2, Chorrera','6897-5412',39,24,'Femenino',3),('8-123-4567','Andrés Castillo ','andrescastillo@gmail.com','1990-03-15','Calle 12, Casa 34, Panamá','6124-9876',34,23,'Masculino',1),('8-123-6789','Ricardo Vargas','ricardovargas@gmail.com','1994-02-18','Avenida Real, Casa 20, Panamá','6198-9876',30,33,'Masculino',6),('8-345-8901','Elena Martínez','elenamartinez@gmail.com','1990-07-13','Barrio Centro, Casa 12, Panamá','6678-9087',34,38,'Femenino',4),('8-678-1234','Diego Pérez','diegoperez@hotmail.com','1996-07-19','Calle Principal, Casa 8, Panamá','6589-1209',28,31,'Masculino',4),('8-678-2345','Juan Vega','juanvega@gmail.com','1992-01-05','Edificio Luna, Piso 3, Apartamento 7, Panamá','6901-5678',32,27,'Masculino',6),('8-765-1234','Carlos Hernández','carloshernandez@gmail.com','1995-10-20','Avenida Central, Edificio Estrella, Piso 5, Apartamento 502, Ciudad de Panamá, Panamá','6123-4567',29,1,'Masculino',2),('8-789-1234','Natalia Quintero','nataliaquintero@gmail.com','1999-11-05','Residencial Verde, Casa 4, Panamá','6890-4321',25,35,'Femenino',2),('8-890-2345','Gabriela Herrera','gabrielaherrera@gmail.com','1997-04-22','Residencial Bahía, Casa 5, Panamá','6124-8765',27,40,'Femenino',6),('9-456-7891','Pablo Morales','pablomorales@gmail.com','1993-06-10','Edificio Sol, Piso 8, Apartamento 15, Colón','6678-4321',31,25,'Masculino',4);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente_hospitalizado`
--

DROP TABLE IF EXISTS `paciente_hospitalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente_hospitalizado` (
  `cedula` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cama` int NOT NULL,
  `id_medico` int NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_egreso` datetime DEFAULT NULL,
  `motivo` text COLLATE utf8mb4_general_ci,
  `estado_pacienteH` enum('Hospitalizado','No hospitalizado') COLLATE utf8mb4_general_ci DEFAULT 'Hospitalizado',
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
INSERT INTO `paciente_hospitalizado` VALUES ('10-321-6789',2,5,'2024-11-17 11:00:00',NULL,'Embarazo','Hospitalizado'),('10-345-6789',4,3,'2024-11-20 12:30:00',NULL,'Cirugia','Hospitalizado'),('10-345-8901',6,5,'2024-10-25 09:40:00',NULL,'Embarazo','Hospitalizado'),('3-123-7890',14,3,'2024-10-24 08:15:00',NULL,'Cirugia','Hospitalizado'),('3-234-5678',10,5,'2024-11-25 15:35:00',NULL,'Fractura de pierna','Hospitalizado'),('8-765-1234',1,2,'2024-11-24 10:45:00',NULL,'Cirugia','Hospitalizado');
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
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ubicacion` text COLLATE utf8mb4_general_ci,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `nombre_recepcionista` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `correo_recepcionista` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
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
INSERT INTO `recepcionista` VALUES (1,'Ana Rodríguez','anarodriguez@gmail.com',2),(2,'Abigail Jones','abigailjones@gmail.com',4);
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
  `dosis` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duracion` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frecuencia` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(12) COLLATE utf8mb4_general_ci DEFAULT 'Pendiente',
  PRIMARY KEY (`id_receta`),
  KEY `id_cita` (`id_cita`),
  KEY `id_medicamento` (`id_medicamento`),
  CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamento` (`id_medicamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receta`
--

LOCK TABLES `receta` WRITE;
/*!40000 ALTER TABLE `receta` DISABLE KEYS */;
/*!40000 ALTER TABLE `receta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referencia_especialidad`
--

DROP TABLE IF EXISTS `referencia_especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referencia_especialidad` (
  `id_referencia` int NOT NULL AUTO_INCREMENT,
  `cedula_paciente` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
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
  `correo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
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
  `correo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
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
  `nombre_aseguradora` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contacto_aseguradora` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion_aseguradora` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `cedula` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_seguro` int NOT NULL,
  `numero_poliza` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `deducible_anual` decimal(10,2) NOT NULL,
  `coaseguro` decimal(5,2) NOT NULL,
  `limite_cobertura` decimal(15,2) DEFAULT NULL,
  `monto_utilizado` decimal(15,2) DEFAULT '0.00',
  `activo` enum('Activo','Inactivo') COLLATE utf8mb4_general_ci DEFAULT 'Activo',
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
  `nombre_servicio` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
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
  `correo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contrasenia` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `contrasenia` (`contrasenia`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'carloshernandez@gmail.com','$2y$10$1e9eY/bO7pDTbYWsJ1OoDuIsgxExgqNX0HDePnpM2AmAo94lbDsby','Administrador'),(2,'anarodriguez@gmail.com','$2y$10$XmlWaFRnXog.ywjA1zHtZOI5E1z3c4wWoW5Roi0.riKsM7fwzC20W','Recepcionista'),(3,'juangomez@gmail.com','$2y$10$IlJyMcrt4QG3SDU0y4r8gOUhBQh.Gi6MUYhqA8Ggp/ieRNpVgGvSq','Farmaceutico'),(4,'abigailjones@gmail.com','$2y$10$XtS9QgZEeDXAp5uBYGaIBuu.5BEEYD9K/6WbuFrXxO0q79u/gcRyG','Recepcionista'),(5,'carlosmendoza@gmail.com','$2y$10$sxt/qduV5.akG.LaZ9teCOpW6uTL.I/gSK3EX.u7r4JHLZtzJPexe','Médico'),(6,'elenarodriguez@gmail.com','$2y$10$Bf3yUgIWEFdI40PifmTWIeg2dgRAvP9HzN/UwP1vQQCaLCe.wnCoO','Médico'),(7,'javiergomez@gmail.com','$2y$10$V.9/5kDHyMRj/DVpypJ9oumpsNVAWFdX7ikx5w00beMzOaf8c0nvm','Médico'),(8,'marianaperez@gmail.com','$2y$10$sR/KOeZHfflUTvDXFOSx2u1Vslq3lGtSab3UZ6AuX1QqnXa5PdEQ2','Médico'),(9,'fernandoortiz@gmail.com','$2y$10$vypAPNj24MNhdgbvAxFf9.NGUEftKJb2JmYUFSDUz8OZlagHrW4uK','Médico'),(10,'sofiaramirez@gmail.com','$2y$10$IDNkZJRjBM1IESTAHOr1Lu9wlH8AvkJfdBEXVNSuPBvCv/D6qFjG6','Médico'),(11,'albertofernandez@gmail.com','$2y$10$2uE8EIAoX/1Kzu1JEx0v4OuEbz/NS8tXMFmY6SALoKi4yf8alQpYO','Médico'),(12,'lauracastillo@gmail.com','$2y$10$uxpTalpFWrFSdfYly9jm7OEGJAdR7.iXTia/uvqqW0eu7Q.itweSO','Médico'),(13,'lauramartinez@gmail.com','$2y$10$XZTf9cPE8JYW8kM8AxYDtumYU/dYhPbDkv/AXzl3KDGD4SpVqkcuC','Médico'),(14,'javierrodriguez@gmail.com','$2y$10$7lokHb3O6f5l39CL1jvaq.PSxDq7B8senVJfWT.P3nDT6ydjNzaoe','Médico'),(15,'isablesanchez@gmail.com','$2y$10$KNE6D7hrgvMu10exc78IyuMNfH/DuUuSt3KmUN2vB4besjBh4zKAq','Médico'),(16,'carlosfernandez@gmail.com','$2y$10$cE1gJut2/LKJqMPi.hqv6OqJqxrLx5aDp0xdYIhwMZdpT3Xwx5Jwu','Médico'),(17,'beatrizcastillo@gmail.com','$2y$10$FNVNwYBKgNJUGwDfI395SeBQoQS2tpmM5mGpI.Kngtasi98SbLBie','Médico'),(18,'manuellopez@gmail.com','$2y$10$ErtTQ4xblBxgcuMkTaALve1cMTjxwwPvzpt/7yoTnxNmh/aMZHQPW','Médico'),(19,'ricardotorres@gmail.com','$2y$10$tyKm7/m8Gc3cP3jqvs772ezWAfpUnxH4YhLJXwvtWAl8wq1hqRmqC','Médico'),(20,'anaortega@gmail.com','$2y$10$PfIcCAzy7VvFpLfR7gjh2OUTV4ip23zV7KMdWivKCFMDhHg5kDLhy','Médico'),(21,'pedromendez@gmail.com','$2y$10$/I.S0E95fkcfkBeWSSkNZ.b5jeoZ68qtgOcHZPYpYFlYXkVmWute.','Médico'),(22,'elenamorales@gmail.com','$2y$10$J0H95qBIzgDkHri3aZWYBeqsCfQhu6SufUMGmFdBn08AeOibXbgRm','Médico'),(23,'andrescastillo@gmail.com','$2y$10$fOCEzlIIf6XIy9IimGNu..2LhlQwWIyTsurLgFPZPDGDHv1pq7Xb2','Paciente'),(24,'marialopez@gmail.com','$2y$10$yfjrUBSmUHNumi0lLLofCeZN6MbaWXPSfQhumJ4fbzDpo75CVOb6K','Paciente'),(25,'pablomorales@gmail.com','$2y$10$Sc6pGpc7ISn9nDpkN25fLeXNlHgC35wfkqIMIvMAj6QRwloysfX7i','Paciente'),(26,'rosajimenez@gmail.com','$2y$10$drwgz0lh1yOiBq8CYiNiyuW8ZpxjNgTldAm7JtosvawfH.MMtOIgu','Paciente'),(27,'juanvega@gmail.com','$2y$10$Q.NN2y0/ZsAq5crbqBPZ3ehuIEp4/nfolTEahL0bYCfZGGRautA3q','Paciente'),(28,'anamendez@gmail.com','$2y$10$kK2ijhaqo2ssONY9h5rAlu4YqDUQ/zssuMN/AACtemNvnlXUmAxXK','Paciente'),(29,'luisortega@gmail.com','$2y$10$NeVrsztuL0Ih1.7yTtBIhOaymOoGv/2VlZGdiHDPB1.4JH5G6WK4W','Paciente'),(30,'camilatorres@yahoo.com','$2y$10$OR5I8NJYXnmMd5kdKsWvd.wgJlzh7hntsbG9fN9.F3myVDVvpJlyG','Paciente'),(31,'diegoperez@hotmail.com','$2y$10$KSRwmN113DrhhDZZ1DhWYO9r4brty4pXfGAojNdHM71pV4Nma/kd2','Paciente'),(32,'valesanchez@gmail.com','$2y$10$hu2bvbY.BUK37CnTyZWFCOLCNSbL2C5a4R9UFNT.ZH./Wj0KJqvpi','Paciente'),(33,'ricardovargas@gmail.com','$2y$10$1eAoKbvPMMLMqvd81/WUXuYUT2mOODv2KGHrtBpKLEDIaaHW23.LC','Paciente'),(34,'laurarosales@gmail.com','$2y$10$YNa55VYcD8GGA6/Lria0G.hpQGBNzep05wQpkSTkzvo.lK21jO.Dm','Paciente'),(35,'nataliaquintero@gmail.com','$2y$10$51xrJaaLr6.O1IL6oX.MKeGN0SBvx1B0sqTaCkVevem50lVuoAEIS','Paciente'),(37,'martinruiz@gmail.com','$2y$10$lrWYGxqH3zC4kN8MHxCnRO1GDtZb7PvERzPmNwd8tlaFt2IRPpmHi','Paciente'),(38,'elenamartinez@gmail.com','$2y$10$mCLejE3uz5Jc.FQI0hzvnOBhf1PsBBh3QWrKaIB0yThSSUVprr9Ua','Paciente'),(39,'danigutierrez@gmail.com','$2y$10$4hEKrHwmRSpO9RU.QGuCeuK5Ib0k6IPtRuAuDhQmUAqgODR.a4G.2','Paciente'),(40,'gabrielaherrera@gmail.com','$2y$10$1IWEKz9zdZy0L5ONiRmFQugwgalS2FzwX0En.Fz2rn3oYCw3X2Lfy','Paciente'),(41,'sebrios@gmail.com','$2y$10$uMGY1fuFHDdtUbyZDGxVHul0upobFyxofMpRxgf5iYn2jHppWldg.','Paciente'),(42,'carlaespinosa@gmail.com','$2y$10$uLDva42bZLskt0.nZ/t0aelmPuJ8AqESTObram9P7EzMnfihBwKK6','Paciente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'gestionclinica_bd'
--

--
-- Dumping routines for database 'gestionclinica_bd'
--
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

-- Dump completed on 2024-11-25 23:49:37
