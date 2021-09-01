<?php

    include_once("db_connect.php");

    if(isset($_GET["id"]))
        $personId = $_GET["id"];

    $sql = 
    "DELETE
         s
        ,p 
    FROM t_standings s 
    INNER JOIN t_person p ON s.person_id = p.id
    WHERE s.person_id = ?";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete person</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/person_standing_add.css">
</head>
<body>

    <?php
        try{
            $stmnt = $conn->prepare($sql);
            $stmnt->execute([$personId]);
            if($stmnt->rowCount() == 0){
                header("Location: id_not_found.php?id=".$personId);
            }
            echo "<div class='alert alert-success text-center' role='alert'>
                    Person deleted successfully. You will be redirected back in 3 seconds.
                  </div>";

            echo "<script type=\"text/javascript\"> 
                    setTimeout(function(){
                        window.location.href = 'http://wt82.fei.stuba.sk/The_Naked_Sun/';
                    }, 3000);
                  </script>";
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger text-center' role='alert'>
                    Sorry, there was an error.
                  </div>";
            echo "<div class='form-group row'>
                    <div class='col-sm-12 text-center'>
                        <a href='http://wt82.fei.stuba.sk/The_Naked_Sun/' class='btn btn-primary'>Go back</a>
                    </div>
                  </div>";
        }
    ?>

    <footer>
        <span>Webtech 2 - Homework 2 - </span>
        <span>Martin Kováčik</span>
    </footer>
</body>
</html>