var qualification = document.getElementsByTagName("Select");
var progName = document.getElementById("progName");
var progDesc = document.getElementById("progDesc");
var closingDate = document.getElementById("closingDate");
var img = document.getElementById("progImg");
var entryScore = document.getElementsByClassName("entryScore");
var errorMsg = document.getElementsByClassName("errorMsg");
var button = document.getElementsByClassName("btn");
var invalidProgName = invalidProgDesc = invalidClosingDate = invalidImg = invalidQualification = invalidEntryScore = false;
var qualificationOption = document.getElementsByTagName("Option");
var optionStr = "";

for (num = 0; num < qualificationOption.length; num++){
	optionStr = optionStr + "<option value = '" + qualificationOption[num].innerHTML + "'>" +
	qualificationOption[num].innerHTML+ "</option>";
}

function addEntryReq(){
	var parentBox = document.getElementsByTagName("Form")[0];
	var addButton = button[0];
	var div = document.createElement("div");
	div.classList.add("row");
	div.innerHTML = '<div class="col-lg-6 form-group"><select name="qualification[]" class = "form-control minimal">'+
	optionStr+'</select></div><div class="col-lg-6 form-group"><input type="text" name="entryScore[]" placeholder="EntryScore*" class = "form-control"></div>';
	parentBox.insertBefore(div,addButton);
}
		
function qSelect(){
	if (qualification[0].value != ""){
		errorMsg[4].style.display = "none";
		qualification[0].style.border = "1px solid lightgrey";
	}
}

function selectDate(){
	if (closingDate.value != ""){
		errorMsg[2].style.display = "none";
		closingDate.style.border = "1px solid lightgrey";
	}
}

progName.onkeyup = function(){
	if (progName.value != ""){
		errorMsg[0].style.display = "none";
		progName.style.border = "1px solid lightgrey";
	}
}

progDesc.onkeyup = function(){
	if (progDesc.value != ""){
		errorMsg[1].style.display = "none";
		progDesc.style.border = "1px solid lightgrey";
	}
}

entryScore[0].onkeyup = function(){
	if (entryScore[0].value != ""){
		errorMsg[5].style.display = "none";
		entryScore[0].style.border = "1px solid lightgrey";
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

function submitProgramme(){
	if (progName.value == ""){
		errorMsg[0].style.display = "block";
		progName.style.border = "1px solid red";
		invalidProgName = true;
	}else
		invalidProgName = false;
	if (progDesc.value == ""){
		errorMsg[1].style.display = "block";
		progDesc.style.border = "1px solid red";
		invalidProgDesc = true;
	}else
		invalidProgDesc = false;
	if (closingDate.value == ""){
		errorMsg[2].style.display = "block";
		closingDate.style.border = "1px solid red";
		invalidClosingDate = true;
	}else
		invalidClosingDate = false;
	
	if (img.value == ""){
		invalidImg = true;
		errorMsg[3].innerHTML = "&#10007;<small> Please upload a programme image</small>";
		errorMsg[3].style.display = "block";
		img.style.border = "1px solid red";
	}
	
	if (qualification[0].value == ""){
		errorMsg[4].style.display = "block";
		qualification[0].style.border = "1px solid red";
		invalidQualification = true;
	}else{
		invalidQualification = false;
	}
	
	if (entryScore[0].value == ""){
		errorMsg[5].style.display = "block";
		entryScore[0].style.border = "1px solid red";
		invalidEntryScore = true;
	}else{
		invalidEntryScore = false;
	}
			
	invalid = [invalidProgName, invalidProgDesc, invalidClosingDate, invalidImg, invalidQualification, invalidEntryScore];
	for ( i = 0 ; i < invalid.length; i++){
		if (invalid[i]){
			document.getElementsByClassName("form-control")[i].focus();
			return false;
		}
	}
}