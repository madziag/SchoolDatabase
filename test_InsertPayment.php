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

	$test_sql_settings = "select * from settings order by settings_date desc limit 1;";
	
	$test_result_settings = $test_conn->query($test_sql_settings)
	or trigger_error($test_conn->error);
	$test_row_settings = $test_result_settings->fetch_array(MYSQLI_BOTH);
	
	if($test_row_settings['contract_amount_installments'] == 900){
		echo 'contract_amount_installments is okay. <br>';} 
	else {
		echo 'contract_amount_installments is NOT AS EXPECTED, <br>';
		}

	if($test_row_settings['contract_amount_infull'] == 818){
		echo 'contract_amount_infull is okay. <br>';} 
	else {
		echo 'contract_amount_infull is NOT AS EXPECTED, <br>';
		}

// - 2. Check if the data needed is there (settings_payment_due_dates table must have correct payment_due_date)
	
	$test_sql_settings_payment_due_dates = "select * from settings_payment_due_dates;";
	
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
	$test_sql_contracts = "select * from contracts where contract_id >= 539 and contract_id <= 544;";
	
	$test_result_contracts = $test_conn->query($test_sql_contracts)
	or trigger_error($test_conn->error);
	$test_row_contracts = $test_result_contracts->fetch_array(MYSQLI_BOTH);
	
	$num_rows_contracts = mysqli_num_rows($test_result_contracts);
	
	$counter = 0;
	
	while ($counter <  $num_rows_contracts){
	
		// We want to check: start_date, payment_type, contract_creation_date, totalamount;
		if($test_row_contracts['contract_id'] == 539){
			if ($test_row_contracts['start_date'] == '2021-09-01' && $test_row_contracts['payment_type'] == 'pay in full' && $test_row_contracts['contract_creation_date'] == '2021-03-09 00:00:00' && $test_row_contracts['totalamount'] == 818.00) {
				echo 'Contract 539 Information  OKAY. <br>';
			} else {
				echo 'Contract 539 Information  NOT AS EXPECTED. <br>';
			}
		}
		
		if($test_row_contracts['contract_id'] == 540){
			if($test_row_contracts['start_date'] == '2021-09-01' && $test_row_contracts['payment_type'] == 'installments' && $test_row_contracts['contract_creation_date'] == '2021-03-09 00:00:00' && $test_row_contracts['totalamount'] == 900.00) {
				echo 'Contract 540 Information  OKAY. <br>';
			} else {
				echo 'Contract 540 Information  NOT AS EXPECTED. <br>';
			}
		}
			
			
		if($test_row_contracts['contract_id'] == 541){
			if($test_row_contracts['start_date'] == '2021-10-01' && $test_row_contracts['payment_type'] == 'installments' && $test_row_contracts['contract_creation_date'] == '2021-03-09 00:00:00' && $test_row_contracts['totalamount'] == 780.00) {
				echo 'Contract 541 Information  OKAY. <br>';
				} else {
				echo 'Contract 541 Information  NOT AS EXPECTED. <br>';
			}
		}
		
		if($test_row_contracts['contract_id'] == 542){
			if($test_row_contracts['start_date'] == '2022-02-01' && $test_row_contracts['payment_type'] == 'installments' && $test_row_contracts['contract_creation_date'] == '2021-03-09 00:00:00' && $test_row_contracts['totalamount'] == 450.00) {
				echo 'Contract 542 Information  OKAY. <br>';
				} else {
				echo 'Contract 542 Information  NOT AS EXPECTED. <br>';
			}
		}

		if($test_row_contracts['contract_id'] == 543){
			if($test_row_contracts['start_date'] == '2022-04-01' && $test_row_contracts['payment_type'] == 'installments' && $test_row_contracts['contract_creation_date'] == '2021-03-09 00:00:00' && $test_row_contracts['totalamount'] == 180.00) {
				echo 'Contract 543 Information  OKAY. <br>';
				} else {
				echo 'Contract 543 Information  NOT AS EXPECTED. <br>';
			}
		}

		if($test_row_contracts['contract_id'] == 544){
			if($test_row_contracts['start_date'] == '2022-02-01' && $test_row_contracts['payment_type'] == 'pay in full' && $test_row_contracts['contract_creation_date'] == '2021-03-09 00:00:00' && $test_row_contracts['totalamount'] == 409.00) {
				echo 'Contract 543 Information  OKAY. <br>';
				} else {
				echo 'Contract 543 Information  NOT AS EXPECTED. <br>';
			}
		}
			$test_row_contracts = $test_result_contracts->fetch_array(MYSQLI_BOTH);
			$counter++;
	}
	
	if($num_rows_contracts == 6){
		echo 'Contracts OKAY. <br>';
		} else {
		echo 'Contracts NOT AS EXPECTED. Number of contracts is' .  $num_rows_contracts . '<br>';
		}
		
		
// - 5. Call InsertPayment 
	$_POST["todays_date"] = '2021-03-17';
	$_POST["contract_id"] = 539;
	$_POST["PaymentAmount"] = 225;

	include 'InsertPayment.php';

// - 6. Check if it inserted the payment as expected
// - 7. Check if the update in the nextpayment table worked as expected

// - Scenarios that we want to test:
// - 1. Insert First Payment on a contract (infull) -> contractID 539
// - 2. Insert First Payment on a contract (installments) -> contractID 540
// - 3. Insert First Payments if student starts after the beginning of the school year
// a. October Installments -> contractID 541
// b. February Installments -> contractID 542
// c. April Installments -> contractID 543
// d. February Infull -> contractID 544

// WE NEED TO CLEAN UP FROM PREVIOUS TESTS - RETURN DB TO STATE BEFORE WE RAN THE TESTS
// - 4. Insert Payment just before the next payment due date (infull/installments)
// a. Infull -> contractID 539
// b. Installments -> contractID 540

// WE NEED TO CLEAN UP FROM PREVIOUS TESTS - RETURN DB TO STATE BEFORE WE RAN THE TESTS
// - 5. Insert Payment on the due date (infull/installments)
// a. Infull -> contractID 539
// b. Installments -> contractID 540

// WE NEED TO CLEAN UP FROM PREVIOUS TESTS - RETURN DB TO STATE BEFORE WE RAN THE TESTS
// - 6. Insert Payment after the due date (infull/installments)
// a. Infull -> contractID 539
// b. Installments -> contractID 540

// WE NEED TO CLEAN UP FROM PREVIOUS TESTS - RETURN DB TO STATE BEFORE WE RAN THE TESTS

// - We need to change insert payment to allow us to fake a different payment date -- done




































?>