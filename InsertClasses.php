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
		<td> Price Payments in Installments </td></tr>";
		
		$counter = 0;
	    $num_rows_classes = mysqli_num_rows($result_classes);
		
	while ($counter <  $num_rows_classes){
			$school_year = $row_classes["school_year"];   
			$class_description = $row_classes["class_description"];   
			$price_in_full = $row_classes["price_in_full"];   
			$price_in_installments = $row_classes["price_in_installments"];   
		    
			if($school_year!=NULL && $class_description != NULL && $price_in_full != NULL){
			$table = $table .
				"<tr> 	
				<td> " . $school_year . " </td>
				<td> " . $class_description . " </td>
				<td> " . $price_in_full  . "  </td>
				<td> " . $price_in_installments . " </td>		
				</tr>";
			
			}
			$row_classes = $result_classes->fetch_array(MYSQLI_BOTH);
			$counter++;
			
		}
		$table = $table . "</table>";

?>

<html>
			<body>
				
				
				
				<form action= "ExecuteInsertClass.php" method="post">
					
					Class Description: <input type="text" name="ClassDescription"> <br><br>
					School Year: <input type="text" name="SchoolYear"><br><br><!-- consider drop down menu - current year + 10 -->
					Price payments in full: <input type="number" name="PricePaymentsFull"><br><br>
					Price payments in installments: <input type="number" name="PricePaymentsInstallments"><br><br>
					
					
					
					
					<input type="submit" name = "InsertClass" value = "Add Class">
				
				
				
				</form>
				
				<?php echo $table ?>
				
			</body>
		</html>