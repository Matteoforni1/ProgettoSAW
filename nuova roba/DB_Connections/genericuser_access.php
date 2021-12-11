<html>
<body>
<?php
function genericuser_access() {
	$con = mysqli_connect('localhost','genericUser','genericUserpassword','Saw_db');
	if (mysqli_connect_errno()) {
		echo"Failed to connect to MYSQL database:".mysqli_connect_error;
		exit;
	}
	return $con;
}
?>
</body>
</html>