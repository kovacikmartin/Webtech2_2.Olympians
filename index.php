<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("php/db_connect.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympics</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

  <h3>Olympic winners</h3>
  <div class="table">
    <?php include_once("php/winners_query.php"); ?>
  </div>

  <h3>Top 10 olympians with most wins</h3>
  <div class="table">
    <?php include_once("php/most_winning_query.php"); ?>
  </div>
  
  <div class="row addButtons">
    <div class="col-sm-12 text-center">
      <a href="php/person_add.php" class="btn btn-primary">Add person</a>
      <a href="php/standing_add.php" class="btn btn-primary">Add standing</a>
    </div>
  </div>

  <footer>
    <span>Webtech 2 - Homework 2 - </span>
    <span>Martin Kováčik</span>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
</body>
</html>