<!DOCTYPE html>
<html>
<head>
    <title>allUsers</title>             
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
			if (isset($_SESSION["errore"])){
				echo('<script type="text/javascript"> alert("'.$_SESSION["errore"].'")</script>');
				unset($_SESSION["errore"]);
			}
			require('../DB_connections/db_admin_access.php');
			$conn=superadmin_access();
			$query="SELECT id, nome, cognome, email, ban FROM utente";
			$result=mysqli_query($conn,$query);
			echo "<table><tr><th>NOME</th><th>COGNOME</th><th>EMAIL</th><th>BAN</th></tr>";
			while($row = mysqli_fetch_array($result)) {
				$id= $row['id'];
				$nome = trim($row['nome']);
				$cognome = trim($row['cognome']);
				$email = trim($row['email']);
				$ban = $row['ban'];
				$email=strtolower($email);
				echo "<tr><td>" .$nome. "</td><td>" .$cognome. "</td><td>" .$email. "</td>";
				if (!$ban) {
					echo "<td><a href='ban.php?id=".$id."'>Ban</a></td>";
				}
				else {
					echo " <td> Utente bannato </td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			mysqli_close($conn);
			require('../comuni/footer.php');
		}
	}
?>
</body>
</html>
