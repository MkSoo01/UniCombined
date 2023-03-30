var username = document.getElementById("username");
var password = document.getElementById("password");
var errorMsg = document.getElementsByClassName("errorMsg");

username.onkeyup = function(){
	if (username.value != ""){
		errorMsg[0].style.display = "none";
		username.style.border = "1px solid lightgrey";
	}
}

password.onkeyup = function(){
	if (password.value != ""){
		errorMsg[1].style.display = "none";
		password.style.border = "1px solid lightgrey";
	}
}
	
function signIn(){
	var invalidUsername = invalidPassword = false;
	if (username.value == ""){
		errorMsg[0].style.display = "block";
		username.style.border = "1px solid red";
		invalidUsername = true;
	}else
		invalidUsername = false;
	if (password.value == ""){
		errorMsg[1].style.display = "block";
		password.style.border = "1px solid red";
		invalidPassword = true;
	}else
		invalidPassword = false;
	invalid = [invalidUsername, invalidPassword];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}