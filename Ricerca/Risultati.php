<?php
	session_start();
	if (!isset($_SESSION['webuser']) || !isset($_POST['tag'])) {
		header('Location: Error_Page.php');
		exit();
	}
	else {
		require('../DB_connections/webuser_access.php');
		$Id_Utente = $_SESSION['webuser'];
		$StringaRicerca = $_POST['tag'];
		$Ricerca = "SELECT *
			    FROM libro
			    WHERE CHARINDEX('?', nome) > 0
  			    AND CHARINDEX('?', autori) > 0";
		$stmt = $con->prepare($Ricerca);
		$stmt->bind_param('ss', $StringaRicerca, $StringaRicerca);
		if(!$stmt->execute()) {
			header('Location: Error_Page.php');
			exit();
		}
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		$rowcount = $res->num_rows;
		$i = 0;
		while($i < $rowcount) {
			$Nome = htmlspecialchars($row['nome']);
			$Autori = htmlspecialchars($row['autori']);
			$Prezzo = $row['prezzo'];
			$ISBN = $row['ISBN'];
			echo "<div id='mostralibri'>";
				echo "<div id='mostralibri2'>";
					echo "<div id='titolo'>".$Nome."</div>";
					echo "<br>";
					echo "<div id='autori'>".$Autori."</div>";
					echo "<br>";
					echo "<div id='prezzo'>".$Prezzo." €</div>";
					echo "<br>";
					echo "<div>";
						echo <a href='PaginaLibri.php?ISBN=".$ISBN."'>Visualizza Informazioni</a>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			$i++;
			$row = $res->fetch_assoc();
		}
		$stmt->close();
	}
?>