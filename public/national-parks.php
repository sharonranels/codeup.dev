<?php


//Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'codeup', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error.PHP_EOL;
} else {

// echo $mysqli->host_info . "\n";
}

$errorMessage = "";


// Sort columns

if (!empty($_GET['sort_column'])) {
	$sort_column = $_GET['sort_column'];
	$sort_order = $_GET['sort_order'];

// Retreieve the National Parks data using SELECT

	$result = $mysqli->query("SELECT name, location, description, `date`, area_in_acres FROM national_parks ORDER BY $sort_column $sort_order");
} else {
	$result = $mysqli->query("SELECT name, location, description, `date`, area_in_acres FROM national_parks");
}


// Gather posted data, validate and place into an array in the table
if (!empty($_POST)) {

	try {
		if ((empty($_POST["name"])) || (strlen("name" > 50))) {
			throw new Exception("Name must be within 1 and 50 characters - please retry");
		}
		if ((empty($_POST["location"])) || (strlen("location" > 50))) {
			throw new Exception("Location must be within 1 and 50 characters - please retry");
		}
		if ((empty($_POST["description"])) || (strlen("description" > 50))) {
			throw new Exception("Description cannot be left blank - please retry");
		}
		if ((empty($_POST["date"])) || (strlen("date" > 50))) {
			throw new Exception("Date must be within 1 and 50 characters - please retry");
		}
		if ((empty($_POST["area_in_acres"])) || (strlen("area_in_acres" > 50))) {
			throw new Exception("Area must be within 1 and 50 characters - please retry");
		} else {
			$name = $_POST["name"];
			$location = $_POST["location"];
			$description = $_POST["description"];
			$date = $_POST["date"];
			$area_in_acres = $_POST["area_in_acres"];

			$stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, description, `date`, area_in_acres) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sssss", $name, $location, $description, $date, $area_in_acres);
			$stmt->execute();
			$mysqli->close();
		}
	} catch (Exception $e) {
		$errorMessage = $e->getMessage();
		}


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

	<? if (!empty($errorMessage)): ?>
		<div class="alert alert-danger alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Warning!</strong><?= $errorMessage; ?>
		</div>
	<? endif; ?>

	<!-- Button trigger modal -->
	<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	  Add more parks
	</button>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add more parks</h4>
	      </div>
	      <div class="modal-body">
	        <form role="form" method="post">
			  <div class="form-group">
			    <label for="name">Name</label>
			    <input type="text" class="form-control" id="name" name="name"placeholder="Enter park name">
			  </div>
			  <div class="form-group">
			    <label for="location">Location</label>
			    <input type="text" class="form-control" id="location" name="location" placeholder="Location">
			  </div>
			  <div class="form-group">
			    <label for="description">Description</label>
			    <input type="text" class="form-control" id="description" name="description" placeholder="Description">
			  </div>
			  <div class="form-group">
			    <label for="date">Date</label>
			    <input type="text" class="form-control" id="date" name="date" placeholder="Date">
			  </div>
			  <div class="form-group">
			    <label for="area_in_acres">Area</label>
			    <input type="text" class="form-control" id="area_in_acres" name="area_in_acres" placeholder="Area in acres">
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</form>
	      </div>
	    </div>
	  </div>
	</div>
	

	<table id="header-fixed" class="table table-striped"></table>

	<table class="table table-striped" id="table-1">
		<thead>
			<tr>
			<td style="width:15%;"><strong>Name</strong>
				<a href='?sort_column=name&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?sort_column=name&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></span></a></td>
			
			<td style="width:15%;"><strong>Location</strong>
				<a href='?sort_column=location&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?sort_column=location&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
			
			<td style="width:45%;"><strong>Description</strong>
				<a href='?sort_column=description&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?sort_column=description&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
			
			<td style="width:15%;"><strong>Date</strong>
				<a href='?sort_column=date&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?sort_column=date&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
			
			<td style="width:10%;"><strong>Area</strong>
				<a href='?sort_column=area_in_acres&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
				<a href='?sort_column=area_in_acres&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
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
