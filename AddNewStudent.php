
<?php

 session_start();

 if(isset($_SESSION['post-sr'])){
  	$_POST =  $_SESSION['post-sr'];
 	}


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



    $studentID= 'ID set automatically';
    $action = 'checkBlankInsert.php';
	$status = 0;


if(isset($_POST["firstname"])){
	$firstname = $_POST["firstname"];
}

if(isset($_POST["lastname"])){
	$lastname = $_POST["lastname"];
}

if(isset($_POST["streetaddress"])){
	$streetaddress = $_POST["streetaddress"];
}

if(isset($_POST["postcode"])){
	$postcode = $_POST["postcode"];
}

if(isset($_POST["town"])){
	$town = $_POST["town"];
}

if(isset($_POST["email"])){
	$email = $_POST["email"];
}

if(isset($_POST["mainphone"])){
	$mainphone = $_POST["mainphone"];
}

if(isset($_POST["altphone"])){
	$altphone = $_POST["altphone"];
}


	include 'DataInsert.php';


?>

