<?php


   session_start();
   $_SESSION['insert-contract'] = $_POST;
   $studentID =  $_GET['studentID'];

	if($_POST["description"] === ''){
	   echo 'Description must be entered to add a new contract!';
	   header('Refresh: 5; URL = CreateContract.php?studentID=' . $studentID);
      die();
	}

	else {
		   header("Location: ExecuteInsertContract.php?studentID=" . $studentID);

      die();
	}




?>


