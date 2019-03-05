var qualiName = document.getElementById("qualiName");
var minScore = document.getElementById("minScore");
var maxScore = document.getElementById("maxScore");
var calculationType = document.getElementById("calculationType");
var numOfSubject = document.getElementById("numOfSubject");
var numOfGrade = document.getElementById("numOfGrade");
var errorMsg = document.getElementsByTagName("p");
var qualiName = minScore = maxScore = calculationType = numOfSubject = numOfGrade = false;
			
qualiName.onkeyup = function(){
	if (qualiName.value != ""){
		errorMsg[1].style.display = "none";
		qualiName.style.border = "1px solid lightgrey";
	}
}
			
//validate password to have at least 8 characters with 1 number, 1 uppercase & 1 lowercase
//else error message appear
minScore.onkeyup = function(){
	if (minScore.value != ""){
		errorMsg[2].style.display = "none";
		minScore.style.border = "1px solid lightgrey";
	}
	if (minScore.value.length<0)
		errorMsg[2].innerHTML = "&#10007<small> Minimum score should not smaller than 0</small>";
}
			
maxScore.onkeyup = function(){
	if (maxScore.value != ""){
		errorMsg[3].style.display = "none";
		maxScore.style.border = "1px solid lightgrey";
	}
}
			
function calculationTypeSelect(){
	if (calculationType.value != ""){
		errorMsg[4].style.display = "none";
		calculationType.style.border = "1px solid lightgrey";
	}
}

function numOfSubjectSelect(){
	if (numOfSubject.value != ""){
		errorMsg[5].style.display = "none";
		numOfSubject.style.border = "1px solid lightgrey";
	}
}

function numOfGradeSelect(){
	if (numOfGrade.value != ""){
		errorMsg[6].style.display = "none";
		numOfGrade.style.border = "1px solid lightgrey";
	}
}

//sign up function will be called when the sign up button clicked
function addQuali(){
	//check if the username is blank, if it is, display error message
	if (qualiName.value == ""){
		errorMsg[1].style.display = "block";
		qualiName.style.border = "1px solid red";
		invalidQualiName = true;
	}else
		invalidQualiName = false;
	
	//check if the confirmation password is blank, if it is, display error message
	if (minScore.value == ""){
		errorMsg[2].style.display = "block";
		minScore.style.border = "1px solid red";
		invalidMinScore = true;
	}else
		invalidMinScore = false;
	
	if (maxScore.value == ""){
		errorMsg[3].style.display = "block";
		maxScore.style.border = "1px solid red";
		invalidMaxScore = true;
	}else
		invalidMaxScore = false;
	
	//check if the id type is chosen
	if (calculationType.value == ""){
		errorMsg[4].style.display = "block";
		calculationType.style.border = "1px solid red";
		invalidCalculationType = true;
	}else
		invalidCalculationType = false;
	
	//check if the id number is blank
	if (numOfSubject.value == ""){
		errorMsg[5].style.display = "block";
		numOfSubject.style.border = "1px solid red";
		invalidCalculationType = true;
	}else
		invalidCalculationType = false;

	//check if the full name is blank
	if (numOfGrade.value == ""){
		errorMsg[6].style.display = "block";
		numOfGrade.style.border = "1px solid red";
		invalidNumOfGrade = true;
	}else
		invalidNumOfGrade = false;
	
	//alert("a"+ invalidUsername + "" + invalidPsw + "" + invalidCPsw + "" + invalidIDtype + "" + invalidIDno + "" + invalidName + "" +
	//invalidNationality + "" + invalidDOB + "" + invalidEmail + "" + invalidPhoneNo + "" + invalidAddress);
	invalid = [invalidQualiName, invalidMinScore, invalidMaxScore, invalidCalculationType, invalidNumOfSubject, invalidNumOfGrade];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}
