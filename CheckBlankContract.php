<?php
   session_start();
   $_SESSION['post_insert'] = $_POST;



	if($_POST["level"] === 'not set'){
	   echo 'Level must be entered to add a new student!';
	   header('Refresh: 2; URL = CreateContract.php');
      die();
	} else {
		   header("Location: ExecuteInsertContract.php");
      die();
	}




?>