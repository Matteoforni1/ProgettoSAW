<html>
<head>
 <title>Modifica Password</title>
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
		$_SESSION["errore"]="Accedi per modificare la tua password";
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
    <div class="profile" style="margin-left:42.5em;; margin-top:2em; margin-bottom:2em; padding-top:3em;">
	    <form id="update_pass" method="post" action="update_password.php">
		    <div class="form_row">
                <label for="oldpass"><b><h3>Vecchia Password</h3></b></label>
                <input type="password" id="oldpass" name="oldpass" class="update_input">
				<div id="oldpasserr" class="update_error">
				</div>
            </div>
		    </br>
            <div class="form_row">
                <label for="newpass"><b><h3>Nuova Password</h3></b></label>
                <input type="password" id="newpass" name="newpass" class="update_input">
				<div id="newpasserr" class="update_error">
				</div>
            </div>
		    </br>
            <div class="form_row">
                <label for="confirm"><b><h3>Conferma Password</h3></b></label>
                <input type="password" id="confirm" name="confirm" class="update_input">
				<div id="confpasserr" class="update_error">
				</div>
            </div>
		    </br>
			<div class="form_row" style="margin-top:2em;">
			    <input type="submit" id="submit" name="submit" value="Modifica" class="update_submit">
			</div>
		</form>
    </div>		  
</div>
<?php 
include"comuni/footer.php";
?>
<script type="text/javascript" src="modify_password.js"></script>
</body>
</html>