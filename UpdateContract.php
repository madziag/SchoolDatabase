<?php

 session_start();

 $studentID =  $_GET['studentID'];
 $contractID =  $_GET['contractID'];

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

   $sql = "SELECT * from englishschooldb.contracts where student_id = " . $studentID . " and contract_id = " . $contractID . " ;";
   $sql_student = "SELECT first_name, last_name  from englishschooldb.students where student_id = " . $studentID . ";";
   $sql_guardian = "SELECT guardian_first_name, guardian_last_name from englishschooldb.guardians join englishschooldb.student_guardian on guardians.guardian_id = student_guardian.guardian_id where student_id = " . $studentID . ";";

   $result = $conn->query($sql) or trigger_error($conn->error);
   $row = $result->fetch_array(MYSQLI_BOTH);

   $result2 = $conn->query($sql_student) or trigger_error($conn->error);
   $row2 = $result2->fetch_array(MYSQLI_BOTH);

   $result3 = $conn->query($sql_guardian) or trigger_error($conn->error);
   $row3 = $result3->fetch_array(MYSQLI_BOTH);

   $action =  "ExecuteUpdateContract.php?studentID=" . $studentID."&contractID=" . $contractID;
 ?>

<html>
<head>
<style>
</style>
</head>

<body>

  <form action= <?php echo $action ?> method="post">

  <?php echo "Name: " . $row2["first_name"] . " " . $row2["last_name"]; ?><br/><br/>
	Contract Start Date: <input type="text" name="contractStartDate" value="<?php echo $row["start_date"] ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date must be in YYYY-MM-DD format</em><br />
    Location: <input type="text" name="location" value="<?php echo $row["location"] ?>"><br />
    Group: <input type="text" name="group" value="<?php echo $row["age_group"] ?>"><br />
    Level: <input type="text" name="level" value="<?php echo $row["level"] ?>"> <em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Levels must be numeric</em><br />
    Rate: <input type="text" name="rate" value="<?php echo $row["payment_type"] ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rates must be </em> not set <em>, </em> pay in full <em>or</em> installments<br />
    Number of Payments: <input type="text" name="nrpayments" value="<?php echo $row["nrpayments"] ?>"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Payments must be numeric</em><br />

    Starter Pack:
   <input type="radio" name="starter" value = "Yes"
   <?php echo ($row["starter"] == 1) ? 'checked = "checked"': ''; ?> /> Yes
   <input type="radio" name="starter" value = "No"
   <?php echo ($row["starter"] == 0) ? 'checked = "checked"': ''; ?> /> No
   <br />
   Book:
   <input type="radio" name="book" value = "Yes"
   <?php echo ($row["book"] == 1) ? 'checked = "checked"': ''; ?> /> Yes
   <input type="radio" name="book" value = "No"
   <?php echo ($row["book"] == 0) ? 'checked = "checked"': ''; ?> /> No
   <br />
   <input type="radio" name="group_ind" value = "Group"
   <?php echo ($row["grouplessons"] == 1) ? 'checked = "checked"': ''; ?> /> Group Lessons
   <input type="radio" name="group_ind" value = "Individual"
   <?php echo ($row["individuallessons"] == 1) ? 'checked = "checked"': ''; ?> /> Individual Lessons
    <br />
    Comments: <input type="text" name="comments" value="<?php echo $row["comments"] ?>"><br />
    <br />
    <em>Some functions may not work if invalid values are put in e.g. invalid locations or invalid groups.</em>
   <br /><br /><br />
   <input type="submit" name = "update" value = "Update Contract">

   </form>
</body>
</html>