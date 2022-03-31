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
	
	$todays_date = date_create(date("Y-m-d"));

	if(isset($_POST["todays_date"])){
		$todays_date = new DateTime($_POST["todays_date"]);
		}
    

	$sql = "INSERT INTO englishschooldb.payment (contract_id, amount, received_date, payment_type) VALUES (" . $_POST["contract_id"] . "," . $_POST["DiscountAmount"] . ",'" . $todays_date -> format('Y-m-d') . "','discount');";
	
	$sql2 = "INSERT INTO englishschooldb.payment (contract_id, amount, received_date, payment_type) VALUES (,,'','discount');";
	
	if($sql != $sql2){
		$result = $conn->query($sql)
		or trigger_error($conn->error);
		
		$paymentID = mysqli_insert_id($conn);
		if(is_numeric($paymentID)){
			echo 'Discount has been successfully added';
		} else {
			echo 'Error inserting payment!';
		}
	}
	
	
	$currentYear = $todays_date -> format('Y');
	$currentMonth = $todays_date -> format('m');
	
	$sql_contracts = "select * from contracts where contracts.contract_id = " . $_POST["contract_id"];
	
	$result_contracts = $conn->query($sql_contracts)
	or trigger_error($conn->error);
	$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	$contractStatus = "Active";
	
    $class_description = $row_contracts["class_description"];
	
	$start_date = new DateTime($row_contracts["start_date"]);
	$year = $start_date->format('Y');
	$month = $start_date->format('m');
	$nextyear = $year + 1;
	$lastyear = $year - 1;
	$school_year = $row_contracts["school_year"];
	
	// Get rates from locationgroupslevels
    $sql_rates = "select * from locationgroupslevels where school_year = '" . $school_year . "' and class_description = '" . $class_description . "';";
	$result_rates = $conn->query($sql_rates)
	or trigger_error($conn->error);
	$row_rates = $result_rates->fetch_array(MYSQLI_BOTH);
	
	//Variables needed for CalculatePayDates.php
	$startDate = new DateTime($row_contracts["start_date"]);
	$contract_id = $_POST["contract_id"];
	
	if($startDate -> format('m') >= 7){
			$endschoolyear = $startDate-> format('Y') + 1; 
		} else {
			$endschoolyear = $startDate-> format('Y'); 
		}
	
	$endschooldate = new DateTime($endschoolyear  . "-6-30");
	

	
	include 'CalculatePayDates.php';
	
	//$nrPaymentsInstallments = count($date_array) + 1;
	
	include 'CalculateNextPayment.php';
	
	if($nextpayment > 0){
		//Paid in full
		
		if($row_contracts["payment_type"] == "pay in full" ){
			
			if($amountdue > $row_rates['price_in_full']/2){
				$nextPaymentDueDate = new DateTime($row_contracts["contract_creation_date"]);
			}
			
			if($amountdue < $row_rates['price_in_full']/2){
				if(date_format(new DateTime($row_contracts["start_date"]), "m") >= 2 && date_format(new DateTime($row_contracts["start_date"]), "m") <= 6){
					$nextPaymentDueDate = new DateTime($row_contracts["contract_creation_date"]);
					} else {
					if (!is_null($february)){
						$nextPaymentDueDate = $february;
						} else {
						$nextPaymentDueDate = new DateTime($row_contracts["contract_creation_date"]);
					}
				}
			}
			
			
			if($amountdue == $row_rates['price_in_full']/2){
				if (!is_null($february)){
					$nextPaymentDueDate = $february;
					} else {
					$nextPaymentDueDate = new DateTime($row_contracts["contract_creation_date"]);
				}
			}
		}
		//Sorts the dates in the payment due date array
		
		if($row_contracts["payment_type"] == "installments" ){
			sort($date_array);
			$i = count($date_array);
			$amountLeft = $amountdue;
			
			while($i > 0){
				$amountLeft = $amountLeft - $installmentAmount;
							
				if($amountLeft > 0){
					$i--;	
				} else {
					$nextPaymentDueDate = $date_array[$i-1];
					break;
					}
			}
	
		/*
			$nrOfPaymentsLeft = ceil($amountdue/$nrPaymentsInstallments);
			
			
			var_dump($date_array);
			
			if($nrOfPaymentsLeft > count($date_array) ){
				$nextPaymentDueDate = $row_contracts["contract_creation_date"];
				} else {
				
				$nextPaymentDueDate = date_format($date_array[count($date_array) - $nrOfPaymentsLeft], "Y-m-d");
				
			}*/
		}
	} else {
		$nextPaymentDueDate = $todays_date;
	}
	
	var_dump($date_array);
	// echo 'NPDD: ' . $nextPaymentDueDate;
	
	$sql_updateNextPayment = "UPDATE englishschooldb.nextpayment SET nextPaymentDate = '" . date_format($nextPaymentDueDate, "Y-m-d") . "', nextPaymentAmount = " . $nextpayment . " where contractID = " . $_POST["contract_id"] . ";";

	$isNextPaymentUpdated = $conn->query($sql_updateNextPayment) or trigger_error($conn->error);
	
	if ($isNextPaymentUpdated){echo 'Update Successful';} else {echo 'Update Failed';}
	
	$conn->close();

	
	
	
?>

<br></br>
<button onclick="window.location.href='SearchRetrieve.php'">Go to Search Page</button>
<button onclick="window.location.href='contracts.php'">Contracts Overview</button>
