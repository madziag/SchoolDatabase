<?php
   session_start();
   $_SESSION['post_insert'] = $_POST;



	if($_POST["lastname"] === ''){
	   echo 'Last name must be entered to add a new student!';
	   header('Refresh: 2; URL = AddNewStudent.php');
      die();
	} else {
		   header("Location: ExecuteInsertStudent.php");

      die();
	}




?>