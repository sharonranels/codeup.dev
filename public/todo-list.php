<?php

$items = array();

$filename = "todo_list.txt";

function save_file($input, $items) {
    $itemStr = implode("\n", $items);
    $handle = fopen("todo_list.txt", "w+");
    fwrite($handle, $itemStr);
    fclose($handle);
}

function open_file($input) {
    $handle = fopen($input, "r");
    $contents = fread($handle, filesize($input));
    fclose($handle);
    return explode("\n", $contents);
	}
		if (filesize($filename) > 0) {
			$items = open_file($filename);
}


if(count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
	$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
	$filename = basename($_FILES['file1']['name']);
	$saved_filename = $upload_dir . $filename;
	move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
	$new_array = open_file($saved_filename);
	$items = array_merge($items, $new_array);
	$itemStr = implode("\n", $items);
    $handle = fopen("todo_list.txt", "w+");
    fwrite($handle, $itemStr);
    fclose($handle);
    header("Location:todo-list.php");
	exit(0);
}



if (isset($_POST['newitem']) && !empty($_POST['newitem'])) {
	$item = $_POST['newitem'];
	array_push($items, $item);
	save_file("todo_list.txt", $items);
	header("Location:todo-list.php");
	exit(0);
}

if (isset($_GET['remove'])) {
	$item = $_GET['remove'];
	unset($items[$item]);
	save_file($filename, $items);
	header("Location:todo-list.php");
	exit(0);
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
</head>
<body>


	<h2>TODO List</h2>
	<ul>

	<?php
		
		foreach ($items as $key => $item) {
			echo "<li>$item <a href=\"?remove=$key\">Remove</a></li>";
		}

	 ?>

	</ul>

<h2>Add Tasks to Your TODO List</h2>
	
<form method="POST" action="todo-list.php">
    <p>
        <label for="newitem">Please enter a new task to complete: </label>
        <input id="newitem" name="newitem" type="text" autofocus="autofocus" placeholder="Type new task here...">
    </p>

    <p>
        <button type="submit">Send</button>
    </p>

</form>

    

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