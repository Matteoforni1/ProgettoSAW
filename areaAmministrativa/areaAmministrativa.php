<!DOCTYPE html>
<html>
<head>
    <title>areaAmministrativa</title>             
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body>
<?php
         require('../comuni/header.php');// includo la parte comune
		 require('../comuni/nav.php');  //  
		 session_start();
	     if (!isset($_SESSION["admin"])){
			 header('Location: adiminLogin.php');
			 exit();
		 }
		 else {
			 echo "<div class='container'>";
			  echo "<a href='allUsers.php'>Utenti</a>";
			  echo "<a href='allBooks.php'>Libri</a>";
			  echo "<a href='allTranactions.php'>Transazioni</a>";
			 echo "</div>";
		 }
         require('../comuni/footer.php');
?>
</body>
</html>