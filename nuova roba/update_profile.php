<html>
<head>
 <title>Modifica Profilo</title>
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body style="background-color:#F3E49A;">
<?php 
    include"comuni/header.php";
	include"comuni/nav.php";
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
	}
	if ($_GET["id"]!=$_SESSION["id"]){
		$_SESSION["errore"]="Non hai i permessi per visualizzare questa pagina";
		 header("Location:home.php");
		 exit;
		 
	}*/
	if (isset($_SESSION["messaggio"])){
			echo('<script type="text/javascript"> alert("'.$_SESSION["messaggio"].'")</script>');
			unset($_SESSION["messaggio"]);
	}
?>
<div class="profile_container">
    <div class="profile" style="margin-left:42.5em;; margin-top:2em; margin-bottom:2em; padding-top:1em;">
	    <form id="update_profile" method="post"  action="update_user.php">
		    <div class="form_row">
                <label for="firstname"><b><h3>Nome</h3></b></label>
                <input type="text" id="firstname" name="firstname" value=<?php echo(htmlspecialchars($_SESSION["nome"]))?> class="update_input">
				<div id="fnameerr" class="update_error">
				</div>
            </div>
		    </br>
            <div class="form_row">
                <label for="lastname"><b><h3>Cognome</h3></b></label>
                <input type="text" id="lastname" name="lastname" value=<?php echo(htmlspecialchars($_SESSION["cognome"]))?> class="update_input">
				<div id="lnameerr" class="update_error">
				</div>
            </div>
		    </br>
            <div class="form_row">
                <label for="email"><b><h3>E-mail</h3></b></label>
                <input type="email" id="email" name="email" value=<?php echo(htmlspecialchars($_SESSION["email"]))?> class="update_input">
			    <div id="emailerr" class="update_error">
				</div>
            </div>
		    </br>
            <div class="form_row">
                <label for="method"><b><h3>Metodo Pagamento</h3></b></label>
                <input type="text" id="method" name="method" class="update_input" value=<?php echo(htmlspecialchars($_SESSION["metodo"]))?> >
				<div id="methoderr" class="update_error">
				</div>
            </div>
		    </br>
			<div class="form_row">
			    <input type="submit" id="submit" name="submit" value="Modifica" class="update_submit">
			</div>
		</form>
    </div>		  
</div>
<?php 
include"comuni/footer.php";
?>
<script type="text/javascript" src="update_profile.js"></script>
</body>
</html>