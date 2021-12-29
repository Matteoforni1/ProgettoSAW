<?php
    session_start(); 
    if(isset($_SESSION['webuser']))				//controllo sessione
        {
        require_once('../../db/webuser_connection.php');	//connetto al DB
        
        $Id_Utente = $_SESSION['webuser'];
        if(!is_numeric($Id_Utente)){				//contollo id utente sia valido
            header('Location: ../comuni/error_page.php');
            exit;
            }
        $Acquisto = "SELECT id_utente						//scrivo query per ottenere dati su carrello riferito all'utente
		     FROM carrello 
		     WHERE id_utente = ?";
        $stmt = $con->prepare($Acquisto);                                     //faccio prepared statement
        $stmt->bind_param('i', $id_Utente);
        if(!$stmt->execute()){							//se ho errore nell'esecuzione vado alla error page
            header('Location: ../comuni/error_page.php');
            exit;
            }
        $res = $stmt->get_result();                                           //prendo risultato query
        $row = $res->fetch_assoc();
	$_SESSION['id_utente'] = $row['id_utente'];				
        echo "../carrello/Ordina_Ora.php";					//link al completamento dell'ordine
        }
    else
        {
        header('Location: ../comuni/error_page.php');    
        }
?> 