<?php
	
	$nextpayment = 0;
	
	if ($currentMonth <= 8){
		$schoolYear = $currentYear - 1;
		} else {
		$schoolYear = $currentYear;
	}
	
	$contractYear = substr($row_contracts["start_date"], 0, 4);
	$contractMonth = substr($row_contracts["start_date"], 5, 2);
	
	$startDate = new DateTime($row_contracts["start_date"]);
	
	
	$contractStatus = "Inactive";
	
	if ($contractYear > $schoolYear){
		$contractStatus = "Active";
	}
	
	if ($contractYear == $schoolYear && $contractMonth >= 9){
		$contractStatus = "Active";
	}
	
	
	$sql_payments = "select * from payment where contract_id = " . $row_contracts["contract_id"];
	
	$result_payments = $conn->query($sql_payments)
	or trigger_error($conn->error);
	$row_payments = $result_payments->fetch_array(MYSQLI_BOTH);
	$num_rows_payments = mysqli_num_rows($result_payments);
	
	$total_amount_paid = 0;
	for($j = 1; $j <= $num_rows_payments; $j++){
		$total_amount_paid += $row_payments["amount"];
	}
	
	$amountdue = $row_contracts['totalamount'] - $total_amount_paid;
	if($amountdue > 0) {
		$contractStatus = "Active";
	}
	
	if ($contractStatus === "Active"){
		
		if ($total_amount_paid == $row_contracts["totalamount"]){
			$nextpayment = 0;
			} 
		if($total_amount_paid > $row_contracts["totalamount"]){
			$nextpayment  = $row_contracts["totalamount"] - $total_amount_paid;
			}
		if($total_amount_paid < $row_contracts["totalamount"]) {
			//Pay in full contract type
			// TODO: $row[totalamount] is not the correct amount to use after we implement discounting!!!!!
			// If the total amount is more than the price of 1 semester but less that the prices of the whole school yr, then amout due = totaldue - half of the school year (second semester)
			// If total amount is less than the price of 1 semester then amount due = total amount OTHERWISE it is the price of 1 semester
			
			if ($row_contracts["payment_type"] == "pay in full") {
				if ($amountdue > $row_settings['contract_amount_infull']/2 && $amountdue < $row_settings['contract_amount_infull']){
					$nextpayment = $amountdue - $row_settings['contract_amount_infull']/2;
				}  
				if ($amountdue < $row_settings['contract_amount_infull']/2){
					$nextpayment = $amountdue;
				}
				if (($amountdue == $row_settings['contract_amount_infull']) || ($amountdue == $row_settings['contract_amount_infull']/2)){
					$nextpayment = $row_settings['contract_amount_infull']/2;
				}
			}
			
			// Pay in installments contract_type
			// TODO: $row[totalamount] is not the correct amount to use after we implement discounting!!!!!
			//
			
			if ($row_contracts["payment_type"] == "installments"){
				if ($amountdue % ($row_settings['contract_amount_installments']/$nrPaymentsInstallments) == 0){
					$nextpayment = $row_settings['contract_amount_installments']/$nrPaymentsInstallments;
					} else {
					$nextpayment = $amountdue % ($row_settings['contract_amount_installments']/$nrPaymentsInstallments);
					
				}
			}
			
		}
	}	
	
	
?>