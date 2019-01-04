<!--
- we also need user to be able to enter contract (create contract)/payment info)
-->
<?php

 session_start();
$_POST =  $_SESSION['post_insert'];


  echo " Name: " . $_POST['firstname'] . " " . $_POST['lastname'] . "<br \>";
  echo "Address: " . $_POST['streetaddress'] . " " . $_POST['postcode'] . " " . $_POST['town'] . "<br \>";
  echo "Contact: "  . $_POST['email'] .  " " . $_POST['mainphone']  . " " . $_POST['altphone'] . "<br \>";
  echo "Status: " . $_POST['status'];


if(empty($action)){
	$action = 'CheckBlankContract.php';
	}

if(empty($level)){
	$level= '';
	}
if(empty($location)){
	$location= '';
	}
if(empty($rate)){
	$rate= '';
	}

$checked1 = 'checked = \"checked\"';
session_destroy();

?>

<html>
<body>

<form action= "<?php echo $action ?>"  method="post">

Class Level:

<select name="level">
  <option>not set</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
</select><br />

Location:
	  <select name="location">
	  <option>not set</option>
	  <option value="Zator">Zator</option>
	  <option value="Grodzisko">Grodzisko</option>
	  <option value="Laskowa">Laskowa</option>
</select><br />

Payment Rate:
		  <select name="rate">
		  <option>not set</option>
		  <option value="1">90</option>
		  <option value="2">408</option>
</select><br />

Starter Pack:
<input type="checkbox" name="starter" checked = "checked"> <br />


Book:
<input type="checkbox" name="book" checked = "checked"> <br />



<input type="submit">
</form>
</body>
</html>