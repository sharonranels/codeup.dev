<?php

require_once('filestore.php');

class TodoList extends Filestore {

	public $filename = "todo_list.txt";

	public $items = array();

	public function __construct($filename = '') {
		if (!empty($filename)) {
			$this->filename = $filename;
		}
        	$this->items = $this->get_file();
	}
	
	// public function save_file {
	    // $itemStr = implode("\n", $this->items);
	    // $handle = fopen($this->filename, "w+");
	    // fwrite($handle, $itemStr);
	    // fclose($handle);
	// }

	// public function read_file() {
	//     $handle = fopen($this->filename, "r+");
	//     $contents = fread($handle, filesize($this->filename));
	//     fclose($handle);
	//     return explode("\n", $contents);
	// }
	
	public function get_file() {
		if (filesize($this->filename) > 0) {
			return $this->read();
		} else {
			return array();
		}
	}

	public function remove_item($key, $redirect = FALSE) {
		unset($this->items[$key]);
		$this->write($this->items);
		if (is_string($redirect)) {
			header("Location: $redirect");
			exit(0);
		}
	}

	public function add_item($thing) {
		array_push($this->items, $thing);
		$this->write('todo_list.txt');
		//header("Location:todo-list.php");
		//exit(0);
	}

}

$archive = array();
$errorMessage = '';

$new_todo_list = new TodoList(); // MAIN INSTANCE

if(count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
	if($_FILES['file1']['type'] == 'text/plain') {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$uploaded_file = new TodoList($saved_filename);
		$new_array = $uploaded_file->read($saved_filename);
		var_dump($new_array);
		if($_POST['overwrite'] == TRUE) {
			$handle = fopen('todo_list.txt', "w");
			$itemStr = implode("\n", $new_array);
		    fwrite($handle, $itemStr);
		    fclose($handle);
			header("Location:todo-list.php");
			exit(0);
		} else {
			$items = array_merge($new_todo_list->items, $new_array);
			$handle = fopen('todo_list.txt', "w");
			$itemStr = implode("\n", $items);
			fwrite($handle, $itemStr);
		    fclose($handle);
		    header("Location:todo-list.php");
			exit(0);
		}
	} else {
		$errorMessage = "The file you are trying to load is not a txt file - please select a different file.";
	}
}

if (!empty($_POST['newitem'])) {
	$new_todo_list->add_item($_POST['newitem']);
}

if (isset($_GET['remove'])) {
	$new_todo_list->remove_item($_GET['remove'], 'todo-list.php');
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

	
		
	<? foreach ($new_todo_list->items as $key => $item): ?>
			<li><?= htmlspecialchars(strip_tags($item)) . " <a href=\"?remove=$key\">Remove</a>"; ?></li>
	<? endforeach; ?>



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

<h1>
<?= $errorMessage; ?>	
</h1>

<form method="POST" enctype="multipart/form-data" action="">
    <p>
        <label for="file1">Please select file to upload: </label>
        <input type="file" id="file1" name="file1">
    </p>
        
 <!--    <p>
        <button type="submit" value="Upload">Send</button>
    </p>
 -->

   <p>
        <label for="overwrite">Check here if you want to overwrite the file with this new information: </label>
        <input type="checkbox" id="overwrite" name="overwrite">
    </p>
        
    <p>
        <button type="submit" value="Upload">Upload</button>
    </p>


</form>


</body>
</html>