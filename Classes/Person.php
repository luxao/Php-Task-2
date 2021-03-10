<?php

class Person {
    private $id;
    private  $name;
    private  $surname;
    private $placing;
    private $year;
    private $city;
    private $type;
    private $discipline;

    /**
     * Person constructor.
     *
     */
    public function __construct(){}

    public function getPerson(){
        return "
                <tr>
                <td>$this->id</td>
                <td>$this->name  $this->surname</td>
                <td>$this->placing</td>
                <td>$this->year</td>
                <td>$this->city</td>
                <td>$this->type</td>
                <td>$this->discipline</td>
           

        ";
    }

}