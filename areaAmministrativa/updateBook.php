<!DOCTYPE html>
<html>
<head>
    <title>updateBook</title>     
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body>
<?php
		 session_start();
	     if (!isset($_SESSION["admin"])){
			 header('Location: adiminLogin.php');
			 exit();
		 }
		 else {
			require('../comuni/header.php');    
		    require('../comuni/nav.php');       
			if (!isset($_GET['id'])){
				 echo " <div class='container'>";
				  echo " <p> inserisci un nuovo libro </p>";
				  echo "<form id='insertBook' action='supportUpdate.php' method='POST'>";
				  echo "<input type='number' id='ISBN' name='ISBN' placeholder='ISBN' class='form_input'>";
				  echo "</br>";
				  echo "<input type='text' id='nome' name='nome' placeholder='Nome' class='form_input'>";
				  echo "</br>";
				  echo "<input type='text' id='autori' name='autori' placeholder='Autori' class='form_input'>";
				  echo "</br>";
				  echo "<input type='number' id='costo' name='costo' placeholder='Costo' class='form_input'>";
				  echo "</br>";
				  echo "<input type='date' id='data' name='data' placeholder='Data pubblicazione' class='form_input'>";
				  echo "</br>";
				  echo "<input type='submit' id='submit' name='submit' value='Inserisci' class='form_submit'>";
				  echo "</form>";
				 echo "</div>";
			}
			else {
				$ISBN=$_GET['id'];
				echo " <div class='container'>";
				echo " <p> aggiorna il prezzo </p>";
				echo "<form id='updatePrize' action='supportUpdate.php?id=".$ISBN."' method='POST'>";
				echo "<input type='number' id='costo' name='costo' placeholder='Nuovo prezzo' class='form_input'>";
				echo "</br>";
				echo "<input type='submit' id='submit' name='submit' value='Inserisci' class='form_submit'>";
				echo "</form>";
				echo "</div>";
			}
			require('../comuni/nav.php');
		 }
?>
</body>
</html>
