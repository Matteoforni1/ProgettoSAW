<?php
	session_start();
	if(!isset($_SESSION['webuser']) || !isset($_GET['ISBN']) || !isset($_POST['rec'])) {
		header('Location: Error_Page.php);
		exit();
	}
	require('../DB_connections/webuser_access.php');
	$Id_Utente = $_SESSION['webuser'];
	$ISBN = $_GET['ISBN'];
	$Voto = $_POST['rec'];
	$Data = date("Y-m-d");
	$Inserisci = "INSERT INTO recensione (id, id_utente, ISBN, voto, data) VALUES (?, ?, ?, ?, ?)";
	$stmt = $con->prepare($Inserisci);
	$stmt->bind_param('iiiis', $Id, $Id_Utente, $ISBN, $Voto, $Data);
	if(!$stmt->execute()) {
		header('Location: Error_Page.php');
		exit();
	}
	$OttieniVecchiDati = "SELECT voto, num_rec FROM libro WHERE ISBN = ?";
	$stmt = $con->prepare($Inserisci);
	$stmt->bind_param('i', $ISBN);
	if(!$stmt->execute()) {
		header('Location: Error_Page.php');
		exit();
	}
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	$rowcount = $res->num_rows;
	if($rowcount != 1) {
		echo "<span> ERRORE! </span>";
		header('Location: Error_Page.php');
		exit();
	}
	$VecchioVoto = $row['voto'];
	$VecchioNum = $row['num_rec'];
	$NuovoNum = $VecchioNum++;
	$NuovoVoto = (($VecchioVoto * $VecchioNum) + $NuovoVoto) / $NuovoNum;
	$Aggiorna = UPDATE libro SET (voto = ?, num_rec = ?) WHERE ISBN = ?";
	$stmt = $con->prepare($Aggiorna);
	$stmt->bind_param('dii', $NuovoVoto, $NuovoNum, $ISBN);
	if(!$stmt->execute()) {
		header('Location: Error_Page.php');
		exit();
	}
	stmt->close();
?>