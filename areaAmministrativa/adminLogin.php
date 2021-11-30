<!DOCTYPE html>
<html>
<head>
    <title>adminLogin</title>                       
	<link href="stileSaw.css" rel="stylesheet">     
</head>                                             
<body style="background-color:#ffffff;">            
<?php	 
		 session_start();
	     if (isset($_SESSION["admin"])){
			 header('Location: areaAmministrativa.php');
		 }
		 if (isset($_SESSION["errore"]){
			 echo('<script type="text/javascript"> alert("'.$SESSION["error"].'")</script>');
		 }
?>
</br>
	<div class="logocentered">
	    <h1><a href="home.html">nomelogo</a></h1>  <!--eventualmente anche un img-->
	</div>
	<div class="form_container">
    <div class="form_header">
        <b>adminLogin</b>
    </div>
    <div class="login_form_box">
	    <form id="login_form" action="adminLog.php" method="post">
		    <label for="email"><b>Inserisci il tuo indirizzo E-mail</b></label>
			</br>
		    <input type="email" id="email" name="email" placeholder="E-mail" class="form_input">
			</br>
			<label for="password"><b>Inserisci la tua password</b></label>
			</br>
			<input type="password" id="password" name="password" placeholder="Password" class="form_input">
			</br>
			<input type="submit" id="submit" name="submit" value="Accedi" class="form_submit">
		</form>
	</div>
	</div>
	</br>
	<script type="text/javascript" src="Login.js"></script>
</body>
</html>