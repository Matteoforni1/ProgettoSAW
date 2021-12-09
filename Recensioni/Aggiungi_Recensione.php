<?php
	session_start();
	if(!isset($_SESSION['webuser']) || !isset($_GET['ISBN'])) {
		header('Location: Error_Page.php');
		exit();
	}
	require('../DB_connections/webuser_access.php');
	$ISBN = $_GET['ISBN'];
	echo "<form action='"../Inserisci_Recensione.php?ISBN='.$ISBN.'"' method="POST" id='agg_rec' nome='agg_rec'>";
		echo "<input type="range" id='rec' name='rec' min="1" max="5">";
		echo "<input type="submit" id='invio_rec' name='invio_rec' value='invia'>";
	echo "</form>";
?>
