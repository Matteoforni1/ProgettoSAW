<?php
	session_start();
	if(!isset($_SESSION['webuser']) || !isset($_GET['id_utente']) || !isset($_GET['quantita']) || !isset($_POST['nuovaquantita']) || !isset($_GET['ISBN']) || $_SESSION['webuser'] != $_GET['id_utente']) {
		header('Location: Error_Page.php');   			
		exit();							//controllo sessione più controllo dati siano passati correttamente
	}
	else {
		require(../DB_connections/webuseraccess.php);		//connetto al DB
		$Id_Utente = $_GET['id_utente'];
		$ISBN = $_GET['ISBN'];
		$Quantita = $_GET['quantita'];
		$NuovaQuantita = $_POST['nuovaquantita'];
		$Totale = $_GET['totale'];
		$Costo = $Totale / $Quantita;				//aggiorno costo
		$Totale = $Costo * $NuovaQuantita;			//aggiorno totale
		$AggiornaQuantita = "UPDATE carrello			//query per aggiornare dati su tabella carrello
				    SET (quantita, costo) VALUES (?, ?)
				    WHERE (id_utente, ISBN) VALUES (?, ?);"
		$stmt = $con->prepare($AggiornaQuantita);					//faccio prepared statement
		$stmt->bind_param('iiii', $NuovaQuantita, $Totale, $Id_Utente, $ISBN);
		if(!$stmt->execute()){								//se ho errore nell'esecuzione vado alla erro page
                        header('Location: ../comuni/error_page.php');
                        exit;
                }
		$stmt->close();
	}
?>
