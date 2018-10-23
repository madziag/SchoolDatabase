 <?php



 // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
     if ($conn->connect_error) {
  	   die("Connection failed: " . $conn->connect_error);
    }

$sql = "INSERT INTO students (first_name, last_name, street_address, address_code, town, phone_main, phone_alt, email, inactive)
VALUES ('".$_POST["firstname"]."','".$_POST["lastname"]."','".$_POST["streetaddress"]."','".$_POST["postcode"]."','".$_POST["town"]."','".$_POST["mainphone"]."','".$_POST["altphone"]."','".$_POST["email"]."','".$_POST["status"]."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}




$conn->close();
?>




