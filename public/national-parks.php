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

<style type="text/css">
	
body { height: 1000px; }

#header-fixed { 
    position: fixed; 
    top: 0px; display:none;
    background-color:white;
}




</style>
	<meta charset="UTF-8">
	<title>National Parks</title>

	<!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

</head>
<body>
	



	<div class="container">

	<h2>National Parks</h2>

	<table id="header-fixed" class="table table-striped"></table>

	<table class="table table-striped" id="table-1">
		<thead>
			<tr>
			<td style="width:15%;"><strong>Name</strong>
				<a href='?sort_column=name'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?desort_column=name'><span class="glyphicon glyphicon-arrow-down"></span></a></td>
			
			<td style="width:15%;"><strong>Location</strong>
				<a href='?sort_column=location'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?desort_column=location'><span class="glyphicon glyphicon-arrow-down"></td>
			
			<td style="width:45%;"><strong>Description</strong>
				<a href='?sort_column=description'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?desort_column=description'><span class="glyphicon glyphicon-arrow-down"></td>
			
			<td style="width:15%;"><strong>Date</strong>
				<a href='?sort_column=date'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?desort_column=date'><span class="glyphicon glyphicon-arrow-down"></td>
			
			<td style="width:10%;"><strong>Area</strong>
				<a href='?sort_column=area_in_acres'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?desort_column=area_in_acres'><span class="glyphicon glyphicon-arrow-down"></td>
		</tr>
		</thead>
		<tbody>
	<? if(!empty($result)) : ?>
		<? while ($park = $result->fetch_array(MYSQLI_ASSOC)) :?>
			<tr>
			<? foreach ($park as $field) : ?>
				<td><?= $field?></td>
				<? endforeach;?>
			</tr>
		<? endwhile;?>
	<? endif;?>
		</tbody>
	</table>
	
	</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>	


<script type="text/javascript">
	var tableOffset = $("#table-1").offset().top;
	var $header = $("#table-1 > thead").clone();
	var $fixedHeader = $("#header-fixed").append($header);

	$(window).bind("scroll", function() {
	    var offset = $(this).scrollTop();
	    
	    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
	        $fixedHeader.show();
	    }
	    else if (offset < tableOffset) {
	        $fixedHeader.hide();
	    }
	});



</script>




</body>
</html>
