
function check_fields(oldpass, newpass,confpass) {
	check=true;
	if(oldpass==""){
	    check=false;
	    document.getElementById("oldpasserr").innerHTML="Compila questo campo";
		document.getElementById("oldpass").style.borderColor="#f44336";
	}
	else {
		document.getElementById("oldpasserr").innerHTML="";
		document.getElementById("oldpass").style.borderColor="black";
	}
	if(newpass==""){
	    check=false;
		document.getElementById("newpasserr").innerHTML="Compila questo campo";
		document.getElementById("newpass").style.borderColor="#f44336";
	}
	else {
		document.getElementById("newpasserr").innerHTML="";
		document.getElementById("newpass").style.borderColor="black";
	}
	if(confpass==""){
	    check=false;
		document.getElementById("confpasserr").innerHTML="Compila questo campo";
		document.getElementById("confirm").style.borderColor="#f44336";
	}
	else {
		document.getElementById("confpasserr").innerHTML="";
		document.getElementById("confirm").style.borderColor="black";
	}
	return check
}



function check_passupdate_values(event) {
	var opass=document.getElementById("oldpass").value;
	var npass=document.getElementById("newpass").value;
	var cpass=document.getElementById("confirm").value;
	var c=check_fields(opass,npass,cpass);
	if (!c){
		event.preventDefault();
		return;
	}
	if (npass!=cpass){
		document.getElementById("confpasserr").innerHTML="Le password non combaciano";
		document.getElementById("confirm").style.borderColor="#f44336";
		event.preventDefault();
		return;
	}
	else {
		document.getElementById("confpasserr").innerHTML="";
		document.getElementById("confirm").style.borderColor="black";
	}
	if (opass==npass){
		document.getElementById("newpasserr").innerHTML="La password scelta é troppo simile";
		document.getElementById("newpass").style.borderColor="#f44336";
		event.preventDefault();
		return;
	}
	else {
		document.getElementById("newpasserr").innerHTML="";
		document.getElementById("newpass").style.borderColor="black";
	}
	return;
}


form=document.getElementById("update_pass");
form.addEventListener("submit",check_passupdate_values);