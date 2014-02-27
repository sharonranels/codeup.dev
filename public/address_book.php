<?php

$address_entry = [];
$filename = "address_book.csv";
$errorMessage = '';
$temp_array = [];

$address_book = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];

//var_dump($_POST);

function writeCSV($filename, $rows) {	//$filename = addressbook.csv file & $row = $address_book array line.
	$handle = fopen($filename, 'w');
	foreach ($rows as $row) {  //$row is one item in the row.
		fputcsv($handle, $row);
	}
	fclose($handle);
}

foreach ($_POST as $key => $value) {
	if(empty($value)) {
		$errorMessage .= $key . " is empty - please retry.\n";
	} else {
		$temp_array[$key] = htmlspecialchars(strip_tags($value));
	}
}
// THESE ARE REPLACED BY ABOVE FOREACH ARRAY.
// if(!empty($_POST)) {
// 	$name = $_POST['name'];
// if(!empty($_POST)) {
// 	$address = $_POST['address'];	
// if(!empty($_POST)) {
// 	$city = $_POST['city'];
// if(!empty($_POST)) {
// 	$state = $_POST['state'];
// if(!empty($_POST)) {
// 	$zip = $_POST['zip'];
// if(!empty($_POST)) {
// 	$phone = $_POST['phone'];


$address_entry = [$temp_array['name'], $temp_array['address'], $temp_array['city'], $temp_array['state'], $temp_array['zip'], $temp_array['phone']];

array_push($address_book, $address_entry);

writeCSV('address_book.csv', $address_book);

var_dump($address_book);
?>


<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h2>Address Book</h2>

<table>
	<tr>
		<td>Name</td>
		<td>Address</td>
		<td>City</td>
		<td>State</td>
		<td>Zip</td>
		<td>Phone</td>
	</tr>
<?php

foreach ($address_book as $key => $row) {
	echo "<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td>
		<td>$row[4]</td>
		<td>$row[4]</td>
	</tr>";
}
?>

</table>

<h1>
<?= $errorMessage; ?>	
</h1>


<h2>Address Book Additions</h2>

<p>
<form method="POST" action="address_book.php">
	* Name: <input type="text" name="name"><br>
	* Address: <input type="text" name="address"><br>
	* City: <input type="text" name="city"><br>
	* State: <input type="text" name="state"><br>
	* Zip: <input type="text" name="zip"><br>
	Phone: <input type="text" name="phone"><br>
	<input type="submit">


</p>	

<p>
		



</body>
</html>