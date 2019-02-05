<!--
- put in start date into insert statement
- Instead of 'New Contract Added, we can print Student Name, level, etc' after new contract added
-->
<?php

 session_start();
 $_POST =  $_SESSION['insert_contract'];
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


// SQL Query

 $sql =  "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level) VALUES
 ('" . $studentID . "', '"
     . $_POST['category'] . "', '"
     . $_POST['subcategory1'] . "', '"
     . $_POST['subcategory2'] . "' );";



/*INSERT INTO `englishschooldb`.`contracts`
(`contract_id`,
`student_id`,
`start_date`,
`lesson_count`,
`contract_signed`,
`nrpayments`,
`paidinfull`,
`totalamountpaid`,
`totalamount`,
`grouplessons`,
`individuallessons`,
`location`,
`age_group`,
`level`)
VALUES
(<{contract_id: }>,
<{student_id: }>,
<{start_date: }>,
<{lesson_count: }>,
<{contract_signed: }>,
<{nrpayments: }>,
<{paidinfull: }>,
<{totalamountpaid: }>,
<{totalamount: }>,
<{grouplessons: }>,
<{individuallessons: }>,
<{location: }>,
<{age_group: }>,
<{level: }>); */




$sql2 = "INSERT INTO englishschooldb.contracts (student_id, location, age_group, level) VALUES (, , , );";



if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);

	        $_POST = array();
			}

	$conn->close();

?>

<html>
<body>

<?php
echo 'New contract added to database.';
?>


<a href = "SearchRetrieve.php"> Go back to Search page </a>

</body>
</html>





