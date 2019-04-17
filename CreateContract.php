<!--
- we also need user to be able to enter contract (create contract)/payment info)
- the sql query pulls out all options of age groups. We need to take into account also semester start so that only active groups are pulled out.
- drop down not working. We need to look closely at the string!

-->
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
	     if ($conn->connect_error) {
	  	   die("Connection failed: " . $conn->connect_error);
    }
  	$result = $conn->query($sql)
		      or trigger_error($conn->error);
	$row = $result->fetch_array(MYSQLI_BOTH);
	echo " Name: " . $row["first_name"] . " " . $row["last_name"] . "<br \>";
	echo "Address: " . $row["street_address"] . " " . $row["address_code"]. " " . $row["town"] . "<br \>";
	echo "Contact: "  . $row["email"] .  " " . $row["phone_main"]  . " " . $row["phone_alt"] . "<br \>";
    echo "Status: " . $row["inactive"];
 	}
 if(isset($_SESSION['post_insert'])){
  	$_POST =  $_SESSION['post_insert'];
  	 echo " Name: " . $_POST['firstname'] . " " . $_POST['lastname'] . "<br \>";
	 echo "Address: " . $_POST['streetaddress'] . " " . $_POST['postcode'] . " " . $_POST['town'] . "<br \>";
	 echo "Contact: "  . $_POST['email'] .  " " . $_POST['mainphone']  . " " . $_POST['altphone'] . "<br \>";
     echo "Status: " . $_POST['status'];
 	}
if(empty($action)){
	$action = "CheckBlankContract.php?studentID=" . $studentID;
	}
$checked1 = 'checked = \"checked\"';
$day = date("d");
$month = date('m');
$year = date('Y');
if($month < 2 or $month > 9 or ($month == 9 and $day > 1)){
	  $selectedFeb = 'selected = \"selected\"';
	  $selectedSept = '';
} else {
     $selectedFeb = '';
     $selectedSept = 'selected = \"selected\"';
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

$result = $conn->query($sql)
or trigger_error($conn->error);

$rows = $result->fetch_all(MYSQLI_NUM);


// <td> " . $row["phone_alt"] . "  </td>

$sql = 'Select distinct location from englishschooldb.locationgroupslevels';
$result = $conn->query($sql)
or trigger_error($conn->error);
$locations = $result->fetch_all(MYSQLI_NUM);

$locationstring = "<select name=\"category\" id=\"category\" onchange=\"javascript: listboxchange1(this.options[this.selectedIndex].value);\">
 <option value=\"\">Select Location</option>";

 for( $i = 0; $i<sizeof($locations); $i++ ) {
	 $locationstring .= "<option value=\"".preg_replace('/[^A-Za-z0-9\-]/', '', $locations[$i][0])."\">".$locations[$i][0]."</option>\n";
 }

$locationstring .=  "</select>";

$js_age_gp = "";
for( $i = 0; $i<sizeof($locations); $i++ ){
	$js_age_gp .= 'case "' . preg_replace('/[^A-Za-z0-9\-]/', '', $locations[$i][0]) . '":';
	$js_age_gp .= '
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");';

	$sql = 'select distinct age_group from englishschooldb.locationgroupslevels where location = \'' . $locations[$i][0] . '\'';
    $result_a = $conn->query($sql)
	or trigger_error($conn->error);
	$rows_a = $result_a->fetch_all(MYSQLI_NUM);

	$x = 1;
	for( $j= 0; $j<sizeof($rows_a); $j++ ){
		$js_age_gp .= '
			 document.form1.subcategory1.options[' . $x . '] = new Option("' . $rows_a[$j][0] . '", "' . $rows_a[$j][0] . '");
';
		$x++;
		}
	$js_age_gp .= ' loc = "' . preg_replace('/[^A-Za-z0-9\-]/', '', $locations[$i][0]) . '";
	break;
';
	}

session_destroy();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>

 <title>3 level dynamic drop down list using javascript</title>

 <script language="javascript" type="text/javascript">
 <!--
 var a = <?php echo json_encode($rows); ?>;
 var foo = (a[0][1]);
 var locations = <?php echo json_encode($locations); ?>;
 locations.length;
 var loc = "";


 function listboxchange1(p_index) {
	 //Clear Current options in subcategory1
	 document.form1.subcategory1.options.length = 0;
	 //Clear Current options in subcategory2
	 document.form1.subcategory2.options.length = 0;
	 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 switch (p_index) {
		 <?php echo $js_age_gp ?>
		 }
	 return true;
 }

function listboxchange(p_index) {
	 //Clear Current options in subcategory
	 document.form1.subcategory2.options.length = 0;
	 if(loc === "Brzenica"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
		 case "Direct Teens":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 break;
		 }
	 }
	if(loc === "Bachowice"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
		 case "Direct Teens":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 break;
		}
	}
	 if(loc === "Zator"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
		 case "Direct Teens":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 break;
		 case "Callan Method Adults":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 document.form1.subcategory2.options[5] = new Option("5", "5");
		 document.form1.subcategory2.options[6] = new Option("6", "6");
		 document.form1.subcategory2.options[7] = new Option("7", "7");
		 document.form1.subcategory2.options[8] = new Option("8", "8");
		 document.form1.subcategory2.options[9] = new Option("9", "9");
		 document.form1.subcategory2.options[10] = new Option("10", "10");
		 document.form1.subcategory2.options[11] = new Option("11", "11");
		 document.form1.subcategory2.options[12] = new Option("12", "12");
         break;
		 }
	 }
	if(loc === "Przeciszw"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
         document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
		 }
	 }
	if(loc === "Laskowa"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
		 case "Direct Teens":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 break;
		 }
 }
	if(loc === "Grodzisko"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
	 		 }
	 }
	 if(loc === "Ryczw"){
		 switch (p_index) {
		 case "Direct Kids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;
		 case "Direct Teens":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 break;
		 }
	 }
	 return true;
 }
 -->
 </script>

 </head>
 <body>
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
 			<select name="month">
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
 		    <select name="year">
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


 <br /> <br />
	<?php echo $locationstring; ?>


 <script type="text/javascript" language="javascript">
 <!--
 document.write('<select name="subcategory1" onChange="javascript: listboxchange(this.options[this.selectedIndex].value);"><option value="">Select Type</option></select>')
 -->
 </script>


 <script type="text/javascript" language="javascript">
 <!--
 document.write('<select name="subcategory2"><option value="">Select Level</option></select>')
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



 <input type="submit">

 </form>
 </body>
 </html>