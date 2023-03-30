var uniName = document.getElementById("uniName");
var description = document.getElementById("description");
var img = document.getElementById("uniImg");
var uniAdminUsername = document.getElementById("uniAdminUsername");
var uniAdminPassword = document.getElementById("uniAdminPassword");
var errorMsg = document.getElementsByTagName("p");
var button = document.getElementsByClassName("btn");
var invalidUniName = invalidDescription = invalidImg = invalidUniAdminUsername = invalidUniAdminPassword = false;
			
function addAdmin(){
	var parentBox = document.getElementsByTagName("Form")[0];
	var addButton = button[0];
	var div = document.createElement("div");
	div.classList.add("row");
	div.innerHTML = '<div class="col-lg-6 form-group"><input type="text" id="uniAdminUsername" name="admin[]" placeholder="Admin Username*" class = "form-control"></div><div class="col-lg-6 form-group"><input type="password" id="uniAdminPassword" name="adminPsw[]" placeholder="Admin Password*" class = "form-control"></div>';
	parentBox.insertBefore(div,addButton);
}

uniName.onkeyup = function(){
	if (uniName.value != ""){
		errorMsg[1].style.display = "none";
		uniName.style.border = "1px solid lightgrey";
	}
}

description.onkeyup = function(){
	if (description.value != ""){
		errorMsg[2].style.display = "none";
		description.style.border = "1px solid lightgrey";
	}
}
			
var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;		
function imgValidation(){
	if (!allowedExtensions.test(img.value)){
		errorMsg[3].innerHTML = "&#10007;<small> Please upload image file having extension .jpeg/.jpg/.png/.gif only</small>";
		errorMsg[3].style.display = "block";
		img.style.border = "1px solid red";
		invalidImg = true;
	}else{
		errorMsg[3].style.display = "none";
		img.style.border = "1px solid lightgrey";
		invalidImg = false;
	}
}

uniAdminUsername.onkeyup = function(){
	if (uniAdminUsername.value != ""){
		errorMsg[4].style.display = "none";
		uniAdminUsername.style.border = "1px solid lightgrey";
	}
}

uniAdminPassword.onkeyup = function(){
	if (uniAdminPassword.value != ""){
		errorMsg[5].style.display = "none";
		uniAdminPassword.style.border = "1px solid lightgrey";
	}
}

//addUni function will be called when the next button is clicked
function addUni(){
	//check if the university name is blank, if it is, display error message
	if (uniName.value == ""){
		errorMsg[1].style.display = "block";
		uniName.style.border = "1px solid red";
		invalidUniName = true;
	}else
		invalidUniName = false;

	//check if the description is blank, if it is, display error message
	if (description.value == ""){
		errorMsg[2].style.display = "block";
		description.style.border = "1px solid red";
		invalidDescription = true;
	}else
		invalidDescription = false;
	
	if (img.value == ""){
		invalidImg = true;
		errorMsg[3].innerHTML = "&#10007;<small> Please upload an university image</small>";
		errorMsg[3].style.display = "block";
		img.style.border = "1px solid red";
	}
	
	if (uniAdminUsername.value == ""){
		errorMsg[4].style.display = "block";
		uniAdminUsername.style.border = "1px solid red";
		invalidUniAdminUsername = true;
	}else
		invalidUniAdminUsername = false;
	
	if (uniAdminPassword.value == ""){
		errorMsg[5].style.display = "block";
		uniAdminPassword.style.border = "1px solid red";
		invalidUniAdminPassword = true;
	}else
		invalidUniAdminPassword = false;
	
	//alert("a"+ invalidUsername + "" + invalidPsw + "" + invalidCPsw + "" + invalidIDtype + "" + invalidIDno + "" + invalidName + "" +
	//invalidNationality + "" + invalidDOB + "" + invalidEmail + "" + invalidPhoneNo + "" + invalidAddress);
	//alert("" + invalidImg);
	invalid = [invalidUniName, invalidDescription, invalidImg, invalidUniAdminUsername, invalidUniAdminPassword];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}
