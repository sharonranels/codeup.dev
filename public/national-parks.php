<?php


//Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'codeup', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error.PHP_EOL;
} else {

// echo $mysqli->host_info . "\n";
}

if (!empty($_GET['sort_column'])) {
	$sort_column = $_GET['sort_column'];
// Rereieve the National Parks data using SELECT
	$result = $mysqli->query("SELECT name, location, description, `date`, area_in_acres FROM national_parks ORDER BY $sort_column ASC");
}

if (isset($_GET['desort_column'])) {
	$sort_column = $_GET['desort_column'];
// Rereieve the National Parks data using SELECT
	$result = $mysqli->query("SELECT name, location, description, `date`, area_in_acres FROM national_parks ORDER BY $sort_column DESC");
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>National Parks</title>

	<!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

</head>
<body>
	
	<div class="container">

	<h2>National Parks</h2>

	


	<table class="table table-striped">
		<tr>
			<td><strong>Name</strong><a href='?sort_column=name'><br><span class="glyphicon glyphicon-arrow-up"></span></a><a href='?desort_column=name'><span class="glyphicon glyphicon-arrow-down"></span></a></td>
			<td><strong>Location</strong><br><a href='?sort_column=location'><span class="glyphicon glyphicon-arrow-up"></span></a><a href='?desort_column=location'><span class="glyphicon glyphicon-arrow-down"></td>
			<td><strong>Description</strong><br><a href='?sort_column=description'><span class="glyphicon glyphicon-arrow-up"></span></a><a href='?desort_column=description'><span class="glyphicon glyphicon-arrow-down"></td>
			<td><strong>Date</strong><br><a href='?sort_column=date'><span class="glyphicon glyphicon-arrow-up"></span></a><a href='?desort_column=date'><span class="glyphicon glyphicon-arrow-down"></td>
			<td><strong>Area</strong><br><a href='?sort_column=area_in_acres'><span class="glyphicon glyphicon-arrow-up"></span></a><a href='?desort_column=area_in_acres'><span class="glyphicon glyphicon-arrow-down"></td>
		</tr>

	<? if(!empty($result)) : ?>
		<? while ($park = $result->fetch_array(MYSQLI_ASSOC)) :?>
			<tr>
			<? foreach ($park as $field) : ?>
				<td><?= $field?></td>
				<? endforeach;?>
			</tr>
	<? endwhile;?>
	<? endif;?>

	</table>
	
	</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>	


</body>
</html>
