<!DOCTYPE html>
<html>
<head>
    <title>allBooks</title>     
	<link href="stileSawpr.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
	if (!isset($_SESSION["adminid"])){
		header('Location:login.php');
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
			require('DB_connections/webadmin_access.php');	
			$conn=webadmin_access();
			$query="SELECT ISBN, nome, autori, costo FROM libro";
			$result=mysqli_query($conn,$query);
			echo "<div class='tabella'>";
			echo" <div class='add'><a href='insert2Book.php'>aggiungi un libro...</a></div>";
			echo "<div class='riga' id='titolo'>";
			echo "<div class='cella'>ISBN</div>";
			echo "<div class='cella'>Nome</div>";
			echo "<div class='cella'>Autori</div>";
			echo "<div class='cella'>Costo</div>";
			echo "<div class='cella'>modifica</div></div>";
			while($row = mysqli_fetch_array($result)) {
			 	$ISBN =trim($row['ISBN']);
				$nome = trim($row['nome']);
				$autori = trim($row['autori']);
				$costo = $row['costo'];
				echo "<div class='riga'>";
				echo "<div class='cella'>" .$ISBN. "</div><div class='cella'>" .$nome. "</div><div class='cella'>" .$autori. "</div><div class='cella'>" .$costo. "</div>";
				if ((isset($_GET['id']))&&($_GET['id']==$ISBN)) {
					echo "<div class='cella'>";
					echo "<form id='updatePrize' action='support2Update.php?id=".$ISBN."' method='POST'>";
					echo "<input type='number' id='costo' name='costo' placeholder='Nuovo prezzo' class='form_input'>";
					echo "</br>";
					echo "<input type='submit' id='submit' name='submit' value='aggiorna' class='form_submit'>";
					echo "</form>";
					echo "</div></div>";
				}
					
				else {
					echo "<div class='cella'><a href='all1Books.php?id=".$ISBN."'>aggiorna</a></div></div>";
				}
			}
			echo "</div>";
			mysqli_close($conn);
			require('comuni/footer.php');
		}
	}
	
?>
</body>
</html>
