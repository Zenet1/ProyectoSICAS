-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: sicasbd
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.22-MariaDB

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
-- Table structure for table `academicos`
--

DROP TABLE IF EXISTS `academicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academicos` (
  `IDProfesor` int(11) NOT NULL AUTO_INCREMENT,
  `ClaveProfesor` int(11) NOT NULL,
  `NombreProfesor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoPaternoProfesor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoMaternoProfesor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `GradoAcademico` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `CorreoProfesor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ActivoProfesor` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDProfesor`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academicos`
--

LOCK TABLES `academicos` WRITE;
/*!40000 ALTER TABLE `academicos` DISABLE KEYS */;
INSERT INTO `academicos` VALUES (1,1,'Juan','Ucán','Pech','Dr.','juan.pech@correo.uady.mx','1'),(2,2,'Otilio','Santos','Aguilar','M.I.E.','otilio.aguilar@correo.uady.mx','1'),(3,3,'Víctor','Menéndez','Domínguez','Dr.','victor.dominguez@correo.uady.mx','1'),(4,4,'José','Lara','Rodríguez','Dr.','jose.rodriguez@correo.uady.mx','1'),(5,5,'Raúl','Aguilar','Vera','Dr.','raul.vera@correo.uady.mx','1'),(6,6,'Fernando','Ruiz','Cardeña','I.S.C','fernando.ruiz@correo.uady.mx','1'),(7,7,'Juan','Garcilazo','Ortiz','M.C','juan.garcilazo@correo.uady.mx','1'),(8,8,'María','Kantún','Chim','M. en C.','maria.chim@correo.uady.mx','1'),(9,9,'Julio','Díaz','Mendoza','M.T.I.','julio.mendoza@correo.uady.mx','1'),(10,10,'Fernando','Cobá','Arias','Dr.','fernando.arias@correo.uady.mx','1'),(11,11,'Luis','Basto','Díaz','M.C.','louis.diaz@correo.uady.mx','1'),(12,12,'Enriqueta','Castellanos','Bolaños','M.G.T.I.','maria.bolaños@correo.uady.mx','1'),(13,13,'Johan','Estrada','López','Dr.','johan.estrada@correo.uady.mx','1'),(14,14,'Felipe','Rosado','Vázquez','M. en C.','felipe.vazquez@correo.uady.mx','1'),(15,15,'Anabel','Martín','González','Dra.','anabel.martin@correo.uady.mx','1'),(16,16,'Auxilio','Chan','García','L.A.','auxilio.garcia@correo.uady.mx','1');
/*!40000 ALTER TABLE `academicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administradores` (
  `IDAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `NombreAdmin` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDUsuario` int(11) NOT NULL,
  PRIMARY KEY (`IDAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES (1,'Elías Navarro',36),(2,'Rodrigo Casale',37);
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrativos`
--

DROP TABLE IF EXISTS `administrativos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrativos` (
  `IDAdministrativo` int(11) NOT NULL AUTO_INCREMENT,
  `NombreAdministrativo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDUsuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDAdministrativo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrativos`
--

LOCK TABLES `administrativos` WRITE;
/*!40000 ALTER TABLE `administrativos` DISABLE KEYS */;
INSERT INTO `administrativos` VALUES (1,'Saúl Aguilar','34'),(2,'María Antonieta','35');
/*!40000 ALTER TABLE `administrativos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `IDAlumno` int(11) NOT NULL AUTO_INCREMENT,
  `Matricula` int(11) NOT NULL,
  `NombreAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoPaternoAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoMaternoAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDPlanEstudio` int(11) NOT NULL,
  `CorreoAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Genero` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ActivoAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaLimiteSuspension` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDUsuario` int(11) NOT NULL,
  `IDModelo` int(11) NOT NULL,
  `NivelEducativo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDAlumno`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (2,17016365,'Andres','Naal','Jacome',2,'andresjacome18@gmail.com','Masculino','1','12/12/2025',3,2,'Licenciatura'),(3,16003210,'Eduardo','López','Guerrero',2,'eduardzenet@outlook.com','Masculino','1','12/12/2025',4,1,'Licenciatura'),(4,16001614,'Miguel','González','Herrera',2,'miguelhumberto522@gmail.com','Masculino','1','12/12/2025',5,1,'Licenciatura'),(6,16001339,'Carlos','Greene','Mex',4,'a16001339@alumnos.uady.mx','Masculino','1','12/12/2025',7,1,'Licenciatura'),(7,16001616,'Jesús','Álvarez','Vázquez',3,'a16001616@alumnos.uady.mx','Masculino','1','12/12/2025',8,2,'Licenciatura'),(8,16004378,'Lucano','Espinosa','Martín',4,'lucano.martin@alumnos.uady.mx','Masculino','1','12/12/2025',9,1,'Licenciatura'),(9,16004260,'Carlos','Kuk','Baeza',2,'carlos.kuk@alumnos.uady.mx','Masculino','1','12/12/2025',10,1,'Licenciatura'),(10,14001088,'Marco','Aragón','Serrano',2,'marco.aragon@alumnos.uady.mx','Masculino','1','12/12/2025',11,1,'Licenciatura'),(11,14003222,'David','Ávila','Pacheco',2,'david.avila@alumnos.uady.mx','Masculino','1','12/12/2025',12,2,'Licenciatura'),(12,13003985,'Kevin','Basto','Anquino',2,'kevin.basto@alumnos.uady.mx','Masculino','1','12/12/2025',13,2,'Licenciatura'),(13,19216288,'Edgar','Bezares','Samaniego',3,'edgar.samaniego@alumnos.uady.mx','Masculino','1','12/12/2025',14,2,'Licenciatura'),(14,19216278,'Gerardo','Caamal','Rios',4,'gerardo.rios@alumnos.uady.mx','Masculino','1','12/12/2025',15,2,'Licenciatura'),(15,16003660,'Pamela','Canul','Chacon',3,'pamela.chacon@alumnos.uady.mx','Femenino','0','12/12/2025',16,1,'Licenciatura'),(16,12000986,'Larry','Carrillo','Herrera',3,'larry.herrera@alumnos.uady.mx','Masculino','0','12/12/2025',17,2,'Licenciatura');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignaturas` (
  `IDAsignatura` int(11) NOT NULL AUTO_INCREMENT,
  `ClaveAsignatura` int(11) NOT NULL,
  `NombreAsignatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDPlanEstudio` int(11) NOT NULL,
  PRIMARY KEY (`IDAsignatura`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaturas`
--

LOCK TABLES `asignaturas` WRITE;
/*!40000 ALTER TABLE `asignaturas` DISABLE KEYS */;
INSERT INTO `asignaturas` VALUES (1,1,'Arquitectura de Software',2),(2,2,'Construcción de Software',2),(4,2,'Desarrollo de Aplicaciones Web',2),(5,4,'Arquitectura y Organización de Computadoras',2),(6,4,'Arquitectura y Organización de Computadoras',4),(7,4,'Álgebra Lineal',2),(8,7,'Diseño de Bases de Datos',2),(9,8,'Inteligencia Artificial',3),(10,9,'Machine Learning',3),(11,10,'Probabilidad',3),(12,11,'Ecuaciones Diferenciales',3),(13,12,'Teoría de Lenguajes de Programación',3),(14,13,'Modelado de Datos',3),(15,14,'Compiladores',3),(16,14,'Sistemas Operativos',3),(17,16,'Análisis y Diseño de Software',3),(18,17,'Ecuaciones Diferenciales',4),(19,18,'Sistemas Digitales I',4),(20,19,'Sistemas Digitales II',4),(21,20,'Circuitos Electrónicos I',4),(22,21,'Circuitos Electrónicos II',4),(23,22,'Inteligencia Artificial',4),(24,22,'Señales y Sistemas',4),(25,24,'Inferencia Estadística',2);
/*!40000 ALTER TABLE `asignaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistencia` (
  `IDAsistencia` int(11) NOT NULL AUTO_INCREMENT,
  `IDAlumno` int(11) NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraIngreso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraSalida` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `LugarEntrada` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDAsistencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargaacademica`
--

DROP TABLE IF EXISTS `cargaacademica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargaacademica` (
  `IDCarga` int(11) NOT NULL AUTO_INCREMENT,
  `IDAlumno` int(11) NOT NULL,
  `IDPlanEstudio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDGrupo` int(11) NOT NULL,
  PRIMARY KEY (`IDCarga`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargaacademica`
--

LOCK TABLES `cargaacademica` WRITE;
/*!40000 ALTER TABLE `cargaacademica` DISABLE KEYS */;
INSERT INTO `cargaacademica` VALUES (1,3,'2',1),(2,3,'2',2),(3,3,'2',3),(4,3,'2',6),(5,3,'2',16),(6,3,'2',17),(7,4,'2',6),(8,4,'2',3),(9,4,'2',18),(10,4,'2',2),(11,4,'2',16),(12,98,'',1),(13,77,'',2),(14,50,'',3),(15,103,'',3),(16,71,'',4),(17,79,'',5),(18,54,'',5),(19,71,'',5),(20,117,'',5),(21,75,'',5),(22,103,'',5),(23,90,'',5),(24,78,'',5),(25,50,'',5),(26,98,'',5),(27,119,'',5),(28,51,'',5),(29,127,'',5),(30,55,'',5),(31,88,'',5),(32,68,'',5),(33,122,'',5),(34,108,'',5),(35,42,'',5),(36,86,'',5),(37,11,'',6),(38,24,'',6),(39,9,'',6),(40,2,'',6);
/*!40000 ALTER TABLE `cargaacademica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edificios`
--

DROP TABLE IF EXISTS `edificios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edificios` (
  `IDEdificio` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEdificio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDEdificio`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edificios`
--

LOCK TABLES `edificios` WRITE;
/*!40000 ALTER TABLE `edificios` DISABLE KEYS */;
INSERT INTO `edificios` VALUES (1,'A'),(2,'B'),(3,'C'),(4,'D'),(5,'E'),(6,'F'),(7,'G'),(8,'H'),(9,'Laboratorio de Redes');
/*!40000 ALTER TABLE `edificios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `externos`
--

DROP TABLE IF EXISTS `externos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `externos` (
  `IDExterno` int(11) NOT NULL AUTO_INCREMENT,
  `NombreExterno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ApellidosExterno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Empresa` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CorreoExterno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDExterno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `externos`
--

LOCK TABLES `externos` WRITE;
/*!40000 ALTER TABLE `externos` DISABLE KEYS */;
/*!40000 ALTER TABLE `externos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos` (
  `IDGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `IDAsignatura` int(11) NOT NULL,
  `IDProfesor` int(11) NOT NULL,
  `ClaveGrupo` int(11) NOT NULL,
  `Grupo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDGrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (1,1,3,1,'G1'),(2,4,1,2,'G1'),(3,2,7,3,'G1'),(4,25,8,4,'G1'),(5,8,12,5,'G1'),(6,8,5,6,'G2'),(7,8,9,7,'G3'),(8,14,11,8,'G1'),(9,13,11,9,'G1'),(10,11,16,10,'G1'),(11,12,14,11,'G1'),(12,21,13,12,'G1'),(13,19,15,13,'G1'),(14,18,14,14,'G1'),(15,23,15,15,'G1'),(16,5,6,16,'G1'),(17,7,4,17,'G1'),(18,1,7,18,'G2');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios` (
  `IDHorario` int(11) NOT NULL AUTO_INCREMENT,
  `IDGrupo` int(11) NOT NULL,
  `Dia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraInicioHorario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraFinHorario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IDSalon` int(11) NOT NULL,
  PRIMARY KEY (`IDHorario`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios`
--

LOCK TABLES `horarios` WRITE;
/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;
INSERT INTO `horarios` VALUES (1,1,'Lunes','13:00','14:30',12),(2,1,'Miércoles','13:00','14:30',12),(3,1,'Viernes','13:00','14:30',27),(4,3,'Lunes','16:00','17:30',12),(5,3,'Martes','13:00','14:30',27),(6,3,'Jueves','13:00','14:30',27),(7,2,'Lunes','14:30','16:00',12),(8,2,'Miércoles','14:30','16:00',12),(9,2,'Viernes','14:30','16:00',12),(10,16,'Lunes','10:30','12:00',30),(11,16,'Jueves','10:30','12:00',30),(12,16,'Viernes','10:30','12:00',30),(13,17,'Lunes','9:00','10:30',28),(14,17,'Jueves','9:00','10:30',28),(15,17,'Viernes','9:00','10:30',28),(16,6,'Martes','14:30','16:00',28),(17,6,'Miércoles','16:00','17:30',10),(18,6,'Viernes','16:00','17:30',10),(19,18,'Lunes','13:00','14:30',33),(20,18,'Miércoles','13:00','14:30',33),(21,18,'Viernes','13:00','14:30',29);
/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modeloeducativo`
--

DROP TABLE IF EXISTS `modeloeducativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modeloeducativo` (
  `IDModelo` int(11) NOT NULL AUTO_INCREMENT,
  `SiglasModelo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDModelo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modeloeducativo`
--

LOCK TABLES `modeloeducativo` WRITE;
/*!40000 ALTER TABLE `modeloeducativo` DISABLE KEYS */;
INSERT INTO `modeloeducativo` VALUES (1,'MEFI'),(2,'MEYA');
/*!40000 ALTER TABLE `modeloeducativo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planesdeestudio`
--

DROP TABLE IF EXISTS `planesdeestudio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planesdeestudio` (
  `IDPlanEstudio` int(11) NOT NULL AUTO_INCREMENT,
  `NombrePlan` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `SiglasPlan` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ClavePlan` int(11) NOT NULL,
  `VersionPlan` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDPlanEstudio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planesdeestudio`
--

LOCK TABLES `planesdeestudio` WRITE;
/*!40000 ALTER TABLE `planesdeestudio` DISABLE KEYS */;
INSERT INTO `planesdeestudio` VALUES (1,'Licenciatura en Ingeniería de Software','LIS',1,'1'),(2,'Licenciatura en Ingeniería de Software','LIS',2,'2'),(3,'Licenciatura en Ciencias de la Computación','LCC',3,'1'),(4,'Licenciatura en Ingeniería en Computación','LIC',4,'1');
/*!40000 ALTER TABLE `planesdeestudio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `porcentajecapacidad`
--

DROP TABLE IF EXISTS `porcentajecapacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `porcentajecapacidad` (
  `IDPorcentaje` int(11) NOT NULL AUTO_INCREMENT,
  `Porcentaje` int(11) NOT NULL,
  `FechaInicio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDPorcentaje`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `porcentajecapacidad`
--

LOCK TABLES `porcentajecapacidad` WRITE;
/*!40000 ALTER TABLE `porcentajecapacidad` DISABLE KEYS */;
INSERT INTO `porcentajecapacidad` VALUES (1,75,'10/01/2022'),(2,100,'11/01/2022'),(3,70,'12/01/2022');
/*!40000 ALTER TABLE `porcentajecapacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preguntas` (
  `IDPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `Pregunta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Opcion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDPregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
INSERT INTO `preguntas` VALUES (2,'¿Está completamente vacunado contra el COVID-19?','Usted se considera completamente vacunado dos semanas después de ponerse la segunda dosis, cuando la vacuna que le aplicaron es de una serie de dos dosis. O dos semanas después de ponerse una única dosis como es el caso de quienes recibieron la vacuna CanSino.','Si, completamente','Si');
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservacionesalumnos`
--

DROP TABLE IF EXISTS `reservacionesalumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservacionesalumnos` (
  `IDReservaAlumno` int(11) NOT NULL AUTO_INCREMENT,
  `IDCarga` int(11) NOT NULL,
  `FechaReservaAl` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraInicioReservaAl` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraFinReservaAl` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraAlumno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDReservaAlumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservacionesalumnos`
--

LOCK TABLES `reservacionesalumnos` WRITE;
/*!40000 ALTER TABLE `reservacionesalumnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservacionesalumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservacionesexternos`
--

DROP TABLE IF EXISTS `reservacionesexternos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservacionesexternos` (
  `IDReservaExterno` int(11) NOT NULL AUTO_INCREMENT,
  `IDExterno` int(11) NOT NULL,
  `FechaReservaEx` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraInicioReservaEx` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraFinReservaEx` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaExterno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraExterno` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDReservaExterno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservacionesexternos`
--

LOCK TABLES `reservacionesexternos` WRITE;
/*!40000 ALTER TABLE `reservacionesexternos` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservacionesexternos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `IDRol` int(11) NOT NULL AUTO_INCREMENT,
  `Rol` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDRol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Alumno'),(2,'Academico'),(3,'Capturador'),(4,'Administrador');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salones`
--

DROP TABLE IF EXISTS `salones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salones` (
  `IDSalon` int(11) NOT NULL AUTO_INCREMENT,
  `IDEdificio` int(11) NOT NULL,
  `NombreSalon` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Capacidad` int(11) NOT NULL,
  PRIMARY KEY (`IDSalon`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salones`
--

LOCK TABLES `salones` WRITE;
/*!40000 ALTER TABLE `salones` DISABLE KEYS */;
INSERT INTO `salones` VALUES (1,1,'1',30),(2,1,'2',31),(3,1,'3',29),(4,1,'4',31),(5,1,'5',31),(6,1,'6',30),(7,2,'1',30),(8,2,'2',30),(9,2,'3',30),(10,3,'C1',40),(11,3,'C2',40),(12,3,'C3',50),(13,3,'C4',50),(14,3,'C5',50),(15,4,'1',30),(16,4,'2',30),(17,4,'3',30),(18,5,'1',30),(19,5,'2',30),(20,5,'3',30),(21,6,'1',30),(22,6,'2',30),(23,6,'3',30),(24,7,'1',30),(25,7,'2',30),(26,7,'3',30),(27,8,'1',30),(28,8,'2',30),(29,8,'3',30),(30,9,'Redes',50),(31,3,'C6',30),(32,3,'C7',30),(33,3,'C8',30);
/*!40000 ALTER TABLE `salones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `IDUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Cuenta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Contraseña` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `IDRol` int(11) NOT NULL,
  PRIMARY KEY (`IDUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (3,'a17016365','123',1),(4,'a16003210','123',1),(5,'a16001614','123',1),(7,'a16001339','123',1),(8,'a16001616','123',1),(9,'a16004378','123',1),(10,'a16004260','123',1),(11,'a14001088','123',1),(12,'a14003222','123',1),(13,'a13003985','123',1),(14,'a19216288','123',1),(15,'a19216278','123',1),(16,'a16003660','123',1),(17,'a12000986','123',1),(18,'juan.ucan','123',2),(19,'otilio.aguilar','123',2),(20,'victor.dominguez','123',2),(21,'jose.rodriguez','123',2),(22,'raul.vera','123',2),(23,'fernando.ruiz','123',2),(24,'juan.garcilazo','123',2),(25,'maria.chim','123',2),(26,'julio.mendoza','123',2),(27,'fernando.arias','123',2),(28,'louis.diaz','123',2),(29,'maria.bolaños','123',2),(30,'johan.estrada','123',2),(31,'felipe.vazquez','123',2),(32,'anabel.martin','123',2),(33,'auxilio.garcia','123',2),(34,'saul.aguilar','123',3),(35,'maria.antonieta','123',3),(36,'elias.navarro','123',4),(37,'rodrigo.casale','123',4);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-26  1:54:57
