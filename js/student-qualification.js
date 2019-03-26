
var qualification = document.getElementsByTagName("Select")[0];
var subject = document.getElementsByClassName("subject");
var grade = document.getElementsByClassName("grade");
var errorMsg = document.getElementsByTagName("p");
var invalidQualification = invalidSubject = invalidResult = false;
function addSubject(){
	var parentBox = document.getElementsByTagName("Form")[0];
	var addButton = document.getElementsByClassName("errorMsg")[8];
	var div = document.createElement("div");
	div.classList.add("row");
	div.innerHTML = '<div class="col-lg-6 form-group"><input type="text" id="subject" name="subject[]" placeholder="Subject*" class = "form-control"></div><div class="col-lg-6 form-group"><input type="text" id="grade" name="grade[]" placeholder="Result*" class = "form-control"></div>';
	parentBox.insertBefore(div,addButton);
}
		
function qSelect(){
	if (qualification.value != ""){
		errorMsg[1].style.display = "none";
		qualification.style.border = "1px solid lightgrey";
	}
}
for (var j = 0; j < 3; j++){
	addKeyUpForSubject(j);
	addKeyUpForGrade(j);
}
		
function addKeyUpForSubject(p){
	subject[p].onkeyup = function(){
		if (subject[p].value != ""){
			errorMsg[(p+1)*2].style.display = "none";
			subject[p].style.border = "1px solid lightgrey";
		}
	}
}
			
function addKeyUpForGrade(k){
	grade[k].onkeyup = function(){
		if (grade[k].value != ""){
			errorMsg[((k+1)*2)+1].style.display = "none";
			grade[k].style.border = "1px solid lightgrey";
		}
	}
}
function signUp(){
	if (qualification.value == ""){
		errorMsg[1].style.display = "block";
		qualification.style.border = "1px solid red";
		invalidQualification = true;
	}else{
		invalidQualification = false;
	}
	var focusNum = -1;
	for (var i = 0; i < 3; i++){
		if (subject[i].value == ""){
			errorMsg[(i+1)*2].style.display = "block";
			subject[i].style.border = "1px solid red";
			invalidSubject = true;
			if (focusNum == -1)
				focusNum = focusNum + ((i+1)*2);
		}
		if (grade[i].value == ""){
			errorMsg[((i+1)*2)+1].style.display = "block";
			grade[i].style.border = "1px solid red";
			invalidResult = true;
			if (focusNum == -1)
				focusNum = focusNum + (((i+1)*2)+1);
		}
	}
			
	invalid = [invalidQualification, invalidSubject, invalidResult];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			if (i > 0)
				document.getElementsByClassName("form-control")[focusNum].focus();
			else
				document.getElementsByClassName("form-control")[i].focus();
			invalidSubject = invalidResult = false;
			focusNum = -1;
			return false;
		}
	}
}