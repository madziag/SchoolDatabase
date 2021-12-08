<?php
		
		
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

	include 'CalculateTotalAmountPaid.php';	
	
	if ($total_amount_paid < $row_contracts["totalamount"]){
		$contractStatus = "Active";
		}
	
?>