-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: gestionclinica_bd
-- ------------------------------------------------------
-- Server version	8.4.3

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `cama`
--

DROP TABLE IF EXISTS `cama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cama` (
  `id_cama` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_habitacion` int DEFAULT NULL,
  PRIMARY KEY (`id_cama`),
  KEY `id_habitacion` (`id_habitacion`),
  CONSTRAINT `cama_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `recordatorio` text COLLATE utf8mb4_general_ci,
  `fecha_cita` datetime DEFAULT NULL,
  `diagnostico` text COLLATE utf8mb4_general_ci,
  `tratamiento` text COLLATE utf8mb4_general_ci,
  `cedula` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_medico` int DEFAULT NULL,
  `id_servicio` int DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  KEY `cedula` (`cedula`),
  KEY `id_medico` (`id_medico`),
  KEY `id_servicio` (`id_servicio`),
  CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `farmaceutico`
--

DROP TABLE IF EXISTS `farmaceutico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `farmaceutico` (
  `id_farmaceutico` int NOT NULL AUTO_INCREMENT,
  `nombre_farmaceutico` varchar(255) NOT NULL,
  `correo_farmaceutico` varchar(255) NOT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_farmaceutico`),
  UNIQUE KEY `correo_farmaceutico` (`correo_farmaceutico`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `farmaceutico_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `habitacion`
--

DROP TABLE IF EXISTS `habitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitacion` (
  `id_habitacion` int NOT NULL AUTO_INCREMENT,
  `capacidad` int DEFAULT NULL,
  `ubicacion` text COLLATE utf8mb4_general_ci,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`cedula`),
  KEY `id_cita` (`id_cita`),
  KEY `id_medico` (`id_medico`),
  CONSTRAINT `historial_medico_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`),
  CONSTRAINT `historial_medico_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `dias_trabajo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_hora`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id_medicamento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `paciente_hospitalizado`
--

DROP TABLE IF EXISTS `paciente_hospitalizado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente_hospitalizado` (
  `id_paciente` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cama` int NOT NULL,
  `id_habitacion` int NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_paciente`,`id_cama`,`id_habitacion`),
  KEY `id_cama` (`id_cama`),
  KEY `id_habitacion` (`id_habitacion`),
  CONSTRAINT `paciente_hospitalizado_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`cedula`),
  CONSTRAINT `paciente_hospitalizado_ibfk_2` FOREIGN KEY (`id_cama`) REFERENCES `cama` (`id_cama`),
  CONSTRAINT `paciente_hospitalizado_ibfk_3` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contrasenia` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `contrasenia` (`contrasenia`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'gestionclinica_bd'
--
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerDatosRecetas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
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

-- Dump completed on 2024-11-04 18:55:00
