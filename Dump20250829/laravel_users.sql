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
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_super_user` tinyint(1) NOT NULL DEFAULT '0',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `registration_note` text COLLATE utf8mb4_unicode_ci,
  `must_change_password` tinyint(1) NOT NULL DEFAULT '0',
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `password_reset_by` bigint unsigned DEFAULT NULL,
  `password_reset_reason` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_approved_by_foreign` (`approved_by`),
  KEY `users_is_approved_is_super_user_index` (`is_approved`,`is_super_user`),
  KEY `users_password_reset_by_foreign` (`password_reset_by`),
  KEY `users_must_change_password_index` (`must_change_password`),
  CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_password_reset_by_foreign` FOREIGN KEY (`password_reset_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@admin.com','2025-08-25 16:45:14','$2y$12$Akvret3XPIloHyh9DIRXIuRVQgzqQ16qEQ5p/5v92DnxrRngdEMtq',1,1,'2025-08-25 16:45:14',NULL,NULL,0,'2025-08-28 05:09:05',NULL,NULL,'gfPyTpir9ifWEEUnVnchBgGs5pCF0E4tRoVDmFpQRfcYm5IiNiu9I5UQVK8c','2025-08-25 16:45:14','2025-08-28 05:09:05'),(2,'Anamul Hasan Nadim','nadim.csm@gmail.com',NULL,'$2y$12$1vUh1NIs4uuM9QsSes1obuWJAaMU63Dp7bmFC6bzUscIcvouGI3xS',1,0,'2025-08-25 17:18:37',1,'want to enter data',0,NULL,NULL,NULL,'4rvOGkPRVvtiHiOmxmNYsanJgdgmvUGTNE7GsEwF885zcsWKO2KHWiVXEXrC','2025-08-25 16:58:43','2025-08-25 17:18:37'),(3,'Nahian Moonsif','nahianovi71@gmail.com',NULL,'$2y$12$XPdjlEL2h7bnTwxTGIYR7.k5IOi4outVBajg20cxrQy2IedZ9jf96',1,0,'2025-08-25 17:18:35',1,NULL,0,NULL,NULL,NULL,NULL,'2025-08-25 17:15:42','2025-08-25 17:18:35'),(4,'মো: নুর ইসলাম','islammnur138@gmail.com',NULL,'$2y$12$NzVAxpy4/zrWfam70W2dXOM7mG608UNfpzBJomAczMoePLxR3aP.u',1,0,'2025-08-26 05:25:19',1,'ব্যবহারকারী (পেশকার) হিসেবে কার্যক্রম সম্পাদনের জন্য এই সিস্টেমে অ্যাকাউন্ট খুলতে চাই।',0,NULL,NULL,NULL,NULL,'2025-08-26 04:56:09','2025-08-26 05:25:19');
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

-- Dump completed on 2025-08-29 12:48:23
