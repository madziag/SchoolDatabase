<?php

 session_start();

 $groupID =  $_GET['groupID'];

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

$sql = "UPDATE locationgroupslevels SET ";
	$sql = $sql . "class_description = '" . $_POST['ClassDescription'] . "', school_year = '" . $_POST['SchoolYear'] . "',
	price_in_full = " . $_POST['PricePaymentsFull'] . ", price_in_installments = " . $_POST['PricePaymentsInstallments'] . " where group_id = " . $groupID . ";";

$result = $conn->query($sql)
		        or trigger_error($conn->error);
		        if ($result == TRUE){
		        	echo 'Class has been updated <br><br>';
		    		header("Refresh: 2; URL = InsertClasses.php");}
		        else{echo $sql;}



?>