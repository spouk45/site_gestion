<?php
class AlertStatus{

    private $_id;
    private $_countDay;

    public function __construct($data){
        if(!isset($data['statusId']) && !isset($data['countDay'])){
            throw new Exception('il manque des donnée pour AlertStatus');
        }

        if(isset($data['statusId'])){
            $this->setId($data['statusId']);
        }
        if(isset($data['countDay'])){
            $this->setCountDay($data['countDay']);
        }


    }

    private function setId($id){
        if(!is_numeric($id)){
            throw new Exception('id doit etre un nombre');
        }
        $this->_id=$id;
    }

    private function setCountDay($value){
        if(!is_numeric($value)){
            throw new Exception('countDay doit etre int.');
        }
        $this->_countDay=$value;
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
    public function getCountDay()
    {
        return $this->_countDay;
    }


}