<?php

    if(isset($_GET["id"]))
        $id = $_GET["id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Please stop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/person_info.css">
</head>
<body>

    <div class="row text-center errorId">
        <b class="col-12">Sorry, there is no such person with ID <?php echo $id; ?></b>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-12 text-center">
            <a href="http://wt82.fei.stuba.sk/The_Naked_Sun/" class="btn btn-primary">Go back</a>
        </div>
    </div>

    <footer>
        <span>Webtech 2 - Homework 2 - </span>
        <span>Martin Kováčik</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>