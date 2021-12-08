<?php

 session_start();

 $groupID =  $_GET['groupID'];

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

   $sql_class = "SELECT * from englishschooldb.locationgroupslevels where group_id = " .  $groupID . " ;";
   
   $result_class = $conn->query($sql_class) or trigger_error($conn->error);
   $row_class = $result_class->fetch_array(MYSQLI_BOTH);

   $action =  "ExecuteUpdateClass.php?groupID=" . $groupID;
   
   $day = date("d");
	$month = date('m');
	$year = (int)date('Y');		
    $current_school_year = $year;
	
	if($month >= 8){
		$current_school_year = $year;
	} else {
        $current_school_year = $year - 1;
	}  

			$schoolyear_dropdown = '<select name="SchoolYear" id="year">
										<option value="' . $current_school_year . '-' . ($current_school_year + 1) . '" >' . ($current_school_year + 0) . '-' . ($current_school_year + 1) . '</option>
										<option value="' . ($current_school_year + 1) . '-' . ($current_school_year + 2) . '" >' . ($current_school_year + 1) . '-' . ($current_school_year + 2) . '</option>
										<option value="' . ($current_school_year + 2) . '-' . ($current_school_year + 3) . '" >' . ($current_school_year + 2) . '-' . ($current_school_year + 3) . '</option>
										<option value="' . ($current_school_year + 3) . '-' . ($current_school_year + 4) . '" >' . ($current_school_year + 3) . '-' . ($current_school_year + 4) . '</option>
										<option value="' . ($current_school_year + 4) . '-' . ($current_school_year + 5) . '" >' . ($current_school_year + 4) . '-' . ($current_school_year + 5) . '</option>
										<option value="' . ($current_school_year + 5) . '-' . ($current_school_year + 6) . '" >' . ($current_school_year + 5) . '-' . ($current_school_year + 6) . '</option>
										<option value="' . ($current_school_year + 6) . '-' . ($current_school_year + 7) . '" >' . ($current_school_year + 6) . '-' . ($current_school_year + 7) . '</option>
										<option value="' . ($current_school_year + 7) . '-' . ($current_school_year + 8) . '" >' . ($current_school_year + 7) . '-' . ($current_school_year + 8) . '</option>
										<option value="' . ($current_school_year + 8) . '-' . ($current_school_year + 9) . '" >' . ($current_school_year + 8) . '-' . ($current_school_year + 9) . '</option>
										<option value="' . ($current_school_year + 9) . '-' . ($current_school_year + 10) . '" >' . ($current_school_year + 9) . '-' . ($current_school_year + 10) . '</option>
									</select><br />' ;
									
	$schoolyear_dropdown = str_replace('"' . $row_class['school_year'] . '"', '"' . $row_class['school_year'] . '" selected', $schoolyear_dropdown);


									
 ?>

<html>
<head>
<style>
</style>
</head>

<body>

				<form action= <?php echo $action ?> method="post">
	
					Class Description: <input type="text" name="ClassDescription" value="<?php echo $row_class["class_description"] ?>" ><br><br>
					
					School Year: <?php echo $schoolyear_dropdown ?> <br><br>
				
					Price payments in full: <input type="number" name="PricePaymentsFull" value="<?php echo $row_class["price_in_full"] ?>"><br><br>
					
					Price payments in installments: <input type="number" name="PricePaymentsInstallments" value="<?php echo $row_class["price_in_installments"] ?>"><br><br>
					

					<input type="submit" name = "InsertClass" value = "Update Class">

				</form>
</body>
</html>