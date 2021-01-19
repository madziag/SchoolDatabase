<?php
	
	//Starts session
	session_start();
	
	//Connects to the database
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
	
	$sql = "INSERT INTO englishschooldb.payment (contract_id, amount, received_date) VALUES (" . $_POST["contract_id"] . "," . $_POST["PaymentAmount"] . ",'" . date('Y-m-d') . "');";
	
	$sql2 = "INSERT INTO englishschooldb.payment (contract_id, amount, received_date) VALUES (,,'');";
	
	if($sql != $sql2){
		$result = $conn->query($sql)
		or trigger_error($conn->error);
		
		$paymentID = mysqli_insert_id($conn);
		if(is_numeric($paymentID)){
			echo 'Payment has been successfully added';
		}
	}
	
	
	$currentYear = date("Y");
	$currentMonth = date("m");
	
	$sql_contracts = "select * from contracts where contracts.contract_id = " . $_POST["contract_id"];
	
	$result_contracts = $conn->query($sql_contracts)
	or trigger_error($conn->error);
	$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	
	$contractStatus = "Active";
	
	$sql_settings = "select * from settings order by settings_date desc limit 1;";
	
	$result_settings = $conn->query($sql_settings)
	or trigger_error($conn->error);
	$row_settings = $result_settings->fetch_array(MYSQLI_BOTH);
	
	$sql_payDate_settings = "select * from settings_payment_due_dates;";
	
	$result_sql_payDate_settings = $conn->query($sql_payDate_settings)
	or trigger_error($conn->error);
	$payDate_count = mysqli_num_rows($result_sql_payDate_settings);
	
	$nrPaymentsInstallments = $payDate_count + 1;
	
	include 'CalculateNextPayment.php';
	include 'CalculatePayDates.php';
	
	if($nextpayment > 0){
		//Paid in full
		
		if($row_contracts["payment_type"] == "pay in full" ){
			
			if($amountdue > $row_settings['contract_amount_infull']/2){
				$nextPaymentDueDate = $row_contracts["contract_creation_date"];
			}
			
			if($amountdue < $row_settings['contract_amount_infull']/2){
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
			
			
			if($amountdue == $row_settings['contract_amount_infull']/2){
				if (!is_null($february)){
					$nextPaymentDueDate = $february;
					} else {
					$nextPaymentDueDate = $row_contracts["contract_creation_date"];
				}
			}
		}
		//Sorts the dates in the payment due date array
		
		
		
		if($row_contracts["payment_type"] == "installments" ){
			$nrOfPaymentsLeft = ceil($amountdue/($row_settings['contract_amount_installments']/$payDate_count));
			sort($date_array);
			
			if($nrOfPaymentsLeft > count($date_array) ){
				$nextPaymentDueDate = $row_contracts["contract_creation_date"];
				} else {
				
				$nextPaymentDueDate = date_format($date_array[count($date_array) - $nrOfPaymentsLeft], "Y-m-d");
				
			}
		}
	} else {
		$nextPaymentDueDate = NULL;
	}
	
	
	$sql_updateNextPayment = "UPDATE englishschooldb.nextpayment SET nextPaymentDate = '" . $nextPaymentDueDate . "', nextPaymentAmount = " . $nextpayment . " where contractID = " . $_POST["contract_id"] . ";";

	$result_updateNextPayment = $conn->query($sql_updateNextPayment)
	or trigger_error($conn->error);
	
?>

<br></br>
<button onclick="window.location.href='SearchRetrieve.php'">Go to Search Page</button>
<button onclick="window.location.href='contracts.php'">Contracts Overview</button>
