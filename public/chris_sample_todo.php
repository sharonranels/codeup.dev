<?php
 
var_dump($_GET);
 
var_dump($_POST);
 
// delete from todo_table where id = ?
 
$todoList = [
	'take out the trash',
	'mow the yard',
	'buy groceries'
];
 
?>
<html>
<head>
	<title>Todo List</title>
</head>
<body>
 
<h1>Todo List</h1>
 
<ul>
<? foreach($todoList as $key => $item): ?>
	<li><?= $item; ?> <button onclick="removeById(<?= $key; ?>)">Remove</button></li>
<? endforeach; ?>
</ul>
 
<form id="removeForm" action="todo-db.php" method="post">
	<input id="removeId" type="hidden" name="remove" value="">
</form>
 
<script>
	
	var form = document.getElementById('removeForm');
	var removeId = document.getElementById('removeId');
 
	function removeById(id) {
		removeId.value = id;
		form.submit();
	}
 
</script>
 
</body>
</html>
