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
	
	$school_year = $_POST["SchoolYear"];
	
	$class_description = $_POST['descriptionSelect'];
	
	// Get rates from locationgroupslevels
    $sql_rates = "select * from locationgroupslevels where school_year = '" . $school_year . "' and class_description = '" . $class_description . "';";
	$result_rates = $conn->query($sql_rates)
	or trigger_error($conn->error);
	$row_rates = $result_rates->fetch_array(MYSQLI_BOTH);
	

	
	$nrOfPayments = 0;
	//1. Get the start_date from the post_data
	$startDate = new DateTime($_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day']);
	include "CalculateNrOfPayments.php";
	
	// To calculate the number of lessons left

			
			
	$sql_lesCount = "select * from classdates where school_year = '" . $school_year . "' and class_description = '" . $class_description . "' order by date_id;";
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
	

	
		
	$price_per_les = $row_rates['price_in_installments']/60;
	$basePrice = $price_per_les * $nrLessons;

	// Pay in full
	
	if (isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){
		$discount = $row_rates['price_in_full']/$row_rates['price_in_installments'];
		$totalContractAmount = $basePrice * $discount;		
	}

	
	
	
	//Pay in installments
	
	if (isset($_POST["rate"]) && $_POST["rate"] == "installments"){
		$totalContractAmount = $basePrice;
	}
	
	// SQL Query
	
	$sql =  "INSERT INTO englishschooldb.contracts (student_id, class_description, payment_type, starter, nrpayments, totalamount, contract_signed, comments, lesson_count, start_date, contract_creation_date, school_year) VALUES
	('" . $studentID . "', '"
	. $class_description . "', '"
	. $_POST['rate'] . "', "
	. $starter . ", "
	. $nrOfPayments . ", "
	. $totalContractAmount. ", "
	. "0, '"
	. $_POST['comments'] . "', "
	. $nrLessons . ", '"
	. $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "', '"
	. date("Y-m-d")."','"
	. $school_year . "');";

 
	
	$sql2 = "INSERT INTO englishschooldb.contracts (student_id, class_description, payment_type, starter, nrpayments, totalamount, contract_signed, comments, start_date, contract_creation_date, school_year) VALUES ('', '', '', '', '', 0, 0, 1, 0, 0, '', 60,'--', '". date("Y-m-d")."', '');";
	
	if($sql != $sql2){
		$result = $conn->query($sql)
		or trigger_error($conn->error);
		$contract_id = mysqli_insert_id($conn);
		}
	
	
	$currentYear = date("Y");
	$currentMonth = date("m");
	
	$sql_contracts = "select * from contracts where contracts.contract_id = " . $contract_id;
		
	$result_contracts = $conn->query($sql_contracts)
	or trigger_error($conn->error);
	$row_contracts = $result_contracts->fetch_array(MYSQLI_BOTH);
	
	$contractStatus = "Active";
	
	//Instead of inserting one value in NextPayment table, the table should hold all the payment values associates with the contract
	
	include 'CalculatePayDates.php';
	include 'CalculateNextPayment.php';
	
	//Insert into nextPayment table nextPayment dates and nextPayment amounts
	$sql_nextPayment = "INSERT INTO englishschooldb.nextPayment (contractID, nextPaymentDate, nextPaymentAmount) VALUES (" . $contract_id . ",'" . date("Y-m-d") . "'," . $nextpayment . ");";
	$result_nextPayment = $conn->query($sql_nextPayment)
	or trigger_error($conn->error);
	mysqli_insert_id($conn);
		

	$conn->close();
	
	$_POST = array(); // Clears post data
	
	if ($contract_id != 0){
		header("Location: DisplayPrintContract.php?studentID=".$studentID."&contractID=".$contract_id);
		} else {
		echo "Error adding contract";}
	
?>




