<?php
	function update_user($id,$con) {
		
		$up_query="UPDATE utente SET ban=1 WHERE utente.id='$id'";
		$upuser=mysqli_query($con,$up_query);
		if (mysqli_affected_rows($con) == 1) {
			return 0;
		}
		else {
			return 1;
		}
	}


	session_start();
	if (!isset($_SESSION["adminid"])){
		header('Location: login.php');
		exit();
	}
	else{
		$lastactivity=$_SESSION["last_activity"];
		$lastactivity= time() - $lastactivity;
		if($lastactivity > 1800) {
			session_unset();
			session_destroy();
			header('Location:login.php');
			exit();
		}
		else {
			$_SESSION["last_activity"]=time();
			$id = $_GET['id'];
			$adminid=$_SESSION["adminid"];
			$pattern="/^[0-9]{1,11}$/";
			if (preg_match($pattern,$id)&&preg_match($pattern,$adminid)) {
				$data=date("Y/m/d");
				require('DB_connections/webadmin_access.php');	
				$conn=webadmin_access();
				$id=mysqli_real_escape_string($conn,$id);
				$adminid=mysqli_real_escape_string($conn,$adminid);
				$data=mysqli_real_escape_string($conn,$data);
				$result=update_user($id,$conn);
				if($result == 0){										//qua uguale a 0 perchè aff rows deve ritornarmi 1
					$query = "INSERT INTO ban (id_utente,id_amm,data) VALUES ('$id','$adminid','$data')";
					$res = mysqli_query($conn,$query);
					echo "utente bannato"; 
					mysqli_close($conn);
					header('Location: allUsers.php');
					exit();
				}
				else {
					$_SESSION["errore"]="vi è stato un errore nel ban,ripetere l'operazione";
					mysqli_close($conn);
					header("Location: allUsers.php");
					exit();
				}
			}
			else {
				$_SESSION["errore"]="vi è stato un errore nel ban,ripetere l'operazione";
				header("Location: allUsers.php");
				exit();
			}
				
		}
	}
?>
