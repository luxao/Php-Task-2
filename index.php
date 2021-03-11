<?php
include "Classes/Game.php";
include "Classes/Winners.php";
include "Classes/helper/Database.php";
include "Classes/Person.php";


$sortNameAsc = "nameAsc";
$sortNameDesc = "nameDesc";
$sortYearAsc = "yearAsc";
$sortYearDesc = "yearDesc";
$sortTypeAsc = "typeAsc";
$sortTypeDesc = "typeDesc";
$urlSort = $_GET['sorting'];
$urlPerson = $_GET['person'];
$urlEdit = $_GET['edit'];



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

</head>
<style>
    table {
        margin-top: .25em;
       box-shadow: 5px 5px 5px #0D0D0D;
    }
    th {
        text-align: center;
    }
    body {
        background-image: -webkit-gradient(
                linear,
                left top,
                left bottom,
                color-stop(0.35, #ECFC08),
                color-stop(1, #E02626)
        );
        background-repeat: no-repeat;
        background-image: -o-linear-gradient(bottom, #ECFC08 35%, #E02626 100%);
        background-image: -moz-linear-gradient(bottom, #ECFC08 35%, #E02626 100%);
        background-image: -webkit-linear-gradient(bottom, #ECFC08 35%, #E02626 100%);
        background-image: -ms-linear-gradient(bottom, #ECFC08 35%, #E02626 100%);
        background-image: linear-gradient(to bottom, #ECFC08 35%, #E02626 100%);
        font-family: 'Amaranth', sans-serif;
    }
    #second {
        font-family: 'Amaranth', sans-serif;
    }

    h1 {
        font-family: 'Amaranth', sans-serif;
        color: red;
        text-align: center;
        margin: .25em auto 0 auto;
        text-shadow: 2px 2px 2px #0D0D0D;
    }
    h2 {
        font-family: 'Amaranth', sans-serif;
        color: gold;
        text-align: center;
        margin: 0 auto;
        text-shadow: 2px 2px 2px #0D0D0D;
    }

    table:hover {
        cursor: pointer;
    }

    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #0D0D0D;
        border-radius: 10px;
    }



</style>

<body>

<header>
    <nav class="navbar">
        <h1>
            Olympijský víťazi
        </h1>
    </nav>
</header>

<main>
    <div class='container'>
        <table class='table table-dark table-hover table-bordered border-light  table-hover'>
            <thead>
            <tr>
                <th>id</th>
                <th>Olympijský víťaz <a href='?sorting=<?php echo $sortNameAsc?>'><i class='fas fa-sort-alpha-down'></i></a>
                    <a href='?sorting=<?php echo $sortNameDesc?>'><i class='fas fa-sort-alpha-down-alt'></i></a>
                </th>
                <th>
                    Umiestnenie
                </th>
                <th>Rok <a href='?sorting=<?php echo $sortYearAsc?>'> <i class='fas fa-sort-numeric-down'></i></a>
                    <a href='?sorting=<?php echo $sortYearDesc?>'><i class='fas fa-sort-numeric-down-alt'></i></a>
                </th>
                <th>Miesto</th>
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
            if(!$_GET['person']) {

                    if ($urlSort == "nameAsc") {
                        foreach ($resultASC as $winners) {
                            echo $winners->getRow();

                        }
                    }
                    if ($urlSort == "nameDesc") {
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
                    } else {
                        foreach ($result as $winners) {
                            echo $winners->getRow();

                        }
                    }
            }
            ?>

            </tbody>
        </table>

    </div>
    <div  id="second">

    <div class="container">
        <br>
        <h2>TOP 10 ŠPORTOVCOV</h2>
        <table class="table table-light table-bordered border-dark  table-hover ">
            <thead>
                <tr>
                    <th>Počet Zlatých Medailí</th>
                    <th>Mená Olympionikov</th>
                    <th>Dátum narodenia</th>
                    <th>Miesto</th>
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

    </div>


</main>


</body>
</html>
