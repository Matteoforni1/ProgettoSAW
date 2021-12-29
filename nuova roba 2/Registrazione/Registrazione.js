function name_validate(name){
	const name_regex=/^(?=.{1,20}$)[a-z]+(?:[-'_.\s][a-z]+)*$/i;
	res=name_regex.test(name);
	return res;
}
function email_validate(email){
	const email_regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //regex from w3resource.com
	res=email_regex.test(String(email).toLowerCase());
	return res;
}
function check_reg_values(event){
	var fname=document.getElementById("firstname").value;
	var lname=document.getElementById("lastname").value;
	var email=document.getElementById("email").value;
	var pass=document.getElementById("pass").value;
	var cpass=document.getElementById("confirm").value;
	if (fname=="" || lname==""|| email=="" || pass=="" || cpass=="") {
		document.getElementById("reg_error").innerHTML='<div class="error_display"><h3>Errore!</h3><p>Compila tutti i campi</p></div>';
		event.preventDefault();
		return;
	}
	if (!(pass==cpass)) {
		document.getElementById("reg_error").innerHTML='<div class="error_display"><h3>Errore!</h3><p>Le password inserite non combaciano</p></div>';
		event.preventDefault();
		return;
	}
	if (!name_validate(fname)) {
		document.getElementById("reg_error").innerHTML='<div class="error_display"><h3>Errore!</h3><p>Il nome è troppo lungo o contiene caratteri non accettati</p></div>';
		event.preventDefault();
		return;
	}
	if (!name_validate(lname)){
		document.getElementById("reg_error").innerHTML='<div class="error_display"><h3>Errore!</h3><p>Il cognome è troppo lungo i contiene caratteri non accettati</p></div>';
		event.preventDefault();
		return;
	}
	if(!email_validate(email)){
	    document.getElementById("reg_error").innerHTML='<div class="error_display"><h3>Errore!</h3><p>La e-mail inserita non è valida</p></div>';
		event.preventDefault();
		return;
	}
	document.getElementById("reg_error").innerHTML='';	
}


form=document.getElementById("reg_form");
form.addEventListener("submit",check_reg_values);