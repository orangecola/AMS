<?php
class USER
{
    private $db;
	public $softwareFields 		= array('vendor', 'procured_from', 'shortname', 'purpose', 'contract_type', 'start_date', 'license_explanation', 'verification');
	public $assetFields 		= array('asset_ID', 'description', 'quantity', 'price', 'crtrno', 'purchaseorder_id', 'release_version', 'expirydate', 'remarks', 'parent');
	public $hardwareFields 		= array('class', 'brand', 'audit_date', 'component', 'label', 'serial', 'location', 'status', 'replacing'); 
	public $userFields 			= array('username', 'password', 'role', 'status');
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
		
		$stmt = $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, parent, version) VALUES (LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :parent, :version)");
		$stmt->bindParam(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindParam(':description', 		$asset['description']);
		$stmt->bindParam(':quantity', 			$asset['quantity']);
		$stmt->bindParam(':price', 				$asset['price']);
		$stmt->bindParam(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindParam(':release_version', 	$asset['release_version']);
		$stmt->bindParam(':expirydate', 		$asset['expirydate']);
		$stmt->bindParam(':remarks', 			$asset['remarks']);
		$stmt->bindParam(':crtrno', 			$asset['crtrno']);
		$stmt->bindParam(':version',			$asset['version']);
		$stmt->bindParam(':parent',				$asset['parent']);
		$stmt->execute();
	}
	
	public function addSoftware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, verification, version) VALUES (LAST_INSERT_ID(), :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :verification, :version)");
		$stmt->bindParam(':vendor', 				$asset['vendor']);
		$stmt->bindParam(':procured_from', 			$asset['procured_from']);
		$stmt->bindParam(':shortname', 				$asset['shortname']);
		$stmt->bindParam(':purpose', 				$asset['purpose']);
		$stmt->bindParam(':contract_type', 			$asset['contract_type']);
		$stmt->bindParam(':start_date', 			$asset['start_date']);
		$stmt->bindParam(':license_explanation', 	$asset['license_explanation']);
		$stmt->bindParam(':verification', 			$asset['verification']);
		$stmt->bindParam(':version',				$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created software asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function addHardware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, status, replacing, version) VALUES (LAST_INSERT_ID(), :class, :brand, :audit_date, :component, :label, :serial, :location, :status, :replacing, :version)");
		$stmt->bindParam(':class', 		$asset['class']);
		$stmt->bindParam(':brand', 		$asset['brand']);
		$stmt->bindParam(':audit_date', $asset['audit_date']);
		$stmt->bindParam(':component', 	$asset['component']);
		$stmt->bindParam(':label', 		$asset['label']);
		$stmt->bindParam(':serial', 	$asset['serial']);
		$stmt->bindParam(':location', 	$asset['location']);
		$stmt->bindParam(':status', 	$asset['status']);
		$stmt->bindParam(':replacing', 	$asset['replacing']);
		$stmt->bindParam(':version',	$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created hardware asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function bulkaddhardware($data) {
		$assetv 	= $this->db->prepare("INSERT INTO asset_version(current_version) VALUES (:version)");
		$assets		= $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, version) VALUES (LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version)");
		$hardware	= $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, status, replacing, version) VALUES (LAST_INSERT_ID(), :class, :brand, :audit_date, :component, :label, :serial, :location, :status, :replacing, :version)");
		
			
		
		$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
		$class = $brand = $audit_date = $component = $label = $serial = $location = $status = $replacing = "";
		
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
		$assets->bindValue(':version',				1);
		
		$hardware->bindParam(':class', 				$class);
		$hardware->bindParam(':brand', 				$brand);
		$hardware->bindParam(':audit_date', 		$audit_date);
		$hardware->bindParam(':component', 			$component);
		$hardware->bindParam(':label', 				$label);
		$hardware->bindParam(':serial', 			$serial);
		$hardware->bindParam(':location', 			$location);
		$hardware->bindParam(':status', 			$status);
		$hardware->bindParam(':replacing', 			$replacing);
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
				$location = $row['Excel Sheet'];
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
		$assets		= $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, version) VALUES (LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version)");
		$software 	= $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, verification, version) VALUES (LAST_INSERT_ID(), :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :verification, :version)");
				
		$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
		$vendor = $procured_from = $shortname = $purpose = $contract_type = $start_date = $license_explanation = $verification = "";
		
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
		$assets->bindValue(':version',					1);
		
		$software->bindParam(':vendor', 				$vendor);
		$software->bindParam(':procured_from', 			$procured_from);
		$software->bindParam(':shortname', 				$shortname);
		$software->bindParam(':purpose', 				$purpose);
		$software->bindParam(':contract_type', 			$contract_type);
		$software->bindParam(':start_date', 			$start_date);
		$software->bindParam(':license_explanation',	$license_explanation);
		$software->bindParam(':verification', 			$verification);
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
			if(isset($row['Verification Status'])) {
				$verification = $row['Verification Status'];
			}
			
			$assetv->execute();
			$assets->execute();
			$software->execute();
			
			$asset_ID = $description = $quantity = $price = $purchaseorder_id = $release_version = $expirydate = $remarks = $crtrno = "";
		
			$vendor = $procured_from = $shortname = $purpose = $contract_type = $start_date = $license_explanation = $verification = "";
		
		}
		$this->savelog($_SESSION['username'], "batch imported software assets");
	}
	
	public function editasset($asset) {
		$stmt = $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, version, parent) VALUES (:asset_tag, :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version, :parent)");
		$stmt->bindParam(':asset_tag',			$asset['asset_tag']);
		$stmt->bindParam(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindParam(':description', 		$asset['description']);
		$stmt->bindParam(':quantity', 			$asset['quantity']);
		$stmt->bindParam(':price', 				$asset['price']);
		$stmt->bindParam(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindParam(':release_version', 	$asset['release_version']);
		$stmt->bindParam(':expirydate', 		$asset['expirydate']);
		$stmt->bindParam(':remarks', 			$asset['remarks']);
		$stmt->bindParam(':crtrno', 			$asset['crtrno']);
		$stmt->bindParam(':version',			$asset['version']);
		$stmt->bindParam(':parent', 			$asset['parent']);
		
		$stmt->execute();
		
		$stmt = $this->db->prepare("UPDATE asset_version SET current_version=:version where asset_tag=:asset_tag");
		$stmt->bindParam(':asset_tag', $asset['asset_tag']);
		$stmt->bindParam(':version', $asset['version']);
		$stmt->execute();
	}
	
	public function editSoftware($asset) {
		$this->editAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, verification, version) VALUES (:asset_tag, :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :verification, :version)");
		$stmt->bindParam(':asset_tag',	$asset['asset_tag']);
		$stmt->bindParam(':vendor', 				$asset['vendor']);
		$stmt->bindParam(':procured_from', 			$asset['procured_from']);
		$stmt->bindParam(':shortname', 				$asset['shortname']);
		$stmt->bindParam(':purpose', 				$asset['purpose']);
		$stmt->bindParam(':contract_type', 			$asset['contract_type']);
		$stmt->bindParam(':start_date', 			$asset['start_date']);
		$stmt->bindParam(':license_explanation', 	$asset['license_explanation']);
		$stmt->bindParam(':verification', 			$asset['verification']);
		$stmt->bindParam(':version',				$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "edited software asset ".$asset['asset_ID']." (version ".$asset['version'].")");
	}
	
	public function editHardware($asset) {
		$this->editAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, status, replacing, version) VALUES (:asset_tag, :class, :brand, :audit_date, :component, :label, :serial, :location, :status, :replacing, :version)");
		$stmt->bindParam(':asset_tag',	$asset['asset_tag']);
		$stmt->bindParam(':class', 		$asset['class']);
		$stmt->bindParam(':brand', 		$asset['brand']);
		$stmt->bindParam(':audit_date', $asset['audit_date']);
		$stmt->bindParam(':component', 	$asset['component']);
		$stmt->bindParam(':label', 		$asset['label']);
		$stmt->bindParam(':serial', 	$asset['serial']);
		$stmt->bindParam(':location', 	$asset['location']);
		$stmt->bindParam(':status', 	$asset['status']);
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
		}
		$result['software'] = $stmt->fetchAll();
	
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
		}
		$result['hardware'] = $stmt->fetchAll();
		
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
		$stmt = $this->db->prepare("SELECT DISTINCT asset.purchaseorder_id FROM asset, asset_version WHERE asset.version = asset_version.current_version AND asset.asset_tag = asset_version.asset_tag ORDER BY purchaseorder_id");
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
		$stmt = $this->db->prepare("SELECT * from vendor ORDER BY vendor_name");
		$stmt->execute();
		$result['vendor'] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT * from procured_from ORDER BY procured_from_name");
		$stmt->execute();
		$result['procured_from'] = $stmt->fetchAll();
		
		$stmt = $this->db->prepare("SELECT * from shortname ORDER BY shortname_name");
		$stmt->execute();
		$result['shortname'] = $stmt->fetchAll();
		
        $stmt = $this->db->prepare("SELECT * from purpose ORDER BY purpose_name");
		$stmt->execute();
		$result['purpose'] = $stmt->fetchAll();
        
        $stmt = $this->db->prepare("SELECT * from contracttype ORDER BY contracttype_name");
		$stmt->execute();
		$result['contracttype'] = $stmt->fetchAll();
        
        $stmt = $this->db->prepare("SELECT * from class ORDER BY class_name");
		$stmt->execute();
		$result['class'] = $stmt->fetchAll();
        
        $stmt = $this->db->prepare("SELECT * from brand ORDER BY brand_name");
		$stmt->execute();
		$result['brand'] = $stmt->fetchAll();
        
        $stmt = $this->db->prepare("SELECT * from server ORDER BY server_name");
		$stmt->execute();
		$result['server'] = $stmt->fetchAll();
		return $result;
	}
	
	public function generateReport($type, $filter) {
		  $entry = '%'.$filter.'%';
		  $stmt = $this->db->prepare("SELECT * FROM asset WHERE ".$type." LIKE :filter");
		  $stmt->bindparam(":filter", $entry);
		  $stmt->execute();
		  
		  $this->savelog($_SESSION['username'], "generated report for $type $filter");
		  return $stmt->fetchAll();
	}
    
    public function addOption($type, $value) {
			
		  $stmt = $this->db->prepare("INSERT INTO ".$type." (".$type."_name) VALUES(:filter)");
		  $stmt->bindparam(":filter", $value);
		  $stmt->execute();
		  $this->savelog($_SESSION['username'], "added option $filter for $type");
	}
    
    public function deleteOption($type, $value) {
			
		  $stmt = $this->db->prepare("DELETE FROM ".$type." WHERE ".$type."_id= :filter");
		  $stmt->bindparam(":filter", $value);
		  $stmt->execute();
		  $this->savelog($_SESSION['username'], "removed option $filter for $type");
	}
	
	public function getCurrentVersion($asset_tag) {
		$stmt = $this->db->prepare("SELECT current_version FROM asset_version where asset_tag=:asset_tag");
		$stmt->bindparam(":asset_tag", $asset_tag);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public function getParents($asset, $savedIDs = array()) {
		
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
					
					echo "<div class='col-xs-6'>".htmlentities($parent['purchaseorder_id'])."</div>"; 
					
					echo "<div class='col-xs-6'>".htmlentities($parent['asset_ID'])."</div>";
					$this->getParents($parent, $savedIDs);
				}
			}
		}
	}
	
	public function getChildren($asset, $savedIDs = array()) {
		$stmt = $this->db->prepare("SELECT 	asset.asset_ID, asset.purchaseorder_id, asset.parent 
									FROM 	asset, asset_version 
									WHERE 	asset.parent=:asset_ID
									AND 	asset.version=asset_version.current_version
									AND		asset.asset_tag=asset_version.asset_tag");
		$stmt->bindparam(":asset_ID", $asset['asset_ID']);
		$stmt->execute();
		foreach($stmt->fetchAll() as $child) {
			if (!in_array($child, $savedIDs)) {
				array_push($savedIDs, $child);
				echo "<div class='col-xs-6'>".htmlentities($child['purchaseorder_id'])."</div>"; 
					
				echo "<div class='col-xs-6'>".htmlentities($child['asset_ID'])."</div>";
				$this->getChildren($child, $savedIDs);
			}
		}
	}
	
}
?>