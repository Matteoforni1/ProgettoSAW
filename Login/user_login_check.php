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
	$_SESSION["last_activity"]=time();
}
function create_adminsession($adminrow) {
	session_start();
	$_SESSION["adminid"]=$adminrow["id"];
	$_SESSION["email"]=$adminrow["email"];
	$_SESSION["last_activity"]=time();
	header("Location: ../reserved_area.php");
	exit;
}
function get_for_you() {
	$id=$_SESSION["id"];
	$ucon = webuser_access();
	$query1="CREATE OR REPLACE VIEW last AS SELECT a.id,a.data FROM acquisto a WHERE a.id_utente = ".$id." ORDER BY a.data DESC LIMIT 1";
	$gen1 = mysqli_query($ucon, $query1);
	$query2="CREATE OR REPLACE VIEW lastISBN AS SELECT al.ISBN FROM (acquisto_libro al JOIN last ON al.id_acquisto = last.id) ORDER BY last.data DESC LIMIT 1";
	$gen2 = mysqli_query($ucon, $query2);
	$query3= "CREATE OR REPLACE VIEW lastgen AS SELECT gl.id_genere FROM (lastISBN JOIN genere_libro gl ON lastISBN.ISBN = gl.ISBN)";
	$gen3 = mysqli_query($ucon, $query3);
	$query = "SELECT g.nome FROM (genere g JOIN lastgen ON lastgen.id_genere = g.id)";
	$gen=mysqli_query($ucon,$query);	
	if (mysqli_num_rows($gen) == 0)
		return;
	$genval = mysqli_fetch_assoc($gen);
	$_SESSION["perte"]=$genval["genere"];
	mysqli_free_result($gen);
	mysqli_close($ucon);
}
function check_admin($email) {
	$adcon = webadmin_access();
	$adquery="SELECT * FROM amministratore WHERE amministratore.email = '$email'";
	$check_ad = mysqli_query($adcon,$adquery);
	if (mysqli_num_rows($check_ad)==1) {
		$adrow=mysqli_fetch_assoc($check_ad);
		mysqli_free_result($check_ad);
		mysqli_close($adcon);
		return $adrow;
	}
	else {
		mysqli_free_result($check_ad);
		mysqli_close($adcon);
		return 0;
	}
}
/*function check_ban($con,$id) {
	$banquery="SELECT * FROM ban WHERE ban.id_utente='$id'";
	$ban=mysqli_query($con,$banquery);
	if (mysqli_affected_rows($con)==1) {
		mysqli_free_result($ban);
		return true;
	}
	else {
		mysqli_free_result($ban);
		return false;
	}
}*/	
function user_login_check() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["email"]) && isset($_POST["password"])) { 
			$email=strtolower($_POST["email"]);
			$conn = webuser_access();
			$email = mysqli_real_escape_string($conn,trim($email));
			$password = mysqli_real_escape_string($conn,$_POST["password"]);
			$admin=check_admin($email);
			if ($admin !== 0) {
				mysqli_close($conn);
				create_adminsession($admin);
			}
			
	        $query = "SELECT * FROM utente WHERE email='$email'";
	        $result = mysqli_query($conn,$query);
		    if (mysqli_num_rows($result) == 0) {
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION["errore"]="Errore! Le credenziali inserite non sono corrette";
				echo($_SESSION["errore"]);
			    mysqli_close($conn);
				mysqli_free_result($result);
		        return 0;
		    }
		    $row=mysqli_fetch_assoc($result);
	        if(!password_verify($password,$row["password"])){
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				$_SESSION["errore"]="Errore! Le credenziali inserite non sono corrette";
			    mysqli_close($conn);
				mysqli_free_result($result);
			    return 0;
		    }
			if ($row["ban"]) {
				#header("Location: banned.php");
				#exit;
			}
		    mysqli_close($conn);
			mysqli_free_result($result);
		    return $row;
		}
	}
	return 0;
}
$res = user_login_check();
if ($res==0) {
	echo(1);
	header("Location: Login.php");
	exit;
}
else {
	create_session($res);
	get_for_you();
	header("Location: ../home.html");
}
?>
</body>
</html>