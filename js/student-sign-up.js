var username = document.getElementById("username");
var password = document.getElementById("psw");
var confirmPsw = document.getElementById("confirmPsw");
var idType = document.getElementById("idType");
var idNo = document.getElementById("idNo");
var fullname = document.getElementById("name");
var nationality = document.getElementById("nationality");
var dateOfBirth = document.getElementById("date");
var email = document.getElementById("email");
var phoneNo = document.getElementById("mobileNo");
var address = document.getElementById("address");
var errorMsg = document.getElementsByTagName("p");
var invalidUsername = invalidPsw = invalidCPsw = invalidIDtype = invalidIDno = invalidName = false;
var invalidNationality = invalidDOB = invalidEmail = invalidPhoneNo = invalidAddress = false;
			
username.onkeyup = function(){
	if (username.value != ""){
		errorMsg[1].style.display = "none";
		username.style.border = "1px solid lightgrey";
	}
}
			
//validate password to have at least 8 characters with 1 number, 1 uppercase & 1 lowercase
//else error message appear
var regexPsw = /[A-Za-z]+/;
var regexPsw2 = /[0-9]+/;
var regexPsw3 = /\w{6,}/;
password.onkeyup = function(){
	invalidPsw = !regexPsw.test(password.value) || !regexPsw2.test(password.value) ||
	!regexPsw3.test(password.value)
	if (invalidPsw){
		if (password.value.length<6)
			errorMsg[2].innerHTML = "&#10007<small> Please use 6 characters or more for password</small>";
		else
			errorMsg[2].innerHTML = "&#10007<small> Choose a stronger password with a mix of letters and numbers</small>";
		errorMsg[2].style.color="red";
		password.style.border = "1px solid red";
		invalidPsw = true;
	}else {
		errorMsg[2].innerHTML = "<small>Use 6 or more characters with a mix of letters and numbers</small>";
		errorMsg[2].style.color="grey";
		password.style.border = "1px solid lightgrey";
		invalidPsw = false;
	}
}
//validate confirmation password to be the same with password
//else display error message
confirmPsw.onkeyup = function(){
	invalidCPsw = password.value != confirmPsw.value;
	if (invalidCPsw){
		errorMsg[3].innerHTML = "&#10007;<small> Those password didn't match. Try again</small>";
		errorMsg[3].style.display = "block";
		confirmPsw.style.border = "1px solid red";
		invalidCPsw = true;
	}else {
		errorMsg[3].style.display = "none";
		confirmPsw.style.border = "1px solid lightgrey";
		invalidCPsw = false;
	}
}
			
idNo.onkeyup = function(){
	if (idNo.value != ""){
		errorMsg[5].style.display = "none";
		idNo.style.border = "1px solid lightgrey";
	}
}
			
fullname.onkeyup = function(){
	if (fullname.value != ""){
		errorMsg[6].style.display = "none";
		fullname.style.border = "1px solid lightgrey";
	}
}
			
nationality.onkeyup = function(){
	if (nationality.value != ""){
		errorMsg[7].style.display = "none";
		nationality.style.border = "1px solid lightgrey";
	}
}
			
var regexEmail = /.com$/;
var regexEmail2 = /@{1}[a-z]+/;
email.onkeyup = function(){
	if (!regexEmail.test(email.value) || !regexEmail2.test(email.value)){
		errorMsg[9].innerHTML = "&#10007<small> Please follow the format example@email.com</small>";
		errorMsg[9].style.color = "red";
		email.style.border = "1px solid red";
		invalidEmail = true;
	}else{
		errorMsg[9].innerHTML = "<small>Use the format example@email.com</small>";
		errorMsg[9].style.color = "grey";
		email.style.border = "1px solid lightgrey";
		invalidEmail = false;
	}
}

