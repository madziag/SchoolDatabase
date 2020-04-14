<?php

$left = [1=>true, 5=>true, 7=>true];
$right = [6=>true, 7=>true, 8=>true, 9=>true];

$union = $left + $right;
$intersection = array_intersect_assoc($left, $right);

var_dump($left);
echo "||";
var_dump($right);
echo "||";
var_dump($union);
echo "||";
var_dump($intersection);
echo '||';
?>

<html>
<head>
<style>
a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
}
</style>
</head>
<body>

<button type="button" onclick="alert('Hello world!')">&circ;</button>
<button type="button" onclick="alert('Hello world!')">&caron;</button>

</body>
</html>