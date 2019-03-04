var uniName = document.getElementById("uniName");
var description = document.getElementById("description");
var adminNo = document.getElementById("adminNo");
var errorMsg = document.getElementsByTagName("p");
var invalidUniName = invalidDescription  = invalidAdminNo = false;
			
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
			
function idTypeSelect(){
	if (adminNo.value != ""){
		errorMsg[3].style.display = "none";
		adminNo.style.border = "1px solid lightgrey";
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

	//check if the number of admin is chosen
	if (adminNo.value == ""){
		errorMsg[3].style.display = "block";
		adminNo.style.border = "1px solid red";
		invalidAdminNo = true;
	}else
		invalidAdminNo = false;

	//alert("a"+ invalidUsername + "" + invalidPsw + "" + invalidCPsw + "" + invalidIDtype + "" + invalidIDno + "" + invalidName + "" +
	//invalidNationality + "" + invalidDOB + "" + invalidEmail + "" + invalidPhoneNo + "" + invalidAddress);
	invalid = [invalidUniName, invalidDescription, invalidAdminNo];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}
