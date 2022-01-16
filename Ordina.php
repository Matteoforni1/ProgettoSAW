<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="stileSaw.css">
</head>
<body>
<?php
	session_start();
	if(isset($_SESSION['id'])) {
        if (isset($_GET['totale'])) {
        require_once('DB_connections/webuser_access.php');	//connetto al DB
        
        $Id_Utente = $_SESSION['id'];
		$Totale = $_GET['totale'];
		if(!is_numeric($Id_Utente)){				//contollo id utente sia valido
			$_SESSION['errore'] = 'Errore! Utente non identificato, si prega di rieffettuare il login!';
            header('Location: Error_Page.php');
            exit;
            }
		$con = webuser_access();
        $Acquisto = "SELECT id_utente FROM carrello WHERE id_utente = ?";		//scrivo query per ottenere dati su carrello riferito all'utente
        $stmt = $con->prepare($Acquisto);                                     //faccio prepared statement
        $stmt->bind_param('i', $Id_Utente);
        if(!$stmt->execute()){							//se ho errore nell'esecuzione vado alla error page
            header('Location: Error_Page.php');
            exit;
            }
        $res = $stmt->get_result();                                           //prendo risultato query
        $row = $res->fetch_assoc();
		$Id_Utente = $row['id_utente'];
        echo "<form id='ordinaora' name='ordinaora' method='POST' action='Ordina_Ora.php?id_utente=".$Id_Utente."&totale=".$Totale."'>";
			echo "<button type='submit'> Ordina Ora!  </button>";
		echo "</form>";			//link al completamento dell'ordine
		$GetRecap = "SELECT * FROM carrello WHERE id_utente = ?";
		$stmt = $con->prepare($GetRecap);
		$stmt->bind_param('i', $Id_Utente);
		if(!$stmt->execute()){							//se ho errore nell'esecuzione vado alla error page
            header('Location: Error_Page.php');
            exit;
        }
		$res = $stmt->get_result();                                           //prendo risultato query
        $row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		$i = 0;
		while($i < $rowcount) {
			$ISBN = $row['ISBN'];
			$GetLibro = "SELECT * FROM libro WHERE ISBN = ?";
			$stmt2 = $con->prepare($GetLibro);
			$stmt2->bind_param('s',$ISBN);
			if(!$stmt2->execute()){							//se ho errore nell'esecuzione vado alla error page
				header('Location: Error_Page.php');
				exit;
			}
			$res2 = $stmt2->get_result();
			$row2 = $res2->fetch_assoc();
			$Nome = $row2['nome'];
			$Autori = $row2['autori'];
			$Quantita = $row['quantita'];
			$Costo = $row['costo'];
			$Img = $row2['immagine'];
			echo "<div id='mostrarecap'>";
				echo "<div> Nome: ".$Nome." </div>";
				echo "<br>";
				echo "<div> Autore: ".$Autori." </div>";
				echo "<br>";
				echo "<div> Quantita: ".$Quantita." </div>";
				echo "<br>";
				echo "<div> Costo Totale: ".$Costo." </div>";
				echo "<br>";
				echo "<img src='".$Img."'>";
			echo "</div>";
			$i++;
			$row = $res->fetch_assoc();
		}
        }
		else {
			header('Location: Error_Page.php');
		}
	}
	else {
		header('Location: Login/login.php');
	}
?>
</body>
</html>