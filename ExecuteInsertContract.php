<?php

 session_start();
 $_POST =  $_SESSION['insert_contract'];
 $studentID =  $_GET['studentID'];

 var_dump($_SESSION['insert_contract']);

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

$starter = 0;
if(isset($_POST["starter"])){
	$starter = 1;
}

$book = 0;
if(isset($_POST["book"])){
	$book = 1;
}


// SQL Query

 $sql =  "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, comments, start_date) VALUES
 ('" . $studentID . "', '"
     . $_POST['locSelect'] . "', '"
     . $_POST['ageGroup'] . "', '"
     . $_POST['levelSelect'] . "', '"
     . $_POST['rate'] . "', '"
     . $starter . "', '"
     . $book . "', '"
     . $_POST['comments'] . "', '"
     . $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "');";

$sql2 = "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, comments, start_date) VALUES (, , , , , , , );";

if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

	        $_POST = array();
			}

	$conn->close();

?>

<html>
<body>

<?php
echo 'New contract added to database.';
?>

<a href = "SearchRetrieve.php"> Go back to Search page </a>

</body>
</html>





