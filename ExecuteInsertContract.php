<?php
	
	session_start();
	
	$_POST =  $_SESSION['insert-contract'];
	$studentID =  $_GET['studentID'];
	
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
	
	$starter = 0;
	if(isset($_POST["starter"])){
		$starter = 1;
	}
	
	$book = 0;
	if(isset($_POST["book"])){
		$book = 1;
	}
	
	// TODO: Sql query needs to take into consideration the location when pulling out dates from DB
	// Selects most recent value from settings
	$sql_settings = "select * from settings order by settings_date desc limit 1;";
	$result_settings = $conn->query($sql_settings)
	or trigger_error($conn->error);
	$row_settings = $result_settings->fetch_array(MYSQLI_BOTH);
	
	echo 'echo $row_settings';
	echo $row_settings['contract_amount_installments'];
	echo '<br>';
	
	$sql_payDate_settings = "select * from settings_payment_due_dates;";
	$result_sql_payDate_settings = $conn->query($sql_payDate_settings)
	or trigger_error($conn->error);
	$row_sql_payDate_settings = $result_sql_payDate_settings->fetch_array(MYSQLI_BOTH);
	
	// Defaulting to group lessons
	$nrOfPayments = 0;
	
	//Pay in full option:
	// If contract start date is July - Jan -> 2 payments
	// If contract start date is Feb - June -> 1 payment
	
	if(isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){
		if($_POST['month'] >= 2 && $_POST['month'] <= 6){
			$nrOfPayments = 1;
			} else {
			$nrOfPayments = 2;
		}
	}
	
	// To calculate the number of lessons left
	//1. Get the start_date from the post_data
	$startDate = new DateTime($_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day']);
	
	//When there is more than one class in the sql table we will select by class -- currently only one class available in db
	$sql_lesCount = "select * from classdates order by date_id;";
	$result_lesCount = $conn->query($sql_lesCount)
	or trigger_error($conn->error);
	$row_lesCount = $result_lesCount->fetch_array(MYSQLI_BOTH);
	
	//Iterate over each date column value to get date that is => start_date
	// To get the first date of the scheduled lessons that is greater that than the start date of the contract
	$i = 1;
	$found = 0;
	
	while($i <= 60 && !$found) {
		$date = 'date' . $i;
		$lesDate = new DateTime($row_lesCount[$date]);
		if ($lesDate >= $startDate){
			$found = 1;
			} else {
			$i++;
		}
	}
	
	$nrLessons = 60 - ($i - 1);
	
	//Pay in installments option:
	// Assumption: Nr payments = Nr of payment due dates left in the school year + 1
	
	$date_array = [];
	
	// if start date is between July and December then school year end current year + 1
	// if start date is between January and June then school year end = current year
	
	$endschoolyear = 0;
	
	if($startDate -> format('m') >= 7){
			$endschoolyear = $startDate-> format('Y') + 1; 
		} else {
			$endschoolyear = $startDate-> format('Y'); 
		}
	
	$endschooldate = new DateTime($endschoolyear  . "-6-30");
	
	// If date is a few days in the future we dont count it
	// If date is not in the school year, we dont count it/If start date is in this school year, we count it
	
	// Find all valid paydates and add to the $date_array
	
	while(!is_null($row_sql_payDate_settings)){
		
		$staticStartDate = new DateTime($startDate -> format('Y-m-d'));
		$startDatePlus10 = $staticStartDate ->add(new DateInterval('P10D'));
		
		//if pay date is between start date of contract and end of school year, then we keep it. 
		$payDate =  new DateTime($row_sql_payDate_settings['due_year'] . "-" . $row_sql_payDate_settings['due_month'] . "-" . $row_sql_payDate_settings['due_day']);
		
		// We add 10 days to the start date so that a payment date within 10 days of the contract start date will not count
		if($payDate > $startDatePlus10 && $payDate < $endschooldate){
			$date_array[] = $payDate;
			}
			
		//Get the next date from the results array
		$row_sql_payDate_settings = $result_sql_payDate_settings->fetch_array(MYSQLI_BOTH); 
	}
	
	
	//if rate type = installments, then the nr of payments = the number of dates in the array + 1
	if(isset($_POST["rate"]) && $_POST["rate"] == "installments"){
		$nrOfPayments = count($date_array) + 1;
	}
	
	$grouplessons = 1;
	$individuallessons = 0;
	$price_per_les = $row_settings['contract_amount_installments']/60;
	$basePrice = $price_per_les * $nrLessons;
	
	// Pay in full
	
	if (isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){
		$discount = $row_settings['contract_amount_infull']/$row_settings['contract_amount_installments'];
		$totalContractAmount = $basePrice * $discount;	
	}
	
	//Pay in installments
	
	if (isset($_POST["rate"]) && $_POST["rate"] == "installments"){
		$totalContractAmount = $basePrice;
	}
	
	
	// SQL Query
	
	$sql =  "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, totalamount, grouplessons, individuallessons, contract_signed, comments, lesson_count, start_date, contract_creation_date) VALUES
	('" . $studentID . "', '"
	. $_POST['locSelect'] . "', '"
	. $_POST['ageGroup'] . "', '"
	. $_POST['levelSelect'] . "', '"
	. $_POST['rate'] . "', "
	. $starter . ", "
	. $book . ", "
	. $nrOfPayments . ", "
	. $totalContractAmount. ", "
	. $grouplessons . ", "
	. $individuallessons . ", "
	. "0, '"
	. $_POST['comments'] . "', "
	. $nrLessons . ", '"
	. $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "', '"
	. date("Y-m-d")."');";
	
	$sql2 = "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, totalamount, grouplessons, individuallessons, contract_signed, comments, start_date, contract_creation_date) VALUES ('', '', '', '', '', 0, 0, 0, 1, 0, 0, '', 60,'--', '". date("Y-m-d")."');";
	
	if($sql != $sql2){
		$result = $conn->query($sql)
		or trigger_error($conn->error);
		$contractID = mysqli_insert_id($conn);
		}
	
	
	$currentYear = date("Y");
	$currentMonth = date("m");
	
	$sql_contracts = "select * from contracts where contracts.contract_id = " . $contractID;
		
	$result_contracts = $conn->query($sql_contracts)
	or trigger_error($conn->error);
	$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	
	$contractStatus = "Active";
	
	include 'CalculatePayDates.php';
	include 'CalculateNextPayment.php';
	
	//Insert into nextPayment table nextPayment dates and nextPayment amounts
	$sql_nextPayment = "INSERT INTO englishschooldb.nextPayment (contractID, nextPaymentDate, nextPaymentAmount) VALUES (" . $contractID . ",'" . date("Y-m-d") . "'," . $nextpayment . ");";
	$result_nextPayment = $conn->query($sql_nextPayment)
	or trigger_error($conn->error);
	mysqli_insert_id($conn);
		

	$conn->close();
	
	$_POST = array(); // Clears post data
	
	if ($contractID != 0){
		header("Location: DisplayPrintContract.php?studentID=".$studentID."&contractID=".$contractID);
		} else {
		echo "Error adding contract";}
	
?>




