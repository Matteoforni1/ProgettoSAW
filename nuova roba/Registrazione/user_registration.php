<html>
<body>
<?php
include'../DB_Connections/webadmin_access.php';
function create_session($row) {
	session_start();
	$_SESSION["id"]=$row["id"];
	$_SESSION["nome"]=$row["nome"];
	$_SESSION["cognome"]=$row["cognome"];
	$_SESSION["email"]=$row["email"];
	$_SESSION["metodo"]='';
	$_SESSION["last_activity"]=time();
	header("Location: ../home.php");
	exit;
}
function check_registered($email,$con) {
	$stmt=mysqli_stmt_init($con);
	mysqli_stmt_prepare($stmt,"SELECT email FROM utente WHERE utente.email=?");
	mysqli_stmt_bind_param($stmt,"s",$email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	if (mysqli_stmt_affected_rows($stmt) == 1) {
		mysqli_stmt_close($stmt);
		return 0;
	}
	else {
		mysqli_stmt_close($stmt);
		return 1;
	}
}

function user_registration() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nome = trim($_POST["firstname"]);
		$cognome = trim($_POST["lastname"]);
	    $email = trim(strtolower($_POST["email"]));
	    $password = password_hash($_POST["pass"],PASSWORD_DEFAULT);
	    $conn = webadmin_access();
		$check_res = check_registered($email,$conn);
		if ($check_res == 0) {
			if (session_status() === PHP_SESSION_NONE) {
					session_start();
			}
			$_SESSION["errore"]="La e-mail inserita è già associata ad un altro account";
			mysqli_close($conn);
			return 0;
		}
		$stmt=mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt," INSERT INTO utente (nome,cognome,password,email) VALUES (?,?,?,?)");
		mysqli_stmt_bind_param($stmt,"ssss",$nome,$cognome,$password,$email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_affected_rows($stmt)==1) {
			mysqli_stmt_free_result($stmt);
			mysqli_stmt_prepare($stmt,"SELECT* FROM utente WHERE utente.email=?");
			mysqli_stmt_bind_param($stmt,"s",$email);
			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);
			$row=mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			return $row;
		}
		else {
			mysqli_stmt_close($stmt);
			if (session_status() === PHP_SESSION_NONE) {
					session_start();
			}
			$_SESSION_["errore"]="Un errore è stato rilevato nel processo di registrazione. Riprova";
			mysqli_close($conn);
			return 0;
		}
	}
	return 0;
}
$res=user_registration();
if ($res==0) {
	header("Location: register.php");
	exit;
}
else {
	create_session($res);
}
?>
</body>
</html>
