<!--
- we also need user to be able to enter contract (create contract)/payment info)
-->
<?php

 session_start();
 if(isset($_SESSION['post_sr'])){
 	$studentID =  $_GET['studentID'];
  	$sql = "Select * from students where student_id = " . $studentID;

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


  	$result = $conn->query($sql)
		      or trigger_error($conn->error);
	$row = $result->fetch_array(MYSQLI_BOTH);

	echo " Name: " . $row["first_name"] . " " . $row["last_name"] . "<br \>";
	echo "Address: " . $row["street_address"] . " " . $row["address_code"]. " " . $row["town"] . "<br \>";
	echo "Contact: "  . $row["email"] .  " " . $row["phone_main"]  . " " . $row["phone_alt"] . "<br \>";
    echo "Status: " . $row["inactive"];
 	}

 if(isset($_SESSION['post_insert'])){
  	$_POST =  $_SESSION['post_insert'];
  	 echo " Name: " . $_POST['firstname'] . " " . $_POST['lastname'] . "<br \>";
	 echo "Address: " . $_POST['streetaddress'] . " " . $_POST['postcode'] . " " . $_POST['town'] . "<br \>";
	 echo "Contact: "  . $_POST['email'] .  " " . $_POST['mainphone']  . " " . $_POST['altphone'] . "<br \>";
     echo "Status: " . $_POST['status'];
 	}




if(empty($action)){
	$action = 'CheckBlankContract.php';
	}

if(empty($level)){
	$level= '';
	}
if(empty($location)){
	$location= '';
	}
if(empty($rate)){
	$rate= '';
	}

$checked1 = 'checked = \"checked\"';
session_destroy();

?>

<html>
<body>

<form action= "<?php echo $action ?>"  method="post">

Class Level:

<select name="level">
  <option>not set</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
</select><br />

Location:
	  <select name="location">
	  <option>not set</option>
	  <option value="Zator">Zator</option>
	  <option value="Grodzisko">Grodzisko</option>
	  <option value="Laskowa">Laskowa</option>
</select><br />

Payment Rate:
		  <select name="rate">
		  <option>not set</option>
		  <option value="1">90</option>
		  <option value="2">408</option>
</select><br />

Starter Pack:
<input type="checkbox" name="starter" checked = "checked"> <br />


Book:
<input type="checkbox" name="book" checked = "checked"> <br />



<input type="submit">
</form>
</body>
</html>