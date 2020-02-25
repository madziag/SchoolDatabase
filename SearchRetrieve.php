
<?php

 session_start();
 $_SESSION['post-sr'] = $_POST;

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

// To change this to an update page after the sql query

if(isset($_POST["studentID"])){
	$studentID = trim($_POST["studentID"]);
}

if(isset($_POST["firstname"])){
	$firstname = trim($_POST["firstname"]);
}

if(isset($_POST["lastname"])){
	$lastname = trim($_POST["lastname"]);
}

if(isset($_POST["streetaddress"])){
	$streetaddress = trim($_POST["streetaddress"]);
}

if(isset($_POST["postcode"])){
	$postcode = trim($_POST["postcode"]);
}

if(isset($_POST["town"])){
	$town = trim($_POST["town"]);
}

if(isset($_POST["email"])){
	$email = trim($_POST["email"]);
}

if(isset($_POST["mainphone"])){
	$mainphone = trim($_POST["mainphone"]);
}

if(isset($_POST["altphone"])){
	$altphone = trim($_POST["altphone"]);
}

if(isset($_POST["status"])){
	$status = $_POST["status"];
}


// build sql query
$sql = "select  a.*, contract_signed, totalamount, totalamountpaid, max(start_date) as start_date from students a left join contracts b on a.student_id = b.student_id where ";



	if (!empty($studentID) ){
			$sql = $sql . "a.student_id = '" . $studentID . "'";
		}
		if (!empty($firstname) ){
		$sql = $sql . "and first_name = '" . $firstname . "'";
		}
		if (!empty($lastname) ){
		$sql = $sql . " and last_name = '" . $lastname . "'";
		}
		if (!empty($streetadress) ){
		$sql = $sql . " and street_address = '" . $streetadress . "'";
		}
		if (!empty($postcode) ){
		$sql = $sql . " and address_code = '" . $postcode . "'";
		}
		if (!empty($town) ){
		$sql = $sql . " and town = '" . $town . "'";
		}
		if (!empty($mainphone) ){
		$sql = $sql . " and phone_main = '" . $mainphone . "'";
		}
		if (!empty($altphone) ){
		$sql = $sql . " and phone_alt = '" . $altphone . "'";
		}
		if (!empty($email) ){
		$sql = $sql . " and email = '" . $email . "'";
		}
		if (isset($status) ){
		$sql = $sql . " and inactive = '" . $status . "'";
		}
		$sql = preg_replace('/where\s+and/','where', $sql);
		$sql = $sql . " group by a.student_id";



$sql2 = "select  a.*, contract_signed, totalamount, totalamountpaid, max(start_date) as start_date from students a left join contracts b on a.student_id = b.student_id where  group by a.student_id";

/* echo $sql;
echo "<br>";
echo $sql2; */


$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql);
fclose($myfile);


// Running query
if($sql != $sql2){
			$result = $conn->query($sql)
	        or trigger_error($conn->error);
			$row = $result->fetch_array(MYSQLI_BOTH);

			$num_rows = mysqli_num_rows($result);
			if($num_rows == 0){
			  echo "<br />";
			  echo "Student not found. Do you want to create a new student? ";
			  echo "<a href= \"AddNewStudent.php\"> Yes </a>";
			  echo "<br />";
			}


			//reset vars based on SQL query

			/*if ($num_rows == 1){
					$studentID = $row["student_id"];
					$firstname = $row["first_name"];
			        $lastname = $row["last_name"];
					$streetaddress = $row["street_address"];
					$postcode = $row["address_code"];
					$town = $row["town"];
					$email = $row["email"];
					$mainphone = $row["phone_main"];
					$altphone = $row["phone_alt"];
					$status = $row["inactive"];

					$action = 'Dataupdate.php';

				}*/
			// More than one result -- needs to be worked on

			if ($num_rows > 0){
			echo "<table border =\"1\"> <tr> <td> </td>
										<td>  studentID </td>
			                            <td> First Name  </td>
			                            <td> Last Name </td>
			                            <td> Street Address, postcode, town </td>
			                            <td>  email </td>
			                            <td>  Main Phone </td>
			                            <td>  Alt Phone </td>
			                            <td>  Status  </td>
			                            <td> Contract Signed </td>
			                            <td> Next Due Date  </td></tr>";

			$counter = 0;
			while ($counter <  $num_rows){
					$firstpaydate = date_create('2017-09-01');
					$lastpaydate = date_add($firstpaydate, date_interval_create_from_date_string('5 months'));
					$monthslefttopay = ceil(($row["totalamount"] - $row["totalamountpaid"])/90);
					$nextpaymonth = date_sub($lastpaydate, date_interval_create_from_date_string($monthslefttopay . ' months'));
					$nextdate = date_format($nextpaymonth,"Y-m-d");

					echo
					"<tr> <td> <a href = \"Dataupdate.php?studentID=" . $row["student_id"] . "\" > update </a> </br>
							   <a href = \"CreateContract.php?studentID=" . $row["student_id"] . "\" > add contract </a> </br>
							   <a href = \"ShowContracts.php?studentID=" . $row["student_id"] . "\" > show contracts </a>
					      </td>

						  <td> " . $row["student_id"] . " </td>
					      <td> " . $row["first_name"] . " </td>
					      <td> " . $row["last_name"] . "  </td>
					      <td> " . $row["street_address"] . "," . $row["address_code"] . ", " . $row["town"] . " </td>
					      <td> " . $row["email"] . " </td>
					      <td> " . $row["phone_main"] . " </td>
					      <td> " . $row["phone_alt"] . "  </td>
					      <td> " . $row["inactive"] . " </td>
						  <td> " . $row["contract_signed"] . " </td>
						  <td> " . $nextdate . "  </td>
					      </tr>";

					$row = $result->fetch_array(MYSQLI_BOTH);
					$counter++;
					}
					echo "</table>";
				    echo "<br />";
				    echo "Do you want to create a new student? ";
				    echo "<a href= \"AddNewStudent.php\"> Yes </a>";
			        echo "<br />";
			        echo "<br />";
					}
			}


//Checks if student in database

/*if(empty($insert)){
	$insert = 'SearchRetrieve.php';
	} */












include 'DataInsert.php';


$conn->close();

?>


<!-- <html>
<body>

<form action= "savingdata.php" method="post">
<input type="submit" name = "Yes" value = "Add New Student"><br /><br />
</form>

We need to send post data from this page with this form!!!!!!

</body>
</html> -->

<!-- TO DO USE TABLE TO SHOW MAIN INFO E.G. PAYMENT-->