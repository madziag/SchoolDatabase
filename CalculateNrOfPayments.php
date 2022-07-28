<?php
/* What is needed: 
1. $_POST["rate"]
2. $_POST["month"]
3. $startDate

What is returned -> $nrOfPayments
*/
	// Get payment due dates
	$sql_payDate_settings = "select * from settings_payment_due_dates;";
	$result_sql_payDate_settings = $conn->query($sql_payDate_settings)
	or trigger_error($conn->error);
	$row_sql_payDate_settings = $result_sql_payDate_settings->fetch_array(MYSQLI_BOTH);
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
	//Pay in installments option:
	// Assumption: Nr payments = Nr of payment due dates left in the school year + 1
	
	// If date is a few days in the future we dont count it
	// If date is not in the school year, we dont count it/If start date is in this school year, we count it
	
	// Find all valid paydates and add to the $date_array
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
?>