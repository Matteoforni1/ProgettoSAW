<?php
	session_start();
	if (!isset($_SESSION['webuser']) || !isset($_GET['ISBN'])) {		//controllo sessione e controllo ISBN libro
		header('Location: Error_Page.php');
		exit();
	}
	else {
		require('../DB_connections/webuser_access.php');		//Connessione al DB
		$ISBN = $_GET['ISBN'];						
		$InfoLibro = "SELECT *						//Scrivo query per ottenere info sul libro
			      FROM libro
			      WHERE ISBN = ?";
		$stmt = $con->prepare($InfoLibro);				//faccio il prepared statement
		$stmt->bind_param($ISBN);
		if(!$stmt->execute()) {						//in caso di errore nell'esecuzione rimanda alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();					//prendo i risultati della query
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		if($rowcount != 1) {						//se ho 0 o più di una riga significa che il libro non esiste o che ci sono più libri con lo stesso ISBN -> ERRORE!
			echo "<span> Errore: Libro non trovato! </span>";
			header('Location: Error_Page.php');
			exit();
		}
		else {
			$Nome = htmlspecialchars($row['nome']);			//metto in variabili con risultato query
			$Autori = htmlspecialchars($row['autori']);
			$Costo = $row['costo'];
			$Data_Pub = htmlspecialchars($row['data_pub']);
			$Voto = $row['voto'];
			$Num_Rec = $row['num_rec'];
			$Url_Img = htmlspecialchars($row['immagine']);
			echo "<div id='mostradati'>";
				echo "<span> Nome Libro: ".$Nome."</span>";	//stampo a video i risultati della query
				echo "<br>";
				echo "<span> Autori: ".$Autori."</span>";
				echo "<br>";
				echo "<span> Costo: ".$Costo."</span>";
				echo "<br>";
				echo "<span> Data di Pubblicazione: ".$Data_Pub."</span>";
				echo "<br>";
				echo "<span> Voto: ".$Voto."</span>";
				echo "<br>";
				echo "<span> Numero di Recensioni: ".$Num_Rec."</span>";
			echo "</div>";
			echo "<div id='bottone_aggiunta'>";									//metto un bottone per aggiungere il libro al carrello
				echo "<form id='aggiungi' name='aggiungi' method='POST' action='AggiungiCarrello.php'>";
					echo "<button type='button'> Aggiungi </button>";
				echo "</form>";
			echo "</div";
		}
		$stmt->close();
	}
?>