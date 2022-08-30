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

if (isset($_POST['starter'])){$starterint = 1;} else {$starterint = 0;}

$startdate_string = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];

$startDate=DateTime::createFromFormat('Y-m-d',$startdate_string);

include "CalculateNrOfPayments.php";

$sql = "UPDATE contracts SET ";
	$sql = $sql . "start_date = '" . $startdate_string. "', class_description = '" . $_POST['descriptionSelect'] . "',
	payment_type = '" . $_POST['rate'] . "',
	nrpayments = '" . $nrOfPayments . "',
	starter = '" . $starterint . "',
	comments = '" . $_POST['comments'] . "'
	where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";

$result = $conn->query($sql)
		        or trigger_error($conn->error);
		        if ($result == TRUE){
		        	echo 'Record has been updated';
		    		header("Refresh: 2; URL = DisplayPrintContract.php?studentID=".$studentID."&contractID=".$contractID);
					}
		        else{echo $sql;}



?>