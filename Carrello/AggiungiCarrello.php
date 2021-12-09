<?php
	session_start();
	if(!isset($_SESSION["webuser"]) || !isset($_GET['ISBN'] || !isset($_GET['quantita'] || !isset($_GET['costo'])) {
		header('Location: Login.php');
		exit();
	}
	else {
		require('../DB_connections/webuser_access.php');
		$Id_Utente = $_SESSION['webuser'];
		$ISBN = $_GET['ISBN'];
		$Quantita = $_GET['quantita'];
		$Costo = $_GET['costo'];
		 if(!is_numeric($Id_Utente) || !is_numeric($ISBN)){
                        header('Location: ../comuni/error_page.php');
                        exit();
                }
                $nuovoAcquisto = "INSERT INTO carrello (id_utente, ISBN, quantita, costo) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($nuovoAcquisto);                              //Invio della query
                $stmt->bind_param('iiis', $Id_Utente, $ISBN, $Quantita, $Costo);
                if(!$stmt->execute()){
                        header('Location: ../comuni/error_page.php');
                        exit;
                }
                $stmt->close();
		header('Location: Carrello.php');
                }
        else
                {
                header('Location: ../comuni/error_page.php');
                }
        
?>