<?php

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

// SQL Query

 if ($_POST['status'] == "InActive"){$statusint = 1;} else {$statusint = 0;}

 $sql = "UPDATE students SET ";
	if(isset($_POST['update']))     {$sql = $sql . "first_name = '" . $_POST['firstname'] . "', last_name = '" . $_POST['lastname'] . "',
	street_address = '" . $_POST['streetaddress'] . "', address_code = '" . $_POST['postcode'] . "', town = '" . $_POST['town'] . "',
	email = '" . $_POST['email'] . "', phone_main = '" . $_POST['mainphone'] . "', phone_alt = '" . $_POST['altphone']. "',
	inactive = '" . $statusint . "' ";}


if (isset($_POST['studentID']))
{
	$sql = $sql . "WHERE student_id = " . $_POST['studentID'];
}
echo $sql;


if(strpos($sql, 'student_id') !== false)
	{
	if(isset($_POST['update'])) {
				$result = $conn->query($sql)
		        or trigger_error($conn->error);
		        if ($result == TRUE){echo 'Record has been updated';}
		        else{echo $sql;}
		        }
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