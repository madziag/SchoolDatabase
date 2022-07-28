<?php

	$studentID =  $_GET['studentID'];
    $contractID =  $_GET['contractID'];

	$action =  "ExecuteUpdateContract.php?studentID=" . $studentID."&contractID=" . $contractID;
	include 'EditContract.php';
 ?>

