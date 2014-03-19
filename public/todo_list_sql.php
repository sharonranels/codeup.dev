<?php

$limit = 10;

//Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'codeup', 'todo_list');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error.PHP_EOL;
}

$errorMessage = "";

$result = $mysqli->query("SELECT * FROM list_items");
$num_rows = $result->num_rows;
$num_pages = ceil($num_rows / $limit);
$result->close();

if (!empty($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

if ($page > 1) {
	$offset = ($_GET['page'] * $limit) - $limit;
} else {
	$offset = 0;
}

if (!empty($_POST)) {
	if (isset($_POST['removeID'])) {
		$id = $_POST['removeID'];
		$stmt = $mysqli->prepare("DELETE FROM list_items WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
	} else {

		try {
			if ((empty($_POST["item"])) || (strlen("item" > 50))) {
				throw new Exception("Item must be within 1 and 50 characters - please retry");
			} else {
				$item = $_POST["item"];
				$stmt = $mysqli->prepare("INSERT INTO list_items (item) VALUES (?)");
				$stmt->bind_param("s", $item);
				$stmt->execute();
			}
		} catch (Exception $e) {
			$errorMessage = $e->getMessage();
		}

	}
}

$stmt = $mysqli->prepare("SELECT * FROM list_items LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$stmt->bind_result($id, $item);
$rows = array();

while ($stmt->fetch()) {
	$rows[] = array('id' => $id, 'item' => $item);
}

?>


<!DOCTYPE html>
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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO List</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="container">

	<h2>To Do List</h2>

	<? if (!empty($errorMessage)): ?>
		<div class="alert alert-danger alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Warning!</strong><?= $errorMessage; ?>
		</div>
	<? endif; ?>

	<!-- Button trigger modal -->
	<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	  Add more things to do
	</button>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add more things to do</h4>
	      </div>
	      <div class="modal-body">
	        <form role="form" method="post">
			  <div class="form-group">
			    <label for="name">Item</label>
			    <input type="text" class="form-control" id="item" name="item"placeholder="Enter new item">
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</form>
	      </div>
	    </div>
	  </div>
	</div>
		
	<? if(!empty($rows)) : ?>
		<ul>
			<? foreach ($rows as $items) :?>
				<li>
					<?= $items['item']?>
					<button onclick="removeById(<?= $items['id']; ?>)">Remove Item</button>
				</li>
			<? endforeach;?>
		</ul>
	<? endif;?>
		
<div class="pager">
	<? if($page > 1): ?>
	<? $page_no = $page - 1; ?>
	<a href="?page=<?= $page_no; ?>">Previous</a>
<? endif; ?>

<? if($page < $num_pages): ?>
<? $page_no = $page + 1; ?>
<a href="?page=<?= $page_no; ?>">Next</a>
<? endif; ?>
</div>

<hr>

<form id="removeForm" method="post">
	<input id="removeID" type="hidden" name="removeID" Value="">
</form>

<script>
	
	var form = document.getElementById('removeForm');
	var removeID = document.getElementById('removeID');

	function removeById(id) {
		removeID.value = id;
		form.submit();
	}
</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>