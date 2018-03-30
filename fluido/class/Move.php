<?php
class Move {

    private  $_id;
    private  $_bottleId;
    private  $_serialFiche;
    private  $_dateOfMove;
    private  $_chargeOut;
    private  $_chargeIn;
    private  $_gazId;
    private  $_customerId;
    private  $_techId;
    private  $_equipmentId;

    public function __construct(array $data){
        if($data==null){throw new Exception('data est vide');}
        if(isset($data['id'])){$this->setId($data['id']);}
        if(!isset($data['bottleId'])){throw new Exception('Il faut un bottleId.');}
            else{$this->setBottleId($data['bottleId']);}
        if(isset($data['serialFiche'])){$this->setSerialFiche($data['serialFiche']);}
        if(!isset($data['dateOfMove'])){throw new Exception('Il faut une date.');}
        else{$this->setDateOfMove($data['dateOfMove']);}
        if(isset($data['chargeOut'])){$this->setChargeOut($data['chargeOut']);}
        if(isset($data['chargeIn'])){$this->setChargeIn($data['chargeIn']);}
        if(!isset($data['gazId'])){throw new Exception('Il faut un gaz.');}
        else{$this->setGazId($data['gazId']);}
        if(isset($data['customerId'])){$this->setCustomerId($data['customerId']);}
        if(!isset($data['techId'])){throw new Exception('Il faut un technicien.');}
        else{$this->setTechId($data['techId']);}
        if(isset($data['equipmentId'])){$this->setEquipmentId($data['equipmentId']);}



    }

    private function setId($id)
    {
        if(!is_numeric($id)){
            throw new Exception('id doit etre numeric');
        }
        $this->_id=$id;
    }

    private function setBottleId($value){
        if(!is_numeric($value)){
            throw new Exception('bottleId doit être numeric');
        }
        $this->_bottleId=$value;
    }

    private function setSerialFiche($value){
        if($value==null){
            throw new Exception('serialFiche ne peut etre null');
        }
        $this->_serialFiche=$value;
    }

    private function setDateOfMove($date){

        // mise au format 'xx/xx/xxxx'
        if(!preg_match('/^[0-9]{2}[- \/]{1}[0-9]{2}[- \/]{1}[0-9]{4}$/',$date)){
            throw new Exception('Erreur de format de date');
        }
        $pattern=array('-',' ');
        $date=str_replace($pattern,'/',$date);
        list($dd,$mm,$yyyy) = explode('/',$date);
        if (!checkdate($mm,$dd,$yyyy)) {
            throw new Exception('Erreur de date');
        }

        $Date=DateTime::createFromFormat('d/m/Y',$date);
        $date=$Date->format('U');
        if(!$date){
            throw new Exception('Erreur de format de date');
        }

        if(!is_numeric($date)){
            throw new Exception('date doit être numeric');
        }
        $this->_dateOfMove=$date;
    }

    private function setChargeOut($value){
        if(!is_numeric($value)){
            throw new Exception('la charge doit être numeric');
        }
        $this->_chargeOut=$value;
    }
    private function setChargeIn($value){
        if(!is_numeric($value)){
            throw new Exception('la charge doit être numeric');
        }
        $this->_chargeIn=$value;
    }
    private function setGazId($value){
        if(!is_numeric($value)){
            throw new Exception('le gaz doit être numeric');
        }
        $this->_gazId=$value;
    }
    private function setCustomerId($value){
        if(!is_numeric($value)){
            throw new Exception('le client doit être numeric');
        }
        $this->_customerId=$value;
    }
    private function setTechId($value){
        if(!is_numeric($value)){
            throw new Exception('le technicien doit être numeric');
        }
        $this->_techId=$value;
    }
    private function setEquipmentId($value){
        if(!is_numeric($value)){
            throw new Exception('equipment doit être numeric');
        }
        $this->_equipmentId=$value;
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
    public function getBottleId()
    {
        return $this->_bottleId;
    }

    /**
     * @return mixed
     */
    public function getSerialFiche()
    {
        return $this->_serialFiche;
    }

    /**
     * @return mixed
     */
    public function getDateOfMove()
    {
        return $this->_dateOfMove;
    }

    /**
     * @return mixed
     */
    public function getChargeOut()
    {
        return $this->_chargeOut;
    }

    /**
     * @return mixed
     */
    public function getChargeIn()
    {
        return $this->_chargeIn;
    }

    /**
     * @return mixed
     */
    public function getGazId()
    {
        return $this->_gazId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->_customerId;
    }

    /**
     * @return mixed
     */
    public function getTechId()
    {
        return $this->_techId;
    }

    /**
     * @return mixed
     */
    public function getEquipmentId()
    {
        return $this->_equipmentId;
    }


}