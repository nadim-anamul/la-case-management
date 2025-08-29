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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_14_create_order_sheets_table',1),(5,'2025_07_16_create_compensations_table',1),(6,'2025_07_20_190941_update_compensations_table_add_inheritance_records',1),(7,'2025_07_27_183238_update_tax_info_structure',1),(8,'2025_07_27_190338_update_ownership_details_structure',1),(9,'2025_07_27_192140_make_mutation_info_nullable',1),(10,'2025_07_28_191222_update_compensations_table_make_fields_nullable',1),(11,'2025_07_29_164928_make_kanungo_opinion_nullable',1),(12,'2025_07_29_171453_add_order_fields_to_compensations_table',1),(13,'2025_07_31_102715_update_land_schedule_field_names',1),(14,'2025_08_02_163029_update_award_holder_name_to_json',1),(15,'2025_08_02_164755_make_former_and_current_plot_nullable',1),(16,'2025_08_03_013955_add_new_compensation_fields',1),(17,'2025_08_03_033434_fix_award_type_values',1),(18,'2025_08_03_190921_add_land_category_to_compensations_table',1),(19,'2025_08_03_193616_add_award_serial_no_fields_to_compensations_table',1),(20,'2025_08_03_193935_make_award_serial_no_nullable',1),(21,'2025_08_03_210423_remove_total_acquired_land_and_total_compensation_from_compensations_table',1),(22,'2025_08_04_075034_make_tax_info_and_additional_documents_nullable',1),(23,'2025_08_05_033027_remove_unnecessary_fields_from_compensations_table',1),(24,'2025_08_05_163145_remove_old_deed_transfer_fields_from_compensations',1),(25,'2025_08_06_015336_make_ownership_details_nullable',1),(26,'2025_08_06_052302_cleanup_compensations_table_structure',1),(27,'2025_08_09_094112_add_district_upazila_to_compensations_table',1),(28,'2025_08_11_024014_change_ownership_details_to_json',1),(29,'2025_08_11_185805_update_award_type_values_to_new_structure',2),(30,'2025_08_12_094113_add_final_order_to_compensations_table',3),(31,'2025_08_12_094114_add_final_order_to_compensations_table',3),(32,'2025_08_15_012756_add_paid_in_name_to_tax_info',4),(33,'2025_08_23_173547_add_order_comment_to_compensations_table',5),(34,'2025_08_23_180428_add_case_information_to_compensations_table',5),(35,'2025_08_25_035504_add_general_comments_to_compensations_table',6),(36,'2025_08_25_133433_add_user_approval_system_to_users_table',7),(37,'2025_08_25_134610_add_password_management_to_users_table',7),(38,'2025_08_25_141306_add_audit_tracking_to_compensations_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-29 12:48:27
