<?php

$address_entry = [];
$filename = "address_book.csv";
$errorMessage = '';


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

if(!empty($_POST)) {
	$name = $_POST['name'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$phone = $_POST['phone'];

$address_entry = [$name, $address, $city, $state, $zip, $phone];

array_push($address_book, $address_entry);

writeCSV('address_book.csv', $address_book);

}

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