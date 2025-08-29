-- MySQL dump 10.13  Distrib 8.0.42, for macos15 (arm64)
--
-- Host: 152.42.201.131    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `order_sheets`
--

DROP TABLE IF EXISTS `order_sheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_sheets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `case_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `case_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `applicant_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `roedad_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `miss_case_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sa_record_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sa_owner_heir_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sa_heir_heir_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sa_heir_transfer_details_1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sa_heir_transfer_details_2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rs_khatian_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rs_owner_heir_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_claim_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `investigation_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_claim` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `overall_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_order_summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_payment_order` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `compensation_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_compensation_words` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lao_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_sheets`
--

LOCK TABLES `order_sheets` WRITE;
/*!40000 ALTER TABLE `order_sheets` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_sheets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-29 12:48:29
