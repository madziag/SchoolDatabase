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

// Implement nr of payments
// Defaulting to group lessons

$nrOfPayments = 0;

if(isset($_POST["rate"]) && $_POST["rate"] == "installments"){
	$nrOfPayments = 5;
}
if(isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){
	$nrOfPayments = 1;
}

$grouplessons = 1;
$individuallessons = 0;

// SQL Query

 $sql =  "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, grouplessons, individuallessons, contract_signed, comments, start_date) VALUES
 ('" . $studentID . "', '"
     . $_POST['locSelect'] . "', '"
     . $_POST['ageGroup'] . "', '"
     . $_POST['levelSelect'] . "', '"
     . $_POST['rate'] . "', "
     . $starter . ", "
     . $book . ", "
     . $nrOfPayments . ", "
     . $grouplessons . ", "
     . $individuallessons . ", "
     . "0, '"
     . $_POST['comments'] . "', '"
     . $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "');";



$sql2 = "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, grouplessons, individuallessons, contract_signed, comments, start_date) VALUES ('', '', '', '', '', 0, 0, 0, 1, 0, 0, '', '--');";
$sql_student = "SELECT first_name, last_name  from englishschooldb.students where student_id = " . $studentID . ";";

$message_string = "Error adding contract";
$message_string2 = "";


if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

	        $result2 = $conn->query($sql_student)
	        or trigger_error($conn->error);
	        $row2 = $result2->fetch_array(MYSQLI_BOTH);

			$message_string = "New contract added to database for " . $row2["first_name"] . " " . $row2["last_name"];
			$message_string2 = $_POST["locSelect"] . ", " .  $_POST["ageGroup"] . ", " . $_POST["levelSelect"];
			$_POST = array(); // Clears post data
			}



	$conn->close();


?>

<html>
<body>

<?php echo $message_string; ?> <br><br> <?php echo $message_string2; ?><br><br>


<a href = "SearchRetrieve.php"> Go back to Search page </a>

</body>
</html>





