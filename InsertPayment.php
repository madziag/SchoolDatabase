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

$sql = "INSERT INTO englishschooldb.payment (contract_id, amount, received_date) VALUES (" . $_POST["contract_id"] . "," . $_POST["PaymentAmount"] . ",'" . date('Y-m-d') . "');";

$sql2 = "INSERT INTO englishschooldb.payment (contract_id, amount, received_date) VALUES (,,'');";


if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

			$paymentID = mysqli_insert_id($conn);
			echo $paymentID;
			}


?>