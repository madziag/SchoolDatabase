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

 $sql = "DELETE from englishschooldb.contracts where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";

 $result = $conn->query($sql) or trigger_error($conn->error);

 if($result){
 	echo "Contract Deleted. Returning to Create New Contract Page.";
    header('Refresh: 2; URL = CreateContract.php?studentID=' . $studentID);
 	} else {
 	echo "Failed to delete contract. Reload page to retry. If failure persists, contact the administrator.";
 	}
?>