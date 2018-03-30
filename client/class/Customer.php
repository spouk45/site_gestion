<?php
class Customer
{
    private $_id;
    private $_status;
    private $_civility;
    private $_serial;
    private $_subId;
    private $_contact;
    private $_name;
    private $_firstName;
    private $_postal;
    private $_city;
    private $_road;
    private $_adress;
    private $_phone;
    private $_phonePort;
    private $_mail;
    private $_com;

    public function __construct(array $data){
        if(isset($data['id'])){$this->setId($data['id']);}
        $this->setStatus($data['status']);
        $this->setCivility($data['civility']);
        $this->setSerial(trim($data['serial']));
        $this->setSubId($data['sub_id']);
        $this->setContact(trim($data['contact']));
        $this->setName(trim($data['name']));
        $this->setFirstName(trim($data['firstName']));
        $this->setPostal(trim($data['postal']));
        $this->setCity(trim($data['city']));
        $this->setRoad(trim($data['road']));
        $this->setPhone(trim($data['tel']));
        $this->setPhonePort(trim($data['port']));
        $this->setMail(trim($data['mail']));
        $this->setCom(trim($data['com']));
    }
    private function setStatus($value){
        if($value==null){
            throw new Exception('<p>Client ou prospect?</p>');
        }
        $this->_status=$value;
    }
    private function setId($value){
        if($value==null){
            throw new Exception('<p>id manquant</p>');
        }
        $this->_id=$value;
    }

    private function setCivility($value){
        if($value==null){
            throw new Exception('<p>Civilité?</p>');
        }
        $this->_civility=$value;
    }
    private function setSerial($value){
        if($value==null){
            throw new Exception('<p>Numéro client manquant</p>');
        }
        $this->_serial=$value;
    }
    private function setSubId($value){
        $this->_subId=$value;
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
    private function setFirstName($value){
        $this->_firstName=$value;
    }

    private function setPhone($value){
        if(!preg_match('/^[0-9]{0,10}$/',$value)){
            throw new Exception('<p>Numéro de téléphone invalide</p>');
        }
        $this->_phone=$value;
    }
    private function setPhonePort($value){
        if(!preg_match('/^[0-9]{0,10}$/',$value)){
            throw new Exception('<p>Numéro de téléphone portable invalide</p>');
        }
        $this->_phonePort=$value;
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
       // $this->_com=htmlentities(addslashes(nl2br($value)));
        $this->_com=htmlentities(addslashes($value));
    }
    private function setPostal($value){
        if(!preg_match('/^[0-9]{5,5}$/',$value)){
            throw new Exception('<p>Code postal non valide</p>');
        }
        $this->_postal=$value;
    }
    private function setCity($value){
        $this->_city=htmlentities(addslashes($value));
    }
    private function setRoad($value){
        // $this->_road=htmlentities(addslashes(nl2br($value)));
        $this->_road=htmlentities(addslashes($value));
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

    public function getId(){
        return $this->_id;
    }

    public function getStatus(){
        return $this->_status;
    }

    public function getCivility(){
        return $this->_civility;
    }
    public function getSerial(){
        return $this->_serial;
    }
    public function getSubId(){
        return $this->_subId;
    }
    public function getContact(){
        return $this->_contact;
    }
    public function getName(){
        return $this->_name;
    }
    public function getFirstName(){
        return $this->_firstName;
    }
    public function getAdress(){
        return $this->_adress;
    }
    public function getPhone(){
        return $this->_phone;
    }
    public function getPhonePort(){
        return $this->_phonePort;
    }
    public function getMail(){
        return $this->_mail;
    }
    public function getCom(){
        return $this->_com;
    }
}