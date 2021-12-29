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
		$_SESSION["errore"]="Accedi per modificare il tuo profilo";
		header("Location:'Login/Login.php'");
		exit;
	}*/
	include('DB_Connections/webuser_access.php');
	include('DB_Connections/webadmin_access.php');
	
	function check_admin_mail($email) {
		$con= webadmin_access();
		$stmte = mysqli_stmt_init($con);
		mysqli_stmt_prepare($stmt,"SELECT email FROM amministratore WHERE email=?");
	    mysqli_stmt_bind_param($stmte,"s",$email);
	    mysqli_stmt_execute($stmte);
	    if (mysqli_stmt_affected_rows()>=1) {
		    mysqli_stmt_close($stmte);
			mysqli_close($con);
		    return 0;
	    }
	    else {
		    mysqli_stmt_close($stmte);
			mysqli_close($con);
		    return 1;
	    }
    }
	function check_registered($email,$con) {
		$stmt1 = mysqli_stmt_init($con);
	    mysqli_stmt_prepare($stmt1, "SELECT email FROM utente WHERE utente.email=?");
        mysqli_stmt_bind_param($stmt1, "s", $email);
		mysqli_stmt_execute($stmt1);
	    if (mysqli_stmt_affected_rows($stmt1) == 1) {
			mysqli_stmt_close($stmt);
		    return 0;
	    }
	    else {
			mysqli_stmt_close($stmt);
		    return 1;
		}
	}
	function update() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$nome = trim($_POST["firstname"]);
		    $cognome = trim($_POST["lastname"]);
	        $email = trim(strtolower($_POST["email"]));
			$metodo= trim($_POST["method"]);
			$id=$_SESSION["id"];
			$con=webuser_access();
			$check=check_registered($email,$con);
			$check_adm = check_admin_mail($email);
			if ($check == 0 || $check_adm == 0) {
				$_SESSION["messaggio"]="La email inserita é giá associata ad un altro account";
				mysqli_close($con);
				return;
			}
			$stmt = mysqli_stmt_init($con);
			mysqli_stmt_prepare($stmt, "UPDATE utente SET nome=?, cognome=?, email=?, metodo_p1=? WHERE utente.id=?");
			mysqli_stmt_bind_param($stmt, "ssssi", $nome,$cognome,$email,$metodo,$id);
			mysqli_stmt_execute($stmt);
			if (mysqli_stmt_affected_rows($stmt)==1) {
				$_SESSION["nome"]=$nome;
				$_SESSION["cognome"]=$cognome;
				$_SESSION["email"]=$email;
				$_SESSION["metodo"]=$metodo;
				$_SESSION["messaggio"]="Modifica avvenuta con successo";
			}
			else {
				$_SESSION["messaggio"]="C'é stato un errore durante il processo di modifica";
			}
			mysqli_stmt_close($stmt);
			mysqli_close($con);
		}
		return;
	}
	
update();
$url="show_profile.php?".http_build_query(array("id"=>$_SESSION["id"]));
header("Location:".$url."");
exit;	
?>
</body>
</html>