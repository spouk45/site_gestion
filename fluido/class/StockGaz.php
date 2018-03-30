<?php
class StockGaz {

    private $_id;
    private $_year;
    private $_gazId;
    private $_charge;
    private $_recup;

    public function __construct($data){
        if(isset($data['id'])){$this->setId($data['id']);}
            if(isset($data['year'])){$this->setYear($data['year']);}
            if(isset($data['gazId'])){$this->setGazId($data['gazId']);}
            if(isset($data['charge'])){$this->setCharge($data['charge']);}
            if(isset($data['recup'])){$this->setRecup($data['recup']);}
    }

    private function setId($value){
        if(!is_numeric($value)){throw new Exception('Le id doit etre numerique.');}
        $this->_id=$value;
    }
    private function setYear($value){
        if(!is_numeric($value)){throw new Exception('l\'ann�e doit etre num�rique.');}
        $this->_year=$value;
    }
    private function setGazId($value){
        if(!is_numeric($value)){throw new Exception('le gazId doit etre num�rique.');}
        $this->_gazId=$value;
    }
    private function setCharge($value){
        if(!is_numeric($value)){throw new Exception('la charge doit etre num�rique.');}
        $this->_charge=$value;
    }
    private function setRecup($value){
        if(!is_numeric($value)){throw new Exception('la recup doit etre num�rique.');}
        $this->_recup=$value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @return mixed
     */
    public function getGazId()
    {
        return $this->_gazId;
    }

    /**
     * @return mixed
     */
    public function getCharge()
    {
        return $this->_charge;
    }

    /**
     * @return mixed
     */
    public function getRecup()
    {
        return $this->_recup;
    }


}