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
	
	public function savelog($user, $time, $log) {
		//Logs an action
		$stmt = $this->db->prepare("INSERT INTO log(user, time, log) VALUES (:user, :time, :log)");
		$stmt->bindValue(':user', $user);
		$stmt->bindValue(':time', $time);
		$stmt->bindValue(':log', $log);
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
		   $this->savelog($_SESSION['username'], date("Y-m-d H:i:s"), "created $role $username");
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
				$this->savelog($_SESSION['username'], date("Y-m-d H:i:s"), 'logged in');
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
		$this->savelog($_SESSION['username'], date("Y-m-d H:i:s"), 'changed password');
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
	
	public function editUser($source, $username, $password, $role, $status) {
		//Updates the user based on the infomration provided
		//There must be at least one item changed 
		//For $username, $role, $status, it is checked against $source entry.
		//If it is different, then it will add statements to update
		//For password, "" is regarded as same
		
		//Flags to determine which fields have changed
		$sameusername = ($username == $source['username']);
		$samepassword = ($password == "");
		$samerole = ($role == $source['role']);
		$samestatus = ($status == $source['status']);
		
		
		//Prepare SQL Statement
		$sql = "UPDATE user SET ";
		
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
			$this->savelog($_SESSION['username'], date("Y-m-d H:i:s"), "edited user {$source['username']}");
		}
		else {
			$this->savelog($_SESSION['username'], date("Y-m-d H:i:s"), "edited user {$source['username']} to {$username}");
		}
	}
}
?>