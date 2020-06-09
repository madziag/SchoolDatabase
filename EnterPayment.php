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

$studentID = $_GET["studentID"];
$sql = "select a.*, first_name, last_name from contracts a left join students b on a.student_id = b.student_id where a.student_id = " . $_GET["studentID"] ;

$result = $conn->query($sql)
or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);
$num_rows = mysqli_num_rows($result);


echo $row["first_name"] . " " . $row["last_name"];

echo "<table border =\"1\">
	<tr>
	<td> Number </td>
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
$number = 1;
$contractNumbers = array();

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

		$oldestStartDate = date('Y-m-d', strtotime(date("Y-m-d"). ' + 365 days'));
		$contractDate = date('Y-m-d', strtotime($row["start_date"]));

		if ($contractStatus == "Active" && $contractDate < $oldestStartDate){
				$oldestStartDate = $contractDate;
				$oldestContract_ID = $row["contract_id"];
				$oldestContractNumber = $number;
				}

		$contractNumbers[$number]= $row["contract_id"];



		// Add additional condition when payments are implemented -- contract remains Active if NOT paid off completely

		echo 	"<tr>
		        <td> " . $number . " </td>
				<td> " . $row["start_date"] . " </td>
				<td> " . $contractSigned . " </td>
				<td> " . $row["nrpayments"] . "  </td>
				<td> " . $row["totalamountpaid"] . "  </td>
				<td> " . $row["totalamount"] . "  </td>
				<td> " . $row["book"] . "  </td>
				<td> " . $row["starter"] . "  </td>
				<td> " . $row["location"] . "  </td>
				<td> " . $row["age_group"] . "  </td>
				<td> " . $row["level"] . "  </td>
				<td> " . $contractStatus . "  </td>
				</tr>";

		$number++;
		$row = $result->fetch_array(MYSQLI_BOTH);
	}


echo "</table>";





?>

<html>
<body>
<button onclick="window.location.href='InsertPayment.php?studentID=<?php echo $studentID ?>&contractID=<?php echo $oldestContract_ID ?>'">Add Payment to Contract <?php echo $oldestContractNumber ?></button>
</body>
</html>