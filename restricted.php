<?php
// taking up the session
session_start();
// checking session ID
if ($_SESSION['logged_in'] == true){ 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Area 51</title>
</head>

<body>
<h1>Only for very special people (aliens, bulgarians and the like)</h1>
<a href="logout.php">Logout</a>
</body>
</html>
<?php
// closing if condition from above
}
else {
    header("location:login.php");
}
?>