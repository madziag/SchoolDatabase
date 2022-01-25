<?php

 session_start();

 $studentID =  $_GET['studentID'];
 $contractID =  $_GET['contractID'];

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

$sql = "SELECT * from englishschooldb.contracts where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";
// student_id, class_description, payment_type, starter, book, nrpayments, contract_signed, comments, start_date
$sql_student = "SELECT first_name, last_name  from englishschooldb.students where student_id = " . $studentID . ";";
$sql_guardian = "SELECT guardian_first_name, guardian_last_name from englishschooldb.guardians join englishschooldb.student_guardian on guardians.guardian_id = student_guardian.guardian_id where student_id = " . $studentID . ";";

$result = $conn->query($sql)
or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);

$result2 = $conn->query($sql_student)
or trigger_error($conn->error);
$row2 = $result2->fetch_array(MYSQLI_BOTH);

$result3 = $conn->query($sql_guardian)
or trigger_error($conn->error);
$row3 = $result3->fetch_array(MYSQLI_BOTH);

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
<br><br><br><br><br><br>
<?php echo "Name: " . $row2["first_name"] . " " . $row2["last_name"]; ?><br/><br/>
<?php echo "Contract Start Date: " . $row["start_date"]; ?><br/><br/>
<?php echo "Description: " . $row["class_description"] ; ?><br/><br/>
<?php echo "Rate: " . $row["payment_type"]; ?><br/><br/>
<?php if($row["starter"] == 1){
			echo "Starter kit: Yes";
			} else {
			echo "Starter kit: No";
			} ?><br/><br/>
<?php if($row["book"] == 1){
			echo "Book: Yes";
			} else {
			echo "Book: No";
			} ?><br/><br/>
<?php echo "Number of Payments: " . $row["nrpayments"] ?><br/><br/>
<br/><br/>
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
<?php echo $row["comments"]; ?><br/><br/>
</div>
</div>

<button onclick="window.location.href='UpdateContract.php?studentID=<?php echo $studentID ?>&contractID=<?php echo $contractID ?>'">Customize Contract</button>
<button onclick="window.location.href='SearchRetrieve.php'">Go to Search Page</button>
<button type="button" onclick="window.print()">Print Contract</button>
<button onclick="window.location.href='DeleteContract.php?studentID=<?php echo $studentID ?>&contractID=<?php echo $contractID ?>'">Delete This Contract</button>

<script type="text/javascript">
window.onload = function() { window.print(); }

</script>
</body>
</html>
