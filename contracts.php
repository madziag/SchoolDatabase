DOES NOT RUN YET!!!

<?php

$sql = "select contracts.*, last_name, first_name, received_date, amount
from contracts join students on contracts.student_id = students.student_id
join(select contract_id, max(received_date) as b from payment
group by contract_id) as a
on contracts.contract_id = a.contract_id
join payment on contracts.contract_id = payment.contract_id and a.b = payment.received_date
where inactive = 0 ";




if ($num_rows > 0){
echo "<table border =\"1\"> <tr> <td> </td>
	<td> studentID </td>
	<td> First Name  </td>
	<td> Last Name </td>
	<td> Start date </td>
	<td> Signed </td>
	<td> Nr Payments </td>
	<td> Total Paid</td>
	<td> Total Amount </td>
	<td> Last Pay Date </td>
	<td> Last Pay Amt</td>
	<td> Next Pay Date  </td>
	<td> Next Pay Amount  </td></tr>";

$counter = 0;
while ($counter <  $num_rows){

echo
"<tr> <td> <a href = \"Dataupdate.php?studentID=" . $row["student_id"] . "\" > update </a> </td>

<td> " . $row["student_id"] . " </td>
<td> " . $row["first_name"] . " </td>
<td> " . $row["last_name"] . "  </td>
<td> " . $row["start_date"] . " </td>
<td> " . $row["contract_signed"] . " </td>
<td> " . $row["nrpayments"] . "  </td>
<td> " . $row["totalamountpaid"] . "  </td>
<td> " . $row["totalamount"] . "  </td>
<td> " . $row["received_date"] . "  </td>
<td> " . $row["amount"] . "  </td>
<td> " "  </td>
<td> " "  </td>

</tr>";

$row = $result->fetch_array(MYSQLI_BOTH);
$counter++;
}
echo "</table>";

}
}

?>