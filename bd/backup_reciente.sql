-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: gestionclinica_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_admin` varchar(100) NOT NULL,
  `correo_admin` varchar(100) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `correo_admin` (`correo_admin`),
  KEY `fk_id_usuario_admin` (`id_usuario`),
  CONSTRAINT `fk_id_usuario_admin` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,'Admin1','admin1@example.com',NULL),(2,'Admin2','admin2@example.com',NULL),(3,'Admin3','admin3@example.com',NULL),(4,'Elon Musk','elon@x.com',14);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrador_recepcionista`
--

DROP TABLE IF EXISTS `administrador_recepcionista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador_recepcionista` (
  `id_admin` int(11) NOT NULL,
  `id_recepcionista` int(11) NOT NULL,
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
  `id_cama` int(11) NOT NULL AUTO_INCREMENT,
  `estado` enum('Disponible','Ocupada','Mantenimiento') DEFAULT 'Disponible',
  `id_habitacion` int(11) DEFAULT NULL,
  `tipo_cama` varchar(20) DEFAULT NULL,
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
  `id_cita` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) DEFAULT 'Pendiente',
  `motivo` varchar(5000) NOT NULL,
  `fecha_cita` datetime DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `cedula` varchar(15) DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `especialidad_referencia` varchar(60) DEFAULT NULL,
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
INSERT INTO `cita` VALUES (1,'Pendiente','Me duele la cabeza','2024-11-21 00:00:00',NULL,NULL,'E-8-217872',12,1,NULL,'14:00:00'),(2,'Pendiente','Fiebre','2024-11-21 00:00:00',NULL,NULL,'7777',12,1,NULL,'14:45:00');
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `ClienteID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Provincia` varchar(50) NOT NULL,
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
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `detalles_compra` text DEFAULT NULL,
  `cedula_paciente` varchar(15) DEFAULT NULL,
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
  `CompraID` int(11) NOT NULL AUTO_INCREMENT,
  `ClienteID` int(11) NOT NULL,
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
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_departamento` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'Pediatría','Departamento encargado del cuidado de niños y adolescentes.'),(2,'Cardiología','Departamento especializado en el diagnóstico y tratamiento de enfermedades del corazón.'),(3,'Oncología','Departamento dedicado al diagnóstico y tratamiento del cáncer.'),(4,'Odontología','Consulta con odontólogo para chequeos y tratamientos dentales.'),(5,'Medicina General','Consulta médica general para diagnóstico, tratamiento y prevención de enfermedades comunes, así como el seguimiento de la salud del paciente.'),(6,'Dermatología','Consulta médica especializada en el diagnóstico, tratamiento y prevención de enfermedades de la piel, cabello y uñas, incluyendo enfermedades dermatológicas comunes y crónicas. Además, se enfoca en el cuidado y seguimiento integral de la salud dermatológica del paciente.');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examenes`
--

