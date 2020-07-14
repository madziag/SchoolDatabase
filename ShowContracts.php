<?php

 session_start();

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

$sql = "select a.*, first_name, last_name from contracts a left join students b on a.student_id = b.student_id where a.student_id = " . $_GET["studentID"] ;

$result = $conn->query($sql)
or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);
$num_rows = mysqli_num_rows($result);


echo $row["first_name"] . " " . $row["last_name"];

echo "<table border =\"1\">
	<tr>
    <td> Start date </td>
	<td> Signed </td>
	<td> Nr Payments </td>
	<td> Total Paid </td>
	<td> Total Amount </td>
	<td> Book </td>
	<td> Starter </td>
	<td> Location </td>
	<td> Age Group </td>
	<td> Level </td>
	<td> Contract Status </td>
	</tr>";

$currentYear = date("Y");
$currentMonth = date("m");

for($i = 1; $i <= $num_rows; $i++){
		$contractSigned = $row["contract_signed"];
		if ($row["contract_signed"] == 1){$contractSigned = 'Yes';}
		else if(is_null($row["contract_signed"])){$contractSigned = 'None';}
		else if($row["contract_signed"] == 0){$contractSigned = 'No';}

		if ($currentMonth <= 8){$schoolYear = $currentYear - 1;}
		else {$schoolYear = $currentYear;}

		$contractYear = substr($row["start_date"], 0, 4);
		$contractMonth = substr($row["start_date"], 5, 2);
        $contractStatus = "Inactive";
		if ($contractYear > $schoolYear){$contractStatus = "Active";}
		if ($contractYear == $schoolYear && $contractMonth >= 9){$contractStatus = "Active";}

		// Add additional condition when payments are implemented -- contract remains Active if NOT paid off completely
        $sql2 = "select * from payment where contract_id = " . $row["contract_id"];
	   	$result2 = $conn->query($sql2)
	   	or trigger_error($conn->error);
	   	$row2 = $result2->fetch_array(MYSQLI_BOTH);
	   	$num_rows2 = mysqli_num_rows($result2);
	    $total_amount_paid = 0;

	   		for($j = 1; $j <= $num_rows2; $j++){
	   	    	$total_amount_paid += $row2["amount"];
				}


		echo 	"<tr>
				<td> " . $row["start_date"] . " </td>
				<td> " . $contractSigned . " </td>
				<td> " . $row["nrpayments"] . "  </td>
				<td> " . number_format((float)$total_amount_paid, 2, '.', '') . "  </td>
				<td> " . $row["totalamount"] . "  </td>
				<td> " . $row["book"] . "  </td>
				<td> " . $row["starter"] . "  </td>
				<td> " . $row["location"] . "  </td>
				<td> " . $row["age_group"] . "  </td>
				<td> " . $row["level"] . "  </td>
				<td> " . $contractStatus . "  </td>
				</tr>";

		$row = $result->fetch_array(MYSQLI_BOTH);
	}


echo "</table>";


?>

