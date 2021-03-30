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
	
	//1. Contract 539: Insert First Payment on a contract (infull)
	$_POST["contract_id"] = 539;
	$_POST["PaymentAmount"] = 409;

	include 'InsertPayment.php';
	echo ' <br>';
	
	//2. Contract 540: Insert First Payment on a contract (installments) 
	$_POST["contract_id"] = 540;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	//3a. Contract 541: Insert First Payments if student starts after the beginning of the school year - October Installments 
	$_POST["contract_id"] = 541;
	$_POST["PaymentAmount"] = 105;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 3b. Contract 542: Insert First Payments if student starts after the beginning of the school year - February Installments 
	$_POST["contract_id"] = 542;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 3c.Contract 543: Insert First Payments if student starts after the beginning of the school year - April Installments 
	$_POST["contract_id"] = 543;
	$_POST["PaymentAmount"] = 180;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 3d.Contract 544: Insert First Payments if student starts after the beginning of the school year - February Infull
	$_POST["contract_id"] = 544;
	$_POST["PaymentAmount"] = 409;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 4a. Contract 545: Insert Payment just before the next payment due date - Infull 
	$_POST["todays_date"] = '2022-01-25';
	
	$_POST["contract_id"] = 545;
	$_POST["PaymentAmount"] = 409;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 4b. Contract 546: Insert Payment just before the next payment due date - Installments
	$_POST["todays_date"] = '2021-10-28';
	
	$_POST["contract_id"] = 546;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 5a. Contract 547: Insert Payment on the due date - Infull
	$_POST["todays_date"] = '2022-02-10';
	
	$_POST["contract_id"] = 547;
	$_POST["PaymentAmount"] = 409;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 5b. Contract 548: Insert Payment on the due date - Installments
	$_POST["todays_date"] = '2021-11-10';
	
	$_POST["contract_id"] = 548;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 6a. Contract 549: Insert Payment after the due date - Infull
	$_POST["todays_date"] = '2022-02-18';
	
	$_POST["contract_id"] = 549;
	$_POST["PaymentAmount"] = 409;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 6b. Contract 550: Insert Payment after the due date - Installments
	$_POST["todays_date"] = '2021-11-15';
	
	$_POST["contract_id"] = 550;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 7a. Contract 551: Insert Payment after the due date (after the last possible due date - March) - Infull
	$_POST["todays_date"] = '2022-03-10';
	
	$_POST["contract_id"] = 551;
	$_POST["PaymentAmount"] = 409;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 7b. Contract 552: Insert Payment after the due date (after the last possible due date - May)  - Installments
	$_POST["todays_date"] = '2022-05-05';
	
	$_POST["contract_id"] = 552;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 7c. Contract 553: Insert Payment after the due date (after due date but before last possible due date - March)  - Installments
	$_POST["todays_date"] = '2022-03-15';
	
	$_POST["contract_id"] = 553;
	$_POST["PaymentAmount"] = 225;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 8a. Contract 554: Payment made is less than amount on infull amount - first payment on contract made in September;	
	$_POST["todays_date"] = '2021-09-15';
	
	$_POST["contract_id"] = 554;
	$_POST["PaymentAmount"] = 350;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 8b. Contract 555: Payment made is less than amount on installments amount - second payment on contract made in November on time;
	$_POST["todays_date"] = '2021-11-10';
	
	$_POST["contract_id"] = 555;
	$_POST["PaymentAmount"] = 200;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 8c. Contract 556: Payment made is more than amount on infull amount - pay whole year in one go ;
	$_POST["todays_date"] = '2021-09-15';
	
	$_POST["contract_id"] = 556;
	$_POST["PaymentAmount"] = 818;
	
	include 'InsertPayment.php';
	echo ' <br>';
	
	// 8d. Contract 557: Payment made is more than amount on installments amount - pay for the semester;
	$_POST["todays_date"] = '2022-09-15';
	
	$_POST["contract_id"] = 557;
	$_POST["PaymentAmount"] = 450;
	
	include 'InsertPayment.php';
	echo ' <br>';
		
		
