-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2017 at 02:59 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `asset_tag` int(11) NOT NULL,
  `asset_ID` varchar(200) DEFAULT NULL,
  `description` text,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `currency` text NOT NULL,
  `purchaseorder_id` text,
  `release_version` text,
  `expirydate` text,
  `remarks` text,
  `crtrno` text,
  `parent` text,
  `status` text NOT NULL,
  `version` int(11) NOT NULL,
  `lastedited` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`asset_tag`, `asset_ID`, `description`, `quantity`, `price`, `currency`, `purchaseorder_id`, `release_version`, `expirydate`, `remarks`, `crtrno`, `parent`, `status`, `version`, `lastedited`) VALUES
(1664, 'nehr0001', 'description', 1, 2, 'SGD', '12345', 'CR346-TR14', '06/21/2017', 'Something like that', 'CR001', '', 'Decommissioned', 1, ''),
(1665, 'nehr0002', 'description2', 34, 43, 'SGD', '100002', 'CR497', '06/21/2017', 'Remarks', 'CR002', 'nehr0001', 'Decommissioned', 1, ''),
(1665, 'nehr0002', 'description2', 34, 43, '', '100002', 'CR497', '06/21/2017', 'Remarks', 'CR002', 'nehr0001', 'Decommissioned', 2, ''),
(1665, 'nehr0002', 'description2', 34, 43, '', '100002', 'CR497', '06/21/2017', 'Remarks', 'CR002', 'nehr0001', 'Decommissioned', 3, ''),
(1665, 'nehr0002', 'description2', 34, 43, 'USD', '100002', 'CR497', '06/21/2017', 'Remarks', 'CR002', 'nehr0001', 'Decommissioned', 4, ''),
(1664, 'nehr0001', 'description', 1, 2, 'SGD', '12345', 'Part of HP Contract SAID: 1062 9911 8158 (1060 7091 3060)', '06/21/2017', 'Something like that', 'CR001', '', 'Decommissioned', 2, ''),
(1665, 'nehr0002', 'description2', 34, 43, 'SGD', '100002', 'CR497', '06/21/2017', 'Remarks', 'CR002', 'nehr0001', 'Decommissioned', 5, '2017-06-22 20:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `asset_version`
--

CREATE TABLE `asset_version` (
  `asset_tag` int(11) NOT NULL,
  `current_version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asset_version`
--

INSERT INTO `asset_version` (`asset_tag`, `current_version`) VALUES
(1659, 1),
(1660, 1),
(1661, 1),
(1662, 1),
(1663, 1),
(1664, 2),
(1665, 5);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`) VALUES
(3, 'Fortigate'),
(4, 'Cisco'),
(5, 'FireEye'),
(6, 'F5'),
(7, 'Bluecoat'),
(8, 'A10'),
(9, 'CA'),
(10, 'HP'),
(11, 'McAfee'),
(12, 'Appliance'),
(13, 'TippingPoint'),
(14, 'Radware'),
(15, 'MRV'),
(16, 'InfoBlox'),
(17, 'ArcSight'),
(18, 'QNAP'),
(19, '3PAR SAN Storage'),
(20, '3PAR Service Processor'),
(21, 'RSA'),
(22, 'Not Available'),
(23, 'Imperva');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(2, 'Firewall'),
(3, 'Router'),
(4, 'APT'),
(5, 'Load Balancer'),
(6, 'Proxy'),
(7, 'SSL Encryptor/Decryptor'),
(8, 'Layer 7'),
(9, 'Switch'),
(10, 'Server'),
(11, 'SAN Switch'),
(12, 'Storage'),
(13, 'Enclosure'),
(14, 'KVM'),
(15, 'Appliance'),
(16, 'IPS'),
(17, 'Console'),
(18, 'DNS'),
(19, 'Mail Security'),
(20, 'SIEM'),
(21, 'NAS'),
(22, 'Tokens'),
(23, 'Network Appliance'),
(24, 'Physical Safe'),
(25, 'Database Monitoring');

-- --------------------------------------------------------

--
-- Table structure for table `contracttype`
--

CREATE TABLE `contracttype` (
  `contracttype_id` int(11) NOT NULL,
  `contracttype_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contracttype`
--

INSERT INTO `contracttype` (`contracttype_id`, `contracttype_name`) VALUES
(5, 'Software & Support'),
(6, 'Software'),
(7, 'Support');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL,
  `currency_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency_name`) VALUES
(1, 'SGD'),
(2, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `hardware`
--

CREATE TABLE `hardware` (
  `asset_tag` int(11) NOT NULL,
  `class` text,
  `brand` text,
  `audit_date` text,
  `component` text,
  `label` text,
  `serial` text,
  `location` text,
  `replacing` text,
  `version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hardware`
--

INSERT INTO `hardware` (`asset_tag`, `class`, `brand`, `audit_date`, `component`, `label`, `serial`, `location`, `replacing`, `version`) VALUES
(1665, 'Enclosure', 'A10', 'Not in scope', 'Component', 'Label', 'Serial', 'CR346 (DMZ2)', '', 1),
(1665, 'Enclosure', 'A10', 'Not in scope', 'Component', 'Label', 'Serial', 'CR346 (DMZ2)', '', 2),
(1665, 'Enclosure', 'A10', 'Not in scope', 'Component', 'Label', 'Serial', 'CR346 (DMZ2)', '', 3),
(1665, 'Enclosure', 'A10', 'Not in scope', 'Component', 'Label', 'Serial', 'CR346 (DMZ2)', '', 4),
(1665, 'Enclosure', 'A10', 'Not in scope', 'Component', 'Label', 'Serial', 'CR346 (DMZ2)', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_name`) VALUES
(1, 'CR346 (DMZ2)'),
(2, 'Not Applicable'),
(3, 'CR337 (Ind Obrd)'),
(4, 'CR446 (MinDef)'),
(5, 'CR320 (Network)'),
(6, 'CR367 (Network)'),
(7, 'CR362'),
(8, 'CR316'),
(9, 'Dev_SITUAT(Servers)'),
(10, 'Dev_SITUAT_R1.5(Servers)'),
(11, 'Dev_SITUAT_R1.6(Servers)'),
(12, 'Dev_SITUAT(Storage)'),
(13, 'Dev_SITUAT_R1.5(Storage)'),
(14, 'Dev_SITUAT(Network)'),
(15, 'Dev_SITUAT_R1.5(Network)'),
(16, 'Prod_P1(Servers)'),
(17, 'Prod_P2&P3(Servers)'),
(18, 'Prod_P2&P3 R1.6(Servers)'),
(19, 'Prod_R1.5(Servers)'),
(20, 'Prod_R1.6(Servers)'),
(21, 'Prod_Remote(Servers)'),
(22, 'Prod_Remote R1.6(Network)'),
(23, 'Prod(Storage)'),
(24, 'Prod_R1.6(Storage)'),
(25, 'Prod(Network)'),
(26, 'Prod_R1.5(Network)'),
(27, 'Prod_R1.6(Network)'),
(28, 'Prod Tech Refresh'),
(29, 'DR_P1(Servers)'),
(30, 'DR_P2&P3(Servers)'),
(31, 'DR_R1.5(Servers)'),
(32, 'DR_R1.6(Servers)'),
(33, 'DR(Storage)'),
(34, 'CR350'),
(35, 'DR_R1.5(Storage)'),
(36, 'DR(Network)'),
(37, 'DR_R1.5(Network)'),
(38, 'DR_R1.6(Network)'),
(39, 'DR Tech Refresh'),
(40, 'Others (Misc)'),
(41, 'Release 1.2'),
(42, 'CR478 (Imaging)'),
(43, 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_ID` int(11) NOT NULL,
  `user` text NOT NULL,
  `time` text NOT NULL,
  `log` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_ID`, `user`, `time`, `log`) VALUES
(132, 'administrator', '2017-06-01 10:43:22', 'logged in'),
(133, 'administrator', '2017-06-01 10:43:50', 'edited user test_admin'),
(134, 'administrator', '2017-06-01 10:54:12', 'edited user test_admin'),
(135, 'administrator', '2017-06-05 09:57:47', 'logged in'),
(136, 'administrator', '2017-06-05 13:33:41', 'logged in'),
(137, 'administrator', '2017-06-05 13:34:25', 'logged in'),
(138, 'administrator', '2017-06-05 13:35:35', 'logged in'),
(139, 'administrator', '2017-06-05 13:36:13', 'logged in'),
(140, 'administrator', '2017-06-05 13:37:44', 'logged in'),
(141, 'administrator', '2017-06-05 13:39:22', 'logged in'),
(142, 'administrator', '2017-06-07 09:25:35', 'logged in'),
(143, 'administrator', '2017-06-07 12:36:03', 'created software asset testasset version 1'),
(144, 'administrator', '2017-06-07 12:36:51', 'edited software asset testasset2 (version 2)'),
(145, 'administrator', '2017-06-07 13:01:10', 'logged in'),
(146, 'administrator', '2017-06-07 13:43:16', 'created hardware asset testhardware version 1'),
(147, 'administrator', '2017-06-07 13:43:44', 'edited hardware asset testhardware2 (version 2)'),
(148, 'administrator', '2017-06-07 13:44:30', 'edited hardware asset testhardware2 (version 3)'),
(149, 'administrator', '2017-06-07 13:47:45', 'edited hardware asset testhardware (version 4)'),
(150, 'administrator', '2017-06-07 13:52:46', 'edited software asset testasset (version 3)'),
(151, 'administrator', '2017-06-08 09:30:01', 'logged in'),
(152, 'administrator', '2017-06-08 11:41:49', 'logged in'),
(153, 'administrator', '2017-06-12 08:36:46', 'logged in'),
(154, 'administrator', '2017-06-12 13:51:17', 'generated report for purchaseorder_id 4500675179'),
(155, 'administrator', '2017-06-12 13:52:22', 'generated report for purchaseorder_id 4500675179'),
(156, 'administrator', '2017-06-12 13:52:56', 'generated report for purchaseorder_id 4500675179'),
(157, 'administrator', '2017-06-12 13:53:47', 'generated report for purchaseorder_id 4500675179'),
(158, 'administrator', '2017-06-12 13:54:46', 'generated report for purchaseorder_id 4500675179'),
(159, 'administrator', '2017-06-13 09:39:00', 'logged in'),
(160, 'administrator', '2017-06-13 11:07:08', 'created software asset 123 version 1'),
(161, 'administrator', '2017-06-13 11:38:09', 'edited software asset 123 (version 2)'),
(162, 'administrator', '2017-06-13 11:39:33', 'edited software asset 123 (version 3)'),
(163, 'administrator', '2017-06-13 11:41:59', 'edited software asset testasset (version 4)'),
(164, 'administrator', '2017-06-13 12:01:22', 'edited hardware asset testhardware (version 5)'),
(165, 'administrator', '2017-06-19 09:32:52', 'logged in'),
(166, 'administrator', '2017-06-19 13:22:52', 'edited hardware asset NEHR1620022 (version 2)'),
(167, 'administrator', '2017-06-19 13:41:16', 'edited software asset NEHR001 (version 2)'),
(168, 'administrator', '2017-06-19 13:41:34', 'edited software asset NEHR001 (version 3)'),
(169, 'administrator', '2017-06-19 15:11:59', 'edited hardware asset NEHR1620020 (version 2)'),
(170, 'administrator', '2017-06-19 15:12:14', 'edited hardware asset NEHR1620019 (version 2)'),
(171, 'administrator', '2017-06-19 17:31:35', 'generated report for purchaseorder_id 4501202428'),
(172, 'administrator', '2017-06-19 17:31:57', 'generated report for crtrno CR210'),
(173, 'administrator', '2017-06-19 17:48:37', 'logged in'),
(174, 'administrator', '2017-06-21 10:15:48', 'logged in'),
(175, 'administrator', '2017-06-21 11:13:44', 'added option  for server'),
(176, 'administrator', '2017-06-21 11:14:34', 'removed option  for server'),
(177, 'administrator', '2017-06-21 11:14:46', 'added option  for server'),
(178, 'administrator', '2017-06-21 11:14:56', 'removed option 5 for server'),
(179, 'administrator', '2017-06-21 11:32:34', 'added option john for server'),
(180, 'administrator', '2017-06-21 11:32:39', 'removed option 6 for server'),
(181, 'administrator', '2017-06-21 11:43:23', 'removed option 19 for releaseversion'),
(182, 'administrator', '2017-06-21 11:53:28', 'removed option 1035 for status'),
(183, 'administrator', '2017-06-21 13:45:40', 'created software asset nehr0001 version 1'),
(184, 'administrator', '2017-06-21 13:50:22', 'created hardware asset nehr0002 version 1'),
(185, 'administrator', '2017-06-22 19:03:15', 'logged in'),
(186, 'administrator', '2017-06-22 19:31:18', 'edited hardware asset nehr0002 (version 2)'),
(187, 'administrator', '2017-06-22 19:34:05', 'edited hardware asset nehr0002 (version 3)'),
(188, 'administrator', '2017-06-22 19:34:28', 'edited hardware asset nehr0002 (version 4)'),
(189, 'administrator', '2017-06-22 20:20:15', 'edited software asset nehr0001 (version 2)'),
(190, 'administrator', '2017-06-22 20:24:06', 'generated report for release_version CR497'),
(191, 'administrator', '2017-06-22 20:24:15', 'generated report for purchaseorder_id 12345'),
(192, 'administrator', '2017-06-22 20:25:37', 'generated report for purchaseorder_id 12345'),
(193, 'administrator', '2017-06-22 20:28:46', 'generated report for purchaseorder_id 12345'),
(194, 'administrator', '2017-06-22 20:29:40', 'generated report for purchaseorder_id 12345'),
(195, 'administrator', '2017-06-22 20:32:36', 'generated report for purchaseorder_id 12345'),
(196, 'administrator', '2017-06-22 20:56:40', 'edited hardware asset nehr0002 (version 5)');

-- --------------------------------------------------------

--
-- Table structure for table `procured_from`
--

CREATE TABLE `procured_from` (
  `procured_from_id` int(11) NOT NULL,
  `procured_from_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procured_from`
--

INSERT INTO `procured_from` (`procured_from_id`, `procured_from_name`) VALUES
(8, 'FortySoftware Inc.'),
(9, 'Initiate'),
(10, 'IBM'),
(11, 'Informatica'),
(12, 'HP/AVNet'),
(13, 'HP'),
(14, 'Oracle'),
(15, 'Orion'),
(16, 'Pic and Pixel'),
(17, 'Plimus'),
(18, 'Mtech'),
(19, 'CIO'),
(20, 'Unisoft'),
(21, 'Verisign'),
(22, 'Data Protection'),
(23, 'Quantiq International'),
(24, 'Compuware Asia-Pacific Pte Ltd'),
(25, 'Clinithink'),
(26, 'Object Planet'),
(27, 'Sis Tech'),
(28, 'ECS'),
(29, 'Avnet'),
(30, 'IngramMicro'),
(31, 'PegaSystems'),
(32, 'Netrust'),
(33, 'PrivyLink'),
(34, 'Tableau'),
(35, 'CA'),
(36, 'UIC'),
(37, 'Symantec'),
(38, 'Liferay'),
(39, 'Elastic'),
(40, 'Symantec Website Security Solution'),
(41, 'IRI'),
(42, 'Netpolean'),
(43, 'Assurity'),
(44, 'IXIX'),
(45, 'Accel'),
(46, 'Carestream');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `purchaseorder_id` text NOT NULL,
  `discount` text,
  `total` text,
  `filecontent` mediumblob,
  `filename` text,
  `filesize` text,
  `filetype` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`purchaseorder_id`, `discount`, `total`, `filecontent`, `filename`, `filesize`, `filetype`) VALUES
('4500675179', '102', '12', NULL, NULL, NULL, NULL),
('4500721647', '2', NULL, NULL, NULL, NULL, NULL),
('4500659011', NULL, NULL, 0x5265736f75726365206964202336, 'ams (2).sql', '531030', 'application/octet-stream');

-- --------------------------------------------------------

--
-- Table structure for table `purpose`
--

CREATE TABLE `purpose` (
  `purpose_id` int(11) NOT NULL,
  `purpose_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purpose`
--

INSERT INTO `purpose` (`purpose_id`, `purpose_name`) VALUES
(5, 'No Information'),
(6, 'Patient Provider Facility Registry'),
(7, 'Testing'),
(8, 'Data Migration'),
(9, 'ADT'),
(10, 'Client Access licenses'),
(11, 'Operations'),
(12, 'Operating System'),
(13, 'Clinical Data Repository'),
(14, 'Identity and Access Management'),
(15, 'Database'),
(16, 'Security'),
(17, 'Virtualization'),
(18, 'Service Registry'),
(19, 'SOA'),
(20, 'Application Server'),
(21, 'Clinical Portal'),
(22, 'Not listed'),
(23, 'BI'),
(24, 'ODS'),
(25, 'ODS Database'),
(26, 'End User Monitoring'),
(27, 'Mailing service'),
(28, 'Training'),
(29, 'Survey Tool'),
(30, 'CCMS'),
(31, 'Imaging');

-- --------------------------------------------------------

--
-- Table structure for table `releaseversion`
--

CREATE TABLE `releaseversion` (
  `releaseversion_id` int(11) NOT NULL,
  `releaseversion_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `releaseversion`
--

INSERT INTO `releaseversion` (`releaseversion_id`, `releaseversion_name`) VALUES
(1, 'P1 license term summary'),
(2, 'Not available'),
(3, 'Release 1.2 license'),
(4, 'P2 license summary'),
(5, 'Temp SIT licenses'),
(6, 'Operations'),
(7, 'Temp license'),
(8, 'Release 1.8 licenses'),
(9, 'P3 license summary'),
(10, 'Release 1.5 license'),
(11, 'Release 1.5A licenses'),
(12, 'Release 1.6 license'),
(13, 'Release 1.8D licenses'),
(14, 'Release 1.7 licenses'),
(15, 'Release 1.8C licenses'),
(16, 'Release 1.8E licenses'),
(17, 'Release 1.8F licenses'),
(18, 'Release 1.9 licenses'),
(20, 'Not Applicable'),
(21, 'NA'),
(22, 'R1.8'),
(23, 'R1.9'),
(24, 'R1.7'),
(25, 'Drop1A- PDC'),
(26, 'R1.0'),
(27, 'R1.5'),
(28, 'R1.6'),
(29, 'TR13'),
(30, 'CR497'),
(31, 'Part of HP Contract SAID: 1062 9911 8158 (1060 7091 3060)'),
(32, 'Drop 1B- PDC'),
(33, 'R1.0A'),
(34, 'CR359 3 Year Ops'),
(35, 'R1.5B'),
(36, 'Drop 1B- SDC'),
(37, 'R1.0B'),
(38, 'R1.8e'),
(39, 'CR346-TR14'),
(40, 'CR491'),
(41, 'TR24');

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE `server` (
  `server_id` int(11) NOT NULL,
  `server_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`server_id`, `server_name`) VALUES
(3, '10.10.1.1');

-- --------------------------------------------------------

--
-- Table structure for table `shortname`
--

CREATE TABLE `shortname` (
  `shortname_id` int(11) NOT NULL,
  `shortname_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shortname`
--

INSERT INTO `shortname` (`shortname_id`, `shortname_name`) VALUES
(3, 'Forty 360 SCA'),
(4, 'Initiate'),
(5, 'IBM'),
(6, 'Informatica'),
(7, 'MSProject'),
(8, 'RemoteDesktop'),
(9, 'Sharepoint'),
(10, 'Windows'),
(11, 'HTB'),
(12, 'Oracle'),
(13, 'Oracle Advanced Security'),
(14, 'Oracle Database'),
(15, 'Oracle Database Vault'),
(16, 'Oracle IAM (OIF,OIM)'),
(17, 'Oracle IAMS (OID)'),
(18, 'Oracle Partitioning'),
(19, 'Oracle RAC'),
(20, 'Oracle VM Manager'),
(21, 'Service Registry'),
(22, 'SOA'),
(23, 'WebLogic'),
(24, 'Concerto'),
(25, 'Adobe Captivate'),
(26, 'Sysax'),
(27, 'RedHat'),
(28, 'RSA Authentication Manager'),
(29, 'Crystal'),
(30, 'Symantec CSP'),
(31, 'Symantec DCS'),
(32, 'Symantec SEP'),
(33, 'Symantec CCS'),
(34, 'Symantec CCS DB'),
(35, 'Symantec ESM'),
(36, 'CIO'),
(37, 'Fieldshield'),
(38, 'Certificate'),
(39, 'DataProtect'),
(40, 'Oracle Active Dataguard'),
(41, 'Oracle Advanced Compression'),
(42, 'Oracle OBIEE'),
(43, 'Cyber-Ark PIM'),
(44, 'Fieldshield Linux'),
(45, 'Gomez'),
(46, 'Crystal Server Linux'),
(47, 'Exchange'),
(48, 'SQL Server'),
(49, 'CLiX'),
(50, 'Opinio'),
(51, 'VMware'),
(52, 'TrendMicro'),
(53, 'BlueCoat'),
(54, 'CA Layer 7'),
(55, 'Pega'),
(56, 'NAM'),
(57, 'SLIFT'),
(58, 'Tableau'),
(59, 'Oracle AMS'),
(60, 'Liferay'),
(61, 'Elasticsearch'),
(62, 'Compuware'),
(63, 'Cyberark'),
(64, 'Assurity'),
(65, 'Orion'),
(66, 'Excel'),
(67, 'Splunk'),
(68, 'Carestream'),
(69, 'F5');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `asset_tag` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `vendor` text,
  `procured_from` text,
  `shortname` text,
  `purpose` text,
  `contract_type` text,
  `start_date` text,
  `license_explanation` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`asset_tag`, `version`, `vendor`, `procured_from`, `shortname`, `purpose`, `contract_type`, `start_date`, `license_explanation`) VALUES
(1664, 1, 'CIO', 'Accel', 'Adobe Captivate', 'ADT', 'Software', '06/21/2017', 'License'),
(1664, 2, 'CIO', 'Accel', 'Adobe Captivate', 'ADT', 'Software', '06/21/2017', 'License');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1031, 'Commissioned'),
(1032, 'Offsite'),
(1033, 'Decommissioned'),
(1034, 'For Testing'),
(1036, 'TBC');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `username`, `password`, `role`, `status`) VALUES
(7, 'administrator', '$2y$10$erUI0n/bfyZRLXZEFUx7OeEGMmOmLZHO/ksSkT2Kykk4ko1fzz9zu', 'admin', 'active'),
(10, 'test_user', '$2y$10$wlJK44h4TwQBpd55ui0omOok1agSZZxTG5QM7LBAPpYGtQ.RaPTmO', 'user', 'active'),
(11, 'test_admin', '$2y$10$pR4t//Rl1CV6XkxvGyn/Iu6u0KVSyOjYtYJciF7uh9t/Arp00aD/.', 'admin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`) VALUES
(6, 'FortySoftware Inc.'),
(7, 'IBM'),
(8, 'Informatica'),
(9, 'Microsoft'),
(10, 'Oracle'),
(11, 'Orion'),
(12, 'Pic and Pixel'),
(13, 'Plimus'),
(14, 'Red Hat'),
(15, 'RSA'),
(16, 'SAP'),
(17, 'Symantec'),
(18, 'CIO'),
(19, 'Fieldshield  (Unisoft)'),
(20, 'Symantec (Verisign)'),
(21, 'HP'),
(22, 'Cyber-Ark Software'),
(23, 'Fieldshield'),
(24, 'Compuware'),
(25, 'Clinithink'),
(26, 'ObjectPlanet'),
(27, 'VMware'),
(28, 'TrendMicro'),
(29, 'CA'),
(30, 'Option1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD KEY `asset_tag` (`asset_tag`);

--
-- Indexes for table `asset_version`
--
ALTER TABLE `asset_version`
  ADD PRIMARY KEY (`asset_tag`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `contracttype`
--
ALTER TABLE `contracttype`
  ADD PRIMARY KEY (`contracttype_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `hardware`
--
ALTER TABLE `hardware`
  ADD KEY `asset_tag` (`asset_tag`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_ID`);

--
-- Indexes for table `procured_from`
--
ALTER TABLE `procured_from`
  ADD PRIMARY KEY (`procured_from_id`);

--
-- Indexes for table `purpose`
--
ALTER TABLE `purpose`
  ADD PRIMARY KEY (`purpose_id`);

--
-- Indexes for table `releaseversion`
--
ALTER TABLE `releaseversion`
  ADD PRIMARY KEY (`releaseversion_id`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`server_id`);

--
-- Indexes for table `shortname`
--
ALTER TABLE `shortname`
  ADD PRIMARY KEY (`shortname_id`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD KEY `asset_tag` (`asset_tag`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_version`
--
ALTER TABLE `asset_version`
  MODIFY `asset_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1666;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `contracttype`
--
ALTER TABLE `contracttype`
  MODIFY `contracttype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;
--
-- AUTO_INCREMENT for table `procured_from`
--
ALTER TABLE `procured_from`
  MODIFY `procured_from_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `purpose`
--
ALTER TABLE `purpose`
  MODIFY `purpose_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `releaseversion`
--
ALTER TABLE `releaseversion`
  MODIFY `releaseversion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `server_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `shortname`
--
ALTER TABLE `shortname`
  MODIFY `shortname_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1037;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset`
--
ALTER TABLE `asset`
  ADD CONSTRAINT `asset_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset_version` (`asset_tag`);

--
-- Constraints for table `hardware`
--
ALTER TABLE `hardware`
  ADD CONSTRAINT `hardware_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset_version` (`asset_tag`);

--
-- Constraints for table `software`
--
ALTER TABLE `software`
  ADD CONSTRAINT `software_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset_version` (`asset_tag`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
