-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: avnee_db
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

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
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home_top',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'studio',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'banners/Fy19Cbgrj4HpKNYx3TPpe2omfCnXCImSDNzhfceH.jpg',NULL,NULL,'/products','home_top','studio',1,1,'2026-03-27 04:08:09','2026-03-27 08:51:12'),(2,'banners/zSA60dwturOlHnRRZ87JbBsQjATXnlmNi5vbDRv6.jpg',NULL,NULL,'/products?category=kids','home_top','studio',2,1,'2026-03-27 04:08:09','2026-04-01 08:08:46'),(3,'banners/fF3PXeMZAX1aO1FMEHbQqwKbkpWOaE6s5D0JzZ3m.jpg',NULL,NULL,'/products?category=kids','home_top','studio',3,1,'2026-03-27 08:51:45','2026-04-01 08:05:57'),(4,'banners/U45zDfnUnjDLhJRtiEOqSzf3MoCT1783MKjSXDXQ.jpg',NULL,NULL,NULL,'jewellery_top','studio',0,1,'2026-03-27 08:53:29','2026-03-27 09:02:04');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES (1,'Heritage Styling','heritage-styling',1,'2026-04-03 18:03:34','2026-04-03 18:03:34');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `blog_category_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `is_on_home` tinyint(1) NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  CONSTRAINT `blog_posts_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,1,'How to Style Traditional Jewellery with Modern Outfits','style-traditional-jewellery-modern-outfits','blogs/blog-1.jpg','Discover how to effortlessly pair traditional jewellery with modern outfits for a chic and elegant fusion look. Explore styling tips to make a statement with your ethnic jewelry pieces.',1,1,54,'2026-04-03 18:03:34','2026-04-05 22:33:21'),(2,1,'5 Must-Have Statement Earrings for Every Occasion','5-must-have-statement-earrings','blogs/blog-2.jpg','Elevate your accessory game with our top picks of statement earrings perfect for weddings, parties, and festive celebrations. Find out which eye-catching designs you need in your jewelry collection.',1,1,9,'2026-04-03 18:03:34','2026-04-05 22:33:31'),(3,1,'The Evolution of Bridal Couture in 2026','evolution-bridal-couture-2026','blogs/blog-3.jpg','A deep dive into the shifting paradigms of bridal fashion. From minimalism to maximalist archival revivals, we explore what the modern bride is choosing for her legacy moments.',1,1,4,'2026-04-03 18:03:34','2026-04-05 22:33:21');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand_experiences`
--

DROP TABLE IF EXISTS `brand_experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand_experiences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `layout_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_description` text COLLATE utf8mb4_unicode_ci,
  `image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_1_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_2_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_3_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_4_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SHOP NOW',
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_experiences_brand_id_foreign` (`brand_id`),
  CONSTRAINT `brand_experiences_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand_experiences`
--

LOCK TABLES `brand_experiences` WRITE;
/*!40000 ALTER TABLE `brand_experiences` DISABLE KEYS */;
INSERT INTO `brand_experiences` VALUES (2,1,'layout_1','THE TRINKETS EDIT','Curated','A playful collection of miniature delights.','experiences/KM7m5dCreTgFYzLRt9eudsToqpP5oKT6MthnYwl1.png',NULL,'experiences/WM9eHH6JuKpVvp606Lf4uKKApF21CvG4xFx9xoaJ.png',NULL,'experiences/rc4l9QsvCeTKuUSMJreSVEsELDgCmi5XcUBtTWGC.png',NULL,NULL,NULL,'VIEW EDIT','https://twosample.online/products?category=sarees',1,1,'2026-04-03 10:44:00','2026-04-03 11:01:13'),(3,1,'layout_2','HAIR ACCESSORIES','Essentials','Complete your look with our crowning jewels.','experiences/t9RGNBpdelLcLayMBZElatgxAfuXgTG6Eo8cXgfo.png',NULL,'experiences/EcHOgX029QjNBd6xJh5GHmmbt6q6gPeFGdmSzG8Y.png',NULL,'experiences/tUBXSIEm5SUm8fW43ClLyj26byGQwKNLHmr7HlP3.png',NULL,'experiences/ACbvef0CzvW9K1OpPLhc3WOw0EdZbG5UCm4rHJdu.png',NULL,'EXPLORE','#',2,1,'2026-04-03 10:44:00','2026-04-03 11:04:07'),(4,2,'layout_3','ARTISANAL CRAFT','The Heritage','Discover the meticulous craftsmanship behind our timeless jewellery pieces. Each design tells a story of elegance and tradition.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'EXPLORE NOW','/products',3,1,'2026-04-03 10:44:00','2026-04-03 10:44:00'),(5,2,'layout_1','TEMPLE COLLECTION','Divine','Sacred designs for the modern soul.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SHOP NOW','#',1,1,'2026-04-03 10:44:00','2026-04-03 10:44:00'),(6,2,'layout_4','MINIMALIST LUXE','Signature','Understated elegance for everyday wear.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'DISCOVER','#',2,1,'2026-04-03 10:44:00','2026-04-03 10:44:00'),(7,1,'layout_3','Kanchi','Sarees','Description','experiences/CTghDXaOa45284SxFZrgS9UMhIvfr9wziTohjwRN.png',NULL,'experiences/uDkjIAWHI2W6Mf3I9nyAq9i0yiHPA827hjv2DGjY.png',NULL,'experiences/2VEnlWKlioYNjC4bG0GAV0Ud5cGMr8kYB0ioNhvm.png',NULL,'experiences/4HE4dY4W7ZFFzdgpq99T9mxe3qwRHUd2sed5rGQE.png',NULL,'SHOP NOW','https://twosample.online/products?category=sarees',0,1,'2026-04-03 10:57:11','2026-04-03 10:57:11');
/*!40000 ALTER TABLE `brand_experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'AVNEE Studio','avnee-studio',1,'2026-03-27 04:08:09','2026-03-27 04:08:09'),(2,'AVNEE Jewellery','avnee-jewellery',1,'2026-03-27 04:08:09','2026-03-27 04:08:09');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
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
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
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
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned DEFAULT NULL,
  `combo_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  KEY `cart_items_variant_id_foreign` (`variant_id`),
  KEY `cart_items_combo_id_foreign` (`combo_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_combo_id_foreign` FOREIGN KEY (`combo_id`) REFERENCES `combos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (1,3,5,5,NULL,1,309.38,'2026-03-31 08:18:59','2026-03-31 08:18:59'),(3,5,6,NULL,NULL,1,599.00,'2026-04-04 13:43:31','2026-04-04 13:43:50'),(4,8,6,NULL,NULL,2,599.00,'2026-04-06 11:58:00','2026-04-06 11:58:06');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_session_id_index` (`session_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,'84OIvEgasQrqewtu52NbQzbVqJgi83VNMWEDZDFi',NULL,'2026-03-27 12:11:59','2026-03-27 12:11:59'),(2,'2tHBTqiG0Yp1Ya5jNtc8YkmhD8cMIgcrPAko6tye',NULL,'2026-03-29 00:18:42','2026-03-29 00:18:42'),(3,'H3Zd7ddkC64XDlznrM4Z5vkCDs5wHPRh4Q4XAQZL',NULL,'2026-03-31 08:18:59','2026-03-31 08:18:59'),(4,NULL,4,'2026-03-31 08:22:01','2026-03-31 08:22:01'),(5,'sX1cBTbt0Nq0om80tBpZNfUNIUiBBNeNzpqXxwRn',NULL,'2026-04-04 13:43:31','2026-04-04 13:43:31'),(6,'D05V3aujZx8w1YlzuKND3Ara7IYkoG6mzpCDJT7R',NULL,'2026-04-05 01:23:10','2026-04-05 01:23:10'),(7,'iM1S0tWRRs6b7WbR5AeFghbHGyKCoZZ92OaLnQPs',NULL,'2026-04-05 22:33:32','2026-04-05 22:33:32'),(8,'I0d4rfLsmCTbdR7fFTwwbl2Ho4Z8k1kMVNcN7sGZ',NULL,'2026-04-06 11:58:00','2026-04-06 11:58:00');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `show_in_menu` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_site_header` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_brand_id_foreign` (`brand_id`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,1,NULL,'new arrivals','Flowing silhouettes and intricate embroideries.','new-arrivals',NULL,1,1,1,1,'2026-03-27 04:08:09','2026-03-31 05:49:12'),(2,1,NULL,'Sarees','Six yards of pure elegance.','sarees',NULL,2,1,1,1,'2026-03-27 04:08:09','2026-03-28 14:31:32'),(3,1,NULL,'best sellers','The perfect festive attire.','best-sellers',NULL,3,1,1,1,'2026-03-27 04:08:09','2026-03-31 05:50:58'),(4,1,NULL,'bogo','Modern styles with an ethnic touch.','bogo',NULL,4,1,1,1,'2026-03-27 04:08:09','2026-03-31 05:51:14'),(5,2,NULL,'new arrivals','Statement pieces for your neckline.','avnee-jewellery-new-arrivals',NULL,1,1,1,1,'2026-03-27 04:08:09','2026-04-03 18:15:42'),(6,2,NULL,'JEWELLERY','Dangling beauties and elegant studs.','avnee-jewellery-jewellery',NULL,2,1,1,1,'2026-03-27 04:08:09','2026-04-03 18:15:11'),(7,2,NULL,'ORGANIZERS','Adorn your wrists with gold and gems.','organizers',NULL,3,1,1,1,'2026-03-27 04:08:09','2026-03-31 05:56:38'),(8,2,NULL,'GIFTING','Complete sets for your special day.','gifting',NULL,4,1,1,1,'2026-03-27 04:08:09','2026-03-31 05:56:53'),(11,1,NULL,'kids',NULL,'kids',NULL,5,1,1,1,'2026-03-31 05:51:41','2026-03-31 05:53:03'),(12,1,NULL,'jewellery',NULL,'jewellery',NULL,6,1,1,1,'2026-03-31 05:53:39','2026-03-31 05:53:39'),(13,1,NULL,'accessories',NULL,'accessories',NULL,7,1,1,1,'2026-03-31 05:53:57','2026-03-31 05:53:57'),(14,1,NULL,'Fun Anklets',NULL,'fun-anklets',NULL,8,1,1,1,'2026-03-31 05:54:17','2026-03-31 05:54:17'),(15,2,NULL,'HAIR ACCESSORIES',NULL,'hair-accessories',NULL,5,1,1,1,'2026-03-31 06:05:00','2026-03-31 06:05:00'),(16,2,NULL,'TRINKETS',NULL,'trinkets',NULL,6,1,1,1,'2026-03-31 06:05:20','2026-03-31 06:05:20'),(17,1,2,'new saree',NULL,'new-saree',NULL,0,1,0,0,'2026-03-31 06:14:52','2026-03-31 06:14:52');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combo_products`
--

DROP TABLE IF EXISTS `combo_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `combo_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `combo_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `combo_products_combo_id_foreign` (`combo_id`),
  KEY `combo_products_product_id_foreign` (`product_id`),
  CONSTRAINT `combo_products_combo_id_foreign` FOREIGN KEY (`combo_id`) REFERENCES `combos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `combo_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combo_products`
--

LOCK TABLES `combo_products` WRITE;
/*!40000 ALTER TABLE `combo_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `combo_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combos`
--

