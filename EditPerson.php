<?php

include "Classes/helper/Database.php";
include "Classes/Person.php";

$urlEdit = $_GET['edit'];

$person = new Person();
try {
    $db = new Database();
    $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,osoby.birth_day,osoby.birth_place,osoby.birth_country
       from osoby where osoby.id = '$urlEdit';");
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
        $stmt = $conn->getConnection()->prepare("select osoby.id,osoby.name,osoby.surname,osoby.birth_day,osoby.birth_place,osoby.birth_country
       from osoby where osoby.id = '$person_id ';");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
        $person = $stmt->fetch();


        $person->setId($_POST['id']);
        $person->setName($_POST['name']);
        $person->setSurname($_POST['surname']);
        $person->setBirthDay($_POST['birth_day']);
        $person->setBirthPlace($_POST['birth_place']);
        $person->setBirthCountry($_POST['birth_country']);

        $name = $person->getName();
        $surname = $person->getSurname();
        $birth_day = $person->getBirthDay();
        $birth_place = $person->getBirthPlace();
        $birth_country = $person->getBirthCountry();

        $id = $person->getId();

        $stmt = $conn->getConnection()->prepare("Update osoby set name='$name', surname='$surname',birth_day='$birth_day',
                 birth_place='$birth_place',birth_country='$birth_country'
        where id ='$id'");
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

<style>
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
          Editovanie ??portovca
      </h1>
  </header>
<main>

    <div class="container">

        <div class="card" >
            <div class="card-body">
                <h2 class="card-title">??portovec</h2>
                <h5 class="card-subtitle mb-2 text-muted">Editni ??portovca</h5>
                <a href='index.php' class="btn btn-warning">Sp???? <i class='fas fa-undo'></i></a>
                <form method="post" action="EditPerson.php">

                    <input type="hidden" name="id" value="<?php  echo  $person->getId();?>">

                       <input type="text" name="name" id="name" placeholder="Meno" value="<?php  echo  $person->getName();?>" >
                       <br>

                     <input type="text"  name="surname" id="surname"  placeholder="Priezvisko" value="<?php  echo  $person->getSurname();?>">
                        <br>

                    <input type="text" name="birth_day" id="birth_day" placeholder="D??tum Narodenia" value="<?php echo $person->getBirthDay() ?>">
                    <br>

                    <input type="text" name="birth_place" id="birth_place" placeholder="Mesto Narodenia" value="<?php  echo $person->getBirthPlace() ?>">
                    <br>

                    <input type="text" name="birth_country" id="birth_country" placeholder="Krajina Narodenia" value="<?php echo $person->getBirthCountry()?>">
                    <br>


                    <input type="submit" class="btn btn-success">
                </form>
            </div>
        </div>




    </div>
</main>

</body>

</html>





