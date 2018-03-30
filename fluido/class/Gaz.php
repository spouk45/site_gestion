<?php
class Gaz {
    private $_id;
    private $_name;

    public function __construct(array $data)
    {
        if($data==null){throw new Exception('data est vide');}
        if(isset($data['id'])){$this->setId($data['id']);}
        if(isset($data['name'])){$this->setName(trim($data['name']));}

    }

    private function setId($id)
    {
        if($id==null){
            throw new Exception('<p>id manquant</p>');
        }
        $this->_id=$id;
    }

    private function setName($name)
    {
        if($name==null){ throw new Exception('<p>Nom de gaz manquant</p>'); }
        $this->_name = $name;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }



}