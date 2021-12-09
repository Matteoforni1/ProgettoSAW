<?php

        session_start();
        if(isset($_SESSION['webuser']) && isset($_GET['id_acquisto']))
            { 
            require('../DB_connections/webuser_access.php');
            
            $Id_Acquisto = $_GET['id_acquisto'];
            $Id_utente = $_SESSION['webuser'];

            if(!is_numeric($Id_Acquisto) || !is_numeric($Id_utente)){
                header('Location: ../comuni/error_page.php');
                exit;
            }
            
	    $ChechCarrello = "SELECT * FROM carrello";
	    $stmt = $con->prepare($CheckCarrello);
	    $stmt->bind_param($Id_Utente);
	    if(!$stmt->execute()) {
		header('Location: Error_Page.php);
		exit;
	    }
	    $res = $stmt->get_result();
	    $rowcount = $res->num_rows;
	    if($rowcount > 0) {
		$stmt->close();
		$CancellaCarrello = "DELETE FROM carrello WHERE id_utente = ?";
		$stmt = $con->prepare($CancellaCarrello);
		$stmt->bind_param($Id_Utente);
		if(!$stmt->execute()) {
			header('Location: Error_Page.php);
			exit;
		}
		$stmt->close();
	    }
            $GetIdAcquisto = "SELECT id_acquisto FROM acquisto WHERE id_utente = ?";
	    $stmt = $con->prepare($GetIdAcquisto);
	    $stmt->bind_param('i', $Id_Utente);
	    if(!$stmt->execute()) {
		header('Location: Error_Page.php);
		exit;
            }
	    $res = $stmt->get_result();
	    $row = $res->fetch_assoc();
	    $Id_Acquisto = $row['id_acuisto'];
	    $stmt->close();
	    $GetAcquisti = "SELECT * FORM (acquisto INNER JOIN) acquisto_libro WHERE ((acquisto.id_acquisto == acquisto_libro.id_acquisto_libro) AND id_acquisto = ?";
	    $stmt = $con->prepare($GetAcquisti);
	    $stmt->bind_param($Id_Acquisto);
	    if(!$stmt->execute()) {
		header('Location: Error_Page.php);
		exit;
            }
	    $res = $stmt->get_result();
	    $row = $res->fetch_assoc();
	    $rowcount = $res->num_rows;
	    $i = 0;
	    while($i < $rowcount) {
		$ISBN = $row['ISBN'];
		$quantita = $row['quantita'];
		$costo = $row['costo'];
		$InserisciCarrello = "INSERT INTO carrello (id_utente, ISBN, quantita, costo) VALUES (?, ?, ?, ?)";
		$stmt = $con->prepare($InserisciCarrello);
		$stmt->bind_param($Id_Utente, $ISBN, $Quantita, $Costo);
		if(!$stmt->execute()) {
			header('Location: Error_Page.php);
			exit;
           	}
		$i++;
		$row = $res->fetch_assoc();
	    }
            header('Location: Carrello.php');
            }
        else
            {
            header('Location: ../comuni/error_page.php');
            }
?>