
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

	if ($currentMonth <= 8){$schoolYear = $currentYear - 1;}
	else {$schoolYear = $currentYear;}

	$contractYear = substr($row["start_date"], 0, 4);
	$contractMonth = substr($row["start_date"], 5, 2);

	$contractStatus = "Inactive";

	if ($contractYear > $schoolYear){$contractStatus = "Active";}
	if ($contractYear == $schoolYear && $contractMonth >= 9){$contractStatus = "Active";}


	$sql2 = "select * from payment where contract_id = " . $row["contract_id"];
			$result2 = $conn->query($sql2)
			or trigger_error($conn->error);
			$row2 = $result2->fetch_array(MYSQLI_BOTH);
			$num_rows2 = mysqli_num_rows($result2);
			$total_amount_paid = 0;
				for($j = 1; $j <= $num_rows2; $j++){
					$total_amount_paid += $row2["amount"];
			}

	$amountdue = $row['totalamount'] - $total_amount_paid;
	if($amountdue > 0) {$contractStatus = "Active";}

	if ($contractStatus === "Active"){

		if ($row["nrpayments"] == 2 and $total_amount_paid == 0)
			{$nextpayment = 409;}
		if ($total_amount_paid == $row["totalamount"])
			{$nextpayment = 0;}
		if ($row["nrpayments"] == 10 and $total_amount_paid != $row["totalamount"])
			{$nextpayment = 90;}

		//Payments should be received by the 10th of each month for installments
		$date=date_create("first day of next month");
		date_add($date, date_interval_create_from_date_string('9 days'));
		$nextdate = date_format($date,"Y-m-d");

		// TODO: The calculation uses an example date
		/*$firstpaydate = date_create('2017-09-01');

		$lastpaydate = date_add($firstpaydate, date_interval_create_from_date_string('5 months'));
		$monthslefttopay = ceil(($row["totalamount"] - $total_amount_paid)/90);
		$nextpaymonth = date_sub($lastpaydate, date_interval_create_from_date_string($monthslefttopay . ' months'));
		$nextdate = date_format($nextpaymonth,"Y-m-d");

		if ($nextpayment == 0){$nextdate = 'Paid';}*/

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
		<td> " . "TODO Next Date" . "  </td>
		<td> " . "TODO Next Payment" . "  </td>

		</tr>";

	}
	$row = $result->fetch_array(MYSQLI_BOTH);
	$counter++;
}
echo "</table>";

}


?>

