<?php
class Category
{
    private $_id;
    private $_name;
    private $_description;
    private $_frigo=false;

    public function __construct($data){
        if(isset($data['id'])){$this->setId($data['id']);}
        $this->setName(trim($data['name']));
        $this->setDescription(trim($data['description']));
        if(isset($data['frigo'])){
            $this->setFrigo($data['frigo']);
        }

    }

    private function setId($value){
        if($value==null){
            throw new Exception('<p>id manquant</p>');
        }
        $this->_id=$value;
    }

    private function setDescription($value){
        $this->_description=$value;
    }
    private function setName($value){
        if($value==null){
            throw new Exception('<p>Nom manquant</p>');
        }
        $this->_name=$value;
    }

    private function setFrigo($value){
        if($value==true){
            $this->_frigo=1;
        }
        else{
            $this->_frigo=0;
        }
    }

    public function getId(){
        return $this->_id;
    }
    public function getName(){
        return $this->_name;
    }
    public function getDescription(){
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getFrigo()
    {
        return $this->_frigo;
    }

}