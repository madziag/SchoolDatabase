<?php
// What ExecuteUpdateClass.php does: 
// Updates locationgroupslevels table for 'this' class 
// $sql = "UPDATE locationgroupslevels SET ";
//	$sql = $sql . "class_description = '" . $_POST['ClassDescription'] . "', school_year = '" . $_POST['SchoolYear'] . "',
//	price_in_full = " . $_POST['PricePaymentsFull'] . ", price_in_installments = " . $_POST['PricePaymentsInstallments'] . " where group_id = " . $groupID . ";";

// Data needed for the test
// - $_GET["groupID"], $_POST['ClassDescription'], $_POST['SchoolYear'], $_POST['PricePaymentsFull'], $_POST['PricePaymentsInstallments']


// What is needed to get a correct updated class
// - Valid class in the locationgroupslevels table in the db (group_id = 374)

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
	
	
// Check if test student is in db
	$test_sql_classes = "select * from locationgroupslevels where group_id = 374;";
	
	$test_result_classes = $test_conn->query($test_sql_classes)
	or trigger_error($test_conn->error);
	$test_row_classes = $test_result_classes ->fetch_array(MYSQLI_BOTH);
	 
	if($test_row_classes['class_description'] == 'Test Class 1'){
		echo "Data is okay <br><br>";
		} else {
		echo "Data is NOT okay<br><br>";
		} 
	
	session_destroy();
	// Pass post data 

	$_GET['groupID'] = 374;
	$_POST['ClassDescription'] = "Test Class 1 - changed"; 
	$_POST['SchoolYear'] = "2025-2026";
	$_POST['PricePaymentsFull'] = 800;
	$_POST['PricePaymentsInstallments'] = 899;
	
	include 'ExecuteUpdateClass.php';
	
	
// Check if address has been updated 
	$test_result_classes = $test_conn->query($test_sql_classes)
	or trigger_error($test_conn->error);
	$test_row_classes = $test_result_classes->fetch_array(MYSQLI_BOTH);
	 
	if($test_row_classes['class_description'] == "Test Class 1 - changed" && $test_row_classes['school_year'] == "2025-2026" &&  $test_row_classes['price_in_full'] == 800 &&  $test_row_classes['price_in_installments'] == 899){
		echo "Update okay <br><br>";
		} else {
		echo "Update NOT okay <br><br>";
		echo ", class_description: " . $test_row_classes['class_description'];
		echo ", school_year: " . $test_row_classes['school_year'];
		echo ", price_in_full: " . $test_row_classes['price_in_full'];
		echo ", price_in_installments: " . $test_row_classes['price_in_installments']; 
		} 
	
// Clean up
	$cleanupsql = "update locationgroupslevels set class_description = 'Test Class 1', school_year = '2021-2022', price_in_full = 900, price_in_installments = 999 where group_id = 374;";

	$test_conn ->multi_query($cleanupsql)
	or trigger_error($test_conn->error);
	
	$test_conn->close();
	
	session_destroy();
	

	
?>
	