// - 6. Check if it inserted the payment as expected
	//1. Contract 539: Insert First Payment on a contract (infull)
	$test_sql_payment_ct539 = "select * from payment where contract_id = 539;";
	$test_result_ct539 = $test_conn->query($test_sql_payment_ct539) or trigger_error($test_conn->error);
	$test_row_ct539 = $test_result_ct539 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct539['amount'] == 409 ){
		echo 'Payment for 539 entered OKAY. <br>';
		} else {
		echo 'Payment for 539 entered NOT AS EXPECTED. ' .  $test_row_ct539['amount'] . ' <br>';
		}

	//2. Contract 540: Insert First Payment on a contract (installments) 
	$test_sql_payment_ct540 = "select * from payment where contract_id = 540;";
	$test_result_ct540 = $test_conn->query($test_sql_payment_ct540) or trigger_error($test_conn->error);	
	$test_row_ct540 = $test_result_ct540 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct540['amount'] == 225 ){
		echo 'Payment for 540 entered OKAY. <br>';
		} else {
		echo 'Payment for 540 entered NOT AS EXPECTED. ' .  $test_row_ct540['amount'] . ' <br>';
		}
		
	//3a. Contract 541: Insert First Payments if student starts after the beginning of the school year - October Installments
	$test_sql_payment_ct541 = "select * from payment where contract_id = 541;";
	$test_result_ct541 = $test_conn->query($test_sql_payment_ct541) or trigger_error($test_conn->error);
	$test_row_ct541 = $test_result_ct541 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct541['amount'] == 105 ){
		echo 'Payment for 541 entered OKAY. <br>';
		} else {
		echo 'Payment for 541 entered NOT AS EXPECTED. ' .  $test_row_ct541['amount'] . ' <br>';
		}
		
	// 3b. Contract 542: Insert First Payments if student starts after the beginning of the school year - February Installments 
	$test_sql_payment_ct542 = "select * from payment where contract_id = 542;";
	$test_result_ct542 = $test_conn->query($test_sql_payment_ct542) or trigger_error($test_conn->error);	
	$test_row_ct542 = $test_result_ct542 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct542['amount'] == 225 ){
		echo 'Payment for 542 entered OKAY. <br>';
		} else {
		echo 'Payment for 542 entered NOT AS EXPECTED. ' .  $test_row_ct542['amount'] . ' <br>';
		}
	
	// 3c.Contract 543: Insert First Payments if student starts after the beginning of the school year - April Installments 
	$test_sql_payment_ct543 = "select * from payment where contract_id = 543;";
	$test_result_ct543 = $test_conn->query($test_sql_payment_ct543) or trigger_error($test_conn->error);	
	$test_row_ct543 = $test_result_ct543 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct543['amount'] == 180 ){
		echo 'Payment for 543 entered OKAY. <br>';
		} else {
		echo 'Payment for 543 entered NOT AS EXPECTED. ' .  $test_row_ct543['amount'] . ' <br>';
		}
	
	// 3d.Contract 544: Insert First Payments if student starts after the beginning of the school year - February Infull
	$test_sql_payment_ct544 = "select * from payment where contract_id = 544;";
	$test_result_ct544 = $test_conn->query($test_sql_payment_ct544) or trigger_error($test_conn->error);	
	$test_row_ct544 = $test_result_ct544 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct544['amount'] == 409 ){
		echo 'Payment for 544 entered OKAY. <br>';
		} else {
		echo 'Payment for 544 entered NOT AS EXPECTED. ' .  $test_row_ct544['amount'] . ' <br>';
		}


	// 4a. Contract 545: Insert Payment just before the next payment due date - Infull 
	$test_sql_payment_ct545 = "select * from payment where contract_id = 545;";
	$test_result_ct545 = $test_conn->query($test_sql_payment_ct545) or trigger_error($test_conn->error);	
	$test_row_ct545 = $test_result_ct545 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct545['amount'] == 409 ){
		echo 'Payment for 545 entered OKAY. <br>';
		} else {
		echo 'Payment for 545 entered NOT AS EXPECTED. ' .  $test_row_ct545['amount'] . ' <br>';
		}
	
	
	// 4b. Contract 546: Insert Payment just before the next payment due date - Installments
	$test_sql_payment_ct546 = "select * from payment where contract_id = 546;";
	$test_result_ct546 = $test_conn->query($test_sql_payment_ct546) or trigger_error($test_conn->error);	
	$test_row_ct546 = $test_result_ct546 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct546['amount'] == 225 ){
		echo 'Payment for 546 entered OKAY. <br>';
		} else {
		echo 'Payment for 546 entered NOT AS EXPECTED. ' .  $test_row_ct546['amount'] . ' <br>';
		}
	
	// 5a. Contract 547: Insert Payment on the due date - Infull
	$test_sql_payment_ct547 = "select * from payment where contract_id = 547;";
	$test_result_ct547 = $test_conn->query($test_sql_payment_ct547) or trigger_error($test_conn->error);	
	$test_row_ct547 = $test_result_ct547 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct547['amount'] == 409 ){
		echo 'Payment for 547 entered OKAY. <br>';
		} else {
		echo 'Payment for 547 entered NOT AS EXPECTED. ' .  $test_row_ct547['amount'] . ' <br>';
		}
	
	// 5b. Contract 548: Insert Payment on the due date - Installments
	$test_sql_payment_ct548 = "select * from payment where contract_id = 548;";
	$test_result_ct548 = $test_conn->query($test_sql_payment_ct548) or trigger_error($test_conn->error);	
	$test_row_ct548 = $test_result_ct548 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct548['amount'] == 225 ){
		echo 'Payment for 548 entered OKAY. <br>';
		} else {
		echo 'Payment for 548 entered NOT AS EXPECTED. ' .  $test_row_ct548['amount'] . ' <br>';
		}
	
	// 6a. Contract 549: Insert Payment after the due date - Infull
	$test_sql_payment_ct549 = "select * from payment where contract_id = 549;";
	$test_result_ct549 = $test_conn->query($test_sql_payment_ct549) or trigger_error($test_conn->error);	
	$test_row_ct549 = $test_result_ct549 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct549['amount'] == 409 ){
		echo 'Payment for 549 entered OKAY. <br>';
		} else {
		echo 'Payment for 549 entered NOT AS EXPECTED. ' .  $test_row_ct549['amount'] . ' <br>';
		}
	
	// 6b. Contract 550: Insert Payment after the due date - Installments
	$test_sql_payment_ct550 = "select * from payment where contract_id = 550;";
	$test_result_ct550 = $test_conn->query($test_sql_payment_ct550) or trigger_error($test_conn->error);	
	$test_row_ct550 = $test_result_ct550 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct550['amount'] == 225 ){
		echo 'Payment for 550 entered OKAY. <br>';
		} else {
		echo 'Payment for 550 entered NOT AS EXPECTED. ' .  $test_row_ct550['amount'] . ' <br>';
		}

	// 7a. Contract 551: Insert Payment after the due date (after the last possible due date - March) - Infull
	$test_sql_payment_ct551 = "select * from payment where contract_id = 551;";
	$test_result_ct551 = $test_conn->query($test_sql_payment_ct551) or trigger_error($test_conn->error);	
	$test_row_ct551 = $test_result_ct551 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct551['amount'] == 409 ){
		echo 'Payment for 551 entered OKAY. <br>';
		} else {
		echo 'Payment for 551 entered NOT AS EXPECTED. ' .  $test_row_ct551['amount'] . ' <br>';
		}
	
	// 7b. Contract 552: Insert Payment after the due date (after the last possible due date - May)  - Installments
	$test_sql_payment_ct552 = "select * from payment where contract_id = 552;";
	$test_result_ct552 = $test_conn->query($test_sql_payment_ct552) or trigger_error($test_conn->error);	
	$test_row_ct552 = $test_result_ct552 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct552['amount'] == 225 ){
		echo 'Payment for 552 entered OKAY. <br>';
		} else {
		echo 'Payment for 552 entered NOT AS EXPECTED. ' .  $test_row_ct552['amount'] . ' <br>';
		}
		
		
	// 7c. Contract 553: Insert Payment after the due date (after due date but before last possible due date - March)  - Installments
	$test_sql_payment_ct553 = "select * from payment where contract_id = 553;";
	$test_result_ct553 = $test_conn->query($test_sql_payment_ct553) or trigger_error($test_conn->error);	
	$test_row_ct553 = $test_result_ct553 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct553['amount'] == 225 ){
		echo 'Payment for 553 entered OKAY. <br>';
		} else {
		echo 'Payment for 553 entered NOT AS EXPECTED. ' .  $test_row_ct553['amount'] . ' <br>';
		}
		
	// 8a. Contract 554: Payment made is less than amount on infull amount - first payment on contract made in September;
	$test_sql_payment_ct554 = "select * from payment where contract_id = 554;";
	$test_result_ct554 = $test_conn->query($test_sql_payment_ct554) or trigger_error($test_conn->error);	
	$test_row_ct554 = $test_result_ct554 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct554['amount'] == 350 ){
		echo 'Payment for 554 entered OKAY. <br>';
		} else {
		echo 'Payment for 554 entered NOT AS EXPECTED. ' .  $test_row_ct554['amount'] . ' <br>';
		}
		
	// 8b. Contract 555: Payment made is less than amount on installments amount - second payment on contract made in November on time;
	$test_sql_payment_ct555 = "select * from payment where contract_id = 555;";
	$test_result_ct555 = $test_conn->query($test_sql_payment_ct555) or trigger_error($test_conn->error);	
	$test_row_ct555 = $test_result_ct555 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct555['amount'] == 200 ){
		echo 'Payment for 555 entered OKAY. <br>';
		} else {
		echo 'Payment for 555 entered NOT AS EXPECTED. ' .  $test_row_ct555['amount'] . ' <br>';
		}
		
	// 8c. Contract 556: Payment made is more than amount on infull amount - pay whole year in one go ;
	$test_sql_payment_ct556 = "select * from payment where contract_id = 556;";
	$test_result_ct556 = $test_conn->query($test_sql_payment_ct556) or trigger_error($test_conn->error);	
	$test_row_ct556 = $test_result_ct556 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct556['amount'] == 818 ){
		echo 'Payment for 556 entered OKAY. <br>';
		} else {
		echo 'Payment for 556 entered NOT AS EXPECTED. ' .  $test_row_ct556['amount'] . ' <br>';
		}
		
	// 8d. Contract 557: Payment made is more than amount on installments amount - pay for the semester;
	$test_sql_payment_ct557 = "select * from payment where contract_id = 557;";
	$test_result_ct557 = $test_conn->query($test_sql_payment_ct557) or trigger_error($test_conn->error);	
	$test_row_ct557 = $test_result_ct557 ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_ct557['amount'] == 450 ){
		echo 'Payment for 557 entered OKAY. <br>';
		} else {
		echo 'Payment for 557 entered NOT AS EXPECTED. ' .  $test_row_ct557['amount'] . ' <br>';
		}
		
	
