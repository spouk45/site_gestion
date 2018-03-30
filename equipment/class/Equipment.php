<?php
class Equipment
{
    private $_id;
    private $_clientId;
    private $_productId;
    private $_serial;

    public function __construct(array $data){
        if(isset($data['id'])){$this->setId($data['id']);}
       if(isset($data['clientId'])){ $this->setClientId(trim($data['clientId']));}
        if(isset($data['productId'])){$this->setProductId(trim($data['productId']));}
       if(isset($data['serial'])){ $this->setSerial(trim($data['serial']));}
    }

    private function setId($value){
        if($value==null){
            throw new Exception('<p>id manquant</p>');
        }
        $this->_id=$value;
    }

    private function setClientId($value){
        if($value==null){
            throw new Exception('<p>Client Id manquant</p>');
        }
        $this->_clientId=$value;
    }
    private function setProductId($value){
        if($value==null){
            throw new Exception('<p>Product Id manquant</p>');
        }
        $this->_productId=$value;
    }
    private function setSerial($serial)
    {
        $this->_serial = $serial;
    }

    public function getId(){
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->_clientId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->_productId;
    }

    /**
     * @return mixed
     */
    public function getSerial()
    {
        return $this->_serial;
    }




}