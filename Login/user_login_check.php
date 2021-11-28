<html>
<body>
<?php
include'webuser_access.php';
function create_session($row) {
	session_start();
	$_SESSION["id"]=$row["id"};
	$_SESSION["nome"]=$row["nome"};
	$_SESSION["cognome"]=$row["cognome"};
	$_SESSION["email"]=$row["email"};
	header("Location: home.html");
}
function get_for_you() {
	$id=$_SESSION["id"];
	$ucon = webuser_access();
	$query="WITH (SELECT a.id,a.data FROM acquisto a WHERE a.id_utente = ".$id." ORDER BY a.data DESC LIMIT 1) AS last
	        WITH (SELECT lastb.ISBN FROM (acquisto_libro al JOIN last ON al.ISBN = last.ISBN) lastb ORDER BY lastb.data DESC LIMIT 1) AS lastISBN
			SELECT lgen.genere FROM (lastISBN JOIN genere_libro gl ON lastISBN.genere = gl.genere) lgen";
	$gen = mysqli_query($ucon, $query);	
	if (mysqli_num_rows($gen) == 0)
		return;
	$genval = mysqli_fetch_assoc($gen);
	$_SESSION["perte"]=$genval["genere"];
	mysqli_free_result($gen);
}	
function user_login_check() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["email"]) && isset($_POST["[password"])) { 
		    $conn = webuser_access();
			$email=strtolower($_POST["email"]);
			$email = mysqli_real_escape_string($conn,trim($email));
			$password = mysqli_real_escape_string($conn,$password);
	        $query = "SELECT * FROM utente WHERE email='$email'";
	        $result = mysqli_query($conn,$query);
		    if (mysqli_num_rows($result) == 0) {
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION_["errore"]="Errore! Le credenziali inserite non sono corrette";
			    mysqli_close($conn);
		        return 0;
		    }
		    $row=mysqli_fetch_assoc($result);
	        if(!password_verify($password,$row["password"])){
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION_["errore"]="Errore! Le credenziali inserite non sono corrette";
			    mysqli_close($conn);
			    return 0;
		    }
		    mysqli_close($conn);
		    return $row;
		}
	}
}

$res = user_login_check();
mysqli_free_result($result);
if ($res==0)
	header("Location: Login.php");
else {
	create_session($res);
	get_for_you();
}
?>
</body>
</html>