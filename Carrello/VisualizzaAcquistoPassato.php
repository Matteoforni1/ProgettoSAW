<?php
	session_start();
	if (!isset($_SESSION['id']) || !isset($_GET['id_acquisto'])) {			//controllo sessione e id acquisto
		header('Location: Error_Page.php');
		exit();
	}
	else {
		require('../DB_connections/webuser_access.php');			//connetto al DB
		$Id_Acquisto = $_GET['id_acquisto'];
		$OttieniDatiAcquisto = "SELECT * FROM acquisto_libro WHERE id_acquisto_libro = ?";			//query per ottenere dati acquisto
		$stmt = $con->get_result();										//faccio prepared statement
		$stmt->bind_param('i', $Id_Acquisto);
		if (!$stmt->execute()) {										//se ho errore nell'esecuzione vado alla error page
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();										//prendo risultati query
		$row = $res->fetch_assoc();
		$rowcount = $stmt->num_rows;
		$i = 0;
		while ($i < $rowcount) {										//finchè ho libri acquistati, stampo i loro dati a schermo
			$ISBN = $row['ISBN'];
			$Quantita = $row['quantita'];
			$Costo = $row['costo'];
			echo "<div>";
				echo "<div> ISBN: ".$ISBN."</div>";
				echo "<br>";
				echo "<div> Quantita: ".$Quantita."</div>";
				echo "<br>";
				echo "<div> Costo: ".$Costo."</div>";
			echo "</div>";
			$row = $res->fetch_assoc();
			$i++;
		}
		$stmt->close();
	}
?>