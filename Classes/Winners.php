<?php

class Winners {
    public $id;
    private $golds;
    private $name;
    private $surname;
    private $placing;
    private $year;
    private $city;
    private $type;
    private $discipline;
    private  $birth_day;
    private  $birth_place;
    private  $birth_country;
    private $death_day;
    private $death_place;
    private $death_country;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }



    /**
     * Winners constructor.
     *
     */

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    public function getRow(){
        return "<tr>
                <td style='display: none'>$this->id</td>
                <td><a href='?person=$this->id' class='btn btn-warning' style='text-decoration:none;'><i class='fas fa-user'></i> $this->name  $this->surname</a></td>
                <td>$this->placing</td>
                <td>$this->year</td>
                <td>$this->city <i class='fas fa-city'></i></td>
                <td>$this->type</td>
                <td>$this->discipline</td>
                <td><a href='EditPerson.php?edit=$this->id' class='btn btn-primary'><i class='fas fa-user-edit'></i></a></td>
                 <td>        
                    <form method='post' action='index.php?delete=$this->id'>
                        <button type='submit' name='deleting' class='btn btn-danger'><i class='fas fa-trash-alt'></i></button>
                    </form>                 
                </td>
                  </tr>
        ";
    }

    public function getTopWinners(){
        return "<tr>
                <td>$this->golds <i class='fas fa-medal'></i></td>
                <td style='background: gold'><i class='fas fa-trophy'></i> $this->name  $this->surname <i class='fas fa-trophy'></i></td>
                <td>$this->birth_day <i class='fas fa-birthday-cake'></i></td>
                <td>$this->birth_place <i class='fas fa-city'></i></td>             
                <td>$this->birth_country</td>
                <td>$this->death_day</td>
                <td>$this->death_place</td>
                <td>$this->death_country</td>
                
        </tr> ";
    }


    public function getPersonInfo(){
        return "
                <tr>
                <td style='display: none'>$this->id</td>
                <td>$this->name  $this->surname</td>
                <td>$this->placing</td>
                <td>$this->year</td>
                <td>$this->city</td>
                <td>$this->type</td>
                <td>$this->discipline</td>
                 

        ";
    }


}



