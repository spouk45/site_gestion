<?php
class Fournisseur{

    private $_id;
    private $_name;

    public function __construct(array $data){
        if(isset($data['id'])){$this->setId($data['id']);}
        if(isset($data['name'])){$this->setName($data['name']);}
    }

    private function setId($value){
        if(!is_numeric($value)){throw new Exception('id doit etre un nombre');}
        $this->_id=$value;
    }

    private function setName($value){
        $this->_name=$value;
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
    public function getName()
    {
        return $this->_name;
    }


}