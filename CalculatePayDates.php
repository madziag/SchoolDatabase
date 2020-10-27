<?php



 $servername2 = 'localhost';
 $username2 = 'MadziaG';
 $password2 = 'P$i@krew2018User';
 $dbname2 = 'englishschooldb';


 // Create connection
    $conn2 = new mysqli($servername2, $username2, $password2, $dbname2);
 // Check connection
     if ($conn2->connect_error) {
  	   die("Connection failed: " . $conn2->connect_error);
    }

// Gets the due dates from the database

$sql_payDate_settings2 = "select * from settings_payment_due_dates;";
$result_sql_payDate_settings2 = $conn2->query($sql_payDate_settings2)
or trigger_error($conn2->error);
$row_sql_payDate_settings2 = $result_sql_payDate_settings2->fetch_array(MYSQLI_BOTH);

//Pay in installments option:
// Assumption: Nr payments = Nr of payment due dates left in the school year + 1

$date_array = [];

// If date is a few days in the future we dont count it
// If date is not in the school year, we dont count it/If start date is in this school year, we count it

while(!is_null($row_sql_payDate_settings2)){
	//If date (day/month) is already passed then year = next year
	//If date (day/momth) has not yet come then year = current year

	if (new DateTime(date('Y') . "-" . $row_sql_payDate_settings2['due_month'] . "-" . $row_sql_payDate_settings2['due_day']) < new DateTime()){

			$date1 = new DateTime(date('Y') + 1 . "-" . $row_sql_payDate_settings2['due_month'] . "-" . $row_sql_payDate_settings2['due_day']);

	} else {
			$date1 = new DateTime(date('Y') . "-" . $row_sql_payDate_settings2['due_month'] . "-" . $row_sql_payDate_settings2['due_day']);
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
	$row_sql_payDate_settings2 = $result_sql_payDate_settings2->fetch_array(MYSQLI_BOTH);

}

$conn2->close();

?>




