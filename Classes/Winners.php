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
     * Winners constructor.
     *
     */
    public function __construct(){}

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getRow(){
        return "<tr>
                <td>$this->id</td>
                <td><a href='?person=$this->id'>$this->name  $this->surname</a></td>
                <td>$this->placing</td>
                <td>$this->year</td>
                <td>$this->city</td>
                <td>$this->type</td>
                <td>$this->discipline</td>
        ";
    }

    public function getTopWinners(){
        return "<tr>
                <td>$this->golds</td>
                <td>$this->name  $this->surname</td>
                <td>$this->birth_day</td>
                <td>$this->birth_place</td>             
                <td>$this->birth_country</td>
                <td>$this->death_day</td>
                <td>$this->death_place</td>
                <td>$this->death_country</td>
                
        </tr> ";
    }


}



