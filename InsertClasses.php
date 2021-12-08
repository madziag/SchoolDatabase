<?php
	
	//Starts session
	session_start();
	
	//Connects to the database
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
	
	$sql_classes = "select * from locationgroupslevels order by school_year desc, class_description;";
	
	$result_classes = $conn->query($sql_classes)
	or trigger_error($conn->error);
	$row_classes = $result_classes ->fetch_array(MYSQLI_BOTH);
	
	$table = "<table border =\"1\">		
		<tr>
		<td> School Year </td>
		<td> Class Description  </td>
		<td> Price Payments in Full</td>
		<td> Price Payments in Installments </td>
		<td>  </td>
		</tr>";
		
		$counter = 0;
		$newest = NULL;
		$highest_row = NULL; 
	    $num_rows_classes = mysqli_num_rows($result_classes);
		
	while ($counter <  $num_rows_classes){
			$school_year = $row_classes["school_year"];   
			$class_description = $row_classes["class_description"];   
			$price_in_full = $row_classes["price_in_full"];   
			$price_in_installments = $row_classes["price_in_installments"]; 
			$date_added = $row_classes["date_added"];
			if($date_added > $newest){
				$newest = $date_added;
				$highest_row = $counter;
				}
		    
			if($school_year!=NULL && $class_description != NULL && $price_in_full != NULL){
			$table = $table .
				'<tr class = "row' . $counter . '"> 	
				<td> ' . $school_year . ' </td>
				<td> ' . $class_description . ' </td>
				<td> ' . $price_in_full  . '  </td>
				<td> ' . $price_in_installments . ' </td>
				<td> ' . '<a href="UpdateClass.php?groupID=' . $row_classes["group_id"] . '"> Edit </a>' . ' </td>
				</tr>';
			    
			}
			$row_classes = $result_classes->fetch_array(MYSQLI_BOTH);
			$counter++;
			
		}
	$style = '<style> tr.row' . $highest_row . ' {background-color: yellow;}</style>';

	$table = $table . "</table>";
	
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
			

?>

<html>
			<?php echo $style ?>
			<body>
				
				
				
				<form action= "ExecuteInsertClass.php" method="post">
					
					Class Description: <input type="text" name="ClassDescription"> <br><br>
					
					   School Year: <?php echo $schoolyear_dropdown ?> <br><br>
				
					
					Price payments in full: <input type="number" name="PricePaymentsFull"><br><br>
					Price payments in installments: <input type="number" name="PricePaymentsInstallments"><br><br>
					
					
					
					
					<input type="submit" name = "InsertClass" value = "Add Class">
				
				
				
				</form>
				
				<button><a href="SearchRetrieve.php">Back to Search</a></button>

				
				<?php echo $table ?>
				
				
			</body>
		</html>