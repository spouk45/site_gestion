<?php
class Mark
{
    private $_id;
    private $_name;


    public function __construct($data){
        if(isset($data['id'])){$this->setId($data['id']);}
        if(isset($data['name'])){$this->setName(trim($data['name']));}

        if(!isset($data['id']) && !isset($data['name'])){
            throw new Exception('Données manquantes');
        }
    }

    private function setId($value){
        if($value==null){
            throw new Exception('id manquant');
        }
        $this->_id=$value;
    }

    private function setName($value){
        if($value==null){
            throw new Exception('Nom manquant');
        }
        $this->_name=ucfirst($value);
    }

    public function getId(){
        return $this->_id;
    }
    public function getName(){
        return $this->_name;
    }

}