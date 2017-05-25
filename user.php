<?php
class USER
{
    private $db;
 
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
	
	public function editUser($source, $username, $password, $role, $status) {
		//Updates the user based on the infomration provided
		//There must be at least one item changed 
		//For $username, $role, $status, it is checked against $source entry.
		//If it is different, then it will add statements to update
		//For password, "" is regarded as same
		
		//Flags to determine which fields have changed
		$sameusername 			= ($username == $source['username']);
		$samepassword 			= ($password == "");
		$samerole 				= ($role == $source['role']);
		$samestatus 			= ($status == $source['status']);
		
		
		//Prepare SQL Statement
		$sql 					= "UPDATE user SET ";
		
		//Part 1: Add field to update
		//Part 2: Add a comma if there are still fields to add.
		//Order: Username -> Password -> Role -> Status
		if (!$sameusername) {
			$sql .= "username=:username";

			if (!$samepassword or !$samerole or !$samestatus) {
				$sql .= ",";
			}
		}
		if (!$samepassword) {
			$sql .= "password=:password";

			if (!$samerole or !$samestatus) {
				$sql .= ",";
			}
		}
		if (!$samerole) {
			$sql .= "role=:role";
			
			if (!$samestatus) {
				$sql .= ",";
			}
		}
		
		if (!$samestatus) {
			$sql .= "status=:status";
		}
		
		//Ending
		$sql .= " WHERE user_ID=:user_ID";
		
		$stmt=$this->db->prepare($sql);
		if(!$sameusername) $stmt->bindValue(':username', $username);
		if(!$samepassword) $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
		if(!$samerole) $stmt->bindValue(':role', $role);
		if(!$samestatus) $stmt->bindValue(':status', $status);
		
		$stmt->bindValue(':user_ID', $source['user_ID']);
		$stmt->execute();
		
		if ($sameusername) {
			$this->savelog($_SESSION['username'], "edited user {$source['username']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited user {$source['username']} to {$username}");
		}
	}
	
	public function editAsset($source, $assetid, $description, $quantity, $price, $crtrno, $pono, $release, $expirydate, $remarks){
			
		$sameid 						= ($source['asset_ID'] == $assetid);
		$samedescription				= ($source['description'] == $description);
		$samequantity					= ($source['quantity'] == $quantity);
		$sameprice						= ($source['price'] == $price);
		$samecrtrno						= ($source['crtrno'] == $crtrno);
		$samepono						= ($source['purchaseorder_id'] == $pono);
		$samerelease					= ($source['release_version'] == $release);
		$sameexpirydate					= ($source['expirydate'] == $expirydate);
		$sameremarks					= ($source['remarks'] == $remarks);
			
		if (!($sameid and $samedescription and $samequantity and $sameprice and $samecrtrno and $samepono and $samerelease and $sameexpirydate and $sameremarks)) {
				
		$sql 			= "UPDATE asset SET";
		$assetarray 	= array();
		
			if (!$sameid) {
				$sql 						.= ' asset_ID=:assetid ';
				$assetarray[':assetid']		= $assetid;

				if (!($samedescription and $samequantity and $sameprice and $samecrtrno and $samepono and $samerelease and $sameexpirydate and $sameremarks)) {
					$sql .= ',';
				}			
			}
			
			if (!$samedescription) {
				$sql						.= ' description=:description ';
				$assetarray[':description'] = $description;
				
				if (!($samequantity and $sameprice and $samecrtrno and $samepono and $samerelease and $sameexpirydate and $sameremarks)) {
					$sql .= ',';
				}
			}
			
			if (!$samequantity) {
				$sql						.= ' quantity=:quantity ';
				$assetarray[':quantity'] 	= $quantity;
				
				if (!($sameprice and $samecrtrno and $samepono and $samerelease and $sameexpirydate and $sameremarks)) {
					$sql .= ',';
				}
			}
			
			if (!$sameprice) {
				$sql						.= ' price=:price ';
				$assetarray[':price'] 		= $price;
				
				if (!($samecrtrno and $samepono and $samerelease and $sameexpirydate and $sameremarks)) {
					$sql .= ',';
				}
			}
			
			if (!$samecrtrno) {
				$sql						.= ' crtrno=:crtrno ';
				$assetarray[':crtrno'] 		= $crtrno;
				
				if (!($samepono and $samerelease and $sameexpirydate and $sameremarks)) {
					$sql .= ',';
				}
			}
			
			if (!$samepono) {
				$sql						.= ' purchaseorder_id=:pono ';
				$assetarray[':pono'] 		= $pono;
				
				if ($samerelease and $sameexpirydate and $sameremarks) {
					$sql .= ',';
				}
			}
			
			if (!$samerelease) {
				$sql						.= ' release_version=:release_version ';
				$assetarray[':release_version'] = $release;
				
				if (!($sameexpirydate and $sameremarks)) {
					$sql .= ',';
				}
			}
			
			if (!$sameexpirydate) {
				$sql						.= ' expirydate=:expirydate ';
				$assetarray[':expirydate'] 	= $expirydate;
				
				if (!$sameremarks) {
					$sql .= ',';
				}
			}
			
			if (!$sameremarks) {
				$sql						.= ' remarks=:remarks ';
				$assetarray[':remarks'] 	= $remarks;
			}
			
			$sql 						.= "WHERE asset_tag =:asset_tag";
			$assetarray[':asset_tag'] 	= $source['asset_tag'];
			
			$stmt 						= $this->db->prepare($sql);
			$stmt->execute($assetarray);
		}
	}
	
