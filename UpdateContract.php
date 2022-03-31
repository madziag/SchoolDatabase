<?php

 session_start();

 $studentID =  $_GET['studentID'];
 $contractID =  $_GET['contractID'];

 $servername = 'localhost';
 $username = 'MadziaG';
 $password = 'P$i@krew2018User';
 $dbname = 'englishschooldb';


 // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
     if ($conn->connect_error) {
  	   die("Connection failed: " . $conn->connect_error);
    }

   $sql = "SELECT * from englishschooldb.contracts where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";
   $sql_student = "SELECT first_name, last_name  from englishschooldb.students where student_id = " . $studentID . ";";
   $sql_guardian = "SELECT guardian_first_name, guardian_last_name from englishschooldb.guardians join englishschooldb.student_guardian on guardians.guardian_id = student_guardian.guardian_id where student_id = " . $studentID . ";";

   $result = $conn->query($sql) or trigger_error($conn->error);
   $row = $result->fetch_array(MYSQLI_BOTH);

   $result2 = $conn->query($sql_student) or trigger_error($conn->error);
   $row2 = $result2->fetch_array(MYSQLI_BOTH);

   $result3 = $conn->query($sql_guardian) or trigger_error($conn->error);
   $row3 = $result3->fetch_array(MYSQLI_BOTH);

   $action =  "ExecuteUpdateContract.php?studentID=" . $studentID."&contractID=" . $contractID;
   $school_year = strval($row["school_year"]);
   echo $school_year;
   
   $sql_lgl = 'Select * from englishschooldb.locationgroupslevels';
   $result_lgl = $conn->query($sql_lgl)or trigger_error($conn->error);

   $resultArr = [];
   
   while($row_lgl = $result_lgl->fetch_assoc()) {
	$resultArr[] = $row_lgl;
   }
	
 ?>

<html>
<head>
<style>
</style>

</head>

  <body onload="school_year();">

   <form action= "<?php echo $action ?>"  method="post" id="form1" name="form1">

  <?php echo "Name: " . $row2["first_name"] . " " . $row2["last_name"]; ?><br/><br/>

  

 <br />
    Selected School Year: <div id="schoolYearDiv"> </div>
 <br /> <br />

    
	Contract Start Date: <input type="text" name="contractStartDate" value="<?php echo $row["start_date"] ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date must be in YYYY-MM-DD format</em><br />
    School Year: <input type="text" onchange = "school_year()" name="schoolYear" id="schoolYear" value="<?php echo $school_year ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date must be in YYYY-YYYY format</em><br />
	Description: <select id = "descriptionSelect" name="descriptionSelect"><option value="<?php echo $row["class_description"] ?>">Select Description</option></select>
	Rate: <input type="text" name="rate" value="<?php echo $row["payment_type"] ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rates must be </em> not set <em>, </em> pay in full <em>or</em> installments<br />
    Number of Payments: <input type="text" name="nrpayments" value="<?php echo $row["nrpayments"] ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Payments must be numeric</em><br />
    Starter Pack:
   <input type="radio" name="starter" value = "Yes"
   <?php echo ($row["starter"] == 1) ? 'checked = "checked"': ''; ?> /> Yes
   <input type="radio" name="starter" value = "No"
   <?php echo ($row["starter"] == 0) ? 'checked = "checked"': ''; ?> /> No
   <br />
   Book:
   <input type="radio" name="book" value = "Yes"
   <?php echo ($row["book"] == 1) ? 'checked = "checked"': ''; ?> /> Yes
   <input type="radio" name="book" value = "No"
   <?php echo ($row["book"] == 0) ? 'checked = "checked"': ''; ?> /> No
   <br />
    <br />
    Comments: <input type="text" name="comments" value="<?php echo $row["comments"] ?>"><br />
    <br />
   <br /><br /><br />
   <input type="submit" name = "update" value = "Update Contract">

   </form>
   <script language="javascript" type="text/javascript">


var result = <?php echo json_encode($resultArr, JSON_PRETTY_PRINT) ?>;
var selectedDescription = <?php echo json_encode($row["class_description"], JSON_PRETTY_PRINT) ?>;

var description = "";
var school_year = "";

function create_school_year() {

    var school_year = document.getElementById("schoolYear").value;

	document.getElementById("schoolYearDiv").innerHTML = school_year;
	var descriptionSet = descriptionsOnSchoolYear(school_year);
	descriptionBoxPopulate(descriptionSet);
}


function descriptionsOnSchoolYear(school_year_local) {
	var i;
	var descriptionSet = new Set();
	
	for (i = 0; i < result.length; i++) {
		if (school_year_local == result[i]["school_year"]) {
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
    document.querySelector('#descriptionSelect').value = selectedDescription;
	 return true;
}


document.body.onload = function(){
      create_school_year();
  }


 </script>

</body>
</html>

