<?php
class USER
{
    private $db;
	public $softwareFields 		= array('vendor', 'procured_from', 'shortname', 'purpose', 'contract_type', 'start_date', 'license_explanation');
	public $assetFields 		= array('asset_ID', 'description', 'quantity', 'price', 'currency', 'crtrno', 'purchaseorder_id', 'release_version', 'expirydate', 'remarks', 'parent', 'status');
	public $hardwareFields 		= array('class', 'brand', 'audit_date', 'component', 'label', 'serial', 'location', 'replacing'); 
	public $userFields 			= array('username', 'password', 'role', 'status');
    public $options = ['status', 'vendor', 'procured_from', 'shortname', 'purpose', 'contracttype', 'releaseversion', 'class', 'brand', 'location', 'server', 'currency'];
	function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
	public function check($username) {
		//Checks if the username that has been taken. True if not taken, false if taken.
		$stmt = $this->db->prepare("SELECT * FROM user WHERE username=:username");
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
	
	public function addasset($asset) {
		$stmt = $this->db->prepare("INSERT INTO asset_version(current_version) VALUES (:version)");
		$stmt->bindParam(':version', $asset['version']);
		$stmt->execute();
		
		$stmt = $this->db->prepare("INSERT INTO 
			asset(
			asset_tag, asset_ID, description, quantity, price, currency, purchaseorder_id, release_version, expirydate, remarks, crtrno, status, parent, version, lastedited
			) VALUES (
			LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :currency, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :status, :parent, :version, :lastedited)");
		$stmt->bindParam(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindParam(':description', 		$asset['description']);
		$stmt->bindParam(':quantity', 			$asset['quantity']);
		$stmt->bindParam(':price', 				$asset['price']);
		$stmt->bindParam(':currency',			$asset['currency']);
		$stmt->bindParam(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindParam(':release_version', 	$asset['release_version']);
		$stmt->bindParam(':expirydate', 		$asset['expirydate']);
		$stmt->bindParam(':remarks', 			$asset['remarks']);
		$stmt->bindParam(':crtrno', 			$asset['crtrno']);
		$stmt->bindParam(':version',			$asset['version']);
		$stmt->bindParam(':status',				$asset['status']);
		$stmt->bindParam(':parent',				$asset['parent']);
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt->bindParam(':lastedited',			$time);
		$stmt->execute();
	}
	
	public function addSoftware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO software(
		
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
		
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, replacing, version) VALUES (LAST_INSERT_ID(), :class, :brand, :audit_date, :component, :label, :serial, :location, :replacing, :version)");
		$stmt->bindParam(':class', 		$asset['class']);
		$stmt->bindParam(':brand', 		$asset['brand']);
		$stmt->bindParam(':audit_date', $asset['audit_date']);
		$stmt->bindParam(':component', 	$asset['component']);
		$stmt->bindParam(':label', 		$asset['label']);
		$stmt->bindParam(':serial', 	$asset['serial']);
		$stmt->bindParam(':location', 	$asset['location']);
		$stmt->bindParam(':replacing', 	$asset['replacing']);
		$stmt->bindParam(':version',	$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created hardware asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function bulkaddhardware($data) {
		$assetv 	= $this->db->prepare("INSERT INTO asset_version(current_version) VALUES (:version)");
		$assets		= $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, version, lastedited, status) VALUES (LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version, :lastedited, :status)");
		$hardware	= $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, replacing, excelsheet, version) VALUES (LAST_INSERT_ID(), :class, :brand, :audit_date, :component, :label, :serial, :location, :replacing, :excelsheet, :version)");
		
			
		
		$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
		$class = $brand = $audit_date = $component = $label = $serial = $location = $status = $replacing = $excelsheet = "";
		
		$assetv->bindValue(':version', 1);
		
		$assets->bindParam(':asset_ID', 			$asset_ID);
		$assets->bindParam(':description', 			$description);
		$assets->bindParam(':quantity', 			$quantity);
		$assets->bindParam(':price', 				$price);
		$assets->bindParam(':purchaseorder_id', 	$purchaseorder_id);
		$assets->bindParam(':release_version', 		$release_version);
		$assets->bindParam(':expirydate', 			$expirydate);
		$assets->bindParam(':remarks', 				$remarks);
		$assets->bindParam(':crtrno', 				$crtrno);
		$assets->bindParam(':status', 			$status);
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$assets->bindParam(':lastedited',			$time);
		$assets->bindValue(':version',				1);
		
		$hardware->bindParam(':class', 				$class);
		$hardware->bindParam(':brand', 				$brand);
		$hardware->bindParam(':audit_date', 		$audit_date);
		$hardware->bindParam(':component', 			$component);
		$hardware->bindParam(':label', 				$label);
		$hardware->bindParam(':serial', 			$serial);
		$hardware->bindParam(':location', 			$location);
		$hardware->bindParam(':replacing', 			$replacing);
		$hardware->bindParam(':excelsheet',			$excelsheet);
		$hardware->bindValue(':version',			1);
		
		foreach($data as $row) {
			
			if(isset($row['Unique Asset ID'])) {
				$asset_ID = $row['Unique Asset ID'];
			}
			if(isset($row['Details'])) {
				$description = $row['Details'];
			}
			if(isset($row['Qty'])) {
				$quantity = $row['Qty'];
			}
			if(isset($row['RRP (SGD)'])) {
				$price = $row['RRP (SGD)'];
			}
			if(isset($row['PO Number'])) {
				$purchaseorder_id = $row['PO Number'];
			}
			if(isset($row['Release'])) {
				$release_version = $row['Release'];
			}
			if(isset($row['Warranty End Date'])) {
				$expirydate = $row['Warranty End Date'];
			}
			if(isset($row['Comments'])) {
				$remarks = $row['Comments'];
			}
			if(isset($row['CR/TR Grouping'])) {
				$crtrno = $row['CR/TR Grouping'];
			}



			if(isset($row['Class'])) {
				$class = $row['Class'];
			}
			if(isset($row['Brand'])) {
				$brand = $row['Brand'];
			}
			if(isset($row['Audit Date'])) {
				$audit_date = $row['Audit Date'];
			}
			if(isset($row['Component'])) {
				$component = $row['Component'];
			}
			if(isset($row['Label'])) {
				$label = $row['Label'];
			}
			if(isset($row['Serial'])) {
				$serial = $row['Serial'];
			}
			if(isset($row['Excel Sheet'])) {
				$excelsheet = $row['Excel Sheet'];
			}
			if(isset($row['Location'])) {
				$location = $row['Location'];
			}
			if(isset($row['Status'])) {
				$status= $row['Status'];
			}
			if(isset($row['Refresh/Replacement'])){
				$replacing = $row['Refresh/Replacement'];
			}
			
			$assetv->execute();
			$assets->execute();
			$hardware->execute();
			
			$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
			$class = $brand = $audit_date = $component = $label = $serial = $location = $status = $replacing = "";
		}
		$this->savelog($_SESSION['username'], "batch imported hardware assets");
	}
	
	public function bulkaddsoftware($data) {
		$assetv 	= $this->db->prepare("INSERT INTO asset_version(current_version) VALUES (:version)");
		$assets		= $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, lastedited, version) VALUES (LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :lastedited , :version)");
		$software 	= $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, version) VALUES (LAST_INSERT_ID(), :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :version)");
				
		$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
		$vendor = $procured_from = $shortname = $purpose = $contract_type = $start_date = $license_explanation = "";
		
		$assetv->bindValue(':version', 1);
		
		$assets->bindParam(':asset_ID', 				$asset_ID);
		$assets->bindParam(':description', 				$description);
		$assets->bindParam(':quantity', 				$quantity);
		$assets->bindParam(':price', 					$price);
		$assets->bindParam(':purchaseorder_id', 		$purchaseorder_id);
		$assets->bindParam(':release_version', 			$release_version);
		$assets->bindParam(':expirydate', 				$expirydate);
		$assets->bindParam(':remarks', 					$remarks);
		$assets->bindParam(':crtrno', 					$crtrno);
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$assets->bindParam(':lastedited',				$time);
		$assets->bindValue(':version',					1);
		
		$software->bindParam(':vendor', 				$vendor);
		$software->bindParam(':procured_from', 			$procured_from);
		$software->bindParam(':shortname', 				$shortname);
		$software->bindParam(':purpose', 				$purpose);
		$software->bindParam(':contract_type', 			$contract_type);
		$software->bindParam(':start_date', 			$start_date);
		$software->bindParam(':license_explanation',	$license_explanation);
		$software->bindValue(':version', 1);
		
		foreach($data as $row) {
			
			if(isset($row['Reference ID'])) {
				$asset_ID = $row['Reference ID'];
			}
			if(isset($row['Description'])) {
				$description = $row['Description'];
			}
			if(isset($row['Quantity'])) {
				$quantity = $row['Quantity'];
			}
			if(isset($row['Price'])) {
				$price = $row['Price'];
			}
			if(isset($row['CR/TR'])) {
				$crtrno = $row['CR/TR'];
			}
			if(isset($row['PO'])) {
				$purchaseorder_id = $row['PO'];
			}
			if(isset($row['Release'])) {
				$release_version = $row['Release'];
			}
			if(isset($row['End Date'])) {
				$expirydate = $row['End Date'];
			}
			if(isset($row['Purpose'])) {
				$purpose = $row['Purpose'];
			}
			if(isset($row['Remarks'])) {
				$remarks = $row['Remarks'];
			}
			if(isset($row['Vendor'])) {
				$vendor = $row['Vendor'];
			}
			if(isset($row['Procured from'])) {
				$procured_from = $row['Procured from'];
			}
			if(isset($row['Shortname'])) {
				$shortname = $row['Shortname'];
			}
			if(isset($row['Contract Type'])) {
				$contract_type = $row['Contract Type'];
			}
			if(isset($row['Start Date'])) {
				$start_date = $row['Start Date'];
			}
			if(isset($row['license explanation'])) {
				$license_explanation = $row['license explanation'];
			}
			
			$assetv->execute();
			$assets->execute();
			$software->execute();
			
			$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
			$vendor = $procured_from = $shortname = $purpose = $contract_type = $start_date = $license_explanation = "";
		
		}
		$this->savelog($_SESSION['username'], "batch imported software assets");
	}
	
	public function editasset($asset) {
		$stmt = $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, currency, purchaseorder_id, release_version, expirydate, remarks, crtrno, version, parent, status, lastedited) VALUES (:asset_tag, :asset_ID, :description, :quantity, :price, :currency, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version, :parent, :status, :lastedited)");
		$stmt->bindParam(':asset_tag',			$asset['asset_tag']);
		$stmt->bindParam(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindParam(':description', 		$asset['description']);
		$stmt->bindParam(':quantity', 			$asset['quantity']);
		$stmt->bindParam(':price', 				$asset['price']);
		$stmt->bindParam(':currency',			$asset['currency']);
		$stmt->bindParam(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindParam(':release_version', 	$asset['release_version']);
		$stmt->bindParam(':expirydate', 		$asset['expirydate']);
		$stmt->bindParam(':remarks', 			$asset['remarks']);
		$stmt->bindParam(':crtrno', 			$asset['crtrno']);
		$stmt->bindParam(':version',			$asset['version']);
		$stmt->bindParam(':parent', 			$asset['parent']);
		$stmt->bindParam(':status', 			$asset['status']);
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt->bindParam(':lastedited',			$time);
		$stmt->execute();
		
		$stmt = $this->db->prepare("UPDATE asset_version SET current_version=:version where asset_tag=:asset_tag");
		$stmt->bindParam(':asset_tag', $asset['asset_tag']);
		$stmt->bindParam(':version', $asset['version']);
		$stmt->execute();
	}
	
	public function editSoftware($asset) {
		$this->editAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, version) VALUES (:asset_tag, :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :version)");
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
		
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, replacing, version) VALUES (:asset_tag, :class, :brand, :audit_date, :component, :label, :serial, :location, :replacing, :version)");
		$stmt->bindParam(':asset_tag',	$asset['asset_tag']);
		$stmt->bindParam(':class', 		$asset['class']);
		$stmt->bindParam(':brand', 		$asset['brand']);
		$stmt->bindParam(':audit_date', $asset['audit_date']);
		$stmt->bindParam(':component', 	$asset['component']);
		$stmt->bindParam(':label', 		$asset['label']);
		$stmt->bindParam(':serial', 	$asset['serial']);
		$stmt->bindParam(':location', 	$asset['location']);
		$stmt->bindParam(':replacing', 	$asset['replacing']);
		$stmt->bindParam(':version',	$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "edited hardware asset ".$asset['asset_ID']." (version ".$asset['version'].")");
	}
	
