<?php
	session_start();
	if (!isset($_SESSION['webuser']) || !isset($_GET['ISBN'])) {
		header('Location: Error_Page.php');
		exit();
	}
	else {
		require('../DB_connections/webuser_access.php');
		$ISBN = $_GET['ISBN'];
		$InfoLibro = "SELECT *
			      FROM libro
			      WHERE ISBN = ?";
		$stmt = $con->prepare($InfoLibro);
		$stmt->bind_param($ISBN);
		if(!$stmt->execute()) {
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		if($rowcount != 1) {
			echo "<span> Errore: Libro non trovato! </span>";
			header('Location: Error_Page.php');
			exit();
		}
		else {
			$Nome = htmlspecialchars($row['nome']);
			$Autori = htmlspecialchars($row['autori']);
			$Costo = $row['costo'];
			$Data_Pub = htmlspecialchars($row['data_pub']);
			$Voto = $row['voto'];
			$Num_Rec = $row['num_rec'];
			$Url_Img = htmlspecialchars($row['immagine']);
			echo "<div id='mostradati'>";
				echo "<span> Nome Libro: "'.$Nome.'"</span>";
				echo "<br>";
				echo "<span> Autori: "'.$Autori.'"</span>";
				echo "<br>";
				echo "<span> Costo: "'.$Costo.'"</span>";
				echo "<br>";
				echo "<span> Data di Pubblicazione: "'.$Data_Pub.'"</span>";
				echo "<br>";
				echo "<span> Voto: "'.$Voto.'"</span>";
				echo "<br>";
				echo "<span> Numero di Recensioni: "'.$Num_Rec.'"</span>";
			echo "</div>";
			echo "<div id='bottone_aggiunta'>";
				echo "<form id='aggiungi' name='aggiungi' method="POST" action='AggiungiCarrello.php'>";
					echo "<button type="button"> Aggiungi </button>";
				echo "</form>";
			echo "</div";
		}
		$stmt->close();
	}
?>