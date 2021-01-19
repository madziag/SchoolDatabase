
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
	
	
	$sql_contracts = "select contracts.*, last_name, first_name, received_date, amount
	from contracts join students on contracts.student_id = students.student_id
	left outer join(select contract_id, max(received_date) as b from payment
	group by contract_id) as a
	on contracts.contract_id = a.contract_id
	left outer join payment on contracts.contract_id = payment.contract_id and a.b = payment.received_date "
	//where contracts.active = 1
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
	
	$sql_payDate_settings = "select * from settings_payment_due_dates;";
	$result_sql_payDate_settings = $conn->query($sql_payDate_settings)
	or trigger_error($conn->error);
	$payDate_count = mysqli_num_rows($result_sql_payDate_settings);
	
	$nrPaymentsInstallments = $payDate_count + 1;
	
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
		
		while ($counter <  $num_rows_contracts){
		
			include 'CalculateNextPayment.php';
		
			if ($contractStatus === "Active"){
							
				include 'CalculatePayDates.php';
							
				$amountLeftToPay = $row_contracts["totalamount"] - $total_amount_paid;
				
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
					
					$nextPaymentDueDate = $row_contracts["contract_creation_date"];
					
					} else {
					if($nextpayment > 0){
					//Paid in full
					
						if($row_contracts["payment_type"] == "pay in full" ){
						
							if($amountLeftToPay > $row_settings['contract_amount_infull']/2){
							$nextPaymentDueDate = $row_contracts["contract_creation_date"];
							}
						
							if($amountLeftToPay < $row_settings['contract_amount_infull']/2){
								if(date_format(new DateTime($row_contracts["start_date"]), "m") >= 2 && date_format(new DateTime($row_contracts["start_date"]), "m") <= 6){
									$nextPaymentDueDate = $row_contracts["contract_creation_date"];
									} else {
									if (!is_null($february)){
										$nextPaymentDueDate = $february;
										} else {
										$nextPaymentDueDate = $row_contracts["contract_creation_date"];
									}
								}
							}
					
						
							if($amountLeftToPay == $row_settings['contract_amount_infull']/2){
								if (!is_null($february)){
									$nextPaymentDueDate = $february;
									} else {
									$nextPaymentDueDate = $row_contracts["contract_creation_date"];
								}
							}
						}
					//Sorts the dates in the payment due date array
					
					
					
						if($row_contracts["payment_type"] == "installments" ){
							$nrOfPaymentsLeft = ceil($amountLeftToPay/($row_settings['contract_amount_installments']/$payDate_count));
							sort($date_array);
							
							if($nrOfPaymentsLeft > count($date_array) ){
								$nextPaymentDueDate = $row_contracts["contract_creation_date"];
								} else {
								
								$nextPaymentDueDate = date_format($date_array[count($date_array) - $nrOfPaymentsLeft], "Y-m-d");
								
							}
						}
					}
					
					
					if ($nextpayment == 0){
						$nextPaymentDueDate = 'Paid';
					}
					if ($nextpayment < 0){
						$nextPaymentDueDate = 'Overpaid';
					}
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
				<td> " . $nextpayment . "  </td>
				
				</tr>";
				
			}
			$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
			$counter++;
		}
		echo "</table>";
		
	}
	
	
?>

