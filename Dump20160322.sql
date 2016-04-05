CREATE DATABASE  IF NOT EXISTS `BloodLINE` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `BloodLINE`;
-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: BloodLINE
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BloodSpecimen`
--

DROP TABLE IF EXISTS `BloodSpecimen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BloodSpecimen` (
  `idBloodSpecimen` varchar(5) NOT NULL,
  `bloodSpec_componentsInfo` varchar(11) DEFAULT NULL,
  `bloodSpec_storageLocation` varchar(12) DEFAULT NULL,
  `bloodSpec_testResults` varchar(10) DEFAULT NULL,
  `bloodSpec_bloodType` varchar(3) DEFAULT NULL,
  `bloodSpec_testedBy` varchar(50) DEFAULT NULL,
  `bloodSpec_processDate` date DEFAULT NULL,
  `bloodSpec_RH` varchar(2) DEFAULT NULL,
  `bloodSpec_status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idBloodSpecimen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BloodSpecimen`
--

LOCK TABLES `BloodSpecimen` WRITE;
/*!40000 ALTER TABLE `BloodSpecimen` DISABLE KEYS */;
/*!40000 ALTER TABLE `BloodSpecimen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DonationRecord`
--

DROP TABLE IF EXISTS `DonationRecord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DonationRecord` (
  `idDonationRecord` varchar(5) NOT NULL,
  `donationRec_date` date DEFAULT NULL,
  `donationRec_location` varchar(50) DEFAULT NULL,
  `donationRec_quantityDonated` decimal(2,2) DEFAULT NULL,
  `donationRec_donorType` varchar(15) DEFAULT NULL,
  `donationRec_collectedBy` varchar(50) DEFAULT NULL,
  `donationRec_expiryDate` date DEFAULT NULL,
  PRIMARY KEY (`idDonationRecord`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DonationRecord`
--

