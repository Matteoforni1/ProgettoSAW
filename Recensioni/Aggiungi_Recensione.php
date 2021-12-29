<?php
	session_start();
	if(!isset($_SESSION['webuser']) || !isset($_GET['ISBN'])) {		//controllo sessione e controllo dati libro siano passati
		header('Location: Error_Page.php');
		exit();
	}
	require('../DB_connections/webuser_access.php');			//connetto al DB
	$ISBN = $_GET['ISBN']
	echo "<form action='"../Inserisci_Recensione.php?ISBN='.$ISBN.'"' method="POST" id='agg_rec' nome='agg_rec'>";		//faccio un form in cui posso inserire un range da 1 a 5, che sarà il voto dato al libro
		echo "<input type="range" id='rec' name='rec' min="1" max="5">";						//il voto sarà passato poi allo script Inserisci_Recensione.php
		echo "<input type="submit" id='invio_rec' name='invio_rec' value='invia'>";					
	echo "</form>";
?>
