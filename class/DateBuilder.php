<?php

class DateBuilder {

    private $_date;
    private $_time;
    private $_separator;



    public function __construct($date){
        $this->setDate($date);
        $this->setSeparator();
        $this->setDateSeparator();
        $this->checkDate();
        $this->setTime();
    }

    private function setDate($date){
        if(empty($date)){
         throw new Exception('La date est vide');
        }
        if(!preg_match('/^[0-9]{2}[- \/]{1}[0-9]{2}[- \/]{1}[0-9]{4}$/',$date)){
            throw new Exception('Erreur de format de date');
        }

        $this->_date=$date;

    }

    private function setSeparator(){
        $s='/';
        $this->_separator=$s;
    }

    private function setDateSeparator(){
        $separator=$this->_separator;
        $date=$this->_date;
        $pattern=array('-',' ');
        $date=str_replace($pattern,$separator,$date);
        $this->_date=$date;
    }

    private function checkDate(){

        list($dd,$mm,$yyyy) = explode('/',$this->_date);
        if (!checkdate($mm,$dd,$yyyy)) {
            throw new Exception('Erreur de date');
        }
    }
    private function setTime(){
        $date=$this->_date;
        $Date=DateTime::createFromFormat('j/m/Y',$date);
        $date=$Date->format('U');
        if(!$date){
            throw new Exception('Erreur de format de date');
        }
        $this->_time=$date;
    }

    public function getTime(){
        return $this->_time;
    }
}