<?php

if(empty($action)){
	$action = 'SearchRetrieve.php';
	}

$checked1 = 'checked = \"checked\"'

?>

<html>
<body>

<form action= "<?php echo $action ?>"  method="post">

Student ID: <input type="text" name="studentID" value="<?php echo $studentID?>"><br />

First name: <input type="text" name="firstname" value="<?php echo $firstname ?>"><br />

Last name: <input type="text" name="lastname" value="<?php echo $lastname ?>"><br />

Street address: <input type="text" name="streetaddress" value="<?php echo $streetaddress ?>"><br />
Postcode: <input type="text" name="postcode" value="<?php echo $postcode ?>"><br />
Town: <input type="text" name="town" value="<?php echo $town ?>"><br />

E-mail: <input type="text" name="email" value="<?php echo $email ?>"><br />

Main Phone: <input type="text" name="mainphone" value="<?php echo $mainphone ?>"><br />
Alt Phone: <input type="text" name="altphone" value="<?php echo $altphone ?>"><br />

Status:
<input type="radio" name="status"
<?php if (isset($status) && $status=="0") echo $checked1;?>
value="0">Active
<input type="radio" name="status"
<?php if (isset($status) && $status=="1") echo $checked1;?>
value="1">Inactive <br />



<input type="submit">
</form>
</body>
</html>