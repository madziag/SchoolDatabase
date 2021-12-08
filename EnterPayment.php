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
	$sql_contracts = "select a.*, first_name, last_name from contracts a left join students b on a.student_id = b.student_id where a.student_id = " . $_GET["studentID"] ;
	
	$result_contracts = $conn->query($sql_contracts)
	or trigger_error($conn->error);
	$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	$num_rows = mysqli_num_rows($result_contracts);
		
	echo $row_contracts["first_name"] . " " . $row_contracts["last_name"];
	
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
	</tr>";
	
	$currentYear = date("Y");
	$currentMonth = date("m");
	$number = 1;
	$contractNumbers = array();
	$oldestStartDate = date('Y-m-d', strtotime(date("Y-m-d"). ' + 365 days'));
	$optionString = "<select name=\"contract_id\" id=\"contract_id\">";
	$oldestContractNumber = 0;
	
	for($i = 1; $i <= $num_rows; $i++){
		$contractSigned = $row_contracts["contract_signed"];
		if ($row_contracts["contract_signed"] == 1){$contractSigned = 'Yes';}
		else if(is_null($row_contracts["contract_signed"])){$contractSigned = 'None';}
		else if($row_contracts["contract_signed"] == 0){$contractSigned = 'No';}
		
		include 'ContractStatus.php';	
		
		$contractDate = date('Y-m-d', strtotime($row_contracts["start_date"]));
		
		if ($contractStatus == "Active" && $contractDate < $oldestStartDate){
			$oldestStartDate = $contractDate;
			$oldestContractNumber = $number;
		}
		
		$contractNumbers[$number]= $row_contracts["contract_id"];
		$nrPaymentsByContractNr[$number]= $row_contracts["nrpayments"];
		
		$optionString .= "<option value=\"" . $row_contracts["contract_id"] . "\">" . $number . "</option>";
			
		include 'CalculateTotalAmountPaid.php';
		
		$table .= "<tr>
		<td> " . $number . " </td>
		<td> " . $row_contracts["start_date"] . " </td>
		<td> " . $contractSigned . " </td>
		<td> " . $row_contracts["nrpayments"] . "  </td>
		<td> " . number_format((float)$total_amount_paid, 2, '.', '') . "  </td>
		<td> " . $row_contracts["totalamount"] . "  </td>
		<td> " . $row_contracts["book"] . "  </td>
		<td> " . $row_contracts["starter"] . "  </td>
		<td> " . $row_contracts["location"] . "  </td>
		<td> " . $row_contracts["age_group"] . "  </td>
		<td> " . $row_contracts["level"] . "  </td>
		</tr>";
		
		$number++;
		$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	}
	
	
	
	$optionString .= "</select>";
	$find = ">" . $oldestContractNumber . "<";
	$replace ="selected=\"selected\">".$oldestContractNumber."<";
	$optionString = str_replace($find,$replace,$optionString);
	
	$table .= "</table>";
		
	if($oldestContractNumber != 0){
	
		$sql_nextPayment = "select * from nextpayment where contractID = " . $contractNumbers[$oldestContractNumber];
		
		$result_nextPayment = $conn->query($sql_nextPayment)
		or trigger_error($conn->error);
		$row_nextPayment = $result_nextPayment->fetch_array(MYSQLI_BOTH);
	}

?>
		
		<html>
			<body>
				
				
				
				<form action= "InsertPayment.php?studentID=<?php echo $studentID ?>" method="post">
					
					Contract: <?php echo $optionString ?>;
					
					Payment Amount: <input type="number" name="PaymentAmount" value="<?php echo $row_nextPayment["nextPaymentAmount"] ?>" >
					
					
					
					
					<input type="submit" name = "addPayment" value = "Add payment">
				
				
				
				</form>
				
			    <form action= "UpdateAmountDue.php?studentID=<?php echo $studentID ?>" method="post">
					
					Contract: <?php echo $optionString ?>;
					
					Discount Amount: <input type="number" name="DiscountAmount" value=0 >
					
					
					
					
					<input type="submit" name = "EnterDiscount" value = "Enter Discount">
				
				
				
				</form>
				
				<?php echo $table ?>
				
			</body>
		</html>
		
		