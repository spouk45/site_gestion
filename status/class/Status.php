<?php

class Status{
    private $_name;
    private $_id;

    public function __construct(array $data){
        if(isset($data['name'])){
            $this->setName($data['name']);
        }
       if(isset($data['id'])){
           $this->setId($data['id']);
       }

    }

    private function setName($name){
        if($name==null || $name==' '){
            throw new Exception('name ne peut être vite');
        }
        $this->_name=$name;
    }

    private function setId($id){
        if(!is_numeric($id)){
            throw new Exception('id doit etre un nombre');
        }
        $this->_id=$id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }


}