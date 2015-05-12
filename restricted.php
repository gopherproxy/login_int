<?php
// taking up the session
session_start();
// checking session ID
if ($_SESSION['logged_in'] == true){ 
// get the username from login-page
$username = $_SESSION['name'];
// connect to the database
require_once("db_const.php");
$mysqli = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
// check connection
if ($mysqli->connect_errno) {
	// exit the current script
	die($mysqli->connect_error);
}
// query the image field for the logged in user
$result = $mysqli->query("SELECT image FROM users WHERE username = '$username' LIMIT 1");
// get the field value
$imgPath = $result->fetch_assoc();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Area 51</title>
</head>

<body>
<h1>Only for very special people (aliens, bulgarians and the like) and you, <?= $username ?>!</h1>
<p>Picture of <?= $username ?>:</p>
<!-- Generating dynamic image URL -->
<img src="<?= htmlspecialchars($imgPath['image']) ?>" width="100" alt="<?= $username ?>"/>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
<?php
// closing if condition from above
}
else {
    header("location:login.php");
}
?>