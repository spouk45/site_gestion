<?php
class Sub
{
    private $_id;
    private $_contact;
    private $_name;
    private $_postal;
    private $_city;
    private $_road;
    private $_phone;
    private $_mail;
    private $_com;

    public function __construct($data){
        if(isset($data['id'])){$this->setId($data['id']);}
        $this->setContact(trim($data['contact']));
        $this->setName(trim($data['name']));
        $this->setPostal(trim($data['postal']));
        $this->setCity(trim($data['city']));
        $this->setRoad(trim($data['road']));
        $this->setPhone(trim($data['tel']));
        $this->setMail(trim($data['mail']));
        $this->setCom(trim($data['com']));
    }

    private function setId($value){
        if($value==null){
            throw new Exception('<p>id manquant</p>');
        }
        $this->_id=$value;
    }

    private function setContact($value){
        $this->_contact=$value;
    }
    private function setName($value){
        if($value==null){
            throw new Exception('<p>Nom manquant</p>');
        }
        $this->_name=$value;
    }

    private function setPostal($value){
        if(!preg_match('/^[0-9]{5,5}$/',$value)){
            throw new Exception('<p>code postal invalide</p>');
        }
        $this->_postal=$value;
    }
    private function setCity($value){
        if($value==null){
            throw new Exception('<p>Ville manquante</p>');
        }
        $this->_city=$value;
    }
    private function setRoad($value){
        if($value==null){
            throw new Exception('<p>rue manquante</p>');
        }
        $this->_road=$value;
    }

    private function setPhone($value){
        if(!preg_match('/^[0-9]{0,10}$/',$value)){
            throw new Exception('<p>Numéro de téléphone invalide</p>');
        }
        $this->_phone=$value;
    }

    private function setMail($value){
        if($value!=null){
            if(!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/',$value)){
                throw new Exception('<p>Adresse e-mail invalide</p>');
            }
        }
        $this->_mail=$value;
    }
    private function setCom($value){
        $this->_com=htmlentities(addslashes($value));
    }

    public function getId(){
        return $this->_id;
    }

    public function getContact(){
        return $this->_contact;
    }
    public function getName(){
        return $this->_name;
    }


    public function getPhone(){
        return $this->_phone;
    }

    public function getMail(){
        return $this->_mail;
    }
    public function getCom(){
        return $this->_com;
    }

    /**
     * @return mixed
     */
    public function getPostal()
    {
        return $this->_postal;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @return mixed
     */
    public function getRoad()
    {
        return $this->_road;
    }

}