<?php
        session_start();
        if(isset($_SESSION['webuser']) && isset($_GET['ISBN'])) {			//controllo sessione più controllo ISBN libro sia passato
		require('../DB_connections/webuser_access.php');			//connetto al DB
		$Id_Utente = $_SESSION['webuser'];
            	$ISBN = $_GET['ISBN'];
            	if(!is_numeric($Id_Utente) || !is_numeric($ISBN)){			//controllo validità id utente e ISBN
            	    header('Location: ../comuni/error_page.php');
            	    exit;
            	}
        	 $EliminaAcquistoLibro = "DELETE FROM carrello WHERE  = (id_utente, ISBN) VALUES (?, ?)";				//scrivo query per eliminazione libro da carrello
           	 $stmt = $con->prepare($EliminaAcquistoLibro);                                			//faccio prepared statement
           	 $stmt->bind_param('ii', $Id_Utente, $ISBN);
           	 if(!$stmt->execute()){										//se ho errori nell'esecuzione vado alla error page
           	     header('Location: ../comuni/error_page.php');
           	     exit;
           	 }
           	 $stmt->close();
            }
        else
            {
            header('Location: ../comuni/error_page.php');    
            }
?>