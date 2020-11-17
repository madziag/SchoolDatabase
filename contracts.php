
<?php

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


$sortByCol = "last_name";
$order = "ASC";

if(isset($_GET["sortByCol"])){
	$sortByCol  = $_GET["sortByCol"];
}

if(isset($_GET["order"])){
	$order  = $_GET["order"];
}


$sql = "select contracts.*, last_name, first_name, received_date, amount
from contracts join students on contracts.student_id = students.student_id
left outer join(select contract_id, max(received_date) as b from payment
group by contract_id) as a
on contracts.contract_id = a.contract_id
left outer join payment on contracts.contract_id = payment.contract_id and a.b = payment.received_date "
//where contracts.active = 1
. "order by trim(" . $sortByCol . ") " . $order;

$result = $conn->query($sql)
or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);

$num_rows = mysqli_num_rows($result);

// Selects most recent value from settings
$sql2 = "select * from settings order by settings_date desc limit 1;";
$result2 = $conn->query($sql2)
or trigger_error($conn->error);
$row2 = $result2->fetch_array(MYSQLI_BOTH);

$sql_payDate_settings = "select * from settings_payment_due_dates;";
$result_sql_payDate_settings = $conn->query($sql_payDate_settings)
or trigger_error($conn->error);
$payDate_count = mysqli_num_rows($result_sql_payDate_settings);


