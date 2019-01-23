<!--
- we also need user to be able to enter contract (create contract)/payment info)
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
	$action = 'CheckBlankContract.php';
	}

if(empty($level)){
	$level= '';
	}
if(empty($location)){
	$location= '';
	}
if(empty($rate)){
	$rate= '';
	}

$checked1 = 'checked = \"checked\"';
session_destroy();

?>

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>

 <title>3 level dynamic drop down list using javascript</title>

 <script language="javascript" type="text/javascript">
 <!--
 var loc = "";
 function listboxchange1(p_index) {

	 //Clear Current options in subcategory1
	 document.form1.subcategory1.options.length = 0;

	 //Clear Current options in subcategory2
	 document.form1.subcategory2.options.length = 0;
	 document.form1.subcategory2.options[0] = new Option("Select Level", "");

		 switch (p_index) {

		 case "Brzeznica":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 document.form1.subcategory1.options[2] = new Option("DirectTeens", "DirectTeens");
		 loc = "Brzeznica";
		 break;

		 case "Bachowice":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 document.form1.subcategory1.options[2] = new Option("DirectTeens", "DirectTeens");
		 loc = "Bachowice";
		 break;

		 case "Zator":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 document.form1.subcategory1.options[2] = new Option("DirectTeens", "DirectTeens");
		 document.form1.subcategory1.options[3] = new Option("CallanAdults", "CallanAdults");
		 loc = "Zator";
 		 break;

		 case "Przeciszów":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 loc = "Przeciszów";
 		 break;

 		 case "Laskowa":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 document.form1.subcategory1.options[2] = new Option("DirectTeens", "DirectTeens");
		 loc = "Laskowa";
 		 break;

		 case "Grodzisko":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 loc = "Grodzisko";
 		 break;

		 case "Ryczów":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 document.form1.subcategory1.options[1] = new Option("DirectKids", "DirectKids");
		 document.form1.subcategory1.options[2] = new Option("DirectTeens", "DirectTeens");
		 loc = "Ryczów";
 		 break;

		 case "Laczany":
		 document.form1.subcategory1.options[0] = new Option("Select Type", "");
		 loc = "Laczany";
		 break;


		 }
	 return true;
 }
 //-->
 </script>

 <script language="javascript" type="text/javascript">
 <!--

 function listboxchange(p_index) {

	 //Clear Current options in subcategory
	 document.form1.subcategory2.options.length = 0;

	 if(loc === "Brzeznica"){
		 switch (p_index) {

		 case "DirectKids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;

		 case "DirectTeens":
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

		 case "DirectKids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;

		 case "DirectTeens":
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

		 case "DirectKids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;

		 case "DirectTeens":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("1", "1");
		 document.form1.subcategory2.options[2] = new Option("2", "2");
		 document.form1.subcategory2.options[3] = new Option("3", "3");
		 document.form1.subcategory2.options[4] = new Option("4", "4");
		 break;

		 case "CallanAdults":
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

	if(loc === "Przeciszów"){
		 switch (p_index) {

		 case "DirectKids":
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

		 case "DirectKids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;

		 case "DirectTeens":
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

		 case "DirectKids":
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

	 if(loc === "Ryczów"){
		 switch (p_index) {

		 case "DirectKids":
		 document.form1.subcategory2.options[0] = new Option("Select Level", "");
		 document.form1.subcategory2.options[1] = new Option("0", "0");
		 document.form1.subcategory2.options[2] = new Option("1", "1");
		 document.form1.subcategory2.options[3] = new Option("2", "2");
		 document.form1.subcategory2.options[4] = new Option("3", "3");
		 document.form1.subcategory2.options[5] = new Option("4", "4");
		 document.form1.subcategory2.options[6] = new Option("5", "5");
		 document.form1.subcategory2.options[7] = new Option("6", "6");
		 break;

		 case "DirectTeens":
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
 //-->
 </script>

 </head>
 <body>
 <form action= "<?php echo $action ?>"  method="post" id="form1" name="form1">
 <select name="category" id="category" onchange="javascript: listboxchange1(this.options[this.selectedIndex].value);">
 <option value="">Select Location</option>
 <option value="Brzeznica">Brze&#378;nica</option>
 <option value="Bachowice">Bachowice</option>
 <option value="Zator">Zator</option>
 <option value="Przeciszów">Przecisz&oacute;w</option>
 <option value="Laskowa">Laskowa</option>
 <option value="Grodzisko">Grodzisko</option>
 <option value="Ryczów">Rycz&oacute;w</option>
 <option value="Laczany">&#321;&#261;czany</option>
 </select>

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
 Payment Rate:
 		  <select name="rate">
 		  <option>not set</option>
 		  <option value="1">90</option>
 		  <option value="2">408</option>
 </select><br />

 Starter Pack:
 <input type="checkbox" name="starter" checked = "checked"> <br />


 Book:
 <input type="checkbox" name="book" checked = "checked"> <br />



 <input type="submit">

 </form>
 </body>
 </html>