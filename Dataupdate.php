<?php

$checked1 = 'checked = \"checked\"';

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

$studentID = $_GET["studentID"];
echo $studentID;

if (isset($studentID))
{
$sql = "Select * from students where student_id = '" . $studentID . "'";
echo $sql;

$result = $conn->query($sql)
or trigger_error($conn->error);

$row = $result->fetch_array(MYSQLI_BOTH);
$studentID = $row["student_id"];
$firstname = $row["first_name"];
$lastname = $row["last_name"];
$streetaddress = $row["street_address"];
$postcode = $row["address_code"];
$town = $row["town"];
$email = $row["email"];
$mainphone = $row["phone_main"];
$altphone = $row["phone_alt"];
$status = $row["inactive"];
} else {
	echo "shouldnt be here";
	$studentID= '';
	$firstname =  '';
	$lastname =  '';
	$streetaddress =  '';
	$postcode =  '';;
	$town =  '';
	$email =  '';
	$mainphone =  '';
	$altphone =  '';
}


?>

<html>
<body>

<form action= "ExecuteUpdate.php" method="post">
Student ID: <input type="text" name="studentID" value="<?php echo $studentID?>"><br />
First name: <input type="text" name="firstname" value="<?php echo $firstname ?>"><br />
Last name: <input type="text" name="lastname" value="<?php echo $lastname ?>"><br />
Street address: <input type="text" name="streetaddress" value="<?php echo $streetaddress ?>"><br />
Postcode: <input type="text" name="postcode" value="<?php echo $postcode ?>"><br />
Town: <input type="text" name="town" value="<?php echo $town ?>"><br />
E-mail: <input type="text" name="email" value="<?php echo $email ?>"><br />
Main Phone: <input type="text" name="mainphone" value="<?php echo $mainphone ?>"><br />
Alt Phone: <input type="text" name="altphone" value="<?php echo $altphone ?>"><br />
Status:
<input type="radio" name="status" value = "Active"
<?php echo (isset($status) && $status=="0") ? 'checked = "checked"': ''; ?> /> Active
<input type="radio" name="status" value = "InActive"
<?php echo (isset($status) && $status=="1") ? 'checked = "checked"': ''; ?> /> Inactive
<br />
<input type="submit" name = "update" value = "Submit Changes">
</form>

<a href = "SearchRetrieve.php"> Go back to Search page </a>

</body>
</html>

<!-- TO DO: SAFETY CHECK -> NOT TO ALLOW FOR USER TO USE UPDATE PAGE IF EMPTY. SHOULD ONLY BE ABLE TO REACH IT FROM SEARCG PAGE. -->

