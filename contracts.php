<!--
Note for Next Week Feb 5:
Option in create contract: to find a way to predefine the number of lessons and startdate, and let user change them. Use of calendar widget?

- we also need user to be able to enter contract (create contract)/payment info
-- calculate due date by month and amount due by the number of lessons.
- make sort buttons work in contracts
-- update button should allow user to update info.
-- create new contract (part of addnewstudent?)
-- insert same student by 2 different users/ 2 users trying to isert students at te same time
-- shared network drive/webserver -- /remote desktop

- search for students with payment due -- SearchRetrieve?
- Add contract/payment to new student?
- Edit payment info
- Case sensitivitiy in search

-- account for special characters when entering new data
-- automated email remainders -- contract & payment.
-- if student quits = user able to adjust amount owed...
-- be able to zero out months that student will no longer be attending but, in will still be able to show when student stillowes for the months they went


-- check boxes for books/starter pack
-- free text notes field -- contracts

===== Questions =====
-- Link class level to new contract. When contract is updated, the class level should be updated as well -- option to manually adjust to different level.
-- is there a group level hierachy. Every level, different locations?
-- billing lower amounts e.g. 60 -- discount or partial payment?
-- set of possible payment schedules she stay to.
-- which classes have a book fee -- option to join with kalss
-- why some students have starter pack and others not?
-- do students change locations when they go up a level - relationship between groups and locations. how many locations do they have?
select klass and location together or separately? what does klas 3/2 mean?
-- contract.php table?
-- add notes column mysql -- archive old notes instead of delete??
-- individual students -- 2 students, 1 row (sylwia Majkut? who pays. Do students prepay or pay after the lessons. is there a contract?
-- option to add new student regardelss of whether there are results or not.



-->

<?php

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


$sql = "select contracts.*, last_name, first_name, received_date, amount
from contracts join students on contracts.student_id = students.student_id
left outer join(select contract_id, max(received_date) as b from payment
group by contract_id) as a
on contracts.contract_id = a.contract_id
left outer join payment on contracts.contract_id = payment.contract_id and a.b = payment.received_date
where inactive = 0 ";

$result = $conn->query($sql)
or trigger_error($conn->error);
$row = $result->fetch_array(MYSQLI_BOTH);

$num_rows = mysqli_num_rows($result);


if ($num_rows > 0){


echo "<table border =\"1\">
	<tr>
	<td> </td>
	<td> </td>
	<td> </td>
	<td> </td>
	<td> </td>
	<td> <center><button type=\"button\" onclick=\"alert('Hello world!')\" style = \"font-size:20px\">&#x25B2;</button>
		 <button type=\"button\" onclick=\"alert('Hello world!')\" style = \"font-size:20px\">&#x25BC;</button>
         </center>
    </td>
	<td> </td>
	<td> </td>
	<td> </td>
	<td> <center><button type=\"button\" onclick=\"alert('Hello world!')\" style = \"font-size:20px\">&#x25B2;</button>
		 <button type=\"button\" onclick=\"alert('Hello world!')\" style = \"font-size:20px\">&#x25BC;</button>
         </center>
    </td>
	<td> </td>
	<td> <center><button type=\"button\" onclick=\"alert('Hello world!')\" style = \"font-size:20px\">&#x25B2;</button>
		 <button type=\"button\" onclick=\"alert('Hello world!')\" style = \"font-size:20px\">&#x25BC;</button>
         </center>
	</td>
	<td> </td>
	</tr>

    <tr>
    <td> </td>
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
	<td> Next Due Date  </td>
	<td> Next Due Amount  </td></tr>";

$counter = 0;


while ($counter <  $num_rows){
if ($row["nrpayments"] == 1 and $row["totalamountpaid"] == 0)
	{$nextpayment = 409;}
if ($row["totalamountpaid"] == $row["totalamount"])
	{$nextpayment = 0;}
if ($row["nrpayments"] == 5 and $row["totalamountpaid"] != $row["totalamount"])
	{$nextpayment = 90;}

$date=date_create("first day of next month");
date_add($date, date_interval_create_from_date_string('9 days'));
$nextdate = date_format($date,"Y-m-d");

$firstpaydate = date_create('2017-09-01');
$lastpaydate = date_add($firstpaydate, date_interval_create_from_date_string('5 months'));
$monthslefttopay = ceil(($row["totalamount"] - $row["totalamountpaid"])/90);
$nextpaymonth = date_sub($lastpaydate, date_interval_create_from_date_string($monthslefttopay . ' months'));
$nextdate = date_format($nextpaymonth,"Y-m-d");

if ($nextpayment == 0){$nextdate = 'Paid';}

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
<td> " . $nextdate . "  </td>
<td> " . $nextpayment . "  </td>

</tr>";

$row = $result->fetch_array(MYSQLI_BOTH);
$counter++;
}
echo "</table>";

}


?>

<html>
<body>

<button type="button" onclick="alert('Hello world!')">&circ;</button>
<button type="button" onclick="alert('Hello world!')">&caron;</button>

</body>
</html>