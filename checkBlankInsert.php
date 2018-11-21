<?php
   session_start();
   $_SESSION['post'] = $_POST;



	if($_POST["lastname"] === ' '){
	 echo 'the same';
	   header("Location: AddNewStudent.php");
      die();
	} else {
		   header("Location: ExecuteInsertStudent.php");
      die();
	}




?>