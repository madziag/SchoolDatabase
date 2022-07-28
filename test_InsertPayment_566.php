<?php
// What InsertPayment.php does: 
// - Updates nextpayment table for 'this' contract with nextPaymentDate and nextPaymentAmount
// - "INSERT INTO englishschooldb.payment (contract_id, amount, received_date) VALUES (" . $_POST["contract_id"] . "," . $_POST["PaymentAmount"] . ",'" . date('Y-m-d') . "');";
	
// Data needed for the test
// - a previous entry in the nextpayment table for the same contract with nextPaymentDate and nextPaymentAmount filled in
// - $_POST["contract_id"]
// - $_POST["PaymentAmount"]

// What is needed to get a correct nextPaymentDate and nextPaymentAmount
// - Valid contract in the contracts table in the db
// - correct set of dates in the settings_payment_due_dates table -> correct array of dates in date_array
// - Settings table in the db needs to have correct infull and installment values

// - 1. Check if the data needed is there (settings table must have in full and installment values and are they correct)

	//Start session
	session_start();
	
	//Connect to the database
	$test_servername = 'localhost';
	$test_username = 'MadziaG';
	$test_password = 'P$i@krew2018User';
	$test_dbname = 'englishschooldb';
	
	// Create connection
    $test_conn = new mysqli($test_servername, $test_username, $test_password, $test_dbname);
	
	// Check connection
	if ($test_conn->connect_error) {
		die("Connection failed: " . $test_conn->connect_error);
	}


// - 2. Check if the data needed is there (settings_payment_due_dates table must have correct payment_due_date)
	
	$test_sql_settings_payment_due_dates = "select * from settings_payment_due_dates where (due_year = 2021 and due_month=11) or (due_year = 2022 and due_month < 6);";
	
	$test_result_settings_payment_due_dates = $test_conn->query($test_sql_settings_payment_due_dates)
	or trigger_error($test_conn->error);
	$test_row_settings_payment_due_dates = $test_result_settings_payment_due_dates->fetch_array(MYSQLI_BOTH);
	
	$num_rows_settings_payment_due_dates = mysqli_num_rows($test_result_settings_payment_due_dates);
	$counter = 0;
	$nrfound = 0;
	
	while ($counter <  $num_rows_settings_payment_due_dates){
		if($test_row_settings_payment_due_dates['due_day'] == 10 && $test_row_settings_payment_due_dates['due_month'] == 11 && $test_row_settings_payment_due_dates['due_year'] == 2021){
			$nrfound++;
			} 
		if($test_row_settings_payment_due_dates['due_day'] == 10 && $test_row_settings_payment_due_dates['due_month'] == 2 && $test_row_settings_payment_due_dates['due_year'] == 2022){
			$nrfound++;
			} 
		if($test_row_settings_payment_due_dates['due_day'] == 10 && $test_row_settings_payment_due_dates['due_month'] == 4 && $test_row_settings_payment_due_dates['due_year'] == 2022){
			$nrfound++;
			} 
	
		$test_row_settings_payment_due_dates = $test_result_settings_payment_due_dates->fetch_array(MYSQLI_BOTH);
		$counter++;
	}
	
	if($nrfound == 3){
		echo 'settings_payment_due_dates are okay. <br>';
		} else {
		echo 'settings_payment_due_dates are NOT AS EXPECTED. Nr of dates found is' . $nrfound . '<br>';
		}
		
// - 3. Check Payments table to see if previous payments are as expected
	$test_sql_payment = "select * from payment where contract_id >= 539 and contract_id <= 544;";
	
	$test_result_payment = $test_conn->query($test_sql_payment)
	or trigger_error($test_conn->error);
	$test_row_payment = $test_result_payment->fetch_array(MYSQLI_BOTH);
	
	$num_rows_payment = mysqli_num_rows($test_result_payment);
	
	
	if($num_rows_payment == 0){
		echo 'Payments (in database) OKAY. <br>';
		} else {
		echo 'Payments (in database) NOT AS EXPECTED. <br>';
		}

// - 4. Check contract to see if it has the values we need 
	$test_sql_contracts = "select * from contracts where contract_id = 566 or (contract_id >= 539 and contract_id <= 544);";
	
	$test_result_contracts = $test_conn->query($test_sql_contracts)
	or trigger_error($test_conn->error);
	$test_row_contracts = $test_result_contracts->fetch_array(MYSQLI_BOTH);
	
	$num_rows_contracts = mysqli_num_rows($test_result_contracts);
	
	$counter = 0;
	
	while ($counter <  $num_rows_contracts){
			
		if($test_row_contracts['contract_id'] == 566){
			if($test_row_contracts['start_date'] == '2022-02-01' && $test_row_contracts['payment_type'] == 'installments' && $test_row_contracts['contract_creation_date'] == '2021-11-10 00:00:00' && $test_row_contracts['totalamount'] == 450.00) {
				echo 'Contract 566 Information  OKAY. <br>';
				} else {
				echo 'Contract 566 Information  NOT AS EXPECTED. <br>';
			}
		}
			$test_row_contracts = $test_result_contracts->fetch_array(MYSQLI_BOTH);
			$counter++;
	}
	
	if($num_rows_contracts == 7){
		echo 'Contracts OKAY. <br>';
		} else {
		echo 'Contracts NOT AS EXPECTED. Number of contracts is' .  $num_rows_contracts . '<br>';
		}
		
		
// - 5. Call InsertPayment 
	
	$_POST["todays_date"] = '2021-03-17';
	
	$_POST["contract_id"] = 566;
	$_POST["PaymentAmount"] = 50;
	
	include 'InsertPayment.php';
	echo ' <br>';
		
		
// - 6. Check if it inserted the payment as expected
	//1. Contract 539: Insert First Payment on a contract (infull)
	$test_sql_payment_ct539 = "select * from payment where contract_id = 539;";
	$test_result_ct539 = $test_conn->query($test_sql_payment_ct539) or trigger_error($test_conn->error);
	$test_row_ct539 = $test_result_ct539 ->fetch_array(MYSQLI_BOTH);
	
				
	// 8e. Contract 566: Payment made is less than amount on installments amount;
	$test_sql_payment_ct566 = "select * from payment where contract_id = 566;";
	$test_result_ct566 = $test_conn->query($test_sql_payment_ct566) or trigger_error($test_conn->error);	
	$test_row_ct566 = $test_result_ct566 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct566['amount'] == 50 ){
		echo 'Payment for 566 entered OKAY. <br>';
		} else {
		echo 'Payment for 566 entered NOT AS EXPECTED. ' .  $test_row_ct566['amount'] . ' <br>';
		}
	
	
		
	
			
		
	// 8e. Contract 566: Payment made is less than amount on installments amount;
	$test_sql_nextpayment_ct566 = "select * from nextpayment where contractID = 566;";
	$test_result_nextpayment_ct566 = $test_conn->query($test_sql_nextpayment_ct566) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct566 = $test_result_nextpayment_ct566  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct566['nextPaymentDate'] == '2021-11-10' && $test_row_nextpayment_ct566['nextPaymentAmount'] == 175 ){
		echo 'Next Payment Date and Amount for 566 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 566  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct566['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct566['nextPaymentAmount'] . ' <br>';
		}
	 
// - 8. Clean Up


	$cleanupsql_1 = "delete from payment where contract_id in (566); 
					 update nextpayment set nextPaymentDate = '2021-11-10', nextPaymentAmount = 225 where contractID in (566);";
	
	$test_conn ->multi_query($cleanupsql_1)
	or trigger_error($test_conn->error);
	
	$test_conn->close();
	session_destroy();

?>