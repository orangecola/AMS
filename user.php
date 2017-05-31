<?php
class USER
{
    private $db;
	public $softwareFields = array('vendor', 'procured_from', 'shortname', 'purpose', 'contract_type', 'start_date', 'license_explanation', 'verification');
	public $assetFields = array('asset_ID', 'description', 'quantity', 'price', 'crtrno', 'purchaseorder_id', 'release_version', 'expirydate', 'remarks');
	public $hardwareFields = array('class', 'brand', 'audit_date', 'component', 'label', 'serial', 'location', 'status', 'replacing'); 
	public $userFields = array('username', 'password', 'role', 'status');
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
	public function check($username) {
		//Checks if the username that has been taken. True if not taken, false if taken.
		$stmt = $this->db->prepare("SELECT * FROM user WHERE username=:username");
		$stmt->bindValue(':username', $username);
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
		$stmt->bindValue(':version', $asset['version']);
		$stmt->execute();
		
		$stmt = $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, version) VALUES (LAST_INSERT_ID(), :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version)");
		$stmt->bindValue(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindValue(':description', 		$asset['description']);
		$stmt->bindValue(':quantity', 			$asset['quantity']);
		$stmt->bindValue(':price', 				$asset['price']);
		$stmt->bindValue(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindValue(':release_version', 	$asset['release_version']);
		$stmt->bindValue(':expirydate', 		$asset['expirydate']);
		$stmt->bindValue(':remarks', 			$asset['remarks']);
		$stmt->bindValue(':crtrno', 			$asset['crtrno']);
		$stmt->bindValue(':version',			$asset['version']);
		
		$stmt->execute();
	}
	
	public function addSoftware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, verification, version) VALUES (LAST_INSERT_ID(), :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :verification, :version)");
		$stmt->bindValue(':vendor', 				$asset['vendor']);
		$stmt->bindValue(':procured_from', 			$asset['procured_from']);
		$stmt->bindValue(':shortname', 				$asset['shortname']);
		$stmt->bindValue(':purpose', 				$asset['purpose']);
		$stmt->bindValue(':contract_type', 			$asset['contract_type']);
		$stmt->bindValue(':start_date', 			$asset['start_date']);
		$stmt->bindValue(':license_explanation', 	$asset['license_explanation']);
		$stmt->bindValue(':verification', 			$asset['verification']);
		$stmt->bindValue(':version',				$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created software asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function addHardware($asset) {
		$this->addAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, status, replacing, version) VALUES (LAST_INSERT_ID(), :class, :brand, :audit_date, :component, :label, :serial, :location, :status, :replacing, :version)");
		$stmt->bindValue(':class', 		$asset['class']);
		$stmt->bindValue(':brand', 		$asset['brand']);
		$stmt->bindValue(':audit_date', $asset['audit_date']);
		$stmt->bindValue(':component', 	$asset['component']);
		$stmt->bindValue(':label', 		$asset['label']);
		$stmt->bindValue(':serial', 	$asset['serial']);
		$stmt->bindValue(':location', 	$asset['location']);
		$stmt->bindValue(':status', 	$asset['status']);
		$stmt->bindValue(':replacing', 	$asset['replacing']);
		$stmt->bindValue(':version',	$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created hardware asset ".$asset['asset_ID']." version ".$asset['version']);
	}
	
	public function editasset($asset) {
		$stmt = $this->db->prepare("INSERT INTO asset(asset_tag, asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno, version) VALUES (:asset_tag, :asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno, :version)");
		$stmt->bindValue(':asset_tag',			$asset['asset_tag']);
		$stmt->bindValue(':asset_ID', 			$asset['asset_ID']);
		$stmt->bindValue(':description', 		$asset['description']);
		$stmt->bindValue(':quantity', 			$asset['quantity']);
		$stmt->bindValue(':price', 				$asset['price']);
		$stmt->bindValue(':purchaseorder_id', 	$asset['purchaseorder_id']);
		$stmt->bindValue(':release_version', 	$asset['release_version']);
		$stmt->bindValue(':expirydate', 		$asset['expirydate']);
		$stmt->bindValue(':remarks', 			$asset['remarks']);
		$stmt->bindValue(':crtrno', 			$asset['crtrno']);
		$stmt->bindValue(':version',			$asset['version']);
		
		$stmt->execute();
		
		$stmt = $this->db->prepare("UPDATE asset_version SET current_version=:version where asset_tag=:asset_tag");
		$stmt->bindValue(':asset_tag', $asset['asset_tag']);
		$stmt->bindValue(':version', $asset['version']);
		$stmt->execute();
	}
	
	public function editSoftware($asset) {
		$this->editAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, verification, version) VALUES (:asset_tag, :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :verification, :version)");
		$stmt->bindValue(':asset_tag',	$asset['asset_tag']);
		$stmt->bindValue(':vendor', 				$asset['vendor']);
		$stmt->bindValue(':procured_from', 			$asset['procured_from']);
		$stmt->bindValue(':shortname', 				$asset['shortname']);
		$stmt->bindValue(':purpose', 				$asset['purpose']);
		$stmt->bindValue(':contract_type', 			$asset['contract_type']);
		$stmt->bindValue(':start_date', 			$asset['start_date']);
		$stmt->bindValue(':license_explanation', 	$asset['license_explanation']);
		$stmt->bindValue(':verification', 			$asset['verification']);
		$stmt->bindValue(':version',				$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "edited software asset ".$asset['asset_ID']." (version ".$asset['version'].")");
	}
	
	public function editHardware($asset) {
		$this->editAsset($asset);
		
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, status, replacing, version) VALUES (:asset_tag, :class, :brand, :audit_date, :component, :label, :serial, :location, :status, :replacing, :version)");
		$stmt->bindValue(':asset_tag',	$asset['asset_tag']);
		$stmt->bindValue(':class', 		$asset['class']);
		$stmt->bindValue(':brand', 		$asset['brand']);
		$stmt->bindValue(':audit_date', $asset['audit_date']);
		$stmt->bindValue(':component', 	$asset['component']);
		$stmt->bindValue(':label', 		$asset['label']);
		$stmt->bindValue(':serial', 	$asset['serial']);
		$stmt->bindValue(':location', 	$asset['location']);
		$stmt->bindValue(':status', 	$asset['status']);
		$stmt->bindValue(':replacing', 	$asset['replacing']);
		$stmt->bindValue(':version',	$asset['version']);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "edited hardware asset ".$asset['asset_ID']." (version ".$asset['version'].")");
	}
	
	public function savelog($user, $log) {
		//Logs an action
		
		date_default_timezone_set('Asia/Singapore');
		$time = date("Y-m-d H:i:s");
		$stmt = $this->db->prepare("INSERT INTO log(user, time, log) VALUES (:user, :time, :log)");
		$stmt->bindValue(':user', $user);
		$stmt->bindValue(':time', $time);
		$stmt->bindValue(':log', $log);
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
		$stmt->bindValue(':username', $_SESSION['username']);
		$stmt->bindValue(':password', $new_password);
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
		$stmt->bindValue(':user_ID', $user_ID);
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
		$stmt->bindValue(':asset_tag', $asset_tag);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$result[0] = true;
			$result[1] = $stmt->fetch();
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
            asset_version.current_version = asset.version AND
            asset_version.current_version = hardware.version");
		$stmt->bindValue(':asset_tag', $asset_tag);
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
}
?>