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



$table = "<table border =\"1\">
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
$oldestStartDate = date('Y-m-d', strtotime(date("Y-m-d"). ' + 365 days'));
$optionString = "<select name=\"contract_id\" id=\"contract_id\">";


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

		$contractDate = date('Y-m-d', strtotime($row["start_date"]));

		if ($contractStatus == "Active" && $contractDate < $oldestStartDate){
				$oldestStartDate = $contractDate;
				$oldestContract_ID = $row["contract_id"];
				$oldestContractNumber = $number;
				}

		$contractNumbers[$number]= $row["contract_id"];
		$nrPaymentsByContractNr[$number]= $row["nrpayments"];

		$optionString .= "<option value=\"" . $row["contract_id"] . "\">" . $number . "</option>";

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

		$table .= "<tr>
		        <td> " . $number . " </td>
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

		$number++;
		$row = $result->fetch_array(MYSQLI_BOTH);
	}



$optionString .= "</select>";
$find = ">" . $oldestContractNumber . "<";
$replace ="selected=\"selected\">".$oldestContractNumber."<";
$optionString = str_replace($find,$replace,$optionString);

$table .= "</table>";



?>

<html>
<body>



  <form action= "InsertPayment.php?studentID=<?php echo $studentID ?>" method="post">

   Contract: <?php echo $optionString ?>;

   Payment Amount: <input type="number" name="PaymentAmount" value="<?php

   		if ($nrPaymentsByContractNr[$oldestContractNumber] == 2){$nextpayment = 409;}
   		if ($nrPaymentsByContractNr[$oldestContractNumber] == 10){$nextpayment = 90;}

        echo $nextpayment?>" >





   <input type="submit" name = "addPayment" value = "Add payment ">

    <?php echo $table ?>

   </form>

</body>
</html>

