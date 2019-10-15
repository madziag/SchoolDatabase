<?php
 session_start();

 if(isset($_SESSION['post_sr'])){

 	$studentID =  $_GET['studentID'];
  	$sql = "Select * from students where student_id = " . $studentID;

  	$servername = 'localhost';
	$username = 'MadziaG';
	$password = 'P$i@krew2018User';
	$dbname = 'englishschooldb';

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

  	$result = $conn->query($sql) or trigger_error($conn->error);
  	$row = $result->fetch_array(MYSQLI_BOTH);

	echo " Name: " . $row["first_name"] . " " . $row["last_name"] . "<br \>";
	echo "Address: " . $row["street_address"] . " " . $row["address_code"]. " " . $row["town"] . "<br \>";
	echo "Contact: "  . $row["email"] .  " " . $row["phone_main"]  . " " . $row["phone_alt"] . "<br \>";
    echo "Status: " . $row["inactive"];
 	}

 if(isset($_SESSION['post_insert'])){
  	$_POST =  $_SESSION['post_insert'];
 	}

if(empty($action)){
	$action = "CheckBlankContract.php?studentID=" . $studentID;
	}

$checked1 = 'checked = \"checked\"';
$day = date("d");
$month = date('m');
$year = date('Y');
$selectedSemester = "";

if($month < 2 or $month > 9 or ($month == 9 and $day > 1)){
	$selectedFeb = 'selected = \"selected\"';
 	$selectedSept = '';
  	$selectedSemester = '2-';
} else {
   	$selectedFeb = '';
   	$selectedSept = 'selected = \"selected\"';
   	$selectedSemester = '9-';
}

if($month < 9 or ($month == 9 and $day == 1)){
	$selectedSemester = $selectedSemester . $year;
} else {
	$selectedSemester = $selectedSemester . ($year + 1);
}

$selected19 = '';
$selected20 = '';
$selected21 = '';
$selected22 = '';
$selected23 = '';
$selected24 = '';
$selected25 = '';
$selected26 = '';
$selected27 = '';
$selected28 = '';

if($year == 2019 and $month < 9){$selected19 = 'selected = \"selected\"';}
if(($year == 2019 and $month >= 9) or ($year == 2020 and $month < 9)){$selected20 = 'selected = \"selected\"';}
if(($year == 2020 and $month >= 9) or ($year == 2021 and $month < 9)){$selected21 = 'selected = \"selected\"';}
if(($year == 2021 and $month >= 9) or ($year == 2022 and $month < 9)){$selected22 = 'selected = \"selected\"';}
if(($year == 2022 and $month >= 9) or ($year == 2023 and $month < 9)){$selected23 = 'selected = \"selected\"';}
if(($year == 2023 and $month >= 9) or ($year == 2024 and $month < 9)){$selected24 = 'selected = \"selected\"';}
if(($year == 2024 and $month >= 9) or ($year == 2025 and $month < 9)){$selected25 = 'selected = \"selected\"';}
if(($year == 2025 and $month >= 9) or ($year == 2026 and $month < 9)){$selected26 = 'selected = \"selected\"';}
if(($year == 2026 and $month >= 9) or ($year == 2027 and $month < 9)){$selected27 = 'selected = \"selected\"';}
if(($year == 2027 and $month >= 9) or ($year == 2028 and $month < 9)){$selected28 = 'selected = \"selected\"';}

$sql = 'Select * from englishschooldb.locationgroupslevels';
$result = $conn->query($sql)or trigger_error($conn->error);

$resultArr = [];
$loc = [];

while($row = $result->fetch_assoc()) {
	$resultArr[] = $row;
}

session_destroy();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Create Contract</title>

<script language="javascript" type="text/javascript">
<!--

var result = <?php echo json_encode($resultArr, JSON_PRETTY_PRINT) ?>;

var loc = "";
var selSemester = "";

function sem() {
	var m = document.getElementById("month").options[document.getElementById("month").selectedIndex].value;
	var y = document.getElementById("year").options[document.getElementById("year").selectedIndex].value;

	if (m >= 2 && m <= 6){selSemester = '2-' + y;}
	else if (m >= 9){selSemester = '9-' + y;}
	else if (m == 1){
		var intYear = parseInt(y, 10);
		intYear = intYear - 1;
		selSemester = '9-' + intYear;
		}
	else (selSemester = "Undefined");

	document.getElementById("semDiv").innerHTML = selSemester;

	var locSet = locsOnSem();
	locBoxPopulate(locSet);
}

