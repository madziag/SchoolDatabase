<?php


 session_start();

 $_POST =  $_SESSION['insert-contract'];
 $studentID =  $_GET['studentID'];

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

// Defaulting to group lessons

$nrOfPayments = 0;

if(isset($_POST["rate"]) && $_POST["rate"] == "installments"){
	$nrOfPayments = 10;
}
if(isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){
	$nrOfPayments = 2;
}

$grouplessons = 1;
$individuallessons = 0;
if ($nrOfPayments == 10){$totalContractAmount = 900;}
if ($nrOfPayments == 2){$totalContractAmount = 818;}

// SQL Query

 $sql =  "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, totalamount, grouplessons, individuallessons, contract_signed, comments, start_date) VALUES
 ('" . $studentID . "', '"
     . $_POST['locSelect'] . "', '"
     . $_POST['ageGroup'] . "', '"
     . $_POST['levelSelect'] . "', '"
     . $_POST['rate'] . "', "
     . $starter . ", "
     . $book . ", "
     . $nrOfPayments . ", "
     . $totalContractAmount. ", "
     . $grouplessons . ", "
     . $individuallessons . ", "
     . "0, '"
     . $_POST['comments'] . "', '"
     . $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "');";

$sql2 = "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, totalamount, grouplessons, individuallessons, contract_signed, comments, start_date) VALUES ('', '', '', '', '', 0, 0, 0, 1, 0, 0, '', '--');";


$message_string = "Error adding contract";

if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

			$contractID = mysqli_insert_id($conn);

			$message_string = $contractID;

			}



$conn->close();

$_POST = array(); // Clears post data

header("Location: DisplayPrintContract.php?studentID=".$studentID."&contractID=".$contractID);

?>




