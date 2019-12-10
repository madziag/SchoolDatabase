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

$sql = "select a.*, first_name, last_name from contracts a left join students b on a.student_id = b.student_id where a.student_id = " . $_GET["studentID"] ;

$result = $conn->query($sql)
or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);

echo $row["first_name"] . " " . $row["last_name"];

echo "<table border =\"1\">
	<tr>

    <td> </td>
    <td> Start date </td>
	<td> Signed </td>
	<td> Nr Payments </td>
	<td> Total Paid </td>
	<td> Total Amount </td>
	<td> Book </td>
	<td> Starter </td>
	<td> Location </td>
	<td> Age Group </td>
	<td> Level </td>
	<td> Active </td>  <!-- not yet in db -- consider adding (to differentiate not paid contracts or with still active classes vs paid in full contract/all classes complete-->
	</tr>"

echo "</table>";

?>
<html>





</html>