function locsOnSem() {
	var i;
	var locSet = new Set();

	for (i = 0; i < result.length; i++) {
		if (selSemester == result[i]["semester_start"]) {
			locSet.add(result[i]["location"] );
		}
	}
	return locSet;
}

 function locBoxPopulate(locSet) {
	//Clear Current options in locSelect
	document.form1.locSelect.options.length = 0;

	document.form1.locSelect.options[0] = new Option("Select Location", "");

	var i = 1;

	for (let loc of locSet) {
	  	document.form1.locSelect.options[i] = new Option(loc, loc);
	  	i++;
	}
	 return true;
}

 function locBoxChange(p_index) {
	 //Clear Current options in locSelect
	 document.form1.ageGroup.options.length = 0;
	 document.form1.levelSelect.options.length = 0;

	 document.form1.levelSelect.options[0] = new Option("Select Level", "");

	 selLoc = document.getElementById("locSelect").options[document.getElementById("locSelect").selectedIndex].value;

	 var i;
	 var ageSet = new Set();

	 for (i = 0; i < result.length; i++) {
	 	if (selSemester == result[i]["semester_start"] && selLoc == result[i]["location"]) {
	 		ageSet.add(result[i]["age_group"] );
	 	}
	 }

	 document.form1.ageGroup.options[0] = new Option("Select Age Group", "");
	 i = 1;

	 for (let age of ageSet) {
	 	document.form1.ageGroup.options[i] = new Option(age, age);
	 	i++;
	 }
	 return true;
}

 function ageGroupChange(p_index) {
	 //Clear Current options in levelSelect
	 document.form1.levelSelect.options.length = 0;

	 selAge = document.getElementById("ageGroup").options[document.getElementById("ageGroup").selectedIndex].value;

	 var i;
	 var levelSet = new Set();

	 for (i = 0; i < result.length; i++) {
	 	if (selSemester == result[i]["semester_start"] && selLoc == result[i]["location"] && selAge == result[i]["age_group"] ) {
	 		levelSet.add(result[i]["levels"] );
	 	}
	 }
	 document.form1.levelSelect.options[0] = new Option("Select Level", "");
	 i = 1;

	 for (let lev of levelSet) {
	 	document.form1.levelSelect.options[i] = new Option(lev, lev);
	 	i++;
	 }
	 return true;
 }
 -->
 </script>

 </head>
 <body onload="sem();">
 <form action= "<?php echo $action ?>"  method="post" id="form1" name="form1">

 <br /> <br />
   Start Date &nbsp;&nbsp;&nbsp;Day:
   		    <select name="day">
 			<option value="1">1</option>
 			<option value="2">2</option>
 			<option value="3">3</option>
 			<option value="4">4</option>
 			<option value="5">5</option>
 			<option value="6">6</option>
 			<option value="7">7</option>
 			<option value="8">8</option>
 			<option value="9">9</option>
 			<option value="10">10</option>
 			<option value="11">11</option>
 			<option value="12">12</option>
 			<option value="13">13</option>
 			<option value="14">14</option>
 			<option value="15">15</option>
 			<option value="16">16</option>
 			<option value="17">17</option>
 			<option value="18">18</option>
 			<option value="19">19</option>
 			<option value="20">20</option>
 			<option value="21">21</option>
 			<option value="22">22</option>
 			<option value="23">23</option>
 			<option value="24">24</option>
 			<option value="25">25</option>
 			<option value="26">26</option>
 			<option value="27">27</option>
 			<option value="28">28</option>
 			<option value="29">29</option>
 			<option value="30">30</option>
 			<option value="31">31</option>
             </select>

   &nbsp;&nbsp;&nbsp;Month:
 			<select name="month" id="month" onchange = "sem()">
 			<option value="1">January</option>
 			<option value="2" <?php echo $selectedFeb; ?>>February</option>
 			<option value="3">March</option>
 			<option value="4">April</option>
 			<option value="5">May</option>
 			<option value="6">June</option>
 			<option value="7">July</option>
 			<option value="8">August</option>
 			<option value="9" <?php echo $selectedSept; ?>>September</option>
 			<option value="10">October</option>
 			<option value="11">November</option>
 			<option value="12">December</option>
 			</select>

   &nbsp;&nbsp;&nbsp;Year:
 		    <select name="year" id="year" onchange = "sem()">
 			<option value="2019"<?php echo $selected19; ?>>2019</option>
 			<option value="2020"<?php echo $selected20; ?>>2020</option>
 			<option value="2021"<?php echo $selected21; ?>>2021</option>
 			<option value="2022"<?php echo $selected22; ?>>2022</option>
 			<option value="2023"<?php echo $selected23; ?>>2023</option>
 			<option value="2024"<?php echo $selected24; ?>>2024</option>
 			<option value="2025"<?php echo $selected25; ?>>2025</option>
 			<option value="2026"<?php echo $selected26; ?>>2026</option>
 			<option value="2027"<?php echo $selected27; ?>>2027</option>
 			<option value="2028"<?php echo $selected28; ?>>2028</option>
 			</select><br />

 <br />
    Selected Semester: <div id="semDiv"> <?php echo $selectedSemester;?> </div>
 <br /> <br />

 <select id = "locSelect" name="locSelect" onChange="javascript: locBoxChange(this.options[this.selectedIndex].value);"><option value="">Select Location</option></select>

 <script type="text/javascript" language="javascript">

 <!--
 document.write('<select id = "ageGroup" name="ageGroup" onChange="javascript: ageGroupChange(this.options[this.selectedIndex].value);"><option value="">Select Type</option></select>')
 -->
 </script>

 <script type="text/javascript" language="javascript">
 <!--
 document.write('<select id = "levelSelect" name="levelSelect"><option value="">Select Level</option></select>')
 -->
 </script>

<br />

<br />
 Payment Rate:
 		  <select name="rate">
 		  <option>not set</option>
 		  <option value="installments">installments</option>
 		  <option value="pay in full">pay in full</option>
 </select><br />

 Starter Pack:
 <input type="checkbox" name="starter" checked = "checked"> <br />


 Book:
 <input type="checkbox" name="book" checked = "checked"> <br />

<label>Comments</label>
          <textarea id = "comments"
          			name = "comments"
                  	rows = "3"
                  	cols = "80"
                  	style = "vertical-align: text-top;"> </textarea>

<br /><br />

 <input type="submit">

 </form>
 </body>
 </html>