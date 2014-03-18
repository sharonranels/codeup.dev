<?php
//Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'codeup', 'address_list_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error.PHP_EOL;
}

$errorMessage = "";


// Sort columns

if (!empty($_GET['sort_column'])) {
  $sort_column = $_GET['sort_column'];
  $sort_order = $_GET['sort_order'];

// Retreieve the National Parks data using SELECT

  $result = $mysqli->query("SELECT name, street, city, state, zip FROM names_and_addresses ORDER BY $sort_column $sort_order");
} else {
  $result = $mysqli->query("SELECT name, street, city, state, zip FROM names_and_addresses");
}


// Gather posted data, validate and place into an array in the data base

if (!empty($_POST)) {

  try {
    if ((empty($_POST["name"])) || (strlen("name" > 50))) {
      throw new Exception("Name must be within 1 and 50 characters - please retry");
    }
    if ((empty($_POST["street"])) || (strlen("street" > 50))) {
      throw new Exception("Street must be within 1 and 50 characters - please retry");
    }
    if ((empty($_POST["city"])) || (strlen("city" > 50))) {
      throw new Exception("City must be between 1 and 50 characters - please retry");
    }
    if ((empty($_POST["state"])) || (strlen("state" > 2))) {
      throw new Exception("Please use the 2-letter abbreviation for State");
    }
    if ("zip" > 999999999999) {
      throw new Exception("Please enter the 7 or 11-digit zipcode");
    } else {
      $name = $_POST["name"];
      $street = $_POST["street"];
      $city = $_POST["city"];
      $state = $_POST["state"];
      $zip = $_POST["zip"];

      $stmt = $mysqli->prepare("INSERT INTO names_and_addresses (name, street, city, state, zip) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $name, $street, $city, $state, $zip);
      $stmt->execute();
      $mysqli->close();
    }
  } catch (Exception $e) {
    $errorMessage = $e->getMessage();
    }

}





?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Address Book</title>

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
    
    <table id="header-fixed" class="table table-striped"></table>

    <table class="table table-striped" id="table-1">
      <thead>
        <tr>
        <td style="width:20%;"><strong>Name</strong>
          <a href='?sort_column=name&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
          <a href='?sort_column=name&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></span></a></td>
        
        <td style="width:20%;"><strong>Street</strong>
          <a href='?sort_column=street&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
          <a href='?sort_column=street&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
        
        <td style="width:20%;"><strong>City</strong>
          <a href='?sort_column=city&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
          <a href='?sort_column=city&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
        
        <td style="width:20%;"><strong>State</strong>
          <a href='?sort_column=state&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
          <a href='?sort_column=state&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
        
        <td style="width:20%;"><strong>Zip</strong>
          <a href='?sort_column=zip&amp;sort_order=ASC'><span class="glyphicon glyphicon-arrow-up"></span></a>
          <a href='?sort_column=zip&amp;sort_order=DESC'><span class="glyphicon glyphicon-arrow-down"></td>
        </tr>
      </thead>
      <tbody>
        <? if(!empty($result)) : ?>
          <? while ($row = $result->fetch_array(MYSQLI_ASSOC)) :?>
            <tr>
            <? foreach ($row as $field) : ?>
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
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>