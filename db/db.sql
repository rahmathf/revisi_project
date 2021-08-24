-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bank_sampah
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB-0ubuntu0.21.04.1

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
-- Table structure for table `detail_transaksi`
--

DROP TABLE IF EXISTS `detail_transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `id_sampah` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_transaksi_id_transaksi_foreign` (`id_transaksi`),
  KEY `detail_transaksi_id_sampah_foreign` (`id_sampah`),
  CONSTRAINT `detail_transaksi_id_sampah_foreign` FOREIGN KEY (`id_sampah`) REFERENCES `sampah` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detail_transaksi_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_transaksi`
--

LOCK TABLES `detail_transaksi` WRITE;
/*!40000 ALTER TABLE `detail_transaksi` DISABLE KEYS */;
INSERT INTO `detail_transaksi` VALUES (1,1,1,10,350,3500,NULL,'2021-08-21 14:09:40','2021-08-21 14:09:40'),(2,3,1,2,350,700,NULL,'2021-08-23 08:32:52','2021-08-23 08:32:52'),(3,3,2,2,1700,3400,NULL,'2021-08-23 08:32:52','2021-08-23 08:32:52'),(4,4,1,1,350,350,NULL,'2021-08-23 08:47:50','2021-08-23 08:47:50'),(5,4,3,3,2500,7500,NULL,'2021-08-23 08:47:51','2021-08-23 08:47:51'),(6,5,1,5,300,1500,NULL,'2021-08-23 09:33:46','2021-08-23 09:33:46'),(7,5,15,5,1700,8500,NULL,'2021-08-23 09:33:46','2021-08-23 09:33:46'),(8,5,2,2,1700,3400,NULL,'2021-08-23 09:33:46','2021-08-23 09:33:46'),(9,5,19,10,100,1000,NULL,'2021-08-23 09:33:46','2021-08-23 09:33:46'),(10,5,15,10,1700,17000,NULL,'2021-08-23 09:33:46','2021-08-23 09:33:46'),(11,6,15,50,1700,85000,NULL,'2021-08-23 09:40:26','2021-08-23 09:40:26'),(12,6,14,100,250,25000,NULL,'2021-08-23 09:40:26','2021-08-23 09:40:26'),(13,50,2,5,1700,8500,NULL,'2021-08-24 09:57:19','2021-08-24 09:57:19'),(14,50,3,9,2500,22500,NULL,'2021-08-24 09:57:19','2021-08-24 09:57:19'),(15,50,4,2,1000,2000,NULL,'2021-08-24 09:57:19','2021-08-24 09:57:19'),(16,50,1,2,300,600,NULL,'2021-08-24 09:57:19','2021-08-24 09:57:19'),(17,50,5,21,350,7350,NULL,'2021-08-24 09:57:19','2021-08-24 09:57:19'),(18,51,2,5,1700,8500,NULL,'2021-08-24 10:38:16','2021-08-24 10:38:16'),(19,51,3,9,2500,22500,NULL,'2021-08-24 10:38:16','2021-08-24 10:38:16'),(20,51,1,1,300,300,NULL,'2021-08-24 10:38:16','2021-08-24 10:38:16');
/*!40000 ALTER TABLE `detail_transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2021-02-25-180650','App\\Database\\Migrations\\Users','default','App',1614279057,1),(2,'2021-02-25-181838','App\\Database\\Migrations\\Sampah','default','App',1614279057,1),(3,'2021-02-25-182427','App\\Database\\Migrations\\Transaksi','default','App',1614279058,1),(4,'2021-02-25-183434','App\\Database\\Migrations\\DetailTransaksi','default','App',1614279059,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sampah`
--

DROP TABLE IF EXISTS `sampah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sampah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `des` varchar(255) DEFAULT NULL,
  `sampul` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sampah`
--

