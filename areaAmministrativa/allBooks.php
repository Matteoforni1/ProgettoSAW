<!DOCTYPE html>
<html>
<head>
    <title>allBooks</title>     
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body>
<?php
		 session_start();
	     if (!isset($_SESSION["admin"])){
			 header('Location: adiminLogin.php');
			 exit();
		 }
		 else {
			 require('../comuni/header.php');    
		     require('../comuni/nav.php');    
			 require('../DB_connections/db_admin_access.php');	
			 echo" <div><a href='updateBook.php'>aggiungi un libro...</a></div>";
			 $conn=superadmin_access();
			 $query="SELECT ISBN, nome, autori, costo FROM libro";  									//aggiungerei un attributo "quantità disponibile" 
			 $result=mysqli_query($conn,$query);													    //così da poterla modificare...inutile ma aggiunge funz e più reale
			 echo "<table><tr><th>ISBN</th><th>NOME</th><th>AUTORI</th><th>COSTO</th><th> </th></tr>";
			 while($row = mysqli_fetch_array($risultato)) {
			 	$ISBN =$row['ISBN'];
				$nome = trim($row['nome']);
				$autori = trim($row['autori']);
				$costo = $row['costo'];
				echo "<tr><td>" .$ISBN. "</td><td>" .$nome. "</td><td>" .$autori. "</td><td>" .$costo. "</td><td><a href='updateBook.php?id=".$ISBN."'>modifica</a></td></tr>";
			 }
			echo "</table>";
			mysqli_close($conn);
			require('../comuni/footer.php');
		 }
?>
</body>
</html>