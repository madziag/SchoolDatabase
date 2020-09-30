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

// Selects most recent value from settings
$sql_settings = "select * from settings order by settings_date desc limit 1;";
$result_settings = $conn->query($sql_settings)
or trigger_error($conn->error);
$row_settings = $result_settings->fetch_array(MYSQLI_BOTH);

// Defaulting to group lessons
$nrOfPayments = 0;

//Pay in full option:
// If contract start date is July - Jan -> 2 payments
// If contract start date is Feb - June -> 1 payment

if(isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){
	if($_POST['month'] >= 2 && $_POST['month'] <= 6){
			$nrOfPayments = 1;
	} else {
			$nrOfPayments = 2;
			}
	}

//Pay in installments option:
// Nr of payments = nr of months in contract with last month in June
// Assumption: Payment is due by the 10th of each contract month. Contracts that start before the 10th are due on the 10th of the same month.
// We add 1 to months in contract because php counts a partial month as 0, but we want the partial month to count as 1
if(isset($_POST["rate"]) && $_POST["rate"] == "installments"){
	 $date1 = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];

	 if($_POST['month'] >= 7 ){
	 	$juneYear = $_POST['year'] + 1;
	 	} else {
	 	$juneYear = $_POST['year'];
	 	}

	 $date2 = $juneYear . '-06-09';

	 $d1=new DateTime($date1);
	 $d2=new DateTime($date2);
	 $Months = $d2->diff($d1);
     $monthsInContract = (($Months->y) * 12) + ($Months->m) + 1;


	 $nrOfPayments = $monthsInContract ;
}

$grouplessons = 1;
$individuallessons = 0;
// Pay in full
// This needs to be changed to calculate amount by the number of lessons!!!!

if (isset($_POST["rate"]) && $_POST["rate"] == "pay in full" && $nrOfPayments == 2){$totalContractAmount = $row_settings['contract_amount_infull'];}
if (isset($_POST["rate"]) && $_POST["rate"] == "pay in full" && $nrOfPayments == 1){$totalContractAmount = $row_settings['contract_amount_infull']/2;}

//Pay in installments
// This needs to be changed to calculate amount by the number of lessons!!!!

if (isset($_POST["rate"]) && $_POST["rate"] == "installments"){$totalContractAmount = ($nrOfPayments/10) * $row_settings['contract_amount_installments'];}


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

$contractID = 0;

if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

			$contractID = mysqli_insert_id($conn);

			}



$conn->close();

$_POST = array(); // Clears post data

if ($contractID != 0){
		header("Location: DisplayPrintContract.php?studentID=".$studentID."&contractID=".$contractID);
	} else {
		echo "Error adding contract";}

?>




