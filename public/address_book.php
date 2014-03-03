<?php

require_once('ADDRESS_DATA_STORE.PHP');

$errorMessage = '';

$filename = 'address_book.csv';
$run = new AddressDataStore($filename);
$address_book = $run->read();

if(count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
	if($_FILES['file1']['type'] == 'text/csv') {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$uploaded_file = new AddressDataStore($saved_filename);
		$new_array = $uploaded_file->read();
		$address_book = array_merge($address_book, $new_array);
		$run->write($address_book);
		header("Location:address_book.php");
		exit(0);

	}
}


if(!empty($_POST)) {
	try {
		$run->validate('name', $_POST['name']);
		$run->validate('address', $_POST['address']);
		$run->validate('city', $_POST['city']);
		$run->validate('state', $_POST['state']);
		$run->validate('zip', $_POST['zip']);
	    array_push($address_book, array_values($_POST));
	    $run->write($address_book);
	} catch (Exception $e) {
		$errorMessage = "You must enter between 1 and 125 characters.";
	}
}





if (isset($_GET['remove'])) {
	$remove = $_GET['remove'];
	unset($address_book[$remove]);
	$run->write($address_book);
	header("Location:address_book.php");
	exit(0);
}

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

<? if(!empty($address_book)) : ?>
	<? foreach ($address_book as $key => $rows) : ?>
		<tr>
		<? foreach ($rows as $field) : ?>
			<td><?= "$field"?></td>
			<? endforeach;?>
			<td><?=" <a href=\"?remove=$key\">Remove</a>"; ?></td>
		</tr>
<? endforeach;?>
<? endif;?>

</table>

<h3>
<?= $errorMessage; ?>	
</h3>


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
</form>

</p>	

<form method="POST" enctype="multipart/form-data" action="">
    <p>
        <label for="file1">Please select file to upload: </label>
        <input type="file" id="file1" name="file1">
    </p>
	<p>
        <button type="submit" value="Upload">Send</button>
    </p>



</form>
	

</body>
</html>