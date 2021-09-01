<?php

    include_once("db_connect.php");
    if(isset($_GET["id"]))
        $id = $_GET["id"];

    $sqlPerson = 
    "SELECT
         p.name
        ,p.surname
        ,p.birth_day
        ,p.birth_place
        ,p.birth_country
        ,p.death_day
        ,p.death_place
        ,p.death_country
    FROM
        t_person p
    WHERE p.id = ?";

    $stmntPerson = $conn->prepare($sqlPerson);
    $stmntPerson->execute([$id]);
    $resultPerson = $stmntPerson->fetch(PDO::FETCH_ASSOC);

    //--------------------------------------------------------------//

    $sqlStandings = 
    "SELECT
         s.placement
        ,s.discipline
        ,oh.year
        ,oh.city
        ,oh.country
        ,oh.type
    FROM
        t_standings s
    INNER JOIN t_oh oh ON s.oh_id = oh.id
    WHERE s.person_id = ?";

    $stmntStandings = $conn->prepare($sqlStandings);
    $stmntStandings->execute([$id]);
    $resultStandings = $stmntStandings->fetchAll(PDO::FETCH_ASSOC);
    
    if(!empty($resultStandings))
        $colsStandings = array_keys($resultStandings[0]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person info</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/person_info.css">
</head>
<body>
    <?php
        if(empty($resultPerson)){
            header("Location: id_not_found.php?id=".$id);
        }
    ?>

    <h3>Details</h3>
    <div class="row personDetails">
    
        <!--Image by <a href="https://pixabay.com/users/wanderercreative-855399/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=973460">Stephanie Edwards</a> from <a href="https://pixabay.com/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=973460">Pixabay</a>-->
        <img src="../img/avatar.png" alt="avatar" class="avatar col-12 col-md-3">
        <div class="personBio col-12 col-md-7">
            <?php
            
                echo "<b>Name: </b>" . $resultPerson["name"] . " " . $resultPerson["surname"];
                echo "<br>";
                echo "<b>Born: </b>" . $resultPerson["birth_day"] . " - " . $resultPerson["birth_place"] . ", " . $resultPerson["birth_country"];
                
                if(!empty($resultPerson["death_day"])){
                    echo "<br>";
                    echo "<b>Died: </b>" . $resultPerson["death_day"] . " - " . $resultPerson["death_place"] . ", " . $resultPerson["death_country"];
                }
            ?>
        </div>
    </div>

    <div class="row buttons">
        <div class="col-sm-12 text-center">
            <?php echo "<a href='edit_person.php?id=" . $id . "' class='btn btn-primary'>Edit person</a>"; ?>
            <?php echo "<a href='delete_person.php?id=" . $id . "' class='btn btn-primary'>Delete person</a>"; ?>
        </div>
    </div>

    <h3>Standings</h3>
    <div class="table">
        <table id="personTable">
            <thead>
                <tr>
                <?php
                    foreach($colsStandings as $colName){
                    if($colName !== "surname")
                        echo "<th>" . ucfirst($colName) . "</th>";
                    }
                ?>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach($resultStandings as $row){
                    echo "<tr>";

                    foreach($colsStandings as $colName){
                        echo "<td>" . $row[$colName] . "</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="row buttons">
        <div class="col-sm-12 text-center">
            <a href="http://wt82.fei.stuba.sk/The_Naked_Sun/" class="btn btn-primary">Go back</a>
        </div>
    </div>

    <footer>
        <span>Webtech 2 - Homework 2 - </span>
        <span>Martin Kováčik</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</body>
</html>