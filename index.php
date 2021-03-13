<?php
include "Classes/Game.php";
include "Classes/Winners.php";
include "Classes/helper/Database.php";
include "Classes/Person.php";
include "Classes/Placement.php";

$sortNameAsc = "asc";
$sortNameDesc = "desc";
$sortYearAsc = "yearAsc";
$sortYearDesc = "yearDesc";
$sortTypeAsc = "typeAsc";
$sortTypeDesc = "typeDesc";
$urlSort = $_GET['sorting'];
$urlPerson = $_GET['person'];
$urlEdit = $_GET['edit'];
$urlDelete =$_GET['delete'];


try {
    $db = new Database();
    $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $stmt = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1; ");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtASC = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1 order by osoby.name ASC ; ");
    $stmtASC->execute();
    $resultASC = $stmtASC->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtDESC = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1 order by osoby.name DESC ; ");
    $stmtDESC->execute();
    $resultDESC = $stmtDESC->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtYearAsc = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1 order by o.year ASC; ");
    $stmtYearAsc->execute();
    $resultYearAsc = $stmtYearAsc->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtYearDesc = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1 order by o.year DESC ; ");
    $stmtYearDesc->execute();
    $resultYearDesc = $stmtYearDesc->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtTypeAsc = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1 order by o.type,o.year ASC ; ");
    $stmtTypeAsc->execute();
    $resultTypeAsc = $stmtTypeAsc->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtTypeDesc = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
    from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id where placing = 1 order by o.type,o.year DESC; ");
    $stmtTypeDesc->execute();
    $resultTypeDesc = $stmtTypeDesc->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtTopTen = $db->getConnection()->prepare("select SUM(umiestnenia.placing = 1) as golds,osoby.name,osoby.surname,osoby.birth_day,
       osoby.birth_place,osoby.birth_country,osoby.death_day,osoby.death_place,osoby.death_country
from umiestnenia join osoby on  umiestnenia.person_id = osoby.id group by umiestnenia.person_id order by golds DESC limit 10 ; ");
    $stmtTopTen->execute();
    $resultTopTen = $stmtTopTen->fetchAll(PDO::FETCH_CLASS,"Winners");

    $stmtPerson = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,u.placing,o.year,o.city,o.type,u.discipline
from osoby join umiestnenia u on osoby.id = u.person_id join oh o on o.id = u.oh_id  where osoby.id = '$urlPerson'; ");
    $stmtPerson->execute();
    $resultPerson = $stmtPerson->fetchAll(PDO::FETCH_CLASS,"Winners");
}

catch (PDOException $exception){
    echo "Error: " . $exception->getMessage();
}

/**
 * Poznámka:
 * AK som skúšal používať PersonController tak mi to z nejakého dôvodu
 * nechcelo vôbec zobratiť stránku.. Z toho dôvodu som sa rozhodol
 * využiť tento nie pekný ale fungujucí prístup
 */

