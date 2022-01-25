<?php

 session_start();

 $studentID =  $_GET['studentID'];
 $contractID =  $_GET['contractID'];

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

if ($_POST['starter'] == "Yes"){$starterint = 1;} else {$starterint = 0;}
if ($_POST['book'] == "Yes"){$bookint = 1;} else {$bookint = 0;}

$sql = "UPDATE contracts SET ";
	$sql = $sql . "start_date = '" . $_POST['contractStartDate'] . "', class_description = '" . $_POST['description'] . "',
	payment_type = '" . $_POST['rate'] . "',
	nrpayments = '" . $_POST['nrpayments'] . "',
	starter = '" . $starterint . "',
	book = '" . $bookint . "',
	comments = '" . $_POST['comments'] . "'
	where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";

$result = $conn->query($sql)
		        or trigger_error($conn->error);
		        if ($result == TRUE){
		        	echo 'Record has been updated';
		    		header("Refresh: 2; URL = DisplayPrintContract.php?studentID=".$studentID."&contractID=".$contractID);}
		        else{echo $sql;}



?>