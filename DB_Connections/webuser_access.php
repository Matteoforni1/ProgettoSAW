<html>
<body>
<?php
function webuser_access() {
	$con = mysqli_connect('localhost','webuser','webuserpassword','Saw_db');
	if (mysqli_connect_errno()) {
		echo"Failed to connect to MYSQL database:".mysqli_connect_error;
		exit;
	}
	return $con;
}
?>
</body>
</html>