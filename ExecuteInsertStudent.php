<?php

 session_start();
$_POST =  $_SESSION['post_insert'];

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

if(isset($_POST["firstname"])){
	$firstname = $_POST["firstname"];
}

if(isset($_POST["lastname"])){
	$lastname = $_POST["lastname"];
}

// SQL Query

 if ($_POST['status'] == "InActive"){$statusint = 1;} else {$statusint = 0;}

 $sql =  "INSERT INTO englishschooldb.students (first_name, last_name, street_address, address_code, town, email, phone_main, phone_alt, inactive) VALUES
 ('" . $_POST['firstname'] . "', '"
     . $_POST['lastname'] . "', '"
     . $_POST['streetaddress'] . "', '"
     . $_POST['postcode'] . "', '"
     . $_POST['town'] . "', '"
     . $_POST['email'] . "','"
     . $_POST['mainphone'] . "','"
     . $_POST['altphone']. "','"
     . $statusint . "' );";


$sql2 = "INSERT INTO englishschooldb.students (first_name, last_name, street_address, address_code, town, phone_main, phone_alt, email, inactive) VALUES (, , , , , , , , 0)";


if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

	        $_POST = array();
			}


	$conn->close();


header("Location: CreateContract.php");

?>

<html>
<body>

<?php
echo 'Student ' . $firstname .' ' . $lastname . ' added to database.';
?>

<a href = "AddNewStudent.php"> Go back to AddNewStudent page </a>

</body>
</html>

