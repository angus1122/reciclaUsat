-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: recicla_usat
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brandmodels`
--

DROP TABLE IF EXISTS `brandmodels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brandmodels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `brand_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brandmodels_brand_id_foreign` (`brand_id`),
  CONSTRAINT `brandmodels_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brandmodels`
--

LOCK TABLES `brandmodels` WRITE;
/*!40000 ALTER TABLE `brandmodels` DISABLE KEYS */;
INSERT INTO `brandmodels` VALUES (1,'Toyota Corolla',NULL,NULL,1,'2024-11-29 12:42:03','2024-11-29 12:42:03'),(2,'Toyota Camry',NULL,NULL,1,'2024-11-29 12:42:12','2024-11-29 12:42:12'),(3,'Toyota Hilux',NULL,NULL,1,'2024-11-29 12:42:22','2024-11-29 12:42:22'),(4,'Nissan Altima',NULL,NULL,3,'2024-11-29 12:42:36','2024-11-29 12:42:36'),(5,'Nissan Sentra',NULL,NULL,3,'2024-11-29 12:43:05','2024-11-29 12:43:05'),(6,'Nissan Pathfinder',NULL,NULL,3,'2024-11-29 12:43:20','2024-11-29 12:43:20'),(7,'Ford Focus',NULL,NULL,2,'2024-11-29 12:43:38','2024-11-29 12:43:38'),(8,'Ford Mustang',NULL,NULL,2,'2024-11-29 12:43:51','2024-11-29 12:43:51'),(9,'Ford F-150',NULL,NULL,2,'2024-11-29 12:44:04','2024-11-29 12:44:04'),(10,'Mitsubishi Outlander',NULL,NULL,4,'2024-11-29 12:44:21','2024-11-29 12:44:21'),(11,'Mitsubishi Lancer',NULL,NULL,4,'2024-11-29 12:44:34','2024-11-29 12:44:34'),(12,'Mitsubishi Eclipse Cross',NULL,NULL,4,'2024-11-29 12:44:50','2024-11-29 12:44:50');
/*!40000 ALTER TABLE `brandmodels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'TOYOTA','TOYOTA','/storage/brand_logo/Fb0sefkctLUe7XS8qz8ByChbL2aQ2q2LsH3HAg2I.png','2024-11-29 12:38:49','2024-11-29 12:39:01'),(2,'FORD','FORD','/storage/brand_logo/v3iuoKfKd7JIquQfYbKLYoY8rM87p1D2FzMxDTBm.png','2024-11-29 12:39:21','2024-11-29 12:39:21'),(3,'NISSAN','NISSAN','/storage/brand_logo/rO1ZaITR7J2fJ62gFdD49sf19GAXFYCEKsnUudL3.png','2024-11-29 12:39:44','2024-11-29 12:39:44'),(4,'MITSUBISHI','MITSUBISHI','/storage/brand_logo/kDEhkzdCaTuMW33EsbYUqCf68NIUM6Q8B9sGBqOs.jpg','2024-11-29 12:40:06','2024-11-29 12:40:06');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'LAMBAYEQUE','10001','2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `province_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_department_id_foreign` (`department_id`),
  KEY `districts_province_id_foreign` (`province_id`),
  CONSTRAINT `districts_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `districts_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (1,'CHICLAYO','14001',1,1,'2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintenances`
--

DROP TABLE IF EXISTS `maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `startdate` date NOT NULL,
  `lastdate` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenances`
--

LOCK TABLES `maintenances` WRITE;
/*!40000 ALTER TABLE `maintenances` DISABLE KEYS */;
INSERT INTO `maintenances` VALUES (1,'MANT. DICIEMBRE 2024','2024-12-01','2024-12-31',NULL,'2024-11-29 13:39:32','2024-11-29 13:39:32'),(2,'MANT. ENERO 2025','2025-01-01','2025-01-31',NULL,'2024-11-29 13:40:06','2024-11-29 13:40:06');
/*!40000 ALTER TABLE `maintenances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintenanceschedules`
--

DROP TABLE IF EXISTS `maintenanceschedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenanceschedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `maintenance_id` bigint(20) unsigned NOT NULL,
  `vehicle_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `maintenancetype_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintenanceschedules_maintenance_id_foreign` (`maintenance_id`),
  KEY `maintenanceschedules_vehicle_id_foreign` (`vehicle_id`),
  KEY `maintenanceschedules_user_id_foreign` (`user_id`),
  KEY `maintenanceschedules_maintenancetype_id_foreign` (`maintenancetype_id`),
  CONSTRAINT `maintenanceschedules_maintenance_id_foreign` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenances` (`id`),
  CONSTRAINT `maintenanceschedules_maintenancetype_id_foreign` FOREIGN KEY (`maintenancetype_id`) REFERENCES `maintenancetypes` (`id`),
  CONSTRAINT `maintenanceschedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `maintenanceschedules_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenanceschedules`
--

LOCK TABLES `maintenanceschedules` WRITE;
/*!40000 ALTER TABLE `maintenanceschedules` DISABLE KEYS */;
INSERT INTO `maintenanceschedules` VALUES (2,'Lunes','11:00:00','13:00:00',1,2,8,1,'2024-11-29 13:45:18','2024-11-29 13:45:18'),(3,'Lunes','08:00:00','11:00:00',1,1,7,1,'2024-11-29 13:47:18','2024-11-29 13:47:18');
/*!40000 ALTER TABLE `maintenanceschedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintenancestatus`
--

DROP TABLE IF EXISTS `maintenancestatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenancestatus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenancestatus`
--

LOCK TABLES `maintenancestatus` WRITE;
/*!40000 ALTER TABLE `maintenancestatus` DISABLE KEYS */;
INSERT INTO `maintenancestatus` VALUES (1,'Iniciado',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(2,'Finalizado',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `maintenancestatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintenancetypes`
--

DROP TABLE IF EXISTS `maintenancetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenancetypes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenancetypes`
--

LOCK TABLES `maintenancetypes` WRITE;
/*!40000 ALTER TABLE `maintenancetypes` DISABLE KEYS */;
INSERT INTO `maintenancetypes` VALUES (1,'Limpieza',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(2,'Reparación',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `maintenancetypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2012_10_31_003627_create_departments_table',1),(2,'2012_10_31_003651_create_provinces_table',1),(3,'2012_10_31_003714_create_districts_table',1),(4,'2013_10_31_003754_create_sectors_table',1),(5,'2013_10_31_003802_create_zones_table',1),(6,'2013_10_31_013935_create_usertypes_table',1),(7,'2014_10_12_000000_create_users_table',1),(8,'2014_10_12_100000_create_password_reset_tokens_table',1),(9,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(10,'2019_08_19_000000_create_failed_jobs_table',1),(11,'2019_12_14_000001_create_personal_access_tokens_table',1),(12,'2024_09_28_003930_create_sessions_table',1),(13,'2024_09_28_014520_create_brands_table',1),(14,'2024_10_05_015437_create_brandmodels_table',1),(15,'2024_10_19_025011_create_vehicletypes_table',1),(16,'2024_10_19_025022_create_vehiclecolors_table',1),(17,'2024_10_24_003025_create_vehicles_table',1),(18,'2024_10_26_003617_create_vehicleimages_table',1),(19,'2024_10_31_003821_create_zonecoords_table',1),(20,'2024_10_31_012000_create_schedules_table',1),(21,'2024_10_31_012054_create_routes_table',1),(22,'2024_10_31_012105_create_routezones_table',1),(23,'2024_10_31_012125_create_routestatus_table',1),(24,'2024_10_31_012145_create_vehicleroutes_table',1),(25,'2024_10_31_012657_create_routepaths_table',1),(26,'2024_10_31_014411_create_vehicleocuppants_table',1),(27,'2024_11_25_201823_create_maintenancetypes_table',1),(28,'2024_11_25_201851_create_maintenancestatus_table',1),(29,'2024_11_25_201935_create_maintenances_table',1),(30,'2024_11_25_220137_create_maintenanceschedules_table',1),(31,'2024_11_26_231017_create_schedulesdates_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provinces` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinces_department_id_foreign` (`department_id`),
  CONSTRAINT `provinces_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provinces`
--

LOCK TABLES `provinces` WRITE;
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;
INSERT INTO `provinces` VALUES (1,'CHICLAYO','14001',1,'2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routepaths`
--

DROP TABLE IF EXISTS `routepaths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `routepaths` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `vehicleroute_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `routepaths_vehicleroute_id_foreign` (`vehicleroute_id`),
  CONSTRAINT `routepaths_vehicleroute_id_foreign` FOREIGN KEY (`vehicleroute_id`) REFERENCES `vehicleroutes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routepaths`
--

LOCK TABLES `routepaths` WRITE;
/*!40000 ALTER TABLE `routepaths` DISABLE KEYS */;
/*!40000 ALTER TABLE `routepaths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `routes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `latitud_start` double NOT NULL,
  `latitude_end` double NOT NULL,
  `longitude_start` double NOT NULL,
  `longitude_end` double NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routes`
--

LOCK TABLES `routes` WRITE;
/*!40000 ALTER TABLE `routes` DISABLE KEYS */;
/*!40000 ALTER TABLE `routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routestatus`
--

DROP TABLE IF EXISTS `routestatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `routestatus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routestatus`
--

LOCK TABLES `routestatus` WRITE;
/*!40000 ALTER TABLE `routestatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `routestatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routezones`
--

DROP TABLE IF EXISTS `routezones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `routezones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `route_id` bigint(20) unsigned NOT NULL,
  `zone_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `routezones_route_id_foreign` (`route_id`),
  KEY `routezones_zone_id_foreign` (`zone_id`),
  CONSTRAINT `routezones_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`),
  CONSTRAINT `routezones_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routezones`
--

LOCK TABLES `routezones` WRITE;
/*!40000 ALTER TABLE `routezones` DISABLE KEYS */;
/*!40000 ALTER TABLE `routezones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedulesdates`
--

DROP TABLE IF EXISTS `schedulesdates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedulesdates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `maintenanceschedules_id` bigint(20) unsigned NOT NULL,
  `maintenances_id` bigint(20) unsigned NOT NULL,
  `maintenancestatus_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedulesdates_maintenanceschedules_id_foreign` (`maintenanceschedules_id`),
  KEY `schedulesdates_maintenances_id_foreign` (`maintenances_id`),
  KEY `schedulesdates_maintenancestatus_id_foreign` (`maintenancestatus_id`),
  CONSTRAINT `schedulesdates_maintenances_id_foreign` FOREIGN KEY (`maintenances_id`) REFERENCES `maintenances` (`id`),
  CONSTRAINT `schedulesdates_maintenanceschedules_id_foreign` FOREIGN KEY (`maintenanceschedules_id`) REFERENCES `maintenanceschedules` (`id`),
  CONSTRAINT `schedulesdates_maintenancestatus_id_foreign` FOREIGN KEY (`maintenancestatus_id`) REFERENCES `maintenancestatus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedulesdates`
--

LOCK TABLES `schedulesdates` WRITE;
/*!40000 ALTER TABLE `schedulesdates` DISABLE KEYS */;
INSERT INTO `schedulesdates` VALUES (1,'2024-12-02',NULL,3,1,1,'2024-11-29 13:48:45','2024-11-29 13:48:45'),(2,'2024-12-09',NULL,3,1,1,'2024-11-29 13:49:08','2024-11-29 13:49:08');
/*!40000 ALTER TABLE `schedulesdates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sectors`
--

DROP TABLE IF EXISTS `sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sectors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `area` double DEFAULT NULL,
  `description` text DEFAULT NULL,
  `district_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sectors_district_id_foreign` (`district_id`),
  CONSTRAINT `sectors_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sectors`
--

LOCK TABLES `sectors` WRITE;
/*!40000 ALTER TABLE `sectors` DISABLE KEYS */;
INSERT INTO `sectors` VALUES (1,'Sector 01',100,NULL,1,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(2,'Sector 02',100,NULL,1,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(3,'Sector 03',100,NULL,1,'2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `sectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
INSERT INTO `sessions` VALUES ('qmrgV46qL3vXhIaMzp8FD514Q1fiexTkt6SPOPwM',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSXRaR2Y3TDFYNndlR3p4d3l4QzBZeWFUdmswc1VqeDhnTlEwa1pTUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9icmFuZHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJE1ieDl2Q1ZRUFkuOC50S3B6V2suL08xOTM4S21lbzhyV0VJMzNTSC8zV0x3OEUuZXRLSC5DIjt9',1732894016);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `license` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `usertype_id` bigint(20) unsigned DEFAULT NULL,
  `zone_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_usertype_id_foreign` (`usertype_id`),
  KEY `users_zone_id_foreign` (`zone_id`),
  CONSTRAINT `users_usertype_id_foreign` FOREIGN KEY (`usertype_id`) REFERENCES `usertypes` (`id`),
  CONSTRAINT `users_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Angela Yanixa Guzmán Huamán','74961945','2000-11-22',NULL,'Paul Harris 751','guzmanangela408@gmail.com',NULL,'$2y$12$Mbx9vCVQPY.8.tKpzWk./O1938Kmeo8rWEI33SH/3WLw8E.etKH.C',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,'2024-11-29 04:12:15','2024-11-29 13:13:29'),(2,'Luis Alberto Chávez Ramos','72584316','1979-07-11',NULL,'Calle Los Jardines 452, Chiclayo, Perú','lchavez.ramos@gmail.com',NULL,'$2y$12$UbmImD5hTP1.hT00U2K3muPbupwSoHEJN9LtFTnxI8aU121/X9QFy',NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,'2024-11-29 13:01:40','2024-11-29 13:01:56'),(3,'Miguel Ángel Fernández Cárdenas','84152763','1988-10-05',NULL,'Av. Las Palmeras 123, Chiclayo, Perú','mfernandez.cardenas@hotmail.com',NULL,'$2y$12$4lA0VJicMuOaA/snnXS7o..EyCcBq5bVE6pU/hmpUfhsAk00AZG.u',NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,'2024-11-29 13:04:03','2024-11-29 13:04:03'),(4,'Juan Carlos Pérez Villanueva','70345682','1979-08-08',NULL,'Jr. Amazonas 345, Chiclayo, Perú','juancarlos.pv@gmail.com',NULL,'$2y$12$Xnsaapz8goFyEIZ1IbrfqOIWjOE9a0CFvMt3sYQqRNFVDDhJh9LN.',NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,'2024-11-29 13:05:50','2024-11-29 13:05:50'),(5,'Eduardo Javier Torres Delgado','78451236','1990-05-31',NULL,'Urb. Los Pinos Mz. C Lt. 15, Chiclayo, Perú','eduardo.tdelgado@yahoo.com',NULL,'$2y$12$Bm0gy9g3oWLAoDFe/DDA0urVi8Z2YBe.zTb3H11WP3ls3ksUVlMQ.',NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,'2024-11-29 13:08:10','2024-11-29 13:08:10'),(6,'Andrés Felipe Castillo Gómez','75623148','1987-10-15',NULL,'Pasaje El Sol 567, Chiclayo, Perú','afcastillo.gomez@gmail.com',NULL,'$2y$12$glJsizLJWmR/JaOVtxgGPu97EPVW6klkh2dRUYgQf8tztfCSmaPKS',NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,'2024-11-29 13:09:23','2024-11-29 13:09:23'),(7,'Diego Armando Salazar Mendoza','70584129','1987-09-02','D12859674','Av. El Bosque 214, Chiclayo, Perú','diego.salazar.mendoza@gmail.com',NULL,'$2y$12$gPIbeAMyHLjeCPQj885lXOd8RwFL31/akDv/XEh.G8Pm8sdZuKtzG',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,'2024-11-29 13:10:53','2024-11-29 13:10:53'),(8,'José Ignacio Rojas Paredes','71254836','1989-01-19','D13984567','Calle Los Álamos 678, Chiclayo, Perú','jrojas.paredes@hotmail.com',NULL,'$2y$12$2kLTRdIhMTYBB7scZlO.5OegcgezWQprcERNOpFbpCRiFI1B.Beqa',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,'2024-11-29 13:12:47','2024-11-29 13:12:47');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertypes`
--

DROP TABLE IF EXISTS `usertypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertypes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertypes`
--

LOCK TABLES `usertypes` WRITE;
/*!40000 ALTER TABLE `usertypes` DISABLE KEYS */;
INSERT INTO `usertypes` VALUES (1,'Administrador',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(2,'Conductor',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(3,'Recolector',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(4,'Ciudadano',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08');
/*!40000 ALTER TABLE `usertypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiclecolors`
--

DROP TABLE IF EXISTS `vehiclecolors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiclecolors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `color_code` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiclecolors`
--

LOCK TABLES `vehiclecolors` WRITE;
/*!40000 ALTER TABLE `vehiclecolors` DISABLE KEYS */;
INSERT INTO `vehiclecolors` VALUES (1,'Blanco','#ffffff','2024-11-29 12:50:24','2024-11-29 12:50:24'),(2,'Negro','#000000','2024-11-29 12:50:42','2024-11-29 12:50:42'),(3,'Verde','#0b752b','2024-11-29 12:51:20','2024-11-29 12:51:20');
/*!40000 ALTER TABLE `vehiclecolors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicleimages`
--

DROP TABLE IF EXISTS `vehicleimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicleimages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `profile` int(11) NOT NULL,
  `vehicle_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicleimages_vehicle_id_foreign` (`vehicle_id`),
  CONSTRAINT `vehicleimages_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicleimages`
--

LOCK TABLES `vehicleimages` WRITE;
/*!40000 ALTER TABLE `vehicleimages` DISABLE KEYS */;
INSERT INTO `vehicleimages` VALUES (1,'/storage/vehicles_images/1/fibRs4li5SvuTChsQzoh3tbPCwn1j0gMzDSzIuph.png',1,1,'2024-11-29 12:53:32','2024-11-29 12:53:32'),(2,'/storage/vehicles_images/2/sKkcx7dPoyq6t3twlyqgag46jR8DyECW2Tg2GguB.avif',1,2,'2024-11-29 12:54:41','2024-11-29 12:54:41');
/*!40000 ALTER TABLE `vehicleimages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicleocuppants`
--

DROP TABLE IF EXISTS `vehicleocuppants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicleocuppants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `vehicle_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `usertype_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicleocuppants_vehicle_id_foreign` (`vehicle_id`),
  KEY `vehicleocuppants_user_id_foreign` (`user_id`),
  KEY `vehicleocuppants_usertype_id_foreign` (`usertype_id`),
  CONSTRAINT `vehicleocuppants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `vehicleocuppants_usertype_id_foreign` FOREIGN KEY (`usertype_id`) REFERENCES `usertypes` (`id`),
  CONSTRAINT `vehicleocuppants_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicleocuppants`
--

LOCK TABLES `vehicleocuppants` WRITE;
/*!40000 ALTER TABLE `vehicleocuppants` DISABLE KEYS */;
INSERT INTO `vehicleocuppants` VALUES (1,1,1,7,2,'2024-11-29 13:33:15','2024-11-29 13:33:15'),(2,1,1,6,3,'2024-11-29 13:33:34','2024-11-29 13:33:34'),(3,1,2,8,2,'2024-11-29 13:34:44','2024-11-29 13:34:44'),(4,1,2,5,3,'2024-11-29 13:35:11','2024-11-29 13:35:11');
/*!40000 ALTER TABLE `vehicleocuppants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicleroutes`
--

DROP TABLE IF EXISTS `vehicleroutes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicleroutes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_route` date NOT NULL,
  `time_route` time NOT NULL,
  `description` text DEFAULT NULL,
  `vehicle_id` bigint(20) unsigned NOT NULL,
  `route_id` bigint(20) unsigned NOT NULL,
  `schedule_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicleroutes_vehicle_id_foreign` (`vehicle_id`),
  KEY `vehicleroutes_route_id_foreign` (`route_id`),
  KEY `vehicleroutes_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `vehicleroutes_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`),
  CONSTRAINT `vehicleroutes_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`),
  CONSTRAINT `vehicleroutes_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicleroutes`
--

LOCK TABLES `vehicleroutes` WRITE;
/*!40000 ALTER TABLE `vehicleroutes` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicleroutes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `plate` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `occupant_capacity` int(11) NOT NULL,
  `load_capacity` double NOT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `brand_id` bigint(20) unsigned NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  `color_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicles_brand_id_foreign` (`brand_id`),
  KEY `vehicles_model_id_foreign` (`model_id`),
  KEY `vehicles_type_id_foreign` (`type_id`),
  KEY `vehicles_color_id_foreign` (`color_id`),
  CONSTRAINT `vehicles_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `vehicles_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `vehiclecolors` (`id`),
  CONSTRAINT `vehicles_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `brandmodels` (`id`),
  CONSTRAINT `vehicles_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `vehicletypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'VEHÍCULO 001','001','VBA-650','2010',2,15000,NULL,1,2,8,4,3,'2024-11-29 12:53:32','2024-11-29 13:36:53'),(2,'VEHÍCULO 002','002','A1A-600','2005',2,15000,NULL,1,1,2,2,1,'2024-11-29 12:54:41','2024-11-29 12:54:41');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicletypes`
--

DROP TABLE IF EXISTS `vehicletypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicletypes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicletypes`
--

LOCK TABLES `vehicletypes` WRITE;
/*!40000 ALTER TABLE `vehicletypes` DISABLE KEYS */;
INSERT INTO `vehicletypes` VALUES (1,'Carga lateral',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(2,'Carga trasera',NULL,'2024-11-29 04:11:08','2024-11-29 04:11:08'),(4,'Compactador',NULL,'2024-11-29 12:46:44','2024-11-29 12:46:44');
/*!40000 ALTER TABLE `vehicletypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zonecoords`
--

DROP TABLE IF EXISTS `zonecoords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zonecoords` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `zone_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zonecoords_zone_id_foreign` (`zone_id`),
  CONSTRAINT `zonecoords_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zonecoords`
--

LOCK TABLES `zonecoords` WRITE;
/*!40000 ALTER TABLE `zonecoords` DISABLE KEYS */;
/*!40000 ALTER TABLE `zonecoords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `area` double DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sector_id` bigint(20) unsigned NOT NULL,
  `district_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zones_sector_id_foreign` (`sector_id`),
  KEY `zones_district_id_foreign` (`district_id`),
  CONSTRAINT `zones_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  CONSTRAINT `zones_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'recicla_usat'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_assignmenthistorical` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_assignmenthistorical`(IN _operacion INT)
begin
	IF _operacion = 1 THEN
		SELECT v.id, u.name AS uname, u2.name AS utname,
		CASE 
			WHEN v.status = 1 THEN 'Activo'
			ELSE 'Inactivo' 
		END AS status, v2.name AS vname, v.created_at 
		FROM vehicleocuppants v INNER JOIN vehicles v2 ON v.vehicle_id = v2.id
		INNER JOIN users u ON v.user_id = u.id
		INNER JOIN usertypes u2 ON v.usertype_id = u2.id;
	END IF;

	IF _operacion = 2 THEN
		SELECT v.id, u.name AS uname, u2.name AS utname,
		CASE 
			WHEN v.status = 1 THEN 'Activo'
			ELSE 'Inactivo' 
		END AS status, v2.name AS vname, v.created_at
		FROM vehicleocuppants v INNER JOIN vehicles v2 ON v.vehicle_id = v2.id
		INNER JOIN users u ON v.user_id = u.id
		INNER JOIN usertypes u2 ON v.usertype_id = u2.id
		where v.status = 1;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_dates` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dates`(IN _id BIGINT)
begin
	select s.id as id, s.`date` as date, s.description as description, m3.name as status
	from schedulesdates s inner join maintenanceschedules m on s.maintenanceschedules_id = m.id
	inner join maintenances m2 on s.maintenances_id = m2.id 
	inner join maintenancestatus m3 on s.maintenancestatus_id = m3.id 
	where m.id = _id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_schedules` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_schedules`(IN _operacion INT, IN _id BIGINT)
begin
	IF _operacion = 1 THEN
		select m.id, m.name as name, v.name as vehiclenames, u.name as usernames, m3.name as maintenancetypes, 
        m.time_start as time_start, m.time_end as time_end
        from maintenanceschedules m inner join maintenances m2 on m.maintenance_id = m2.id
        inner join vehicles v on m.vehicle_id = v.id 
        inner join users u on m.user_id = u.id 
        inner join maintenancetypes m3 on m.maintenancetype_id = m3.id
        where m2.id = _id;
    END IF;
   
   IF _operacion = 2 then
   		select m.id as id, m.name as name, m.time_start as time_start, m.time_end as time_end,
	   	m2.id as maintenance_id, m2.name as mname, m2.startdate as startdate, m2.lastdate as lastdate, m3.name as tname
	   	from maintenanceschedules m inner join maintenances m2 on m.maintenance_id = m2.id 
	   	inner join vehicles v on m.vehicle_id = v.id 
	   	inner join users u on m.user_id = u.id 
	   	inner join maintenancetypes m3 on m.maintenancetype_id = m3.id 
	   	where m.id = _id;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_users` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users`()
begin
	SELECT u.id as id, u.name as name, u.dni as dni,
	u.license as license, u.email as email, u2.name AS tname
	FROM users u LEFT JOIN usertypes u2 ON u.usertype_id = u2.id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_vehicles` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_vehicles`(IN _operacion INT, IN _id BIGINT)
begin
	IF _operacion = 1 THEN
		select v.id,v3.image as logo, v.name as name, b.name as brand, b2.name as model, 
		v2.name as vtype, v.plate as plate, v.status as status  
		from vehicles v 
		inner join brands b on v.brand_id = b.id 
		inner join brandmodels b2 on v.model_id = b2.id 
		inner join vehicletypes v2 on v.type_id = v2.id 
		left join vehicleimages v3 on (v.id = v3.vehicle_id and v3.profile=1);
	END IF;

	IF _operacion = 2 then
		select v.id, v.name as name, v.plate as plate, b.name as brand, b2.name as model,
		v2.name as vtype, v.occupant_capacity, v.load_capacity, v.status as status
		from vehicles v
		inner join brands b on v.brand_id = b.id 
		inner join brandmodels b2 on v.model_id = b2.id
		inner join vehicletypes v2 on v.type_id = v2.id
		WHERE v.id = _id;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_zones` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_zones`(in _operacion int, in _id bigint)
begin
	IF _operacion = 1 THEN
        SELECT z.id AS id, z.name AS name, z.area AS area, s.name AS sector, z.description AS description 
        FROM zones z 
        INNER JOIN sectors s ON z.sector_id = s.id;
    END IF;

    IF _operacion = 2 THEN
        SELECT z.id AS id, z.name AS name, z.area AS area, s.name AS sector, z.description AS description 
        FROM zones z 
        INNER JOIN sectors s ON z.sector_id = s.id
        WHERE z.id = _id;
    END IF;

    IF _operacion = 3 THEN
        SELECT s.name AS name, z.name as zone, z2.latitude AS latitude, z2.longitude AS longitude
        FROM sectors s
        INNER JOIN zones z ON s.id = z.sector_id
        INNER JOIN zonecoords z2 ON z.id = z2.zone_id
        WHERE s.id = _id;
    END IF;
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

-- Dump completed on 2024-11-29 11:04:39
