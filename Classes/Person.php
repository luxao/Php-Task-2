<?php

class Person {
    public $id;
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getPlacing()
    {
        return $this->placing;
    }

    /**
     * @param mixed $placing
     */
    public function setPlacing($placing)
    {
        $this->placing = $placing;
    }




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
                  <td><a href='?edit=$this->id' class='btn btn-primary'>upraviť</a></td>
                 <td><a href='?delete=$this->id' class='btn btn-danger'>vymazať</a></td>
                  </tr>

        ";
    }

}