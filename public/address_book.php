<?php

require_once('address_data_store.php');

$errorMessage = '';

$filename = 'address_book.csv';
$run = new AddressDataStore($filename);
$address_book = $run->read_address_book();

if(count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
	if($_FILES['file1']['type'] == 'text/csv') {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$uploaded_file = new AddressDataStore($saved_filename);
		$new_array = $uploaded_file->read_address_book();
		var_dump($new_array);
		$address_book = array_merge($address_book, $new_array);
		$run->writeCSV($address_book);
	    header("Location:address_book.php");
		exit(0);

	}
}

if(!empty($_POST)) {
	if(empty($_POST['name'])) {
		$errorMessage = 'You must give data for everything with "*".';
	} elseif (empty($_POST['address'])) {
		$errorMessage = 'You must give data for everything with "*".';
	} elseif (empty($_POST['city'])) {
		$errorMessage = 'You must give data for everything with "*".';
	} elseif (empty($_POST['state'])) {
		$errorMessage = 'You must give data for everything with "*".';
	} elseif (empty($_POST['zip'])) {
		$errorMessage = 'You must give data for everything with "*".';
	} else {
		array_push($address_book, $_POST);
		$run->writeCSV($address_book);
	}
}

if (isset($_GET['remove'])) {
	$remove = $_GET['remove'];
	unset($address_book[$remove]);
	$run->writeCSV($address_book);
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