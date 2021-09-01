<?php
    include_once("db_connect.php");

    $sqlPersons = "SELECT p.id, p.name, p.surname FROM t_person p";
    $stmntPersons = $conn->query($sqlPersons);
    $personsResult = $stmntPersons->fetchAll(PDO::FETCH_ASSOC);

    $sqlOH = "SELECT oh.id, oh.type, oh.year FROM t_oh oh";
    $stmntOH = $conn->query($sqlOH);
    $ohResult = $stmntOH->fetchAll(PDO::FETCH_ASSOC);


    $personId = $ohId = $placement = $discipline = "";
    $personReq = $ohReq = $placementReq = $disciplineReq = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_POST["person"])){
            $personReq = "You must select a person";
        }
        else{
            $personId = $_POST["person"];
        } 
        
        if(empty($_POST["oh"])){
            $ohReq = "You must select olympic games";
        }
        else{
            $ohId = $_POST["oh"];
        }

        if(empty($_POST["placement"])){
            $placementReq = "Placement cannot be empty";
        }
        else{
            $placement = $_POST["placement"];
        }

        if(empty($_POST["discipline"])){
            $disciplineReq = "Discipline cannot be empty";
        }
        else{
            $discipline = $_POST["discipline"];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add standing</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/person_standing_add.css">
</head>
<body>
    <div class="formContainer">
        <h3>Add standing</h3>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="form-group row">
                <label for="selectPersons" class="col-sm-2 col-form-label">Person</label>
                <div class="col-sm-10">
                    <select class="form-control" id="selectPersons" name="person">
                    <option selected disabled hidden value=''>Choose person</option>           
                        <?php
                            foreach($personsResult as $person){
                                echo "<option value=" . $person["id"] . ">" . $person["name"] . " " . $person["surname"] . "</option>";
                            }
                        ?>
                    </select>
                    <span><?php echo $personReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="selectOH" class="col-sm-2 col-form-label">Olympic games</label>
                <div class="col-sm-10">
                    <select class="form-control" id="selectOH" name="oh">
                    <option selected disabled hidden value=''>Choose OH</option>
                        <?php
                            foreach($ohResult as $oh){
                                echo "<option value=" . $oh["id"] . ">" . $oh["type"] . " - " . $oh["year"] . "</option>";
                            }
                        ?>
                    </select>
                    <span><?php echo $ohReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPlacement" class="col-sm-2 col-form-label">Placement</label>
                <div class="col-sm-10">
                    <input type="number" min="1" class="form-control" name="placement" id="inputPlacement" value="<?php echo $placement; ?>" placeholder="Placement">
                    <span><?php echo $placementReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDiscipline" class="col-sm-2 col-form-label">Discipline</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="discipline" id="inputDiscipline" value="<?php echo $discipline; ?>" placeholder="Discipline">
                    <span><?php echo $disciplineReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary">Add standing</button>
                    <a href="http://wt82.fei.stuba.sk/The_Naked_Sun/" class="btn btn-primary">Go back</a>
                </div>
            </div>
        </form>
    </div>
    <div class="modal" id="successModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert">
                        Standing successfully created. You will be redirected in 3 seconds.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="errorModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Standing already exists.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if($personId && $ohId && $placement && $discipline){

            try{
            
                $sql = "INSERT INTO t_standings(person_id, oh_id, placement, discipline)
                                VALUES(?, ?, ?, ?)";
            
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
                $conn->prepare($sql)->execute([$personId, $ohId, $placement, $discipline]);
                
                echo "<script type=\"text/javascript\"> 
                    $('#successModal').modal('show');
                </script>";
                
                echo "<script type=\"text/javascript\"> 
                        setTimeout(function(){
                            window.location.href = 'http://wt82.fei.stuba.sk/The_Naked_Sun/';
                        }, 3000);
                      </script>";
            }
            catch(PDOException $e){
        
                if($e->getCode() === '23000'){

                    echo "<script type=\"text/javascript\"> 
                            $('#errorModal').modal('show');
                          </script>";
                }
                else{
                    echo "<div class='alert alert-danger' role='alert'>
                                Sorry, there was an error.
                          </div>";
                }
            }
        }
    ?>
    
    <footer>
        <span>Webtech 2 - Homework 2 - </span>
        <span>Martin Kováčik</span>
    </footer>
</body>
</html>