<?php
	session_start();
	if(!isset($_SESSION['webuser']) || !isset($_GET['id_utente']) || !isset($_GET['quantita']) || !isset($_POST['nuovaquantita']) || !isset($_GET['ISBN']) || $_SESSION['webuser'] != $_GET['id_utente']) {
		header('Location: Error_Page.php');
		exit();
	}
	else {
		require(../DB_connections/webuseraccess.php);
		$Id_Utente = $_GET['id_utente'];
		$ISBN = $_GET['ISBN'];
		$Quantita = $_GET['quantita'];
		$NuovaQuantita = $_POST['nuovaquantita'];
		$Totale = $_GET['totale'];
		$Costo = $Totale / $Quantita;
		$Totale = $Costo * $NuovaQuantita;
		$AggiornaQuantita = "UPDATE carrello
				    SET (quantita, costo) VALUES (?, ?)
				    WHERE (id_utente, ISBN) VALUES (?, ?);"
		$stmt = $con->prepare($AggiornaQuantita);
		$stmt->bind_param('iiii', $NuovaQuantita, $Totale, $Id_Utente, $ISBN);
		if(!$stmt->execute()){
                        header('Location: ../comuni/error_page.php');
                        exit;
                }
		$stmt->close();
	}
?>
