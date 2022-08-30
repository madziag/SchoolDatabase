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
	<td> Starter </td>
	<td> Description </td>
	</tr>";

$currentYear = date("Y");
$currentMonth = date("m");

for($i = 1; $i <= $num_rows; $i++){
		$row_contracts = $row;
		$contractSigned = $row["contract_signed"];
		if ($row["contract_signed"] == 1){$contractSigned = 'Yes';}
		else if(is_null($row["contract_signed"])){$contractSigned = 'None';}
		else if($row["contract_signed"] == 0){$contractSigned = 'No';}
		
		include 'ContractStatus.php';
		
		include 'CalculateTotalAmountPaid.php';
		
		echo 	"<tr>
				<td> " . $row["start_date"] . " </td>
				<td> " . $contractSigned . " </td>
				<td> " . $row["nrpayments"] . "  </td>
				<td> " . number_format((float)$total_amount_paid, 2, '.', '') . "  </td>
				<td> " . $row["totalamount"] . "  </td>
				<td> " . $row["starter"] . "  </td>
				<td> " . $row["class_description"] . "  </td>
				</tr>";

		$row = $result->fetch_array(MYSQLI_BOTH);
	}


echo "</table>";


?>

<a href = "SearchRetrieve.php"> Go back to Search page </a>
