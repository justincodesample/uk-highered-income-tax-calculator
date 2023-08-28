<?php
include("calculator.php");
$file = fopen("./grade.csv", "r");

$grades = [];
$tax_objs = array();

while(! feof($file)) {
	$data = fgetcsv($file);
	$grades[$data[0]] = $data[1];
	if ($data[1] == 0) {
		$tax_objs[$data[0]] = new Tax($data[1], 0, 0);
		$tax_objs[$data[0]]->take_home();
	} else {
		$tax_objs[$data[0]] = new Tax($data[1], 4000, 0.06);
		$tax_objs[$data[0]]->take_home();
	}
}

include("index.template.php");

fclose($file);
?>