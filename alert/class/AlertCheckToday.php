<?php
class AlertCheckToday{

    private $_id;
    private $_dateLastCheck;
    private $_countAlert;

    public function __construct($data){
        if(isset($data['id'])){$this->setId($data['id']);}
        if(!empty($data['dateLastCheck'])) {
            $this->setDateLastCheck($data['dateLastCheck']);
        }
        if(isset($data['countAlert'])){$this->setCountAlert($data['countAlert']);}
    }

    private function setId($id){
        if(!is_numeric($id)){throw new Exception('id doit etre un nombre');}
        $this->_id=$id;
    }

    private function setDateLastCheck($temp){ //timestamp
        if(!is_numeric($temp)){throw new Exception('temp doit etre un timestamp');}
        $this->_dateLastCheck=$temp;
    }

    private function setCountAlert($count){
        if(!is_numeric($count)){throw new Exception('countAlert doit etre un nombre');}
        $this->_countAlert=$count;
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
    public function getDateLastCheck()
    {
        return $this->_dateLastCheck;
    }

    /**
     * @return mixed
     */
    public function getCountAlert()
    {
        return $this->_countAlert;
    }


}