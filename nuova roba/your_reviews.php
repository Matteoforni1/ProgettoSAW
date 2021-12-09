<html>
<head>
 <title>Le tue recensioni</title>
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body style="background-color:#F3E49A; height:100vh; margin:0; display:flex; flex-direction:column; ">
<?php 
    include"comuni/header.php";
	include"comuni/nav.php";
	include('DB_Connections/webuser_access.php');
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
		$_SESSION["errore"]="Accedi per vedere le tue recensioni";
		header("Location:'Login/Login.php'");
		exit;
	}
	if ($_GET["id"]!=$_SESSION["id"]){
		$_SESSION["errore"]="Non hai i permessi per visualizzare questa pagina";
		 header("Location:home.php");
		 exit;
		 
	}*/
	$con=webuser_access();
	$stmt=mysqli_stmt_init($con);
	mysqli_stmt_prepare($stmt,"SELECT libro.ISBN, libro.nome, r.voto, r.data FROM((SELECT recensione.ISBN,recensione.voto,recensione.data FROM recensione WHERE id_utente=?) AS r JOIN libro ON r.ISBN=libro.ISBN)");
	mysqli_stmt_bind_param($stmt,"i",$_SESSION["id"]);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	if (mysqli_stmt_num_rows($stmt)>0){
	    mysqli_stmt_bind_result($stmt,$isbn,$nome,$voto,$data);
		echo("<div class=review_row>
		             <div class=review_info>
				     <h3>ISBN<h3>
				     </div>
				     <div class=review_info>
				     <h3>Nome Libro</h3>
				     </div>
				     <div class=review_info>
				     <h3>Voto</h3>
				     </div>
				     <div class=review_info>
				     <h3>Data Recensione</h3>
				     </div>
			      </div>
				  "
			);
	    while(mysqli_stmt_fetch($stmt)){
		    echo("<div class=review_row>
		             <div class=review_info>
				     <p>".htmlspecialchars($isbn)."</p>
				     </div>
				     <div class=review_info>
				     <p>".htmlspecialchars($nome)."</p>
				     </div>
				     <div class=review_info>
				     <p>".htmlspecialchars($voto)."</p>
				     </div>
				     <div class=review_info>
				     <p>".htmlspecialchars($data)."</p>
				     </div>
			      </div>"
				);
		}
		mysqli_stmt_free_result($stmt);
		mysqli_close($con);
	}
	else {
		mysqli_stmt_free_result($stmt);
		mysqli_close($con);
		echo("<h1 style='text-align:center; margin-bottom:16em;'>Non hai ancora fatto nessuna recensione</h1>");
	}
?>
<?php 
include"comuni/footer.php"; #aggiungi margin-top:auto;
?>
</body>
</html>