<?php
	session_start();
	if (!isset($_SESSION['webuser']) || !isset($_POST['tag'])) {		//controolo sessione e controllo che la barra di ricerca abbia scritto sopra qualcosa
		header('Location: Error_Page.php');
		exit();
	}
	else {									
		require('../DB_connections/webuser_access.php');		//richiedo connessione al DB
		$Id_Utente = $_SESSION['webuser'];
		$StringaRicerca = $_POST['tag'];
		$Ricerca = "SELECT *						//scrivo la query
			    FROM libro
			    WHERE CHARINDEX('?', nome) > 0			//guardo che la stringa sia contenuta in un nome o in un autore di un libro
  			    AND CHARINDEX('?', autori) > 0";
		$stmt = $con->prepare($Ricerca);				//faccio prepared statement
		$stmt->bind_param('ss', $StringaRicerca, $StringaRicerca);
		if(!$stmt->execute()) {						//se c'è un errore nell'esecuzione rimanda alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();					//prendo risultati query
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		$i = 0;
		while($i < $rowcount) {						//finchè ho righe (libri trovati dalla query) li stampo a video con relative info
			$Nome = htmlspecialchars($row['nome']);
			$Autori = htmlspecialchars($row['autori']);
			$Prezzo = $row['prezzo'];
			$ISBN = $row['ISBN'];
			echo "<div id='mostralibri'>";
				echo "<div id='mostralibri2'>";
					echo "<div id='titolo'>'.$Nome.'</div>";
					echo "<br>";
					echo "<div id='autori'>'.$Autori.'</div>";
					echo "<br>";
					echo "<div id='prezzo'>'.$Prezzo.' €</div>";
					echo "<br>";
					echo "<div>";
						echo "<a href='PaginaLibri.php?ISBN='.$ISBN."'>Visualizza Informazioni</a>";			//metto un link alla pagina del libro, da cui poi si può aggiungere al carrello
					echo "</div>";
				echo "</div>";
			echo "</div>";
			$i++;
			$row = $res->fetch_assoc();
		}
		$stmt->close();
	}
?>