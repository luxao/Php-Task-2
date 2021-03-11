<?php

include "Classes/helper/Database.php";
include "Classes/Person.php";

$urlEdit = $_GET['edit'];

$person = new Person();
try {
    $db = new Database();
    $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname from osoby where osoby.id = '$urlEdit';");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
    $person = $stmt->fetch();



}
catch (PDOException $exception){
    echo "Error: " . $exception->getMessage();
}


if(isset($_POST['name'])){
    if(isset($_POST['id'])){
        $person_id = $_POST['id'];
        $conn = new Database();
        $conn->getConnection()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname from osoby where osoby.id = '$person_id ';");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
        $person = $stmt->fetch();


        $person->setId($_POST['id']);
        $person->setName($_POST['name']);
        $person->setSurname($_POST['surname']);
        $name = $person->getName();
        $surname = $person->getSurname();
        $id = $person->getId();

        $stmt = $conn->getConnection()->prepare("Update osoby set name='$name', surname='$surname' where id ='$id'");
        $stmt->execute();

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

</head>

<style>
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
    h1 {
        font-family: 'Amaranth', sans-serif;
        color: red;
        text-align: center;
        margin: .25em auto 0 auto;
        text-shadow: 2px 2px 2px #0D0D0D;
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

    .card {
        margin: 5em 5em 35em 5em;
        box-shadow: 5px 5px 5px #0D0D0D;
        border-radius: 25px;
    }
    .card-body {
        text-align: center;
    }

    input {
        margin: 1em 0 0 0 ;
        width: 12em;
        font-family: 'Amaranth', sans-serif;
        border: 2px solid blue;
    }
</style>

<body>

  <header>
      <h1>
          Editovanie Športovca
      </h1>
  </header>
<main>

    <div class="container">

        <div class="card" >
            <div class="card-body">
                <h2 class="card-title">Športovec</h2>
                <h5 class="card-subtitle mb-2 text-muted">Editni Športovca</h5>
                <a href='index.php' class="btn btn-warning">Späť pozrieť zmeny<i class='fas fa-undo'></i></a>
                <form method="post" action="EditPerson.php">

                    <input type="hidden" name="id" value="<?php  echo  $person->getId();?>">

                       <input type="text" name="name" id="name" placeholder="Meno" value="<?php  echo  $person->getName();?>" >
                       <br>

                     <input type="text"  name="surname" id="surname"  placeholder="Priezvisko" value="<?php  echo  $person->getSurname();?>">
                        <br>

                    <input type="submit" class="btn btn-success">
                </form>
            </div>
        </div>




    </div>
</main>


</body>

</html>





