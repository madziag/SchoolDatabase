<?php

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

// SQL Query

$studentID = $_GET["studentID"];

$sql = "UPDATE contracts SET contract_signed = 1 WHERE student_id =" . $studentID;

if($sql !== 'UPDATE contracts SET contract_signed = 1 WHERE student_id =')
	{$result = $conn->query($sql)
	or trigger_error($conn->error);
	if ($result == TRUE){echo 'Contract has been signed';}
	else{echo $sql;}

	} else {echo "Bad Query";}


	$conn->close();

header('Refresh: 5; URL = SearchRetrieve.php');
?>

<html>
<body>

Update Successful.

<a href = "SearchRetrieve.php"> Go back to Search page </a>

</body>
</html>
