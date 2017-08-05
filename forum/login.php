<?php

session_start();
$output = NULL;

// Check Form
if(isset($_POST['submit'])){
	$username = $_POST['username'];
	$password = $_POST['password'];


	if(empty($username) || empty ($password)){
		$output = "Please enter all fields";
	}else{
		// Connect to the databse
		$mysqli = NEW MySQLi('localhost','root','','test');


		$username = $mysqli->real_escape_string($username);
		$password = $mysqli->real_escape_string($password);

		$query = $mysqli->query("SELECT id FROM accounts WHERE username ='$username' AND password = md5('$password')");

		if($query->num_rows == 0){
			$output = "Invalid username/password";
		}else{
			// User logged in successfully
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['user'] = $username;

			$output = "WELCOME" . $_SESSION['user'] ." -<a href='logout.php'>Logout</a>";
		}

	}
}

if(!isset($_SESSION['loggedin'])){
	//Display Welcome Guest / Display login form
	
	echo  "Welsome Guest. <p/>";

	?>

	<form method="POST">
		Username: <input type="TEXT" name="username" />
		<p />
		Password: <input type="PASSWORD" name="password" />
		<br />
		<input type="SUBMIT" name="submit" value="Log In" />
	</form>
	<?php

}else{
	// Display welcome USER / Display logout
}

echo $output;

?>