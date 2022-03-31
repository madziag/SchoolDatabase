var result = <?php echo json_encode($resultArr, JSON_PRETTY_PRINT) ?>;

var description = "";
var selSchoolYear = "";

function school_year() {
	var m = document.getElementById("month").options[document.getElementById("month").selectedIndex].value;
  	var y = document.getElementById("year").options[document.getElementById("year").selectedIndex].value;
    var nexty = parseInt(y, 10) + 1;
    var lasty = parseInt(y, 10) - 1;

	if (m >= 7 && m <= 12){selSchoolYear = y + '-' + nexty;}
	else if (m < 7) {selSchoolYear = lasty + '-' + y;}
	else (selSchoolYear = "Undefined");

	document.getElementById("schoolYearDiv").innerHTML = selSchoolYear;

	var descriptionSet = descriptionsOnSchoolYear();
	descriptionBoxPopulate(descriptionSet);
}

function descriptionsOnSchoolYear() {
	var i;
	var descriptionSet = new Set();

	for (i = 0; i < result.length; i++) {
		if (selSchoolYear == result[i]["school_year"]) {
			descriptionSet.add(result[i]["class_description"] );
		}
	}
	return descriptionSet;
}

 function descriptionBoxPopulate(descriptionSet) {
	//Clear Current options in descriptionSelect
	document.form1.descriptionSelect.options.length = 0;

	document.form1.descriptionSelect.options[0] = new Option("Select description", "");

	var i = 1;

	for (let description of descriptionSet) {
	  	document.form1.descriptionSelect.options[i] = new Option(description, description);
	  	i++;
	}
	 return true;
}
 function submitWithSchoolYear() {
    var form = document.getElementById('form1');//retrieve the form as a DOM element
    var school_year = document.createElement('input');//prepare a new input DOM element
	
    school_year.setAttribute('name', "SchoolYear");//set the param name
    school_year.setAttribute('value', selSchoolYear);//set the value
    school_year.setAttribute('type', "hidden")//set the type, like "hidden" or other

    form.appendChild(school_year);//append the input to the form

    form.submit();//send with added input
 }
 
