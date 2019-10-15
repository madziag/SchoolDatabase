<?php
   session_start();
   $_SESSION['insert_contract'] = $_POST;
   $studentID =  $_GET['studentID'];


	if($_POST["subcategory2"] === ''){
	   echo 'Level must be entered to add a new student!';
	   header('Refresh: 2; URL = CreateContract.php');
      die();
	}

	else {
		   header("Location: ExecuteInsertContract.php?studentID=" . $studentID);

      die();
	}




?>


