<?php 
// loading contents from external php file
// passing on the target path to file as argument
require_once("db_const.php");
// checking IF form-array exists
if(isset($_POST['submit'])){
	
    #############################
    # connect to mysql database #
    #############################

//creating a new object from the mysqli class and submitting the connection CONSTANTS
$connection = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
// calling the method connect_error from the mysqli class
if($connection->connect_error){
	// if there is a connection error, shut down the connection to server
	die($connection->connect_error);
	} 
// prepare data for insertion into database
// collect form values
$username = $_POST['username'];
// adding password encryption
$password = hash("sha256", $_POST['password']);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
// check if username and email exist, else insert data into database
    $exists = 0;
    $check = $connection->query("SELECT username FROM users WHERE username = '$username' LIMIT 1");
    // sometimes we only want to retrieve a subset of records. In MySQL, this is accomplished using the LIMIT keyword
    if ($check->num_rows == 1) {
        $exists = 1;
        $check = $connection->query("SELECT email from users WHERE email = '$email' LIMIT 1");
        if ($check->num_rows == 1) $exists = 2;    
    } else {
        $check = $connection->query("SELECT email from users WHERE email = '$email' LIMIT 1");
        if ($check->num_rows == 1) $exists = 3;
    }
 
    if ($exists == 1) echo "<p>Username already exists!</p>";
    else if ($exists == 2) echo "<p>Username and Email already exist!</p>";
    else if ($exists == 3) echo "<p>Email already exists!</p>";
    else {
    
        ###################################
        # insert data into mysql database #
        ################################### 
		
		$sql = "INSERT INTO users (id, username, password, first_name, last_name, email) VALUES (NULL, '$username', '$password', '$first_name', '$last_name', '$email')";        // -> operator is used to call class methods (object oriented programming)
		// executing the query containing the SQL string above and providing user feedback
       if($connection->query($sql)){
		   echo "New record added to database!";
	   }else {
		   echo "Ooops - we are not able to process the request...";
	   }
    }
	
}// end if isset
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Registration</title>
</head>

<body>
<!-- The user registration form -->
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
Username: <input type="text" name="username" id="username" required><br>
Password: <input type="password" name="password" id="password" required><br>
First name: <input type="text" name="first_name" id="first_name" required><br>
Last name: <input type="text" name="last_name" id="last_name" required><br>
E-mail: <input type="email" name="email" id="email" required><br>
<input type="submit" name="submit" value="Register">
</form>
</body>
</html>