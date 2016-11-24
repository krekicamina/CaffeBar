window.onload = function(){
  var email = localStorage.getItem("Test2");
  var email1 = document.getElementById("Test2");
  if (email != null) email1.value = email;
}


/*dropdown meni*/
function dropDownFunkcija() {
	var x = document.getElementById("mytopnav");
	if (x.className === "header") {
		x.className += " responsive";
	} 
	else {
		x.className = "header";
	}
}


 /*validacija*/
 function validateEmail(field) { /*funkcija daje upozorenja ukoliko polje e-mail nije popunjeno i ukoliko je pogresan format*/
    value = document.getElementById(field).value;
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
	errorField = field + 'Error';

    successField = field + 'Success';

    if (value != '' && re.test(value)) {
        document.getElementById(successField).style.display = 'block';
        document.getElementById(errorField).style.display = 'none';
        return true;
    } else {
        document.getElementById(successField).style.display = 'none';
        document.getElementById(errorField).style.display = 'block';
        return false;
    }
}

 function SimulateSubmit1(){
	var email = document.getElementById("Test2");
	localStorage.setItem("Test2", Test2.value);
	
	if (validateEmail('Test2')===false)
		return false;
}
