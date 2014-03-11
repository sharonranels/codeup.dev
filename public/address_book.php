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
		//$errorMessage = "You must enter between 1 and 125 characters.";
		echo 'Error: ' . $e->getMessage();
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
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Address Book</title>

	<!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

<style>
	
	body {
	background-image: url(/img/notebook.png);
}




</style>

</head>
<body>

<div class="container">

	<h2>Address Book</h2>

<table class="table">
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


<h2>Address Book Additions - "*" signifies required data</h2>

<table class="table">
<p>
<form method="POST" action="address_book.php">
	* <strong>Name</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name"><br><br>
	* <strong>Address</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="address"><br><br>
	* <strong>City</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="city"><br><br>
	* <strong>State</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="state"><br><br>
	* <strong>Zip</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="zip"><br><br>
	Phone: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone"><br><br>
	<input type="submit">
</form>

</p>	

</table>

<form method="POST" enctype="multipart/form-data" action="">
    <p>
        <label for="file1">Please select file to upload: </label>
        <input type="file" id="file1" name="file1">
    </p>
	<p>
        <button type="submit" value="Upload">Send</button>
    </p>



</form>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>	

</body>
</html>