-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2017 at 05:30 AM
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
  `asset_ID` varchar(200) NOT NULL,
  `description` text,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `purchaseorder_id` text,
  `release_version` text,
  `expirydate` text,
  `remarks` text,
  `crtrno` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`asset_tag`, `asset_ID`, `description`, `quantity`, `price`, `purchaseorder_id`, `release_version`, `expirydate`, `remarks`, `crtrno`) VALUES
(2, 'NEHR179', 'Opinio 6 Enterprise', 3, 0, '4501108174', 'Release 1.5A licenses', '06/30/17', '', 'CR167'),
(3, 'NEHR213a', 'Blue Coat WebFilter, 50-99 Users', 50, 0, '4501490736', 'Release 1.8D licenses', '06/30/2017', '\"Q8353-VZC9Y\r\nFor DEV\"', 'CR346'),
(4, 'NEHR287', 'Year 1  Yearly Maintenance Opinio 6 Enterprise', 3, 0, '4501354108', 'Release 1.8 licenses', '06/30/2015', 'Ops Ext July 14 - June 17', 'CR359'),
(5, 'NEHR288', 'Year 2  Yearly Maintenance Opinio 6 Enterprise', 3, 0, '4501354108', 'Release 1.8 licenses', '06/30/2016', 'Ops Ext July 14 - June 17', 'CR359'),
(6, 'NEHR289', 'Year 3  Yearly Maintenance Opinio 6 Enterprise', 3, 0, '4501354108', 'Release 1.8 licenses', '06/30/2017', 'Ops Ext July 14 - June 17', 'CR359'),
(7, 'NEHR380', 'ADDITIONAL SYMANTEC MANAGED PKI FOR PREMIUM CERT UNITS Secure Site Pro Â· 128 Bit encryption - minimum encryption Â· USD$1,500,000 Protection Plan Â· Symantec Authentication Service Â· Free Symantec Customer Care', 25, 0, '4501759195', 'Release 1.8 licenses', '08/03/2017', 'Ops Ext July 14 - June 17', 'CR359'),
(8, 'NEHR442', 'Privileged Session Manager (PSM) Licenses', 10, 0, '4501858124', '', '07/31/2019', 'CyberArk Support Certificate Number: S012012228', 'CR545'),
(9, 'NEHR443', 'Renewal Service, Blue Coat WebFilter, 50-99 Users, 1 Yr. (45 days)', 50, 0, '4501846955', 'Release 1.8D licenses', '06/30/2017', '', 'CR346'),
(10, 'NEHR1620018', 'FG-100D-BDL-UK\r\n20 x GE RJ45 ports (including 1 x DMZ port, 1 x Mgmt port, 2 x HA port, 16 x internal switch ports)\r\n2 x shared media pairs (including 2 x GE RJ45, 2 x GE SFP slots)\r\n32GB onboard', 1, 2814.84, '4501488459 Renewal 4501844224 ( 2Apr17-30Jun17)', 'R1.8', '06/30/2017', '', 'CR346'),
(11, 'NEHR1620019', 'FG-100D-BDL-UK\r\n20 x GE RJ45 ports (including 1 x DMZ port, 1 x Mgmt port, 2 x HA port, 16 x internal switch ports)\r\n2 x shared media pairs (including 2 x GE RJ45, 2 x GE SFP slots)\r\n32GB onboard ', 1, 2814.84, '\"4501488459 Renewal 4501844224 ( 2Apr17-30Jun17)\"', 'R1.8', '06/30/2017', '', 'CR346'),
(12, 'NEHR1120122', '1 x HP BL460c Gen9 10Gb/20Gb FLB CTO Blade\r\n1 x HP BL460c Gen9 E5-2650v3 FIO Kit\r\n1 x HP BL460c Gen9 E5-2650v3 Kit\r\n16 x HP 16GB 2Rx4 PC4-2133P-R Kit\r\n2 x HP 600GB 6G SAS 10K 2.5in SC ENT HDD\r\n1 x HP FlexFabric 20Gb 2P 650FLB FIO Adptr\r\n1 x HP Smart Array P244br/1G FIO Controller\r\n1 x HP QMH2672 16Gb FC HBA', 1, 11500, '4501467049', 'R1.7', '04/20/2018', 'DR_P1(Servers)', 'CR316'),
(13, 'NEHR1220096', 'Details: HP 3PAR 8000 1.92TB SAS cMLC SFF FE SSD Disk Enclosure\r\nPart/Product Number: Not Applicable\r\nSoftware: Not Applicable', 1, 4094.583333, '4501678836', 'R1.9', '05/10/2019', '', 'CR337'),
(14, 'NEHR1320064', '1x ISR4431/K9 CISCO ISR 4431 (4GE 3NIM 8G FLASH 4G DRAM IPB) \"\"\r\n1x NIM-2GE-CU-SFP CISCO 2-PORT GIGABIT ETHERNET WAN NETWORK INTERFACE MODULE \r\n2x PWR-4430-AC AC POWER SUPPLY FOR CISCO ISR 4430\r\n2x CAB-ACU AC Power Cord (UK), C13, BS 1363, 2.5m\r\n1x SL-44-SEC-K9 SECURITY LICENSE (PAPER) FOR CISCO 4451-X (SYSTEM)', 1, 21548, '4501800219', '', '10/24/2017', '', 'TR17'),
(15, 'NEHR1320064', '1x FL-44-HSEC-K9 US Export Restriction Compliance License 4400 Series (3861J49F8F9)', 1, 513.75, '4501829017', '', '10/24/2017', '', 'TR17'),
(16, 'NEHR1320001', '3845 Bund. w/AIM-VPN/SSL-3,Adv. IP Serv,25 SSL lic,128F/512D (CISCO3845-HSEC/K9)\r\nCisco 3845 AISK9-AISK9 FEAT SET FACTORY UPG FOR BUNDLES (S384RAISK9-12415XZ)\r\nCisco3845 redundant AC power supply (PWR-3845-AC/2)\r\nAC Power Cord (UK), C13, BS 1363, 2.5m (CAB-ACU)\r\nCD for SDM software (ROUTER-SDM-CD)\r\nCisco 3845 AC power supply (PWR-3845-AC)\r\nDES/3DES/AES/SSL VPN Encryption/Compression (AIM-VPN/SSL-3) ', 1, 13350, '4500659011', 'Drop1A- PDC', '06/30/2017', 'Dev_SITUAT(Network)', 'Not Applicable'),
(17, 'NEHR1320001', 'Two 10/100 routed port HWIC (HWIC-2FE=)\r\nFeature License IOS SSL VPN Up To 25 Users (Incremental) (FL-WEBVPN-25-K9)', 1, 986.58, '4500659011', 'Drop1A- PDC', '05/24/2017', 'Dev_SITUAT(Network)', 'Not Applicable'),
(18, 'NEHR1320001', '10/100 routed port HWIC (For ISR 3845) - Additional WIC for Cisco ISR 3845 Router at PDC (HWIC-2FE=)', 1, 0, '4501050583', 'R1.5', '06/30/2017', 'Dev_SITUAT(Network)', 'CR167'),
(19, 'hardwareassetid2', 'description', 1, 4, 'purchaseorderid', '0.2', '06/01/2017', 'something like that', 'cr123');

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
  `status` text,
  `replacing` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hardware`
--

INSERT INTO `hardware` (`asset_tag`, `class`, `brand`, `audit_date`, `component`, `label`, `serial`, `location`, `status`, `replacing`) VALUES
(10, 'Firewall', 'Fortigate', '', 'DMZ2 DEV', 'sdc-dev-idmz2-f02', 'FG100D3G14830642', 'R0951, U37 (Level 4) (SDC)', 'Commissioned', 'Not Applicable'),
(11, 'Firewall', 'Fortigate', '', 'DMZ2 DEV/DR', 'SDC-DMZ2-MGT-F01', 'FG100D3G14826275', 'R0951, U28 (Level 4) (SDC)', 'Commissioned', 'Not Applicable'),
(12, 'Server', 'HP', 'MOHH Sighted, 1 Jul 2016', 'BL460c G9', 'R801', 'SGH621W96H', 'R0950, U02 - 07, Bay 5 (Level 4) (SDC)', 'Commissioned', 'RMA SGH504W8MN'),
(13, 'Storage', 'HP', 'MOHH Sighted, 8 Jul 2016', '3PAR StoreServ 8000 - Disk Enclosure - Componenet', 'Disk Enclosure', 'EEAUBA1TF9Q5LW', 'R0753, U30 - 31 (Level 3) (PDC)', 'Commissioned', 'Not Applicable'),
(14, 'Router', 'Cisco', 'Not in scope of Jul \'16 sighting', 'ISR4431/K9 Wan Router', 'pdc-wan-r01', 'FGL2015111B', 'R0556, U36 Level 3 (PDC)', 'Commissioned', 'Refresh / NEHR1320001'),
(15, 'Router\r\n', 'Cisco\r\n', 'Not in scope of Jul \'16 sighting\r\n', 'ISR4431/K9 Wan Router - Component\r\n', 'pdc-wan-r01\r\n', 'FGL2015111B\r\n', 'R0556, U36 Level 3 (PDC)\r\n', 'Commissioned\r\n', 'Refresh / NEHR1320001\r\n'),
(16, 'Router', 'Cisco', 'MOHH Sighted, 8 Jul 2016', 'C3845-HSEC/K9 Wan Routers', 'pdc-wan-r01', 'FHK1434F2NG', 'R0555, U03 - 05 (Level 3) (PDC)', 'Pending decommission', 'Not Applicable'),
(17, 'Router', 'Cisco', 'MOHH Sighted, 8 Jul 2016', 'C3845-HSEC/K9 Router - Component', 'pdc-wan-r01', 'FHK1434F2NG', 'R0555, U03 - 05 (Level 3) (PDC)', 'Pending decommission', 'Not Applicable'),
(18, 'Router', 'Cisco', 'MOHH Sighted, 8 Jul 2016', 'C3845-HSEC/K9  Router - Component', 'pdc-wan-r01', 'FHK1434F2NG', 'R0555, U03 - 05 (Level 3) (PDC)', 'Pending decommission', 'Not Applicable'),
(19, 'Switch', 'cisco', 'Not in scope of Jul \'16 sighting', '9120', 'NEHR-Switch-3', '123456789abcde', 'Storage', 'Pending Comission', 'Nil');

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
(1, 'john', '2017-05-16 09:28:36', 'logged in'),
(2, 'john', '2017-05-16 09:36:03', 'logged in'),
(3, 'john', '2017-05-16 09:36:59', 'logged in'),
(4, 'john', '2017-05-16 09:37:43', 'created admin administrator'),
(5, 'john', '2017-05-16 09:37:56', 'created user User'),
(6, 'User', '2017-05-16 09:38:05', 'logged in'),
(7, 'User', '2017-05-16 09:39:52', 'logged in'),
(8, 'john', '2017-05-17 04:02:47', 'logged in'),
(9, 'john', '2017-05-17 04:14:51', 'changed password'),
(10, 'administrator', '2017-05-17 04:15:52', 'logged in'),
(11, 'User', '2017-05-17 04:16:13', 'logged in'),
(12, 'User', '2017-05-17 04:16:24', 'changed password'),
(13, 'administrator', '2017-05-17 04:19:21', 'logged in'),
(14, 'administrator', '2017-05-17 04:19:47', 'created admin johnny'),
(15, 'johnny', '2017-05-17 04:19:55', 'logged in'),
(16, 'johnny', '2017-05-17 04:20:11', 'changed password'),
(17, 'administrator', '2017-05-17 04:21:31', 'logged in'),
(18, 'administrator', '2017-05-17 04:21:57', 'created user test_user'),
(19, 'test_user', '2017-05-17 04:22:08', 'logged in'),
(20, 'test_user', '2017-05-17 04:22:23', 'changed password'),
(21, 'test_user', '2017-05-17 04:22:32', 'logged in'),
(22, 'test_user', '2017-05-17 04:38:07', 'logged in'),
(23, 'administrator', '2017-05-17 05:27:13', 'logged in'),
(24, 'administrator', '2017-05-17 09:01:25', 'edited user test_user'),
(25, 'administrator', '2017-05-17 09:05:33', 'edited user test_user'),
(26, 'administrator', '2017-05-17 09:05:41', 'edited user test_user'),
(27, 'administrator', '2017-05-17 09:05:44', 'edited user test_user'),
(28, 'administrator', '2017-05-17 09:15:13', 'edited user test_user to test_user2'),
(29, 'administrator', '2017-05-17 09:15:38', 'edited user test_user2 to test_user'),
(30, 'administrator', '2017-05-17 09:15:46', 'edited user test_user'),
(31, 'administrator', '2017-05-17 09:15:50', 'edited user test_user'),
(32, 'administrator', '2017-05-17 09:15:53', 'edited user test_user'),
(33, 'administrator', '2017-05-17 09:16:09', 'edited user test_user to test_user2'),
(34, 'administrator', '2017-05-17 09:16:19', 'edited user test_user2'),
(35, 'administrator', '2017-05-17 09:16:26', 'edited user test_user2'),
(36, 'administrator', '2017-05-17 09:17:10', 'edited user test_user2 to test_user'),
(37, 'administrator', '2017-05-17 09:17:30', 'edited user test_user'),
(38, 'administrator', '2017-05-17 09:17:49', 'logged in'),
(39, 'administrator', '2017-05-17 09:21:46', 'edited user test_user'),
(40, 'administrator', '2017-05-17 09:22:20', 'logged in'),
(41, 'administrator', '2017-05-17 09:22:30', 'edited user test_user'),
(42, 'test_user', '2017-05-17 09:22:40', 'logged in'),
(43, 'administrator', '2017-05-17 09:23:12', 'logged in'),
(44, 'test_user', '2017-05-17 09:24:08', 'logged in'),
(45, 'test_user', '2017-05-17 09:29:50', 'logged in'),
(46, 'test_user', '2017-05-17 09:30:13', 'logged in'),
(47, 'administrator', '2017-05-17 09:30:24', 'logged in'),
(48, 'administrator', '2017-05-17 09:31:44', 'created admin test_admin'),
(49, 'test_user', '2017-05-18 03:49:50', 'logged in'),
(50, 'administrator', '2017-05-18 03:56:33', 'logged in'),
(51, 'administrator', '2017-05-18 04:04:34', 'logged in'),
(52, 'administrator', '2017-05-18 04:05:52', 'logged in'),
(53, 'administrator', '2017-05-18 04:07:00', 'logged in'),
(54, 'administrator', '2017-05-18 04:07:44', 'logged in'),
(55, 'administrator', '2017-05-18 04:08:56', 'logged in'),
(56, 'test_admin', '2017-05-18 06:47:58', 'logged in'),
(57, 'administrator', '2017-05-18 07:46:19', 'logged in'),
(58, 'test_user', '2017-05-18 07:48:02', 'logged in'),
(59, 'administrator', '2017-05-22 03:20:03', 'logged in'),
(60, 'administrator', '2017-05-23 03:32:23', 'logged in'),
(61, 'administrator', '2017-05-23 09:39:42', 'logged in'),
(62, 'administrator', '2017-05-23 10:48:25', 'logged in'),
(63, 'administrator', '2017-05-23 15:44:57', 'created software asset asset1'),
(64, 'administrator', '2017-05-24 09:35:14', 'logged in'),
(65, 'administrator', '2017-05-24 11:05:30', 'created software asset NEHR179'),
(66, 'administrator', '2017-05-24 11:11:00', 'created software asset NEHR213a'),
(67, 'administrator', '2017-05-24 11:12:45', 'created software asset NEHR287'),
(68, 'administrator', '2017-05-24 11:14:43', 'created software asset NEHR288'),
(69, 'administrator', '2017-05-24 11:16:20', 'created software asset NEHR289'),
(70, 'administrator', '2017-05-24 11:17:38', 'created software asset NEHR380'),
(71, 'administrator', '2017-05-24 11:18:54', 'created software asset NEHR442'),
(72, 'administrator', '2017-05-24 11:20:14', 'created software asset NEHR443'),
(73, 'administrator', '2017-05-24 11:53:31', 'created hardware asset NEHR1620018'),
(74, 'administrator', '2017-05-24 11:59:10', 'created hardware asset NEHR1620019'),
(75, 'administrator', '2017-05-24 12:14:03', 'created hardware asset NEHR1120122'),
(76, 'administrator', '2017-05-24 12:15:08', 'created hardware asset NEHR1220096'),
(77, 'administrator', '2017-05-24 12:16:18', 'created hardware asset NEHR1320064'),
(78, 'administrator', '2017-05-24 12:16:53', 'created software asset NEHR1320064'),
(79, 'administrator', '2017-05-24 12:21:44', 'created hardware asset NEHR1320001'),
(80, 'administrator', '2017-05-24 12:22:37', 'created hardware asset NEHR1320001'),
(81, 'administrator', '2017-05-24 12:23:57', 'created hardware asset NEHR1320001'),
(82, 'administrator', '2017-05-24 12:30:14', 'created software asset asset'),
(83, 'administrator', '2017-05-25 10:32:50', 'logged in'),
(84, 'administrator', '2017-05-25 10:34:05', 'created hardware asset hardwareassetid'),
(85, 'administrator', '2017-05-25 11:19:31', 'edited hardware asset  to hardwareassetid'),
(86, 'administrator', '2017-05-25 11:21:12', 'edited hardware asset hardwareassetid'),
(87, 'administrator', '2017-05-25 11:27:14', 'edited hardware asset hardwareassetid'),
(88, 'administrator', '2017-05-25 11:27:23', 'edited hardware asset hardwareassetid to hardwareassetid2');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `asset_tag` int(11) NOT NULL,
  `vendor` text,
  `procured_from` text,
  `shortname` text,
  `purpose` text,
  `contract_type` text,
  `start_date` text,
  `license_explanation` text,
  `verification` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`asset_tag`, `vendor`, `procured_from`, `shortname`, `purpose`, `contract_type`, `start_date`, `license_explanation`, `verification`) VALUES
(2, 'ObjectPlanet\r\n', 'Object Planet\r\n', 'Opinio\r\n', 'Survey Tool\r\n', 'Software & Support\r\n', '03/05/2013', 'PO4501354108 (30Jun14- 30un17)\r\n', 'Verified\r\n'),
(3, 'BlueCoat', 'Mtech', 'BlueCoat', 'Security', 'Software & Support', '05/17/2015', 'PO4501846955 (17May17-30Jun17) PO4501695106 (17May16-16May17) Perpetual user license.', 'Verified'),
(4, 'ObjectPlanet', 'Object Planet', 'Opinio', 'Operations', 'Software', '06/30/2014', 'Refer to PO4501108174', 'Verified'),
(5, 'ObjectPlanet', 'Object Planet', 'Opinio', 'Operations', 'Support', '07/01/2015', 'Refer to PO4501108174', 'Verified'),
(6, 'ObjectPlanet', 'Object Planet', 'Opinio', 'Operations', 'Software', '07/01/2016', 'Refer to PO4501108174', 'Verified'),
(7, 'Symantec', 'Symantec Website Security Solution', 'Certificate', 'Operations', 'Software & Support', '08/04/2016', 'Expires 1 year after purchase. No renewal done as it has to be a constant purchase.', 'No renewal required'),
(8, 'Cyber-Ark Software', 'Netpolean', 'Cyberark', 'Security', 'Software', '04/01/2017', 'First Purchase', 'Verified'),
(9, 'BlueCoat', 'Mtech', 'BlueCoat', 'Security', 'Support', '05/17/2017', 'Refer to PO4501490736', 'Verified');

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
(11, 'test_admin', '$2y$10$udHkhqLA0SFi.Ujoe6gR6.Fo5xUrV12DVyOEO6vN2jEHMAUU5jUF6', 'admin', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`asset_tag`);

--
-- Indexes for table `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`asset_tag`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_ID`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`asset_tag`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset`
--
ALTER TABLE `asset`
  MODIFY `asset_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `software`
--
ALTER TABLE `software`
  MODIFY `asset_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `hardware`
--
ALTER TABLE `hardware`
  ADD CONSTRAINT `hardware_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset` (`asset_tag`);

--
-- Constraints for table `software`
--
ALTER TABLE `software`
  ADD CONSTRAINT `software_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset` (`asset_tag`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
