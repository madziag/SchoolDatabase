
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
	
	
	$sql_contracts = "select contracts.*, last_name, first_name, received_date, amount, nextpayment.nextPaymentDate, nextpayment.nextPaymentAmount
	from contracts join students on contracts.student_id = students.student_id
	left outer join(select contract_id, max(received_date) as b from payment
	group by contract_id) as a
	on contracts.contract_id = a.contract_id
	left outer join payment on contracts.contract_id = payment.contract_id and a.b = payment.received_date 
	left outer join nextpayment on contracts.contract_id = nextpayment.contractID "
	. "order by trim(" . $sortByCol . ") " . $order;
	
	$result_contracts = $conn->query($sql_contracts)
	or trigger_error($conn->error);
	$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	
	$num_rows_contracts = mysqli_num_rows($result_contracts);
	
	// Selects most recent value from settings
	$sql_settings = "select * from settings order by settings_date desc limit 1;";
	$result_settings = $conn->query($sql_settings)
	or trigger_error($conn->error);
	$row_settings = $result_settings->fetch_array(MYSQLI_BOTH);
	
	if ($num_rows_contracts > 0){
		
		
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
		<td> <!-- <center><a href=\"http://localhost:8000/contracts.php?sortByCol=nextPaymentDate&order=ASC\" class=\"button\">&#x25B2;</a>
		<a href=\"http://localhost:8000/contracts.php?sortByCol=nextPaymentDate&order=DESC\" class=\"button\">&#x25BC;</a>
		</center> -->
		</td>
		<td> </td>
		<td> <center><a href=\"http://localhost:8000/contracts.php?sortByCol=nextPaymentDate&order=ASC\" class=\"button\">&#x25B2;</a>
		<a href=\"http://localhost:8000/contracts.php?sortByCol=nextPaymentDate&order=DESC\" class=\"button\">&#x25BC;</a>
		</center>
		</td> 
		<td> <center><a href=\"http://localhost:8000/contracts.php?sortByCol=nextPaymentAmount&order=ASC\" class=\"button\">&#x25B2;</a>
		<a href=\"http://localhost:8000/contracts.php?sortByCol=nextPaymentAmount&order=DESC\" class=\"button\">&#x25BC;</a>
		</center> 
		</td>
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
		
		while ($counter <  $num_rows_contracts){
				
			include 'ContractStatus.php';

			if ($contractStatus === "Active"){
								
				include 'CalculateTotalAmountPaid.php';
		
				$nextPaymentDueDate = "";
			
				if($row_contracts["nextPaymentAmount"] > 0){
					$nextPaymentDueDate = $row_contracts["nextPaymentDate"];
					}	
				if ($row_contracts["nextPaymentAmount"] == 0){
					$nextPaymentDueDate = 'Paid';
					}
				if (is_null($row_contracts["nextPaymentAmount"])){
					$nextPaymentDueDate = '';
					}
				if ($row_contracts["nextPaymentAmount"] < 0){
					$nextPaymentDueDate = 'Overpaid';
					}		
				$contractSigned = $row_contracts["contract_signed"];
				
				if ($row_contracts["contract_signed"] == 1){
					$contractSigned = 'Yes';
					}
				else if(is_null($row_contracts["contract_signed"])){
					$contractSigned = 'None';
					}
				else if($row_contracts["contract_signed"] == 0){
					$contractSigned = 'No';
					}
						
				echo
				"<tr> <td> <a href = \"Dataupdate.php?studentID=" . $row_contracts["student_id"] . "\" > update </a> </td>
				
				<td> " . $row_contracts["student_id"] . " </td>
				<td> " . $row_contracts["first_name"] . " </td>
				<td> " . $row_contracts["last_name"] . "  </td>
				<td> " . $row_contracts["start_date"] . " </td>
				<td> " . $contractSigned . " </td>
				<td> " . $row_contracts["nrpayments"] . "  </td>
				<td> " . number_format((float)$total_amount_paid, 2, '.', '') . "  </td>
				<td> " . $row_contracts["totalamount"] . "  </td>
				<td> " . $row_contracts["received_date"] . "  </td>
				<td> " . $row_contracts["amount"] . "  </td>
				<td> " . $nextPaymentDueDate . "  </td>
				<td> " . $row_contracts["nextPaymentAmount"] . "  </td>
				
				</tr>";
				
			}
			
			$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
			$counter++;
		}
		echo "</table>";
		
	}
	
	
?>

