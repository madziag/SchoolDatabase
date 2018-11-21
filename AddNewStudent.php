<!-- We need to be able to insert new student after Q: 'Ace'Do you want to create a new student? in SearchRetrieve
- Do we create another button to take us to another page to add new student?
- or do we use datainsert to add New Student?
- we also need user to be able to enter contract (create contract)/payment info
-- account for special characters when entering new data
-- DOESN'T WORK -  PAGE DOES NOT REFRESH - INSERTS AGAIN ON RELOADING; EXECUTE INSERT DOES NOT WORK YET

-- PLAN FOR Next time: create middle page btween addNS and ExecIS. Page checks to see if last name is filled from ADDNS. If not filled -> back to AddNS,
-- If filled -> ExecuteInseST (how do we pass the post array between pages?
-->

<?php

 session_start();

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

		if(isset($_POST["firstname"]) && isset($_POST["lastname"])){
			echo 'Student ' . $_POST["firstname"] .' ' . $_POST["lastname"] . ' added to database.';
	}


    $studentID= 'ID set automatically';
    $action = 'checkBlankInsert.php';
	$status = 0;

	include 'DataInsert.php';


?>

