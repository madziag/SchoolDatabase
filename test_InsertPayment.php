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

// - 3. Check Payments table to see if previous payments are as expected

// - 4. Check contract to see if it has the values we need 

// - 5. Call InsertPayment 
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