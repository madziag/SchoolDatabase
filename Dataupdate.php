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

$sql = "Select * from students where student_id = '" . $_GET["studentid"] . "'";
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


// SQL Query

 $sql = "UPDATE students SET ";
	if(isset($_POST['change_name']))     {$sql = $sql . "first_name = '$firstname', last_name = '$lastname' "; }
	elseif(isset($_POST['change_address'])) {$sql = $sql . "street_address = '$streetaddress', address_code = '$postcode', town = '$town' "; }
	elseif(isset($_POST['change_email']))   {$sql = $sql . "email = '$email' "; }
	elseif(isset($_POST['change_phone']))   {$sql = $sql . "phone_main = '$mainphone', phone_alt = '$altphone' "; }
	elseif(isset($_POST['change_status']))  {$sql = $sql . "inactive = $status "; }

	$sql = $sql . "WHERE student_id = $studentID";



	if(isset($_POST['change_name']) ||
		isset($_POST['change_address']) ||
		isset($_POST['change_email']) ||
		isset($_POST['change_phone']) ||
		isset($_POST['change_status'])){
				$result = $conn->query($sql)
		        or trigger_error($conn->error);
		        if ($result == TRUE){echo 'Record has been updated';}
		        else{echo $sql;}
		        }

	$conn->close();
?>

<html>
<body>

<form action= "Dataupdate.php" method="post">
Student ID: <input type="text" name="studentID" value="<?php echo $studentID?>"><br />
First name: <input type="text" name="firstname" value="<?php echo $firstname ?>"><br />
Last name: <input type="text" name="lastname" value="<?php echo $lastname ?>"><br />
<input type="submit" name = "change_name" value = "Update Name"> <br /><br />

Street address: <input type="text" name="streetaddress" value="<?php echo $streetaddress ?>"><br />
Postcode: <input type="text" name="postcode" value="<?php echo $postcode ?>"><br />
Town: <input type="text" name="town" value="<?php echo $town ?>"><br />
<input type="submit" name = "change_address" value = "Update Address"> <br /><br />

E-mail: <input type="text" name="email" value="<?php echo $email ?>"><br />
<input type="submit" name = "change_email" value = "Update Email"><br /><br />

Main Phone: <input type="text" name="mainphone" value="<?php echo $mainphone ?>"><br />
Alt Phone: <input type="text" name="altphone" value="<?php echo $altphone ?>"><br />
<input type="submit" name = "change_phone" value = "Update Phone"><br /><br />

Status:
<input type="radio" name="status"
<?php if (isset($status) && $status=="0") echo $checked1;?>
value="0">Active
<input type="radio" name="status"
<?php if (isset($status) && $status=="1") echo $checked1;?>
value="1">Inactive <br />
<input type="submit" name = "change_status" value = "Update Status">
</form>

<a href = "SearchRetrieve.php"> Go back to Search page </a>

</body>
</html>