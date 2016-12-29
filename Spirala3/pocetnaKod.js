window.onload = function(){
  var email = localStorage.getItem("Test2");
  var email1 = document.getElementById("Test2");
  if (email != null) email1.value = email;
  
  var username1 = localStorage.getItem("username");
  var username2 = document.getElementById("username");
  if (username1 != null) username2.value = username1;

  var password10 = localStorage.getItem("password1");
  var password11 = document.getElementById("password1");
  if (password10 != null) password11.value = password10;
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

 function validateUsername(field) { 
    value = document.getElementById(field).value;
	var re = /^[a-zA-Z0-9]+$/;  
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

 function validatePassword(field) { 
    value = document.getElementById(field).value;
	var re = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; /*minimalno 8 karaktera, 1 slovo i 1 broj*/
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

 function SimulateSubmit3() { /*funkcija onemogucava klik na dugme login i omogucava local storage zadnje unesenih podataka*/ 
	var username2 = document.getElementById("username");
	localStorage.setItem("username", username.value);
 
	var password2 = document.getElementById("password1");
	localStorage.setItem("password1", password2.value);
  
	if (validatePassword('password1')===false)
		return false;
	if (validateUsername('username')===false)
		return false;
}

/*search*/
function prikaziRezultate(tekst){
	document.getElementById("divzaprikazpretrage").innerHTML = tekst;
}

function prikazi(str) {
  if (str.length==0) { 
    document.getElementById("prikazpretrage").innerHTML="";
    document.getElementById("prikazpretrage").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // kod za IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // kod za IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("prikazpretrage").innerHTML=this.responseText;
      document.getElementById("prikazpretrage").style.border="3px solid #E2DD91;";
    }
  }
  xmlhttp.open("GET","pretraga.php?q="+str,true);
  xmlhttp.send();
}