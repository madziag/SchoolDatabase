
<?php

 session_start();
 $_SESSION['post_sr'] = $_POST;

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

    $q = intval($_GET['q']);

    $sql = 'Select distinct location from englishschooldb.locationgroupslevels where semester_start = ' . $q;

	$result = $conn->query($sql)
	or trigger_error($conn->error);
	$loc = "";
	while($row = $result->fetch_assoc()) {
	        $locations[] = $row["location"];
    }

$locationstring = "<select name=\"category\" id=\"category\" onchange=\"javascript: listboxchange1(this.options[this.selectedIndex].value);\">
 <option value=\"\">Select Location</option>";

 for( $i = 0; $i<sizeof($locations); $i++ ) {
	 $locationstring .= "<option value=\"".preg_replace('/[^A-Za-z0-9\-]/', '', $locations[$i])."\">".$locations[$i]."</option>\n";
 }

$locationstring .=  "</select>";
echo $locationstring;
?>