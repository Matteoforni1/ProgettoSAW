<html>
<head>
 <title>Profilo</title>
	<link href="stileSaw.css" rel="stylesheet">
</head>
<body style="background-color:#F3E49A;">
<?php 
    include"comuni/header.php";
	include"comuni/nav.php";
	session_start();
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
      // last request was more than 30 minutes ago
      session_unset();     // unset $_SESSION variable for    the  run-time 
      session_destroy();   // destroy session data in   storage
	  header("Location:home.php");
	  exit;
    }
	$_SESSION['LAST_ACTIVITY'] = time(); 
    /*if (!isset($_SESSION["id"])) {
		$_SESSION["errore"]="Accedi per visualizzare il tuo profilo";
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
	$url1="update_profile.php?".http_build_query(array("id"=>$_SESSION["id"]));
	$url2="modify_password.php?".http_build_query(array("id"=>$_SESSION["id"]));
	$url3="your_reviews.php?".http_build_query(array("id"=>$_SESSION["id"]));
?>
<div class="profile_container">	
     <div class="buttonlist">
            <button type="button" class="editbutton" onclick=<?php echo("location.href='".$url1."'")?>>Modifica il tuo profilo</button>
			<button type="button" class="editbutton" onclick=<?php echo("location.href='".$url2."'")?>>Modifica la password</button>
			<button type="button" class="editbutton" onclick=<?php echo("location.href='".$url3."'")?>>Le tue recensioni</button>
    </div>        
    <div class="profile">
        <div class="row">
            <div class="label">
                <h3>Nome</h3>
            </div>
            <div class="profile-info">
                <?php echo(htmlspecialchars($_SESSION["nome"])); ?>
            </div>
        </div>
        <hr>
		</br>
        <div class="row">
            <div class="label">
                <h3>Cognome</h3>
            </div>
            <div class="profile-info">
                <?php echo(htmlspecialchars($_SESSION["cognome"])); ?>
            </div>
        </div>
        <hr>
		</br>
        <div class="row">
            <div class="label">
                <h3>Email</h3>
            </div>
            <div class="profile-info">
                <?php echo(htmlspecialchars($_SESSION["email"])); ?>
            </div>
        </div>
        <hr>
		</br>
        <div class="row">
            <div class="label">
                <h3>Metodo Pagamento</h3>
            </div>
            <div class="profile-info">
                <?php echo(htmlspecialchars($_SESSION["metodo"])); ?>
            </div>
        </div>
        <hr>
		</br>
    </div>		  
</div>
<?php 
include"comuni/footer.php";
?>
</body>
</html>