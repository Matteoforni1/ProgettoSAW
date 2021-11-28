
function email_validate(email){
	const email_regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //regex from w3resource.com
	res=email_regex.test(String(email).toLowerCase());
	return res;
}

function check_login_values (event) {
	var errore=false;
	var email=document.getElementById("email").value;
	var pass=document.getElementById("password").value;
	if(!email_validate(email)){
		errore=true;
		document.getElementById("login_error").innerHTML = '<div class="error_display"><h3>Errore!</h3><p>Inserisci una email valida</p></div>';
	}
	if (pass=="") {
		errore=true;
		document.getElementById("login_error").innerHTML = '<div class="error_display"><h3>Errore!</h3><p>Inserisci una password</p></div>';
	}
	if(errore)
		event.preventDefault();
	else {
		document.getElementById("login_error").innerHTML = "";
	}
}

form=document.getElementById("login_form");
form.addEventListener("submit",check_login_values);
