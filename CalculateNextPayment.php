<?php
	
	$nextpayment = 0;
	
	include 'ContractStatus.php';
	
	include 'calculateTotalAmountPaid.php';
	
	$amountdue = $row_contracts['totalamount'] - $total_amount_paid;
	if($amountdue > 0) {
		$contractStatus = "Active";
	}
	
	if ($contractStatus === "Active"){
		/*echo 'Total Amount Paid: ';
		echo $total_amount_paid;
		echo '<br>';*/
		
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
				
				if ($amountdue % $installmentAmount == 0){
					$nextpayment = $installmentAmount;
					} else {
					$nextpayment = $amountdue % $installmentAmount;	
				}
			}
			
		}
	}	
	
	
?>