<?php
ini_set('display_errors', 'On');
/*require_once('phptestconn.php');*/

$servername = 'localhost';
$username = 'root';
$password = 'alexlkong';
$dbname = 'sickride';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn)
	die("Connection failed: " . $conn->connect_error);

$username = "";
$errInput = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) || empty($password))
		$errInput = "Your username did not match your password.";
	else {
		$checkIfExists = mysqli_query($conn, "SELECT * FROM driver_profile WHERE username = '".$username."' AND password = '".md5($password)."'");

		if (!$checkIfExists)
			die("Failure!" . mysqli_error($conn));

		$numRows = mysqli_num_rows($checkIfExists);

		if ($numRows == 0)
			$errInput = "Your username did not match your password.";
		else {
			echo "Success!";
			//start a session
		}
	}
}
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Driver Sign-in</title>
		<link rel="stylesheet" href="driver_signup.css"></link>
		<!--add CSS stylesheet here-->
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="driver_login">
			<p>Username: </p><input type="text" name="username" value="<?php if (isset($username)) echo $username;?>"></input></p>
			<p>Password: </p><input type="password" name="password"></input><p><?php echo $errInput;?></p><!--Obviously will add a checking statement here to prevent brute-force attacks-->
			<br>
			<input type="submit" value="Sign In!"></input>
		</form>
	</body>
</html>