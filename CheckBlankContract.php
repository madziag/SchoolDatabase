<?php




   session_id("insert-contract");
   session_start();
   $_SESSION['insert-contract'] = $_POST;
   $studentID =  $_GET['studentID'];

	if($_POST["levelSelect"] === ''){
	   echo 'Level must be entered to add a new student!';
	   header('Refresh: 5; URL = CreateContract.php?studentID=' . $studentID);
      die();
	}

	else {
		   header("Location: ExecuteInsertContract.php?studentID=" . $studentID);

      die();
	}




?>