//validate phone number to follow format else display error
	var regexPhoneNo = /[0-9]{3}-[0-9]{7,}/;
	phoneNo.onkeyup = function(){
	invalidPhoneNo = !regexPhoneNo.test(phoneNo.value);
	if (invalidPhoneNo){
		errorMsg[10].innerHTML = "&#10007<small> Please follow the format xxx-xxxxxxx</small>";
		errorMsg[10].style.color="red";
		phoneNo.style.border = "1px solid red";
		invalidPhoneNo = true;
	}else{
		errorMsg[10].innerHTML = "<small>Use the format XXX-XXXXXXX</small>";
		errorMsg[10].style.color = "grey";
		phoneNo.style.border = "1px solid lightgrey";
		invalidPhoneNo = false;
	}
}
			
address.onkeyup = function(){
	if (address.value != ""){
		errorMsg[11].innerHTML = "";
		address.style.border = "1px solid lightgrey";
	}
}
			
function idTypeSelect(){
	if (idType.value != ""){
		errorMsg[4].style.display = "none";
		idType.style.border = "1px solid lightgrey";
	}
}
			
function dateSelect(){
	if (dateOfBirth.value != ""){
		errorMsg[8].style.display = "none";
		dateOfBirth.style.border = "1px solid lightgrey";
	}
}

//sign up function will be called when the sign up button clicked
function signUp(){
	//check if the username is blank, if it is, display error message
	if (username.value == ""){
		errorMsg[1].style.display = "block";
		username.style.border = "1px solid red";
		invalidUsername = true;
	}else
		invalidUsername = false;
	//check if the password is blank, if it is, display error message
	if (password.value == ""){
		errorMsg[2].innerHTML = "&#10007<small> Please enter password</small>";
		errorMsg[2].style.color="red";
		errorMsg[2].style.display = "block";
		password.style.border = "1px solid red";
		invalidPsw = true;
	}
	//check if the confirmation password is blank, if it is, display error message
	if (confirmPsw.value == ""){
		errorMsg[3].innerHTML = "&#10007;<small> Please enter confirm password</small>";
		errorMsg[3].style.display = "block";
		confirmPsw.style.border = "1px solid red";
		invalidCPsw = true;
	}
	//check if the id type is chosen
	if (idType.value == ""){
		errorMsg[4].style.display = "block";
		idType.style.border = "1px solid red";
		invalidIDtype = true;
	}else
		invalidIDtype = false;
	//check if the id number is blank
	if (idNo.value == ""){
		errorMsg[5].style.display = "block";
		idNo.style.border = "1px solid red";
		invalidIDno = true;
	}else
		invalidIDno = false;
	//check if the full name is blank
	if (fullname.value == ""){
		errorMsg[6].style.display = "block";
		fullname.style.border = "1px solid red";
		invalidName = true;
	}else
		invalidName = false;
	//check if the nationality is blank
	if (nationality.value == ""){
		errorMsg[7].style.display = "block";
		nationality.style.border = "1px solid red";
		invalidNationality = true;
	}else
		invalidNationality = false;
	if (dateOfBirth.value == ""){
		errorMsg[8].style.display = "block";
		dateOfBirth.style.border = "1px solid red";
		invalidDOB = true;
	}else
		invalidDOB = false;
	if (email.value == ""){
		errorMsg[9].innerHTML = "&#10007<small> Please enter email address</small>";
		errorMsg[9].style.color="red";
		email.style.border = "1px solid red";
		invalidEmail = true;
	}
	//check if phone number is blank
	if (phoneNo.value == ""){
		errorMsg[10].innerHTML = "&#10007<small> Please enter mobile number</small>";
		errorMsg[10].style.color="red";
		phoneNo.style.border = "1px solid red";
		invalidPhoneNo = true;
	}
	//check if address is blank
	if (address.value == ""){
		errorMsg[11].style.display = "block";
		address.style.border = "1px solid red";
		invalidAddress = true;
	}else
		invalidAddress = false;
	//alert("a"+ invalidUsername + "" + invalidPsw + "" + invalidCPsw + "" + invalidIDtype + "" + invalidIDno + "" + invalidName + "" +
	//invalidNationality + "" + invalidDOB + "" + invalidEmail + "" + invalidPhoneNo + "" + invalidAddress);
	invalid = [invalidUsername, invalidPsw, invalidCPsw, invalidIDtype, invalidIDno, invalidName, invalidNationality,
	invalidDOB, invalidEmail, invalidPhoneNo, invalidAddress];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}
