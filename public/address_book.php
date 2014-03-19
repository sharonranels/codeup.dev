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


<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Address Book</title>

	<!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

<style>
	





</style>

</head>
<body>

<div class="container">

	<h2>Address Book</h2>

<table class="table table-striped">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Address</strong></td>
		<td><strong>City</strong></td>
		<td><strong>State</strong></td>
		<td><strong>Zip</strong></td>
		<td><strong>Phone</strong></td>
		<td><strong>Remove Item?</strong></td>
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
<p>&nbsp;&nbsp;&nbsp;&nbsp;("*" signifies required data)</p><br>

<form role="form" method="POST" action="address_book.php">
  <div class="form-group">
    <label for="Name">* Name</label>
    <input type="text" class="form-control" id="name" placeholder="Enter name">
  </div>
  <div class="form-group">
    <label for="address">* Address</label>
    <input type="text" class="form-control" id="address" placeholder="Enter address">
  </div>
    <div class="form-group">
    <label for="city">* City</label>
    <input type="text" class="form-control" id="city" placeholder="Enter city">
  </div>  <div class="form-group">
    <label for="state">* State</label>
    <input type="text" class="form-control" id="state" placeholder="Enter state">
  </div>  <div class="form-group">
    <label for="zip">* Zip</label>
    <input type="text" class="form-control" id="zip" placeholder="Enter zip">
  </div>
    <div class="form-group">
    <label for="phone">Phone</label>
    <input type="tel" class="form-control" id="phone" placeholder="Enter phone">
  </div>
	<input type="submit">

  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>




<!-- <table class="table">
<! <p> -->
<!-- <form method="POST" action="address_book.php">
	* <strong>Name</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name"><br><br>
	* <strong>Address</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="address"><br><br>
	* <strong>City</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="city"><br><br>
	* <strong>State</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="state"><br><br>
	* <strong>Zip</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="zip"><br><br>
	Phone: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone"><br><br>
	<input type="submit">
</form>
 -->
<!-- </p>	 -->

<!-- </table> -->

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