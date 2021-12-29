<?php
	session_start();
	if(!isset($_SESSION["webuser"]) || !isset($_GET['ISBN'] || !isset($_GET['quantita'] || !isset($_GET['costo'])) {		//controllo sessioni e controllo dati passati siano corretti
		header('Location: Login.php');
		exit();
	}
	else {
		require('../DB_connections/webuser_access.php');									//mi connetto al DB
		$Id_Utente = $_SESSION['webuser'];
		$ISBN = $_GET['ISBN'];
		$Quantita = $_GET['quantita'];
		$Costo = $_GET['costo'];
		 if(!is_numeric($Id_Utente) || !is_numeric($ISBN)){									//controllo che id utente e ISBN siano validi
                        header('Location: ../comuni/error_page.php');
                        exit();
                }
                $nuovoAcquisto = "INSERT INTO carrello (id_utente, ISBN, quantita, costo) VALUES (?, ?, ?, ?)";				//scrivo query per inserire acquisto nel carrello
                $stmt = $con->prepare($nuovoAcquisto);                             							//faccio prepared astatement
                $stmt->bind_param('iiis', $Id_Utente, $ISBN, $Quantita, $Costo);
                if(!$stmt->execute()){													//se ho errori nell'esecuzione vado alla error page
                        header('Location: ../comuni/error_page.php');
                        exit;
                }
                $stmt->close();
		header('Location: Carrello.php');											//torno al carrello
                }
        else
                {
                header('Location: ../comuni/error_page.php');
                }
        
?>