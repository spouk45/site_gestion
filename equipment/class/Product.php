<?php
class Product
{
    private $_id;
    private $_name;
    private $_mark;
    private $_categoryId;
    private $_description;

    public function __construct($data){
        if(isset($data['id'])){$this->setId($data['id']);}
        $this->setName(trim($data['name']));
        $this->setDescription(trim($data['description']));
        $this->setMark(trim($data['mark']));
        $this->setCategoryId(trim($data['category_id']));
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

    private function setMark($value){
        $this->_mark=$value;
    }
    private function setCategoryId($value){
        $this->_categoryId=$value;
    }

    public function getId(){
        return $this->_id;
    }
    public function getName(){
        return $this->_name;
    }
    public function getMark(){
        return $this->_mark;
    }
    public function getCategoryId(){
        return $this->_categoryId;
    }
    public function getDescription(){
        return $this->_description;
    }
}