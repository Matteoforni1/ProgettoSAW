<!DOCTYPE html>
<html>
<head>
    <title>areaAmministrativa</title>             
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body>
<?php
	session_start();
	if (!isset($_SESSION["adminid"])){
		header('Location: login.php');
		exit();
	}
	else{
		$lastactivity=$_SESSION["last_activity"];
		$lastactivity= time() - $lastactivity;
		if($lastactivity > 1800) {
			session_unset();
			session_destroy();
			header('Location:login.php');
			exit();
		}
		else {
			$_SESSION["last_activity"]=time();
			require('comuni/header.php');
			require('comuni/nav.php'); 
			echo "<div class='admincontainer'>";
			 echo "<div class='adminref'><a href='allUsers.php'><ul><li>Utenti</ul></li></a></div>";
			 echo "<div class='adminref'><a href='allBooks.php'><ul><li>Libri</ul></li></a></div>";
			echo "</div>";
			require('comuni/footer.php');
		}
	}	
?>
</body>
</html>