LOCK TABLES `DonationRecord` WRITE;
/*!40000 ALTER TABLE `DonationRecord` DISABLE KEYS */;
/*!40000 ALTER TABLE `DonationRecord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Donor`
--

DROP TABLE IF EXISTS `Donor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Donor` (
  `idDonor_TRN` varchar(11) NOT NULL,
  `donor_medicalRec` varchar(5) DEFAULT NULL,
  `donor_donationRec` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idDonor_TRN`),
  KEY `fk_Donor_2_idx` (`donor_medicalRec`),
  KEY `fk_Donor_3_idx` (`donor_donationRec`),
  CONSTRAINT `fk_Donor_2` FOREIGN KEY (`donor_medicalRec`) REFERENCES `MedicalRecord` (`idMedicalRecord`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Donor_3` FOREIGN KEY (`donor_donationRec`) REFERENCES `DonationRecord` (`idDonationRecord`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Donor_1` FOREIGN KEY (`idDonor_TRN`) REFERENCES `Person` (`idPerson_TRN`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Donor`
--

LOCK TABLES `Donor` WRITE;
/*!40000 ALTER TABLE `Donor` DISABLE KEYS */;
/*!40000 ALTER TABLE `Donor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MedicalRecord`
--

DROP TABLE IF EXISTS `MedicalRecord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MedicalRecord` (
  `idMedicalRecord` varchar(5) NOT NULL,
  `medicalRec_weight` decimal(3,2) DEFAULT NULL,
  `medicalRec_height` decimal(2,1) DEFAULT NULL,
  `medicalRec_bloodPressure` varchar(6) DEFAULT NULL,
  `medicalRec_temperature` decimal(3,2) DEFAULT NULL,
  `medicalRec_bloodIronLevel` decimal(3,2) DEFAULT NULL,
  `medicalRec_time` time DEFAULT NULL,
  `medicalRec_date` date DEFAULT NULL,
  `medicalRec_medicalHistory` varchar(255) DEFAULT NULL,
  `medicalRec_rejectionReason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idMedicalRecord`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MedicalRecord`
--

LOCK TABLES `MedicalRecord` WRITE;
/*!40000 ALTER TABLE `MedicalRecord` DISABLE KEYS */;
/*!40000 ALTER TABLE `MedicalRecord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Person`
--

DROP TABLE IF EXISTS `Person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Person` (
  `idPerson_TRN` varchar(11) NOT NULL,
  `person_firstName` varchar(50) DEFAULT NULL,
  `person_lastName` varchar(50) DEFAULT NULL,
  `person_address1` varchar(50) DEFAULT NULL,
  `person_address2` varchar(150) DEFAULT NULL,
  `person_cellNo` varchar(15) DEFAULT NULL,
  `person_workNo` varchar(15) DEFAULT NULL,
  `person_homeNo` varchar(15) DEFAULT NULL,
  `person_email` varchar(50) DEFAULT NULL,
  `person_dob` date DEFAULT NULL,
  `person_sex` char(1) DEFAULT NULL,
  `person_idPicture` varchar(13) DEFAULT NULL,
  `person_maritalStatus` varchar(25) DEFAULT NULL,
  `person_middleName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idPerson_TRN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Person`
--

LOCK TABLES `Person` WRITE;
/*!40000 ALTER TABLE `Person` DISABLE KEYS */;
/*!40000 ALTER TABLE `Person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipient`
--

DROP TABLE IF EXISTS `Recipient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipient` (
  `idRecipient_TRN` varchar(11) NOT NULL,
  `recipient_bloodGroup` varchar(3) DEFAULT NULL,
  `recipient_quantityNeeded` decimal(2,2) DEFAULT NULL,
  `recipient_reason` varchar(100) DEFAULT NULL,
  `recipient_urgencyLevel` int(11) DEFAULT NULL,
  `recipient_location` varchar(50) DEFAULT NULL,
  `recipient_RH` varchar(2) DEFAULT NULL,
  `recipient_compatibleWith` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idRecipient_TRN`),
  CONSTRAINT `fk_Recipient_1` FOREIGN KEY (`idRecipient_TRN`) REFERENCES `Person` (`idPerson_TRN`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recipient`
--

LOCK TABLES `Recipient` WRITE;
/*!40000 ALTER TABLE `Recipient` DISABLE KEYS */;
/*!40000 ALTER TABLE `Recipient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipient_DonationRec_BloodSpec`
--

DROP TABLE IF EXISTS `Recipient_DonationRec_BloodSpec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipient_DonationRec_BloodSpec` (
  `RDB_idDonationRec` varchar(5) NOT NULL,
  `RDB_idRecipient` varchar(11) DEFAULT NULL,
  `RDB_idBloodSpec` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`RDB_idDonationRec`),
  KEY `fk_Recipient_DonationRec_BloodSpec_2_idx` (`RDB_idRecipient`),
  KEY `fk_Recipient_DonationRec_BloodSpec_3_idx` (`RDB_idBloodSpec`),
  CONSTRAINT `fk_Recipient_DonationRec_BloodSpec_3` FOREIGN KEY (`RDB_idBloodSpec`) REFERENCES `BloodSpecimen` (`idBloodSpecimen`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Recipient_DonationRec_BloodSpec_1` FOREIGN KEY (`RDB_idDonationRec`) REFERENCES `DonationRecord` (`idDonationRecord`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Recipient_DonationRec_BloodSpec_2` FOREIGN KEY (`RDB_idRecipient`) REFERENCES `Recipient` (`idRecipient_TRN`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recipient_DonationRec_BloodSpec`
--

LOCK TABLES `Recipient_DonationRec_BloodSpec` WRITE;
/*!40000 ALTER TABLE `Recipient_DonationRec_BloodSpec` DISABLE KEYS */;
/*!40000 ALTER TABLE `Recipient_DonationRec_BloodSpec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserLogin`
--

DROP TABLE IF EXISTS `UserLogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserLogin` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) DEFAULT NULL,
  `userType` char(1) DEFAULT NULL,
  `passWord` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserLogin`
--

LOCK TABLES `UserLogin` WRITE;
/*!40000 ALTER TABLE `UserLogin` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserLogin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-22  9:14:24