if ($num_rows > 0){


echo "<table border =\"1\">
	<tr>
	<td> </td>
	<td> </td>
	<td> </td>
	<td> <center> <a href=\"http://localhost:8000/contracts.php?sortByCol=last_name&order=ASC\" class=\"button\">&#x25B2;</a>
		          <a href=\"http://localhost:8000/contracts.php?sortByCol=last_name&order=DESC\" class=\"button\">&#x25BC;</a>
         </center> </td>
	<td> </td>
	<td> <center> <a href=\"http://localhost:8000/contracts.php?sortByCol=contract_signed&order=ASC\" class=\"button\">&#x25B2;</a>
		          <a href=\"http://localhost:8000/contracts.php?sortByCol=contract_signed&order=DESC\" class=\"button\">&#x25BC;</a>
         </center>
    </td>
	<td> </td>
	<td> </td>
	<td> </td>
	<td> <!--<center><a href=\"http://localhost:8000/contracts.php?sortByCol=contract_signed&order=ASC\" class=\"button\">&#x25B2;</a>
		          <a href=\"http://localhost:8000/contracts.php?sortByCol=contract_signed&order=DESC\" class=\"button\">&#x25BC;</a>
         </center> -->
    </td>
	<td> </td>
	<td> <!--<center><a href=\"http://localhost:8000/contracts.php?sortByCol=contract_signed&order=ASC\" class=\"button\">&#x25B2;</a>
		         <a href=\"http://localhost:8000/contracts.php?sortByCol=contract_signed&order=DESC\" class=\"button\">&#x25BC;</a>
         </center> -->
	</td>
	<td> </td>
	</tr>

    <tr>
    <td> </td>
	<td> studentID </td>
	<td> First Name  </td>
	<td> Last Name </td>
	<td> Start date </td>
	<td> Signed </td>
	<td> Nr Payments </td>
	<td> Total Paid </td>
	<td> Total Amount </td>
	<td> Last Pay Date </td>
	<td> Last Pay Amt</td>
	<td> Next Due Date  </td>
	<td> Next Due Amount  </td></tr>";

$counter = 0;
$currentYear = date("Y");
$currentMonth = date("m");

while ($counter <  $num_rows){
	$nextpayment = 0;
	if ($currentMonth <= 8){$schoolYear = $currentYear - 1;}
	else {$schoolYear = $currentYear;}

	$contractYear = substr($row["start_date"], 0, 4);
	$contractMonth = substr($row["start_date"], 5, 2);

    $startDate = new DateTime($row["start_date"]);
	$contractStatus = "Inactive";

	if ($contractYear > $schoolYear){$contractStatus = "Active";}
	if ($contractYear == $schoolYear && $contractMonth >= 9){$contractStatus = "Active";}


	$sql3 = "select * from payment where contract_id = " . $row["contract_id"];
			$result3 = $conn->query($sql3)
			or trigger_error($conn->error);
			$row3 = $result3->fetch_array(MYSQLI_BOTH);
			$num_rows3 = mysqli_num_rows($result3);
			$total_amount_paid = 0;
				for($j = 1; $j <= $num_rows3; $j++){
					$total_amount_paid += $row3["amount"];
			}

	$amountdue = $row['totalamount'] - $total_amount_paid;
	if($amountdue > 0) {$contractStatus = "Active";}

	if ($contractStatus === "Active"){
			if ($total_amount_paid == $row["totalamount"]){
				$nextpayment = 0;
			} else {
			//Pay in full contract type
			// TODO: $row[totalamount] is not the correct amount to use after we implement discounting!!!!!
            // If the total amount is more than the price of 1 semester but less that the prices of the whole school yr, then amout due = totaldue - half of the school year (second semester)
            // If total amount is less than the price of 1 semester then amount due = total amount OTHERWISE it is the price of 1 semester

				if ($row["payment_type"] == "pay in full") {
					if ($row["totalamount"] - $total_amount_paid > $row2['contract_amount_infull']/2 && $row["totalamount"] - $total_amount_paid < $row2['contract_amount_infull']){
							$nextpayment = ($row["totalamount"] - $total_amount_paid) - $row2['contract_amount_infull']/2;
							}
					if ($row["totalamount"] - $total_amount_paid < $row2['contract_amount_infull']/2){
							$nextpayment = $row["totalamount"] - $total_amount_paid;
					}
					if (($row["totalamount"] - $total_amount_paid == $row2['contract_amount_infull']) || ($row["totalamount"] - $total_amount_paid == $row2['contract_amount_infull']/2)){
							$nextpayment = $row2['contract_amount_infull']/2;
					}
				}

			// Pay in installments contract_type
			// TODO: $row[totalamount] is not the correct amount to use after we implement discounting!!!!!
			//

				if ($row["payment_type"] == "installments"){
				    if (($row["totalamount"] - $total_amount_paid)% ($row2['contract_amount_installments']/($payDate_count + 1)) == 0){
				    		$nextpayment = $row2['contract_amount_installments']/($payDate_count + 1);
				    	} else {
				    		$nextpayment = ($row["totalamount"] - $total_amount_paid)% ($row2['contract_amount_installments']/($payDate_count + 1));

				    	}
				    }

		}


		include 'CalculatePayDates.php';


		$amountLeftToPay = $row["totalamount"] - $total_amount_paid;

		//Gets the February date from the payment due dates array if there is one

		$february = NULL;
		$datenumber = 0;

		while(is_null($february) && $datenumber < count($date_array)){
				if($date_array[$datenumber] -> format('m') == 2){
					$february = date_format($date_array[$datenumber], "Y-m-d");
					}
				$datenumber++;
		}


        //If total amount paid = 0, then next payment date is the contract creation date

		if($total_amount_paid == 0){

					$nextPaymentDueDate = $row["contract_creation_date"];

		} else {
			//Paid in full

			if($row["payment_type"] == "pay in full" ){

				if($amountLeftToPay > $row2['contract_amount_infull']/2){
						$nextPaymentDueDate = $row["contract_creation_date"];
						}

				if($amountLeftToPay < $row2['contract_amount_infull']/2){
					if(date_format(new DateTime($row["start_date"]), "m") >= 2 && date_format(new DateTime($row["start_date"]), "m") <= 6){
						$nextPaymentDueDate = $row["contract_creation_date"];
					} else {
						if (!is_null($february)){
							$nextPaymentDueDate = $february;
						} else {
							$nextPaymentDueDate = $row["contract_creation_date"];
							}
						}
					}

				if($amountLeftToPay == $row2['contract_amount_infull']/2){
					if (!is_null($february)){
						$nextPaymentDueDate = $february;
					} else {
						$nextPaymentDueDate = $row["contract_creation_date"];
						}
				}
			}
			//Sorts the dates in the payment due date array



			if($row["payment_type"] == "installments" ){
				$nrOfPaymentsLeft = $amountLeftToPay/($row2['contract_amount_installments']/$payDate_count);
				sort($date_array);

				if($nrOfPaymentsLeft > count($date_array) ){
					$nextPaymentDueDate = $row["contract_creation_date"];
					} else {
						$nextPaymentDueDate = date_format($date_array[count($date_array) - $nrOfPaymentsLeft], "Y-m-d");
						}
				}


			if ($nextpayment == 0){
					$nextPaymentDueDate = 'Paid';
					}
		}


			$contractSigned = $row["contract_signed"];
			if ($row["contract_signed"] == 1){$contractSigned = 'Yes';}
			else if(is_null($row["contract_signed"])){$contractSigned = 'None';}
			else if($row["contract_signed"] == 0){$contractSigned = 'No';}


		echo
		"<tr> <td> <a href = \"Dataupdate.php?studentID=" . $row["student_id"] . "\" > update </a> </td>

		<td> " . $row["student_id"] . " </td>
		<td> " . $row["first_name"] . " </td>
		<td> " . $row["last_name"] . "  </td>
		<td> " . $row["start_date"] . " </td>
		<td> " . $contractSigned . " </td>
		<td> " . $row["nrpayments"] . "  </td>
		<td> " . number_format((float)$total_amount_paid, 2, '.', '') . "  </td>
		<td> " . $row["totalamount"] . "  </td>
		<td> " . $row["received_date"] . "  </td>
		<td> " . $row["amount"] . "  </td>
		<td> " . $nextPaymentDueDate . "  </td>
		<td> " . $nextpayment . "  </td>

		</tr>";

	}
	$row = $result->fetch_array(MYSQLI_BOTH);
	$counter++;
}
echo "</table>";

}


?>

