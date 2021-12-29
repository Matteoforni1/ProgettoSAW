<?php

        session_start();
        if(isset($_SESSION['webuser']) && isset($_GET['id_acquisto']))		//controllo sessione e passaggio dati su acquisto che si vuole ricopiare
            { 
            require('../DB_connections/webuser_access.php');			//connetto al DB
            
            $Id_Acquisto = $_GET['id_acquisto'];
            $Id_utente = $_SESSION['webuser'];

            if(!is_numeric($Id_Acquisto) || !is_numeric($Id_utente)){		//controllo validità id acquisto e id utente
                header('Location: ../comuni/error_page.php');
                exit;
            }
            
	    $CheckCarrello = "SELECT * FROM carrello WHERE id_utente = ?";				//query per controllo carrello sia vuoto per crearne uno nuovo uguale all'ordine già fatto
	    $stmt = $con->prepare($CheckCarrello);							//faccio prepared statement
	    $stmt->bind_param($Id_Utente);
	    if(!$stmt->execute()) {
		header('Location: Error_Page.php);							//se ho errore nell'esecuziomne vado alla error page
		exit;
	    }
	    $res = $stmt->get_result();							
	    $rowcount = $res->num_rows;
	    if($rowcount > 0) {										//se il carrello esiste già, lo cancello
		$stmt->close();
		$CancellaCarrello = "DELETE FROM carrello WHERE id_utente = ?";				//query per cancellare il carrello
		$stmt = $con->prepare($CancellaCarrello);						//faccio prepared statement
		$stmt->bind_param($Id_Utente);
		if(!$stmt->execute()) {									//se ho errore nell'esecuzione, vado alla error page
			header('Location: Error_Page.php);
			exit;
		}
		$stmt->close();
	    }
            $GetIdAcquisto = "SELECT id_acquisto FROM acquisto WHERE id_utente = ?";			//query per ottenere dati vecchio acquisto
	    $stmt = $con->prepare($GetIdAcquisto);							//faccio prepared statement
	    $stmt->bind_param('i', $Id_Utente);
	    if(!$stmt->execute()) {									//se ho errore nell'esecuzione vado alla error page
		header('Location: Error_Page.php);
		exit;
            }	
	    $res = $stmt->get_result();									//prendo risultati
	    $row = $res->fetch_assoc();
	    $Id_Acquisto = $row['id_acuisto'];
	    $stmt->close();
	    $GetAcquisti = "SELECT * FORM (acquisto INNER JOIN) acquisto_libro WHERE ((acquisto.id_acquisto == acquisto_libro.id_acquisto_libro) AND id_acquisto = ?";		//query per ottenere tutti i libri acquistati
	    $stmt = $con->prepare($GetAcquisti);			//faccio prepared statement
	    $stmt->bind_param($Id_Acquisto);
	    if(!$stmt->execute()) {					//se ho errore nell'esecuzione vado alla error page
		header('Location: Error_Page.php);
		exit;
            }
	    $res = $stmt->get_result();
	    $row = $res->fetch_assoc();					// prendo risultati query
	    $rowcount = $res->num_rows;
	    $i = 0;
	    while($i < $rowcount) {					//finchè ho libri nel vecchio acquisto, recupero dati da inserire nel carrello
		$ISBN = $row['ISBN'];
		$quantita = $row['quantita'];
		$costo = $row['costo'];
		$InserisciCarrello = "INSERT INTO carrello (id_utente, ISBN, quantita, costo) VALUES (?, ?, ?, ?)";			// query per inserire dati libro nel carrello
		$stmt = $con->prepare($InserisciCarrello);										//faccio prepared statement
		$stmt->bind_param($Id_Utente, $ISBN, $Quantita, $Costo);
		if(!$stmt->execute()) {													//se ho errore nell'esecuzione vado alla error page
			header('Location: Error_Page.php);
			exit;
           	}
		$i++;
		$row = $res->fetch_assoc();
	    }
            header('Location: Carrello.php');												//vado a carrello
            }
        else
            {
            header('Location: ../comuni/error_page.php');
            }
?>