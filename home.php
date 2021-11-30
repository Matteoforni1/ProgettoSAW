<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stileSaw.css">
	<title> Home </title>
</head>
<body>
 <?php
            require('../comuni/header.php');// includo la parte comune
			require('../comuni/nav.php');  //  
            ?>
 <?php
				session_start();
                if(isset($_SESSION["id"]))                         
                {
					$nome=trim($_SESSION["nome"]);
					$cognome=trim($_SESSION["cognome"]);
					echo "<div class='benvenuto'>"; 
						echo "<p>";
							echo "Benvenuto";
							echo "\t$nome";
							echo "\t$cognome,\n";
							echo "qui sotto puoi trovare alcuni libri di tuo interesse.";
						echo "</p>";
					echo "</div>";
                }
				else {
					echo " <div class='notlogged'>";
						echo "<p> Scopri Prefelibro,\n";
						echo "per te una vasta gamma di libri per ogni genere.\n";
						echo "Digita il nome di un libro o il correispondente codice ISBN nella barra di ricerca in alto,\t";
						echo "oppure naviga nell' apposita\t";
						echo "<a href="cerca.php">pagina</a>";
						echo ",\t";
						echo "per una ricerca piu' dettagliata.";
						echo "</p>";
					echo "</div>";
				}
            ?>
<div class="categories">
<h2> In primo piano: </h2>
</div>
<div class="main">
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
</div>
<div class="categories">
 <h2> I più votati: </h2> 
</div>
<div class="main">
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
 <div class="fakeimg"> *img </div>
</div>
<?php 
		 if(isset($_SESSION["id"]))                         
                {
				echo "<div class='categories'>";
				echo "<h2> Scelti per te: </h2>";
				echo "</div>";
				echo "<div class='main'>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "<div class='fakeimg'> *img </div>";
				echo "</div>";
				}
?>

<?php
		require('../comuni/footer.php');
		?>

</body>
</html>