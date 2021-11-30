<?php

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["email"]) && isset($_POST["[password"])) {
			require_once('../DB_connections/webadmin_access.php');
		    $conn = webadmin_access();
			$email=trim($_POST["email"]);
			$email=strtolower($email);
			$email = mysqli_real_escape_string($conn,trim($email));
			$password = mysqli_real_escape_string($conn,$password);
	        $query = "SELECT * FROM admin WHERE email='$email'";
	        $result = mysqli_query($conn,$query);
		    if (mysqli_num_rows($result) == 0) {
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION["errore"]="Errore! Le credenziali inserite non sono corrette";
			    mysqli_close($conn);
				header('Location: adminLogin.php');
				}
		    $row=mysqli_fetch_assoc($result);
	        if(!password_verify($password,$row["password"])){
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION["errore"]="Errore! Le credenziali inserite non sono corrette";
			    mysqli_close($conn);
				header('Location: adminLogin.php');
		    }
		    mysqli_close($conn);
		    session_start();
			$_SESSION["admin"]=true;
			header('Location: areaAmministrativa.php');
		}
	?>