<?php

 session_start();

 $contract_amount_installments = $_POST['contract_amount_installments'];
 $contract_amount_infull = $_POST['contract_amount_infull'];

 if(is_numeric($contract_amount_installments) && is_numeric($contract_amount_infull)){
 		header("Location: ExecuteInsertSettings.php?contract_amount_installments=" . $contract_amount_installments."&contract_amount_infull=" . $contract_amount_infull);

 } else {
 		echo 'Please enter numeric value';
 			   header('Refresh: 5; URL = settings.php');
      die();
 }

?>