<?php
    include_once("db_connect.php");

    if(isset($_GET["id"]))
        $personId = $_GET["id"];
    
    $sqlRetrieveInfo = 
    "SELECT
         p.name
        ,p.surname
        ,p.birth_day
        ,p.birth_place
        ,p.birth_country
        ,p.death_day
        ,p.death_place
        ,p.death_country
    FROM t_person p
    WHERE id = ?";

    
    $stmntRetrieveInfo = $conn->prepare($sqlRetrieveInfo);
    $stmntRetrieveInfo->execute([$personId]);
    $retrieveInfoResult = $stmntRetrieveInfo->fetch(PDO::FETCH_ASSOC);

    if(empty($retrieveInfoResult)){
        header("Location: id_not_found.php?id=".$personId);
    }
    
    $name = $surname = $birthDate = $birthPlace = $birthCountry = $deathDate = $deathPlace = $deathCountry = "";

    $name = $retrieveInfoResult["name"];
    $surname = $retrieveInfoResult["surname"];
    
    $birthDateFormatted = DateTime::createFromFormat("j.n.Y", $retrieveInfoResult["birth_day"]);
    $birthDate = $birthDateFormatted->format("Y-m-d");

    $birthPlace = $retrieveInfoResult["birth_place"];
    $birthCountry = $retrieveInfoResult["birth_country"];

    if($retrieveInfoResult["death_day"]){
        $deathDateFormatted = DateTime::createFromFormat("j.n.Y", $retrieveInfoResult["death_day"]);
        $deathDate = $deathDateFormatted->format("Y-m-d");
    }
    else{
        $deathDate = "";
    }

    $deathPlace = $retrieveInfoResult["death_place"];
    $deathCountry = $retrieveInfoResult["death_country"];

    $nameReq = $surnameReq = $birthDateReq = $birthPlaceReq = $birthCountryReq = $deathDateReq = $deathPlaceReq = $deathCountryReq = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_POST["name"])){
            $nameReq = "Name cannot be empty";
            $name = "";
        }
        else{
            $name = $_POST["name"];
        } 
        
        if(empty($_POST["surname"])){
            $surnameReq = "Surname cannot be empty";
            $surname = "";
        }
        else{
            $surname = $_POST["surname"];
        }

        if(empty($_POST["birthDate"])){
            $birthDateReq = "Date of birth cannot be empty";
            $birthDate = "";
        }
        else{
            $birthDate = $_POST["birthDate"];

            $birthDateFormatted = DateTime::createFromFormat("Y-m-d", $birthDate);
            $birthDateFormatted = $birthDateFormatted->format("j.n.Y");
        }

        if(empty($_POST["birthPlace"])){
            $birthPlaceReq = "City of birth cannot be empty";
            $birthPlace = "";
        }
        else{
            $birthPlace = $_POST["birthPlace"];
        }

        if(empty($_POST["birthCountry"])){
            $birthCountryReq = "Country of birth cannot be empty";
            $birthCountry = "";
        } 
        else{
            $birthCountry = $_POST["birthCountry"];
        }

        $deathDate = $deathDateFormatted = $deathPlace = $deathCountry = "";

        if(!empty($_POST["deathDate"]) || !empty($_POST["deathPlace"]) || !empty($_POST["deathCountry"])){
            
            if(empty($_POST["deathDate"])){

                $deathDateReq = "Date of death cannot be empty";
                $deathDate = "";
            }
            else{
                $deathDate = $_POST["deathDate"];
                $deathDateFormatted = DateTime::createFromFormat("Y-m-d", $_POST["deathDate"]);
                $deathDateFormatted = $deathDateFormatted->format("j.n.Y");
            }

            if(empty($_POST["deathPlace"])){
                $deathPlaceReq = "Place of death cannot be empty";
                $deathPlace = "";
            }
            else{
                $deathPlace = $_POST["deathPlace"];
            }

            if(empty($_POST["deathCountry"])){
                $deathCountryReq = "Country of death cannot be empty";
                $deathCountry = "";
            }
            else{
                $deathCountry = $_POST["deathCountry"];
            }
        }
    }

    function update($conn, $name, $surname, $birthDateFormatted, $birthPlace, $birthCountry, $deathDateFormatted, $deathPlace, $deathCountry, $personId){
        try{
            
            $sql = "UPDATE t_person SET name=?, surname=?, birth_day=?, birth_place=?, birth_country=?, death_day=?, death_place=?, death_country=?
                    WHERE id=?";
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
            $conn->prepare($sql)->execute([$name, $surname, $birthDateFormatted, $birthPlace, $birthCountry, $deathDateFormatted, $deathPlace, $deathCountry, $personId]);
            
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
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error.
                </div>";

            echo "<div class='form-group row'>
                    <div class='col-sm-12 text-center'>
                        <a href='http://wt82.fei.stuba.sk/The_Naked_Sun/' class='btn btn-primary'>Go back</a>
                    </div>
                  </div>";

            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit person</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/person_standing_add.css">
</head>
<body>
    <div class="formContainer">
        <h3>Edit person</h3>
        <form action="<?php echo $_SERVER["PHP_SELF"]."?id=".$personId; ?>" method="POST">
            <div class="form-group row">
                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="inputName" value="<?php echo $name; ?>" placeholder="Name">
                    <span><?php echo $nameReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputSurname" class="col-sm-2 col-form-label">Surname</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="surname" id="inputSurname" value="<?php echo $surname; ?>" placeholder="Surname">
                    <span><?php echo $surnameReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputBirthDate" class="col-sm-2 col-form-label">Date of birth</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="birthDate" id="inputBirthDate" value="<?php echo $birthDate; ?>">
                    <span><?php echo $birthDateReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputBirthPlace" class="col-sm-2 col-form-label">City of birth</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="birthPlace" id="inputBirthPlace" value="<?php echo $birthPlace; ?>" placeholder="City of birth">
                    <span><?php echo $birthPlaceReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputBirthCountry" class="col-sm-2 col-form-label">Country of birth</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="birthCountry" id="inputBirthCountry" value="<?php echo $birthCountry; ?>" placeholder="Country of birth">
                    <span><?php echo $birthCountryReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDeathDate" class="col-sm-2 col-form-label">Date of death</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="deathDate" id="inputDeathDate" value="<?php echo $deathDate; ?>">
                    <span><?php echo $deathDateReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDeathPlace" class="col-sm-2 col-form-label">City of death</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="deathPlace" id="inputDeathPlace" value="<?php echo $deathPlace; ?>" placeholder="City of death">
                    <span><?php echo $deathPlaceReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDeathCountry" class="col-sm-2 col-form-label">Country of death</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="deathCountry" id="inputDeathCountry" value="<?php echo $deathCountry; ?>" placeholder="Country of death">
                    <span><?php echo $deathCountryReq; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary">Edit person</button>
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
                        Person successfully edited. You will be redirected in 3 seconds.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($name && $surname && $birthDate && $birthPlace && $birthCountry && !$deathDate && !$deathPlace && !$deathCountry){
            
            update($conn, $name, $surname, $birthDateFormatted, $birthPlace, $birthCountry, $deathDateFormatted, $deathPlace, $deathCountry, $personId);
        }

        if($name && $surname && $birthDate && $birthPlace && $birthCountry && $deathDate && $deathPlace && $deathCountry){
            
            update($conn, $name, $surname, $birthDateFormatted, $birthPlace, $birthCountry, $deathDateFormatted, $deathPlace, $deathCountry, $personId);
        }
    }
    ?>

    <footer>
        <span>Webtech 2 - Homework 2 - </span>
        <span>Martin Kov????ik</span>
    </footer>
</body>
</html>