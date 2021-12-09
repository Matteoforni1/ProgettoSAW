<?php
    session_start(); 
    if(isset($_SESSION['webuser']))
        {
        require_once('../../db/webuser_connection.php');
        
        $Id_Utente = $_SESSION['webuser'];
        if(!is_numeric($Id_Utente)){
            header('Location: ../comuni/error_page.php');
            exit;
            }
        $Acquisto = "SELECT id_utente
		     FROM carrello 
		     WHERE id_utente = ?";
        $stmt = $con->prepare($Acquisto);                                     //Invio della query
        $stmt->bind_param('i', $id_Utente);
        if(!$stmt->execute()){
            header('Location: ../comuni/error_page.php');
            exit;
            }
        $res = $stmt->get_result();                                           //Risultato della query
        $row = $res->fetch_assoc();
	$_SESSION['id_utente'] = $row['id_utente'];
        echo "../carrello/CompletaOrdine.php";
        }
    else
        {
        header('Location: ../comuni/error_page.php');    
        }
?> 