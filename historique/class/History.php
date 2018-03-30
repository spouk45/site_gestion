<?php
class History{

    private $_text; //(array)
    private $_date; //(int)
    private $_equipmentId=array(); // string
    private $_id;


    public function __construct($data){
        if(isset($data['text'])){$this->setText($data['text']);}
        if(isset($data['date'])){$this->setDate($data['date']);}
        if(isset($data['equipmentId'])){$this->setEquipmentId($data['equipmentId']);}
        if(isset($data['id'])){$this->setId($data['id']);}

    }

    private function setText($text){
        if(empty($text)){
            throw new Exception('text est vide');
        }
        $this->_text=htmlspecialchars($text);
    }
    private function setDate($date){
        if(!is_numeric($date)){
            throw new Exception('Date doit etre INT');
        }
        $this->_date=$date;
    }
    private function setEquipmentId($data){
        if(!is_array($data)){
            throw new Exception('selected doit etre ARRAY');
        }

        $this->_equipmentId=$data;
    }

    private function setId($id){
        if(!is_numeric($id)){
            throw new Exception('id doit etre INT');
        }
        $this->_id=$id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @return mixed
     */
    public function getEquipmentId()
    {
        return $this->_equipmentId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }


}