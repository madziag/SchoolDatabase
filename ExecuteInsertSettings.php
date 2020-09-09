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

// Contract amount (paid in full/installments will be for the complete year i.e. installment value * 5(installments) * 2(terms) (900) in case of installments and paid in full value * 2 (per term)
$sql =  "INSERT INTO englishschooldb.settings (contract_amount_installments, contract_amount_infull, settings_date) VALUES
 ('" . $_GET['contract_amount_installments'] . "', '"
     . $_GET['contract_amount_infull'] . "', '"
     . date("Y-m-d H:i:s") . "');";


$sql2 = "INSERT INTO englishschooldb.settings (contract_amount_installments, contract_amount_infull, settings_date) VALUES (,, '');";

if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

			$settingsID = mysqli_insert_id($conn);
            echo nl2br("Settings Updated. \n"). nl2br("\n");
            echo "Installment Amount:" . $_GET['contract_amount_installments'] . nl2br("\n"). nl2br("\n");
            echo "In Full Amount:" . $_GET['contract_amount_infull']. nl2br("\n");
			} else {
				echo 'Error! Settings Not Changed!';
			}

$conn->close();


?>

<html>
<body>
<br><br><br>
<a href="SearchRetrieve.php"><button>Go To Search Retrieve</button></a>
<a href="settings.php"><button>Go Back To Settings Page</button></a><br><br><br>

</body>
</html>