DROP TABLE IF EXISTS `examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examenes` (
  `id_examen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
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
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `monto` decimal(10,2) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `detalles_factura` text DEFAULT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `id_recepcionista` int(11) DEFAULT NULL,
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
  `id_farmaceutico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_farmaceutico` varchar(255) NOT NULL,
  `correo_farmaceutico` varchar(255) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
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
INSERT INTO `farmaceutico` VALUES (1,'Nicolas Tesla','nicotes33@gmail.com',15);
/*!40000 ALTER TABLE `farmaceutico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habitacion`
--

DROP TABLE IF EXISTS `habitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitacion` (
  `id_habitacion` int(11) NOT NULL AUTO_INCREMENT,
  `capacidad_disponible` int(11) NOT NULL,
  `ubicacion` text DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
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
  `cedula` varchar(255) NOT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `altura` decimal(10,2) DEFAULT NULL,
  `presion_arterial` varchar(20) DEFAULT NULL,
  `frecuencia_cardiaca` int(11) DEFAULT NULL,
  `tipo_sangre` varchar(10) DEFAULT NULL,
  `antecedentes_personales` text DEFAULT NULL,
  `otros_antecedentes` text DEFAULT NULL,
  `antecedentes_no_patologicos` text DEFAULT NULL,
  `otros_antecedentes_no_patologicos` text DEFAULT NULL,
  `condicion_general` text DEFAULT NULL,
  `examenes` text DEFAULT NULL,
  `laboratorios` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `receta` text DEFAULT NULL,
  `recomendaciones` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `fecha_cita` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_departamento_referencia` int(11) DEFAULT NULL,
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
  `id_hora` int(11) NOT NULL AUTO_INCREMENT,
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
  `id_medicamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `cant_stock` int(11) DEFAULT NULL,
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
INSERT INTO `medicamento` VALUES (1,'Paracetamol','Analgésico general',100,5.99,NULL),(2,'Amoxicilina','Antibiótico',50,12.99,NULL),(3,'Ibuprofeno','Antiinflamatorio',75,8.99,NULL);
/*!40000 ALTER TABLE `medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medico` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_medico` varchar(100) DEFAULT NULL,
  `correo_medico` varchar(100) DEFAULT NULL,
  `id_hora` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  KEY `id_hora` (`id_hora`),
  KEY `id_departamento` (`id_departamento`),
  KEY `medico_usuario_fk` (`id_usuario`),
  CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`id_hora`) REFERENCES `horario` (`id_hora`),
  CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  CONSTRAINT `medico_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (1,'Dr. Carlos Mendoza','carlosmendoza@gmail.com',1,1,16),(2,'Dra. Elena Rodríguez','elenarodriguez@gmail.com',2,1,17),(3,'Dr. Javier Gómez','javiergomez@gmail.com',1,2,18),(4,'Dra. Mariana Pérez','marianaperez@gmail.com',2,2,19),(5,'Dr. Fernando Ortiz','fernandoortiz@gmail.com',1,3,20),(6,'Dra. Sofía Ramírez','sofiaramirez@gmail.com',2,3,21),(7,'Dr. Alberto Fernández','albertofernandez@gmail.com',1,4,22),(8,'Dra. Laura Castillo','lauracastillo@gmail.com',2,4,23),(9,'Dr. Laura Martínez','lauramartinez@gmail.com',1,5,25),(10,'Dr. Javier Rodríguez','javierrodriguez@gmail.com',2,5,26),(11,'Dr. Beatriz Gómez','beatrizgomez@gmail.com',1,5,27),(12,'Dr. Manuel López','manuellopez@gmail.com',2,5,28),(13,'Dr. Isabel Sánchez','isabelsanchez@gmail.com',1,6,29),(14,'Dr. Carlos Fernández','carlosfernandez@gmail.com',2,6,30);
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `cedula` varchar(15) NOT NULL,
  `nombre_paciente` varchar(100) DEFAULT NULL,
  `correo_paciente` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion_paciente` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `edad` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `id_seguro` int(11) DEFAULT NULL,
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
INSERT INTO `paciente` VALUES ('1','a','a@a.com','2022-12-12','a','1',1,2,'Masculino',4),('1234','Moisés Betancourt','moisos03@gmail.com','2003-02-05','Panama','1234',21,3,'Masculino',3),('123456789','Juan Pérez','juan.perez@example.com','1985-05-15','Calle Falsa 123, Ciudad','555-1234',24,NULL,'Masculino',NULL),('3-1567-2839','Luisito Eduardo Comunica Versallez','luisitocomunica@gmail.com','1998-10-08','Condado, calle 14','8495-2234',26,31,'Masculino',4),('456789123','Luis Martínez','luis.martinez@example.com','1978-03-30','Boulevard de los Sueños 789, Ciudad','555-9012',0,NULL,'Masculino',NULL),('7777','Pedrolongo Juarez','pedrolongo1@gmail.com','2001-11-17','Los Andes','7777',23,24,'Masculino',4),('8-yeafer','Fernando Barrios','yeafer@gmail.com','2003-11-24','Cincuentenario','507121212',20,9,'Masculino',3),('9000','Juan González','juanito@gmail.com','2003-11-15','Pacora','+1 656589281',20,4,'Masculino',2),('987654321','María González','maria.gonzalez@example.com','1990-08-25','Avenida Siempre Viva 456, Ciudad','555-5678',0,NULL,'Masculino',NULL),('asd','aaaaaaaaaaa','asdasd@asdsad.com',NULL,'Pacora','123123',0,NULL,'Masculino',NULL),('E-8-217872','Moisés Betancourt','moisos695@gmail.com','2003-02-05','Bethania','+507 69353940',21,32,'Masculino',4);
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente_hospitalizado`
--

DROP TABLE IF EXISTS `paciente_hospitalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente_hospitalizado` (
  `cedula` varchar(15) NOT NULL,
  `id_cama` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_egreso` datetime DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `estado_pacienteH` enum('Hospitalizado','No hospitalizado') DEFAULT 'Hospitalizado',
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
INSERT INTO `paciente_hospitalizado` VALUES ('1234',1,1,'2024-11-17 10:45:00',NULL,'Cirugia','Hospitalizado'),('123456789',6,4,'2024-10-25 09:40:00',NULL,'Embarazo','Hospitalizado'),('456789123',4,3,'2024-11-16 12:30:00',NULL,'Cirugia','Hospitalizado'),('9000',14,2,'2024-10-24 08:15:00',NULL,'Cirugia','Hospitalizado'),('987654321',10,1,'2024-11-10 15:35:00',NULL,'Embarazo','Hospitalizado');
/*!40000 ALTER TABLE `paciente_hospitalizado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
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
  `id_recepcionista` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_recepcionista` varchar(100) NOT NULL,
  `correo_recepcionista` varchar(100) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_recepcionista`),
  UNIQUE KEY `correo_recepcionista` (`correo_recepcionista`),
  KEY `fk_id_usuario` (`id_usuario`),
  CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recepcionista`
--

LOCK TABLES `recepcionista` WRITE;
/*!40000 ALTER TABLE `recepcionista` DISABLE KEYS */;
INSERT INTO `recepcionista` VALUES (1,'Recepcionista1','recepcionista1@example.com',NULL),(2,'Recepcionista2','recepcionista2@example.com',NULL),(3,'Recepcionista3','recepcionista3@example.com',NULL);
/*!40000 ALTER TABLE `recepcionista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receta`
--

DROP TABLE IF EXISTS `receta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receta` (
  `id_receta` int(11) NOT NULL AUTO_INCREMENT,
  `id_cita` int(11) DEFAULT NULL,
  `id_medicamento` int(11) DEFAULT NULL,
  `dosis` varchar(50) DEFAULT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `frecuencia` varchar(50) DEFAULT NULL,
  `estado` varchar(12) DEFAULT 'Pendiente',
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
  `id_referencia` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_paciente` varchar(15) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `fecha_referencia` date NOT NULL,
  `id_medico` int(11) NOT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `usado` tinyint(1) DEFAULT 0,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
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
  `id_seguro` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_aseguradora` varchar(100) NOT NULL,
  `contacto_aseguradora` varchar(100) DEFAULT NULL,
  `direccion_aseguradora` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_seguro`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro`
--

LOCK TABLES `seguro` WRITE;
/*!40000 ALTER TABLE `seguro` DISABLE KEYS */;
INSERT INTO `seguro` VALUES (1,'SaludMax','0800-123-4567','Av. Siempre Viva 123, Ciudad Salud'),(2,'AseguraVida','0800-987-6543','Calle Ficticia 456, Ciudad Salud'),(3,'Medicos del Mundo','contacto@medicosmundos.com','Calle Ejemplo 789, Ciudad Salud'),(4,'Salud Total','0800-555-1212','Calle Central 101, Ciudad Salud'),(5,'Protección Salud','0800-444-3333','Calle Secundaria 202, Ciudad Salud');
/*!40000 ALTER TABLE `seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguro_paciente`
--

DROP TABLE IF EXISTS `seguro_paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguro_paciente` (
  `cedula` varchar(20) NOT NULL,
  `id_seguro` int(11) NOT NULL,
  `numero_poliza` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `deducible_anual` decimal(10,2) NOT NULL,
  `coaseguro` decimal(5,2) NOT NULL,
  `limite_cobertura` decimal(15,2) DEFAULT NULL,
  `monto_utilizado` decimal(15,2) DEFAULT 0.00,
  `activo` enum('Activo','Inactivo') DEFAULT 'Activo',
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
INSERT INTO `seguro_paciente` VALUES ('123456789',1,'POL123456','2023-01-01','2024-01-01',1000.00,20.00,50000.00,0.00,'Activo'),('456789123',2,'POL987654','2023-02-01','2024-02-01',1500.00,25.00,75000.00,0.00,'Activo'),('987654321',3,'POL456789','2023-03-01','2024-03-01',2000.00,15.00,100000.00,0.00,'Activo');
/*!40000 ALTER TABLE `seguro_paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`),
  KEY `fk_departamento` (`id_departamento`),
  CONSTRAINT `fk_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (1,'Cita Medicina General','Consulta con médico general para chequeos y tratamientos básicos.',50.00,5),(2,'Vacuna Pentavalente','Vacuna combinada para proteger contra cinco enfermedades: difteria, tétanos, tos ferina, hepatitis B y Haemophilus influenzae tipo b.',30.00,5),(3,'Vacuna Antirrábica','Vacuna para prevenir la rabia, recomendada tras mordeduras de animales.',40.00,5),(4,'Vacuna Influenza','Vacuna anual para prevenir la gripe.',25.00,5),(5,'Cita Dermatología','Consulta con dermatólogo para problemas de piel.',80.00,6),(6,'Cita Odontología','Consulta con odontólogo para chequeos y tratamientos dentales.',70.00,4),(7,'Cita Cardiología','Consulta con cardiólogo para chequeos y tratamientos cardíacos.',90.00,2);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes_examenes`
--

DROP TABLE IF EXISTS `solicitudes_examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes_examenes` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(15) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `estado` enum('Pendiente','Realizado','Cancelado') DEFAULT 'Pendiente',
  `fecha_realizacion` datetime DEFAULT NULL,
  `resultado` text DEFAULT NULL,
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
  `id_proveedor` int(11) NOT NULL,
  `id_medicamento` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
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
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) DEFAULT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `tipo_usuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `contrasenia` (`contrasenia`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (2,'a@a.com','$2y$10$O42R2qV1yg2z1AI4Gj3Bx.apU6XFDDUeFIpfoz8XFvjcIeTAsJIS6','paciente'),(3,'moisos03@gmail.com','$2y$10$vciBarRSptqYPwth3BBhHOOc2iVqosrGlzSQ/Sp.H2cnmzDYK2q7K','paciente'),(4,'juanito@gmail.com','$2y$10$oGiry.tle3fTYTHOnyDC3uCDN8TZcD7SJ9.jv/oIC.ddvqZfUDNcW','paciente'),(6,'asdasd@asdsad.com','12345678','paciente'),(7,'albertito@hotmail.com','$2y$10$LPjt7onv9Pf14auyUqTpvuwsx9bos18cpYMlTBkbgDCVZfuS8tDX2','paciente'),(9,'yeafer@gmail.com','$2y$10$ByS.f3b0SNpZnggO1IRlCe2rZZz3bywviReszxadAYtMCSeAwG9rG','paciente'),(12,'aasdasda@gm.com','$2y$10$fQaDODArmp9CleCW/px4lu8WFaN0xIP2Wj3OkJSIALS.dvovEnAwK','medico'),(14,'elon@x.com','$2y$10$mqO3Z4sTuy8co/.mDYGLHuzXfUcdjzk6uFQvb0TI4Y61ZBJ/mcIcS','Administrador'),(15,'nicotes33@gmail.com','$2y$10$5lcOrZe62y0WMQlz.1Jz0uKtkPs8680UZkYhS595t3qs6QW5Tqu1O','Farmaceutico'),(16,'carlosmendoza@gmail.com','$2y$10$tdc89.hSRWb0gRYbeq.ZcOpp8Lf0AQ3QxVwUZ0ySXtQ5C.a8gsiby','Médico'),(17,'elenarodriguez@gmail.com','$2y$10$LdiIUZV2PtW9fbG393kA3.V7UFMB5RPrpfr4sZyS8hSw7orSqnqfu','Médico'),(18,'javiergomez@gmail.com','$2y$10$tMycfin1gvM/qTJsZzy0p.Aj/j7UoLBe8OmXolJduv3vSroQ1P0je','Médico'),(19,'marianaperez@gmail.com','$2y$10$85lYnOtCskL/JULs3TI2Eu/p2UlBaTLIyuJT5vHVIALDdkulUWjkG','Médico'),(20,'fernandoortiz@gmail.com','$2y$10$riZb3zwWkl88/Bl30vLJXuYmfZ4.C9KXQbtV2hxE.zDmM3iwCEhxO','Médico'),(21,'sofiaramirez@gmail.com','$2y$10$AxJ23Vb3Wf8VCwqMcZypv.spCiyGGj72bPwp8HrJfi.GX/WT.wI5C','Médico'),(22,'albertofernandez@gmail.com','$2y$10$2UYTgEbUIRfqFKDRoDVNVOojh8zIeIwhMuenL3SYNpOeQmSt/DAd.','Médico'),(23,'lauracastillo@gmail.com','$2y$10$Y71b4gjUUU/So98RU2Yb6uZvFm.KBxG9f1vQYLca9wx/ZndyiKks2','Médico'),(24,'pedrolongo1@gmail.com','$2y$10$.oRfGCCbCokM7k1gJqNZKuBtH93zUOUsPACqqHc9BkJnBdcbix3Re','Paciente'),(25,'lauramartinez@gmail.com','$2y$10$/iU/9uIdbFHS4aRXsU9nvuTqE4iA6W58GtDxMRjXU8pR8ZNK46.v6','Médico'),(26,'javierrodriguez@gmail.com','$2y$10$2x/A15Jy40HJBOWd2QAn9urU3j8Hibyg4QrMqaFcka6MptY/aahju','Médico'),(27,'beatrizgomez@gmail.com','$2y$10$deVrSMgrXlVpBE2wCQ8weuVPAiLYljOSneS6YnyGz6cQAjpww3x4u','Médico'),(28,'manuellopez@gmail.com','$2y$10$3UFKOp7X0mpnr6bGuYbub.K4HGFWFAs.k8cziqcJs2p2qJzOeyboO','Médico'),(29,'isabelsanchez@gmail.com','$2y$10$qQWa68phNMyKITmXJS9jleEjFwqRIkt9W9Muia21w3viwq5ChsV.W','Médico'),(30,'carlosfernandez@gmail.com','$2y$10$rYLlKNkpwlQN4tb1wBowfeNvNGk0Ry/sm2hxMGMTt7a11oVuBvvS2','Médico'),(31,'luisitocomunica@gmail.com','$2y$10$wJIrdqvex0Prg3XQboE8duaawuWX.D1HzujPNl8t9irni8l5WOKdK','Paciente'),(32,'moisos695@gmail.com','$2y$10$KrC04G0KTjXOS3r.BYKUQ.UHlpd5aEvzSZBVdlAKrf04qSDaaxQZq','Paciente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'gestionclinica_db'
--

--
-- Dumping routines for database 'gestionclinica_db'
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

-- Dump completed on 2024-11-20  2:37:50
