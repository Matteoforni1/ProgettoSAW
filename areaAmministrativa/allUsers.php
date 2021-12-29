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
			if (isset($_SESSION["errore"])){
				echo('<script type="text/javascript"> alert("'.$_SESSION["errore"].'")</script>');
				unset($_SESSION["errore"]);
			}
			require('DB_connections/webadmin_access.php');	
			$conn=webadmin_access();
			$query="SELECT id, nome, cognome, email, ban FROM utente";
			$result=mysqli_query($conn,$query);
			echo "<div class='tabella'>";
			echo "<div class='riga' id='titolo'>";
			echo "<div class='cella'>Nome</div>";
			echo "<div class='cella'>Cognome</div>";
			echo "<div class='cella'>Email</div>";
			echo "<div class='cella'>Ban</div></div>";
			while($row = mysqli_fetch_array($result)) {
				$id= $row['id'];
				$nome = trim($row['nome']);
				$cognome = trim($row['cognome']);
				$email = trim($row['email']);
				$ban = $row['ban'];
				$email=strtolower($email);
				echo "<div class='riga'>";
				echo "<div class='cella'>" .$nome. "</div><div class='cella'>" .$cognome. "</div><div class='cella'>" .$email. "</div>";
				if (!$ban) {
					echo "<div class='cella'><a href='ban.php?id=".$id."'>Ban</a></div>";
				}
				else {
					echo " <div class='cella'> Utente bannato </div>";
				}
				echo "</div>";
			}
			echo "</div>";
			mysqli_close($conn);
			require('comuni/footer.php');
		}
	}
?>
</body>
</html>
