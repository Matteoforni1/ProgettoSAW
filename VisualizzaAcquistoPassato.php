<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="stileSaw.css">
	<p> RISULTATI: </p>
</head>
<body>
<?php
	session_start();
	if(isset($_SESSION['id'])) {
		if (isset($_GET['id_acquisto']) && isset($_GET['id_utente'])) {
		require('DB_connections/webuser_access.php');                     //Connetto al DB
		$Id_Utente = $_GET['id_utente'];
		$Id_Acquisto = $_GET['id_acquisto'];
		$OttieniAcquistoLibro = "SELECT acquisto_libro.ISBN, libro.nome, acquisto_libro.quantita, acquisto_libro.costo FROM (acquisto_libro INNER JOIN libro) WHERE (id_acquisto = ? AND acquisto_libro.ISBN = libro.ISBN)";
		$con = webuser_access();
		$stmt2 = $con->prepare($OttieniAcquistoLibro);
		$stmt2->bind_param('i',$Id_Acquisto);
		if(!$stmt2->execute()) {
			header('Location: Error_Page.php');							//se ho errore nell'esecuziomne vado alla error page
			exit;
	    }
		$res = $stmt2->get_result();
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		$i = 0;
		while($i < $rowcount) {
			$Titolo = htmlspecialchars($row['nome']);
			$ISBN = htmlspecialchars($row['ISBN']);
			$Quantita = htmlspecialchars($row['quantita']);
			$Costo = htmlspecialchars($row['costo']);
			echo "<div>";
				$Num = $i + 1;
				echo "<p> Libro numero ".$Num.": </p>";
				echo "<p> Titolo: ".$Titolo." </p>";
				echo "<p> ISBN: ".$ISBN." </p>";
				echo "<p> quantità: ".$Quantita." </p>";
				echo "<p> costo: ".$Costo." </p>";
				echo "<br>";
				echo "<br>";
			echo "</div>";
			$i++;
			$row = $res->fetch_assoc();
		}
		echo "<a href ='Ordina_Ancora.php?id_acquisto=".$Id_Acquisto."'> Ordina Ancora </a>";
		echo "<br>";
		echo "<br>";
		echo "<a href='Storico.php?id_utente=".$Id_Utente."'> Torna Indietro </a>";
		$stmt2->close(); 
	}
	}
	else {
		header('Location: Login/login.php');
	}
?>
</body>
</html>