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

$sql_payDate_settings = "select * from settings_payment_due_dates;";
$result_sql_payDate_settings = $conn->query($sql_payDate_settings)
or trigger_error($conn->error);
$row_sql_payDate_settings = $result_sql_payDate_settings->fetch_array(MYSQLI_BOTH);

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

// To calculate the number of lessons left
//1. Get the start_date from the post_data
$startDate = new DateTime($_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day']);

//When there is more than one class in the sql table we will select by class -- currently only one class available in db
$sql_lesCount = "select * from classdates;";
$result_lesCount = $conn->query($sql_lesCount)
or trigger_error($conn->error);
$row_lesCount = $result_lesCount->fetch_array(MYSQLI_BOTH);

//Iterate over each date column value to get date that is => start_date
// To get the first date of the scheduled lessons that is greater that than the start date of the contract
$i = 1;
$found = 0;

while($i <= 60 && !$found) {
  $date = 'date' . $i;
  $lesDate = new DateTime($row_lesCount[$date]);
  if ($lesDate >= $startDate){$found = 1;} else {$i++;}
}

$nrLessons = 60 - ($i - 1);

//Pay in installments option:
// Assumption: Nr payments = Nr of payment due dates left in the school year + 1

$date_array = [];

// If date is a few days in the future we dont count it
// If date is not in the school year, we dont count it/If start date is in this school year, we count it

while(!is_null($row_sql_payDate_settings)){
	//If date (day/month) is already passed then year = next year
	//If date (day/momth) has not yet come then year = current year

	if (new DateTime(date('Y') . "-" . $row_sql_payDate_settings['due_month'] . "-" . $row_sql_payDate_settings['due_day']) < new DateTime()){

			$date1 = new DateTime(date('Y') + 1 . "-" . $row_sql_payDate_settings['due_month'] . "-" . $row_sql_payDate_settings['due_day']);

	} else {
			$date1 = new DateTime(date('Y') . "-" . $row_sql_payDate_settings['due_month'] . "-" . $row_sql_payDate_settings['due_day']);
	}

	//If todays date is before June then the school year ends this year
	//If todays date is after June then the school year ends next year

    if (date('z') < 181){
    		$JuneDate = new DateTime(date('Y') . "-6-30");
    } else {
    		$JuneDate = new DateTime(date('Y')+1 . "-6-30");
    }

	//If due date (created above) is part of current month then we do not add it to the array
	//Otherwise if part of the school year then add it to the array

	if($date1 -> format('m') == date('m')){
		//DO NOTHING
	} else {
		if($date1 >= $startDate && $date1 < $JuneDate){
			if($date1 -> format('m') == 2 && $startDate -> format('m') == 2){
				//DO NOTHING
			}else{
				$date_array[] = $date1;}
			}
		}

   //Get the next date from the results array
	$row_sql_payDate_settings = $result_sql_payDate_settings->fetch_array(MYSQLI_BOTH);

}

//if rate type = installments, then the nr of payments = the number of dates in the array + 1
if(isset($_POST["rate"]) && $_POST["rate"] == "installments"){
	 $nrOfPayments = count($date_array) + 1;
}

$grouplessons = 1;
$individuallessons = 0;
$price_per_les = $row_settings['contract_amount_installments']/60;
$basePrice = $price_per_les * $nrLessons;

// Pay in full

  if (isset($_POST["rate"]) && $_POST["rate"] == "pay in full"){

		$discount = $row_settings['contract_amount_infull']/$row_settings['contract_amount_installments'];
		$totalContractAmount = $basePrice * $discount;

	}

//Pay in installments

  if (isset($_POST["rate"]) && $_POST["rate"] == "installments"){

     	$totalContractAmount = $basePrice;

    }


// SQL Query

 $sql =  "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, totalamount, grouplessons, individuallessons, contract_signed, comments, lesson_count, start_date) VALUES
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
     . $_POST['comments'] . "', "
     . $nrLessons . ", '"
     . $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'] . "');";

$sql2 = "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level, payment_type, starter, book, nrpayments, totalamount, grouplessons, individuallessons, contract_signed, comments, start_date) VALUES ('', '', '', '', '', 0, 0, 0, 1, 0, 0, '', 60,'--');";

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




