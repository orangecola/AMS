-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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
  `status` text,
  `version` int(11) NOT NULL,
  `lastedited` text,
  KEY `asset_tag` (`asset_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `asset_version` (
  `asset_tag` int(11) NOT NULL AUTO_INCREMENT,
  `current_version` int(11) NOT NULL,
  PRIMARY KEY (`asset_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=1168 DEFAULT CHARSET=latin1;


CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` text NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;


CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` text NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


CREATE TABLE `contracttype` (
  `contracttype_id` int(11) NOT NULL AUTO_INCREMENT,
  `contracttype_name` text NOT NULL,
  PRIMARY KEY (`contracttype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` text NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


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
  `excelsheet` text,
  `version` int(11) NOT NULL,
  KEY `asset_tag` (`asset_tag`),
  CONSTRAINT `hardware_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset_version` (`asset_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` text NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;


CREATE TABLE `log` (
  `log_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `time` text NOT NULL,
  `log` text NOT NULL,
  PRIMARY KEY (`log_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=latin1;


CREATE TABLE `procured_from` (
  `procured_from_id` int(11) NOT NULL AUTO_INCREMENT,
  `procured_from_name` text NOT NULL,
  PRIMARY KEY (`procured_from_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;


CREATE TABLE `purchaseorder` (
  `purchaseorder_id` text NOT NULL,
  `discount` text,
  `total` text,
  `filecontent` mediumblob,
  `filename` text,
  `filesize` text,
  `filetype` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `purpose` (
  `purpose_id` int(11) NOT NULL AUTO_INCREMENT,
  `purpose_name` text NOT NULL,
  PRIMARY KEY (`purpose_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;


CREATE TABLE `releaseversion` (
  `releaseversion_id` int(11) NOT NULL AUTO_INCREMENT,
  `releaseversion_name` text NOT NULL,
  PRIMARY KEY (`releaseversion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;


CREATE TABLE `renewal` (
  `renewal_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_ID` text NOT NULL,
  `parent_ID` text NOT NULL,
  `purchaseorder_id` text NOT NULL,
  `startdate` text,
  `expiry_date` text NOT NULL,
  PRIMARY KEY (`renewal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=latin1;


CREATE TABLE `server` (
  `server_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` text NOT NULL,
  PRIMARY KEY (`server_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


CREATE TABLE `shortname` (
  `shortname_id` int(11) NOT NULL AUTO_INCREMENT,
  `shortname_name` text NOT NULL,
  PRIMARY KEY (`shortname_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;


CREATE TABLE `software` (
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
  CONSTRAINT `software_ibfk_1` FOREIGN KEY (`asset_tag`) REFERENCES `asset_version` (`asset_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` text NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1037 DEFAULT CHARSET=latin1;


CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;


CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` text NOT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;


-- 2017-07-07 08:06:18
