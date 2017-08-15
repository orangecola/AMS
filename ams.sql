-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `gpc_Asset` (
  `gpc_asset_tag` int(11) NOT NULL,
  `gpc_version` int(11) NOT NULL DEFAULT '1',
  `gpc_Environment` varchar(50) NOT NULL,
  `gpc_Tier` varchar(50) NOT NULL,
  `gpc_Phase` varchar(50) NOT NULL,
  `gpc_Item` text NOT NULL,
  `gpc_Remarks` text,
  `gpc_Ami` varchar(50) NOT NULL,
  `gpc_Startdate` varchar(20) NOT NULL,
  `gpc_Expirydate` varchar(20) NOT NULL,
  `gpc_halb` varchar(10) NOT NULL,
  `gpc_quantity` int(11) NOT NULL,
  `gpc_Application` int(11) NOT NULL,
  `gpc_Data` int(11) NOT NULL,
  `gpc_IOPS` int(11) NOT NULL,
  `gpc_Backup` int(11) NOT NULL,
  `gpc_OS` varchar(50) NOT NULL,
  `gpc_Y1_Qt` int(11) NOT NULL,
  `gpc_Y2_Qt` int(11) NOT NULL,
  `gpc_Y1_Ops` varchar(50) NOT NULL,
  `gpc_Y2_Ops` varchar(50) NOT NULL,
  `gpc_Gwgc` varchar(50) NOT NULL,
  `gpc_Lastedited` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `gpc_Asset_version` (
  `gpc_asset_tag` int(11) NOT NULL AUTO_INCREMENT,
  `current_version` int(11) NOT NULL,
  PRIMARY KEY (`gpc_asset_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;


CREATE TABLE `gpc_Options` (
  `gpc_Options_Id` int(11) NOT NULL AUTO_INCREMENT,
  `gpc_Options_Name` text NOT NULL,
  `gpc_Options_Type` text NOT NULL,
  PRIMARY KEY (`gpc_Options_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;


CREATE TABLE `ihis_Log` (
  `log_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `time` text NOT NULL,
  `log` text NOT NULL,
  PRIMARY KEY (`log_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6482 DEFAULT CHARSET=latin1;


CREATE TABLE `ihis_User` (
  `user_ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Asset` (
  `asset_tag` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `lastedited` text,
  `asset_ID` varchar(200) DEFAULT NULL,
  `description` text,
  `quantity` varchar(10) DEFAULT NULL,
  `crtrno` text,
  `purchaseorder_id` text,
  `release_version` text,
  `expirydate` text,
  `status` text,
  `remarks` text,
  `poc` text,
  KEY `asset_tag` (`asset_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Asset_version` (
  `asset_tag` int(11) NOT NULL AUTO_INCREMENT,
  `current_version` int(11) NOT NULL,
  PRIMARY KEY (`asset_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=4768 DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Hardware` (
  `asset_tag` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `IHiS_Asset_ID` text,
  `IHiS_Invoice` text,
  `CR359 / CR506` varchar(20) DEFAULT NULL,
  `CR560` varchar(20) DEFAULT NULL,
  `POST-CR560` varchar(20) DEFAULT NULL,
  `price` varchar(11) NOT NULL,
  `currency` varchar(11) NOT NULL,
  `class` text,
  `brand` text,
  `audit_date` text,
  `component` text,
  `label` text,
  `serial` text,
  `location` text,
  `replacing` text,
  `excelsheet` text,
  KEY `asset_tag` (`asset_tag`),
  CONSTRAINT `nehr_Hardware_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `nehr_Asset_version` (`asset_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Options` (
  `nehr_Options_Id` int(11) NOT NULL AUTO_INCREMENT,
  `nehr_Options_Name` text NOT NULL,
  `nehr_Options_Type` text NOT NULL,
  PRIMARY KEY (`nehr_Options_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=368 DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Purchaseorder` (
  `purchaseorder_id` text NOT NULL,
  `discount` text,
  `total` text,
  `filecontent` mediumblob,
  `filename` text,
  `filesize` text,
  `filetype` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Renewal` (
  `renewal_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_ID` text NOT NULL,
  `parent_ID` text NOT NULL,
  `purchaseorder_id` text NOT NULL,
  `startdate` text,
  `expiry_date` text NOT NULL,
  PRIMARY KEY (`renewal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=latin1;


CREATE TABLE `nehr_Software` (
  `asset_tag` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `vendor` text,
  `procured_from` text,
  `shortname` text,
  `purpose` text,
  `contract_type` text,
  `start_date` text,
  `license_explanation` text,
  KEY `asset_tag` (`asset_tag`),
  CONSTRAINT `nehr_Software_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `nehr_Asset_version` (`asset_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2017-08-15 04:20:43
