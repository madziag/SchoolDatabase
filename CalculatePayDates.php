<?php
// THE FILE GETS THE VALID PAYDATES OUT OF THE SETTINGS_PAYMENTS_DUE_DATES TABLE
// VALID DUE DATES ARE DATES IN THE SCHOOL YEAR
// SCHOOL YEAR IS DEFINED AS BETWEEEN THE START DATE OF THE CONTRACT AND THE ENDSCHOOLDATE
// $startDate and $endschooldate MUST EXIST IN ANY FILE THAT CALLS THIS FILE

	$servername2 = 'localhost';
	$username2 = 'MadziaG';
	$password2 = 'P$i@krew2018User';
	$dbname2 = 'englishschooldb';
	
	
	// Create connection
    $conn2 = new mysqli($servername2, $username2, $password2, $dbname2);
	// Check connection
	if ($conn2->connect_error) {
		die("Connection failed: " . $conn2->connect_error);
	}
	
	// Gets the due dates from the database
	
	$sql_payDate_settings2 = "select * from settings_payment_due_dates;";
	$result_sql_payDate_settings2 = $conn2->query($sql_payDate_settings2)
	or trigger_error($conn2->error);
	$row_sql_payDate_settings2 = $result_sql_payDate_settings2->fetch_array(MYSQLI_BOTH);
	
	$sql_contracts = "select * from contracts where contract_id = " . $contract_id . " ;";
	$result_sql_contracts = $conn2->query($sql_contracts)
	or trigger_error($conn2->error);
	$row_sql_contracts = $result_sql_contracts->fetch_array(MYSQLI_BOTH);
	$contract_creation_date = new DateTime($row_sql_contracts["contract_creation_date"]);
	$class_description = $row_sql_contracts["class_description"];
	//$school_year is defined by the caller

	
	
	// Get rates from locationgroupslevels
    $sql_rates = "select * from locationgroupslevels where school_year = '" . $school_year . "' and class_description = '" . $class_description . "';";
	$result_rates = $conn->query($sql_rates)
	or trigger_error($conn->error);
	$row_rates = $result_rates->fetch_array(MYSQLI_BOTH);
	

	
	
	

	
	//Pay in installments option:
	// Assumption: Nr payments = Nr of payment due dates left in the school year + 1
	
	//$date_array -> stores payment due dates for a specific contract 
	//$school_year_date_array -> stores payment due dates for a particular school year
	
	$date_array = [];
	$school_year_date_array = [];
	
	//Calculate installment amount based on number of payments in school year
	$startSchoolDate = new DateTime($endschooldate -> format('Y-m-d'));
	//To get the start date of school year, we first subtract 10 months from the endof school year - June 30, which gives us Aug 30. We then add 2 days to give us the start date of Sept 1
	$startSchoolDate ->sub(new DateInterval('P10M'));
	$startSchoolDate ->add(new DateInterval('P2D'));
		
	/*echo '<br>';
	echo 'Start School Date';
	echo $startSchoolDate -> format('Y-m-d');
	echo '<br>';*/
	
	// If date is a few days in the future we dont count it
	// If date is not in the school year, we dont count it/If start date is in this school year, we count it
	
	//$counter = 0; 
	
	while(!is_null($row_sql_payDate_settings2)){
	
		$staticStartDate = new DateTime($startDate -> format('Y-m-d'));
		$startDatePlus10 = $staticStartDate ->add(new DateInterval('P10D'));
		/*echo "<br>";
	    echo "START DATE PLUS10 BEFORE!!!!";
		echo $startDatePlus10 -> format('Y-m-d');
		echo "<br>";
		echo "<br>";
	    echo "STATIC START DATE!!!!";
		echo $staticStartDate-> format('Y-m-d');
		echo "<br>";*/
		
		
		//if pay date is between start date of contract and end of school year, then we keep it. 
		$payDate =  new DateTime($row_sql_payDate_settings2['due_year'] . "-" . $row_sql_payDate_settings2['due_month'] . "-" . $row_sql_payDate_settings2['due_day']);
		
		// We add 10 days to the start date so that a payment date within 10 days of the contract start date will not count
		if($payDate > $startDatePlus10 && $payDate < $endschooldate){
			$date_array[] = $payDate;
			}
			
		if($payDate > $startSchoolDate && $payDate < $endschooldate){
			if($payDate -> format('m') == 2) {
				$february = $payDate;
				}
			$school_year_date_array[] = $payDate;
			}
				
		
		//Get the next date from the results array
		$row_sql_payDate_settings2 = $result_sql_payDate_settings2->fetch_array(MYSQLI_BOTH);
	}

		
	array_unshift($date_array, $contract_creation_date);

		
	$nrInstallmentsPerYear = count($school_year_date_array) + 1;
	$installmentAmount = $row_rates['price_in_installments']/$nrInstallmentsPerYear;
 
    
	
	$conn2->close();
	
?>