	public function editHardware ($source, $assetid, $description, $quantity, $price, $crtrno, $pono, $release, $expirydate, $remarks, $class, $brand, $auditdate, $component, $label, $serial, $location, $status, $replacing) {
		
		//Updates the Asset Table
		$this->editAsset($source, $assetid, $description, $quantity, $price, $crtrno, $pono, $release, $expirydate, $remarks);

		
		//Updates the hardware table		
		$sameclass			= ($source['class'] == $class); 
		$samebrand			= ($source['brand'] == $brand);
		$sameauditdate		= ($source['audit_date'] == $auditdate);
		$samecomponent		= ($source['component'] == $component);
		$samelabel			= ($source['label'] == $label);
		$sameserial			= ($source['serial'] == $serial);
		$samelocation		= ($source['location'] == $location);
		$samestatus			= ($source['status'] == $status);
		$samereplacing		= ($source['replacing'] == $replacing);
		
		if (!($sameclass and $samebrand and $sameauditdate and $samecomponent and $samelabel and $sameserial and $samelocation and $samestatus and $samereplacing)) {
			$sql = "UPDATE hardware SET ";
			$hardwarearr = array();
			
			if (!$sameclass) {
				$sql						.='class=:class';
				$hardwarearr[':class']		= $class;
				
				if (!($samebrand and $sameauditdate and $samecomponent and $samelabel and $sameserial and $samelocation and $samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$samebrand) {
				$sql						.='brand=:brand';
				$hardwarearr[':brand']		= $brand;
				
				if (!($sameauditdate and $samecomponent and $samelabel and $sameserial and $samelocation and $samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$sameauditdate) {
				$sql						.='audit_date=:audit_date';
				$hardwarearr[':audit_date']	= $auditdate;
				
				if (!($samecomponent and $samelabel and $sameserial and $samelocation and $samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$samecomponent) {
				$sql						.='component=:component';
				$hardwarearr[':component']	= $component;
				
				if (!($samelabel and $sameserial and $samelocation and $samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$samelabel) {
				$sql						.='label=:label';
				$hardwarearr[':label']		= $label;
				
				if (!($sameserial and $samelocation and $samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$sameserial) {
				$sql						.='serial=:serial';
				$hardwarearr[':serial']		= $serial;
				
				if (!($samelocation and $samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$samelocation) {
				$sql						.='location=:location';
				$hardwarearr[':location']	= $location;
				
				if (!($samestatus and $samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$samestatus) {
				$sql						.='status=:status';
				$hardwarearr[':status']		= $status;
				
				if (!($samereplacing)) {
					$sql					.=',';
				}
			}
			
			if (!$samereplacing) {
				$sql						.='replacing=:replacing';
				$hardwarearr[':replacing']	= $replacing;
			}
			
			$sql						.= ' WHERE asset_tag=:asset_tag';
			$hardwarearr[':asset_tag']	= $source['asset_tag'];
			
			$stmt						= $this->db->prepare($sql);
			$stmt->execute($hardwarearr);
		}
		if ($source['asset_ID'] == $assetid) {
			$this->savelog($_SESSION['username'], "edited hardware asset {$source['asset_ID']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited hardware asset {$source['asset_ID']} to {$assetid}");
		}
	}
	
	public function editSoftware ($source, $assetid, $description, $quantity, $price, $crtrno, $pono, $release, $expirydate, $remarks, $vendor, $procure, $shortname, $purpose, $contracttype, $license, $verification) {
		
		//Updates the Asset Table
		$this->editAsset($source, $assetid, $description, $quantity, $price, $crtrno, $pono, $release, $expirydate, $remarks);

		
		//Updates the Software table		
		$samevendor			= ($source['vendor'] == $vendor); 
		$sameprocure		= ($source['procured_from'] == $procure);
		$sameshortname		= ($source['shortname'] == $shortname);
		$samepurpose		= ($source['purpose'] == $purpose);
		$samecontracttype	= ($source['contract_type'] == $contracttype);
		$samelicense		= ($source['license_explanation'] == $license);
		$sameverification	= ($source['verification'] == $verification);
		
		if (!($samevendor and $sameprocure and $sameshortname and $samepurpose and $samecontracttype and $samelicense and $sameverification)) {
			$sql = "UPDATE software SET ";
			$hardwarearr = array();
			
			if (!$samevendor) {
				$sql						.='vendor=:vendor';
				$hardwarearr[':vendor']		= $vendor;
				
				if (!($sameprocure and $sameshortname and $samepurpose and $samecontracttype and $samelicense and $sameverification)) {
					$sql					.=',';
				}
			}
			
			if (!$sameprocure) {
				$sql						.='procured_from=:procured_from';
				$hardwarearr[':procured_from']		= $procure;
				
				if (!($sameshortname and $samepurpose and $samecontracttype and $samelicense and $sameverification)) {
					$sql					.=',';
				}
			}
			
			if (!$sameshortname) {
				$sql							.='shortname=:shortname';
				$hardwarearr[':shortname']		= $shortname;
				
				if (!($samepurpose and $samecontracttype and $samelicense and $sameverification)) {
					$sql					.=',';
				}
			}
			
			if (!$samepurpose) {
				$sql							.='purpose=:purpose';
				$hardwarearr[':purpose']		= $purpose;
				
				if (!($samecontracttype and $samelicense and $sameverification)) {
					$sql					.=',';
				}
			}
			
			if (!$samecontracttype) {
				$sql							.='contract_type=:contract_type';
				$hardwarearr[':contract_type']	= $contracttype;
				
				if (!($samelicense and $sameverification)) {
					$sql					.=',';
				}
			}
			
			if (!$samelicense) {
				$sql						.='license_explanation=:license_explanation';
				$hardwarearr[':license_explanation']		= $license;
				
				if (!$sameverification) {
					$sql					.=',';
				}
			}
			
			if (!$sameverification) {
				$sql						.='verification=:verification';
				$hardwarearr[':verification']	= $verification;
				
			}
			
	
			
			$sql						.= ' WHERE asset_tag=:asset_tag';
			$hardwarearr[':asset_tag']	= $source['asset_tag'];

			$stmt						= $this->db->prepare($sql);
			$stmt->execute($hardwarearr);
		}
		
		if ($source['asset_ID'] == $assetid) {
			$this->savelog($_SESSION['username'], "edited software asset {$source['asset_ID']}");
		}
		else {
			$this->savelog($_SESSION['username'], "edited software asset {$source['asset_ID']} to {$assetid}");
		}
	}
}
?>