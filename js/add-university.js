var uniName = document.getElementById("uniName");
var description = document.getElementById("description");
var img = document.getElementById("uniImg");
var errorMsg = document.getElementsByTagName("p");
var invalidUniName = invalidDescription = invalidImg = false;
			
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
	//alert("a"+ invalidUsername + "" + invalidPsw + "" + invalidCPsw + "" + invalidIDtype + "" + invalidIDno + "" + invalidName + "" +
	//invalidNationality + "" + invalidDOB + "" + invalidEmail + "" + invalidPhoneNo + "" + invalidAddress);
	//alert("" + invalidImg);
	invalid = [invalidUniName, invalidDescription, invalidImg];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}
