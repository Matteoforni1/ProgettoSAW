<?php
	session_start();
	if (!isset($_SESSION["adminid"])){
		header('Location: adiminLogin.php');
		exit();
	}
	else{
		$lastactivity=$_SESSION["last_activity"];
		$lastactivity= time() - $lastactivity;
		if($lastactivity > 1800) {
			session_destroy();
			header('Location:login.php');
			exit();
		}
		else {
			$_SESSION["last_activity"]=time();
			$id = $_GET['id'];
			$adminid=$_SESSION["adminid"];
			$pattern="/^[0-9]{11}$/";
			if (preg_match($pattern,$id)&&preg_match($pattern,$adminid)) {
				$data=date("d/m/Y");
				require('../DB_Connections/webadmin_access.php');
				$conn= webadmin_access();
				$query = "INSERT INTO ban (id_utente,id_amm,data) VALUES ('$id','$adminid','$data')";
				$res = mysqli_query($conn,$query);
				echo "utente bannato"; 
				mysqli_close($conn);
				header('Location: allUser.php');
				exit();
			}
			else {
				$_SESSION_["errore"]="vi è stato un errore nel ban,ripetere l'operazione";
				mysqli_close($conn);
				header("Location: allUsers.php");
				exit();
			}
				
		}
	}
?>
