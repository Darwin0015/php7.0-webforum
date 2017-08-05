<?php
$output =NULL;

if(isset($_POST['submit'])){
	//Connect to databse
	$mysqli = NEW MySQLi('localhost','root','','test');

	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$rpassword = $mysqli->real_escape_string($_POST['rpassword']);
	$email = $mysqli->real_escape_string($_POST['email']);


	$query = $mysqli->query("SELECT * FROM accounts WHERE username ='$username'");// kapag may kaparehas na username
	$emailquery = $mysqli->query("SELECT * FROM accounts WHERE email ='$email'"); // kapag may kaparehas na email


	if(empty($username) Or empty($password) Or empty($email) Or empty($rpassword)){
		$output ="Please fill in all fields";
	}
	elseif($query->num_rows != 0){
		$output = "That username is already taken";
	}elseif($emailquery->num_rows != 0){
		$output = "That email is already in use choose another one";
	}elseif($rpassword != $password){
		$output = "Your password don't match";
	}elseif(strlen($password) < 6){
		$output = "Your password must be at least 5 characters";
	}else{

		// Encryt the passowrd
		$password = md5($password);

		//Insert the record
		$insert = $mysqli->query("INSERT INTO accounts(username,password,email) VALUES('$username','$password','$email')");
			if($insert != TRUE){
				$output = "There was a problem <br />";
				$output .= $mysqli->error;
			}else{
				$output = "You have been registered!";
			}
	}
}
?>

<form method="POST">
	<table>
		<tr>
			<td>Username:</td>
			<td><input type="TEXT" name="username"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="PASSWORD" name="password"></td>
		</tr>
		<tr>
			<td>Repeat Password:</td>
			<td><input type="PASSWORD" name="rpassword"></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="TEXT" name="email"></td>
		</tr>
	</table>
	<input type="SUBMIT" name="submit" value="Register">
</form>

<?php
	echo $output;
?>