<!DOCTYPE html>
<html>
<head>
    <title>allUsers</title>             
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body>
<?php
         require('../comuni/header.php');    
		 require('../comuni/nav.php');       
		 session_start();
	     if (!isset($_SESSION["admin"])){
			 header('Location: adiminLogin.php');
			 exit();
		 }
		 else {
			 require('../DB_connections/db_admin_access.php');
			 $conn=super_admin_access();
			 $query="SELECT id, nome, cognome, email, ban FROM utente";                          //tabella utente necessita attributo boolean ban
			 $result=mysqli_query($conn,$query);                                                 //per bannare utenti senza eliminarli dal db
			echo "<table><tr><th>NOME</th><th>COGNOME</th><th>EMAIL</th><th>BAN</th></tr>";      //come vuole la prof
			while($row = mysqli_fetch_array($risultato)) {
				$nome = trim($row['nome']);
				$cognome = trim($row['cognome']);
				$email = trim($row['email']);
				$ban = $row['ban'];
				$email=strtolower($email);
				echo "<tr><td>" .$nome. "</td><td>" .$cognome. "</td><td>" .$email. "</td>";
				if (!$ban) {
					echo "<td><a href='ban.php?id=".$email."'>Ban</a></td>";
				}
				else {
					echo " <td> Utente bannato </td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			mysqli_close($conn);
		 }
		 require('../comuni/footer.php'); 
?>
</body>
</html>