// - 7. Check if the update in the nextpayment table worked as expected
	//1. Contract 539: Insert First Payment on a contract (infull)
	$test_sql_nextpayment_ct539 = "select * from nextpayment where contractID = 539;";
	$test_result_nextpayment_ct539 = $test_conn->query($test_sql_nextpayment_ct539) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct539 = $test_result_nextpayment_ct539  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct539['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct539['nextPaymentAmount'] == 409 ){
		echo 'Next Payment Date and Amount for 539 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount entered for 539 NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct539['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct539['nextPaymentAmount'] . ' <br>';
		}
		
	//2. Contract 540: Insert First Payment on a contract (installments)
	$test_sql_nextpayment_ct540 = "select * from nextpayment where contractID = 540;";
	$test_result_nextpayment_ct540 = $test_conn->query($test_sql_nextpayment_ct540) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct540 = $test_result_nextpayment_ct540  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct540['nextPaymentDate'] == '2021-11-10' && $test_row_nextpayment_ct540['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 540 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 540  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct540['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct540['nextPaymentAmount'] . ' <br>';
		}
		
	//3a. Contract 541: Insert First Payments if student starts after the beginning of the school year - October Installments
	$test_sql_nextpayment_ct541 = "select * from nextpayment where contractID = 541;";
	$test_result_nextpayment_ct541 = $test_conn->query($test_sql_nextpayment_ct541) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct541 = $test_result_nextpayment_ct541  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct541['nextPaymentDate'] == '2021-11-10' && $test_row_nextpayment_ct541['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 541 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 541  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct541['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct541['nextPaymentAmount'] . ' <br>';
		}
		
	// 3b. Contract 542: Insert First Payments if student starts after the beginning of the school year - February Installments 
	$test_sql_nextpayment_ct542 = "select * from nextpayment where contractID = 542;";
	$test_result_nextpayment_ct542 = $test_conn->query($test_sql_nextpayment_ct542) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct542 = $test_result_nextpayment_ct542  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct542['nextPaymentDate'] == '2022-04-10' && $test_row_nextpayment_ct542['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 542 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 542  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct542['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct542['nextPaymentAmount'] . ' <br>';
		}
		
	// 3c.Contract 543: Insert First Payments if student starts after the beginning of the school year - April Installments 
	$test_sql_nextpayment_ct543 = "select * from nextpayment where contractID = 543;";
	$test_result_nextpayment_ct543 = $test_conn->query($test_sql_nextpayment_ct543) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct543 = $test_result_nextpayment_ct543  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct543['nextPaymentDate'] == '2021-03-17' && $test_row_nextpayment_ct543['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 543 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 543  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct543['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct543['nextPaymentAmount'] . ' <br>';
		}
		
	// 3d.Contract 544: Insert First Payments if student starts after the beginning of the school year - February Infull
	$test_sql_nextpayment_ct544 = "select * from nextpayment where contractID = 544;";
	$test_result_nextpayment_ct544 = $test_conn->query($test_sql_nextpayment_ct544) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct544 = $test_result_nextpayment_ct544  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct544['nextPaymentDate'] == '2021-03-17' && $test_row_nextpayment_ct544['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 544 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 544  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct544['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct544['nextPaymentAmount'] . ' <br>';
		}
		
		
	// 4a. Contract 545: Insert Payment just before the next payment due date - Infull 
	$test_sql_nextpayment_ct545 = "select * from nextpayment where contractID = 545;";
	$test_result_nextpayment_ct545 = $test_conn->query($test_sql_nextpayment_ct545) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct545 = $test_result_nextpayment_ct545  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct545['nextPaymentDate'] == '2022-01-25' && $test_row_nextpayment_ct545['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 545 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 545  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct545['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct545['nextPaymentAmount'] . ' <br>';
		}
	
	
	// 4b. Contract 546: Insert Payment just before the next payment due date - Installments
	$test_sql_nextpayment_ct546 = "select * from nextpayment where contractID = 546;";
	$test_result_nextpayment_ct546 = $test_conn->query($test_sql_nextpayment_ct546) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct546 = $test_result_nextpayment_ct546  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct546['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct546['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 546 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 546  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct546['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct546['nextPaymentAmount'] . ' <br>';
		}
	
	// 5a. Contract 547: Insert Payment on the due date - Infull
	$test_sql_nextpayment_ct547 = "select * from nextpayment where contractID = 547;";
	$test_result_nextpayment_ct547 = $test_conn->query($test_sql_nextpayment_ct547) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct547 = $test_result_nextpayment_ct547  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct547['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct547['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 547 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 547  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct547['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct547['nextPaymentAmount'] . ' <br>';
		}
	
	// 5b. Contract 548: Insert Payment on the due date - Installments
	$test_sql_nextpayment_ct548 = "select * from nextpayment where contractID = 548;";
	$test_result_nextpayment_ct548 = $test_conn->query($test_sql_nextpayment_ct548) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct548 = $test_result_nextpayment_ct548  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct548['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct548['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 548 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 548  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct548['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct548['nextPaymentAmount'] . ' <br>';
		}
	
	// 6a. Contract 549: Insert Payment after the due date - Infull
	$test_sql_nextpayment_ct549 = "select * from nextpayment where contractID = 549;";
	$test_result_nextpayment_ct549 = $test_conn->query($test_sql_nextpayment_ct549) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct549 = $test_result_nextpayment_ct549  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct549['nextPaymentDate'] == '2022-02-18' && $test_row_nextpayment_ct549['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 549 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 549  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct549['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct549['nextPaymentAmount'] . ' <br>';
		}
	
	// 6b. Contract 550: Insert Payment after the due date - Installments
	$test_sql_nextpayment_ct550 = "select * from nextpayment where contractID = 550;";
	$test_result_nextpayment_ct550 = $test_conn->query($test_sql_nextpayment_ct550) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct550 = $test_result_nextpayment_ct550  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct550['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct550['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 550 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 550  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct550['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct550['nextPaymentAmount'] . ' <br>';
		}
		
	// 7a. Contract 551: Insert Payment after the due date (after the last possible due date - March) - Infull
	$test_sql_nextpayment_ct551 = "select * from nextpayment where contractID = 551;";
	$test_result_nextpayment_ct551 = $test_conn->query($test_sql_nextpayment_ct551) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct551 = $test_result_nextpayment_ct551  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct551['nextPaymentDate'] == '2022-03-10' && $test_row_nextpayment_ct551['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 551 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 551  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct551['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct551['nextPaymentAmount'] . ' <br>';
		}
	
	// 7b. Contract 552: Insert Payment after the due date (after the last possible due date - May)  - Installments
	$test_sql_nextpayment_ct552 = "select * from nextpayment where contractID = 552;";
	$test_result_nextpayment_ct552 = $test_conn->query($test_sql_nextpayment_ct552) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct552 = $test_result_nextpayment_ct552  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct552['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct552['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 552 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 552  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct552['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct552['nextPaymentAmount'] . ' <br>';
		}
		
	// 7c. Contract 553: Insert Payment after the due date (after due date but before last possible due date - March)  - Installments
	$test_sql_nextpayment_ct553 = "select * from nextpayment where contractID = 553;";
	$test_result_nextpayment_ct553 = $test_conn->query($test_sql_nextpayment_ct553) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct553 = $test_result_nextpayment_ct553  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct553['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct553['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 553 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 553  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct553['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct553['nextPaymentAmount'] . ' <br>';
		}
	
	// 8a. Contract 554: Payment made is less than amount on infull amount - first payment on contract made in September;
	$test_sql_nextpayment_ct554 = "select * from nextpayment where contractID = 554;";
	$test_result_nextpayment_ct554 = $test_conn->query($test_sql_nextpayment_ct554) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct554 = $test_result_nextpayment_ct554  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct554['nextPaymentDate'] == '2021-03-30' && $test_row_nextpayment_ct554['nextPaymentAmount'] == 59 ){
		echo 'Next Payment Date and Amount for 554 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 554  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct554['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct554['nextPaymentAmount'] . ' <br>';
		}
	
	// 8b. Contract 555: Payment made is less than amount on installments amount - second payment on contract made in November on time;
	$test_sql_nextpayment_ct555 = "select * from nextpayment where contractID = 555;";
	$test_result_nextpayment_ct555 = $test_conn->query($test_sql_nextpayment_ct555) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct555 = $test_result_nextpayment_ct555  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct555['nextPaymentDate'] == '2021-11-10' && $test_row_nextpayment_ct555['nextPaymentAmount'] == 25 ){
		echo 'Next Payment Date and Amount for 555 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 555  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct555['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct555['nextPaymentAmount'] . ' <br>';
		}
	
	// 8c. Contract 556: Payment made is more than amount on infull amount - pay whole year in one go ;
	$test_sql_nextpayment_ct556 = "select * from nextpayment where contractID = 556;";
	$test_result_nextpayment_ct556 = $test_conn->query($test_sql_nextpayment_ct556) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct556 = $test_result_nextpayment_ct556  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct556['nextPaymentDate'] == '2021-09-15' && $test_row_nextpayment_ct556['nextPaymentAmount'] == 0 ){
		echo 'Next Payment Date and Amount for 556 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 556  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct556['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct556['nextPaymentAmount'] . ' <br>';
		}
	
	// 8d. Contract 557: Payment made is more than amount on installments amount - pay for the semester;
	$test_sql_nextpayment_ct557 = "select * from nextpayment where contractID = 557;";
	$test_result_nextpayment_ct557 = $test_conn->query($test_sql_nextpayment_ct557) or trigger_error($test_conn->error);
	$test_row_nextpayment_ct557 = $test_result_nextpayment_ct557  ->fetch_array(MYSQLI_BOTH);
	
	if($test_row_nextpayment_ct557['nextPaymentDate'] == '2022-02-10' && $test_row_nextpayment_ct557['nextPaymentAmount'] == 225 ){
		echo 'Next Payment Date and Amount for 557 entered OKAY. <br>';
		} else {
		echo 'Next Payment Date and Amount for 557  entered NOT AS EXPECTED. NextPaymentDate: ' .  $test_row_nextpayment_ct557['nextPaymentDate'] . 'NextPaymentAmount: ' . $test_row_nextpayment_ct557['nextPaymentAmount'] . ' <br>';
		}
	
	
	
// - 8. Clean Up
	//1. Contract 539: Insert First Payment on a contract (infull)
	//2. Contract 540: Insert First Payment on a contract (installments)
	//3a. Contract 541: Insert First Payments if student starts after the beginning of the school year - October Installments
	//3b. Contract 542: Insert First Payments if student starts after the beginning of the school year - February Installments 
	//3c.Contract 543: Insert First Payments if student starts after the beginning of the school year - April Installments
	//3d.Contract 544: Insert First Payments if student starts after the beginning of the school year - February Infull
	// 4a. Contract 545: Insert Payment just before the next payment due date - Infull 
	// 4b. Contract 546: Insert Payment just before the next payment due date - Installments	
	// 5a. Contract 547: Insert Payment on the due date - Infull
	// 5b. Contract 548: Insert Payment on the due date - Installments
	// 6a. Contract 549: Insert Payment after the due date - Infull
	// 6b. Contract 550: Insert Payment after the due date - Installments
	// 7a. Contract 551: Insert Payment after the due date (after the last possible due date - March) - Infull
	// 7b. Contract 552: Insert Payment after the due date (after the last possible due date - May)  - Installments
	// 7c. Contract 553: Insert Payment after the due date (after due date but before last possible due date - March)  - Installments
	// 8a. Contract 554: Payment made is less than amount on infull amount - first payment on contract made in September;	
	// 8b. Contract 555: Payment made is less than amount on installments amount - second payment on contract made in November on time;
	// 8c. Contract 556: Payment made is more than amount on infull amount - pay whole year in one go ;
	// 8d. Contract 557: Payment made is more than amount on installments amount - pay for the semester;

	$cleanupsql_1 = "delete from payment where contract_id in (539, 540, 541, 542, 543, 544, 554, 556, 557); 
					 delete from payment where contract_id = 545 and received_date = '2022-01-25'; 
					 delete from payment where contract_id = 546 and received_date = '2021-10-28'; 
					 delete from payment where contract_id = 547 and received_date = '2022-02-10'; 
					 delete from payment where contract_id = 548 and received_date = '2021-11-10'; 
					 delete from payment where contract_id = 549 and received_date = '2022-02-18'; 
					 delete from payment where contract_id = 550 and received_date = '2021-11-15'; 
					 delete from payment where contract_id = 551 and received_date = '2022-03-10'; 
					 delete from payment where contract_id = 552 and received_date = '2022-05-05'; 
					 delete from payment where contract_id = 553 and received_date = '2022-03-15'; 
					 delete from payment where contract_id = 555 and received_date = '2021-11-10'; 
					 update nextpayment set nextPaymentDate = '2021-03-09' where contractID in (539,540, 541, 542, 543, 544);
					 update nextpayment set nextPaymentDate = '2021-03-30' where contractID in (554, 556, 557);
					 update nextpayment set nextPaymentAmount = 409 where contractID in (539, 544, 554, 556);
					 update nextpayment set nextPaymentAmount = 225 where contractID in (540, 542, 557);
					 update nextpayment set nextPaymentAmount = 105 where contractID = 541;
					 update nextpayment set nextPaymentAmount = 180 where contractID = 543; 
					 update nextpayment set nextPaymentDate = '2022-02-10', nextPaymentAmount = 409 where contractID  in (545, 547, 549, 551);
					 update nextpayment set nextPaymentDate = '2021-11-10', nextPaymentAmount = 225 where contractID in (546, 548, 550, 552, 553, 555);";
	
	$test_conn ->multi_query($cleanupsql_1)
	or trigger_error($test_conn->error);
	
	





// WE NEED TO CLEAN UP FROM PREVIOUS TESTS - RETURN DB TO STATE BEFORE WE RAN THE TESTS


// WE NEED TO CLEAN UP FROM PREVIOUS TESTS - RETURN DB TO STATE BEFORE WE RAN THE TESTS

// - We need to change insert payment to allow us to fake a different payment date -- done
































$test_conn->close();



?>