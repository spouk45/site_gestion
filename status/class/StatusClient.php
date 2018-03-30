<?php
class StatusClient{
    private $_customerId;
    private $_statusId;
    private $_date;
    private $_id;

    public function __construct(array $data){
        if(!isset($data['customerId']) || !isset($data['statusId']) || !isset($data['date'])){
            throw new Exception('Il manque des données de status client.');
        }

        $this->setCustomerId($data['customerId']);
        if($data['statusId']!=null){
            $this->setStatusId($data['statusId']);
        }

        $this->setDate($data['date']);
        if(isset($data['id'])){
            $this->setId($data['id']);
        }
    }

    private function setCustomerId($id){
        if(!is_numeric($id)){
            throw new Exception('customerId doit etre un nombre.');
        }
        $this->_customerId=$id;
    }

    private function setStatusId($id){
        if(!is_numeric($id)){
            throw new Exception('statusId doit etre un nombre.');
        }
        $this->_statusId=$id;
    }
    private function setDate($date){
        if(is_numeric($date)){
            $this->_date=$date;
        }
        else {
            if (!preg_match('/^[0-9]{2}[\/\- ]{1}[0-9]{2}[\/\- ]{1}[0-9]{4}$/', $date)){
                throw new Exception('Erreur de date.');
            }
           $data=preg_split('/[\/ -]/',$date);
            list($d,$m,$y)=$data;
            if(!checkdate($m,$d,$y)){
                throw new Exception('Erreur de date');
            }
            $Date=new DateTime($y.'-'.$m.'-'.$d);
            $date=$Date->format('U');
            $this->_date=$date;
        }

    }

    private function setId($id){
        if(!is_numeric($id)){
            throw new Exception('id:'.$id.' doit etre numeric');
        }

        $this->_id=$id;
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
    public function getStatusId()
    {
        return $this->_statusId;
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
    public function getId()
    {
        return $this->_id;
    }


}