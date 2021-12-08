<?php
	
	session_start();
	
	//$_POST =  $_SESSION['insert-class'];
	
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
	
	if($_POST['SchoolYear'] == NULL){echo "Please enter the School Year <br><br>" ;}
	if($_POST['ClassDescription'] == NULL){echo "Please enter the Class Description <br><br>" ;}
	if($_POST['PricePaymentsFull'] == NULL){echo "Please enter the Price Payments in Full <br><br>" ;}
	if($_POST['PricePaymentsInstallments'] == NULL){echo "Please enter the Price Payments Installments <br><br>" ;}
	
    $sql =  "INSERT INTO englishschooldb.locationgroupslevels (group_id, school_year, class_description, price_in_full, price_in_installments) VALUES
	( NULL, '"
	. $_POST['SchoolYear'] . "', '"
	. $_POST['ClassDescription'] . "', '"
	. $_POST['PricePaymentsFull'] . "', '"
	. $_POST['PricePaymentsInstallments']. "');";
	
	$sql2 =  "INSERT INTO englishschooldb.locationgroupslevels (group_id, school_year, class_description, price_in_full, price_in_installments) VALUES
	(NULL, '', '', '', '');";
	
	if($sql != $sql2 and $_POST['SchoolYear'] != NULL and $_POST['ClassDescription'] != NULL and $_POST['PricePaymentsFull'] != NULL and $_POST['PricePaymentsInstallments'] != NULL){
		$result = $conn->query($sql)
		or trigger_error($conn->error);
		$group_id = mysqli_insert_id($conn);
		if ($group_id!= 0){
			header("Location: InsertClasses.php");
		} else {
			echo "Error adding class";
			}
	} else {
		echo '<button><a href="InsertClasses.php">Back to Insert Classes </a></button>';
	}
		

	
	
	
?>