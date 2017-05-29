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
	
	public function checkasset($assetID) {
		//Checks if the asset ID has been taken. True if not taken, false if taken.
		$stmt = $this->db->prepare("SELECT * FROM asset WHERE asset_ID=:asset_ID");
		$stmt->bindValue(':asset_ID', $assetID);
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
	
	public function addasset($asset_id, $description, $quantity, $price, $crtrno, $pono, $release, $expiry, $remarks) {
		$stmt = $this->db->prepare("INSERT INTO asset(asset_ID, description, quantity, price, purchaseorder_id, release_version, expirydate, remarks, crtrno) VALUES (:asset_ID, :description, :quantity, :price, :purchaseorder_id, :release_version, :expirydate, :remarks, :crtrno)");
		$stmt->bindValue(':asset_ID', $asset_id);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':quantity', $quantity);
		$stmt->bindValue(':price', $price);
		$stmt->bindValue(':purchaseorder_id', $pono);
		$stmt->bindValue(':release_version', $release);
		$stmt->bindValue(':expirydate', $expiry);
		$stmt->bindValue(':remarks', $remarks);
		$stmt->bindValue(':crtrno', $crtrno);
		$stmt->execute();
	}
	
	public function addSoftware($asset_id, $vendor, $procure, $shortname, $purpose, $contracttype, $startdate, $license, $verification) {
		$stmt = $this->db->prepare("INSERT INTO software(asset_tag, vendor, procured_from, shortname, purpose, contract_type, start_date, license_explanation, verification) VALUES (LAST_INSERT_ID(), :vendor, :procured_from, :shortname, :purpose, :contract_type, :start_date, :license_explanation, :verification)");
		$stmt->bindValue(':vendor', $vendor);
		$stmt->bindValue(':procured_from', $procure);
		$stmt->bindValue(':shortname', $shortname);
		$stmt->bindValue(':purpose', $purpose);
		$stmt->bindValue(':contract_type', $contracttype);
		$stmt->bindValue(':start_date', $startdate);
		$stmt->bindValue(':license_explanation', $license);
		$stmt->bindValue(':verification', $verification);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created software asset ".$asset_id);
	}
	
	public function addHardware($asset_id, $class, $brand, $auditdate, $component, $label, $serial, $location, $status, $replacing) {
		$stmt = $this->db->prepare("INSERT INTO hardware(asset_tag, class, brand, audit_date, component, label, serial, location, status, replacing) VALUES (LAST_INSERT_ID(), :class, :brand, :audit_date, :component, :label, :serial, :location, :status, :replacing)");
		$stmt->bindValue(':class', $class);
		$stmt->bindValue(':brand', $brand);
		$stmt->bindValue(':audit_date', $auditdate);
		$stmt->bindValue(':component', $component);
		$stmt->bindValue(':label', $label);
		$stmt->bindValue(':serial', $serial);
		$stmt->bindValue(':location', $location);
		$stmt->bindValue(':status', $status);
		$stmt->bindValue(':replacing', $replacing);
		$stmt->execute();
		$this->savelog($_SESSION['username'], "created hardware asset ".$asset_id);
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
	
	public function getAssets() {
		//Gets all of the asset details
		$stmt = $this->db->prepare("SELECT * FROM asset");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getSoftwareList() {
		//Gets all of the software details
		$stmt = $this->db->prepare("SELECT * FROM asset INNER JOIN software WHERE asset.asset_tag=software.asset_tag");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getHardwareList() {
		//Gets all of the software details
		$stmt = $this->db->prepare("SELECT * FROM asset INNER JOIN hardware where asset.asset_tag=hardware.asset_tag");
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
		$stmt = $this->db->prepare("SELECT * from asset INNER JOIN software where software.asset_tag=asset.asset_tag AND software.asset_tag=:asset_tag");
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
		$stmt = $this->db->prepare("SELECT * from asset INNER JOIN hardware where hardware.asset_tag=asset.asset_tag AND hardware.asset_tag=:asset_tag");
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
	
	public function editAsset($source, $candidate){
		
		$sql = $this->prepareEditSQL($this->assetFields, $source, $candidate);
		
		if ($sql[0] != "") {
			$sql[0] 				= "UPDATE asset SET".$sql[0]." WHERE asset_tag =:asset_tag";
			$sql[1][':asset_tag'] 	= $source['asset_tag'];
			
			$stmt					= $this->db->prepare($sql[0]);
			$stmt->execute($sql[1]);
		}
	}
	
	public function editHardware ($source, $candidate) {
		
		//Updates the Asset Table
		$this->editAsset($source, $candidate);

		//Updates the Hardware table
			
		$sql = $this->prepareEditSQL($this->hardwareFields, $source, $candidate);
		if ($sql[0] != "") {
			$sql[0] 				= "UPDATE hardware SET".$sql[0]." WHERE asset_tag =:asset_tag";
			$sql[1][':asset_tag'] 	= $source['asset_tag'];
			
			$stmt					= $this->db->prepare($sql[0]);
			$stmt->execute($sql[1]);
		}
	
		if ($source['asset_ID'] == $candidate['asset_ID']) {
		$this->savelog($_SESSION['username'], "edited hardware asset {$source['asset_ID']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited hardware asset {$source['asset_ID']} to {$candidate['asset_ID']}");
		}
	}
	
	public function editSoftware ($source, $candidate) {
		
		//Updates the Asset Table
		$this->editAsset($source, $candidate);

		//Updates the Software table
			
		$sql = $this->prepareEditSQL($this->softwareFields, $source, $candidate);
		if ($sql[0] != "") {
			$sql[0] 				= "UPDATE software SET".$sql[0]." WHERE asset_tag =:asset_tag";
			$sql[1][':asset_tag'] 	= $source['asset_tag'];
			
			$stmt					= $this->db->prepare($sql[0]);
			$stmt->execute($sql[1]);
		}
	
		if ($source['asset_ID'] == $candidate['asset_ID']) {
		$this->savelog($_SESSION['username'], "edited software asset {$source['asset_ID']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited software asset {$source['asset_ID']} to {$assetid}");
		}
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