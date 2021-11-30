<?php
if (!isset($_SESSION["admin"])){
			 header('Location: adiminLogin.php');
			 exit();
		}
		else {
			require('../DB_connections/db_admin_access.php');
			$conn= super_admin_access();
			$email = trim($_GET['id']);
			$email=strtolower($email);
			$query = "UPDATE utente SET ban= 1 WHERE email = '$email'";
			$res = mysqli_query($conn,$query);
			echo "utente bannato"; 
			mysqli_close($conn);
			header('Location: allUser.php');
			exit();
		}
?>