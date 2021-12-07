<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stileSaw.css">
	<title> Home </title>
</head>
<body>
 <?php																							//devo fare ancora lo stile delle copertine, prezzo, nome
            require('../comuni/header.php');
			require('../comuni/nav.php');  
			session_start();
			if(isset($_SESSION["id"])) {
				$nome=trim($_SESSION["nome"]);
				$cognome=trim($_SESSION["cognome"]);
				echo "<div class='benvenuto'>"; 
					echo "<p>";
						echo "Benvenuto\t".$nome."\t".$cognome."\n";
						echo "qui sotto puoi trovare alcuni libri di tuo interesse.";
					echo "</p>";
				echo "</div>";
			}
			else {
				echo " <div class='benvenuto'>";
					echo "<p> Scopri Prefelibro,\n";
					echo "per te una vasta gamma di libri per ogni genere.\n";
					echo "Digita il nome di un libro o il correispondente codice ISBN nella barra di ricerca in alto,\t";
					echo "oppure naviga nell apposita\t";
					echo "<a href='cerca.php'>pagina</a>";
					echo ",\t";
					echo "per una ricerca più dettagliata.";
					echo "</p>";
				echo "</div>";
			}
			require('../DB_connections/webuser_access.php');
			$conn=webuser_access();
			$query="SELECT nome, ISBN, immagine, costo FROM libro ORDER BY data_pub LIMIT 8";			//non so in realtà se funziona ORDER BY data_pub...
			$result=mysqli_query($conn,$query);															//controllerò prossimamente
			echo "<div class='categories'>";
			echo "<h2> In primo piano: </h2>";
			echo "</div>";
			echo "<div class='main'>";
			while($row = mysqli_fetch_array($result)) {
				$nome=trim($row['nome']);
				$ISBN=trim($row['ISBN']);
				$imm=trim($row['immagine']);
				$costo=$row['costo'];
				$costo=$costo."€";
				echo "<div class='fakeimg'>";
				echo "<div class='copertina'><a href='libro.php?id=".$ISBN."'><img src=".$imm." alt='copertina'></a></div>";
				echo "<div class='prezzo'><p>".$costo."</p></div>";
				echo "<div class='nome'><a href='libro.php?id=".$ISBN."'>".$nome."</a></div>";
				echo "</div>";
			}
			echo "</div>";
			$query="SELECT nome, ISBN, immagine, costo FROM libro ORDER BY voto LIMIT 8";
			$result=mysqli_query($conn,$query);
			echo "<div class='categories'>";
			echo "<h2> I più votati:: </h2>";
			echo "</div>";
			echo "<div class='main'>";
			while($row = mysqli_fetch_array($result)) {
				$nome=trim($row['nome']);
				$ISBN=trim($row['ISBN']);
				$imm=trim($row['immagine']);
				$costo=$row['costo'];
				$costo=$costo."€";
				echo "<div class='fakeimg'>";
				echo "<div class='copertina'><a href='libro.php?id=".$ISBN."'><img src=".$imm." alt='copertina'></a></div>";
				echo "<div class='prezzo'><p>".$costo."</p></div>";
				echo "<div class='nome'><a href='libro.php?id=".$ISBN."'>".$nome."</a></div>";
				echo "</div>";
			}
			echo "</div>";
			mysqli_close($conn);
			if(isset($_SESSION["id"])&&isset($_SESSION["perte"])) {
				$gen=trim($_SESSION["perte"]);
				require('../DB_connections/webuser_access.php');
				$conn=webuser_access();
				$gen=mysqli_real_escape_string($conn,$gen);
				$query="SELECT l.nome, l.ISBN, l.immagine, l.costo FROM libro l WHERE l.ISBN IN (SELECT gl.ISBN FROM genere_libro gl WHERE gl.id_genere='$gen') ORDER BY l.voto LIMIT 8"; 
				$result=mysqli_query($conn,$query);
				echo "<div class='categories'>";
				echo "<h2> Scelti per te: </h2>";
				echo "</div>";
				echo "<div class='main'>";
				while($row = mysqli_fetch_array($result)) {
					$nome=trim($row['nome']);
					$ISBN=trim($row['ISBN']);
					$imm=trim($row['immagine']);
					$costo=$row['costo'];
					$costo=$costo."€";
					echo "<div class='fakeimg'>";
					echo "<div class='copertina'><a href='libro.php?id=".$ISBN."'><img src=".$imm." alt='copertina'></a></div>";
					echo "<div class='prezzo'><p>".$costo."</p></div>";
					echo "<div class='nome'><a href='libro.php?id=".$ISBN."'>".$nome."</a></div>";
					echo "</div>";
				}
				echo "</div>";
				mysqli_close($conn);
			}
			require('../comuni/footer.php');
?>

</body>
</html>