	public function savelog($user, $log) {
		//Logs an action
		
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt = $this->db->prepare("INSERT INTO log(user, time, log) VALUES (:user, :time, :log)");
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':time', $time);
		$stmt->bindParam(':log', $log);
		$stmt->execute();
	}
		
	public function getSoftwareList() {
		//Gets all of the software details
		$stmt = $this->db->prepare("SELECT 	asset.*, software.*
			FROM asset_version INNER JOIN software, asset 
			WHERE 
            asset_version.asset_tag = software.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            asset_version.current_version = asset.version AND
            asset_version.current_version = software.version");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getHardwareList() {
		//Gets all of the hardware details
		$stmt = $this->db->prepare("SELECT 	asset.*, hardware.*
			FROM asset_version INNER JOIN hardware, asset 
			WHERE 
            asset_version.asset_tag = hardware.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            asset_version.current_version = asset.version AND
            asset_version.current_version = hardware.version");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getPurchaseOrder($purchaseorder_id) {
		$result['purchaseorder_id'] = $purchaseorder_id;
		$result['validation'] = false;
		//Gets all of the software details
		$stmt = $this->db->prepare("SELECT 	asset.*, software.*
			FROM asset_version INNER JOIN software, asset 
			WHERE 
            asset_version.asset_tag = software.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            asset_version.current_version = asset.version AND
            asset_version.current_version = software.version AND
			asset.purchaseorder_id = :purchaseorder_id");
		
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$result['validation'] = true;
			$result['software'] = $stmt->fetchAll();
		}

	
		//Gets all of the hardware details
		$stmt = $this->db->prepare("SELECT 	asset.*, hardware.*
			FROM asset_version INNER JOIN hardware, asset 
			WHERE 
            asset_version.asset_tag = hardware.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            asset_version.current_version = asset.version AND
            asset_version.current_version = hardware.version AND
			asset.purchaseorder_id = :purchaseorder_id");
		
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$result['validation'] = true;
			$result['hardware'] = $stmt->fetchAll();
		}
		
		$stmt = $this->db->prepare("SELECT * FROM renewal where purchaseorder_id=:purchaseorder_id");
		
		$stmt->bindParam(":purchaseorder_id", $purchaseorder_id);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$result['validation'] = true;
			$result['renewal'] = $stmt->fetchAll();
		}

		
		$stmt = $this->db->prepare("SELECT * FROM purchaseorder where purchaseorder_id = :purchaseorder_id");
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
		$stmt = $this->db->prepare("UPDATE purchaseorder SET ".$field."=:value where purchaseorder_id=:purchaseorder_id");
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':purchaseorder_id', $purchaseorder_id);
		$stmt->execute();
	}
	
	public function newPurchaseOrder($purchaseorder_id, $field, $value) {
		$stmt = $this->db->prepare("INSERT INTO purchaseorder (purchaseorder_id, ".$field.")VALUES (:purchaseorder_id, :value)");
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
   
           $stmt = $this->db->prepare("INSERT INTO user(username,password,role,status) 
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
        
        $stmt = $this->db->prepare("INSERT INTO user(username,password,role,status) VALUES(:username, :password, :role, :status)");
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
		$stmt = $this->db->prepare("SELECT * from renewal");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getRenewal($renewal_ID) {
		//Return format
		//Array: {true/false, array of user information}
		//[0]: Result of retrieving. True if successful, False if failed
		//[1]: Array of user information
		$result = array(false, false);
		$stmt = $this->db->prepare("SELECT * from renewal where renewal_ID=:renewal_ID");
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
          $stmt = $this->db->prepare("SELECT * FROM user WHERE username = :username AND status='active' LIMIT 1");
          $stmt->bindparam(":username", $username);
		  $stmt->execute();
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
			 //Password verify 
             if(password_verify($password, $userRow['password']))
             {
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
          $stmt = $this->db->prepare("SELECT * FROM user WHERE username = :username AND status='active' LIMIT 1");
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
		$stmt = $this->db->prepare("UPDATE user SET password=:password where username=:username AND status='active'");
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':password', $new_password);
		$stmt->execute();
		$this->savelog($_SESSION['username'], 'changed password');
	}
	
	public function getLog() {
		//Retrieves the log list
		//Returns an array of the logs
		$stmt = $this->db->prepare("SELECT * FROM log ORDER BY time DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getUsers() {
		//Retrieves the user list
		//Returns an array of users
		$stmt = $this->db->prepare("SELECT username, role, status, user_ID FROM user");
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
		$stmt = $this->db->prepare("SELECT * from user where user_ID=:user_ID");
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
		$stmt = $this->db->prepare("SELECT 	asset.*, software.*
			FROM asset_version INNER JOIN software, asset 
			WHERE 
            asset_version.asset_tag = :asset_tag AND
            asset_version.asset_tag = software.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            asset_version.current_version = asset.version AND
            asset_version.current_version = software.version");
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
		$stmt = $this->db->prepare("SELECT 	asset.*, software.*
			FROM asset_version INNER JOIN software, asset 
			WHERE 
            asset_version.asset_tag = :asset_tag AND
            asset_version.asset_tag = software.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            software.version = asset.version");
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
		$stmt = $this->db->prepare("SELECT 	asset.*, hardware.*
			FROM asset_version INNER JOIN hardware, asset 
			WHERE 
            asset_version.asset_tag = :asset_tag AND
            asset_version.asset_tag = hardware.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
			asset_version.current_version 	= asset.version AND
            asset_version.current_version = hardware.version");
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
		$stmt = $this->db->prepare("SELECT 	asset.*, hardware.*
			FROM asset_version INNER JOIN hardware, asset 
			WHERE 
            asset.asset_ID = :asset_ID AND
            asset_version.asset_tag = hardware.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
			asset_version.current_version 	= asset.version AND
            asset_version.current_version = hardware.version");
		$stmt->bindParam(':asset_ID', $asset_ID);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$result['hardware'] = $stmt->fetchAll();
		}
		
		$stmt = $this->db->prepare("SELECT 	asset.*, software.*
			FROM asset_version INNER JOIN software, asset 
			WHERE 
            asset.asset_ID = :asset_ID AND
            asset_version.asset_tag = software.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
			asset_version.current_version 	= asset.version AND
            asset_version.current_version = software.version");
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
		$stmt = $this->db->prepare("SELECT 	asset.*, hardware.*
			FROM asset_version INNER JOIN hardware, asset 
			WHERE 
            asset_version.asset_tag = :asset_tag AND
            asset_version.asset_tag = hardware.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
            asset.version = hardware.version");
		$stmt->bindParam(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() >= 1) {
			$result[0] = true;
			$result[1] = $stmt->fetchAll();
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
			$sql[0] 				= "UPDATE user SET".$sql[0]." WHERE user_ID =:user_ID";
			$sql[1][':user_ID'] 	= $source['user_ID'];
			
			$stmt					= $this->db->prepare($sql[0]);
			$stmt->execute($sql[1]);
		}
				
		if ($source['username'] == $candidate['username']) {
			$this->savelog($_SESSION['username'], "edited user {$source['username']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited user {$source['username']} to {$candidate['username']}");
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
		$stmt = $this->db->prepare("SELECT DISTINCT asset.purchaseorder_id FROM asset, asset_version WHERE asset.version = asset_version.current_version AND asset.asset_tag = asset_version.asset_tag UNION SELECT purchaseorder_id from renewal");
		$stmt->execute();
		$result[0] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT DISTINCT asset.release_version FROM asset, asset_version WHERE asset.version = asset_version.current_version AND asset.asset_tag = asset_version.asset_tag ORDER BY release_version");
		$stmt->execute();
		$result[1] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT DISTINCT asset.crtrno FROM asset, asset_version WHERE asset.version = asset_version.current_version AND asset.asset_tag = asset_version.asset_tag ORDER BY crtrno");
		$stmt->execute();
		$result[2] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT DISTINCT asset.asset_ID FROM asset, asset_version WHERE asset.version = asset_version.current_version AND asset.asset_tag = asset_version.asset_tag ORDER BY asset_ID");
		$stmt->execute();
		$result[3] = $stmt->fetchAll();
		
		return $result;
	}
    
    public function getOptions() {
		
		$result = array();
		
		foreach ($this->options as $option) {
			$stmt = $this->db->prepare("SELECT * from {$option} ORDER BY {$option}_name");
			$stmt->execute();
			$result[$option] = $stmt->fetchAll();
		}
		return $result;
	}
	
	public function generateReport($type, $filter) {
		  $entry = '%'.$filter.'%';
		  $stmt = $this->db->prepare("SELECT * FROM asset, asset_version WHERE ".$type." LIKE :filter AND
		  asset_version.asset_tag = asset.asset_tag AND
		  asset_version.current_version 	= asset.version");
		  $stmt->bindparam(":filter", $entry);
		  $stmt->execute();
		  
		  $this->savelog($_SESSION['username'], "generated report for $type $filter");
		  return $stmt->fetchAll();
	}
    
	public function downloadReport($type, $filter) {
		  $entry = '%'.$filter.'%';
		  $stmt = $this->db->prepare("SELECT 	asset.*, hardware.*
			FROM asset_version INNER JOIN hardware, asset 
			WHERE 
            asset_version.asset_tag = hardware.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
			asset_version.current_version 	= asset.version AND
            asset_version.current_version = hardware.version AND
			$type LIKE :filter");
		  $stmt->bindparam(":filter", $entry);
		  $stmt->execute();
		  
		  $result['hardware'] = $stmt->fetchAll();
		  
		  $stmt = $this->db->prepare("SELECT 	asset.*, software.*
			FROM asset_version INNER JOIN software, asset 
			WHERE 
            asset_version.asset_tag = software.asset_tag AND
            asset_version.asset_tag = asset.asset_tag AND
			asset_version.current_version 	= asset.version AND
            asset_version.current_version = software.version AND
			$type LIKE :filter");
		  $stmt->bindparam(":filter", $entry);
		  $stmt->execute();
		  
		  $result['software'] = $stmt->fetchAll();
		  
		  return $result;
	}
    public function addOption($type, $value) {
			
		  $stmt = $this->db->prepare("INSERT INTO ".$type." (".$type."_name) VALUES(:filter)");
		  $stmt->bindparam(":filter", $value);
		  $stmt->execute();
		  $this->savelog($_SESSION['username'], "added option $value for $type");
	}
    
    public function deleteOption($type, $value) {
			
		  $stmt = $this->db->prepare("DELETE FROM ".$type." WHERE ".$type."_id= :filter");
		  $stmt->bindparam(":filter", $value);
		  $stmt->execute();
		  $this->savelog($_SESSION['username'], "removed option $value for $type");
	}
	
	public function getCurrentVersion($asset_tag) {
		$stmt = $this->db->prepare("SELECT current_version FROM asset_version where asset_tag=:asset_tag");
		$stmt->bindparam(":asset_tag", $asset_tag);
		$stmt->execute();
		return $stmt->fetch();
	}
	/*
	public function getParents($asset, &$savedIDs = array()) {
		
		$stmt = $this->db->prepare("SELECT 	asset.asset_ID, asset.purchaseorder_id, asset.parent 
									FROM 	asset, asset_version 
									WHERE 	asset.asset_ID=:asset_ID
									AND 	asset.version=asset_version.current_version
									AND		asset.asset_tag=asset_version.asset_tag");
									
		if ($asset['parent'] != "") {
			$stmt->bindparam(":asset_ID", $asset['parent']);
			$stmt->execute();
			foreach($stmt->fetchAll() as $parent) {
				if (!in_array($parent, $savedIDs)) {
					array_push($savedIDs, $parent);
					
					echo "<div class='col-xs-6'>".htmlentities($parent['asset_ID'])."</div>"; 
					
					echo "<div class='col-xs-6'>".htmlentities($parent['purchaseorder_id'])."</div>";
					$this->getParents($parent, $savedIDs);
				}
			}
		}
	}
	*/
	public function getChildren($asset) {
		$stmt = $this->db->prepare("SELECT 	* from renewal where parent_ID=:parent_ID");
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
		
			$sql = "UPDATE purchaseorder SET filecontent=:filecontent, filename=:filename, filesize=:filesize, filetype=:filetype where purchaseorder_id=:purchaseorder_id";
		}
		else {
			$sql = "INSERT INTO purchaseorder (purchaseorder_id, filecontent, filename, filesize, filetype)VALUES (:purchaseorder_id, :filecontent, :filename, :filesize, :filetype)";
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
		$stmt = $this->db->prepare("SELECT purchaseorder_id, filename, filecontent, filesize, filetype FROM purchaseorder WHERE purchaseorder_id=:purchaseorder_id");
		$stmt->bindParam(':purchaseorder_id', $purchaseorder_id);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public function deletePurchaseOrderFile($purchaseorder_id) {
		$sql = "UPDATE purchaseorder SET filecontent=NULL, filename=NULL, filesize=NULL, filetype=NULL where purchaseorder_id=:purchaseorder_id";
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
		echo				"<p>Price				: ".htmlentities($asset['price']) . " " 		. htmlentities($asset['currency'])	."</p>";
		echo				"<p>CR / TR No			: ".htmlentities($asset['crtrno'])				."</p>";
		echo				"<p>Purchase Order ID	: ".htmlentities($asset['purchaseorder_id'])	."</p>";
		echo				"<p>Release Version		: ".htmlentities($asset['release_version']) 	."</p>";
		echo				"<p>Expiry Date			: ".htmlentities($asset['expirydate']) 			."</p>";
		echo				"<p>Status				: ".htmlentities($asset['status'])				."</p>";
		echo				"<p>Remarks				: ".htmlentities($asset['remarks']) 			."</p>";
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
		echo				"<p>Class				: ".htmlentities($hardware['class']) 			."</p>";
		echo				"<p>Brand				: ".htmlentities($hardware['brand']) 			."</p>";
		echo				"<p>Audit Date			: ".htmlentities($hardware['audit_date']) 		."</p>";
		echo				"<p>Component			: ".htmlentities($hardware['component']) 		."</p>";
		echo 				"<p>Label				: ".htmlentities($hardware['label']) 			."</p>";
		echo				"<p>Serial				: ".htmlentities($hardware['serial']) 			."</p>";
		echo				"<p>Location 			: ".htmlentities($hardware['location']) 		."</p>";
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
			$stmt = $this->db->prepare("INSERT INTO renewal(asset_ID,parent_ID,purchaseorder_id,startdate,expiry_date) 
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
					$this->editSoftware($row);
				}										
			}
			if(isset($parents['software'])) {
				foreach ($parents['software'] as $row) {
					$row['expirydate'] = $renewal['expiry_date'];
					$row['version'] = $row['version'] + 1;
					$this->editHardware($row);
				}										
			}
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
	
	public function printAssetRow($asset) {
				echo "<td>".htmlentities($asset['description'])			."</td>";
				echo "<td>".htmlentities($asset['quantity'])			."</td>";
				echo "<td>".htmlentities($asset['price'])			." ".htmlentities($asset['currency'])."</td>";
				echo "<td>".htmlentities($asset['crtrno'])				."</td>";
				echo "<td>".htmlentities($asset['purchaseorder_id'])	."</td>";
				echo "<td>".htmlentities($asset['release_version'])		."</td>";
				echo "<td>".htmlentities($asset['expirydate'])			."</td>";
				echo "<td>".htmlentities($asset['remarks'])				."</td>";
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
		if ($type == 'renewal') {
			$sql = "SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=:type and not COLUMN_NAME='renewal_id'";
		}
		else if ($type == 'hardware' or $type == 'software') {
			$sql = "SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
					WHERE (TABLE_NAME= 'asset' or TABLE_NAME = :type)
					AND  
					(not COLUMN_NAME='asset_tag' or COLUMN_NAME='version')
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