-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `compensations`
--

DROP TABLE IF EXISTS `compensations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compensations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `case_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `case_date` date NOT NULL,
  `sa_plot_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rs_plot_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicants` json NOT NULL,
  `la_case_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `award_serial_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acquisition_record_basis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plot_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objector_details` text COLLATE utf8mb4_unicode_ci,
  `is_applicant_in_award` tinyint(1) NOT NULL,
  `total_acquired_land` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_compensation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_acquired_land` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mouza_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jl_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sa_khatian_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `former_plot_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rs_khatian_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_plot_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_applicant_sa_owner` tinyint(1) NOT NULL,
  `ownership_details` json NOT NULL,
  `mutation_info` json DEFAULT NULL,
  `tax_info` json NOT NULL,
  `additional_documents_info` json NOT NULL,
  `kanungo_opinion` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_signature_date` date DEFAULT NULL,
  `signing_officer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compensations`
--

LOCK TABLES `compensations` WRITE;
/*!40000 ALTER TABLE `compensations` DISABLE KEYS */;
INSERT INTO `compensations` VALUES (1,'CASE-2024-001','2024-01-15','SA-PLOT-001',NULL,'[{\"nid\": \"1234567890123\", \"name\": \"আব্দুল রহমান\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ আলী\"}, {\"nid\": \"1234567890124\", \"name\": \"ফাতেমা বেগম\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল হামিদ\"}]','LA-2024-001','[\"\\u099c\\u09ae\\u09bf\\/\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-001','SA','PLOT-001','আব্দুল রহমান',NULL,1,'2.5 acres','500000','1.25 acres','কাশিমপুর','JL-001','SA-KH-001','OLD-001',NULL,'NEW-001',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-001\", \"sa_khatian_no\": \"SA-KH-001\", \"sa_land_in_khatian\": \"2.5 acres\", \"sa_total_land_in_plot\": \"5 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"আব্দুল রহমান\"}, {\"name\": \"ফাতেমা বেগম\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-01-15\", \"applicant_name\": \"আব্দুল রহমান\", \"kharij_case_no\": \"KHARIJ-001\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-001\", \"kharij_land_amount\": \"1.25 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-001\", \"deed_date\": \"2020-01-15\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"মোহাম্মদ আলী\", \"deed_number\": \"DEED-001\", \"total_shotok\": \"5\", \"recipient_name\": \"আব্দুল রহমান\", \"total_sotangsho\": \"2.5\", \"mutation_case_no\": \"MUT-001\", \"mutation_plot_no\": \"PLOT-001\", \"sold_land_amount\": \"1.25 acres\", \"possession_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": []}','{\"mutation_date\": \"2024-01-15\", \"mutation_case_no\": \"MUT-001\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-29 06:11:55','2025-07-29 06:11:55',NULL,NULL,'pending'),(2,'CASE-2024-002','2024-02-20',NULL,'RS-PLOT-002','[{\"nid\": \"1234567890125\", \"name\": \"রহিমা খাতুন\", \"address\": \"গ্রাম: মোহাম্মদপুর, পোস্ট: মোহাম্মদপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মালেক\"}]','LA-2024-002','[\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-002','RS','PLOT-002','রহিমা খাতুন',NULL,1,'1.5 acres','300000','1.5 acres','মোহাম্মদপুর','JL-002',NULL,'OLD-002','RS-KH-002','NEW-002',0,'{\"rs_info\": {\"rs_plot_no\": \"RS-PLOT-002\", \"rs_khatian_no\": \"RS-KH-002\", \"rs_land_in_khatian\": \"1.5 acres\", \"rs_total_land_in_plot\": \"3 acres\"}, \"sa_info\": {\"sa_plot_no\": \"\", \"sa_khatian_no\": \"\", \"sa_land_in_khatian\": \"\", \"sa_total_land_in_plot\": \"\"}, \"rs_owners\": [{\"name\": \"রহিমা খাতুন\"}], \"sa_owners\": [], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-02-20\", \"applicant_name\": \"রহিমা খাতুন\", \"kharij_case_no\": \"KHARIJ-002\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-002\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-06-15\", \"has_death_cert\": \"yes\", \"inheritance_type\": \"direct\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মালেক\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-02-20\", \"mutation_case_no\": \"KHARIJ-002\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-002\", \"mutation_land_amount\": \"1.5 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"না-দাবী নামা\", \"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-29 06:11:55','2025-07-29 06:11:55',NULL,NULL,'pending'),(3,'CASE-2024-003','2024-03-15','SA-PLOT-003',NULL,'[{\"nid\": \"1234567890126\", \"name\": \"সাবরিনা আক্তার\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}, {\"nid\": \"1234567890127\", \"name\": \"মাহমুদা সুলতানা\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}]','LA-2024-003','[\"\\u099c\\u09ae\\u09bf\\/\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-003','SA','PLOT-003','সাবরিনা আক্তার',NULL,1,'3.0 acres','600000','1.5 acres','উত্তরা','JL-003','SA-KH-003','OLD-003',NULL,'NEW-003',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-003\", \"sa_khatian_no\": \"SA-KH-003\", \"sa_land_in_khatian\": \"3 acres\", \"sa_total_land_in_plot\": \"6 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"সাবরিনা আক্তার\"}, {\"name\": \"মাহমুদা সুলতানা\"}], \"rs_records\": [{\"rs_plot_no\": \"RS-PLOT-003\", \"rs_khatian_no\": \"RS-KH-003\", \"rs_owner_name\": \"সাবরিনা আক্তার\", \"rs_land_in_khatian\": \"1.5 acres\", \"rs_total_land_in_plot\": \"3 acres\"}], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"দলিল\", \"index\": 2}, {\"type\": \"আরএস রেকর্ড\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-03-15\", \"applicant_name\": \"সাবরিনা আক্তার\", \"kharij_case_no\": \"KHARIJ-003\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-003\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-003\", \"deed_date\": \"2021-03-20\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"মোহাম্মদ সফিক\", \"deed_number\": \"DEED-002\", \"total_shotok\": \"6\", \"recipient_name\": \"সাবরিনা আক্তার\", \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-002\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}, {\"plot_no\": \"PLOT-003\", \"deed_date\": \"2022-05-10\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"আব্দুল হামিদ\", \"deed_number\": \"DEED-003\", \"total_shotok\": \"6\", \"recipient_name\": \"মাহমুদা সুলতানা\", \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-003\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": true, \"inheritance_records\": []}','{\"mutation_date\": \"2024-03-15\", \"mutation_case_no\": \"KHARIJ-003\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"না-দাবী নামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-29 06:11:55','2025-07-29 06:11:55',NULL,NULL,'pending'),(4,'CASE-2024-004','2024-04-20','SA-PLOT-004',NULL,'[{\"nid\": \"1234567890128\", \"name\": \"নাসরিন আক্তার\", \"address\": \"গ্রাম: গুলশান, পোস্ট: গুলশান, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মতিন\"}]','LA-2024-004','[\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-004','SA','PLOT-004','নাসরিন আক্তার',NULL,1,'2.0 acres','400000','2.0 acres','গুলশান','JL-004','SA-KH-004','OLD-004',NULL,'NEW-004',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-004\", \"sa_khatian_no\": \"SA-KH-004\", \"sa_land_in_khatian\": \"2 acres\", \"sa_total_land_in_plot\": \"4 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"নাসরিন আক্তার\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-04-20\", \"applicant_name\": \"নাসরিন আক্তার\", \"kharij_case_no\": \"KHARIJ-004\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-004\", \"kharij_land_amount\": \"2 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-004\", \"deed_date\": \"2020-08-15\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"আব্দুল মতিন\", \"deed_number\": \"DEED-004\", \"total_shotok\": \"4\", \"recipient_name\": \"নাসরিন আক্তার\", \"total_sotangsho\": \"2\", \"mutation_case_no\": \"MUT-004\", \"mutation_plot_no\": \"PLOT-004\", \"sold_land_amount\": \"1 acre\", \"possession_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"1 acre\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-12-10\", \"has_death_cert\": \"yes\", \"inheritance_type\": \"direct\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মতিন\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-04-20\", \"mutation_case_no\": \"KHARIJ-004\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"2 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-29 06:11:55','2025-07-29 06:11:55',NULL,NULL,'pending'),(5,'CASE-2024-001','2024-01-15','SA-PLOT-001',NULL,'[{\"nid\": \"1234567890123\", \"name\": \"আব্দুল রহমান\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ আলী\"}, {\"nid\": \"1234567890124\", \"name\": \"ফাতেমা বেগম\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল হামিদ\"}]','LA-2024-001','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-001','SA','PLOT-001','আব্দুল রহমান',NULL,1,'2.5 acres','500000','1.25 acres','কাশিমপুর','JL-001','SA-KH-001','OLD-001',NULL,'NEW-001',1,'{\"status\": \"pending\", \"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-001\", \"sa_khatian_no\": \"SA-KH-001\", \"sa_land_in_khatian\": \"2.5 acres\", \"sa_total_land_in_plot\": \"5 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"আব্দুল রহমান\"}, {\"name\": \"ফাতেমা বেগম\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-01-15\", \"applicant_name\": \"আব্দুল রহমান\", \"kharij_case_no\": \"KHARIJ-001\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-001\", \"kharij_land_amount\": \"1.25 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-001\", \"deed_date\": \"2020-01-15\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"মোহাম্মদ আলী\", \"deed_number\": \"DEED-001\", \"total_shotok\": \"5\", \"recipient_name\": \"আব্দুল রহমান\", \"total_sotangsho\": \"2.5\", \"mutation_case_no\": \"MUT-001\", \"mutation_plot_no\": \"PLOT-001\", \"sold_land_amount\": \"1.25 acres\", \"possession_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [], \"order_signature_date\": null, \"signing_officer_name\": null}','{\"mutation_date\": \"2024-01-15\", \"mutation_case_no\": \"MUT-001\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 05:44:29','2025-07-31 05:44:29',NULL,NULL,'pending'),(6,'CASE-2024-002','2024-02-20',NULL,'RS-PLOT-002','[{\"nid\": \"1234567890125\", \"name\": \"রহিমা খাতুন\", \"address\": \"গ্রাম: মোহাম্মদপুর, পোস্ট: মোহাম্মদপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মালেক\"}]','LA-2024-002','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-002','RS','PLOT-002','রহিমা খাতুন',NULL,1,'1.5 acres','300000','1.5 acres','মোহাম্মদপুর','JL-002',NULL,'OLD-002','RS-KH-002','NEW-002',0,'{\"rs_info\": {\"rs_plot_no\": \"RS-PLOT-002\", \"rs_khatian_no\": \"RS-KH-002\", \"rs_land_in_khatian\": \"1.5 acres\", \"rs_total_land_in_plot\": \"3 acres\"}, \"sa_info\": {\"sa_plot_no\": \"\", \"sa_khatian_no\": \"\", \"sa_land_in_khatian\": \"\", \"sa_total_land_in_plot\": \"\"}, \"rs_owners\": [{\"name\": \"রহিমা খাতুন\"}], \"sa_owners\": [], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-02-20\", \"applicant_name\": \"রহিমা খাতুন\", \"kharij_case_no\": \"KHARIJ-002\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-002\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-06-15\", \"has_death_cert\": \"yes\", \"inheritance_type\": \"direct\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মালেক\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-02-20\", \"mutation_case_no\": \"KHARIJ-002\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-002\", \"mutation_land_amount\": \"1.5 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"না-দাবী নামা\", \"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 05:44:29','2025-07-31 05:44:29',NULL,NULL,'pending'),(7,'CASE-2024-003','2024-03-15','SA-PLOT-003',NULL,'[{\"nid\": \"1234567890126\", \"name\": \"সাবরিনা আক্তার\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}, {\"nid\": \"1234567890127\", \"name\": \"মাহমুদা সুলতানা\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}]','LA-2024-003','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-003','SA','PLOT-003','সাবরিনা আক্তার',NULL,1,'3.0 acres','600000','1.5 acres','উত্তরা','JL-003','SA-KH-003','OLD-003',NULL,'NEW-003',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-003\", \"sa_khatian_no\": \"SA-KH-003\", \"sa_land_in_khatian\": \"3 acres\", \"sa_total_land_in_plot\": \"6 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"সাবরিনা আক্তার\"}, {\"name\": \"মাহমুদা সুলতানা\"}], \"rs_records\": [{\"plot_no\": \"RS-PLOT-003\", \"khatian_no\": \"RS-KH-003\", \"owner_name\": \"সাবরিনা আক্তার\", \"land_amount\": \"3 acres\"}], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"দলিল\", \"index\": 2}, {\"type\": \"আরএস রেকর্ড\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-03-15\", \"applicant_name\": \"সাবরিনা আক্তার\", \"kharij_case_no\": \"KHARIJ-003\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-003\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-003\", \"deed_date\": \"2021-03-20\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"মোহাম্মদ সফিক\", \"deed_number\": \"DEED-002\", \"total_shotok\": \"6\", \"recipient_name\": \"সাবরিনা আক্তার\", \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-002\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}, {\"plot_no\": \"PLOT-003\", \"deed_date\": \"2022-05-10\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"আব্দুল হামিদ\", \"deed_number\": \"DEED-003\", \"total_shotok\": \"6\", \"recipient_name\": \"মাহমুদা সুলতানা\", \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-003\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": true, \"inheritance_records\": []}','{\"mutation_date\": \"2024-03-15\", \"mutation_case_no\": \"KHARIJ-003\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"না-দাবী নামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 05:44:29','2025-07-31 05:44:29',NULL,NULL,'pending'),(8,'CASE-2024-004','2024-04-20','SA-PLOT-004',NULL,'[{\"nid\": \"1234567890128\", \"name\": \"নাসরিন আক্তার\", \"address\": \"গ্রাম: গুলশান, পোস্ট: গুলশান, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মতিন\"}]','LA-2024-004','[\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-004','SA','PLOT-004','নাসরিন আক্তার',NULL,1,'2.0 acres','400000','2.0 acres','গুলশান','JL-004','SA-KH-004','OLD-004',NULL,'NEW-004',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-004\", \"sa_khatian_no\": \"SA-KH-004\", \"sa_land_in_khatian\": \"2 acres\", \"sa_total_land_in_plot\": \"4 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"নাসরিন আক্তার\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-04-20\", \"applicant_name\": \"নাসরিন আক্তার\", \"kharij_case_no\": \"KHARIJ-004\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-004\", \"kharij_land_amount\": \"2 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-004\", \"deed_date\": \"2020-08-15\", \"sale_type\": \"বিক্রয়\", \"donor_name\": \"আব্দুল মতিন\", \"deed_number\": \"DEED-004\", \"total_shotok\": \"4\", \"recipient_name\": \"নাসরিন আক্তার\", \"total_sotangsho\": \"2\", \"mutation_case_no\": \"MUT-004\", \"mutation_plot_no\": \"PLOT-004\", \"sold_land_amount\": \"1 acre\", \"possession_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"1 acre\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-12-10\", \"has_death_cert\": \"yes\", \"inheritance_type\": \"direct\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মতিন\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-04-20\", \"mutation_case_no\": \"KHARIJ-004\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"2 acres\"}','{\"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\"}','{\"details\": {\"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 05:44:29','2025-07-31 05:44:29',NULL,NULL,'pending'),(9,'CASE-2024-001','2024-01-15','SA-PLOT-001',NULL,'[{\"nid\": \"1234567890123\", \"name\": \"আব্দুল রহমান\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ আলী\"}, {\"nid\": \"1234567890124\", \"name\": \"ফাতেমা বেগম\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল হামিদ\"}]','LA-2024-001','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-001','SA','PLOT-001','আব্দুল রহমান',NULL,1,'2.5 acres','500000','1.25 acres','কাশিমপুর','JL-001','SA-KH-001','OLD-001',NULL,'NEW-001',1,'{\"status\": \"pending\", \"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-001\", \"sa_khatian_no\": \"SA-KH-001\", \"sa_land_in_khatian\": \"2.5 acres\", \"sa_total_land_in_plot\": \"5 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"আব্দুল রহমান\"}, {\"name\": \"ফাতেমা বেগম\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-01-15\", \"applicant_name\": \"আব্দুল রহমান\", \"kharij_case_no\": \"KHARIJ-001\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-001\", \"kharij_land_amount\": \"1.25 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-001\", \"deed_date\": \"2020-01-15\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-001\", \"donor_names\": [{\"name\": \"মোহাম্মদ আলী\"}], \"total_shotok\": \"5\", \"recipient_names\": [{\"name\": \"আব্দুল রহমান\"}], \"total_sotangsho\": \"2.5\", \"mutation_case_no\": \"MUT-001\", \"mutation_plot_no\": \"PLOT-001\", \"sold_land_amount\": \"1.25 acres\", \"possession_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [], \"order_signature_date\": null, \"signing_officer_name\": null}','{\"mutation_date\": \"2024-01-15\", \"mutation_case_no\": \"MUT-001\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\"}','{\"holding_no\": \"HLD-001\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"2.5 acres\"}','{\"details\": {\"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:26:39','2025-07-31 09:26:39',NULL,NULL,'pending'),(10,'CASE-2024-002','2024-02-20',NULL,'RS-PLOT-002','[{\"nid\": \"1234567890125\", \"name\": \"রহিমা খাতুন\", \"address\": \"গ্রাম: মোহাম্মদপুর, পোস্ট: মোহাম্মদপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মালেক\"}]','LA-2024-002','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-002','RS','PLOT-002','রহিমা খাতুন',NULL,1,'1.5 acres','300000','1.5 acres','মোহাম্মদপুর','JL-002',NULL,'OLD-002','RS-KH-002','NEW-002',0,'{\"rs_info\": {\"rs_plot_no\": \"RS-PLOT-002\", \"rs_khatian_no\": \"RS-KH-002\", \"rs_land_in_khatian\": \"1.5 acres\", \"rs_total_land_in_plot\": \"3 acres\"}, \"sa_info\": {\"sa_plot_no\": \"\", \"sa_khatian_no\": \"\", \"sa_land_in_khatian\": \"\", \"sa_total_land_in_plot\": \"\"}, \"rs_owners\": [{\"name\": \"রহিমা খাতুন\"}], \"sa_owners\": [], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-02-20\", \"applicant_name\": \"রহিমা খাতুন\", \"kharij_case_no\": \"KHARIJ-002\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-002\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-06-15\", \"has_death_cert\": \"yes\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মালেক\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-02-20\", \"mutation_case_no\": \"KHARIJ-002\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-002\", \"mutation_land_amount\": \"1.5 acres\"}','{\"holding_no\": \"HLD-002\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"1.5 acres\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"না-দাবী নামা\", \"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:26:39','2025-07-31 09:26:39',NULL,NULL,'pending'),(11,'CASE-2024-003','2024-03-15','SA-PLOT-003',NULL,'[{\"nid\": \"1234567890126\", \"name\": \"সাবরিনা আক্তার\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}, {\"nid\": \"1234567890127\", \"name\": \"মাহমুদা সুলতানা\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}]','LA-2024-003','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-003','SA','PLOT-003','সাবরিনা আক্তার',NULL,1,'3.0 acres','600000','1.5 acres','উত্তরা','JL-003','SA-KH-003','OLD-003',NULL,'NEW-003',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-003\", \"sa_khatian_no\": \"SA-KH-003\", \"sa_land_in_khatian\": \"3 acres\", \"sa_total_land_in_plot\": \"6 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"সাবরিনা আক্তার\"}, {\"name\": \"মাহমুদা সুলতানা\"}], \"rs_records\": [{\"plot_no\": \"RS-PLOT-003\", \"khatian_no\": \"RS-KH-003\", \"owner_name\": \"সাবরিনা আক্তার\", \"land_amount\": \"3 acres\"}], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"দলিল\", \"index\": 2}, {\"type\": \"আরএস রেকর্ড\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-03-15\", \"applicant_name\": \"সাবরিনা আক্তার\", \"kharij_case_no\": \"KHARIJ-003\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-003\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-003\", \"deed_date\": \"2021-03-20\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-002\", \"donor_names\": [{\"name\": \"মোহাম্মদ সফিক\"}], \"total_shotok\": \"6\", \"recipient_names\": [{\"name\": \"সাবরিনা আক্তার\"}], \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-002\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}, {\"plot_no\": \"PLOT-003\", \"deed_date\": \"2022-05-10\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-003\", \"donor_names\": [{\"name\": \"আব্দুল হামিদ\"}], \"total_shotok\": \"6\", \"recipient_names\": [{\"name\": \"মাহমুদা সুলতানা\"}], \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-003\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": true, \"inheritance_records\": []}','{\"mutation_date\": \"2024-03-15\", \"mutation_case_no\": \"KHARIJ-003\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\"}','{\"holding_no\": \"HLD-003\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"1.5 acres\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"না-দাবী নামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:26:39','2025-07-31 09:26:39',NULL,NULL,'pending'),(12,'CASE-2024-004','2024-04-20','SA-PLOT-004',NULL,'[{\"nid\": \"1234567890128\", \"name\": \"নাসরিন আক্তার\", \"address\": \"গ্রাম: গুলশান, পোস্ট: গুলশান, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মতিন\"}]','LA-2024-004','[\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-004','SA','PLOT-004','নাসরিন আক্তার',NULL,1,'2.0 acres','400000','2.0 acres','গুলশান','JL-004','SA-KH-004','OLD-004',NULL,'NEW-004',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-004\", \"sa_khatian_no\": \"SA-KH-004\", \"sa_land_in_khatian\": \"2 acres\", \"sa_total_land_in_plot\": \"4 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"নাসরিন আক্তার\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-04-20\", \"applicant_name\": \"নাসরিন আক্তার\", \"kharij_case_no\": \"KHARIJ-004\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-004\", \"kharij_land_amount\": \"2 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-004\", \"deed_date\": \"2020-08-15\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-004\", \"donor_names\": [{\"name\": \"আব্দুল মতিন\"}], \"total_shotok\": \"4\", \"recipient_names\": [{\"name\": \"নাসরিন আক্তার\"}], \"total_sotangsho\": \"2\", \"mutation_case_no\": \"MUT-004\", \"mutation_plot_no\": \"PLOT-004\", \"sold_land_amount\": \"1 acre\", \"possession_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"1 acre\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-12-10\", \"has_death_cert\": \"yes\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মতিন\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-04-20\", \"mutation_case_no\": \"KHARIJ-004\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"2 acres\"}','{\"holding_no\": \"HLD-004\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"2 acres\"}','{\"details\": {\"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:26:39','2025-07-31 09:26:39',NULL,NULL,'pending'),(13,'CASE-2024-001','2024-01-15','SA-PLOT-001',NULL,'[{\"nid\": \"1234567890123\", \"name\": \"আব্দুল রহমান\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ আলী\"}, {\"nid\": \"1234567890124\", \"name\": \"ফাতেমা বেগম\", \"address\": \"গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল হামিদ\"}]','LA-2024-001','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-001','SA','PLOT-001','আব্দুল রহমান',NULL,1,'2.5 acres','500000','1.25 acres','কাশিমপুর','JL-001','SA-KH-001','OLD-001',NULL,'NEW-001',1,'{\"status\": \"pending\", \"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-001\", \"sa_khatian_no\": \"SA-KH-001\", \"sa_land_in_khatian\": \"2.5 acres\", \"sa_total_land_in_plot\": \"5 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"আব্দুল রহমান\"}, {\"name\": \"ফাতেমা বেগম\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-01-15\", \"applicant_name\": \"আব্দুল রহমান\", \"kharij_case_no\": \"KHARIJ-001\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-001\", \"kharij_land_amount\": \"1.25 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-001\", \"deed_date\": \"2020-01-15\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-001\", \"donor_names\": [{\"name\": \"মোহাম্মদ আলী\"}], \"total_shotok\": \"5\", \"recipient_names\": [{\"name\": \"আব্দুল রহমান\"}], \"total_sotangsho\": \"2.5\", \"mutation_case_no\": \"MUT-001\", \"mutation_plot_no\": \"PLOT-001\", \"sold_land_amount\": \"1.25 acres\", \"possession_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [], \"order_signature_date\": null, \"signing_officer_name\": null}','{\"mutation_date\": \"2024-01-15\", \"mutation_case_no\": \"MUT-001\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-001\", \"mutation_land_amount\": \"1.25 acres\"}','{\"holding_no\": \"HLD-001\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"2.5 acres\"}','{\"details\": {\"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:33:22','2025-07-31 09:33:22',NULL,NULL,'pending'),(14,'CASE-2024-002','2024-02-20',NULL,'RS-PLOT-002','[{\"nid\": \"1234567890125\", \"name\": \"রহিমা খাতুন\", \"address\": \"গ্রাম: মোহাম্মদপুর, পোস্ট: মোহাম্মদপুর, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মালেক\"}]','LA-2024-002','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-002','RS','PLOT-002','রহিমা খাতুন',NULL,1,'1.5 acres','300000','1.5 acres','মোহাম্মদপুর','JL-002',NULL,'OLD-002','RS-KH-002','NEW-002',0,'{\"rs_info\": {\"rs_plot_no\": \"RS-PLOT-002\", \"rs_khatian_no\": \"RS-KH-002\", \"rs_land_in_khatian\": \"1.5 acres\", \"rs_total_land_in_plot\": \"3 acres\"}, \"sa_info\": {\"sa_plot_no\": \"\", \"sa_khatian_no\": \"\", \"sa_land_in_khatian\": \"\", \"sa_total_land_in_plot\": \"\"}, \"rs_owners\": [{\"name\": \"রহিমা খাতুন\"}], \"sa_owners\": [], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-02-20\", \"applicant_name\": \"রহিমা খাতুন\", \"kharij_case_no\": \"KHARIJ-002\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-002\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-06-15\", \"has_death_cert\": \"yes\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মালেক\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-02-20\", \"mutation_case_no\": \"KHARIJ-002\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-002\", \"mutation_land_amount\": \"1.5 acres\"}','{\"holding_no\": \"HLD-002\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"1.5 acres\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"না-দাবী নামা\", \"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:33:22','2025-07-31 09:33:22',NULL,NULL,'pending'),(15,'CASE-2024-003','2024-03-15','SA-PLOT-003',NULL,'[{\"nid\": \"1234567890126\", \"name\": \"সাবরিনা আক্তার\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}, {\"nid\": \"1234567890127\", \"name\": \"মাহমুদা সুলতানা\", \"address\": \"গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা\", \"father_name\": \"মোহাম্মদ সফিক\"}]','LA-2024-003','[\"\\u099c\\u09ae\\u09bf\",\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\",\"\\u0985\\u09ac\\u0995\\u09be\\u09a0\\u09be\\u09ae\\u09cb\"]','AWD-003','SA','PLOT-003','সাবরিনা আক্তার',NULL,1,'3.0 acres','600000','1.5 acres','উত্তরা','JL-003','SA-KH-003','OLD-003',NULL,'NEW-003',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-003\", \"sa_khatian_no\": \"SA-KH-003\", \"sa_land_in_khatian\": \"3 acres\", \"sa_total_land_in_plot\": \"6 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"সাবরিনা আক্তার\"}, {\"name\": \"মাহমুদা সুলতানা\"}], \"rs_records\": [{\"plot_no\": \"RS-PLOT-003\", \"khatian_no\": \"RS-KH-003\", \"owner_name\": \"সাবরিনা আক্তার\", \"land_amount\": \"3 acres\"}], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"দলিল\", \"index\": 2}, {\"type\": \"আরএস রেকর্ড\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-03-15\", \"applicant_name\": \"সাবরিনা আক্তার\", \"kharij_case_no\": \"KHARIJ-003\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-003\", \"kharij_land_amount\": \"1.5 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-003\", \"deed_date\": \"2021-03-20\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-002\", \"donor_names\": [{\"name\": \"মোহাম্মদ সফিক\"}], \"total_shotok\": \"6\", \"recipient_names\": [{\"name\": \"সাবরিনা আক্তার\"}], \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-002\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}, {\"plot_no\": \"PLOT-003\", \"deed_date\": \"2022-05-10\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-003\", \"donor_names\": [{\"name\": \"আব্দুল হামিদ\"}], \"total_shotok\": \"6\", \"recipient_names\": [{\"name\": \"মাহমুদা সুলতানা\"}], \"total_sotangsho\": \"3\", \"mutation_case_no\": \"MUT-003\", \"mutation_plot_no\": \"PLOT-003\", \"sold_land_amount\": \"1.5 acres\", \"possession_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": true, \"inheritance_records\": []}','{\"mutation_date\": \"2024-03-15\", \"mutation_case_no\": \"KHARIJ-003\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-003\", \"mutation_land_amount\": \"1.5 acres\"}','{\"holding_no\": \"HLD-003\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"1.5 acres\"}','{\"details\": {\"না-দাবী নামা\": \"না-দাবী নামা সম্পন্ন হয়েছে\", \"সরেজমিন তদন্ত\": \"সরেজমিন তদন্ত সম্পন্ন হয়েছে\", \"আপস- বন্টননামা\": \"আপসনামা সম্পন্ন হয়েছে\"}, \"selected_types\": [\"আপস- বন্টননামা\", \"না-দাবী নামা\", \"সরেজমিন তদন্ত\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:33:22','2025-07-31 09:33:22',NULL,NULL,'pending'),(16,'CASE-2024-004','2024-04-20','SA-PLOT-004',NULL,'[{\"nid\": \"1234567890128\", \"name\": \"নাসরিন আক্তার\", \"address\": \"গ্রাম: গুলশান, পোস্ট: গুলশান, জেলা: ঢাকা\", \"father_name\": \"আব্দুল মতিন\"}]','LA-2024-004','[\"\\u099c\\u09ae\\u09bf\\/\\u0997\\u09be\\u099b\\u09aa\\u09be\\u09b2\\u09be\"]','AWD-004','SA','PLOT-004','নাসরিন আক্তার',NULL,1,'2.0 acres','400000','2.0 acres','গুলশান','JL-004','SA-KH-004','OLD-004',NULL,'NEW-004',1,'{\"rs_info\": {\"rs_plot_no\": \"\", \"rs_khatian_no\": \"\", \"rs_land_in_khatian\": \"\", \"rs_total_land_in_plot\": \"\"}, \"sa_info\": {\"sa_plot_no\": \"SA-PLOT-004\", \"sa_khatian_no\": \"SA-KH-004\", \"sa_land_in_khatian\": \"2 acres\", \"sa_total_land_in_plot\": \"4 acres\"}, \"rs_owners\": [], \"sa_owners\": [{\"name\": \"নাসরিন আক্তার\"}], \"rs_records\": [], \"currentStep\": \"applicant\", \"transferItems\": [{\"type\": \"দলিল\", \"index\": 1}, {\"type\": \"ওয়ারিশ\", \"index\": 1}, {\"type\": \"আবেদনকারী\", \"index\": 1}], \"applicant_info\": {\"kharij_date\": \"2024-04-20\", \"applicant_name\": \"নাসরিন আক্তার\", \"kharij_case_no\": \"KHARIJ-004\", \"kharij_details\": \"খারিজ সম্পন্ন হয়েছে\", \"kharij_plot_no\": \"PLOT-004\", \"kharij_land_amount\": \"2 acres\"}, \"completedSteps\": [\"info\", \"transfers\", \"applicant\"], \"deed_transfers\": [{\"plot_no\": \"PLOT-004\", \"deed_date\": \"2020-08-15\", \"sale_type\": \"বিক্রয়\", \"deed_number\": \"DEED-004\", \"donor_names\": [{\"name\": \"আব্দুল মতিন\"}], \"total_shotok\": \"4\", \"recipient_names\": [{\"name\": \"নাসরিন আক্তার\"}], \"total_sotangsho\": \"2\", \"mutation_case_no\": \"MUT-004\", \"mutation_plot_no\": \"PLOT-004\", \"sold_land_amount\": \"1 acre\", \"possession_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"1 acre\", \"possession_mentioned\": \"yes\", \"possession_description\": \"দখলে আছে\"}], \"rs_record_disabled\": false, \"inheritance_records\": [{\"death_date\": \"2023-12-10\", \"has_death_cert\": \"yes\", \"is_heir_applicant\": \"yes\", \"previous_owner_name\": \"আব্দুল মতিন\", \"heirship_certificate_info\": \"ওয়ারিশ সনদ আছে\"}]}','{\"mutation_date\": \"2024-04-20\", \"mutation_case_no\": \"KHARIJ-004\", \"mutation_details\": \"খারিজ সম্পন্ন হয়েছে\", \"mutation_plot_no\": \"PLOT-004\", \"mutation_land_amount\": \"2 acres\"}','{\"holding_no\": \"HLD-004\", \"bangla_year\": \"১৪৩১\", \"english_year\": \"2024\", \"paid_land_amount\": \"2 acres\"}','{\"details\": {\"এফিডেভিটের তথ্য\": \"এফিডেভিট সম্পন্ন হয়েছে\"}, \"selected_types\": [\"এফিডেভিটের তথ্য\"]}','{\"opinion_details\": \"মালিকানার ধারাবাহিকতা আছে\", \"has_ownership_continuity\": \"yes\"}','2025-07-31 09:33:22','2025-07-31 09:33:22',NULL,NULL,'pending');
/*!40000 ALTER TABLE `compensations` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_14_create_order_sheets_table',1),(5,'2025_07_16_create_compensations_table',1),(6,'2025_07_20_190941_update_compensations_table_add_inheritance_records',1),(7,'2025_07_27_183238_update_tax_info_structure',1),(8,'2025_07_27_190338_update_ownership_details_structure',1),(9,'2025_07_27_192140_make_mutation_info_nullable',1),(10,'2025_07_28_191222_update_compensations_table_make_fields_nullable',1),(11,'2025_07_29_164928_make_kanungo_opinion_nullable',2),(12,'2025_07_29_171453_add_order_fields_to_compensations_table',2),(13,'2025_07_31_102715_update_land_schedule_field_names',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
INSERT INTO `sessions` VALUES ('2mOyNNhcBnaCZbSoljKRKlyzR2CtORDLbXKpftSH',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlJwMlhXbXNBZzBPTHlXT1lycEQ0MFdkS2o3NHUzOGNKeVJlVFU5YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189453),('4XjRg7i4tmGGq3FS5CdUR6qx78j9KkCI2FF9OtLV',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXlFUmY2a2lkT1Rxc1FSdGY0dGc0YzY5c3hkOURCcWY4eVJNQ2JYMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189421),('59Uddk3Upjrj05Fr1SqSBAgBdwdmb7zS9Z7OcZpo',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1lYQ29zTVMzdUZPdE8yOU9GeWhtMU12RE5ZQjhTeHB6NDNaR1l6dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189470),('94qOhJTkVIjyWiAFcQUIoX60ZnHp8J71WckLAU2g',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWJMUGc3YnBQOGx5QTRJb3hCU25ESU40T1VBdGhGdHc2bnhCelZaeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189472),('95J2VRLfBWqDHEbRraSC4enqBG0vCnsuWXJgknCR',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoia2x0QjZzT3NMVWpWTVRmQ3d3TU5hQzdvYkVTUktqTlQzRG5uT0FsMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189459),('BC0rHvPmPz8E85NDTuAvsKAxDQPS3ldFuc2MRBOA',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUU5Y2FER2ZJR2JHSnFHeHZuTW94d0pnNnFtMzRwRHczU2NqMUZlYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189430),('cRDvkmTRbQe7fxlXn5LnDCeInENPcf9oS0r0cjGS',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYk5TRTBtbmVJazBQa1R3VmFwanZUTG5GYUpWUFZCUU9UdmdvWEp2OSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189444),('e62R29oGPVUnTmS6Oj8jF5RcSBya8Ku5B7LnBku0',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDRRQU16U2NhdzJOWDVwQ3ppYWIxRFY3Qk5oanNKRkZBMjJjS2dubCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189438),('g5OQClaYFro7y0ya5A4xiTrkXqQUWkaniezoWkQx',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYUlGT2pINlBtNEFhbWFvMlBYY2Q1THhJUXdaVW54YWhLTDVSWE5rUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189419),('H3ftOj2g38cmluYv2igZbe4t5L32bWtu5QYgHqJb',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGtQa01xcXY4Nk9NMXlpZlhFcDdSMmZQZ2wwZHZQNFhYRHRBQUpNMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189436),('h6MkfzfdHaGxnieHvxeiOPs4QAnWJc0ZHmPs15Fa',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUtJeVV4UGFGbGdNWG9nUGNQV2FvZ28zdFIwbXJpN0tjSlVaUEEwaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189474),('ItTPjLT42fSqdprUhRiQb2v7wjZfkrKrMh0sWGGO',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXpuUUI3YjREZDRLSmlJV2tnenY2bG5OSzBXTmxhZW1WaEQ4bkUyYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189442),('JeCgYsz7rssl23eV8wndIPjt2skfwiXsgn6g79KP',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidjlkV0tNVU1renlRNmxJcTVySHExOGEwdVZ2ZHBPU0FhdW51a3Q2MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189427),('k1WbqtY3wygQftqW8OFJyXcx6Z93rYkAU3v49Sao',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidGM3YVA0cVNlSUhYUWhxTmlsUUsybHlQMXdhdUZpelpYWDJMYlFNSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189440),('l0UzSCFOYYa9x3rgUFUlzd9RtWlNIWPjLT2wreLA',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDh4Vlo2ZTM4OU1ZMlBoeG1HakFVYnIyaGdhYXZ0aElWR2lQSmNIRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189434),('lKC2GDUFHP9la0BFG462nHkvnyLOxRQBfFELw8yz',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNThXZVZJeVNRZzdHQnhib0J6UzlhWFI4UWt1T0x3aFhPVElCU1l1eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189432),('M7TVTxdtDQ0uaJz7sy7odxiCMC3hriTyoVre60kW',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDNlV09nSkMyZG5qQWZHd3BMNUhMbERtSTZWMVpXVEozRm9VM1pKbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189457),('pl15AYJgA6lYRr3K9tZfVKU0YmnI872a7VqRYIy2',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnU3dWFSUTM4cm9nSW1MeUVoMVIwQ0hkM25TVDFDTE05VXpVTXRDSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189425),('QaUSaOXmHn1zuQD4vi2YlczkwYm1Z2MAVP3E4lso',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXVBaGk1YXBWRFdFUlYxVldLTHN1RVl3aVpSUzk2MXBrUEFvRzZ3VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189423),('QLE5SMlrwttOd6SBgI8V46TweN8ivFOfCvAgEsaS',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVRGaDFnZEVmWlBFYXlSRVVZVVlHYkRTV0FINk1MMTJzOVFTSFVGVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189467),('qmHKEPEdmWhnR1DEcubO59rmc2nTMVAWR2yCW5gx',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieVlUTW5KbjNCWVRCc01XcU9oQm1XbktybFRMT01WQ05Zd2JKcm1lYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189465),('RSCUF7o6IyG3nH6Mjo5rmBM9PHvAUUNyamzGQlPp',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibU4zNzAwSGRUc2poVlp2QUNEYXo4d05kckJ2YlFhRDNuc3JBdHhqRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189455),('SuqXjuPOxoARZFK7uGDZINi8RzRwD477PhQzDY3L',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXNkNm82WEw4Z1A2WGhvc2N6dm14eERxdHJYN1ozSGRtdnlyanM2SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189480),('TL4VxBorKP5YyOo6LuW67JmzIiCBnARiUXhdhc2L',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWxlSHVLSjl6SmpvTmdmRWRzSFZpdk5senBYNHF2bUQ5QVpHOTZYZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189463),('trxQzD98vYUXGSvSLkVLNHVSTbbiMtYbB9JqbV8e',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieFk0SVVKR2pHa1RoVHJlZ0ZwdHRWZ3RLRWdMVEVTN0NTTUNvY2plaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189486),('Umql0MrdvZtknqwk3vF85jGtaDyiUUaQGHawSRLB',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTENvR1p2NEowdVJlbWNwY0VJUW5hcVVaMWE5N082cjVVMU5yT1NBRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189449),('Z1S7mTTM26gvI78A6BayehnKdupHGMJLL4hRcOFp',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSndyZE9FeGk4dkdDZXNxOUVQbmFURXloSlc4MndqYUJQNG56WDhwWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189446),('ZF84lTgywO1ZETEWX9esRDpaVcYWoR9Q7XiEcuiV',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0RTYWpocVFUTm0yUzRkZmFwWHMybHloeXdtWVVBcmxtalowbUhyZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189451),('zp3iYyr0P6UH3bepehQPixJ1cYcSrc4Nt7bcdXZ0',NULL,'172.18.0.1','curl/8.5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDY1ejYzM3ByRU5hbXhyUTljOERDNEhLRk1mMERNR3Q5c1lrTTNidCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1754189461);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2025-08-03  2:55:27
