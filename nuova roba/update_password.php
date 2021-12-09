<html>
<body>
<?php
    session_start();
	/*if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
      // last request was more than 30 minutes ago
      session_unset();     // unset $_SESSION variable for    the  run-time 
      session_destroy();   // destroy session data in   storage
	  header("Location:home.php");
	  exit;
    }
	$_SESSION['LAST_ACTIVITY'] = time(); 
    if (!isset($_SESSION["id"])) {
		$_SESSION["errore"]="Accedi per modificare la tua password";
		header("Location:'Login/Login.php'");
		exit;
	}*/
	include('DB_Connections/webuser_access.php');
	function check_old_pass($oldpassword,$con){
		$stmt1 = mysqli_stmt_init($con);
	    mysqli_stmt_prepare($stmt1, "SELECT password FROM utente WHERE utente.id=?");
        mysqli_stmt_bind_param($stmt1, "i", $_SESSION["id"]);
		mysqli_stmt_execute($stmt1);
		mysqli_stmt_bind_result($stmt1,$row);
		mysqli_stmt_store_result($stmt1);
		mysqli_stmt_fetch($stmt1);
		if (!password_verify($oldpassword,$row)){
			$_SESSION["messaggio"]="La password inserita non é corretta";
			mysqli_stmt_close($stmt1);
			$url1="modify_password.php?".http_build_query(array("id"=>$_SESSION["id"]));
			header("Location:".$url1."");
			exit;
		}
		else{
			mysqli_stmt_close($stmt1);
			return true;
		}
	}
	function update_pass() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$con=webuser_access();
			$opass = trim($_POST["oldpass"]);
			$npass = trim($_POST["newpass"]);
			$cpass = trim($_POST["confirm"]);
			if (check_old_pass($opass,$con)){
				if ($npass==$cpass) {
					$pass=password_hash($npass,PASSWORD_DEFAULT);
					$stmt=mysqli_stmt_init($con);
					mysqli_stmt_prepare($stmt,"UPDATE utente SET password=? WHERE utente.id=?");
					mysqli_stmt_bind_param($stmt,"si",$pass,$_SESSION["id"]);
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_affected_rows($stmt)){
						$_SESSION["messaggio"]="La modifica della password é andata a buon fine";
						mysqli_close($con);
						return true;
					}
				}
			}
		}
		mysqli_close($con);
		return false;
	}
	        
$check=update_pass();
if($check) {
	$url="show_profile.php?".http_build_query(array("id"=>$_SESSION["id"]));
	header("Location:".$url."");
	exit;
}
else {
	//$_SESSION["messaggio"]="Si é riscontrato un problema durante la modifica";
	$url1="modify_password.php?".http_build_query(array("id"=>$_SESSION["id"]));
    header("Location:".$url1."");
	exit;
}