DROP TABLE IF EXISTS `combos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `combos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) NOT NULL,
  `original_price` decimal(12,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `combos_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combos`
--

LOCK TABLES `combos` WRITE;
/*!40000 ALTER TABLE `combos` DISABLE KEYS */;
/*!40000 ALTER TABLE `combos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `reward` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `max_discount` decimal(10,2) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
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
-- Table structure for table `flash_sale_products`
--

DROP TABLE IF EXISTS `flash_sale_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flash_sale_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `flash_sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `discount_percentage` int DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flash_sale_products_flash_sale_id_foreign` (`flash_sale_id`),
  KEY `flash_sale_products_product_id_foreign` (`product_id`),
  CONSTRAINT `flash_sale_products_flash_sale_id_foreign` FOREIGN KEY (`flash_sale_id`) REFERENCES `flash_sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `flash_sale_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flash_sale_products`
--

LOCK TABLES `flash_sale_products` WRITE;
/*!40000 ALTER TABLE `flash_sale_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `flash_sale_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flash_sales`
--

DROP TABLE IF EXISTS `flash_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flash_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `flash_sales_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flash_sales`
--

LOCK TABLES `flash_sales` WRITE;
/*!40000 ALTER TABLE `flash_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `flash_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_explore_grids`
--

DROP TABLE IF EXISTS `home_explore_grids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_explore_grids` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL DEFAULT '1',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_span` int NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_explore_grids`
--

LOCK TABLES `home_explore_grids` WRITE;
/*!40000 ALTER TABLE `home_explore_grids` DISABLE KEYS */;
INSERT INTO `home_explore_grids` VALUES (1,1,'Jewellery Edit','All That Jewels You Must Own','products/FqWSykn1sKp5OyvpzEyen5aiDAfRauAa0Bbq1DbT.png','/products',2,1,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(2,1,'Earrings Edit','Jhumkas | Chandbalis | Studs','products/xzOE71cNLOnLrK20y5fUJCHFbYTxRhEMhDwhFTBe.png','/products',2,2,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(3,1,'Organizers Edit','Keep Your Precious Jewels Organized','products/CnqurpRSDhr4Bq6JXOuotyuRpfripujdECT13rhI.png','/products',1,3,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(4,1,'Organizers Edit','Shop Now - Shop To Organized','products/cIAVCIP65CEMkcVvuTkdZz1s1sHbq6bNmpSsOXYf.png','/products',1,4,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(5,1,'Hair Accessories Edit','Elegant Pieces To Adorn Your Locks','products/FjojpIyCx8DOf9x0aYDO1Fih48a0UyrFUVIsiTq4.png','/products',2,5,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(6,2,'The Gold Ritual','Handcrafted Heritage Pieces','products/default.jpg','/jewellery',2,1,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(7,2,'Diamond Archive','The Brilliance of Bespoke Craft','products/default.jpg','/jewellery',2,2,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(8,2,'Celestial Rings','For Eternal Unions','products/default.jpg','/jewellery',1,3,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(9,2,'Temple Protocol','Sacred Adornments for the Soul','products/default.jpg','/jewellery',1,4,1,'2026-04-03 18:18:33','2026-04-03 18:18:33'),(10,2,'Jewellery Restoration','Preserve Your Family Archive','products/default.jpg','/jewellery',2,5,1,'2026-04-03 18:18:33','2026-04-03 18:18:33');
/*!40000 ALTER TABLE `home_explore_grids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_sections`
--

DROP TABLE IF EXISTS `home_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned DEFAULT NULL,
  `section_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_ids` json DEFAULT NULL,
  `limit` int NOT NULL DEFAULT '8',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `home_sections_brand_id_section_id_unique` (`brand_id`,`section_id`),
  CONSTRAINT `home_sections_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_sections`
--

LOCK TABLES `home_sections` WRITE;
/*!40000 ALTER TABLE `home_sections` DISABLE KEYS */;
INSERT INTO `home_sections` VALUES (3,1,'best_buys','Best Buys','Popular Pieces',NULL,NULL,'[\"5\", \"6\", \"7\", \"8\", \"9\"]',10,1,20,'2026-03-27 09:21:43','2026-04-01 05:50:53'),(4,1,'shop_the_look','Shop The Look','Complete Your Style',NULL,NULL,'[\"5\", \"6\", \"7\", \"8\", \"9\"]',10,1,30,'2026-03-27 09:21:43','2026-04-01 05:51:03'),(5,1,'top_collections','Top Collections','Trending Now',NULL,NULL,'[\"5\", \"6\", \"7\", \"8\", \"9\"]',8,1,40,'2026-03-27 09:21:43','2026-04-01 05:51:11'),(10,2,'best_buys_jewellery','Best Buys',NULL,NULL,NULL,NULL,8,1,20,'2026-03-27 09:52:41','2026-03-27 11:04:24'),(11,2,'shop_the_look_jewellery','Shop The Look',NULL,NULL,NULL,NULL,8,1,30,'2026-03-27 09:52:41','2026-03-27 11:04:24'),(12,2,'top_collections_jewellery','Top Collections',NULL,NULL,NULL,NULL,8,1,40,'2026-03-27 09:52:41','2026-03-27 11:04:24'),(13,1,'popular_pieces','Bestselling Styles',NULL,NULL,NULL,'[\"5\", \"6\", \"7\", \"8\", \"9\"]',8,1,50,'2026-03-27 10:55:40','2026-04-01 05:51:19'),(14,2,'popular_pieces_jewellery','Bestselling Styles',NULL,NULL,NULL,NULL,8,1,50,'2026-03-27 10:55:40','2026-03-27 11:04:24'),(19,1,'just_in','Just In','Latest Arrivals',NULL,NULL,NULL,2,1,1,'2026-04-01 05:14:21','2026-04-01 05:14:21'),(20,1,'shop_by_price','Shop By Price','Affordable Fashion',NULL,NULL,NULL,6,1,10,'2026-04-01 05:14:21','2026-04-01 05:14:21'),(21,2,'just_in_jewellery','New Jewels','Precious Moments',NULL,NULL,NULL,2,1,1,'2026-04-01 05:14:21','2026-04-01 05:14:21'),(22,2,'shop_by_price_jewellery','Shop By Range','Sparkle for Less',NULL,NULL,NULL,6,1,10,'2026-04-01 05:14:21','2026-04-01 05:14:21'),(23,1,'shop_by_style','Shop By Style','Curate Your Look',NULL,NULL,NULL,8,1,15,'2026-04-03 10:06:08','2026-04-03 10:06:08'),(24,2,'shop_by_style','Shop By Style','Exquisite Designs',NULL,NULL,NULL,8,1,15,'2026-04-03 10:06:08','2026-04-03 10:06:08');
/*!40000 ALTER TABLE `home_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_styles`
--

DROP TABLE IF EXISTS `home_styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_styles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `home_styles_brand_id_foreign` (`brand_id`),
  CONSTRAINT `home_styles_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_styles`
--

LOCK TABLES `home_styles` WRITE;
/*!40000 ALTER TABLE `home_styles` DISABLE KEYS */;
INSERT INTO `home_styles` VALUES (1,1,'Infant Sets','home_styles/gwEVjiKKkjDc6MhNNd4yo3jNGbTCb0gBff3ruC4N.png','/products?category=bogo',1,1,'2026-04-03 10:02:37','2026-04-03 10:02:37'),(2,1,'Silk Sarees','home_styles/VVS8EN1j0goepyX9ZJLwu4qoTcvLV9A5TNAuYCt7.png','/products?category=sarees',1,1,'2026-04-03 10:06:50','2026-04-03 10:07:56'),(3,1,'Floral Sets','home_styles/6vJ927hpQUENCBqE3XgVzxbiOrKwFvVCKCbKO7Uu.png','/products?category=sets',2,1,'2026-04-03 10:06:50','2026-04-03 10:09:22'),(4,2,'Kundan Sets','styles/kundan.jpg','/products?category=kundan',1,1,'2026-04-03 10:06:50','2026-04-03 10:06:50'),(5,2,'Temple Jewellery','styles/temple.jpg','/products?category=temple',2,1,'2026-04-03 10:06:50','2026-04-03 10:06:50');
/*!40000 ALTER TABLE `home_styles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jewellery_experience_settings`
--

DROP TABLE IF EXISTS `jewellery_experience_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jewellery_experience_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ARTISANAL CRAFT',
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'The Heritage',
  `description` text COLLATE utf8mb4_unicode_ci,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EXPLORE NOW',
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/products',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jewellery_experience_settings`
--

LOCK TABLES `jewellery_experience_settings` WRITE;
/*!40000 ALTER TABLE `jewellery_experience_settings` DISABLE KEYS */;
INSERT INTO `jewellery_experience_settings` VALUES (1,'ARTISANAL CRAFT','The Heritage','Discover the meticulous craftsmanship behind our timeless jewellery pieces. Each design tells a story of elegance and tradition.',NULL,NULL,NULL,NULL,NULL,'EXPLORE NOW','/products',1,'2026-03-27 10:31:47','2026-03-27 10:31:47');
/*!40000 ALTER TABLE `jewellery_experience_settings` ENABLE KEYS */;
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
-- Table structure for table `just_in_experiences`
--

DROP TABLE IF EXISTS `just_in_experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `just_in_experiences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Explore Now',
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `just_in_experiences_brand_id_foreign` (`brand_id`),
  CONSTRAINT `just_in_experiences_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `just_in_experiences`
--

LOCK TABLES `just_in_experiences` WRITE;
/*!40000 ALTER TABLE `just_in_experiences` DISABLE KEYS */;
INSERT INTO `just_in_experiences` VALUES (1,1,'Party Frocks',NULL,'just_in_experiences/wNkuHpcrDRcE9mJ82rCGA3q5nlA74GRTZcJEa6bj.jpg','Shop Now','https://twosample.online/products?category=kids',1,1,'2026-03-27 11:33:03','2026-04-01 08:04:56'),(2,1,'Festive Wear',NULL,'just_in_experiences/NPtmYSz1T1z4Th5Du7KtcWfOFEZWLBwDemB6PDUy.jpg','Shop Now','https://twosample.online/products?category=kids',2,1,'2026-03-27 11:51:43','2026-04-01 08:05:07');
/*!40000 ALTER TABLE `just_in_experiences` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_23_075855_create_brands_table',1),(5,'2026_03_23_075856_create_categories_table',1),(6,'2026_03_23_075857_create_products_table',1),(7,'2026_03_23_075858_create_product_images_table',1),(8,'2026_03_23_075858_create_product_variants_table',1),(9,'2026_03_23_075859_create_settings_table',1),(10,'2026_03_23_084119_create_carts_table',1),(11,'2026_03_23_084120_create_cart_items_table',1),(12,'2026_03_23_084121_create_wishlists_table',1),(13,'2026_03_23_084125_create_orders_table',1),(14,'2026_03_23_084126_create_order_items_table',1),(15,'2026_03_23_085726_create_banners_table',1),(16,'2026_03_23_093017_add_return_fields_to_orders_table',1),(17,'2026_03_23_093434_create_reviews_table',1),(18,'2026_03_23_093928_create_coupons_table',1),(19,'2026_03_23_093929_add_coupon_code_to_orders_table',1),(20,'2026_03_23_103407_create_flash_sales_table',1),(21,'2026_03_23_103518_create_flash_sale_products_table',1),(22,'2026_03_23_104742_create_combos_table',1),(23,'2026_03_23_104753_create_combo_products_table',1),(24,'2026_03_23_105548_add_type_to_banners_table',1),(25,'2026_03_23_105751_add_combo_id_to_cart_items_table',1),(26,'2026_03_23_105833_add_combo_id_to_order_items_table',1),(27,'2026_03_23_115129_add_verified_and_reply_to_reviews_table',1),(28,'2026_03_23_115824_create_blog_categories_table',1),(29,'2026_03_23_115825_create_blog_posts_table',1),(30,'2026_03_23_121008_create_pages_table',1),(31,'2026_03_23_132744_add_image_to_products_table',1),(32,'2026_03_23_195217_add_show_in_menu_and_description_to_categories_table',1),(33,'2026_03_23_195243_add_columns_to_categories_table',1),(34,'2026_03_25_110215_add_subcategory_id_to_products_table',1),(35,'2026_03_27_091532_create_home_sections_table',2),(36,'2026_03_27_092631_add_video_to_products_table',3),(37,'2026_03_27_093827_add_brand_id_to_home_sections',4),(38,'2026_03_27_095847_create_shop_by_price_bands_table',5),(39,'2026_03_27_100442_create_saree_edit_settings_table',6),(40,'2026_03_27_102921_create_jewellery_experience_settings_table',7),(41,'2026_03_27_104314_create_just_in_experiences_table',8),(42,'2026_03_27_120641_add_price_and_discount_to_products_table',9),(43,'2026_03_27_123548_create_contact_messages_table',10),(44,'2026_03_27_151743_add_show_in_site_header_to_categories_table',11),(45,'2026_03_27_153458_add_shiprocket_fields_to_orders_table',12),(46,'2026_03_27_155216_create_newsletter_subscribers_table',12),(47,'2026_03_31_043325_add_main_video_to_experience_settings_tables',13),(48,'2026_03_31_044527_add_user_name_to_reviews_table',14),(49,'2026_03_31_044931_add_brand_id_to_reviews_table',15),(50,'2026_03_31_045232_change_review_status_default',16),(51,'2026_03_31_131007_change_home_sections_unique_constraint',17),(52,'2026_04_01_055743_add_image_and_location_to_reviews_table',18),(53,'2026_04_03_054754_create_home_styles_table',19),(54,'2026_04_03_102606_create_brand_experiences_table',20),(55,'2026_04_03_175954_add_is_on_home_to_blog_posts_table',21),(56,'2026_04_03_181217_create_home_explore_grids_table',22);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `variant_id` bigint unsigned DEFAULT NULL,
  `combo_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_variant_id_foreign` (`variant_id`),
  KEY `order_items_combo_id_foreign` (`combo_id`),
  CONSTRAINT `order_items_combo_id_foreign` FOREIGN KEY (`combo_id`) REFERENCES `combos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,5,NULL,NULL,'Classic Peach Layered Frock',NULL,1,499.00,499.00,'2026-03-31 08:43:19','2026-03-31 08:43:19'),(2,2,5,NULL,NULL,'Classic Peach Layered Frock',NULL,1,499.00,499.00,'2026-03-31 08:43:52','2026-03-31 08:43:52');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `razorpay_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shiprocket_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shiprocket_shipment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `billing_address` text COLLATE utf8mb4_unicode_ci,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `return_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_reason` text COLLATE utf8mb4_unicode_ci,
  `return_notes` text COLLATE utf8mb4_unicode_ci,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_session_id_index` (`session_id`),
  KEY `orders_return_status_index` (`return_status`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'ORD-CUPHXAXVCX',4,NULL,'pending','razorpay','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,499.00,0.00,NULL,0.00,499.00,'{\"first_name\":\"Admin\",\"last_name\":\"kumar\",\"address\":\"1-62, Gomptalli Street, Boddavaram Village, Kottananduru Mandal, Kakinada District\",\"apartment\":null,\"city\":\"Tuni\",\"state\":\"Andhra Pradesh\",\"pincode\":\"533401\",\"country\":\"India\"}','{\"first_name\":\"Admin\",\"last_name\":\"kumar\",\"address\":\"1-62, Gomptalli Street, Boddavaram Village, Kottananduru Mandal, Kakinada District\",\"apartment\":null,\"city\":\"Tuni\",\"state\":\"Andhra Pradesh\",\"pincode\":\"533401\",\"country\":\"India\"}','admin@avnee.com','09866139213',NULL,'2026-03-31 08:43:19','2026-03-31 08:43:19',NULL,NULL,NULL,NULL),(2,'ORD-HLRZIDRKB2',4,NULL,'processing','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,499.00,0.00,NULL,0.00,499.00,'{\"first_name\":\"Admin\",\"last_name\":\"kumar\",\"address\":\"1-62, Gomptalli Street, Boddavaram Village, Kottananduru Mandal, Kakinada District\",\"apartment\":null,\"city\":\"Tuni\",\"state\":\"Andhra Pradesh\",\"pincode\":\"533401\",\"country\":\"India\"}','{\"first_name\":\"Admin\",\"last_name\":\"kumar\",\"address\":\"1-62, Gomptalli Street, Boddavaram Village, Kottananduru Mandal, Kakinada District\",\"apartment\":null,\"city\":\"Tuni\",\"state\":\"Andhra Pradesh\",\"pincode\":\"533401\",\"country\":\"India\"}','admin@avnee.com','09866139213',NULL,'2026-03-31 08:43:52','2026-03-31 08:43:52',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Terms Of Service','terms-of-service','<h3>TERMS OF SERVICE – AVNEE COLLECTIONS</h3><p>Welcome to Avnee Collections.<br>By accessing or using our website, you agree to comply with and be bound by the following Terms of Service. Please read them carefully before making a purchase.</p><hr><h4>1. Overview</h4><p>Avnee Collections is a lifestyle brand offering curated <strong>kidswear (0–12 years)</strong>, <strong>jewelry</strong> for women and mothers, <strong>sarees</strong>, <strong>accessories</strong>, and playful trinkets.<br>By using our platform, you agree to these Terms along with our related policies (Returns, Shipping, Privacy).</p><hr><h4>2. Eligibility</h4><ul><li>You must be at least <strong>18 years old</strong> to make a purchase</li><li>If under 18, purchases must be made under <strong>parental or guardian supervision</strong></li></ul><hr><h4>3. Products & Representation</h4><p>We strive to present all products as accurately as possible. However:</p><ul><li><strong>Colors may vary slightly</strong> due to lighting or screens</li><li><strong>Fabric textures, prints, and handcrafted details</strong> may have natural variations</li><li><strong>Jewelry finishes may vary slightly</strong> due to design and wear nature</li></ul><p>These are <strong>not considered defects</strong>.</p><hr><h4>4. Pricing & Payments</h4><ul><li>All prices are listed in <strong>INR (₹)</strong></li><li>Prices are subject to change <strong>without prior notice</strong></li><li>Orders are confirmed only after <strong>successful payment</strong></li></ul><p>In case of pricing or technical errors, we reserve the right to <strong>cancel or correct the order</strong>.</p><hr><h4>5. Order Acceptance & Cancellation</h4><ul><li>Placing an order is an <strong>offer to purchase</strong></li><li>Order is confirmed only <strong>after dispatch</strong></li></ul><p>We may cancel orders due to:</p><ul><li>Stock unavailability</li><li>Incorrect pricing or product information</li><li>Payment or fraud concerns</li></ul><p>Refunds (if applicable) will be processed to the original payment method.</p><hr><h4>6. Shipping & Delivery</h4><ul><li>Delivery timelines are <strong>estimates</strong> and may vary</li><li>Delays due to logistics partners, weather, or unforeseen circumstances are <strong>beyond our control</strong></li><li><strong>Risk of loss</strong> transfers to the customer upon dispatch</li></ul><hr><h4>7. Returns & Exchanges</h4><p>Returns/exchanges are accepted only if:</p><ul><li>Product is <strong>unused</strong></li><li>Original <strong>tags and packaging</strong> are intact</li><li>Request is raised within the <strong>return window</strong></li></ul><p><strong>Non-returnable items</strong> may include:</p><ul><li>Jewelry (for hygiene reasons)</li><li>Customized or sale items</li></ul><p>Avnee Collections reserves the right to <strong>reject returns</strong> that do not meet conditions.</p><hr><h4>8. Jewelry Care Disclaimer</h4><p>Our jewelry is designed for everyday elegance and comfort, including <strong>anti-tarnish styles</strong>. However:</p><ul><li>Longevity depends on <strong>usage and care</strong></li><li>Avoid exposure to <strong>water, perfumes, and chemicals</strong></li><li>Natural wear over time is <strong>not considered a defect</strong></li></ul><hr><h4>9. User Responsibilities</h4><p>You agree to:</p><ul><li>Provide <strong>accurate and complete information</strong></li><li>Maintain <strong>confidentiality</strong> of your account</li><li>Use the platform for <strong>lawful purposes only</strong></li></ul><p>You <strong>must not</strong>:</p><ul><li>Misuse the website</li><li>Attempt unauthorized access</li><li>Upload harmful, illegal, or inappropriate content</li></ul><hr><h4>10. Intellectual Property</h4><p>All content on this website — including images, designs, branding, text, and graphics — is <strong>owned by Avnee Collections</strong>.<br>You may <strong>not copy, reproduce, or use</strong> any content without prior permission.</p><hr><h4>11. Reviews & Feedback</h4><p>Any feedback, reviews, or content shared by you:</p><ul><li>May be used by Avnee Collections for marketing or improvement</li><li>Should <strong>not be unlawful</strong>, offensive, or misleading</li></ul><hr><h4>12. Limitation of Liability</h4><p>Avnee Collections shall not be liable for:</p><ul><li>Indirect or incidental damages</li><li>Delays in delivery beyond our control</li><li>Minor variations in product appearance</li></ul><p>Maximum liability shall <strong>not exceed the value of the product purchased</strong>.</p><hr><h4>13. Force Majeure</h4><p>We are not responsible for delays or failure in performance due to events <strong>beyond our control</strong>, including but not limited to: natural disasters, strikes, transportation disruptions, or government restrictions.</p><hr><h4>14. Privacy</h4><p>Your personal information is handled <strong>securely</strong> and used only to enhance your shopping experience. Please refer to our Privacy Policy for details.</p><hr><h4>15. Changes to Terms</h4><p>We reserve the right to <strong>update these Terms at any time</strong>. Continued use of the website implies acceptance of updated terms.</p><hr><h4>16. Governing Law</h4><p>These Terms are governed by the <strong>laws of India</strong>. Any disputes shall be subject to jurisdiction of courts in India.</p><hr><h4>17. Contact</h4><p><strong>Avnee Collections</strong><br>Email: <strong>studio@avneecollections.com</strong> &amp; <strong>avnee.collections@gmail.com</strong></p>',NULL,NULL,1,'2026-03-27 13:41:10','2026-03-27 14:19:19'),(2,'Privacy Policy','privacy-policy','<h3>PRIVACY POLICY – AVNEE COLLECTIONS</h3><p>At Avnee Collections, your privacy matters to us. We are committed to protecting your personal information and ensuring a <strong>safe shopping experience</strong>.</p><hr><h4>1. Information We Collect</h4><ul><li><strong>Name</strong></li><li><strong>Email address</strong></li><li><strong>Phone number</strong></li><li><strong>Shipping &amp; billing address</strong></li><li><strong>Payment details</strong> (processed securely via payment gateways)</li><li><strong>Order history and preferences</strong></li></ul><p>We may also collect basic <strong>technical data</strong> such as <strong>IP address</strong>, <strong>browser type</strong>, and <strong>device information</strong>.</p><hr><h4>2. How We Use Your Information</h4><ul><li><strong>Process and deliver your orders</strong></li><li><strong>Communicate updates</strong>, offers, and support</li><li><strong>Improve our website</strong> and services</li><li><strong>Personalize your shopping experience</strong></li><li><strong>Ensure secure transactions</strong> and prevent fraud</li></ul><hr><h4>3. Sharing of Information</h4><p>We <strong>do not sell your personal data</strong>. Your information may be shared only with <strong>trusted partners</strong> such as: <strong>Payment gateways</strong>, <strong>Shipping and logistics providers</strong>, and <strong>Technology and support services</strong>.</p><hr><h4>4. Cookies &amp; Tracking</h4><p>We use cookies to: Enhance your browsing experience, remember preferences, and analyze performance. You can choose to <strong>disable cookies</strong> in your browser settings.</p><hr><h4>5. Data Security</h4><p>We take <strong>reasonable steps</strong> to protect your personal data from unauthorized access, misuse, or loss.</p><hr><h4>6. Your Rights</h4><ul><li><strong>Access or update</strong> your personal information</li><li><strong>Request deletion</strong> of your data</li><li><strong>Opt out</strong> of marketing communications</li></ul><hr><h4>7. Children’s Privacy</h4><p>Purchases must be made by parents or guardians. We do not knowingly collect personal data from children under 13.</p><hr><h4>8. Data Retention</h4><p>We retain your information only as long as necessary to fulfill orders, comply with legal obligations, and improve customer experience.</p><hr><h4>9. Legal Compliance</h4><p>This Privacy Policy is governed by applicable <strong>Indian laws</strong>, including: <strong>Information Technology Act, 2000</strong> and <strong>SPDI Rules, 2011</strong>.</p><hr><h4>10. Business Information</h4><p><strong>Avnee Collections</strong><br><strong>GSTIN: 29BDKPR6215G1Z8</strong></p><hr><h4>11. Updates to Policy</h4><p>We may update this policy from time to time. Changes will be posted on this page.</p><hr><h4>12. Contact Us</h4><p>📧 Email: <strong>studio@avneecollections.com</strong> &amp; <strong>avnee.collections@gmail.com</strong><br>📞 Phone: <strong>+91 9008671144</strong></p>',NULL,NULL,1,'2026-03-27 13:41:10','2026-03-27 14:21:39'),(3,'Return Exchange Policy','return-exchange-policy','<h3>RETURN &amp; EXCHANGE POLICY – AVNEE COLLECTIONS</h3><p>At Avnee Collections, every piece is thoughtfully curated and quality-checked before dispatch. As a small, growing brand, we follow a strict return policy to ensure fairness and product integrity.</p><hr><h4>1. Return Window</h4><ul><li>Returns must be requested within <strong>3 days of delivery</strong></li></ul><hr><h4>2. Mandatory Unboxing Video (VERY IMPORTANT)</h4><p>To be eligible for any return:</p><ul><li>A clear <strong>360° unboxing video</strong> is mandatory</li><li>The video must show:<ul><li><strong>Sealed package</strong> before opening</li><li>Full unboxing process</li><li>Product condition clearly</li></ul></li></ul><p>❌ <strong>Without this video, no return or claim will be accepted</strong></p><hr><h4>3. Return Eligibility</h4><p>Returns are accepted only if the product is: <strong>Damaged</strong>, <strong>Defective</strong>, or <strong>Incorrect item received</strong>.</p><hr><h4>4. Product Condition Requirements</h4><ul><li>Product must be <strong>unused</strong></li><li>All <strong>original tags must be intact</strong> (especially jewelry tags)</li><li>Product must be returned in <strong>original packaging</strong></li></ul><p>❌ <strong>If tags are removed</strong> (including jewelry tags), return will not be accepted</p><hr><h4>5. Non-Returnable Items</h4><p>The following are <strong>not eligible for return</strong>:</p><ul><li><strong>Jewelry (without tags)</strong></li><li><strong>Accessories &amp; trinkets</strong> (unless non-working/damaged validated by opening video)</li><li><strong>Customized / made-to-order products</strong></li><li><strong>Sale / discounted items</strong></li></ul><hr><h4>6. Size &amp; Preference</h4><p>We <strong>currently do not accept returns</strong> for: Size issues, Change of mind, or Styling preference. Please check size charts carefully before ordering.</p><hr><h4>7. Return Process</h4><p>We do not offer automated return requests on the website at this stage. To request a return:</p><p>📩 Email: <strong>studio@avneecollections.com</strong><br>📩 Alternate: <strong>avnee.collections@gmail.com</strong><br>📞 Phone/WhatsApp: <strong>+91 908671144</strong></p><p>Include: <strong>Order ID</strong>, <strong>Issue details</strong>, and <strong>360° unboxing video</strong>. Our team will review and respond within 24–48 hours.</p><hr><h4>8. Approval &amp; Pickup</h4><ul><li>Returns are subject to <strong>approval</strong></li><li>If approved, pickup instructions will be shared</li><li>A <strong>quality check</strong> will be done before refund</li></ul><hr><h4>9. Return Charges</h4><ul><li>A <strong>₹149 return handling fee</strong> may be applicable</li><li>Shipping charges are <strong>non-refundable</strong></li></ul><hr><h4>10. Refund Policy</h4><p>Refund is processed only after product passes quality check. Refund will be issued as:</p><ul><li><strong>Store credit (preferred)</strong> or</li><li><strong>Original payment method</strong> (case-to-case)</li></ul><p>Timeline: <strong>5 - 7 working days</strong></p><hr><h4>11. Cancellation Policy</h4><ul><li>Orders can be cancelled only <strong>before dispatch</strong></li><li>Once shipped, cancellation is <strong>not possible</strong></li></ul><hr><p>💛 <strong>A Note From Us</strong><br>AVNEE is built with love and care - every product is chosen to bring joy to little ones and confidence to women. This policy helps us maintain quality, fairness, and sustainability as we grow.</p>',NULL,NULL,1,'2026-03-27 13:41:10','2026-03-27 14:23:00'),(4,'Shipping Policy','shipping-policy','<h3>SHIPPING POLICY – AVNEE COLLECTIONS</h3><p>At Avnee Collections, we aim to deliver your orders safely and smoothly.</p><hr><h4>1. Shipping Coverage</h4><ul><li>We currently deliver <strong>across India</strong></li><li>International shipping may be available on request</li></ul><hr><h4>2. Shipping Charges</h4><ul><li><strong>Free shipping on orders above ₹1499</strong></li><li>For orders below ₹1499, shipping charges range between:<ul><li>👉 <strong>₹50 – ₹150</strong> (based on location &amp; weight)</li></ul></li></ul><hr><h4>3. Cash on Delivery (COD)</h4><ul><li>COD is available in <strong>selected locations</strong></li><li>Available for orders <strong>up to ₹10,000</strong></li></ul><hr><h4>4. Order Processing &amp; Delivery Time</h4><ul><li>Orders are usually dispatched within <strong>1–3 working days</strong></li><li>Delivery timelines:<ul><li><strong>Metro cities: 2–4 days</strong></li><li><strong>Other locations: 3–6 days</strong></li></ul></li></ul><p>Delivery timelines may vary depending on location and courier service.</p><hr><h4>5. Order Tracking</h4><ul><li>Once shipped, you will receive tracking details via <strong>SMS/Email</strong></li><li>You can track your order through the <strong>courier partner link</strong></li></ul><hr><h4>6. Shipping Partners</h4><p>We work with <strong>trusted delivery partners</strong> to ensure safe and timely delivery.</p><hr><h4>7. Delivery Responsibility</h4><ul><li>Once dispatched, the order is handled by our courier partners</li><li>We request your patience for delays due to <strong>logistics, weather, or external factors</strong></li></ul><hr><h4>8. Damaged or Tampered Packages</h4><ul><li>Please record a <strong>360° unboxing video</strong> while opening your package</li><li>If the package appears damaged:<ul><li><strong>Do not accept it</strong> (if possible), or</li><li><strong>Contact us immediately</strong></li></ul></li></ul><p>Without proper proof, we may not be able to process claims.</p><hr><h4>9. Incorrect Address</h4><p>Please ensure your address and contact details are <strong>correct</strong>. We are not responsible for delays or failed deliveries due to <strong>incorrect information</strong>.</p><hr><h4>10. International Orders (If Applicable)</h4><p>Customers are responsible for any <strong>custom duties, import taxes, or local charges</strong> applicable in their country.</p><hr><p>💛 <strong>A Note From Us</strong><br>Every order from Avnee Collections is packed with care and love. We truly appreciate your trust and patience as we bring these little pieces of joy to your doorstep.</p>',NULL,NULL,1,'2026-03-27 13:41:10','2026-03-27 14:24:37'),(5,'Faqs','faqs','<h3>FREQUENTLY ASKED QUESTIONS (FAQs)</h3>\r\n<hr>\r\n\r\n<h3>🛍️ About Avnee Collections</h3>\r\n<p><strong>What is Avnee Collections?</strong><br>\r\nAvnee Collections is a curated brand offering stylish and comfortable kidswear (0–12 years) along with jewelry, accessories, sarees, and fun trinkets designed to add joy to everyday moments.</p>\r\n<hr>\r\n\r\n<h3>📏 Size & Fit</h3>\r\n<p><strong>How do I choose the right size?</strong><br>\r\nPlease refer to the size chart available on each product page. If you need help, feel free to contact us.</p>\r\n<hr>\r\n\r\n<p><strong>Do you offer customization?</strong><br>\r\nNo, we currently do not offer customization.</p>\r\n<hr>\r\n\r\n<p><strong>What if the outfit doesn’t fit?</strong><br>\r\nWe recommend checking the size chart carefully before ordering. Returns are not accepted for size-related issues.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>📦 Orders & Delivery</h3>\r\n<p><strong>How do I place an order?</strong><br>\r\nSelect your product, choose the size (if applicable), and proceed to checkout.</p>\r\n<hr>\r\n\r\n<p><strong>How can I track my order?</strong><br>\r\nOnce your order is shipped, you will receive tracking details via SMS or email.</p>\r\n<hr>\r\n\r\n<p><strong>How long does delivery take?</strong><br>\r\n• Metro cities: 2–4 days<br>\r\n• Other locations: 3–6 days</p>\r\n<hr>\r\n\r\n<p><strong>Do you offer Cash on Delivery (COD)?</strong><br>\r\nYes, COD is available for orders up to ₹10,000 in selected locations.</p>\r\n<hr>\r\n\r\n<p><strong>What if I miss my delivery?</strong><br>\r\nThe courier will reattempt delivery. You can also contact the courier or reach out to us for assistance.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>💸 Payments</h3>\r\n<p><strong>What payment methods do you accept?</strong><br>\r\nWe accept UPI, Debit/Credit Cards, Net Banking, and COD.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>🔁 Returns & Cancellation</h3>\r\n<p><strong>Can I return or exchange my order?</strong><br>\r\nReturns are accepted only if the product is:<br>\r\n• Damaged<br>\r\n• Defective<br>\r\n• Incorrect</p>\r\n<hr>\r\n\r\n<p><strong>What is the return window?</strong><br>\r\nYou must request a return within 3 days of delivery.</p>\r\n<hr>\r\n\r\n<p><strong>What is required for a return?</strong><br>\r\nA 360° unboxing video is mandatory. Without this, returns cannot be processed.</p>\r\n<hr>\r\n\r\n<p><strong>Are all products eligible for return?</strong><br>\r\nNo. The following are not returnable:<br>\r\n• Jewelry (especially if tags are removed)<br>\r\n• Accessories & trinkets<br>\r\n• Sarees & stitched items<br>\r\n• Sale items</p>\r\n<hr>\r\n\r\n<p><strong>Can I cancel my order?</strong><br>\r\nOrders can be cancelled only before dispatch. Once shipped, cancellation is not possible.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>🚚 Shipping</h3>\r\n<p><strong>What are the shipping charges?</strong><br>\r\n• Free shipping on orders above ₹1499<br>\r\n• ₹50–₹150 for orders below ₹1499 (based on location & weight)</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>💎 Product & Quality</h3>\r\n<p><strong>Will I receive good quality products?</strong><br>\r\nYes 💛 Every product is carefully selected to ensure comfort, quality, and style.</p>\r\n<hr>\r\n\r\n<p><strong>Will the product look exactly like the images?</strong><br>\r\nSlight variations may occur due to lighting and screen differences.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>📞 Customer Support</h3>\r\n<p><strong>How can I contact you?</strong><br>\r\nWe’re always happy to help!<br>\r\n📧 studio@avneecollections.com<br>\r\n📧 avnee.collections@gmail.com<br>\r\n📞 908671144<br>\r\nWe usually respond within 24–48 hours</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>📦 Additional Queries</h3>\r\n<p><strong>Do you offer bulk orders?</strong><br>\r\nYes, for bulk inquiries please contact us directly.</p>\r\n<hr>\r\n\r\n<p><strong>Do you have a physical store?</strong><br>\r\nWe are currently an online-first brand based in Bangalore.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>💛 A Note From Us</h3>\r\n<p>Every piece at Avnee Collections is chosen with love — for little ones and for you. If you ever need help, we’re just a message away.</p>\r\n\r\n<div class=\"divider-long\"></div>\r\n\r\n<h3>⭐ POPULAR QUESTIONS</h3>\r\n<p><strong>1. Do you offer Cash on Delivery (COD)?</strong><br>\r\nYes, COD is available for orders up to ₹10,000 in selected locations.</p>\r\n<hr>\r\n\r\n<p><strong>2. What is your return policy?</strong><br>\r\nReturns are accepted only for damaged/incorrect items within 3 days, with a mandatory unboxing video.</p>\r\n<hr>\r\n\r\n<p><strong>3. How long does delivery take?</strong><br>\r\n2–4 days for metro cities and 3–6 days for other locations.</p>\r\n<hr>\r\n\r\n<p><strong>4. Is shipping free?</strong><br>\r\nYes, free shipping on orders above ₹1499. Otherwise ₹50–₹150.</p>\r\n<hr>\r\n\r\n<p><strong>5. What if the size doesn’t fit?</strong><br>\r\nWe recommend checking the size chart carefully. Returns are not accepted for size issues.</p>\r\n<hr>\r\n\r\n<p><strong>6. Will I receive the same product as shown?</strong><br>\r\nYes, though slight color variations may occur due to lighting.</p>\r\n<hr>\r\n\r\n<p><strong>7. Is jewelry safe for everyday wear?</strong><br>\r\nYes, many pieces are designed for everyday use. Avoid water/perfume for longer life.</p>\r\n<hr>\r\n<hr>\r\n\r\n<h3>🔄 RECENT QUESTIONS</h3>\r\n<hr>\r\n<p><strong>1. Can I change my order after placing it?</strong><br>\r\nYes, only before dispatch. Please contact us immediately.</p>\r\n<hr>\r\n\r\n<p><strong>2. I missed my delivery. What should I do?</strong><br>\r\nThe courier will reattempt delivery. You can also contact them or reach out to us.</p>\r\n<hr>\r\n\r\n<p><strong>3. My order shows delivered but I didn’t receive it. What now?</strong><br>\r\nPlease check with neighbors/security and contact us immediately if still not received.</p>\r\n<hr>\r\n\r\n<p><strong>4. Do you offer customization?</strong><br>\r\nCurrently, we do not offer customization.</p>\r\n<hr>\r\n\r\n<p><strong>5. How can I contact your team?</strong><br>\r\nYou can reach us via email or phone. We respond within 24–48 hours.</p>\r\n<hr>\r\n\r\n<p><strong>6. Do you take bulk or gifting orders?</strong><br>\r\nYes, please contact us for bulk or special orders.</p>\r\n<hr>\r\n\r\n<p><strong>7. Do you have a store in Bangalore?</strong><br>\r\nWe are currently an online-first brand.</p>',NULL,NULL,1,'2026-03-27 13:41:10','2026-03-27 14:48:58');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
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
-- Table structure for table `price_bands`
--

DROP TABLE IF EXISTS `price_bands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_bands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Under',
  `price_limit` int NOT NULL,
  `redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `price_bands_brand_id_foreign` (`brand_id`),
  CONSTRAINT `price_bands_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price_bands`
--

LOCK TABLES `price_bands` WRITE;
/*!40000 ALTER TABLE `price_bands` DISABLE KEYS */;
INSERT INTO `price_bands` VALUES (1,1,'Under',399,NULL,1,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(2,1,'Under',599,NULL,2,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(3,1,'Under',999,NULL,3,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(4,1,'Under',1999,NULL,4,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(5,2,'Under',499,NULL,1,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(6,2,'Under',999,NULL,2,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(7,2,'Under',1999,NULL,3,1,'2026-03-27 10:00:37','2026-03-27 10:00:37'),(8,2,'Under',2999,NULL,4,1,'2026-03-27 10:00:37','2026-03-27 10:00:37');
/*!40000 ALTER TABLE `price_bands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,5,'products/FqWSykn1sKp5OyvpzEyen5aiDAfRauAa0Bbq1DbT.png',0,'2026-03-31 07:25:29','2026-03-31 07:25:29'),(2,6,'products/xzOE71cNLOnLrK20y5fUJCHFbYTxRhEMhDwhFTBe.png',0,'2026-04-01 05:18:59','2026-04-01 05:18:59'),(3,7,'products/CnqurpRSDhr4Bq6JXOuotyuRpfripujdECT13rhI.png',0,'2026-04-01 05:20:58','2026-04-01 05:20:58'),(4,8,'products/cIAVCIP65CEMkcVvuTkdZz1s1sHbq6bNmpSsOXYf.png',0,'2026-04-01 05:33:13','2026-04-01 05:33:13'),(5,9,'products/FjojpIyCx8DOf9x0aYDO1Fih48a0UyrFUVIsiTq4.png',0,'2026-04-01 05:50:36','2026-04-01 05:50:36');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `low_stock_threshold` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_sku_unique` (`sku`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES (5,5,'Classic Peach Layered Frock','6 years','peach',499.00,799.00,2,5,'2026-03-31 07:25:29','2026-03-31 07:25:29'),(6,6,'Ethnic Charm Festive Dress','6 years','green',599.00,999.00,3,5,'2026-04-01 05:18:59','2026-04-01 05:18:59'),(7,7,'Floral Garden Party Dress','5 years','peach',349.00,749.00,8,5,'2026-04-01 05:20:58','2026-04-01 05:20:58'),(8,8,'Casual Chic Denim Set','9 years','red',699.00,899.00,6,5,'2026-04-01 05:33:13','2026-04-01 05:33:13'),(9,9,'Blush Bloom Ethnic Set','9 years','peach',699.00,999.00,5,5,'2026-04-01 05:50:36','2026-04-01 05:50:36');
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `subcategory_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` int NOT NULL DEFAULT '0',
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `care_instructions` text COLLATE utf8mb4_unicode_ci,
  `weight_grams` decimal(8,2) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (5,1,11,NULL,'Classic Peach Layered Frock','classic-peach-layered-frock-69cb76e9aad77','products/FqWSykn1sKp5OyvpzEyen5aiDAfRauAa0Bbq1DbT.png',NULL,0,NULL,'desc','care',490.02,1,1,NULL,NULL,'2026-03-31 07:25:29','2026-03-31 07:25:29'),(6,1,11,NULL,'Ethnic Charm Festive Dress','ethnic-charm-festive-dress-69ccaac31272f','products/xzOE71cNLOnLrK20y5fUJCHFbYTxRhEMhDwhFTBe.png',NULL,0,NULL,'Description','care instructions',690.00,1,1,NULL,NULL,'2026-04-01 05:18:59','2026-04-01 05:18:59'),(7,1,11,NULL,'Floral Garden Party Dress','floral-garden-party-dress-69ccab3ab0793','products/CnqurpRSDhr4Bq6JXOuotyuRpfripujdECT13rhI.png',NULL,0,NULL,'Description','care Instructions',NULL,1,1,NULL,NULL,'2026-04-01 05:20:58','2026-04-01 05:20:58'),(8,1,11,NULL,'Casual Chic Denim Set','casual-chic-denim-set-69ccae19dad1c','products/cIAVCIP65CEMkcVvuTkdZz1s1sHbq6bNmpSsOXYf.png',NULL,0,NULL,'Description','Care Instructions',590.00,1,1,NULL,NULL,'2026-04-01 05:33:13','2026-04-01 05:33:13'),(9,1,11,NULL,'Blush Bloom Ethnic Set','blush-bloom-ethnic-set-69ccb22c3e39d','products/FjojpIyCx8DOf9x0aYDO1Fih48a0UyrFUVIsiTq4.png',NULL,0,NULL,'Elegant floral printed kurta set with soft frill detailing, perfect for festive and traditional wear','Care Instructions',790.00,1,1,NULL,NULL,'2026-04-01 05:50:36','2026-04-01 05:50:36');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL DEFAULT '1',
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int unsigned NOT NULL COMMENT '1 to 5',
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `admin_reply` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_brand_id_foreign` (`brand_id`),
  CONSTRAINT `reviews_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,6,NULL,'Meena Sharma, Bangalore, India',4,'\"Absolutely in love with Avnee’s collection! My daughter looked like a fairy princess! The quality is top-notch and so many beautiful options for little girls.“','reviews/wzomZzXKfjJo6YSP7newdYsqPbkPI5jVlwJbe4a0.png',NULL,1,NULL,'approved','2026-04-01 05:53:59','2026-04-01 06:05:08'),(2,1,7,NULL,'Latha Iyer, Chennai, India',5,'\"Avnee Collection never disappoints! Every dress is adorable and comfortable. My daughter is super happy with her new dress and so are we. Highly recommend!“','reviews/akmgzsAOZ9cdPDz0DhF04KCr92NXNsZS6P7ua5p3.png',NULL,1,NULL,'approved','2026-04-01 05:54:29','2026-04-01 06:04:59'),(3,2,5,NULL,'sdkfds',5,'jnknknjkn',NULL,'hjbkjbk',1,NULL,'approved','2026-04-03 18:08:36','2026-04-03 18:08:36');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saree_edit_settings`
--

DROP TABLE IF EXISTS `saree_edit_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saree_edit_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INSTANT SAREE™',
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Introducing',
  `description` text COLLATE utf8mb4_unicode_ci,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PRE-DRAPE NOW',
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/products?category=sarees',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saree_edit_settings`
--

LOCK TABLES `saree_edit_settings` WRITE;
/*!40000 ALTER TABLE `saree_edit_settings` DISABLE KEYS */;
INSERT INTO `saree_edit_settings` VALUES (1,'INSTANT SAREE™','Introducing','Description','saree_edit/f4ZQyonXKOJ4J7Ez3G7W95jN7KEAZfvl7RIVRqyf.png',NULL,'saree_edit/1QD4xoA4aq6VnPnU4WAxgh80OF37cHjoFhoDIVEI.png','saree_edit/w4Dr10xzCocsSCJoe6myE1ea7hzfqpvFxqVIPXzD.png','saree_edit/64qPFDMTENlrsw8xyPsWfJIwftYw47EzulolOeeM.png','PRE-DRAPE NOW','/products?category=sarees',1,'2026-03-27 10:06:33','2026-04-01 05:41:00');
/*!40000 ALTER TABLE `saree_edit_settings` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('GPJaH1DsLwqzHb0l61TyZGavurHEb91jFucX9RMD',NULL,'54.39.210.32','Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmlHV2dGdmJ5QXh4cEU5dkVTN3J6WXRPVWtMbEQ1Yktsd0JNTTVwZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vdHdvc2FtcGxlLm9ubGluZS90cmFjay1vcmRlcj90aGVtZT1zdHVkaW8iO3M6NToicm91dGUiO3M6MTc6ImZyb250LnRyYWNrX29yZGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775479287),('I0d4rfLsmCTbdR7fFTwwbl2Ho4Z8k1kMVNcN7sGZ',NULL,'49.37.163.241','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSktjSFhuM3p3cFVwRVpnVnNKZGZUaUlTRHpES1JDcjV1M1BmSTJidSI7czo1OiJ0aGVtZSI7czo2OiJzdHVkaW8iO3M6ODoiYnJhbmRfaWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NzoiaHR0cHM6Ly90d29zYW1wbGUub25saW5lL3Byb2R1Y3RzP2NhdGVnb3J5PWtpZHMiO3M6NToicm91dGUiO3M6MjA6ImZyb250LnByb2R1Y3RzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775476962),('jTO6jYvuuM9Odn0fnw2GkLyv6lYXD7MtzQ2i2zDI',NULL,'54.39.203.250','Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTRxOUZXYkZuSXh6bEJJMUFvREN4MVB0ZUV2WGc4dU5ReE9oT1EwdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vdHdvc2FtcGxlLm9ubGluZS9jb25jaWVyZ2UiO3M6NToicm91dGUiO3M6MTM6ImZyb250LmNvbnRhY3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1775473015),('mX8e1CHE9B6mwO3N3hAU6mYFqiXVaBAKqSwyWw6D',NULL,'49.44.81.198','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoibG1PV3RUT2lZUE5xVTdmaTJqNGdId3FDaWl4cFNJem9mQWxrZzhTNiI7czo1OiJ0aGVtZSI7czo5OiJqZXdlbGxlcnkiO3M6ODoiYnJhbmRfaWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly90d29zYW1wbGUub25saW5lL2pld2VsbGVyeSI7czo1OiJyb3V0ZSI7czoxNToiZnJvbnQuamV3ZWxsZXJ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775476550),('R7JnC0xJ03HxXf3xRvhmGDEExr0C5O3uRwX5edQS',NULL,'117.98.188.154','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ1YySjM2U2N3eGZoSnVBVE40UW5QYjRWZVRHb29qMzVuVTc3MzVmdSI7czo1OiJ0aGVtZSI7czo2OiJzdHVkaW8iO3M6ODoiYnJhbmRfaWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly90d29zYW1wbGUub25saW5lIjtzOjU6InJvdXRlIjtzOjEwOiJmcm9udC5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775481042),('ZadCF2dnNT5ra1LEDQw9kNUuGr89sVcIUiTuhKUb',NULL,'54.39.0.244','Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRE4xejZVUkJTVVk0M2RPZFlPYnE0TDJvSGtzbUZhNDFoVEYza3I1SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vdHdvc2FtcGxlLm9ubGluZS9ibG9nIjtzOjU6InJvdXRlIjtzOjE2OiJmcm9udC5ibG9nLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1775476690);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','\"AVNEE\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(2,'site_email','\"contact@avnee.in\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(3,'site_phone','\"+91 9876543210\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(4,'site_address','\"123 Fashion Street, New Delhi, India\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(5,'facebook_url','\"\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(6,'instagram_url','\"\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(7,'twitter_url','\"\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(8,'shipping_flat_rate','\"100\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(9,'shipping_free_above','\"1499\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(10,'razorpay_key_id','\"\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(11,'razorpay_key_secret','\"\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(12,'currency_symbol','\"₹\"','general','2026-03-27 04:08:09','2026-03-27 04:08:09'),(13,'shiprocket_email','\"\"','logistics','2026-03-27 15:35:51','2026-03-27 15:35:51'),(14,'shiprocket_password','\"\"','logistics','2026-03-27 15:35:51','2026-03-27 15:35:51'),(15,'shiprocket_token','\"\"','logistics','2026-03-27 15:35:51','2026-03-27 15:35:51'),(16,'is_cod_enabled','\"1\"','payment','2026-03-27 15:35:51','2026-03-27 15:35:51'),(17,'whatsapp_number','\"\"','business','2026-03-27 15:35:51','2026-03-27 15:35:51'),(18,'social_instagram','\"\"','business','2026-03-27 15:35:51','2026-03-27 15:35:51'),(19,'social_facebook','\"\"','business','2026-03-27 15:35:51','2026-03-27 15:35:51'),(20,'custom_pixels','\"\"','analytics','2026-03-27 15:35:51','2026-03-27 15:35:51');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
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
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@avnee.in',NULL,NULL,'$2y$12$agd4IEgDZnN0UTj5w0NR6.0CakypQeADzYv.8veL5EsWRzfobNdOC','admin',0,NULL,'2026-03-27 04:08:08','2026-03-27 04:08:08'),(2,'Test Customer','customer@avnee.in',NULL,NULL,'$2y$12$fOsz.jwBFr6tFBlTYOYqw.foE5WNGWm1xtssgU6PeYb9PJgbgd8Lq','customer',0,NULL,'2026-03-27 04:08:09','2026-03-27 04:08:09'),(3,'Master Admin','master@avnee.com',NULL,NULL,'$2y$12$OusZWzQtoeJ/uyBmiJW.6uzmQ/gP528gHa/8BGRb4pjZP0rnbZzHK','admin',0,NULL,'2026-03-27 04:08:50','2026-03-27 04:08:50'),(4,'Admin','admin@avnee.com',NULL,NULL,'$2y$12$rv2BwXfnj00kWpuZq5Zp5.do4CaWkAEwbXr7NwyXuKShNeuYfmPz6','admin',0,NULL,'2026-03-27 04:08:50','2026-03-27 04:08:50'),(5,'kumar','vjnan@gmail.com',NULL,NULL,'$2y$12$eBU/oQazik.xR8EO2yc6b.M1Or8Nwa41Y1OzpFq.KHgMa6Fk73mni','admin',0,NULL,'2026-03-27 04:12:27','2026-03-27 04:12:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  KEY `wishlists_variant_id_foreign` (`variant_id`),
  KEY `wishlists_session_id_index` (`session_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-06 13:16:52
