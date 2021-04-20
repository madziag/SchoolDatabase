<?php
// What ExecuteUpdate.php does: 
// Updates student table for 'this' student 
//  "UPDATE students SET ";
//	if(isset($_POST['update']))     {$sql = $sql . "first_name = '" . $_POST['firstname'] . "', last_name = '" . $_POST['lastname'] . "',
//	street_address = '" . $_POST['streetaddress'] . "', address_code = '" . $_POST['postcode'] . "', town = '" . $_POST['town'] . "',
//	email = '" . $_POST['email'] . "', phone_main = '" . $_POST['mainphone'] . "', phone_alt = '" . $_POST['altphone']. "',
//	inactive = '" . $statusint . "' where student_id = " . $studentID;}

// Data needed for the test
// - $_GET["studentID"], $_POST['status'], $_POST['update'], $_POST['firstname'], $_POST['lastname'], $_POST['streetaddress'], $_POST['postcode'], $_POST['town'], $_POST['email'], $_POST['mainphone'], $_POST['altphone'] 


// What is needed to get a correct updated student
// - Valid student in the student table in the db (student_id 570)

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
	
// Pass post data 

$_GET['studentID'] = 570;
$_POST['status'] = "Active"; 
$_POST['update'] = "Change Contact Info";
$_POST['firstname'] = "Test1";
$_POST['lastname'] = "InsertPayment";
$_POST['streetaddress'] = "Korte Lauwestraat";
$_POST['postcode'] = "12345";
$_POST['town'] = "Krakow";
$_POST['email'] = "";
$_POST['mainphone'] = "";
$_POST['altphone'] = ""; 
	
// Check if test student is in db
	$test_sql_students = "select * from students where student_id = 570;";
	
	$test_result_students = $test_conn->query($test_sql_students)
	or trigger_error($test_conn->error);
	$test_row_students = $test_result_students->fetch_array(MYSQLI_BOTH);
	 
	if($test_row_students['first_name'] == 'Test1'){
		echo "Data is okay";
		} else {
		echo "Data is NOT okay";
		} 
	
	
	include 'ExecuteUpdate.php';
	
	
// Check if address has been updated 
	$test_result_students = $test_conn->query($test_sql_students)
	or trigger_error($test_conn->error);
	$test_row_students = $test_result_students->fetch_array(MYSQLI_BOTH);
	 
	if($test_row_students['street_address'] == "Korte Lauwestraat" && $test_row_students['address_code'] == "12345" &&  $test_row_students['town'] == "Krakow"){
		echo "Update okay";
		} else {
		echo "Update NOT okay";
		echo ", street_address: " . $test_row_students['street_address'];
		echo ", postcode: " . $test_row_students['address_code'];
		echo ", town: " . $test_row_students['town']; 
		} 
	
// Clean up
	$cleanupsql = "update students set street_address = '', address_code = '', town = '' where student_id = 570;";

	$test_conn ->multi_query($cleanupsql)
	or trigger_error($test_conn->error);
	
	$test_conn->close();
	
	session_destroy();
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>
	