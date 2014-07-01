<?php

class Users {
	
	public $username = NULL;
	public $password = NULL;
	public $repassword = NULL;
	public $email = NULL;
	public $ucode = NULL;
	public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";
	
	// Construct method
	public function __construct($data = array()) { 
		if(isset($data['username'])) 
			$this->username = stripslashes(strip_tags($data['username']));
		if(isset($data['password'])) 
			$this->password = stripslashes(strip_tags($data['password']));
		if(isset($data['repassword']))
			$this->repassword = stripslashes(strip_tags($data['repassword']));
		if(isset($data['email']))
			$this->email = stripslashes(strip_tags($data['email']));
		if(isset($data['ucode']))
			$this->ucode = stripslashes(strip_tags($data['ucode']));
		if(isset($data['server']))
			$this->server = stripslashes(strip_tags($data['server']));
	}
	
	// Store data sent from the form
	public function storeData($params) {
		$this->__construct($params); 
	}

	// Login function
	public function userLogin() {	
		$success = false; 
		try { //create our pdo object 
			$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD); //set how pdo will handle errors 
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //this would be our query. 
			$sql = "SELECT * FROM users WHERE username = :username AND password = :password AND world = :server LIMIT 1"; //prepare the statements 
			
			$stmt = $con->prepare($sql); //give value to named parameter :username 
			$stmt->bindValue("username", $this->username, PDO::PARAM_STR); //give value to named parameter :password 
			$stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
			$stmt->bindValue("server", $this->server, PDO::PARAM_STR);
			$stmt->execute();
			
			$valid = $stmt->fetchColumn(); 
			
			if($valid)
				$success = true;
				
			$con = NULL;
			return $success; 
			
			} catch(PDOException $e) {
			  	echo $e->getMessage(); 
				return $success;
			}
	} 
	
	// Register function
	public function register() {
		$correct = false;
		try {
			$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO users (username, password, email, uniquecode, world) VALUES (:username, :password, :email, :ucode, :server)";
			
			$stmt = $con->prepare($sql);
			$stmt->bindValue("username", $this->username, PDO::PARAM_STR);
			$stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
			$stmt->bindValue("email", $this->email, PDO::PARAM_STR);
			$stmt->bindValue("ucode", $this->ucode, PDO::PARAM_STR);
			$stmt->bindValue("server", $this->server, PDO::PARAM_STR);
			$stmt->execute();
			
			} catch(PDOException $e) {
				return $e->getMessage();
			}
	}
	
	// Verify register inputs
	public function verifyRegister() {
		
		$error = array();
		
		// Verify usernames' length and if exists or not
		if((strlen($this->username) < 4) || (strlen($this->username) > 15))
			$error[0] = "Username length must be between 4 and 15 characters.";
		
		// Verify is usename contains only english letters
		if(preg_match('/[^A-Za-z]+/', $this->username))
			$error[1] = "Username should contain only English letters.";
			
		// Verify if username and email address exist or not
		try {
			$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sqlu = "SELECT * FROM users WHERE username = :username LIMIT 1";		
			$stmtu = $con->prepare($sqlu);
			$stmtu->bindValue("username", $this->username, PDO::PARAM_STR);
			$stmtu->execute();			
			$validu = $stmtu->fetchColumn(); 
			
			if($validu)
				$error[2] = "Username is already taken.";
				
			$sqle = "SELECT * FROM users WHERE email = :email LIMIT 1";	
			$stmte = $con->prepare($sqle);
			$stmte->bindValue("email", $this->email, PDO::PARAM_STR);
			$stmte->execute();
			$valide = $stmte->fetchColumn();
			
			if($valide)
				$error[3] = "E-mail address is already taken.";
				
		} catch(PDOException $e) {
			return $e->getMessage();
		}
			
		// Verify if all fields are completed
		if((empty($this->username) || empty($this->password) || empty($this->repassword) || empty($this->email) || empty($this->ucode)))
			$error[4] = "All fields are required.";
		
		// Verify if passwords match
		if($this->password != $this->repassword)
			$error[5] = "Both passwords must be the same.";
		
		// Verify passwords' length
		if(strlen($this->password) < 6)
			$error[6] = "Password should be longer than 7 characters." ;
			
		// Verify unique code length
		if(strlen($this->ucode) != 6)
			$error[7] = "Unique code must consist of 6 digits.";
			
		// Verify if the code contains only digits
		if(preg_match('/[^0-9]+/', $this->ucode)) // if(ctype_digit($this->ucode))
			$error[8] = "Characters from unique code should all be digits.";
		
		if($error != NULL) {
			$view['content'] = NULL;
			foreach($error as $value)
				$view['content'] = $view['content'] . '<br />' . $value;
			return $view['content'];		
		} else		
			return "verified";
	}

}
?>