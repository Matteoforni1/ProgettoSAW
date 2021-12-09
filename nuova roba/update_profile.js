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
function check_fields(fnameval, lnameval, emailval) {
	check=true;
	if(fnameval==""){
	    check=false;
	    document.getElementById("fnameerr").innerHTML="Compila questo campo";
		document.getElementById("firstname").style.borderColor="#f44336";
	}
	else {
		document.getElementById("fnameerr").innerHTML="";
		document.getElementById("firstname").style.borderColor="black";
	}
	if(lnameval==""){
	    check=false;
		document.getElementById("lnameerr").innerHTML="Compila questo campo";
		document.getElementById("lastname").style.borderColor="#f44336";
	}
	else {
		document.getElementById("lnameerr").innerHTML="";
		document.getElementById("lastname").style.borderColor="black";
	}
	if(emailval==""){
	    check=false;
		document.getElementById("emailerr").innerHTML="Compila questo campo";
		document.getElementById("email").style.borderColor="#f44336";
	}
	else {
		document.getElementById("emailerr").innerHTML="";
		document.getElementById("email").style.borderColor="black";
	}
	return check
}
function fields_validate(fname,lname,email,method) {
	valid=true;
	if (!(name_validate(fname))) {
		valid=false
		document.getElementById("fnameerr").innerHTML="Il nome è troppo lungo o contiene caratteri non accettati";
		document.getElementById("firstname").style.borderColor="#f44336";
	}
	else {
		document.getElementById("fnameerr").innerHTML="";
		document.getElementById("firstname").style.borderColor="black";
	}
	if (!(name_validate(lname))) {
		valid=false
		document.getElementById("lnameerr").innerHTML="Il cognome è troppo lungo o contiene caratteri non accettati";
		document.getElementById("lastname").style.borderColor="#f44336";
	}
	else {
		document.getElementById("lnameerr").innerHTML="";
		document.getElementById("lastname").style.borderColor="black";
	}
	if (!(email_validate(email))) {
		valid=false
		document.getElementById("emailerr").innerHTML="La email inserita non é valida";
		document.getElementById("email").style.borderColor="#f44336";
	}
	else {
		document.getElementById("emailerr").innerHTML="";
		document.getElementById("email").style.borderColor="black";
	}
	if (method.lenght>20) {
		valid=false
		document.getElementById("methoderr").innerHTML="Il metodo di pagamento puó avere al massimo 20 lettere";
		document.getElementById("method").style.borderColor="#f44336";
	}
	else {
		document.getElementById("methoderr").innerHTML="";
		document.getElementById("method").style.borderColor="black";
	}
	return valid;	
}
function check_update_values(event) {
	var fname=document.getElementById("firstname").value;
	var lname=document.getElementById("lastname").value;
	var email=document.getElementById("email").value;
	var method=document.getElementById("method").value;
	var c=check_fields(fname, lname, email);
	if(!c) {
		event.preventDefault();
		return;
	}
	var f=fields_validate(fname,lname,email,method);
	if(!f) {
		event.preventDefault();
		return;
	}	
}


form=document.getElementById("update_profile");
form.addEventListener("submit",check_update_values);
