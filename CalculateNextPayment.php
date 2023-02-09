<?php
	/*Required variables:
	
	$row_contracts 
	$total_amount_paid 
	$contractStatus  
	$installmentAmount
	$row_rates
	*/
	
	$nextpayment = 0;
	
	include 'ContractStatus.php';
	
	include 'calculateTotalAmountPaid.php';
	
	// selects starter fee from settings
	$sql_settings = "select * from settings order by settings_date desc";
	$result_settings = $conn->query($sql_settings)
	or trigger_error($conn->error);
	$row_settings = $result_settings->fetch_array(MYSQLI_BOTH);
    
	//if no starter fee $starterfee defaults to 0
	$starterfee = 0;
	
	if($row_contracts["starter"] == 1){

	    $starterfee = $row_settings["starter_fee"];
	} 
	
	//$contractamountdue = ($row_contracts["totalamount"] +  $starterfee) - $total_amount_paid;
	
	if($starterfee <= $total_amount_paid){
			$contractamountdue = $row_contracts["totalamount"] - ($total_amount_paid - $starterfee);
	    } else {
		    $contractamountdue = $row_contracts["totalamount"];
		}
	
	// $contractstatus may already be active. If inactive and money is owed then it is set back to Active. 
	if((($row_contracts["totalamount"] +  $starterfee) - $total_amount_paid) > 0) {
		$contractStatus = "Active";
	}
	// TODO: WE NEED TO HANDLE OVERPAYMENTS IE. $contractamountdue < 0
	
	if ($contractStatus === "Active"){
		//paid exactly
		if ($total_amount_paid == $row_contracts["totalamount"] + $starterfee){
			$nextpayment = 0;
			} 
		//overpaid
		if($total_amount_paid > $row_contracts["totalamount"] + $starterfee){
			$nextpayment  = (($row_contracts["totalamount"] + $starterfee) - $total_amount_paid);
			}
		//still owe
		if($total_amount_paid < $row_contracts["totalamount"] + $starterfee) {
					//Pay in full contract type
					// If the total amount is more than the price of 1 semester but less that the prices of the whole school yr, then amout due = totaldue - half of the school year (second semester)
					// If total amount is less than the price of 1 semester then amount due = total amount OTHERWISE it is the price of 1 semester
					
				
				// Has the starterfee been paid off?
				$remainingstarterfee = $starterfee - $total_amount_paid;

				if($remainingstarterfee < 0){$remainingstarterfee = 0;}
					
					
					if ($row_contracts["payment_type"] == "pay in full") {
						if ($contractamountdue > $row_rates['price_in_full']/2 && $contractamountdue < $row_rates['price_in_full']){
							$nextpayment = ($contractamountdue - $row_rates['price_in_full']/2) + $remainingstarterfee;
						}  
						if ($contractamountdue < $row_rates['price_in_full']/2){
							$nextpayment = $contractamountdue + $remainingstarterfee;
						}
						if (($contractamountdue == $row_rates['price_in_full']) || ($contractamountdue == $row_rates['price_in_full']/2)){
							$nextpayment = $row_rates['price_in_full']/2 + $remainingstarterfee;
						}
					}
					
					// Pay in installments contract_type
					
					if ($row_contracts["payment_type"] == "installments"){
							// for each element in date array check if that element (date) is before todays date 
							$todays_date = date_create(date("Y-m-d"));
							if(isset($_POST["todays_date"])){
								$todays_date = new DateTime($_POST["todays_date"]);
								}
							// calculates the number of past due dates 
							$running_total_due = 0;
							
							
							echo $row_contracts["contract_id"];
							var_dump($date_array);
							echo "TODAYS DATE " . $todays_date ->format('d/m/Y');
							
							foreach ($date_array as $installment_date) {
							// Check if todays date is 10 days before due date (Sept/Nov/Feb/April 10) - if within these 10 days then we add new installment amount to previously unpaid due amounts 
							// e.g. student did not pay first installment in time (or still owes from before), if it is Nov 1, student will now owe September amount + upcomin november amount) 
								
								  
								  
				                  
								  echo ' INSTALLMENT DATE1 '. $installment_date->format('d/m/Y');
								  $installment_date_minus10 = clone $installment_date;
								  
								  if($installment_date_minus10->sub(new DateInterval('P10D')) <= $todays_date){
								    $contract_creation_date = date_create($row_contracts["contract_creation_date"]);
							
									  echo 'INSTALLMENT DATE new  '. $installment_date_minus10 ->format('d/m/Y');
									  echo 'INSTALLMENT DATE2 '. $installment_date ->format('d/m/Y');
					
									  echo '    CONTRACT CREATION DATE ' . $contract_creation_date ->format('d/m/Y');
									  
									  if($installment_date == $contract_creation_date){
									        echo "   I AM RIGHT HERE!!   ";
										   if (fmod($contractamountdue, $installmentAmount) == 0){
												echo "   I AM RIGHT HERE IN THE IF PART!!   ";
												echo "   contractamountdue: " . $contractamountdue;
												echo "   installmentAmount: " . $installmentAmount;
												echo "   remainingstarterfee: " . $remainingstarterfee;
												echo "   running_total_due BEFORE: " . $running_total_due; 
												$running_total_due += $installmentAmount + $remainingstarterfee;
												echo "   running_total_due AFTER: " . $running_total_due; 
												
										   } else {
										   echo "   I AM RIGHT HERE IN THE ELSE PART!!   ";
												$running_total_due += (fmod($contractamountdue, $installmentAmount)) + $remainingstarterfee;	
											}
										} else {
										     echo "   I AM WRONG!!   ";
										    $running_total_due += $installmentAmount;
										}
									  
									}
									  
							}
							$nextpayment = $running_total_due - $total_amount_paid;
					}
			
		}
	}	
	
	
?>