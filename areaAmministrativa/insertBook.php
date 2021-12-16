<!DOCTYPE html>
<html>
<head>
    <title>insertBook</title>     
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
			echo "<div class='container'>";
			 echo "<p> Nuovo libro: </p>";
			 echo "<form id='insertBook' action='supportUpdate.php' method='POST'>";
			 echo "<input type='text' id='ISBN' name='ISBN' placeholder='ISBN' class='form_input'>";
			 echo "</br>";
			 echo "<input type='text' id='nome' name='nome' placeholder='Nome' class='form_input'>";
			 echo "</br>";
			 echo "<input type='text' id='autori' name='autori' placeholder='Autori' class='form_input'>";
			 echo "</br>";
			 echo "<input type='number' id='costo' name='costo' placeholder='Costo' class='form_input'>";
			 echo "</br>";
			 echo "<input type='date' id='data' name='data' placeholder='Data pubblicazione' class='form_input'>";
			 echo "</br>";
			 echo "<select name='genere' class='form_input'>";
			 echo "<option value='1'>Suspanse</option>";
			 echo "<option value='2'>Fantasy</option>";
			 echo "<option value='3'>Narrativa</option>";
			 echo "<option value='4'>Filosofia</option>";
			 echo "<option value='5'>Storia</option>";
			 echo "<option value='6'>Biografia</option>";
			 echo "<option value='7'>Bambini</option>";
			 echo "<option value='8'>Horror</option>";
			 echo "<option value='9'>Fantascienza</option>";
			 echo "<option value='10'>Giallo</option>";
			 echo "<option value='11'>Scienze</option>";
			 echo "<option value='12'>Azione/Avventura</option>";
			 echo "<option value='13'>Romantico</option>";
			 echo "<option value='14'>Cucina</option>";
			 echo "<option value='15'>Comico</option>";
			 echo "<option value='16'>Formazione</option>";
			 echo "<option value='17'>Sport</option>";
			 echo "<option value='18'>Religione</option>";
			 echo "<option value='19'>Arte</option>";
			 echo "</select>";
			 echo "</br>";
			 echo "<input type='text' id='immagine' name='immagine' placeholder='imagesrc' class='form_input'>";
			 echo "<input type='submit' id='submit' name='submit' value='Inserisci' class='form_submit'>";
			 echo "</form>";
			echo "</div>";
			require('comuni/footer.php');
		}
	}
?>
</body>
</html>