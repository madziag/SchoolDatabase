<?php


 $date1 = '2020-09-10';
 $date2 = '2021-06-09';
 $d1=new DateTime($date1);
 $d2=new DateTime($date2);
 $Months = $d2->diff($d1);
 $howeverManyMonths = (($Months->y) * 12) + ($Months->m) + 1;

 echo $howeverManyMonths;

?>




