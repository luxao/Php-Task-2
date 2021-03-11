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
    private  $birth_day;
    private  $birth_place;
    private  $birth_country;
    private $death_day;
    private $death_place;
    private $death_country;

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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }





}