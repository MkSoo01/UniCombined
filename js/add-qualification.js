var qualiName = document.getElementById("qualiName");
var minScore = document.getElementById("minScore");
var maxScore = document.getElementById("maxScore");
var calculationType = document.getElementById("calculationType");
var numOfSubject = document.getElementById("numOfSubject");
var errorMsg = document.getElementsByTagName("p");
var invalidQualiName = invalidMinScore = invalidMaxScore = invalidCalculationType = invalidNumOfSubject = false;			

qualiName.onkeyup = function(){
	if (qualiName.value != ""){
		errorMsg[1].style.display = "none";
		qualiName.style.border = "1px solid lightgrey";
	}
}

function minScoreSelect(){
	if (minScore.value != ""){
		errorMsg[2].style.display = "none";
		minScore.style.border = "1px solid lightgrey";
	}
	if (minScore.value.length<0)
		errorMsg[2].innerHTML = "&#10007<small> Minimum score should not smaller than 0</small>";
}
			
function maxScoreSelect(){
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

function addGrade(){
	var parentBox = document.getElementsByTagName("Form")[0];
	var addButton = document.getElementsByClassName("errorMsg")[5];
	var div = document.createElement("div");
	div.classList.add("row");
	div.innerHTML = '<div class="col-lg-6 form-group"><input type="text" id="subject" name="grade[]" placeholder="Subject Grade*" class = "form-control"></div><div class="col-lg-6 form-group"><input type="text" id="grade" name="gradePoint[]" placeholder="Subject Grade Point (SGP)*" class = "form-control"></div>';
	parentBox.insertBefore(div,addButton);
}

//sign up function will be called when the sign up button clicked
function addQuali(){
	//check if the qualification name is blank
	if (qualiName.value == ""){
		errorMsg[1].style.display = "block";
		qualiName.style.border = "1px solid red";
		invalidQualiName = true;
	}else
		invalidQualiName = false;
	
	//check if the minimum score is blank
	if (minScore.value == ""){
		errorMsg[2].style.display = "block";
		minScore.style.border = "1px solid red";
		invalidMinScore = true;
	}else
		invalidMinScore = false;
	
	//check if the maximum score is blank
	if (maxScore.value == ""){
		errorMsg[3].style.display = "block";
		maxScore.style.border = "1px solid red";
		invalidMaxScore = true;
	}else
		invalidMaxScore = false;
	
	//check if the calculation type is chosen
	if (calculationType.value == ""){
		errorMsg[4].style.display = "block";
		calculationType.style.border = "1px solid red";
		invalidCalculationType = true;
	}else
		invalidCalculationType = false;
	
	//check if the number of subject is blank
	if (numOfSubject.value == ""){
		errorMsg[5].style.display = "block";
		numOfSubject.style.border = "1px solid red";
		invalidNumOfSubject = true;
	}else
		invalidNumOfSubject = false;

	
	//alert("a"+ invalidQualiName + "" + invalidMinScore + "" + invalidMaxScore + "" + invalidCalculationType + "" + invalidNumOfSubject + "" + invalidNumOfGrade + "");
	invalid = [invalidQualiName, invalidMinScore, invalidMaxScore, invalidCalculationType, invalidNumOfSubject];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}