if(isset($_POST['name'])){
    if(isset($_POST['id'])){
       $person = new Person();
        try {
            $person->setId($_POST['id']);
            $person->setName($_POST['name']);
            $person->setSurname($_POST['surname']);
            $person->setBirthDay($_POST['birth_day']);
            $person->setBirthPlace($_POST['birth_place']);
            $person->setBirthCountry($_POST['birth_country']);

            $id = $person->getId();
            $name = $person->getName();
            $surname = $person->getSurname();
            $birth_day = $person->getBirthDay();
            $birth_place = $person->getBirthPlace();
            $birth_country = $person->getBirthCountry();

            $conn = new Database();
            $conn->getConnection()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->getConnection()->prepare("Insert into osoby (id,name, surname, birth_day, birth_place, birth_country) 
        values ('$id','$name','$surname','$birth_day','$birth_place','$birth_country')");
            $stmt->execute();
            header("Refresh:0; url = index.php");
        } catch (PDOException $exception){
            echo "<script>alert('Nemôžeš vytvoriť osobu ktorá už existuje !!')</script>";
        }

    }
}

if(isset($_POST['person_id'])){
    if(isset($_POST['oh_id'])){
        $placement = new Placement();
        $placement->setPersonId($_POST['person_id']);
        $placement->setOhId($_POST['oh_id']);
        $placement->setPlacing($_POST['placing']);
        $placement->setDiscipline($_POST['discipline']);

        $person_id = $placement->getPersonId();
        $oh_id = $placement->getOhId();
        $placing = $placement->getPlacing();
        $discipline = $placement->getDiscipline();

        $conn = new Database();
        $conn->getConnection()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->getConnection()->prepare("Insert into umiestnenia (person_id,oh_id,placing,discipline) 
        values ('$person_id','$oh_id','$placing','$discipline')");
        $stmt->execute();

        header("Refresh:0; url = index.php");
    }
}


if(isset($_POST['deleting'])){
        if(isset($urlDelete)){

        $conn = new Database();
        $conn->getConnection()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->getConnection()->prepare("DELETE  FROM umiestnenia WHERE person_id ='$urlDelete';");
        $stmt->execute();
        $stmt = $conn->getConnection()->prepare("DELETE  FROM osoby WHERE id ='$urlDelete';");
        $stmt->execute();

        header("Refresh:0; url = index.php");
    }

}


?>

<!doctype html>

<html lang="en">
<head>

    <title>Olympic Winners</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/44b171361e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Amaranth&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>


<body>

<header>
    <nav class="navbar">

        <h1>
            <i class='fas fa-medal'></i> Olympijský víťazi <i class='fas fa-medal'></i>
        </h1>
    </nav>
</header>

<main>
    <div class='container'>

        <table  class='table table-dark table-hover table-bordered border-light  table-hover'>
            <thead>
            <tr>
                <th style='display: none'>>id</th>
                <th>Olympijský víťaz <a href='?sorting=<?php echo $sortNameAsc?>'><i class='fas fa-sort-alpha-down'></i></a>
                    <a href='?sorting=<?php echo $sortNameDesc?>'><i class='fas fa-sort-alpha-down-alt'></i></a>
                </th>
                <th>
                    Umiestnenie <i class='fas fa-medal'></i>
                </th>
                <th>Rok <a href='?sorting=<?php echo $sortYearAsc?>'> <i class='fas fa-sort-numeric-down'></i></a>
                    <a href='?sorting=<?php echo $sortYearDesc?>'><i class='fas fa-sort-numeric-down-alt'></i></a>
                </th>
                <th>Mesto <i class='fas fa-city'></i></th>
                <th>Typ<a href='?sorting=<?php echo $sortTypeAsc?>'> <i class='fas fa-sort-amount-down-alt'></i></a>
                    <a href='?sorting=<?php echo $sortTypeDesc?>'><i class='fas fa-sort-amount-down'></i></a>
                </th>

                <th>Discplína</th>
                <th>Uprav</th>
                <th>Vymaž</th>

            </thead>
            <tbody>

            <?php

            if($_GET['person']) {
                echo "
                    <a href='index.php' class='btn btn-danger'>Späť<i class='fas fa-undo'></i></a>
                ";
                    if($urlPerson){
                        foreach ($resultPerson as $value){
                            echo $value->getPersonInfo();
                            echo "<td></td>
                               <td></td>
                               </tr>";
                        }
                    }
            }

          else  if($_GET['sorting']) {

                    if ($urlSort == "asc") {
                        foreach ($resultASC as $winners) {
                            echo $winners->getRow();

                        }
                    }
                    if ($urlSort == "desc") {
                        foreach ($resultDESC as $winners) {
                            echo $winners->getRow();

                        }
                    }


                    if ($urlSort == "typeAsc") {
                        foreach ($resultTypeAsc as $winners) {
                            echo $winners->getRow();

                        }
                    } else if ($urlSort == "typeDesc") {
                        foreach ($resultTypeDesc as $winners) {
                            echo $winners->getRow();

                        }
                    } else if ($urlSort == "yearAsc") {
                        foreach ($resultYearAsc as $winners) {
                            echo $winners->getRow();

                        }
                    } else if ($urlSort == "yearDesc") {
                        foreach ($resultYearDesc as $winners) {
                            echo $winners->getRow();
                        }
                    }
            }
             else {

                     foreach ($result as $winners) {
                         echo $winners->getRow();
                     }

             }


            ?>

            </tbody>
        </table>

        <div class="addOlympicv">
            <button type="button" id="create" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Vytvor nového športovca <i class="fas fa-user-plus"></i></button>
            <button type="button" id="add-placing" class="btn btn-success btn-lg" data-toggle="modal" data-target="#secondModal">Pridaj novému športovci umiestnenie <i class="fas fa-medal"></i></button>
        </div>

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Vytvor Športovca</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post"  action="index.php">
                            <input type="number" name="id" id="id" value="" placeholder="24" min="24">
                            <br>
                            <input type="text" name="name" id="name" placeholder="Meno" value="">
                            <br>
                            <input type="text" name="surname" id="surname" placeholder="Priezvisko" value="">
                            <br>
                            <input type="text" name="birth_day" id="birth_day" placeholder="Dátum narod." value="">
                            <br>
                            <input type="text" name="birth_place" id="birth_place" placeholder="Mesto" value="">
                            <br>
                            <input type="text" name="birth_country" id="birth_country" placeholder="Krajina" value="">
                            <br>
                            <input type="submit" class="btn btn-success">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div id="secondModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Vytvor Umiestnenie</h4>
                    </div>
                    <div class="modal-body" id="modal-body2">
                        <form method="post" action="index.php">
                            <label for="person_id">id:</label>
                            <input type="number" name="person_id" id="person_id" value="" placeholder="24" min="24">
                            <br>
                            <label for="oh_id">Oh id:</label>
                            <input type="number" name="oh_id" id="oh_id" placeholder="23" min="1" max="35" value="" >
                            <br>
                            <label for="placing">Umiestnenie:</label>
                            <input type="number" name="placing" id="placing" placeholder="1 = uvidite v table :)"  min="1" max="50" value="">
                            <br>
                            <label for="discipline">Disciplína:</label>
                            <input type="text" name="discipline" id="discipline" placeholder="gaučing" value="">
                            <br>
                            <input type="submit" class="btn btn-success">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <div class="container">
        <br>
        <h2><i class="fas fa-trophy"></i> TOP 10 ŠPORTOVCOV <i class="fas fa-trophy"></i></h2>
        <table class="table table-light table-bordered border-dark  table-hover ">
            <thead>
                <tr>
                    <th>Počet Zlatých Medailí <i class='fas fa-medal'></i></th>
                    <th>Mená Olympionikov</th>
                    <th>Dátum narodenia <i class='fas fa-birthday-cake'></i></th>
                    <th>Mesto <i class='fas fa-city'></i></th>
                    <th>Krajina</th>
                    <th>Dátum úmrtia</th>
                    <th>Miesto úmrtia</th>
                    <th>Krajina</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($resultTopTen as $top){
                    echo $top->getTopWinners();
                }

            ?>
            </tbody>
        </table>

    </div>




</main>



</body>
</html>
