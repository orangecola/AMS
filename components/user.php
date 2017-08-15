<?php
class USER
{
    private $db;
	public $softwareFields 		= array('vendor', 'procured_from', 'shortname', 'purpose', 'contract_type', 'start_date', 'license_explanation');
	public $assetFields 		= array('asset_ID', 'description', 'quantity', 'crtrno', 'purchaseorder_id', 'release_version', 'expirydate', 'remarks', 'status', 'poc');
	public $hardwareFields 		= array('IHiS_Asset_ID', 'CR359 / CR506', 'CR560', 'POST-CR560', 'price', 'currency', 'class', 'brand', 'audit_date', 'component', 'label', 'serial', 'location', 'replacing', 'excelsheet'); 
	public $userFields 			= array('username', 'password', 'role', 'status');
	function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
	public function check($username) {
		//Checks if the username that has been taken. True if not taken, false if taken.
		$stmt = $this->db->prepare("SELECT * FROM ihis_User WHERE username=:username");
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0)
          {
             return false;
          }
		return true;
	}
		
	public function check_date($date) {
		$dt = DateTime::createFromFormat("m/d/Y", $date);
		return $dt !== false && !array_sum($dt->getLastErrors());
	}
	
	public function validatesAsInt($number) {
		$number = filter_var($number, FILTER_VALIDATE_INT);
		return ($number !== FALSE);
	}
	
	public function validatesAsDouble($number) {
		$number = filter_var($number, FILTER_VALIDATE_FLOAT);
		return ($number !== FALSE);
	}
	
	public function addAsset($asset) {
		
		$stmt = $this->db->prepare("INSERT INTO nehr_Asset_version(current_version) VALUES (:version)");
		$stmt->bindParam(':version', $asset['version']);
		$stmt->execute();
		
		$stmt = $this->db->prepare("INSERT INTO 
			nehr_Asset(
			asset_tag, asset_ID, description, quantity, purchaseorder_id, release_version, expirydate, remarks, crtrno, status, version, lastedited, poc
			) VALUES (
			LAST_INSERT_ID(), :asset_ID, :description, :quantity, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :status, :version, :lastedited, :poc)");
		$stmt->bindParam(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindParam(':description', 		$asset['description']);
		$stmt->bindParam(':quantity', 			$asset['quantity']);
		$stmt->bindParam(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindParam(':release_version', 	$asset['release_version']);
		$stmt->bindParam(':expirydate', 		$asset['expirydate']);
		$stmt->bindParam(':remarks', 			$asset['remarks']);
		$stmt->bindParam(':crtrno', 			$asset['crtrno']);
		$stmt->bindParam(':version',			$asset['version']);
		$stmt->bindParam(':status',				$asset['status']);
		$stmt->bindParam(':poc',				$asset['poc']);
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt->bindParam(':lastedited',			$time);
		$stmt->execute();
	}
	
	public function addSoftware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO nehr_Software(
		
		asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, version
		) VALUES (
		LAST_INSERT_ID(), :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :version)");
		
		$stmt->bindParam(':vendor', 				$asset['vendor']);
		$stmt->bindParam(':procured_from', 			$asset['procured_from']);
		$stmt->bindParam(':shortname', 				$asset['shortname']);
		$stmt->bindParam(':purpose', 				$asset['purpose']);
		$stmt->bindParam(':contract_type', 			$asset['contract_type']);
		$stmt->bindParam(':start_date', 			$asset['start_date']);
		$stmt->bindParam(':license_explanation', 	$asset['license_explanation']);
		$stmt->bindParam(':version',				$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created software asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function addHardware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO nehr_Hardware(asset_tag, `IHiS_Asset_ID`, IHiS_Invoice, `CR359 / CR506`,	`CR560`, `POST-CR560`, price, currency, class, brand, audit_date, component, label, serial, location, replacing, version, excelsheet) 
		VALUES 
		(LAST_INSERT_ID(), :IHiS_Asset_ID, :IHiS_Invoice, :CR359, :CR560, :POSTCR560, :price, :currency, :class, :brand, :audit_date, :component, :label, :serial, :location, :replacing, :version, :excelsheet)");
		
		$stmt->bindParam(':IHiS_Asset_ID', 	$asset['IHiS_Asset_ID']);
		$stmt->bindParam(':IHiS_Invoice', 	$asset['IHiS_Invoice']);
		$stmt->bindParam(':CR359', 			$asset['CR359 / CR506']);
		$stmt->bindParam(':CR560', 			$asset['CR560']);
		$stmt->bindParam(':POSTCR560', 		$asset['POST-CR560']);
		$stmt->bindParam(':price', 			$asset['price']);
		$stmt->bindParam(':currency',		$asset['currency']);
		$stmt->bindParam(':class', 			$asset['class']);
		$stmt->bindParam(':brand', 			$asset['brand']);
		$stmt->bindParam(':audit_date', 	$asset['audit_date']);
		$stmt->bindParam(':component', 		$asset['component']);
		$stmt->bindParam(':label', 			$asset['label']);
		$stmt->bindParam(':serial', 		$asset['serial']);
		$stmt->bindParam(':location', 		$asset['location']);
		$stmt->bindParam(':replacing', 		$asset['replacing']);
		$stmt->bindParam(':excelsheet', 	$asset['excelsheet']);
		$stmt->bindParam(':version',		$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created hardware asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function bulkAddSoftware($assets) {
		foreach ($assets as $asset) {
			$this->addSoftware($asset);
		}
	}
	
	public function bulkAddHardware($assets) {
		foreach ($assets as $asset) {
			$this->addHardware($asset);
		}
	}
	
	public function bulkAddRenewal($renewals) {
		foreach ($renewals as $renewal) {
			$this->addRenewal($renewal);
		}
	}
	
	public function editasset($asset) {
		$stmt = $this->db->prepare("INSERT INTO nehr_Asset(asset_tag, asset_ID, description, quantity,  purchaseorder_id, release_version, expirydate, remarks, crtrno, version, status, lastedited, poc) 
		VALUES 
		(:asset_tag, :asset_ID, :description, :quantity, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version, :status, :lastedited, :poc)");
		$stmt->bindParam(':asset_tag',			$asset['asset_tag']);
		$stmt->bindParam(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindParam(':description', 		$asset['description']);
		$stmt->bindParam(':quantity', 			$asset['quantity']);
		$stmt->bindParam(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindParam(':release_version', 	$asset['release_version']);
		$stmt->bindParam(':expirydate', 		$asset['expirydate']);
		$stmt->bindParam(':remarks', 			$asset['remarks']);
		$stmt->bindParam(':crtrno', 			$asset['crtrno']);
		$stmt->bindParam(':version',			$asset['version']);
		$stmt->bindParam(':status', 			$asset['status']);
		$stmt->bindParam(':poc',				$asset['poc']);
		
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt->bindParam(':lastedited',			$time);
		$stmt->execute();
		
		$stmt = $this->db->prepare("UPDATE nehr_Asset_version SET current_version=:version where asset_tag=:asset_tag");
		$stmt->bindParam(':asset_tag', $asset['asset_tag']);
		$stmt->bindParam(':version', $asset['version']);
		$stmt->execute();
	}
	
	public function editSoftware($asset) {
		$this->editAsset($asset);
		$stmt = $this->db->prepare("INSERT INTO nehr_Software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, version) VALUES (:asset_tag, :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :version)");
		$stmt->bindParam(':asset_tag',				$asset['asset_tag']);
		$stmt->bindParam(':vendor', 				$asset['vendor']);
		$stmt->bindParam(':procured_from', 			$asset['procured_from']);
		$stmt->bindParam(':shortname', 				$asset['shortname']);
		$stmt->bindParam(':purpose', 				$asset['purpose']);
		$stmt->bindParam(':contract_type', 			$asset['contract_type']);
		$stmt->bindParam(':start_date', 			$asset['start_date']);
		$stmt->bindParam(':license_explanation', 	$asset['license_explanation']);
		$stmt->bindParam(':version',				$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "edited software asset ".$asset['asset_ID']." (version ".$asset['version'].")");
	}
	
	public function editHardware($asset) {
		$this->editAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO nehr_Hardware(asset_tag, `IHiS_Asset_ID`, IHiS_Invoice, `CR359 / CR506`,	`CR560`, `POST-CR560`, price, currency, class, brand, audit_date, component, label, serial, location, replacing, version, excelsheet) 
		VALUES 
		(:asset_tag, :IHiS_Asset_ID, :IHiS_Invoice, :CR359, :CR560, :POSTCR560, :price, :currency, :class, :brand, :audit_date, :component, :label, :serial, :location, :replacing, :version, :excelsheet)");
		$stmt->bindParam(':asset_tag',	$asset['asset_tag']);
		
		$stmt->bindParam(':IHiS_Asset_ID', 	$asset['IHiS_Asset_ID']);
		$stmt->bindParam(':IHiS_Invoice', 	$asset['IHiS_Invoice']);
		$stmt->bindParam(':CR359', 			$asset['CR359 / CR506']);
		$stmt->bindParam(':CR560', 			$asset['CR560']);
		$stmt->bindParam(':POSTCR560', 		$asset['POST-CR560']);
		$stmt->bindParam(':price', 			$asset['price']);
		$stmt->bindParam(':currency',		$asset['currency']);
		$stmt->bindParam(':class', 			$asset['class']);
		$stmt->bindParam(':brand', 			$asset['brand']);
		$stmt->bindParam(':audit_date', 	$asset['audit_date']);
		$stmt->bindParam(':component', 		$asset['component']);
		$stmt->bindParam(':label', 			$asset['label']);
		$stmt->bindParam(':serial', 		$asset['serial']);
		$stmt->bindParam(':location', 		$asset['location']);
		$stmt->bindParam(':replacing', 		$asset['replacing']);
		$stmt->bindParam(':excelsheet', 	$asset['excelsheet']);
		$stmt->bindParam(':version',		$asset['version']);
		
		$stmt->execute();
		$this->savelog($_SESSION['username'], "edited hardware asset ".$asset['asset_ID']." (version ".$asset['version'].")");
	}
	
	public function savelog($user, $log) {
		//Logs an action
		
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt = $this->db->prepare("INSERT INTO ihis_Log(user, time, log) VALUES (:user, :time, :log)");
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':time', $time);
		$stmt->bindParam(':log', $log);
		$stmt->execute();
	}
		
	public function getSoftwareList() {
		//Gets all of the software details
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Software.*
			FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Asset_version.current_version = nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Software.version");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getHardwareList() {
		//Gets all of the hardware details
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Hardware.*
			FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Asset_version.current_version = nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Hardware.version");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getGPCAssetList() {
		$stmt = $this->db->prepare("SELECT * from gpc_Asset 
		INNER JOIN gpc_Asset_version
		WHERE 
		gpc_Asset.gpc_asset_tag = gpc_Asset_version.gpc_asset_tag AND
		gpc_Asset.gpc_version = gpc_Asset_version.current_version
		ORDER BY gpc_Asset.gpc_asset_tag");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getPurchaseOrder($purchaseorder_id) {
		$result['purchaseorder_id'] = $purchaseorder_id;
		$result['validation'] = false;
		//Gets all of the software details
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Software.*
			FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Asset_version.current_version = nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Software.version AND
			nehr_Asset.purchaseorder_id = :purchaseorder_id");
		
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$result['validation'] = true;
			$result['software'] = $stmt->fetchAll();
		}

	
		//Gets all of the hardware details
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Hardware.*
			FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Asset_version.current_version = nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Hardware.version AND
			nehr_Asset.purchaseorder_id = :purchaseorder_id");
		
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$result['validation'] = true;
			$result['hardware'] = $stmt->fetchAll();
		}
		
		$stmt = $this->db->prepare("SELECT * FROM nehr_Renewal where purchaseorder_id=:purchaseorder_id");
		
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$result['validation'] = true;
			$result['renewal'] = $stmt->fetchAll();
		}

		
		$stmt = $this->db->prepare("SELECT * FROM nehr_Purchaseorder where purchaseorder_id = :purchaseorder_id");
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$result['exists'] = true;
			$result['purchaseorder'] = $stmt->fetch();
		}
		else {
			$result['exists'] = false;
		}
		return $result;
	}
	
	public function updatePurchaseOrder($purchaseorder_id, $field, $value) {
		$stmt = $this->db->prepare("UPDATE nehr_Purchaseorder SET ".$field."=:value where purchaseorder_id=:purchaseorder_id");
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':purchaseorder_id', $purchaseorder_id);
		$stmt->execute();
	}
	
	public function newPurchaseOrder($purchaseorder_id, $field, $value) {
		$stmt = $this->db->prepare("INSERT INTO nehr_Purchaseorder (purchaseorder_id, ".$field.")VALUES (:purchaseorder_id, :value)");
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':purchaseorder_id', $purchaseorder_id);
		$stmt->execute();
	}
    public function register($username, $password, $role)
	//Adds the provided user into the database and activates it.
	
    {
       try
       {
           $new_password = password_hash($password, PASSWORD_DEFAULT);
   
           $stmt = $this->db->prepare("INSERT INTO ihis_User(username,password,role,status) 
                                                       VALUES(:username, :password, :role, 'active')");
              
           $stmt->bindparam(":username", $username);
           $stmt->bindparam(":password", $new_password);
           $stmt->bindparam(":role", $role);
           $stmt->execute(); 
		   $this->savelog($_SESSION['username'], "created $role $username");
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
    
    public function addBulkUsers($array) {
        $username = "";
        $password = "";
        $role = "";
        $status = "";
        
        $stmt = $this->db->prepare("INSERT INTO ihis_User(username,password,role,status) VALUES(:username, :password, :role, :status)");
        $stmt->bindparam(":username", $username);
        $stmt->bindparam(":password", $password);
        $stmt->bindparam(":role", $role);
        $stmt->bindparam(":status", $status);
        
        foreach($array as $row) {
            if ($this->check($row[0])) {
                $username = $row[0];
                $password = password_hash($row[1], PASSWORD_DEFAULT);
                $role = $row[2];
                $status = $row[3];
                $stmt->execute();
            }
        }
		
		$this->savelog($_SESSION['username'], "batch imported users");
    }
 
 
	public function getRenewals() {
		//Retrieves the user list
		//Returns an array of users
		$stmt = $this->db->prepare("SELECT * from nehr_Renewal");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getRenewal($renewal_ID) {
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT * from nehr_Renewal where renewal_ID=:renewal_ID");
		$stmt->bindParam(':renewal_ID', $renewal_ID);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$result[0] = true;
			$result[1] = $stmt->fetch();
		}
		return $result;
	}
	
    public function login($username,$password)
	//Checks the username / password combination for logging in. 
	//Sets session variables
	//Returns true / false
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM ihis_User WHERE username = :username AND status='active' LIMIT 1");
          $stmt->bindparam(":username", $username);
		  $stmt->execute();
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
			 //Password verify 
             if(password_verify($password, $userRow['password']))
             {
				$_SESSION['user_ID'] = $userRow['user_ID'];
				$_SESSION['username'] = $username;
				$_SESSION['role'] = $userRow['role'];
				$this->savelog($_SESSION['username'], 'logged in');
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
   
   public function checkPassword($oldpassword) {
	   //Checks if the password given is correct, before changing the password
	   //Returns true / false
	   try
       {
          $stmt = $this->db->prepare("SELECT * FROM ihis_User WHERE username = :username AND status='active' LIMIT 1");
          $stmt->bindparam(":username", $_SESSION['username']);
		  $stmt->execute();
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($oldpassword, $userRow['password']))
             {
                return true;
             }
          }
		  return false;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
	
	public function changePassword($newpassword) {
		//Changes the password of the current user logged in.
		//Check for the same password must be finished prior to this (This has no checks!)
		$new_password = password_hash($newpassword, PASSWORD_DEFAULT);
		$stmt = $this->db->prepare("UPDATE ihis_User SET password=:password where username=:username AND status='active'");
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':password', $new_password);
		$stmt->execute();
		$this->savelog($_SESSION['username'], 'changed password');
	}
	
	public function getLog() {
		//Retrieves the log list
		//Returns an array of the logs
		$stmt = $this->db->prepare("SELECT * FROM ihis_Log ORDER BY time DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getUsers() {
		//Retrieves the user list
		//Returns an array of users
		$stmt = $this->db->prepare("SELECT username, role, status, user_ID FROM ihis_User");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getUser($user_ID) {
		//Get the details of a user with user_ID=$user_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT * from ihis_User where user_ID=:user_ID");
		$stmt->bindParam(':user_ID', $user_ID);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$result[0] = true;
			$result[1] = $stmt->fetch();
		}
		return $result;
	}
	
	public function getSoftware($asset_tag) {
		//Get the details of an asset with asset_ID=$asset_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Software.*
			FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = :asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Asset_version.current_version = nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Software.version");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$result[0] = true;
			$result[1] = $stmt->fetch();
		}
		return $result;
	}
	
    public function getSoftwareVersions($asset_tag) {
        //Get the details of an asset with asset_ID=$asset_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Software.*
			FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = :asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Software.version = nehr_Asset.version");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() >= 1) {
			$result[0] = true;
			$result[1] = $stmt->fetchAll();
		}
		return $result;
    }
	public function getHardware($asset_tag) {
		//Get the details of an asset with asset_ID=$asset_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Hardware.*
			FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = :asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			nehr_Asset_version.current_version 	= nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Hardware.version");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$result[0] = true;
			$result[1] = $stmt->fetch();
		}
		return $result;
	}
	
	public function getParents($asset_ID) {
		$result = null;
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Hardware.*
			FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset 
			WHERE 
            nehr_Asset.asset_ID = :asset_ID AND
            nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			nehr_Asset_version.current_version 	= nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Hardware.version");
		$stmt->bindParam(':asset_ID', $asset_ID);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$result['hardware'] = $stmt->fetchAll();
		}
		
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Software.*
			FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			WHERE 
            nehr_Asset.asset_ID = :asset_ID AND
            nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			nehr_Asset_version.current_version 	= nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Software.version");
		$stmt->bindParam(':asset_ID', $asset_ID);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$result['software'] = $stmt->fetchAll();
		}
		return $result;
	}
	
    public function getHardwareVersions($asset_tag) {
		//Get the details of an asset with asset_ID=$asset_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Hardware.*
			FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = :asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
            nehr_Asset.version = nehr_Hardware.version");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() >= 1) {
			$result[0] = true;
			$result[1] = $stmt->fetchAll();
		}
		return $result;
	}
    
	public function getGPCAssetVersions($asset_tag) {
		//Get the details of an asset with asset_ID=$asset_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT * from gpc_Asset 
		WHERE 
		gpc_Asset.gpc_asset_tag = :asset_tag");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() >= 1) {
			$result[0] = true;
			$result[1] = $stmt->fetchAll();
		}
		return $result;
	}
	public function getGPCAsset($asset_tag) {
		//Get the details of an asset with asset_ID=$asset_ID
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT * from gpc_Asset 
		INNER JOIN gpc_Asset_version
		WHERE 
		gpc_Asset.gpc_asset_tag = :asset_tag AND 
		gpc_Asset.gpc_asset_tag = gpc_Asset_version.gpc_asset_tag AND
		gpc_Asset.gpc_version = gpc_Asset_version.current_version");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$result[0] = true;
			$result[1] = $stmt->fetch();
		}
		return $result;
	}
	public function editUser($source, $candidate) {
		//Updates the user based on the infomration provided
		//There must be at least one item changed 
		//For $username, $role, $status, it is checked against $source entry.
		//If it is different, then it will add statements to update
		//For password, "" is regarded as same
		
		$sql = $this->prepareEditSQL($this->userFields, $source, $candidate);
		if ($sql[0] != "") {
			$sql[0] 				= "UPDATE ihis_User SET".$sql[0]." WHERE user_ID =:user_ID";
			$sql[1][':user_ID'] 	= $source['user_ID'];
			
			$stmt					= $this->db->prepare($sql[0]);
			$stmt->execute($sql[1]);
		}
				
		if ($source['username'] == $candidate['username']) {
			$this->savelog($_SESSION['username'], "edited nehr_User {$source['username']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited nehr_User {$source['username']} to {$candidate['username']}");
		}
	}
	
	public function allTrue($array) {
		$result = true;

		foreach ($array as $key => $value) {
			if ($value === false) {
				$result = false;
				break;
			} 
		}
		
		return $result;
	}
	
	
	public function prepareEditSql($fields, $source, $candidate) {
		//Prepares the center of the sql statement 
		foreach($fields as $value) {
			//Compares if the source and candidate entries are the same
			$same[$value] = ($source[$value] == $candidate[$value]);
		}
		
		//Ensure that there is at least one different field before iterating
		if (!$this->allTrue($same)) {
			$sql 			= "";
			$fieldArray 	= array();
			
			foreach ($fields as $value) {
				if (!$same[$value]) {
					//Example: asset_ID=:asset_ID
					$sql									.= " {$value}=:{$value}";
					
					//Example: $fieldArray[":asset_ID", $candidate[":asset_ID"];
					$fieldArray[":{$value}"]	= 			$candidate[$value];
					
					//Remove the field
					unset($same[$value]);
					
					//If there are other fields that are different, add a comma to separate them.
					if (!$this->allTrue($same)) {
						$sql 	.= ",";
					}
				}
			}
			return array($sql, $fieldArray); 
		}
	}
	
	public function getDistinct() {
		$result = array();
		$stmt = $this->db->prepare("SELECT DISTINCT nehr_Asset.purchaseorder_id FROM nehr_Asset, nehr_Asset_version WHERE nehr_Asset.version = nehr_Asset_version.current_version AND nehr_Asset.asset_tag = nehr_Asset_version.asset_tag UNION SELECT purchaseorder_id from nehr_Renewal");
		$stmt->execute();
		$result[0] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT DISTINCT nehr_Asset.release_version FROM nehr_Asset, nehr_Asset_version WHERE nehr_Asset.version = nehr_Asset_version.current_version AND nehr_Asset.asset_tag = nehr_Asset_version.asset_tag ORDER BY release_version");
		$stmt->execute();
		$result[1] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT DISTINCT nehr_Asset.crtrno FROM nehr_Asset, nehr_Asset_version WHERE nehr_Asset.version = nehr_Asset_version.current_version AND nehr_Asset.asset_tag = nehr_Asset_version.asset_tag ORDER BY crtrno");
		$stmt->execute();
		$result[2] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT DISTINCT nehr_Asset.asset_ID FROM nehr_Asset, nehr_Asset_version WHERE nehr_Asset.version = nehr_Asset_version.current_version AND nehr_Asset.asset_tag = nehr_Asset_version.asset_tag ORDER BY asset_ID");
		$stmt->execute();
		$result[3] = $stmt->fetchAll();
		
		return $result;
	}
    	
	public function getOptions($table, $options) {
		$result = array();
		if ($table == 'nehr_Options') {
			$stmt = $this->db->prepare("SELECT * from nehr_Options 
			where nehr_Options_Type=:Options_Type 
			ORDER BY nehr_Options_name");
		}
		else if ($table == 'gpc_Options') {
			$stmt = $this->db->prepare("SELECT * from gpc_Options 
			where gpc_Options_Type=:Options_Type 
			ORDER BY gpc_Options_name");
		}
		else return;
		
		$stmt->bindParam(':Options_Type', $Options_Type);
		foreach($options as $option) {
			$Options_Type = $option;
			$stmt->execute();
			$result[$option] = $stmt->fetchAll();
		}
		return $result;
	}
	public function generateReport($type, $filter) {
		$result = array();
		if ($type == 'expirydate') {
			  $stmt = $this->db->prepare("SELECT * FROM nehr_Asset 
			  WHERE str_to_date(expirydate, '%m/%d/%Y') <= str_to_date(:expirydate, '%m/%d/%Y')
			  AND NOT status='Decommissioned'");
			  $stmt->bindparam(":expirydate", $filter);
			  $stmt->execute();
			  
			  $this->savelog($_SESSION['username'], "generated report for $type $filter");
			  $result['asset'] = $stmt->fetchAll();
		}
		else {
			  $entry = '%'.$filter.'%';
			  $stmt = $this->db->prepare("SELECT * FROM nehr_Asset, nehr_Asset_version WHERE ".$type." LIKE :filter AND
			  nehr_Asset_version.asset_tag 			= nehr_Asset.asset_tag AND
			  nehr_Asset_version.current_version 	= nehr_Asset.version");
			  $stmt->bindparam(":filter", $entry);
			  $stmt->execute();
			  
			  $this->savelog($_SESSION['username'], "generated report for $type $filter");
			  $result['asset'] = $stmt->fetchAll();
			  
			  if ($type == 'purchaseorder_id') {
				  $stmt = $this->db->prepare("SELECT * FROM nehr_Renewal WHERE ".$type." LIKE :filter");
				  $stmt->bindparam(":filter", $entry);
				  $stmt->execute();
				  $result['renewal'] = $stmt->fetchAll();	
			  } 
		}		  
		  return $result;
	}
    
	public function downloadReport($type, $filter) {
		echo $filter;
		$result = array();
		if ($type == 'expirydate') {
			  $stmt = $this->db->prepare("SELECT nehr_Asset.*, nehr_Hardware.*
			  FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset  
			  WHERE
			  nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
			  nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			  nehr_Asset_version.current_version 	= nehr_Asset.version AND
			  nehr_Asset_version.current_version = nehr_Hardware.version AND
			  str_to_date(expirydate, '%m/%d/%Y') <= str_to_date(:expirydate, '%m/%d/%Y')
			  AND NOT status='Decommissioned'");
			  $stmt->bindparam(":expirydate", $filter);
			  $stmt->execute();
			  
			  $result['hardware'] = $stmt->fetchAll();
			  
			  $stmt = $this->db->prepare("SELECT nehr_Asset.*, nehr_Software.*
			  FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			  WHERE
			  nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
              nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			  nehr_Asset_version.current_version 	= nehr_Asset.version AND
              nehr_Asset_version.current_version = nehr_Software.version AND
			  str_to_date(expirydate, '%m/%d/%Y') <= str_to_date(:expirydate, '%m/%d/%Y')
			  AND NOT status='Decommissioned'");
			  $stmt->bindparam(":expirydate", $filter);
			  $stmt->execute();
			  
			  $result['software'] = $stmt->fetchAll();
		}
		else {
		  $entry = '%'.$filter.'%';
		  $stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Hardware.*
			FROM nehr_Asset_version INNER JOIN nehr_Hardware, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = nehr_Hardware.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			nehr_Asset_version.current_version 	= nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Hardware.version AND
			$type LIKE :filter");
		  $stmt->bindparam(":filter", $entry);
		  $stmt->execute();
		  
		  $result['hardware'] = $stmt->fetchAll();
		  
		  $stmt = $this->db->prepare("SELECT 	nehr_Asset.*, nehr_Software.*
			FROM nehr_Asset_version INNER JOIN nehr_Software, nehr_Asset 
			WHERE 
            nehr_Asset_version.asset_tag = nehr_Software.asset_tag AND
            nehr_Asset_version.asset_tag = nehr_Asset.asset_tag AND
			nehr_Asset_version.current_version 	= nehr_Asset.version AND
            nehr_Asset_version.current_version = nehr_Software.version AND
			$type LIKE :filter");
		  $stmt->bindparam(":filter", $entry);
		  $stmt->execute();
		  
		  $result['software'] = $stmt->fetchAll();
		  
		  if ($type == 'purchaseorder_id') {
			  $stmt = $this->db->prepare("SELECT * FROM nehr_Renewal WHERE ".$type." LIKE :filter");
			  $stmt->bindparam(":filter", $entry);
			  $stmt->execute();
			  $result['renewal'] = $stmt->fetchAll();
		  }
		}
		  return $result;
	}
    public function addOption($table, $type, $value) {
		if ($table == 'nehr_Options') {
			$stmt = $this->db->prepare("INSERT INTO nehr_Options(nehr_Options_Name, nehr_Options_Type)
			VALUES (:value, :type)");
		}
		else if ($table == 'gpc_Options') {
			$stmt = $this->db->prepare("INSERT INTO gpc_Options(gpc_Options_Name, gpc_Options_Type)
			VALUES (:value, :type)");
		}
		else return;
		
		$stmt->bindparam(":value", $value);
		$stmt->bindparam(":type", $type);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "added option $value for $type");
	}
    
	
    public function deleteOption($table, $value) {
		if ($table == 'nehr_Options') {
			$stmt = $this->db->prepare("DELETE FROM nehr_Options WHERE nehr_Options_Id=:value");
		}
		else if ($table == 'gpc_Options') {
			$stmt = $this->db->prepare("DELETE FROM gpc_Options WHERE gpc_Options_Id=:value");
		}
		else return;
		
		$stmt->bindparam(":value", $value);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "removed option $value");
	}
	
	public function getCurrentVersion($asset_tag) {
		$stmt = $this->db->prepare("SELECT current_version FROM nehr_Asset_version where asset_tag=:asset_tag");
		$stmt->bindparam(":asset_tag", $asset_tag);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public function getChildren($asset) {
		$stmt = $this->db->prepare("SELECT 	* from nehr_Renewal where parent_ID=:parent_ID");
		$stmt->bindparam(":parent_ID", $asset['asset_ID']);
		$stmt->execute();
		foreach($stmt->fetchAll() as $child) {
			echo "<div class='col-xs-3'>".htmlentities($child['asset_ID'])."</div>"; 
			echo "<div class='col-xs-3'>".htmlentities($child['purchaseorder_id'])."</div>";
			echo "<div class='col-xs-3'>".htmlentities($child['startdate'])."</div>";
			echo "<div class='col-xs-3'>".htmlentities($child['expiry_date'])."</div>";
		}
	}
	
	public function savePurchaseOrderFile($purchaseorder, $file) {
		
		$fileName = $file['name'];
		$tmpName  = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileType = $file['type'];

		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		
		$sql = "";
		if ($purchaseorder['exists'] == 1) {
		
			$sql = "UPDATE nehr_Purchaseorder SET filecontent=:filecontent, filename=:filename, filesize=:filesize, filetype=:filetype where purchaseorder_id=:purchaseorder_id";
		}
		else {
			$sql = "INSERT INTO nehr_Purchaseorder (purchaseorder_id, filecontent, filename, filesize, filetype)VALUES (:purchaseorder_id, :filecontent, :filename, :filesize, :filetype)";
		}
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':purchaseorder_id', $purchaseorder['purchaseorder_id']);
		$stmt->bindParam(':filename', $fileName);
		$stmt->bindParam(':filesize', $fileSize);
		$stmt->bindParam(':filetype', $fileType);
		$stmt->bindParam(':filecontent', $content);
		
		$stmt->execute();
	}
	
	public function getPurchaseOrderFile($purchaseorder_id) {
		$stmt = $this->db->prepare("SELECT purchaseorder_id, filename, filecontent, filesize, filetype FROM nehr_Purchaseorder WHERE purchaseorder_id=:purchaseorder_id");
		$stmt->bindParam(':purchaseorder_id', $purchaseorder_id);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public function deletePurchaseOrderFile($purchaseorder_id) {
		$sql = "UPDATE nehr_Purchaseorder SET filecontent=NULL, filename=NULL, filesize=NULL, filetype=NULL where purchaseorder_id=:purchaseorder_id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':purchaseorder_id', $purchaseorder_id);
		$stmt->execute();
	}
	
	public function printAssetModal($asset) {
		#Modal for more information
		echo "<div id='".htmlentities($asset['asset_tag'])."view' class='modal fade' role='dialog'>";
		echo 	"<div class='modal-dialog'>";
		echo 		"<div class='modal-content'>";
		echo 			"<div class='modal-header'>";
		echo 				"<button type='button' class='close' data-dismiss='modal'>&times;</button>";
		echo 					"<h3 class='modal-title'>Asset ".htmlentities($asset['asset_ID'])." Information</h3>";
		echo 			"</div>";
		echo	 		"<div class='modal-body'>";
		echo				"<h4>Asset Information</h4>";
		echo				"<p>Description			: ".htmlentities($asset['description'])			."</p>";
		echo				"<p>Quantity			: ".htmlentities($asset['quantity'])			."</p>";
		echo				"<p>CR / TR No			: ".htmlentities($asset['crtrno'])				."</p>";
		echo				"<p>Purchase Order ID	: ".htmlentities($asset['purchaseorder_id'])	."</p>";
		echo				"<p>Release Version		: ".htmlentities($asset['release_version']) 	."</p>";
		echo				"<p>Expiry Date			: ".htmlentities($asset['expirydate']) 			."</p>";
		echo				"<p>Status				: ".htmlentities($asset['status'])				."</p>";
		echo				"<p>Remarks				: ".htmlentities($asset['remarks']) 			."</p>";
		echo				"<p>Point of Contact 	: ".htmlentities($asset['poc']) 				."</p>";
	}
	
	public function printSoftwareModal($software) {
		$this->printAssetModal($software);
		echo				"<h4>Software Information</h4>";
		echo				"<p>Vendor				: ".htmlentities($software['vendor'])				."</p>";
		echo				"<p>Procured From		: ".htmlentities($software['procured_from']) 		."</p>";
		echo				"<p>Short Name			: ".htmlentities($software['shortname']) 			."</p>";
		echo				"<p>Purpose				: ".htmlentities($software['purpose']) 				."</p>";
		echo 				"<p>Contract type		: ".htmlentities($software['contract_type']) 		."</p>";
		echo				"<p>Start Date			: ".htmlentities($software['start_date']) 			."</p>";
		echo				"<p>License Explanation	: ".htmlentities($software['license_explanation']) 	."</p>";
		echo				"<h4>Children Information</h4>";
		echo				"<div class='row'>";
		echo				"<div class='col-xs-3'>Asset ID</div><div class='col-xs-3'>Purchase Order No</div><div class='col-xs-3'>Start Date</div><div class='col-xs-3'>End Date</div>";
		echo				$this->getChildren($software);
		echo				"</div>";
		echo 			"</div>";
		echo 		"<div class='modal-footer'>";
		echo			"<a href=\"editsoftware.php?id=".htmlentities($software['asset_tag'])."\" class=\"btn btn-info\"><i class='fa fa-edit'></i>Edit</a>";
		echo 			"<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
		echo		"</div>";
		echo	"</div>";
		echo "</div>";
	}
	
	public function printHardwareModal($hardware) {
		$this->printAssetModal($hardware);
		echo				"<h4>Hardware Information</h4>";
		echo				"<p>Price				: ".htmlentities($hardware['price']) . " " 		. htmlentities($hardware['currency'])	."</p>";
		echo				"<p>IHiS Asset ID		: ".htmlentities($hardware['IHiS_Asset_ID']) 	."</p>";
		echo				"<p>IHiS Invoice		: ".htmlentities($hardware['IHiS_Invoice']) 	."</p>";
		echo				"<p>CR359/CR506			: ".htmlentities($hardware['CR359 / CR506']) 	."</p>";
		echo				"<p>CR560				: ".htmlentities($hardware['CR560']) 			."</p>";
		echo				"<p>Post-CR560			: ".htmlentities($hardware['POST-CR560']) 		."</p>";
		echo				"<p>Class				: ".htmlentities($hardware['class']) 			."</p>";
		echo				"<p>Brand				: ".htmlentities($hardware['brand']) 			."</p>";
		echo				"<p>Audit Date			: ".htmlentities($hardware['audit_date']) 		."</p>";
		echo				"<p>Component			: ".htmlentities($hardware['component']) 		."</p>";
		echo 				"<p>Label				: ".htmlentities($hardware['label']) 			."</p>";
		echo				"<p>Serial				: ".htmlentities($hardware['serial']) 			."</p>";
		echo				"<p>Location 			: ".htmlentities($hardware['location']) 		."</p>";
		echo				"<p>Excel Sheet 		: ".htmlentities($hardware['excelsheet']) 		."</p>";
		echo				"<p>RMA					: ".htmlentities($hardware['replacing']) 		."</p>";
		echo				"<h4>Children Information</h4>";
		echo				"<div class='row'>";
		echo				"<div class='col-xs-3'>Asset ID</div><div class='col-xs-3'>Purchase Order No</div><div class='col-xs-3'>Start Date</div><div class='col-xs-3'>End Date</div>";
		echo				$this->getChildren($hardware);
		echo				"</div>";
		echo 			"</div>";
		echo 		"<div class='modal-footer'>";
		echo			"<a href=\"edithardware.php?id=".htmlentities($hardware['asset_tag'])."\" class=\"btn btn-info\"><i class='fa fa-edit'></i>Edit</a>";
		echo 			"<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
		echo		"</div>";
		echo	"</div>";
		echo "</div>";
	}
	
	public function addRenewal($renewal) {
       try
       {
			$stmt = $this->db->prepare("INSERT INTO nehr_Renewal(asset_ID,parent_ID,purchaseorder_id,startdate,expiry_date) 
                                                       VALUES(:asset_ID,:parent_ID,:purchaseorder_id,:startdate,:expiry_date)");
			
			$stmt->bindparam(":asset_ID", 			$renewal['asset_ID']);
			$stmt->bindparam(":parent_ID", 			$renewal['parent_ID']);
			$stmt->bindparam(":purchaseorder_id", 	$renewal['purchaseorder_id']);
			$stmt->bindparam(":startdate", 			$renewal['startdate']);
			$stmt->bindparam(":expiry_date", 		$renewal['expiry_date']);
			$stmt->execute(); 
			$this->savelog($_SESSION['username'], "created renewal for asset {$renewal['parent_ID']}");
			
			//Changing of the parent
			$parents = $this->getParents($renewal['parent_ID']);
			
			if(isset($parents['hardware'])) {
				foreach ($parents['hardware'] as $row) {
					$row['expirydate'] = $renewal['expiry_date'];
					$row['version'] = $row['version'] + 1;
					$this->editHardware($row);
				}										
			}
			if(isset($parents['software'])) {
				foreach ($parents['software'] as $row) {
					$row['expirydate'] = $renewal['expiry_date'];
					$row['version'] = $row['version'] + 1;
					$this->editSoftware($row);
				}										
			}
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
	
	public function editRenewal($renewal) {
       try
       {
			$stmt = $this->db->prepare("UPDATE nehr_Renewal
										SET asset_ID	=:asset_ID,
										parent_ID		=:parent_ID,
										purchaseorder_id=:purchaseorder_id,
										startdate		=:startdate,
										expiry_date		=:expiry_date
										WHERE renewal_id=:renewal_id");
			
			$stmt->bindparam(":asset_ID", 			$renewal['asset_ID']);
			$stmt->bindparam(":parent_ID", 			$renewal['parent_ID']);
			$stmt->bindparam(":purchaseorder_id", 	$renewal['purchaseorder_id']);
			$stmt->bindparam(":startdate", 			$renewal['startdate']);
			$stmt->bindparam(":expiry_date", 		$renewal['expiry_date']);
			$stmt->bindparam(":renewal_id",			$renewal['renewal_id']);
			$stmt->execute(); 
			$this->savelog($_SESSION['username'], "edited renewal for asset {$renewal['parent_ID']}");
			
			//Changing of the parent
			$parents = $this->getParents($renewal['parent_ID']);
			
			if(isset($parents['hardware'])) {
				foreach ($parents['hardware'] as $row) {
					$row['expirydate'] = $renewal['expiry_date'];
					$row['version'] = $row['version'] + 1;
					$this->editHardware($row);
				}										
			}
			if(isset($parents['software'])) {
				foreach ($parents['software'] as $row) {
					$row['expirydate'] = $renewal['expiry_date'];
					$row['version'] = $row['version'] + 1;
					$this->editSoftware($row);
				}										
			}
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
	
	public function addGPCAsset($asset) {
		$stmt = $this->db->prepare("INSERT INTO gpc_Asset_version(current_version) VALUES (:version)");
		$stmt->bindValue(':version', 1);
		$stmt->execute();
		
		$stmt = $this->db->prepare("
			INSERT INTO gpc_Asset 
			(
			gpc_asset_tag, gpc_version,
			gpc_Environment, gpc_Tier, gpc_Phase, gpc_Item, gpc_Remarks,
			gpc_Ami, gpc_Startdate, gpc_Expirydate, gpc_halb, gpc_quantity,
			gpc_Application, gpc_Data, gpc_IOPS, gpc_Backup, gpc_OS, 
			gpc_Y1_Qt, gpc_Y2_Qt, gpc_Y1_Ops, gpc_Y2_Ops, gpc_Gwgc, 
			gpc_Lastedited
			)
			VALUES (
			LAST_INSERT_ID(), 1,
			:gpc_Environment, :gpc_Tier, :gpc_Phase, :gpc_Item, :gpc_Remarks,
			:gpc_Ami, :gpc_Startdate, :gpc_Expirydate, :gpc_halb, :gpc_quantity,
			:gpc_Application, :gpc_Data, :gpc_IOPS, :gpc_Backup, :gpc_OS,
			:gpc_Y1_Qt, :gpc_Y2_Qt, :gpc_Y1_Ops, :gpc_Y2_Ops, :gpc_Gwgc,
			:gpc_Lastedited
			)
			");
		$stmt->bindParam(':gpc_Environment',	$asset['gpc_Environment']);
		$stmt->bindParam(':gpc_Tier', 			$asset['gpc_Tier']);
		$stmt->bindParam(':gpc_Phase', 			$asset['gpc_Phase']);
		$stmt->bindParam(':gpc_Item', 			$asset['gpc_Item']);
		$stmt->bindParam(':gpc_Remarks', 		$asset['gpc_Remarks']);
		$stmt->bindParam(':gpc_Ami', 			$asset['gpc_Ami']);
		$stmt->bindParam(':gpc_Startdate', 		$asset['gpc_Startdate']);
		$stmt->bindParam(':gpc_Expirydate', 	$asset['gpc_Expirydate']);
		$stmt->bindParam(':gpc_halb', 			$asset['gpc_halb']);
		$stmt->bindParam(':gpc_quantity',		$asset['gpc_quantity']);
		$stmt->bindParam(':gpc_Application', 	$asset['gpc_Application']);
		$stmt->bindParam(':gpc_Data', 			$asset['gpc_Data']);
		$stmt->bindParam(':gpc_IOPS',			$asset['gpc_IOPS']);
		$stmt->bindParam(':gpc_Backup', 		$asset['gpc_Backup']);
		$stmt->bindParam(':gpc_OS', 			$asset['gpc_OS']);
		$stmt->bindParam(':gpc_Y1_Qt',			$asset['gpc_Y1_Qt']);
		$stmt->bindParam(':gpc_Y2_Qt', 			$asset['gpc_Y2_Qt']);
		$stmt->bindParam(':gpc_Y1_Ops',			$asset['gpc_Y1_Ops']);
		$stmt->bindParam(':gpc_Y2_Ops', 		$asset['gpc_Y2_Ops']);
		$stmt->bindParam(':gpc_Gwgc', 			$asset['gpc_Gwgc']);
		$stmt->bindParam(':gpc_Lastedited',		$asset['gpc_Lastedited']);
		
		date_default_timezone_set('Asia/Singapore');
		$asset['gpc_Lastedited'] = date("Y-m-d H:i:s");
		$stmt->execute();
					
		$this->savelog($_SESSION['username'], "created GPC asset".$asset['gpc_Item']);
	}
	
	public function editGPCAsset($asset) {
		$stmt = $this->db->prepare("UPDATE gpc_Asset_version SET current_version=:version 
									WHERE gpc_asset_tag=:gpc_asset_tag");
		$stmt->bindParam(':gpc_asset_tag', $asset['gpc_asset_tag']);
		$stmt->bindParam(':version', $asset['gpc_version']);
		$stmt->execute();
		
		$stmt = $this->db->prepare("
			INSERT INTO gpc_Asset 
			(
			gpc_asset_tag, gpc_version,
			gpc_Environment, gpc_Tier, gpc_Phase, gpc_Item, gpc_Remarks,
			gpc_Ami, gpc_Startdate, gpc_Expirydate, gpc_halb, gpc_quantity,
			gpc_Application, gpc_Data, gpc_IOPS, gpc_Backup, gpc_OS, 
			gpc_Y1_Qt, gpc_Y2_Qt, gpc_Y1_Ops, gpc_Y2_Ops, gpc_Gwgc, 
			gpc_Lastedited
			)
			VALUES (
			:gpc_asset_tag, :gpc_version,
			:gpc_Environment, :gpc_Tier, :gpc_Phase, :gpc_Item, :gpc_Remarks,
			:gpc_Ami, :gpc_Startdate, :gpc_Expirydate, :gpc_halb, :gpc_quantity,
			:gpc_Application, :gpc_Data, :gpc_IOPS, :gpc_Backup, :gpc_OS,
			:gpc_Y1_Qt, :gpc_Y2_Qt, :gpc_Y1_Ops, :gpc_Y2_Ops, :gpc_Gwgc,
			:gpc_Lastedited
			)
			");
			
		$stmt->bindParam(':gpc_asset_tag',		$asset['gpc_asset_tag']);
		$stmt->bindParam(':gpc_version',		$asset['gpc_version']);
		$stmt->bindParam(':gpc_Environment',	$asset['gpc_Environment']);
		$stmt->bindParam(':gpc_Tier', 			$asset['gpc_Tier']);
		$stmt->bindParam(':gpc_Phase', 			$asset['gpc_Phase']);
		$stmt->bindParam(':gpc_Item', 			$asset['gpc_Item']);
		$stmt->bindParam(':gpc_Remarks', 		$asset['gpc_Remarks']);
		$stmt->bindParam(':gpc_Ami', 			$asset['gpc_Ami']);
		$stmt->bindParam(':gpc_Startdate', 		$asset['gpc_Startdate']);
		$stmt->bindParam(':gpc_Expirydate', 	$asset['gpc_Expirydate']);
		$stmt->bindParam(':gpc_halb', 			$asset['gpc_halb']);
		$stmt->bindParam(':gpc_quantity',		$asset['gpc_quantity']);
		$stmt->bindParam(':gpc_Application', 	$asset['gpc_Application']);
		$stmt->bindParam(':gpc_Data', 			$asset['gpc_Data']);
		$stmt->bindParam(':gpc_IOPS',			$asset['gpc_IOPS']);
		$stmt->bindParam(':gpc_Backup', 		$asset['gpc_Backup']);
		$stmt->bindParam(':gpc_OS', 			$asset['gpc_OS']);
		$stmt->bindParam(':gpc_Y1_Qt',			$asset['gpc_Y1_Qt']);
		$stmt->bindParam(':gpc_Y2_Qt', 			$asset['gpc_Y2_Qt']);
		$stmt->bindParam(':gpc_Y1_Ops',			$asset['gpc_Y1_Ops']);
		$stmt->bindParam(':gpc_Y2_Ops', 		$asset['gpc_Y2_Ops']);
		$stmt->bindParam(':gpc_Gwgc', 			$asset['gpc_Gwgc']);
		$stmt->bindParam(':gpc_Lastedited',		$asset['gpc_Lastedited']);
		
		date_default_timezone_set('Asia/Singapore');
		$asset['gpc_Lastedited'] = date("Y-m-d H:i:s");
		$stmt->execute();
					
		$this->savelog($_SESSION['username'], "edited GPC asset".$asset['gpc_Item']);
	}
	
	public function printAssetRow($asset) {
				echo "<td style='width: 59%'>".htmlentities($asset['description'])			."</td>";
				echo "<td>".htmlentities($asset['quantity'])			."</td>";
				echo "<td>".htmlentities($asset['crtrno'])				."</td>";
				echo "<td>".htmlentities($asset['purchaseorder_id'])	."</td>";
				echo "<td>".htmlentities($asset['release_version'])		."</td>";
				echo "<td>".htmlentities($asset['expirydate'])			."</td>";
				echo "<td>".htmlentities($asset['status'])			."</td>";
				echo "<td>".htmlentities($asset['poc'])			."</td>";
	}
	
	public function printRenewalRow($row) {
		$parents = $this->getParents($row['parent_ID']);
		echo '<tr>';
		echo "<td>".htmlentities($row['asset_ID'])."</td>";
		echo "<td>".htmlentities($row['parent_ID'])."</td>";
		echo "<td>".htmlentities($row['purchaseorder_id'])."</td>";
		echo "<td>".htmlentities($row['startdate'])."</td>";
		echo "<td>".htmlentities($row['expiry_date'])."</td>";
		echo "<td>";
		echo "<a href=\"editrenewal.php?id=".htmlentities($row['renewal_id'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
		if(isset($parents['hardware'])) {
			foreach ($parents['hardware'] as $row) {
				echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($row['asset_tag'])."view href="."#".htmlentities($row['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
				$this->printHardwareModal($row);
			}										
		}
		if(isset($parents['software'])) {
			foreach ($parents['software'] as $row) {
				echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($row['asset_tag'])."view href="."#".htmlentities($row['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
				$this->printSoftwareModal($row);
			}										
		}
		echo "</td>";
		echo '</tr>';
	}
	
	public function getHeaders($type) {
		if ($type == 'nehr_Renewal') {
			$sql = "SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
					WHERE TABLE_NAME=:type 
					AND 
					NOT COLUMN_NAME='renewal_id'
					AND
					TABLE_SCHEMA='ams'
					";
		}
		else if ($type == 'nehr_Hardware' or $type == 'nehr_Software') {
			$sql = "SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
					WHERE (TABLE_NAME= 'nehr_Asset' or TABLE_NAME = :type)
					AND  
					NOT (COLUMN_NAME='asset_tag' or COLUMN_NAME='version' or COLUMN_NAME='lastedited')
					AND
					TABLE_SCHEMA='ams'
					";
		}
		else {
			return null;
		}
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':type', $type);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}
?>