-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for login
CREATE DATABASE IF NOT EXISTS `login` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `login`;

-- Dumping structure for table login.guguk
CREATE TABLE IF NOT EXISTS `guguk` (
  `id` int NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Latitude` decimal(10,8) NOT NULL,
  `Longitude` decimal(11,8) NOT NULL,
  `Keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table login.guguk: ~0 rows (approximately)

-- Dumping structure for table login.location
CREATE TABLE IF NOT EXISTS `location` (
  `Id` int NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `last_changed` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table login.location: ~7 rows (approximately)
INSERT INTO `location` (`Id`, `store_name`, `location`, `status`, `latitude`, `longitude`, `last_changed`) VALUES
	(4, 'Rica GUGUK Super Njingkat', 'Lokasi 1', 'New Location', -7.55803300, 110.81373100, '2025-01-05 14:34:21'),
	(5, 'RICA2 GUGUK SAVIOR', 'Lokasi 2', 'New Location', -7.56397400, 110.82503200, '2025-01-05 21:33:03'),
	(6, 'Rica guguk scobydoo', 'Lokasi 3', 'New Location', -7.55904100, 110.82459900, '2025-01-05 21:33:03'),
	(7, 'Rica - Rica Guguk Pak Darto', 'Lokasi 4', 'New Location', -7.56860700, 110.84000000, '2025-01-05 21:33:03'),
	(8, 'Rica guguk pak gundul', 'Lokasi 5', 'New Location', -7.55362800, 110.82602400, '2025-01-05 21:33:03'),
	(9, 'Rica-Rica Guguk', 'Lokasi 6', 'New Location', -7.54172800, 110.83256100, '2025-01-05 21:33:03'),
	(10, 'Rica rica guguk PAK GARENG', 'Lokasi 7', 'New Location', -7.55423700, 110.84444300, '2025-01-05 21:33:03');

-- Dumping structure for table login.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table login.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`) VALUES
	(1, 'Joko', 'Widodo', 'jkw@gmail.com', '93b680869e9e448d6c0ea3af0821a4a3'),
	(2, 'anto', 'as', 'a@g.com', '457391c9c82bfdcbb4947278c0401e41'),
	(3, 'admin', 'admin', 'admin@admin.com', '827ccb0eea8a706c4c34a16891f84e7b'),
	(4, 'admin', 'admin', 'admin@a.com', '21232f297a57a5a743894a0e4a801fc3');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
