<?php
	session_start();
	if(!isset($_SESSION['webuser']) || !isset($_GET['ISBN']) || !isset($_POST['rec'])) {		//controllo sessione e controllo dati siano passati correttamente
		header('Location: Error_Page.php);
		exit();
	}
	require('../DB_connections/webuser_access.php');						//connetto al DB
	$Id_Utente = $_SESSION['webuser'];
	$ISBN = $_GET['ISBN'];
	$Voto = $_POST['rec'];
	$Data = date("Y-m-d");
	$ControllaEsistenza = "SELECT id FROM recensione WHERE id_utente = ?";
	$stmt = $con->prepare($ControllaEsistenza);
	$stmt->bind_param($Id_Utente);
	if(!$stmt->execute()) {												//se ho errori vado alla error page
		header('Location: Error_Page.php');
		exit();
	}
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	$rowcount = $res->num_rows;
	if(rowcount == 0) {
		$Inserisci = "INSERT INTO recensione (id, id_utente, ISBN, voto, data) VALUES (?, ?, ?, ?, ?)";			//scrivo la query per inserire la recensione nel DB
		$stmt = $con->prepare($Inserisci);										//faccio prepared statement
		$stmt->bind_param('iiiis', $Id, $Id_Utente, $ISBN, $Voto, $Data);
		if(!$stmt->execute()) {												//se ho errori vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$OttieniVecchiDati = "SELECT voto, num_rec FROM libro WHERE ISBN = ?";						//scrivo la query per ottenere il vecchio voto del libro, che sarà cambiato
		$stmt = $con->prepare($Inserisci);										//faccio il prepared statement
		$stmt->bind_param('i', $ISBN);
		if(!$stmt->execute()) {												//se ho errori vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();											//prendo risultati query
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		if($rowcount != 1) {												//se non ho una sola riga ho 0 o più di un libro con quell'ISBN ->ERRORE
			echo "<span> ERRORE! </span>";
			header('Location: Error_Page.php');
			exit();
		}
		$VecchioVoto = $row['voto'];
		$VecchioNum = $row['num_rec'];
		$NuovoNum = $VecchioNum++;
		$NuovoVoto = (($VecchioVoto * $VecchioNum) + $NuovoVoto) / $NuovoNum;						//Calcolo nuova media
		$Aggiorna = UPDATE libro SET (voto = ?, num_rec = ?) WHERE ISBN = ?";						//scrivo query per cambiare il voto vecchio con quello nuovo
		$stmt = $con->prepare($Aggiorna);										//faccio prepared statement
		$stmt->bind_param('dii', $NuovoVoto, $NuovoNum, $ISBN);
		if(!$stmt->execute()) {												//se ho errori nell'esecuzione vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		stmt->close();
	}
	else {
		$VecchioVotoRec = $row['voto'];
		$Id = $row['id'];
		$Aggiorna = UPDATE recensione SET (voto = ?, data = ?) WHERE id = ?";
		$stmt = $con->prepare($Aggiorna);
		$stmt->bind_param('isi', $Voto, $Data, $Id);
		if(!$stmt->execute()) {												//se ho errori nell'esecuzione vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();											//prendo risultati query;
		$rowcount = $res->num_rows;
		if($rowcount != 1) {												//se non ho una sola riga ho 0 o più di un libro con quell'ISBN ->ERRORE
			echo "<span> ERRORE! </span>";
			header('Location: Error_Page.php');
			exit();
		}
		$OttieniVecchiDati = "SELECT voto, num_rec FROM libro WHERE ISBN = ?";							//scrivo la query per ottenere il vecchio voto del libro, che sarà cambiato
		$stmt = $con->prepare($Inserisci);										//faccio il prepared statement
		$stmt->bind_param('i', $ISBN);
		if(!$stmt->execute()) {												//se ho errori vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();											//prendo risultati query
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		if($rowcount != 1) {												//se non ho una sola riga ho 0 o più di un libro con quell'ISBN ->ERRORE
			echo "<span> ERRORE! </span>";
			header('Location: Error_Page.php');
			exit();
		}
		$NumRec = $row['num_rec'];
		$VecchioVoto = $row['voto'];
		$NuovoVoto = (($VecchioVoto * $NumRec) + $Voto - $VecchioVotoRec) / $NumRec;						//Calcolo nuova media
		$Aggiorna = UPDATE libro SET (voto = ?) WHERE ISBN = ?";						//scrivo query per cambiare il voto vecchio con quello nuovo
		$stmt = $con->prepare($Aggiorna);										//faccio prepared statement
		$stmt->bind_param('di', $NuovoVoto, $ISBN);
		if(!$stmt->execute()) {												//se ho errori nell'esecuzione vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		stmt->close();
	}
?>