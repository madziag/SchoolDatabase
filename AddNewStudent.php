We need to be able to insert new student after Q: 'Ace'Do you want to create a new student? in SearchRetrieve
- Do we create another button to take us to another page to add new student?
- or do we use datainsert to add New Student?
- we also need user to be able to enter contract (create contract)/payment info

<? php

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

$sql = "INSERT INTO englishschooldb.students
	   (student_id, first_name, last_name, street_address, address_code, town, phone_main, phone_alt, email, inactive)";

?>