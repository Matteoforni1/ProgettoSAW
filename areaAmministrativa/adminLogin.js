function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePassword(password) {
    const re = /^[\s\S]{8,32}$/;
    return re.test(password);
}

var form = document.getElementById("login_form");
form.addEventListener("submit", function(event){
        var errore = false;
        var email = document.getElementById("email").value;
        if(!validateEmail(email))
            {
            errore=true;
			document.getElementById("login_error").innerHTML = '<div class="error_display"><h3>Errore!</h3><p>Inserisci una email valida</p></div>';
            }
        else
            {
            document.getElementById("login_error").innerHTML = "";
            }
        var password = document.getElementById("password").value;
        if(!validatePassword(password))
            {
            errore=true;
			document.getElementById("login_error").innerHTML = '<div class="error_display"><h3>Errore!</h3><p>Inserisci una Password valida</p></div>';
            }
        else
            {
            document.getElementById("login_error").innerHTML = "";
            }
        if(errore) event.preventDefault();
});