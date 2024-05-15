<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	 
	$username = $_POST["username"]; 
	$email = $_POST["email"]; 
	$password = $_POST["password"]; 
    $role = $_POST["role"];

	
	// Hash the password 
	$hashed_password = password_hash($password, PASSWORD_BCRYPT); 
	$host = "localhost"; 
	$dbname = "food-order"; 
	$username_db = "admin"; 
	$password_db = "bhargav"; 
	try { 
		$db = new PDO( 
		"mysql:host=$host;dbname=$dbname", 
			$username_db, $password_db); 
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		
		// Insert the user into the database 
		$stmt = $db->prepare( 
		"INSERT INTO users (email, password,username,role) 
			VALUES (:email,:password, :username, :role)"); 
		

		$stmt->bindParam(":email", $email); 
		$stmt->bindParam(":password", $hashed_password); 
        $stmt->bindParam(":username", $username); 
        $stmt->bindParam(":role", $role); 
		$stmt->execute(); 
		echo "<h2>Registration Successful</h2>"; 
		echo "Thank you for registering, " . $username . "!<br>"; 
		echo "You'll be redirected to login page in 3 seconds"; 
		header("refresh:3;url=login.html"); 
	} 
	catch(PDOException $e) { 
		echo "Connection failed: " . $e->getMessage(); 
	} 
} 
?>
