<html>
<head>
    <title>Registrati</title>
	<link href="../stileSaw.css" rel="stylesheet">
</head>
<?php
         session_start();
	     /*if (isset($_SESSION["id"]) || isset($_SESSION["adminid"])){
			 header('Location: ../home.html');
			 exit;
		 }*/
		 if (isset($_SESSION["errore"])){
			 echo('<script type="text/javascript"> alert("'.$_SESSION["errore"].'")</script>');
			 unset($_SESSION["errore"]);
		 }
	?>
<body  style="background-color:#ffffff;">	
	</br>
	<div class="logocentered">
	    <h1><a href="home.html">Prefelibro</a></h1>  
	</div>
	<div id="reg_error" class="error_box">
	</div>
	<div class="reg_form_container">
	<div class="form_header">
	    <b>Registrazione</b>
	</div>	 
	<div class="reg_form_box">
	    <form id="reg_form" action="user_registration.php" method="post">
		    <label for="firstname"><b>Nome (max 20)</b></label>
			</br>
		    <input type="text" id="firstname" name="firstname" placeholder="Nome" class="form_input">
			</br>
			<label for="lastname"><b>Cognome (max 20)</b></label>
			</br>
		    <input type="text" id="lastname" name="lastname" placeholder="Cognome" class="form_input">
			</br>
			<label for="email"><b>E-mail</b></label>
			</br>
		    <input type="email" id="email" name="email" placeholder="E-mail" class="form_input">
			</br>
			<label for="password"><b>Password</b></label>
			</br>
		    <input type="password" id="pass" name="pass" placeholder="Password" class="form_input">
			</br>
			<label for="confirm"><b>Conferma Password</b></label>
			</br>
		    <input type="password" id="confirm" name="confirm" placeholder="Conferma Password" class="form_input">
			</br>
			<input type="submit" id="submit" name="submit" value="Continua" class="form_submit">
		</form>
	</div>
	</div>
	</br>
	<div class="footer" style="background-color:#f4f4f4; color:black;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px; height:14em;">
	<p>LOREM IPSUM</p>
	</div>
	<script type="text/javascript" src="Registrazione.js"></script>
</body>
</html>

	
			