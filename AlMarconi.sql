-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: AlMarconi
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `annunci`
--

DROP TABLE IF EXISTS `annunci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `annunci` (
  `IdAnnuncio` int(6) NOT NULL AUTO_INCREMENT,
  `TipoContratto` varchar(50) NOT NULL,
  `Mansione` varchar(30) NOT NULL,
  `Descrizione` text NOT NULL,
  `AreaDisciplinare` varchar(30) NOT NULL,
  `AbilitaRichieste` text DEFAULT NULL,
  `DataPubblicazione` date NOT NULL DEFAULT curdate(),
  `DataScadenza` date DEFAULT NULL,
  `MaxIscrizioni` int(6) DEFAULT NULL,
  `Azienda` int(6) NOT NULL,
  PRIMARY KEY (`IdAnnuncio`),
  KEY `Azienda` (`Azienda`),
  CONSTRAINT `annunci_ibfk_1` FOREIGN KEY (`Azienda`) REFERENCES `aziende` (`IdUtente`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annunci`
--

LOCK TABLES `annunci` WRITE;
/*!40000 ALTER TABLE `annunci` DISABLE KEYS */;
INSERT INTO `annunci` VALUES (1,'Apprendistato','Tecnico Meccatronico Junior','Meccanica Pontedera S.p.A. è alla ricerca di un diplomato in Meccanica e Meccatronica per il ruolo di Tecnico Meccatronico Junior. Il candidato affiancherà il team nella manutenzione e installazione di impianti automatizzati e nella produzione con macchinari CNC.','Meccanica, Meccatronica ed Ene','Conoscenze di base di pneumatica, elettronica e automazione, Capacità di lettura di schemi elettrici e disegni meccanici, Precisione, manualità e autonomia operativa, Disponibilità al lavoro su turni o in produzione','2025-05-25',NULL,NULL,23),(2,'Tirocinio','Junior Developer','SoftLab S.r.l. cerca un giovane diplomato per il ruolo di Junior Developer da inserire nel team di sviluppo web. La risorsa supporterà i progetti di realizzazione di applicazioni web e mobile, collaborando con programmatori senior e il reparto UX/UI.','Informatica e telecomunicazion','Conoscenza base di almeno un linguaggio di programmazione (preferibilmente JavaScript o Python), Capacità di utilizzare ambienti di sviluppo come Visual Studio Code o GitHub, Attitudine al lavoro in team, Curiosità, problem solving e voglia di imparare','2025-05-25',NULL,NULL,4);
/*!40000 ALTER TABLE `annunci` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aziende`
--

DROP TABLE IF EXISTS `aziende`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aziende` (
  `IdUtente` int(6) NOT NULL,
  `IVA` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Settore` varchar(30) NOT NULL,
  `NumeroDipendenti` int(6) DEFAULT NULL,
  `Link` text DEFAULT NULL,
  `Descrizione` text DEFAULT NULL,
  `ReferenteCodiceFiscale` varchar(16) NOT NULL,
  `ReferenteNome` varchar(50) NOT NULL,
  `ReferenteCognome` varchar(50) NOT NULL,
  `ReferenteDataNascita` date NOT NULL,
  `SedeCitta` varchar(50) NOT NULL,
  `SedeVia` varchar(50) NOT NULL,
  `SedeCivico` int(7) NOT NULL,
  PRIMARY KEY (`IdUtente`),
  UNIQUE KEY `IVA` (`IVA`),
  UNIQUE KEY `ReferenteCodiceFiscale` (`ReferenteCodiceFiscale`),
  CONSTRAINT `aziende_ibfk_1` FOREIGN KEY (`IdUtente`) REFERENCES `utenti` (`IdUtente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aziende`
--

LOCK TABLES `aziende` WRITE;
/*!40000 ALTER TABLE `aziende` DISABLE KEYS */;
INSERT INTO `aziende` VALUES (4,1987654321,'SoftLab S.r.l.','Sviluppo software e servizi IT',100,'http://www.softlab.it/','SoftLab S.r.l. è una giovane e dinamica azienda che offre soluzioni software personalizzate per piccole e medie imprese. Specializzata in applicazioni web e mobile, si distingue per l\'approccio innovativo e la capacità di adattarsi alle esigenze specifiche dei clienti.','BNCGLC85A15H501R','Giorgio','Bianchi','1985-04-15','Pontedera','Via Galilei',45),(23,2147483647,'Meccanica Pontedera S.p.A.','Automazione industriale e mecc',12,NULL,'Meccanica Avanzata Pontedera è una realtà consolidata nel campo della meccanica di precisione e meccatronica, con un focus su innovazione e qualità. Offre opportunità di inserimento per giovani diplomati interessati a lavorare su progetti industriali e tecnici di alto livello, valorizzando competenze pratiche e tecniche.','RSSMRT77B29F205Y','Marco','Rossi','1977-07-29','Pontedera','Via Leonardo da Vinci',88);
/*!40000 ALTER TABLE `aziende` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidarsi`
--

DROP TABLE IF EXISTS `candidarsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `candidarsi` (
  `IdStudente` int(6) NOT NULL,
  `IdAnnuncio` int(6) NOT NULL,
  `Data` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`IdStudente`,`IdAnnuncio`),
  KEY `IdAnnuncio` (`IdAnnuncio`),
  CONSTRAINT `candidarsi_ibfk_1` FOREIGN KEY (`IdStudente`) REFERENCES `studenti` (`IdUtente`) ON DELETE CASCADE,
  CONSTRAINT `candidarsi_ibfk_2` FOREIGN KEY (`IdAnnuncio`) REFERENCES `annunci` (`IdAnnuncio`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidarsi`
--

LOCK TABLES `candidarsi` WRITE;
/*!40000 ALTER TABLE `candidarsi` DISABLE KEYS */;
INSERT INTO `candidarsi` VALUES (2,1,'2025-05-25'),(2,2,'2025-05-25'),(3,1,'2025-05-25');
/*!40000 ALTER TABLE `candidarsi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studenti`
--

DROP TABLE IF EXISTS `studenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studenti` (
  `IdUtente` int(6) NOT NULL,
  `CodiceFiscale` varchar(16) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Cognome` varchar(50) NOT NULL,
  `Sesso` varchar(1) DEFAULT NULL,
  `DataNascita` date NOT NULL,
  `Nazionalita` varchar(30) NOT NULL,
  `IndirizzoScolastico` varchar(30) NOT NULL,
  `Voto` int(3) NOT NULL,
  `Descrizione` text DEFAULT NULL,
  `ResidenzaCitta` varchar(50) NOT NULL,
  `ResidenzaVia` varchar(50) NOT NULL,
  `ResidenzaCivico` int(7) NOT NULL,
  `DomicilioCitta` varchar(50) DEFAULT NULL,
  `DomicilioVia` varchar(50) DEFAULT NULL,
  `DomicilioCivico` int(7) DEFAULT NULL,
  PRIMARY KEY (`IdUtente`),
  UNIQUE KEY `CodiceFiscale` (`CodiceFiscale`),
  CONSTRAINT `studenti_ibfk_1` FOREIGN KEY (`IdUtente`) REFERENCES `utenti` (`IdUtente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studenti`
--

LOCK TABLES `studenti` WRITE;
/*!40000 ALTER TABLE `studenti` DISABLE KEYS */;
INSERT INTO `studenti` VALUES (2,'BNCLCU06C15G702X','Luca','Bianchi','M','2006-03-15','Italia','Informatica',88,'Sono un giovane diplomato in Informatica e Telecomunicazioni con solide basi tecniche in programmazione, reti e sistemi digitali. Durante il percorso scolastico ho sviluppato capacità di problem solving e lavoro in team, partecipando anche a progetti pratici di programmazione e assistenza tecnica. Cerco un\'opportunità per mettere in pratica le mie competenze e crescere professionalmente nel settore IT.','Pontedera','Via Roma',12,NULL,NULL,NULL),(3,'RSSMRT06L69G702R','Martina','Rossi','F','2006-07-29','Italia','Meccanica',92,'Diplomata in Meccanica e Meccatronica con ottime competenze nell\'uso di strumenti CAD e nella manutenzione di impianti meccanici ed elettronici. Sono abituata a lavorare con precisione e attenzione ai dettagli, con una forte predisposizione al lavoro pratico e di squadra. Sono motivata a crescere nel settore industriale e a contribuire con entusiasmo ai progetti aziendali.','Pontedera','Via Dante Alighieri',7,'Pisa','Via San Giovanni',10);
/*!40000 ALTER TABLE `studenti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utenti` (
  `IdUtente` int(6) NOT NULL AUTO_INCREMENT,
  `Mail` varchar(255) NOT NULL,
  `Telefono` varchar(16) DEFAULT NULL,
  `HashPassword` varchar(60) NOT NULL,
  `2FA` bit(1) NOT NULL DEFAULT b'0',
  `Verificato` bit(1) NOT NULL DEFAULT b'0',
  `DataCreazione` date NOT NULL DEFAULT curdate(),
  `VisualizzaMail` bit(1) NOT NULL DEFAULT b'1',
  `VisualizzaTelefono` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`IdUtente`),
  UNIQUE KEY `Mail` (`Mail`),
  UNIQUE KEY `Telefono` (`Telefono`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utenti`
--

LOCK TABLES `utenti` WRITE;
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` VALUES (2,'luca.bianchi2006@gmail.com','+393456789123','$2y$10$KeDvtz..1Rd0SIt4HwzI8eZ1f.AbzyGaZHI11pEpBmmTDByvuhQ2.','\0','','2025-05-25','','\0'),(3,'martina.rossi06@gmail.com','+393339876542','$2y$10$f0YqB72Fz.EUNoibycKsHu9Cfs/bEzgOyUU3dL2YA5ohgNqpu9d9W','\0','','2025-05-25','',''),(4,'info@softlab.it','+390587123456','$2y$10$CsQ.LQxCtVzJnyVPYx/nAOX64zlijrPZe/C3PIG.4xLybmlTqXGl.','\0','','2025-05-25','',''),(23,'hr@meccanicapontedera.it','+39059743456','$2y$10$6DIWFw01qJK2xMHRT2EvpOVLvqyYMpYC7v8wPPPAKDUAFvn1.f6ta','\0','','2025-05-25','','');
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-25 17:11:16
