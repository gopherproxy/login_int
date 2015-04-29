 <?php
if (isset($_POST['login'])) {
    require_once("db_const.php");
    $mysqli = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
    // check connection
    if ($mysqli->connect_errno) {
        // exit the current script
        die($mysqli->connect_error);
    }
 	// avoiding sql injection (' or 0=0 #) by escaping special characters in sql queries
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = hash("sha256", $_POST['password']);
    // formulating the sql queri as PHP string
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
    // passing the string on to the query method, executing the query
    $result = $mysqli->query($sql);
    // if the query is NOT returning anything, if there is no match in the database
    if (!$result->num_rows == 1) {
        echo "<p>Invalid username/password!</p>";
    }      
        ######################
        # do more stuff here #
        ######################
                
        // open a PHP session
		session_start();
		// session name, activating the specific session
		$_SESSION['logged_in'] = true;
		// redirecting to a specific URL
		header("Location: restricted.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Login</title>
</head>

<body>
<!-- The HTML login form -->
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
  Username:
  <input type="text" name="username" required>
  <br>
  Password:
  <input type="password" name="password" required>
  <br>
  <input type="submit" name="login" value="Login">
</form>
</body>
</html>