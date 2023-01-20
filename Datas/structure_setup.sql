DROP DATABASE IF EXISTS Pandemic;
CREATE DATABASE Pandemic;
USE Pandemic;

DROP TABLE IF EXISTS amzn;
DROP TABLE IF EXISTS flight;
DROP TABLE IF EXISTS generaldata;
DROP TABLE IF EXISTS googl;
DROP TABLE IF EXISTS ixic;
DROP TABLE IF EXISTS n225;
DROP TABLE IF EXISTS nke;
DROP TABLE IF EXISTS unemployment;
DROP TABLE IF EXISTS vaccination;


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `amzn` (
  `Date` date DEFAULT NULL,
  `Open` double DEFAULT NULL,
  `High` double DEFAULT NULL,
  `Low` double DEFAULT NULL,
  `Close` double DEFAULT NULL,
  `Adj Close` double DEFAULT NULL,
  `Volume` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flight` (
  `Date` date DEFAULT NULL,
  `2021_7MA` int DEFAULT NULL,
  `2021_flights` int DEFAULT NULL,
  `2020_7MA` int DEFAULT NULL,
  `2020_flights` int DEFAULT NULL,
  `2019_7MA` int DEFAULT NULL,
  `2019_flights` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `generaldata` (
  `iso` text,
  `continent` text,
  `location` text,
  `date` date DEFAULT NULL,
  `total_cases` int DEFAULT NULL,
  `new_cases` int DEFAULT NULL,
  `total_deaths` int DEFAULT NULL,
  `new_deaths` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `googl` (
  `Date` date DEFAULT NULL,
  `Open` double DEFAULT NULL,
  `High` double DEFAULT NULL,
  `Low` double DEFAULT NULL,
  `Close` double DEFAULT NULL,
  `Adj Close` double DEFAULT NULL,
  `Volume` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ixic` (
  `Date` date DEFAULT NULL,
  `Open` double DEFAULT NULL,
  `High` double DEFAULT NULL,
  `Low` double DEFAULT NULL,
  `Close` double DEFAULT NULL,
  `Adj Close` double DEFAULT NULL,
  `Volume` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `n225` (
  `Date` date DEFAULT NULL,
  `Open` double DEFAULT NULL,
  `High` double DEFAULT NULL,
  `Low` double DEFAULT NULL,
  `Close` double DEFAULT NULL,
  `Adj Close` double DEFAULT NULL,
  `Volume` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nke` (
  `Date` date DEFAULT NULL,
  `Open` double DEFAULT NULL,
  `High` double DEFAULT NULL,
  `Low` double DEFAULT NULL,
  `Close` double DEFAULT NULL,
  `Adj Close` double DEFAULT NULL,
  `Volume` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unemployment` (
  `location` text,
  `2017` double DEFAULT NULL,
  `2018` double DEFAULT NULL,
  `2019` double DEFAULT NULL,
  `2020` double DEFAULT NULL,
  `2021` double DEFAULT NULL,
  `2022` double DEFAULT NULL,
  `2023` double DEFAULT NULL,
  `2024` double DEFAULT NULL,
  `2025` double DEFAULT NULL,
  `2026` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccination` (
  `location` text,
  `iso` text,
  `date` date DEFAULT NULL,
  `total_vaccinations` int DEFAULT NULL,
  `vaccinated` int DEFAULT NULL,
  `fully_vaccinated` int DEFAULT NULL,
  `daily_vaccinations` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
