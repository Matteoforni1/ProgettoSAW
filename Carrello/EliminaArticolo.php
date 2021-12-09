<?php
        session_start();
        if(isset($_SESSION['webuser']) && isset($_GET['ISBN'])) {
		require('../DB_connections/webuser_access.php');
		$Id_Utente = $_SESSION['webuser'];
            	$ISBN = $_GET['ISBN'];
            	if(!is_numeric($Id_Utente) || !is_numeric($ISBN)){
            	    header('Location: ../comuni/error_page.php');
            	    exit;
            	}
        	 $EliminaAcquistoLibro = "DELETE FROM carrello WHERE  = (id_utente, ISBN) VALUES (?, ?)";
           	 $stmt = $con->prepare($EliminaAcquistoLibro);                                 //Invio della query
           	 $stmt->bind_param('ii', $Id_Utente, $ISBN);
           	 if(!$stmt->execute()){
           	     header('Location: ../comuni/error_page.php');
           	     exit;
           	 }
           	 $res = $stmt->get_result();                                          //Risultato della query
           	 $row = $res->fetch_assoc();
           	 $stmt->close();
            }
        else
            {
            header('Location: ../comuni/error_page.php');    
            }
?>