LOCK TABLES `sampah` WRITE;
/*!40000 ALTER TABLE `sampah` DISABLE KEYS */;
INSERT INTO `sampah` VALUES (1,'Kresek','kresek',300,'','1625480545_34758434d43aa439200b.jpg','2021-04-01 16:53:37','2021-08-23 08:49:21'),(2,'botol plastik','botol-plastik',1700,'','1625480562_328296f16d906fa4143e.jpg','2021-04-01 16:54:00','2021-07-05 17:22:42'),(3,'gelas plastik','gelas-plastik',2500,'','1625480584_2c6b99e1ad4ab3e17252.jpg','2021-04-01 16:55:59','2021-07-05 17:23:04'),(4,'Kardus','kardus',1000,'','1625480603_7e8cabf09c4acbca7a70.jpg','2021-04-01 16:56:17','2021-07-05 17:23:23'),(5,'Duplex','duplex',350,'','sampah.png','2021-04-01 16:56:40','2021-04-01 16:56:40'),(6,'Kaleng','kaleng',1200,'','sampah.png','2021-04-01 16:57:09','2021-04-01 16:57:09'),(7,'Ember Warna','ember-warna',2000,'','sampah.png','2021-04-01 16:57:42','2021-04-01 16:57:42'),(8,'Ember Putih','ember-putih',2500,'','sampah.png','2021-04-01 16:58:03','2021-04-01 16:58:03'),(9,'Kertas Buram','kertas-buram',800,'','sampah.png','2021-04-01 16:58:23','2021-04-01 16:58:23'),(10,'Kertas HVS','kertas-hvs',1500,'','sampah.png','2021-04-01 16:58:54','2021-04-01 16:58:54'),(11,'Kantong Semen','kantong-semen',1700,'','sampah.png','2021-04-01 16:59:16','2021-04-01 17:41:30'),(12,'Botol Syrop','botol-syrop',75,'','sampah.png','2021-04-01 16:59:57','2021-04-01 16:59:57'),(13,'Botol Kaleng','botol-kaleng',125,'','sampah.png','2021-04-01 17:00:24','2021-04-01 17:24:06'),(14,'Botol Kecap','botol-kecap',250,'','sampah.png','2021-04-01 17:00:42','2021-04-01 17:23:20'),(15,'Besi','besi',1700,'','sampah.png','2021-04-01 17:01:22','2021-04-01 17:01:22'),(16,'Beling','beling',50,'','sampah.png','2021-04-01 17:01:44','2021-04-01 17:21:48'),(18,'kristal','kristal',1500,'','1625577879_0b6d02bceffb87b241e1.jpg','2021-07-06 20:24:39','2021-07-06 20:24:39'),(19,'kulit pisang','kulit-pisang',100,'','sampah.png','2021-08-23 09:26:08','2021-08-23 09:26:08'),(20,'Kulit mangga','kulit-mangga',0,'','sampah.png','2021-08-23 09:26:28','2021-08-23 09:26:28');
/*!40000 ALTER TABLE `sampah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp`
--

DROP TABLE IF EXISTS `temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_sampah` int(11) NOT NULL,
  `qty` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp`
--

LOCK TABLES `temp` WRITE;
/*!40000 ALTER TABLE `temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jenis_transaksi` varchar(25) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_id_admin_foreign` (`id_admin`),
  KEY `transaksi_id_user_foreign` (`id_user`),
  CONSTRAINT `transaksi_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` VALUES (1,1,4,'masuk',3500,'2021-08-21 14:09:39','2021-08-21 14:09:39'),(2,1,4,'keluar',500,'2021-08-21 14:09:58','2021-08-21 14:09:58'),(3,1,6,'masuk',4100,'2021-08-23 08:32:52','2021-08-23 08:32:52'),(4,1,7,'masuk',7850,'2021-08-23 08:47:50','2021-08-23 08:47:50'),(5,1,9,'masuk',31400,'2021-08-23 09:33:46','2021-08-23 09:33:46'),(6,1,9,'masuk',110000,'2021-08-23 09:40:26','2021-08-23 09:40:26'),(7,1,9,'keluar',140000,'2021-08-23 09:43:33','2021-08-23 09:43:33'),(8,1,9,'keluar',1300,'2021-08-23 09:44:36','2021-08-23 09:44:36'),(50,1,4,'masuk',40950,'2021-08-24 09:57:19','2021-08-24 09:57:19'),(51,1,4,'masuk',31300,'2021-08-24 10:38:16','2021-08-24 10:38:16'),(52,1,4,'keluar',75250,'2021-08-24 10:43:03','2021-08-24 10:43:03');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rt` varchar(3) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `sampul` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `saldo` int(30) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin','$2y$10$UUD3sYUxZcSSbQ3WeA.d/OIN8IZma113Hbev08h9KoGdzPCF9dxWK','2','1','profil.svg','admin',0,'2021-04-01 16:15:46','2021-04-01 16:17:45'),(3,'SemangatePoor','semangatepoor','$2y$10$mi0hbnvM7UwHWdKyyZvoneQki6a0OdJ8WniA.aQnDPmuNXaqiQ7Vi','02','01','profil.svg','admin',0,'2021-06-26 05:17:27','2021-06-26 05:17:27'),(4,'Rahmat','rahmat','$2y$10$5KANuVKei6F95fvSpGo9UO8lA.aujmXaxeGn7lhffvLZtRGWt93Jy','02','01','profil.svg','user',0,'2021-06-26 05:20:58','2021-08-24 10:43:03'),(6,'Siti','siti','$2y$10$gsC6g1idQDF3wmPIFYZliuNscXrDX/JbvLW64F00l/o7SmodFaLWi','2','1','profil.svg','user',4100,'2021-07-04 20:17:43','2021-08-23 08:32:52'),(7,'Sulastri','sulastri','$2y$10$B.krq7EUB9WZ/Ma046DUtOJfrJiZ2TTCv9XcWEoTyMAkhHewmihLG','01','03','profil.svg','user',7850,'2021-07-06 20:14:26','2021-08-23 08:47:50'),(8,'hidayat','hidayat','$2y$10$RNcu1me0nLqU8SccuUSUuO5DOallRqx4WOj/1yWRr8aL1m2OLZcQa','1','1','profil.svg','user',0,'2021-08-23 08:46:25','2021-08-23 08:46:25'),(9,'Aa','aa','$2y$10$Eolkzp8omSmbzZijRORnV.D8cYc.nLrcBWH/xnkj4ouZpqVfgDI3q','aa','aa','profil.svg','user',100,'2021-08-23 09:28:10','2021-08-23 09:44:36'),(10,'ab','ab','$2y$10$WSyk5ne0BDUuWZknDc8/aOr.9fRDTPrLts0VAyKm2m1/sy7GYCse6','ab','ab','profil.svg','user',0,'2021-08-23 09:28:33','2021-08-23 09:28:33');
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

-- Dump completed on 2021-08-24 10:45:30
