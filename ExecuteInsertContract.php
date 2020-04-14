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
$sql_guardian = "SELECT guardian_first_name, guardian_last_name from englishschooldb.guardians join englishschooldb.student_guardian on guardians.guardian_id = student_guardian.guardian_id where student_id = " . $studentID . ";";


$message_string = "Error adding contract";

if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

	        $result2 = $conn->query($sql_student)
	        or trigger_error($conn->error);
	        $row2 = $result2->fetch_array(MYSQLI_BOTH);

			$result3 = $conn->query($sql_guardian)
			or trigger_error($conn->error);
	        $row3 = $result3->fetch_array(MYSQLI_BOTH);

			$message_string = "";

			}

	$conn->close();

    session_destroy();

?>

<html>
<head>
<style>

@media print {
 @page { margin: 0; }

  body * {
    visibility: hidden;
    margin: 1.6cm;
  }

  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}

div.page {
        size: A4;
        margin: 0;
        width: 20cm;
        visibility: visible;
}

a.button {
 	display: block;
    width: 115px;
    height: 25px;
    background: #4E9CAF;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
}

</style>
</head>
<body>
<div class="page" id = "section-to-print">
<div style="margin:2em;">
<?php echo $message_string; ?> <br><br>
<br><br><br><br><br><br>
<?php echo "Name: " . $row2["first_name"] . " " . $row2["last_name"]; ?><br/><br/>
<?php echo "Contract Start Date: " . $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day']; ?><br/><br/>
<?php echo "Location: " . $_POST['locSelect'] ; ?><br/><br/>
<?php echo "Group: " . $_POST['ageGroup']; ?><br/><br/>
<?php echo "Level: " . $_POST['levelSelect']; ?><br/><br/>
<?php echo "Rate: " . $_POST['rate']; ?><br/><br/>
<?php if($starter == 1){
			echo "Starter kit: Yes";
			} else {
			echo "Starter kit: No";
			} ?><br/><br/>
<?php if($book == 1){
			echo "Book: Yes";
			} else {
			echo "Book: No";
			} ?><br/><br/>
<?php echo "Number of Payments: " . $nrOfPayments ?><br/><br/>
<?php if($grouplessons == 1){
			echo "Group Lessons \n";
			}
	  if($individuallessons == 1){
			echo "Individual Lessons";
			} ?><br/><br/><br/><br/>
<?php echo "____________________"; ?><br/><br/>



<?php if ($row3["guardian_first_name"] == ""){
			echo "Student Name: " . $row2["first_name"] . " " . $row2["last_name"];
			}
	  else{
	  		echo "Guardians Name: " . $row3["guardian_first_name"] . " " . $row3["guardian_last_name"];
	  		$row3 = $result3->fetch_array(MYSQLI_BOTH);

	  		if($row3["guardian_first_name"] != ""){
	  			echo " or " . $row3["guardian_first_name"] . " " . $row3["guardian_last_name"];
	  		}
	  	}
			?><br/><br/>


<?php echo "Date: " . date('Y/m/d'); ?><br/><br/>
<?php echo $_POST['comments']; ?><br/><br/>
</div>
</div>

<button onclick="window.location.href='UpdateContract.php?studentID=<?php echo $studentID ?>'">Update Contract Page</button>
<button onclick="window.location.href='SearchRetrieve.php'">Search Page</button>
<button type="button" onclick="window.print()">Print Contract</button>


<script type="text/javascript">
window.onload = function() { window.print(); }

</script>
</body>
</html>

<?php
$_POST = array(); // Clears post data
?>




