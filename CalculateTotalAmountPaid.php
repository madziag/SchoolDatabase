<?php
	
	$servername = 'localhost';
	$username = 'MadziaG';
	$password = 'P$i@krew2018User';
	$dbname = 'englishschooldb';
		
	// Create connection
    $conn_pay = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn_pay->connect_error) {
		die("Connection failed: " . $conn_pay->connect_error);
	}
	
	
	$sql_payments = "select * from payment where contract_id = " . $row_contracts["contract_id"];
	
	$result_payments = $conn_pay->query($sql_payments)
	or trigger_error($conn_pay->error);
	$row_payments = $result_payments->fetch_array(MYSQLI_BOTH);
	$num_rows_payments = mysqli_num_rows($result_payments);
	
	$total_amount_paid = 0;
	
	for($j = 1; $j <= $num_rows_payments; $j++){
		$total_amount_paid += $row_payments["amount"];
		$row_payments = $result_payments->fetch_array(MYSQLI_BOTH);
	}
	
	
	$conn_pay->close();
?>