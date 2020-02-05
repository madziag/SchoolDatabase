<?php

 session_start();
$_POST =  $_SESSION['post_insert'];

 $servername = 'localhost';
 $username = ;
 $password = ;
 $dbname = 'englishschooldb';


 // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
     if ($conn->connect_error) {
  	   die("Connection failed: " . $conn->connect_error);
    }

if(isset($_POST["firstname"])){
	$firstname = trim($_POST["firstname"]);
}

if(isset($_POST["lastname"])){
	$lastname = trim($_POST["lastname"]);
}

if(isset($_POST["streetaddress"])){
	$streetaddress = trim($_POST["streetaddress"]);
}

if(isset($_POST["postcode"])){
	$postcode = trim($_POST["postcode"]);
}
if(isset($_POST["town"])){
	$town = trim($_POST["town"]);
}

if(isset($_POST["email"])){
	$email = trim($_POST["email"]);
}

if(isset($_POST["mainphone"])){
	$mainphone = trim($_POST["mainphone"]);
}

if(isset($_POST["altphone"])){
	$altphone = trim($_POST["altphone"]);

}

if ($_POST['status'] == "InActive"){$statusint = 1;} else {$statusint = 0;}

// SQL Query



 $sql =  "INSERT INTO englishschooldb.students (first_name, last_name, street_address, address_code, town, email, phone_main, phone_alt, inactive) VALUES
 ('" . $firstname . "', '"
     . $lastname . "', '"
     . $streetaddress . "', '"
     . $postcode . "', '"
     . $town . "', '"
     . $email . "','"
     . $mainphone . "','"
     . $altphone . "','"
     . $statusint . "' );";


$sql2 = "INSERT INTO englishschooldb.students (first_name, last_name, street_address, address_code, town, phone_main, phone_alt, email, inactive) VALUES (, , , , , , , , 0)";

$sql3 = "SELECT student_id from englishschooldb.students where
	  first_name = '" . $firstname . "' and
	  last_name =  '" . $lastname . "' and
	  street_address = '" . $streetaddress . "' and
	  address_code = '" . $postcode . "' and
	  town = '" . $town . "' and
	  email = '" . $email . "' and
	  phone_main = '" . $mainphone . "' and
	  phone_alt = '" . $altphone. "';";


if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);
	        sleep(1);
	        $result2 = $conn->query($sql3)
		    or trigger_error($conn->error);
	     	$row = $result2->fetch_array(MYSQLI_BOTH);

	        $_POST = array();
			}



	$studentID= $row["student_id"];
	$conn->close();



header("Location: CreateContract.php?studentID=" . $studentID);

?>

<html>
<body>

<?php
echo 'Student ' . $firstname .' ' . $lastname . ' added to database.';
?>


<a href = "AddNewStudent.php"> Go back to AddNewStudent page </a>

</body>
</html>

