<?php
	//Creates/updates form - to be called by CreateContract.php & UpdateContract.php
	
	session_start();
	
	$servername = 'localhost';
	$username = 'MadziaG';
	$password = 'P$i@krew2018User';
	$dbname = 'englishschooldb';
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
	
	//student id
	$studentID =  $_GET['studentID'];
	
	//gets contract id if exists
	if (isset($_GET['contractID'])){$contractID =  $_GET['contractID'];}
	
	//gets post data
	if(isset($_SESSION['post_insert'])){$_POST =  $_SESSION['post_insert'];}
	
	//queries db for student info
	$sql = "Select * from students where student_id = " . $studentID;
	$result = $conn->query($sql) or trigger_error($conn->error);
	$row = $result->fetch_array(MYSQLI_BOTH);
	
	//creates empty array for contracts
    $resultArr_contract = [];
	
	//queries using student id/contract id
	if(isset($contractID)){
		$sql_contract = "SELECT * from englishschooldb.contracts where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";
        $result_contract = $conn->query($sql_contract) or trigger_error($conn->error);
		//TODO: DO WE NEED THIS WHILE LOOP AS ONLY ONE CONTRACT SHOULD BE RETURNED (query uses studentid and contractid)
		while($row_contract = $result_contract->fetch_assoc()) {
			$resultArr_contract[] = $row_contract;
		}
	}
	
	//print statements for user
	echo " Name: " . $row["first_name"] . " " . $row["last_name"] . "<br \>";
	echo "Address: " . $row["street_address"] . " " . $row["address_code"]. " " . $row["town"] . "<br \>";
	echo "Contact: "  . $row["email"] .  " " . $row["phone_main"]  . " " . $row["phone_alt"] . "<br \>";
	
	//$action is where the data is submitted to when submit button is pressed
	if(empty($action)){$action = "CheckBlankContract.php?studentID=" . $studentID;}
	
	//setting variables - start date (current date)
	$day = date("d");
	$month = date('m');
	$year = intval(date('Y'));
	$selectedSemester = "";
	
	//
	
	
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
	
	// REDO to format we use in UpdateClass.php
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
	
	
	// queries db to get the classes 
	$sql = 'Select * from englishschooldb.locationgroupslevels';
	$result = $conn->query($sql)or trigger_error($conn->error);
	
	// creates array for the class info (all)
	$resultArr_classes = [];
	
	while($row = $result->fetch_assoc()) {
		$resultArr_classes[] = $row;
	}
	
	session_destroy();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Create Contract</title>
		<script language="javascript" type="text/javascript">
			
			<!--
			//getting class list info from php to javascript
			var result_classes = <?php echo json_encode($resultArr_classes, JSON_PRETTY_PRINT) ?>;
			// getting contract info from php into javascript
			var result_contract = <?php echo json_encode($resultArr_contract, JSON_PRETTY_PRINT) ?>;
			var description = "";
			var selSchoolYear = "";
			
			// function determines selected school year 
			function school_year() {
			    //Gets value from month drop down 
				var m = document.getElementById("month").options[document.getElementById("month").selectedIndex].value;
				//Gets value from year drop down
				var y = document.getElementById("year").options[document.getElementById("year").selectedIndex].value;
				//creates previous and next year variables 
				var nexty = parseInt(y, 10) + 1;
				var lasty = parseInt(y, 10) - 1;
				//sets selected school year
				if (m >= 7 && m <= 12){selSchoolYear = y + '-' + nexty;}
				else if (m < 7) {selSchoolYear = lasty + '-' + y;}
				else (selSchoolYear = "Undefined");
                //puts selectedschoolyear on the screen
				document.getElementById("schoolYearDiv").innerHTML = selSchoolYear;
				//getting descriptions using a function (below)
				var descriptionSet = descriptionsOnSchoolYear();
				//populating description dropdown using function (below)
				descriptionBoxPopulate(descriptionSet);
				//getting the dropdown
				var class_description_dropdown = document.getElementById("descriptionSelect");
				//if editing a current contract we apply the description from that contract
				if(typeof result_contract[0] != 'undefined'){
					class_description_dropdown.value=result_contract[0]["class_description"];
					}
			
			}
			
			//gets descriptions of classes from the result variable 
			function descriptionsOnSchoolYear() {
				//counter
				var i;
				//creates container for the classes 
				var descriptionSet = new Set();
				
				//adds classes to descriptionset
				for (i = 0; i < result_classes.length; i++) {
					if (selSchoolYear == result_classes[i]["school_year"]) {
						descriptionSet.add(result_classes[i]["class_description"] );
					}
				}
				return descriptionSet;
			}
			
			// Functions populates description dropdown
			function descriptionBoxPopulate(descriptionSet) {
				//Clear Current options in descriptionSelect
				document.form1.descriptionSelect.options.length = 0;
				//sets first option to be empty
				document.form1.descriptionSelect.options[0] = new Option("Select description", "");
				//counter
				var i = 1;
				//actual populating of description box
				for (let description of descriptionSet) {
					document.form1.descriptionSelect.options[i] = new Option(description, description);
					document.form1.descriptionSelect.options[i].value = description;
					i++;
				}
				return true;
			}
			
			//creates an invisible dropdown box - user cannot update it - prevents from changing values in box 
			function submitWithSchoolYear() {
				var form = document.getElementById('form1');//retrieve the form as a DOM element
				var school_year = document.createElement('input');//prepare a new input DOM element
				
				school_year.setAttribute('name', "SchoolYear");//set the param name
				school_year.setAttribute('value', selSchoolYear);//set the value
				school_year.setAttribute('type', "hidden")//set the type, like "hidden" or other
				
				form.appendChild(school_year);//append the input to the form
				
				form.submit();//send with added input
			}
			-->
			
		</script>
	</head>
	<!-- Creates form - when the page loads, it runs school_year() -->
	<body onload="school_year();">
		<form action= "<?php echo $action ?>"  method="post" id="form1" name="form1">
			
			<br /> <br />
			Start Date &nbsp;&nbsp;&nbsp;Day:
   		    <select name="day" id="day">
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
 			<select name="month" id="month" onchange = "school_year()">
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
			
			&nbsp;&nbsp;&nbsp;Year:
 		    <select name="year" id="year" onchange = "school_year()">
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
			Selected School Year: <div id="schoolYearDiv"> </div>
			<br /> <br />
			
			<select id = "descriptionSelect" name="descriptionSelect"><option value="">Select Description</option></select>
			
			<br />
			
			<br />
			Payment Rate:
			<select name="rate" id="rate">
				<option>not set</option>
				<option value="installments">installments</option>
				<option value="pay in full">pay in full</option>
			</select><br />
			
			Starter Pack:
			<input type="checkbox" name="starter" id="starter" checked = "checked"> <br />
			
			
			Book:
			<input type="checkbox" name="book" id="book" checked = "checked"> <br />
			
			<label>Comments</label>
			<textarea id = "comments"
			name = "comments"
			rows = "3"
			cols = "80"
			style = "vertical-align: text-top;"> </textarea>
			
			<br /><br />
			
			<button onclick="submitWithSchoolYear()">Submit</button>
			
			
			
		</form>
		<script>
			
			// FOR UPDATING CONTRACTS!!!
			// Loads information from exsiting contract into the form 
			
			if(result_contract.length != 0){
			// setting contract start date
				var day_dropdown = document.getElementById("day");
				var month_dropdown = document.getElementById("month");
				var year_dropdown = document.getElementById("year");
				
				var start_date = result_contract[0]["start_date"];
	
				var contract_year = parseInt(start_date.substring(0, 4));
				var contract_month = parseInt(start_date.substring(5, 7));
				var contract_day = parseInt(start_date.substring(8, 10));
				
				day_dropdown.value = contract_day;
				month_dropdown.value = contract_month;
				year_dropdown.value = contract_year;
				
				// setting payment type
				var payment_type = result_contract[0]["payment_type"];
				
				var rate_dropdown = document.getElementById("rate");
				rate_dropdown.value = payment_type;
				
				// starter pack
				var starter_pack = result_contract[0]["starter"];
				
				var starter_checkbox = document.getElementById("starter");
				if(starter_pack==0){starter_pack_bool = false;} else {starter_pack_bool = true;}	
				starter_checkbox.checked = starter_pack_bool;
				
				// book
				var book = result_contract[0]["book"];
				
				var book_checkbox = document.getElementById("book");
				
				if(book==0){book_bool = false;} else {book_bool = true;}	
				book_checkbox.checked = book_bool;
				
				//comment box
			    var comments = result_contract[0]["comments"];
				
				var comment_box = document.getElementById("comments");
				comment_box.value = comments;
				
			} 
			
			
			
			
		</script>
		
	</body>
</html>




