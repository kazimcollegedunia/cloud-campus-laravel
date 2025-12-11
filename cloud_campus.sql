-- MySQL dump 10.13  Distrib 9.1.0, for macos12.7 (x86_64)
--
-- Host: localhost    Database: cloud_campus
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `address_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_employee_id_foreign` (`employee_id`),
  CONSTRAINT `addresses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','leave','half_day') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `att_unique_user_date` (`tenant_id`,`user_id`,`date`),
  KEY `attendances_user_id_foreign` (`user_id`),
  CONSTRAINT `attendances_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,1,2,'2025-12-01','present',NULL,NULL,NULL,NULL,'2025-12-10 09:05:38','2025-12-10 09:05:38'),(2,1,2,'2025-12-09','present',NULL,NULL,NULL,NULL,'2025-12-10 09:06:01','2025-12-10 09:06:01');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
-- Table structure for table `contact_numbers`
--

DROP TABLE IF EXISTS `contact_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_numbers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_numbers_employee_id_foreign` (`employee_id`),
  CONSTRAINT `contact_numbers_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_numbers`
--

LOCK TABLES `contact_numbers` WRITE;
/*!40000 ALTER TABLE `contact_numbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_numbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_department_id_foreign` (`department_id`),
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `fee_payments`
--

DROP TABLE IF EXISTS `fee_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fee_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `fee_id` bigint unsigned NOT NULL,
  `payment_mode` enum('cash','online','upi','bank','cheque') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'online',
  `amount_inr` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('success','failed','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_payments_fee_id_foreign` (`fee_id`),
  KEY `fee_payments_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `fee_payments_fee_id_foreign` FOREIGN KEY (`fee_id`) REFERENCES `fees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_payments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_payments`
--

LOCK TABLES `fee_payments` WRITE;
/*!40000 ALTER TABLE `fee_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_types`
--

DROP TABLE IF EXISTS `fee_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fee_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_inr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `frequency` enum('monthly','yearly','one_time','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `description` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_types_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `fee_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_types`
--

LOCK TABLES `fee_types` WRITE;
/*!40000 ALTER TABLE `fee_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `fee_type_id` bigint unsigned NOT NULL,
  `amount_inr` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','paid','partial','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `receipt_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fees_student_id_foreign` (`student_id`),
  KEY `fees_fee_type_id_foreign` (`fee_type_id`),
  KEY `fees_tenant_id_student_id_index` (`tenant_id`,`student_id`),
  CONSTRAINT `fees_fee_type_id_foreign` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_11_18_125231_create_departments_table',1),(4,'2025_11_18_125249_create_employees_table',1),(5,'2025_11_18_125254_create_contact_numbers_table',1),(6,'2025_11_18_125259_create_addresses_table',1),(7,'2025_12_05_160348_create_tenants_table',1),(8,'2025_12_05_160355_create_users_table',1),(9,'2025_12_05_160405_create_password_resets_table',1),(10,'2025_12_05_162708_create_oauth_auth_codes_table',1),(11,'2025_12_05_162709_create_oauth_access_tokens_table',1),(12,'2025_12_05_162710_create_oauth_refresh_tokens_table',1),(13,'2025_12_05_162711_create_oauth_clients_table',1),(14,'2025_12_05_162712_create_oauth_device_codes_table',1),(15,'2025_12_05_213303_create_system_logs_table',1),(16,'2025_12_06_151515_create_students_table',1),(17,'2025_12_07_131734_create_attendances_table',1),(18,'2025_12_09_133454_create_fee_types_table',1),(19,'2025_12_09_133507_create_fees_table',1),(20,'2025_12_09_133514_create_fee_payments_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_types` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_device_codes`
--

DROP TABLE IF EXISTS `oauth_device_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_device_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  KEY `oauth_device_codes_user_id_index` (`user_id`),
  KEY `oauth_device_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_device_codes`
--

LOCK TABLES `oauth_device_codes` WRITE;
/*!40000 ALTER TABLE `oauth_device_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_device_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `admission_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','passed_out','left') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_admission_no_unique` (`admission_no`),
  KEY `students_user_id_foreign` (`user_id`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,1,'707229',6,'A','2025-11-06','male','Surender Pardeep',NULL,'9012789657','near home by the  juanpur ,UP','active','2025-12-10 09:04:12','2025-12-10 09:04:12'),(2,2,'343243',2,'A','2025-09-06','male','khan bhai',NULL,'9819209180','mufti mohalla  juanpur ,UP','active','2025-12-10 09:05:09','2025-12-10 09:05:09'),(3,4,'758446',3,'B','2015-11-12','female','Rehan Siddiqui',NULL,'9876541230','Civil Lines, Allahabad, UP','active','2025-12-10 09:08:48','2025-12-10 09:08:48'),(4,5,'780245',4,'A','2014-03-23','male','Suresh Singh',NULL,'9098765432','Ashok Nagar, Varanasi, UP','active','2025-12-10 09:09:01','2025-12-10 09:09:01'),(5,6,'913252',1,'C','2017-07-19','female','Arun Gupta',NULL,'9123456789','Gandhi Nagar, Lucknow, UP','active','2025-12-10 09:09:16','2025-12-10 09:09:16'),(6,7,'943263',2,'B','2016-01-14','male','Haroon Arif',NULL,'9988776655','Nai Basti, Gorakhpur, UP','active','2025-12-10 09:09:36','2025-12-10 09:09:36'),(7,8,'152689',5,'A','2013-09-08','female','Rajesh Yadav',NULL,'8976453201','Yadav Colony, Kanpur, UP','active','2025-12-10 09:09:43','2025-12-10 09:09:43'),(8,9,'983612',3,'C','2015-05-27','male','Shakeel Alam',NULL,'9001122334','Purani Sabzi Mandi, Azamgarh, UP','active','2025-12-10 09:10:01','2025-12-10 09:10:01'),(9,10,'525382',4,'B','2014-12-02','female','Mahesh Sharma',NULL,'8123987450','Old Cantt, Meerut, UP','active','2025-12-10 09:10:06','2025-12-10 09:10:06'),(10,11,'941421',6,'A','2012-04-16','male','Qasim Qureshi',NULL,'8213456790','Chowk, Lucknow, UP','active','2025-12-10 09:10:20','2025-12-10 09:10:20'),(11,12,'437963',1,'A','2018-10-21','female','Ritika Verma',NULL,'9988012345','Rajendra Nagar, Bareilly, UP','active','2025-12-10 09:10:26','2025-12-10 09:10:26'),(12,13,'301109',2,'C','2016-02-03','male','Imran Sheikh',NULL,'9876001122','Sheikh Tola, Sultanpur, UP','active','2025-12-10 09:10:56','2025-12-10 09:10:56'),(13,14,'327366',5,'B','2013-06-10','female','Mahavir Pandey',NULL,'9090909080','Pandey Tola, Ballia, UP','active','2025-12-10 09:11:07','2025-12-10 09:11:07'),(14,15,'956345',4,'C','2014-08-05','male','Shahid Ahmad',NULL,'9012345678','Jama Masjid Area, Basti, UP','active','2025-12-10 09:11:19','2025-12-10 09:11:19'),(15,16,'579459',3,'A','2015-01-18','female','Kamal Saxena',NULL,'8800112233','Saxena Colony, Agra, UP','active','2025-12-10 09:11:29','2025-12-10 09:11:29'),(16,17,'348773',2,'B','2016-11-11','male','Shabbir Khan',NULL,'9123012301','Khan Market, Rampur, UP','active','2025-12-10 09:11:41','2025-12-10 09:11:41'),(17,18,'519137',1,'A','2018-03-20','female','Ramesh Jaiswal',NULL,'7894561230','Jaiswal Gali, Mirzapur, UP','active','2025-12-10 09:12:45','2025-12-10 09:12:45'),(18,19,'836802',6,'C','2012-09-09','male','Yasir Malik',NULL,'8901212121','Malik Nagar, Moradabad, UP','active','2025-12-10 09:12:56','2025-12-10 09:12:56'),(19,20,'909460',5,'A','2013-12-25','female','Devendra Chauhan',NULL,'8500112233','Chauhan Pur, Etawah, UP','active','2025-12-10 09:13:04','2025-12-10 09:13:04'),(20,21,'642928',4,'A','2014-04-07','male','Rahim Ansari',NULL,'9800223344','Ansari Mohalla, Mau, UP','active','2025-12-10 09:13:14','2025-12-10 09:13:14'),(21,22,'827373',3,'C','2015-07-30','female','Mukesh Mishra',NULL,'9123450099','Mishra Tola, Rewa, UP','active','2025-12-10 09:13:24','2025-12-10 09:13:24'),(22,23,'234611',2,'A','2016-10-12','male','Salim Khan',NULL,'7001234567','Khan Mohalla, Bahraich, UP','active','2025-12-10 09:13:31','2025-12-10 09:13:31'),(23,24,'513891',5,'b','2098-04-12','male','kazim papa',NULL,'9989809789','Delhi mohalla 17 no gali, Delhi, delhi','active','2025-12-10 09:14:33','2025-12-10 09:14:33');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_logs`
--

DROP TABLE IF EXISTS `system_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `request_data` json DEFAULT NULL,
  `response_data` json DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_logs`
--

LOCK TABLES `system_logs` WRITE;
/*!40000 ALTER TABLE `system_logs` DISABLE KEYS */;
INSERT INTO `system_logs` VALUES (1,NULL,'Student Creation','Student creation successful','{\"dob\": \"2025-11-06\", \"name\": \"manjob Kumar\", \"gender\": \"male\", \"address\": \"near home by the  juanpur ,UP\", \"section\": \"A\", \"class_id\": \"6\", \"parent_name\": \"Surender Pardeep\", \"admission_no\": \"1234\", \"parent_email\": \"Surender@gmail.com\", \"parent_phone\": \"9012789657\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:04:12','2025-12-10 09:04:12'),(2,NULL,'Student Creation','Student creation successful','{\"dob\": \"2025-09-06\", \"name\": \"intezar khan\", \"gender\": \"male\", \"address\": \"mufti mohalla  juanpur ,UP\", \"section\": \"A\", \"class_id\": \"2\", \"parent_name\": \"khan bhai\", \"admission_no\": \"121\", \"parent_email\": \"khanbhai@gmail.com\", \"parent_phone\": \"9819209180\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:05:09','2025-12-10 09:05:09'),(3,NULL,'Bulk Attendance','Bulk attendance updated','{\"date\": \"2025-12-01\", \"attendances\": [{\"status\": \"present\", \"remarks\": null, \"user_id\": 2}]}','[{\"id\": 1, \"date\": \"2025-12-01T00:00:00.000000Z\", \"status\": \"present\", \"in_time\": null, \"remarks\": null, \"user_id\": 2, \"out_time\": null, \"tenant_id\": 1, \"created_at\": \"2025-12-10T14:35:38.000000Z\", \"updated_at\": \"2025-12-10T14:35:38.000000Z\"}]','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','success','2025-12-10 09:05:38','2025-12-10 09:05:38'),(4,NULL,'Bulk Attendance','Bulk attendance updated','{\"date\": \"2025-12-09\", \"attendances\": [{\"status\": \"present\", \"remarks\": null, \"user_id\": 2}]}','[{\"id\": 2, \"date\": \"2025-12-09T00:00:00.000000Z\", \"status\": \"present\", \"in_time\": null, \"remarks\": null, \"user_id\": 2, \"out_time\": null, \"tenant_id\": 1, \"created_at\": \"2025-12-10T14:36:01.000000Z\", \"updated_at\": \"2025-12-10T14:36:01.000000Z\"}]','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','success','2025-12-10 09:06:01','2025-12-10 09:06:01'),(5,NULL,'Student Creation','SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'khanbhai@gmail.com\' for key \'users.users_email_unique\' (Connection: mysql, SQL: insert into `users` (`tenant_id`, `name`, `email`, `password`, `role`, `updated_at`, `created_at`) values (1, Intezar Khan, khanbhai@gmail.com, $2y$12$ol/2SllpS6XR9..wOoVMC.XDfr6QEa4obrhViUGK/NsR64Co8rtcK, student, 2025-12-10 14:38:15, 2025-12-10 14:38:15))','{\"dob\": \"2025-09-06\", \"name\": \"Intezar Khan\", \"gender\": \"male\", \"address\": \"Mufti Mohalla, Jaunpur, UP\", \"section\": \"A\", \"class_id\": \"2\", \"parent_name\": \"Khan Bhai\", \"admission_no\": \"121\", \"parent_email\": \"khanbhai@gmail.com\", \"parent_phone\": \"9819209180\"}','{\"error\": \"SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'khanbhai@gmail.com\' for key \'users.users_email_unique\' (Connection: mysql, SQL: insert into `users` (`tenant_id`, `name`, `email`, `password`, `role`, `updated_at`, `created_at`) values (1, Intezar Khan, khanbhai@gmail.com, $2y$12$ol/2SllpS6XR9..wOoVMC.XDfr6QEa4obrhViUGK/NsR64Co8rtcK, student, 2025-12-10 14:38:15, 2025-12-10 14:38:15))\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','fail','2025-12-10 09:08:15','2025-12-10 09:08:15'),(6,NULL,'Student Creation','Student creation successful','{\"dob\": \"2015-11-12\", \"name\": \"Ayesha Siddiqui\", \"gender\": \"female\", \"address\": \"Civil Lines, Allahabad, UP\", \"section\": \"B\", \"class_id\": \"3\", \"parent_name\": \"Rehan Siddiqui\", \"admission_no\": \"122\", \"parent_email\": \"rehan.s@gmail.com\", \"parent_phone\": \"9876541230\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:08:48','2025-12-10 09:08:48'),(7,NULL,'Student Creation','Student creation successful','{\"dob\": \"2014-03-23\", \"name\": \"Rohan Singh\", \"gender\": \"male\", \"address\": \"Ashok Nagar, Varanasi, UP\", \"section\": \"A\", \"class_id\": \"4\", \"parent_name\": \"Suresh Singh\", \"admission_no\": \"123\", \"parent_email\": \"suresh.singh@gmail.com\", \"parent_phone\": \"9098765432\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:09:01','2025-12-10 09:09:01'),(8,NULL,'Student Creation','Student creation successful','{\"dob\": \"2017-07-19\", \"name\": \"Simran Gupta\", \"gender\": \"female\", \"address\": \"Gandhi Nagar, Lucknow, UP\", \"section\": \"C\", \"class_id\": \"1\", \"parent_name\": \"Arun Gupta\", \"admission_no\": \"124\", \"parent_email\": \"arun.gupta@gmail.com\", \"parent_phone\": \"9123456789\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:09:16','2025-12-10 09:09:16'),(9,NULL,'Student Creation','Student creation successful','{\"dob\": \"2016-01-14\", \"name\": \"Mohammad Arif\", \"gender\": \"male\", \"address\": \"Nai Basti, Gorakhpur, UP\", \"section\": \"B\", \"class_id\": \"2\", \"parent_name\": \"Haroon Arif\", \"admission_no\": \"125\", \"parent_email\": \"haroon.arif@gmail.com\", \"parent_phone\": \"9988776655\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:09:36','2025-12-10 09:09:36'),(10,NULL,'Student Creation','Student creation successful','{\"dob\": \"2013-09-08\", \"name\": \"Neha Yadav\", \"gender\": \"female\", \"address\": \"Yadav Colony, Kanpur, UP\", \"section\": \"A\", \"class_id\": \"5\", \"parent_name\": \"Rajesh Yadav\", \"admission_no\": \"126\", \"parent_email\": \"rajesh.yadav@gmail.com\", \"parent_phone\": \"8976453201\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:09:43','2025-12-10 09:09:43'),(11,NULL,'Student Creation','Student creation successful','{\"dob\": \"2015-05-27\", \"name\": \"Sameer Alam\", \"gender\": \"male\", \"address\": \"Purani Sabzi Mandi, Azamgarh, UP\", \"section\": \"C\", \"class_id\": \"3\", \"parent_name\": \"Shakeel Alam\", \"admission_no\": \"127\", \"parent_email\": \"shakeel.alam@gmail.com\", \"parent_phone\": \"9001122334\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:10:01','2025-12-10 09:10:01'),(12,NULL,'Student Creation','Student creation successful','{\"dob\": \"2014-12-02\", \"name\": \"Ritika Sharma\", \"gender\": \"female\", \"address\": \"Old Cantt, Meerut, UP\", \"section\": \"B\", \"class_id\": \"4\", \"parent_name\": \"Mahesh Sharma\", \"admission_no\": \"128\", \"parent_email\": \"mahesh.sharma@gmail.com\", \"parent_phone\": \"8123987450\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:10:06','2025-12-10 09:10:06'),(13,NULL,'Student Creation','Student creation successful','{\"dob\": \"2012-04-16\", \"name\": \"Zeeshan Qureshi\", \"gender\": \"male\", \"address\": \"Chowk, Lucknow, UP\", \"section\": \"A\", \"class_id\": \"6\", \"parent_name\": \"Qasim Qureshi\", \"admission_no\": \"129\", \"parent_email\": \"qasim.q@gmail.com\", \"parent_phone\": \"8213456790\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:10:20','2025-12-10 09:10:20'),(14,NULL,'Student Creation','Student creation successful','{\"dob\": \"2018-10-21\", \"name\": \"Isha Verma\", \"gender\": \"female\", \"address\": \"Rajendra Nagar, Bareilly, UP\", \"section\": \"A\", \"class_id\": \"1\", \"parent_name\": \"Ritika Verma\", \"admission_no\": \"130\", \"parent_email\": \"ritika.v@gmail.com\", \"parent_phone\": \"9988012345\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:10:26','2025-12-10 09:10:26'),(15,NULL,'Student Creation','Student creation successful','{\"dob\": \"2016-02-03\", \"name\": \"Adnan Sheikh\", \"gender\": \"male\", \"address\": \"Sheikh Tola, Sultanpur, UP\", \"section\": \"C\", \"class_id\": \"2\", \"parent_name\": \"Imran Sheikh\", \"admission_no\": \"131\", \"parent_email\": \"imran.sheikh@gmail.com\", \"parent_phone\": \"9876001122\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:10:56','2025-12-10 09:10:56'),(16,NULL,'Student Creation','Student creation successful','{\"dob\": \"2013-06-10\", \"name\": \"Kavya Pandey\", \"gender\": \"female\", \"address\": \"Pandey Tola, Ballia, UP\", \"section\": \"B\", \"class_id\": \"5\", \"parent_name\": \"Mahavir Pandey\", \"admission_no\": \"132\", \"parent_email\": \"mahavir.p@gmail.com\", \"parent_phone\": \"9090909080\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:11:07','2025-12-10 09:11:07'),(17,NULL,'Student Creation','Student creation successful','{\"dob\": \"2014-08-05\", \"name\": \"Faizan Ahmad\", \"gender\": \"male\", \"address\": \"Jama Masjid Area, Basti, UP\", \"section\": \"C\", \"class_id\": \"4\", \"parent_name\": \"Shahid Ahmad\", \"admission_no\": \"133\", \"parent_email\": \"shahid.a@gmail.com\", \"parent_phone\": \"9012345678\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:11:19','2025-12-10 09:11:19'),(18,NULL,'Student Creation','Student creation successful','{\"dob\": \"2015-01-18\", \"name\": \"Priya Saxena\", \"gender\": \"female\", \"address\": \"Saxena Colony, Agra, UP\", \"section\": \"A\", \"class_id\": \"3\", \"parent_name\": \"Kamal Saxena\", \"admission_no\": \"134\", \"parent_email\": \"kamal.saxena@gmail.com\", \"parent_phone\": \"8800112233\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:11:29','2025-12-10 09:11:29'),(19,NULL,'Student Creation','Student creation successful','{\"dob\": \"2016-11-11\", \"name\": \"Imtiyaz Khan\", \"gender\": \"male\", \"address\": \"Khan Market, Rampur, UP\", \"section\": \"B\", \"class_id\": \"2\", \"parent_name\": \"Shabbir Khan\", \"admission_no\": \"135\", \"parent_email\": \"shabbir.khan@gmail.com\", \"parent_phone\": \"9123012301\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:11:41','2025-12-10 09:11:41'),(20,NULL,'Student Creation','Student creation successful','{\"dob\": \"2018-03-20\", \"name\": \"Anjali Jaiswal\", \"gender\": \"female\", \"address\": \"Jaiswal Gali, Mirzapur, UP\", \"section\": \"A\", \"class_id\": \"1\", \"parent_name\": \"Ramesh Jaiswal\", \"admission_no\": \"136\", \"parent_email\": \"ramesh.j@gmail.com\", \"parent_phone\": \"7894561230\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:12:45','2025-12-10 09:12:45'),(21,NULL,'Student Creation','Student creation successful','{\"dob\": \"2012-09-09\", \"name\": \"Rehan Malik\", \"gender\": \"male\", \"address\": \"Malik Nagar, Moradabad, UP\", \"section\": \"C\", \"class_id\": \"6\", \"parent_name\": \"Yasir Malik\", \"admission_no\": \"137\", \"parent_email\": \"yasir.m@gmail.com\", \"parent_phone\": \"8901212121\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:12:56','2025-12-10 09:12:56'),(22,NULL,'Student Creation','Student creation successful','{\"dob\": \"2013-12-25\", \"name\": \"Surbhi Chauhan\", \"gender\": \"female\", \"address\": \"Chauhan Pur, Etawah, UP\", \"section\": \"A\", \"class_id\": \"5\", \"parent_name\": \"Devendra Chauhan\", \"admission_no\": \"138\", \"parent_email\": \"devendra.c@gmail.com\", \"parent_phone\": \"8500112233\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:13:04','2025-12-10 09:13:04'),(23,NULL,'Student Creation','Student creation successful','{\"dob\": \"2014-04-07\", \"name\": \"Yusuf Ansari\", \"gender\": \"male\", \"address\": \"Ansari Mohalla, Mau, UP\", \"section\": \"A\", \"class_id\": \"4\", \"parent_name\": \"Rahim Ansari\", \"admission_no\": \"139\", \"parent_email\": \"rahim.a@gmail.com\", \"parent_phone\": \"9800223344\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:13:14','2025-12-10 09:13:14'),(24,NULL,'Student Creation','Student creation successful','{\"dob\": \"2015-07-30\", \"name\": \"Shivani Mishra\", \"gender\": \"female\", \"address\": \"Mishra Tola, Rewa, UP\", \"section\": \"C\", \"class_id\": \"3\", \"parent_name\": \"Mukesh Mishra\", \"admission_no\": \"140\", \"parent_email\": \"mukesh.m@gmail.com\", \"parent_phone\": \"9123450099\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:13:24','2025-12-10 09:13:24'),(25,NULL,'Student Creation','Student creation successful','{\"dob\": \"2016-10-12\", \"name\": \"Aadil Khan\", \"gender\": \"male\", \"address\": \"Khan Mohalla, Bahraich, UP\", \"section\": \"A\", \"class_id\": \"2\", \"parent_name\": \"Salim Khan\", \"admission_no\": \"141\", \"parent_email\": \"salim.khan@gmail.com\", \"parent_phone\": \"7001234567\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:13:31','2025-12-10 09:13:31'),(26,NULL,'Student Creation','Student creation successful','{\"dob\": \"2098-04-12\", \"name\": \"kazim\", \"gender\": \"male\", \"address\": \"Delhi mohalla 17 no gali, Delhi, delhi\", \"section\": \"b\", \"class_id\": \"5\", \"parent_name\": \"kazim papa\", \"admission_no\": \"141\", \"parent_email\": \"kazim papa@gmail.com\", \"parent_phone\": \"9989809789\"}','{\"message\": \"Student created successfully\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','success','2025-12-10 09:14:33','2025-12-10 09:14:33');
/*!40000 ALTER TABLE `system_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subdomain` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_connection` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mysql',
  `plan_id` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenants_subdomain_unique` (`subdomain`),
  KEY `tenants_subdomain_index` (`subdomain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'kazim convent school','kcs','kcs','kcs','kcs',2,'active',NULL,NULL);
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('super_admin','admin','teacher','student','parent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_tenant_id_email_index` (`tenant_id`,`email`),
  CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'manjob Kumar','Surender@gmail.com',NULL,'student','$2y$12$Tq.43h6LAFPeN1t1zntBr.NRsTQB5.UtO8cHOEPvie7wFg1vQVS9G','active','2025-12-10 09:04:12','2025-12-10 09:04:12'),(2,1,'intezar khan','khanbhai@gmail.com',NULL,'student','$2y$12$nOF.kQKZf1t/GjVpnXeTUeS3iIqWIkE7kXz5LxZm1CN4Q.FXxdTBK','active','2025-12-10 09:05:09','2025-12-10 09:05:09'),(4,1,'Ayesha Siddiqui','rehan.s@gmail.com',NULL,'student','$2y$12$U2ESbwJtBtWpGI6rv7iPh.9iSg.KMYudBw0CX1rPufulxiM.jgPZe','active','2025-12-10 09:08:48','2025-12-10 09:08:48'),(5,1,'Rohan Singh','suresh.singh@gmail.com',NULL,'student','$2y$12$2Elcg2s9358s4cOKBVh1oedTsYUfiJPaG4ifB3ZFk6JK2HfPjNlyC','active','2025-12-10 09:09:01','2025-12-10 09:09:01'),(6,1,'Simran Gupta','arun.gupta@gmail.com',NULL,'student','$2y$12$puwPVtoyTSv4FfcJjl1CHOAmMHPKRn97O5jTSjW7ml7.D7JFT06Ye','active','2025-12-10 09:09:16','2025-12-10 09:09:16'),(7,1,'Mohammad Arif','haroon.arif@gmail.com',NULL,'student','$2y$12$0aOAmNetUUNWsb7cko9TaOLdFFEei06MG6wPAHl66z3CVDsaKeKmy','active','2025-12-10 09:09:36','2025-12-10 09:09:36'),(8,1,'Neha Yadav','rajesh.yadav@gmail.com',NULL,'student','$2y$12$y6vAx1AUJsSoW/oCC.1kpu.7/Wpf4u/Lx3.hEn8XaaS/7cQgxE7mK','active','2025-12-10 09:09:43','2025-12-10 09:09:43'),(9,1,'Sameer Alam','shakeel.alam@gmail.com',NULL,'student','$2y$12$WH9R9t.HbjpjH7ajMiHzFO5TCYBYNLxWCCPyMqRJMDvlHf9CwSbka','active','2025-12-10 09:10:01','2025-12-10 09:10:01'),(10,1,'Ritika Sharma','mahesh.sharma@gmail.com',NULL,'student','$2y$12$s4k31YFpYre5Ob5FfeEJ/Odp8T2ZreoVF8mANDoIzeihiJr64v6w6','active','2025-12-10 09:10:06','2025-12-10 09:10:06'),(11,1,'Zeeshan Qureshi','qasim.q@gmail.com',NULL,'student','$2y$12$kvHTwM/UXsYF9Ftx0GjhieNpxmiE9ISc8UhvrMIbSX6.wngFwQTuq','active','2025-12-10 09:10:20','2025-12-10 09:10:20'),(12,1,'Isha Verma','ritika.v@gmail.com',NULL,'student','$2y$12$KcE0u38sITJgSK97B8CF4.EIMKGjvb91ISlnZE2VpJedVWd03QTMy','active','2025-12-10 09:10:26','2025-12-10 09:10:26'),(13,1,'Adnan Sheikh','imran.sheikh@gmail.com',NULL,'student','$2y$12$RVWWHAXtFcq4eyXWVO3nK.D0G9PUsxbQuRvg.9940ToEoRgg5aMYS','active','2025-12-10 09:10:56','2025-12-10 09:10:56'),(14,1,'Kavya Pandey','mahavir.p@gmail.com',NULL,'student','$2y$12$oYACaDMvswHMh0guuTXa8OluQHEXPA4fUglwIlsGsGvyFe5ALWcBG','active','2025-12-10 09:11:07','2025-12-10 09:11:07'),(15,1,'Faizan Ahmad','shahid.a@gmail.com',NULL,'student','$2y$12$sz0IPU5FUccVCDB/g7K1/.h9nJmfMHsZ5FgSQn9vFXvabyGP4jC.a','active','2025-12-10 09:11:19','2025-12-10 09:11:19'),(16,1,'Priya Saxena','kamal.saxena@gmail.com',NULL,'student','$2y$12$gmJuBXNrrb4BxwQBXpfNbO60fBJqokqmqnCP0dygN/U5fk4k1c8TW','active','2025-12-10 09:11:29','2025-12-10 09:11:29'),(17,1,'Imtiyaz Khan','shabbir.khan@gmail.com',NULL,'student','$2y$12$XaFX.spQ/40XowHqDWvOquOEADMlV7rWFaieUgWM/HRVGiOusTkh.','active','2025-12-10 09:11:41','2025-12-10 09:11:41'),(18,1,'Anjali Jaiswal','ramesh.j@gmail.com',NULL,'student','$2y$12$EfcylJQiPaS.HanZxWyWL.fWOirysz/oc.XoJx2cqfJpvq.E1Uckm','active','2025-12-10 09:12:45','2025-12-10 09:12:45'),(19,1,'Rehan Malik','yasir.m@gmail.com',NULL,'student','$2y$12$OfPiYshXcD2hYYTTNAyG.eiUY7LK6DEStkjqX78lTPN84NtPht4Hy','active','2025-12-10 09:12:56','2025-12-10 09:12:56'),(20,1,'Surbhi Chauhan','devendra.c@gmail.com',NULL,'student','$2y$12$UjGHG64Ryw3I74jvQ0VreeZsx4xVs6fFR31XwcRKTYj96q3Id8B6O','active','2025-12-10 09:13:04','2025-12-10 09:13:04'),(21,1,'Yusuf Ansari','rahim.a@gmail.com',NULL,'student','$2y$12$GO4ayEbnowDUoe2OfIkTD.K/cqtvCCiZ7w.U37a5AbtLacRr7Gweq','active','2025-12-10 09:13:14','2025-12-10 09:13:14'),(22,1,'Shivani Mishra','mukesh.m@gmail.com',NULL,'student','$2y$12$ZEN8Szjcm8Ncygp2dLgCMe5o.WCpwVn73JDTfH86ou/087cjetjra','active','2025-12-10 09:13:24','2025-12-10 09:13:24'),(23,1,'Aadil Khan','salim.khan@gmail.com',NULL,'student','$2y$12$SlLHwRrkTl7ToMk6bAwKceKz2w903xykMBhCKtwGFA0wtXf8Qw1Ge','active','2025-12-10 09:13:31','2025-12-10 09:13:31'),(24,1,'kazim','kazim papa@gmail.com',NULL,'student','$2y$12$sIII96.7E66oo86avlQa8uzRhyRgedsx1Aukpc8GLcs7bX0RfDYtW','active','2025-12-10 09:14:33','2025-12-10 09:14:33');
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

-- Dump completed on 2025-12-10 20:17:28
