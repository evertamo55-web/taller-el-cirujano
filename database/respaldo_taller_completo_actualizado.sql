-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: taller_cirujano
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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id_cliente` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `nit_ci` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `clientes_nit_ci_unique` (`nit_ci`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Ever tamo Moye','75481944','B/primavera/Calle A1','10804660','2026-09-23 16:04:52','2026-09-23 16:04:52'),(2,'Roddy Erick Suarez','1026740','18 de noviembre','10804612 BN','2026-09-23 16:49:41','2026-09-23 16:51:37'),(3,'ever tamo','10203050','12 de noviembre','123302','2026-09-24 04:04:42','2026-09-24 04:04:42'),(4,'Alvaro Suarez','82401255','Calle A1/Primavera','12307012','2026-10-11 00:14:54','2026-10-11 00:14:54'),(5,'jairo avalo','71133352','13 de abril','10804690','2026-10-13 15:41:30','2026-10-13 15:41:30');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion_taller`
--

DROP TABLE IF EXISTS `configuracion_taller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion_taller` (
  `id_config` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_taller` varchar(100) NOT NULL DEFAULT 'Taller El Cirujano',
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `imagen_hero` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion_taller`
--

LOCK TABLES `configuracion_taller` WRITE;
/*!40000 ALTER TABLE `configuracion_taller` DISABLE KEYS */;
INSERT INTO `configuracion_taller` VALUES (1,'Taller \"El Cirujano\"','AV/18 de Noviembre casi Esquina C/Felix sattori','71133352',NULL,'8:00 am A  23:00 pm',NULL,NULL,'2026-10-14 21:27:38','2026-10-14 22:28:50');
/*!40000 ALTER TABLE `configuracion_taller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_servicios`
--

DROP TABLE IF EXISTS `detalle_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_servicios` (
  `id_detalle` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_orden_servicio` bigint(20) unsigned NOT NULL,
  `id_servicio` bigint(20) unsigned NOT NULL,
  `repuesto_traido_cliente` varchar(150) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `detalle_servicios_id_orden_servicio_foreign` (`id_orden_servicio`),
  KEY `detalle_servicios_id_servicio_foreign` (`id_servicio`),
  CONSTRAINT `detalle_servicios_id_orden_servicio_foreign` FOREIGN KEY (`id_orden_servicio`) REFERENCES `ordenes_servicio` (`id_orden_servicio`) ON DELETE CASCADE,
  CONSTRAINT `detalle_servicios_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_servicios`
--

LOCK TABLES `detalle_servicios` WRITE;
/*!40000 ALTER TABLE `detalle_servicios` DISABLE KEYS */;
INSERT INTO `detalle_servicios` VALUES (8,8,3,'Ninguno',15.00,'2026-10-11 03:16:25','2026-10-11 03:16:25'),(9,9,3,'LLave 19',15.00,'2026-10-12 05:36:35','2026-10-12 05:36:35'),(10,9,2,'llave 14',25.00,'2026-10-12 05:36:35','2026-10-12 05:36:35'),(11,9,1,'conjunto de llave L',150.00,'2026-10-12 05:36:35','2026-10-12 05:36:35'),(12,10,2,'Ninguno',25.00,'2026-10-12 08:21:47','2026-10-12 08:21:47'),(13,11,1,'llave 18 y 23',150.00,'2026-10-13 15:48:03','2026-10-13 15:48:03'),(14,12,2,'No',25.00,'2026-10-13 17:30:23','2026-10-13 17:30:23'),(15,13,3,'compro aceite nuevo',15.00,'2026-10-13 21:10:24','2026-10-13 21:10:24'),(17,15,2,'No ttrajo',25.00,'2026-10-15 22:52:13','2026-10-15 22:52:13');
/*!40000 ALTER TABLE `detalle_servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleados` (
  `id_empleado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(100) NOT NULL,
  `cargo` enum('propietario','operario','tecnico') NOT NULL DEFAULT 'tecnico',
  `telefono_empleado` varchar(20) DEFAULT NULL,
  `email_empleado` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `empleados_email_empleado_unique` (`email_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (1,'Jaime Noco','propietario','75012345',NULL,'activo','2026-09-17 17:06:52','2026-09-17 17:06:52'),(2,'Operario Familiar','operario','75054321',NULL,'activo','2026-09-17 17:06:52','2026-09-17 17:06:52'),(3,'Jesus Mae','tecnico','70000003',NULL,'activo','2026-09-17 17:06:52','2026-10-12 10:31:32'),(4,'Daniel Tamo','tecnico','70000004','evertamo55@gmail.com','activo','2026-09-17 17:06:52','2026-10-12 10:31:32'),(5,'Ceferino Noe','tecnico','70000005',NULL,'activo','2026-09-17 17:06:52','2026-09-17 17:06:52');
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `herramientas`
--

DROP TABLE IF EXISTS `herramientas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `herramientas` (
  `id_herramienta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_herramienta` varchar(50) NOT NULL,
  `nombre_herramienta` varchar(100) NOT NULL,
  `estado` enum('disponible','prestado','mantenimiento','extraviado') NOT NULL DEFAULT 'disponible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_herramienta`),
  UNIQUE KEY `herramientas_codigo_herramienta_unique` (`codigo_herramienta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `herramientas`
--

LOCK TABLES `herramientas` WRITE;
/*!40000 ALTER TABLE `herramientas` DISABLE KEYS */;
/*!40000 ALTER TABLE `herramientas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_08_23_210739_create_clientes_y_empleados_table',1),(2,'2026_08_23_211433_create_motos_servicios_herramientas_table',1),(3,'2026_08_25_192929_create_sessions_table',1),(4,'2026_09_13_190036_create_ordenes_detalles_prestamos_table',1),(5,'2026_09_17_053145_create_users_table',1),(6,'2026_09_17_063825_create_cache_table',1),(7,'2026_10_12_022710_add_email_empleado_to_empleados_table',2),(8,'2026_10_14_000001_create_servicios_portada_table',3),(9,'2026_10_14_000002_create_configuracion_taller_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motos`
--

DROP TABLE IF EXISTS `motos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motos` (
  `id_moto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `placa` varchar(15) DEFAULT NULL,
  `id_cliente` bigint(20) unsigned NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `fecha_ultimo_mantenimiento` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_moto`),
  KEY `motos_id_cliente_foreign` (`id_cliente`),
  CONSTRAINT `motos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motos`
--

LOCK TABLES `motos` WRITE;
/*!40000 ALTER TABLE `motos` DISABLE KEYS */;
INSERT INTO `motos` VALUES (1,'4381 UCA',1,'Serna','150','Rojo','2026-09-01','2026-09-23 16:06:51','2026-09-23 16:06:51'),(2,'6009EYR',2,'Kimgo','125','Azul','2026-09-23','2026-09-23 16:52:34','2026-09-23 16:58:33'),(3,'2200AH',3,'serna','150','verde','2026-09-24','2026-09-24 04:06:01','2026-09-24 04:06:01'),(4,'4381 bz',4,'Wave','150 C','Negro','2026-10-10','2026-10-11 00:21:54','2026-10-11 00:21:54'),(5,'6009 EYR',5,'Motocar','150 YR','verde','2026-10-13','2026-10-13 15:44:57','2026-10-13 15:44:57');
/*!40000 ALTER TABLE `motos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes_servicio`
--

DROP TABLE IF EXISTS `ordenes_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes_servicio` (
  `id_orden_servicio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_moto` bigint(20) unsigned NOT NULL,
  `id_empleado` bigint(20) unsigned NOT NULL,
  `fecha_recepcion` date NOT NULL,
  `fecha_entrega_estimada` date DEFAULT NULL,
  `descripcion_falla` text NOT NULL,
  `diagnostico_tecnico` text DEFAULT NULL,
  `total_mano_obra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado_servicio` enum('pendiente','en_progreso','completado','entregado') NOT NULL DEFAULT 'pendiente',
  `ganancia_taller` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ganancia_tecnico` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_orden_servicio`),
  KEY `ordenes_servicio_id_moto_foreign` (`id_moto`),
  KEY `ordenes_servicio_id_empleado_foreign` (`id_empleado`),
  CONSTRAINT `ordenes_servicio_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  CONSTRAINT `ordenes_servicio_id_moto_foreign` FOREIGN KEY (`id_moto`) REFERENCES `motos` (`id_moto`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes_servicio`
--

LOCK TABLES `ordenes_servicio` WRITE;
/*!40000 ALTER TABLE `ordenes_servicio` DISABLE KEYS */;
INSERT INTO `ordenes_servicio` VALUES (8,4,5,'2026-10-10',NULL,'se hizo la tesada de cadena',NULL,15.00,'entregado',7.50,7.50,'2026-10-11 03:16:25','2026-10-11 03:17:08'),(9,4,4,'2026-10-12',NULL,'se realiza mantemiento',NULL,190.00,'entregado',95.00,95.00,'2026-10-12 05:36:35','2026-10-12 05:37:29'),(10,2,3,'2026-10-12',NULL,'urgencia',NULL,25.00,'entregado',12.50,12.50,'2026-10-12 08:21:47','2026-10-12 08:22:04'),(11,5,5,'2026-10-13',NULL,'Mantenimiento general',NULL,150.00,'entregado',75.00,75.00,'2026-10-13 15:48:03','2026-10-13 15:49:16'),(12,2,4,'2026-10-13',NULL,'Su carburador se encuentra sucio',NULL,25.00,'entregado',12.50,12.50,'2026-10-13 17:30:23','2026-10-13 17:30:48'),(13,5,3,'2026-10-13',NULL,'Estaba muy quemado y rerqueria cambiar',NULL,15.00,'entregado',7.50,7.50,'2026-10-13 21:10:24','2026-10-13 21:10:44'),(15,3,4,'2026-10-15',NULL,'Requiere un cambio lo mas ante posible',NULL,25.00,'pendiente',12.50,12.50,'2026-10-15 22:52:13','2026-10-15 22:52:13');
/*!40000 ALTER TABLE `ordenes_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamos_herramientas`
--

DROP TABLE IF EXISTS `prestamos_herramientas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamos_herramientas` (
  `id_prestamo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_orden_servicio` bigint(20) unsigned NOT NULL,
  `id_herramienta` bigint(20) unsigned NOT NULL,
  `id_empleado` bigint(20) unsigned NOT NULL,
  `fecha_prestamo` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_devolucion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_prestamo`),
  KEY `prestamos_herramientas_id_orden_servicio_foreign` (`id_orden_servicio`),
  KEY `prestamos_herramientas_id_herramienta_foreign` (`id_herramienta`),
  KEY `prestamos_herramientas_id_empleado_foreign` (`id_empleado`),
  CONSTRAINT `prestamos_herramientas_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  CONSTRAINT `prestamos_herramientas_id_herramienta_foreign` FOREIGN KEY (`id_herramienta`) REFERENCES `herramientas` (`id_herramienta`),
  CONSTRAINT `prestamos_herramientas_id_orden_servicio_foreign` FOREIGN KEY (`id_orden_servicio`) REFERENCES `ordenes_servicio` (`id_orden_servicio`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamos_herramientas`
--

LOCK TABLES `prestamos_herramientas` WRITE;
/*!40000 ALTER TABLE `prestamos_herramientas` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestamos_herramientas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicios` (
  `id_servicio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(150) NOT NULL,
  `precio_mano_obra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,'mantenimiento general',150.00,'2026-09-23 16:11:34','2026-09-23 16:11:34'),(2,'Limpieza de carburador',25.00,'2026-09-23 16:12:17','2026-09-23 16:12:17'),(3,'cambio de aceite',15.00,'2026-09-23 16:13:57','2026-09-23 16:13:57'),(5,'Mantenimiento electrico',40.00,'2026-10-13 23:57:10','2026-10-13 23:57:10'),(6,'Cambo de balbula',120.00,'2026-10-15 18:48:10','2026-10-15 18:48:10'),(7,'Cambo de balbula',120.00,'2026-10-15 18:48:10','2026-10-15 18:48:10');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios_portada`
--

DROP TABLE IF EXISTS `servicios_portada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicios_portada` (
  `id_servicio_portada` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `estado` enum('visible','oculto') NOT NULL DEFAULT 'visible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_servicio_portada`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios_portada`
--

LOCK TABLES `servicios_portada` WRITE;
/*!40000 ALTER TABLE `servicios_portada` DISABLE KEYS */;
INSERT INTO `servicios_portada` VALUES (1,'Mantenimiento Preventivo','* Cambio de aceite',NULL,NULL,0,'visible','2026-10-14 22:32:37','2026-10-14 23:15:23'),(2,'Mantenimiento Preventivo','* Limpieza de carburador',NULL,NULL,0,'visible','2026-10-14 23:15:56','2026-10-14 23:15:56'),(3,'Mantenimiento Preventivo','* Calibración de válvula',NULL,NULL,0,'visible','2026-10-14 23:16:19','2026-10-14 23:16:19');
/*!40000 ALTER TABLE `servicios_portada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('15BXXIxbxl94RHHVh2W2D0zFDpHwAVBfpFygkLUu',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJIZjltQ0dtRDZYbG11QTFGYjNXTUJyam1KR2RpckFHSGhZMHh2VVpkIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL29yZGVuZXNcL2NyZWF0ZSJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=',1792096065),('2EqdSzoWdV39gEnngrp8IH5dX9WBCtDLSGwmcrlV',2,'192.168.1.6','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36','eyJfdG9rZW4iOiJvOVloYnM5RVU5bDd2UU11YVdHQTRCS216dTZBYUZKa2NZU3RYZW9FIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMS43OjgwODBcL2NsaWVudGVzIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9',1792094306);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('propietario','operario','tecnico') NOT NULL DEFAULT 'operario',
  `id_empleado` bigint(20) unsigned DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_id_empleado_foreign` (`id_empleado`),
  CONSTRAINT `users_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jaime Noco','jaime.noco@cirujano.local','2026-09-17 17:06:53','$2y$12$vPlHHGn/hS008UP3W9IDnuSEZJpOGSzwHF/i47vVHu3Pf63M7Rz0u','propietario',1,'w89m14s7JwnvWOmQUdDnh5b2Ne1OjYfMvuR919abiQjjjWX9kWvbkhpnyYWI','2026-09-17 17:06:53','2026-09-17 17:06:53'),(2,'Operario Familiar','operario@cirujano.local','2026-09-17 17:06:53','$2y$12$j.Jh0azpICTuzzBCn8MnPuGNhmOYNcEAaG4BTcv3v/xuxEbRUeYCC','operario',2,'weI4IXXU96qROHuIEswNsOBi0HvB4vCvWIGg1DvqV1VYy4pu5CXthYCBl7Iw','2026-09-17 17:06:53','2026-09-17 17:06:53'),(3,'Jesus Mae','jesus.mae@cirujano.local','2026-09-17 17:06:53','$2y$12$CL5skWEU0F.GFkgVNRfKo.PYvhMoipj0f4CGQyLS/0.GBE7bEb3/S','tecnico',3,NULL,'2026-09-17 17:06:53','2026-09-17 17:06:53'),(4,'Daniel Tamo','daniel.tamo@cirujano.local','2026-09-17 17:06:53','$2y$12$cYaYWx5hREjOq6Q6GU0fquaaXte.SA1ahFj61uK/jHKUmP9vlSW3m','tecnico',4,NULL,'2026-09-17 17:06:53','2026-09-17 17:06:53'),(5,'Ceferino Noe','ceferino.noe@cirujano.local','2026-09-17 17:06:54','$2y$12$Z9lZ6XOqI9mofpCZksbSneZcvCtf/Re0iB.RxTl2heORDf/PAmJa.','tecnico',5,NULL,'2026-09-17 17:06:54','2026-09-17 17:06:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-15 17:15:25
