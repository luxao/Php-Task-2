<?php

class Placement {
    private  $id;
    private  $person_id;
    private  $oh_id;
    private  $placing;
    private  $discipline;
    private  $city;

    /**
     * Placement constructor.
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
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * @param mixed $person_id
     */
    public function setPersonId($person_id)
    {
        $this->person_id = $person_id;
    }

    /**
     * @return mixed
     */
    public function getOhId()
    {
        return $this->oh_id;
    }

    /**
     * @param mixed $oh_id
     */
    public function setOhId($oh_id)
    {
        $this->oh_id = $oh_id;
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
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * @param mixed $discipline
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;
    }




}