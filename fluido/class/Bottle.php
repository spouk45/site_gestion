<?php

class Bottle{

    private $_id;
    private $_serial;
    private $_dateOfBuy;
    private $_dateOfSell;
    private $_charge;
    private $_gazId;
    private $_typeId;
    private $_fournisseurId;



    /**
     * Bottle constructor.
     * @param mixed array $_data("id","serial","dateOfBuy","dateOfSell","charge","gazId","typeId","fournisseurId")
     */
    public function __construct(array $data)
    {
        if($data==null){throw new Exception('data est vide');}

        if(isset($data['id'])){$this->setId($data['id']);}
        $this->setSerial(trim($data['serial']));
        $this->setdateOfBuy($data['dateOfBuy']);
        if(!empty($data['dateOfSell'])){$this->setdateOfSell($data['dateOfSell']);}
        if(!empty($data['charge'])){$this->setcharge(trim($data['charge']));}
        if(!empty($data['gazId'])){$this->setgazId($data['gazId']);}
        $this->settypeId($data['typeId']);
        $this->setfournisseurId($data['fournisseurId']);
        $this->selfControl();
    }


    /**
     * @param mixed $id
     */
    private function setId($id)
    {
        if($id==null){
            throw new Exception('id manquant');
        }
        $this->_id=$id;
    }

    /**
     * @param mixed $serial
     */
    private function setSerial($serial)
    {
        if($serial==null){ throw new Exception('numéro de bouteille manquante'); }
        if(!is_numeric($serial)){ throw new Exception('le numéro de bouteille doit être numéric'); }
        $this->_serial = $serial;
    }

    /**
     * @param mixed $dateOfBuy
     */
    private function setDateOfBuy($dateOfBuy)
    {

            // mise au format 'xx/xx/xxxx'
            if(!preg_match('/^[0-9]{2}[- \/]{1}[0-9]{2}[- \/]{1}[0-9]{4}$/',$dateOfBuy)){
                throw new Exception('Erreur de format de date');
            }
            $pattern=array('-',' ');
            $dateOfBuy=str_replace($pattern,'/',$dateOfBuy);
            list($dd,$mm,$yyyy) = explode('/',$dateOfBuy);
            if (!checkdate($mm,$dd,$yyyy)) {
                throw new Exception('Erreur de date');
            }

            $Date=DateTime::createFromFormat('d/m/Y',$dateOfBuy);
            $date=$Date->format('U');
            if(!$date){
                throw new Exception('Erreur de format de date');
            }

        $this->_dateOfBuy = $date;
    }

    /**
     * @param mixed $dateOfSell
     */
    private function setDateOfSell($dateOfSell)
    {
        // mise au format 'xx/xx/xxxx'
        if(!preg_match('/^[0-9]{2}[- \/]{1}[0-9]{2}[- \/]{1}[0-9]{4}$/',$dateOfSell)){
            throw new Exception('Erreur de format de date');
        }
        $pattern=array('-',' ');
        $dateOfSell=str_replace($pattern,'/',$dateOfSell);
        list($dd,$mm,$yyyy) = explode('/',$dateOfSell);
        if (!checkdate($mm,$dd,$yyyy)) {
            throw new Exception('Erreur de date');
        }

        $Date=DateTime::createFromFormat('j/m/Y',$dateOfSell);
        $date=$Date->format('U');
        if(!$date){
            throw new Exception('Erreur de format de date');
        }

        $this->_dateOfSell = $date;
    }

    /**
     * @param mixed $gazId
     */
    private function setGazId($gazId)
    {
        if(!is_numeric($gazId)){ throw new Exception('id gaz doit etre numérique'); }
        $this->_gazId = $gazId;
    }

    /**
     * @param mixed $typeId
     */
    private function setTypeId($typeId)
    {
        if(!is_numeric($typeId)){ throw new Exception('id type doit etre numérique'); }
        $this->_typeId = $typeId;
    }

    /**
     * @param mixed $fournisseurId
     */
    private function setFournisseurId($fournisseurId)
    {
        if(!is_numeric($fournisseurId)){ throw new Exception('id fournisseur doit etre numérique'); }
        $this->_fournisseurId = $fournisseurId;
    }

    /**
     * @param mixed $charge
     */
    private function setCharge($charge)
    {
        if(!is_numeric($charge)){ throw new Exception('la charge doit etre une valeur numérique'); }
        $this->_charge = $charge;
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
    public function getSerial()
    {
        return $this->_serial;
    }

    /**
     * @return mixed
     */
    public function getDateOfBuy()
    {
        return $this->_dateOfBuy;
    }

    /**
     * @return mixed
     */
    public function getDateOfSell()
    {
        return $this->_dateOfSell;
    }

    /**
     * @return mixed
     */
    public function getCharge()
    {
        return $this->_charge;
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
    public function getTypeId()
    {
        return $this->_typeId;
    }

    /**
     * @return mixed
     */
    public function getFournisseurId()
    {
        return $this->_fournisseurId;
    }

    private function selfControl(){
        $typeId=$this->_typeId;

            switch ($typeId){
                case 1: // charge
                    if($this->_charge == null){throw new Exception('une charge doit etre indiqué pour une bouteille neuve.');}
                    if($this->_gazId == null){throw new Exception('un gaz doit etre indiqué pour une bouteille neuve.');}
                    break;

                case 2: // recup
                case 3: //transfert
                    $this->_gazId=null;
                    $this->_charge=null;

                break;
            }

    }


}