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
	header("Location: ../home.html");
}
function check_registered($email,$con) {
	$check_query="SELECT email FROM utente WHERE utente.email='$email'";
	$check=mysqli_query($con,$check_query);
	if (mysqli_affected_rows($con) == 1) {
		mysqli_free_result($check);
		return 0;
	}
	else {
		mysqli_free_result($check);
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
	    $nome = mysqli_real_escape_string($conn,$nome);
	    $cognome = mysqli_real_escape_string($conn,$cognome);
	    $email = mysqli_real_escape_string($conn,$email);
	    $password = mysqli_real_escape_string($conn,$password);
		$check_res = check_registered($email,$conn);
		if ($check_res == 0) {
			if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
			$_SESSION_["errore"]="La e-mail inserita è già associata ad un altro account";
			mysqli_close($conn);
			return 0;
		}
	    $query = "INSERT INTO utente (nome,cognome,password,email) VALUES ('$nome','$cognome','$password','$email')";
		$result=mysqli_query($conn,$query);
		if (mysqli_affected_rows($conn)==1) {
			$result=mysqli_query($conn,"SELECT* FROM utente WHERE utente.email='$email'");
			$row=mysqli_fetch_assoc($result);
			mysqli_close($conn);
			mysqli_free_result($result);
			return $row;
		}
		else {
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
	header("Location: Registrazione.php");
}
else {
	create_session($res);
}
?>
</body>
</html>
