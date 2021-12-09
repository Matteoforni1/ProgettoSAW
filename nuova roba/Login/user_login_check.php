<html>
<body>
<?php
include'../DB_Connections/webuser_access.php';
include'../DB_Connections/webadmin_access.php';
function create_session($row) {
	session_start();
	$_SESSION["id"]=$row["id"];
	$_SESSION["nome"]=$row["nome"];
	$_SESSION["cognome"]=$row["cognome"];
	$_SESSION["email"]=$row["email"];
	$_SESSION["metodo"]=$row["metodo_p1"];
	$_SESSION["last_activity"]=time();
}
function create_adminsession($adminrow) {
	session_start();
	$_SESSION["adminid"]=$adminrow["id"];
	$_SESSION["email"]=$adminrow["email"];
	$_SESSION["last_activity"]=time();
	header("Location: ../areaAmministrativa/areaAmministrativa.php");
	exit;
}
function get_for_you() {
	$id=$_SESSION["id"];
	$ucon = webuser_access();
	$stmt=mysqli_stmt_init($ucon);
	mysqli_stmt_prepare($stmt,"SELECT al.ISBN FROM acquisto_libro al WHERE al.id_acquisto=(SELECT a.id FROM acquisto a WHERE a.id_utente=? ORDER BY a.data DESC LIMIT 1)");
	mysqli_stmt_bind_param($stmt,"i",$id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt,$gen_isbn);
	mysqli_stmt_fetch($stmt);
	if (mysqli_stmt_num_rows($stmt)==0){
		mysqli_stmt_close($stmt);
		return;
	}
	$stmt1=mysqli_stmt_init($ucon);
	mysqli_stmt_prepare($stmt1,"SELECT gl.id_genere FROM genere_libro gl WHERE gl.ISBN = ?");
	mysqli_stmt_bind_param($stmt1,"s",$gen_isbn);
	mysqli_stmt_execute($stmt1);
	
	mysqli_stmt_close($stmt); //closing first statement
	
	mysqli_stmt_bind_result($stmt1,$gen);
	mysqli_stmt_store_result($stmt1);
	mysqli_stmt_fetch($stmt1);
	$_SESSION["perte"]=$gen;
	mysqli_stmt_close($stmt1);
	mysqli_close($ucon);
}
function check_admin($email,$password) {
	$adcon = webadmin_access();
	$stmt=mysqli_stmt_init($adcon);
	mysqli_stmt_prepare($stmt,"SELECT * FROM amministratore WHERE amministratore.email = ?");
	mysqli_stmt_bind_param($stmt,"s",$email);
	mysqli_stmt_execute($stmt);
	$check_ad=mysqli_stmt_get_result($stmt);
	if (mysqli_num_rows($check_ad)==1) {
		$adminrow=mysqli_fetch_assoc($check_ad);
		if (password_verify($password,$adminrow["password"])) {
			mysqli_stmt_close($stmt);
			mysqli_close($adcon);
			return $adminrow;
		}
		else {
			mysqli_stmt_close($stmt);
			mysqli_close($adcon);
			return 0;
		}
	}
	else {
		mysqli_stmt_close($stmt);
		mysqli_close($adcon);
		return 0;
	}
}
function user_login_check() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["email"]) && isset($_POST["password"])) { 
			$email=strtolower($_POST["email"]);
			$conn = webuser_access();
			$email =trim($email);
			$password = $_POST["password"];
			$admin=check_admin($email,$password);
			if ($admin !== 0) {
				mysqli_close($conn);
				create_adminsession($admin);
			}
			$stmt=mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "SELECT * FROM utente WHERE email=?");
			mysqli_stmt_bind_param($stmt,"s",$email);
			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);
		    if (mysqli_num_rows($result) == 0) {
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION["errore"]="Errore! Le credenziali inserite non sono corrette";
				echo($_SESSION["errore"]);
			    mysqli_close($conn);
				mysqli_stmt_close($stmt);
		        return 0;
		    }
		    $row=mysqli_fetch_assoc($result);
	        if(!password_verify($password,$row["password"])){
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION["errore"]="Errore! Le credenziali inserite non sono corrette";
			    mysqli_close($conn);
				mysqli_stmt_close($stmt);
			    return 0;
		    }
			if ($row["ban"]) {
				header("Location: ../banned.php");
				exit;
			}
		    mysqli_close($conn);
			mysqli_stmt_close($stmt);
		    return $row;
		}
	}
	return 0;
}
$res = user_login_check();
if ($res==0) {
	header("Location: Login.php");
	exit;
}
else {
	create_session($res);
	get_for_you();
	header("Location: ../home.php");
	exit;
}
?>
</body>
</html>