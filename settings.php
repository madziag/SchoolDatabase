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

$sql = "SELECT * FROM settings ORDER BY settings_date DESC;";

$result = $conn->query($sql) or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);

$contract_amount_infull = $row['contract_amount_infull'];
$contract_amount_installments = $row['contract_amount_installments'];






$conn->close();
?>
<html>
<body>

<form action= "CheckSettings.php"  method="post" id="form" name="form">
    Enter the total amount of a one year contract (installments):
	<input type="text" name="contract_amount_installments" value="<?php echo $contract_amount_installments ?>">  <br />

    Enter the total amount of a one year contract (paid in full):
	<input type="text" name="contract_amount_infull" value="<?php echo $contract_amount_infull ?>"> <br />

    <input type="submit">

 </form>
 </body>
 </html>