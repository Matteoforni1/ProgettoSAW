<html>
<head>
    <title>Accedi</title>
	<link href="stileSaw.css" rel="stylesheet"> 
</head>
<body style="background-color:#ffffff;">
    <?php
	     if (isset($_SESSION["id"])){
			 header('Location: home.html');
		 }
		 if (isset($_SESSION["errore"]){
			 echo('<script type="text/javascript"> alert("'.$SESSION["error"].'")</script>');
		 }
	    //include header,footer and required php/js files
	?>
	</br>
	<div class="logocentered">
	    <h1><a href="home.html">nomelogo</a></h1>  <!--eventualmente anche un img-->
	</div>
	<div id="login_error" class="error_box">
	<?php
	    if (isset($_SESSIONE["error"])){
			 echo('<div class="error_display"');
		 }
	?>
	</div>
	<div class="form_container">
    <div class="form_header">
        <b>Login</b>
    </div>
    <div class="login_form_box">
	    <form id="login_form" action="test.php" method="post">
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
	<div class="register" >
	     <button type="button" class="registerbutton" onclick="Login.php">Registrati</button>
	</div>
	</br>
	<div class="footer" style="background-color:#f4f4f4;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px; height:50%;">
	<p>LOREM IPSUM</p>
	</div>
	<script type="text/javascript" src="Login.js"></script>
</body>
</html>