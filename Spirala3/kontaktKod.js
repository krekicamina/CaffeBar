window.onload = function(){
  var ime = localStorage.getItem("Test3");
  var ime1 = document.getElementById("Test3");
  if (ime != null) ime1.value = ime;
  
  var email = localStorage.getItem("Test1");
  var email1 = document.getElementById("Test1");
  if (email != null) email1.value = email;
  
  var poruka = localStorage.getItem("Test4");
  var poruka1 = document.getElementById("Test4");
  if (poruka != null) poruka1.value = poruka;
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

 function validateName(field) { /*funkcija daje upozorenja ukoliko polje ime nije popunjeno i ako je pogresan format*/
    value = document.getElementById(field).value;
	var re = /^[a-zA-Z ]{2,30}$/;   
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

 function validateMessage(field) { /*funkcija daje upozorenja ukoliko polje poruka nije popunjeno*/
    value = document.getElementById(field).value;   
	errorField = field + 'Error';

    successField = field + 'Success';

    if (value != '') {
        document.getElementById(successField).style.display = 'block';
        document.getElementById(errorField).style.display = 'none';
        return true;
    } else {
        document.getElementById(successField).style.display = 'none';
        document.getElementById(errorField).style.display = 'block';
        return false;
    }
}


 function SimulateSubmit() { /*funkcija onemogucava klik na dugme posalji i omogucava local storage zadnje unesenih podataka*/ 
	var ime = document.getElementById("Test3");
	localStorage.setItem("Test3", Test3.value);
 
	var email = document.getElementById("Test1");
	localStorage.setItem("Test1", Test1.value);
  
	var poruka1 = document.getElementById("Test4");
	localStorage.setItem("Test4", Test4.value);
  
	if (validateName('Test3')===false)
		return false;
	if (validateEmail('Test1')===false)
		return false;
	if (validateMessage('Test4')===false)
		return false;
}