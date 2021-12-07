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
		header('Location: adiminLogin.php');
		exit();
	}
	else{
		$lastactivity=$_SESSION["last_activity"];
		$lastactivity= time() - $lastactivity;
		if($lastactivity > 1800) {
			session_destroy();
			header('Location:login.php');
			exit();
		}
		else {
			$_SESSION["last_activity"]=time();
			require('../comuni/header.php');
			require('../comuni/nav.php'); 
			echo "<div class='container'>";
			 echo "<a href='allUsers.php'>Utenti</a>";
			 echo "<a href='allBooks.php'>Libri</a>";
			 echo "<a href='allTranactions.php'>Transazioni</a>";
			echo "</div>";
			require('../comuni/footer.php');
		}
	}	
?>
</body>
</html>
