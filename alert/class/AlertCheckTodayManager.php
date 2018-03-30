<?php
class AlertCheckTodayManager{
    private $_db;

    public function __construct(PDO $db){
        $this->_db=$db;
    }

    public function getDateLastCheck(){
        $sql='SELECT id,countAlert,dateLastCheck FROM alert_checktoday';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

        $data=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data['id']=$row['id'];
            $data['dateLastCheck']=$row['dateLastCheck'];
            $data['countAlert']=$row['countAlert'];
        }
        return $data;
    }

    public function updateDateLastCheck(AlertCheckToday $AlertCheckToday){
        $date=$AlertCheckToday->getDateLastCheck();
        $id=$AlertCheckToday->getId();
        $countAlert=$AlertCheckToday->getCountAlert();

        $sql='UPDATE alert_checktoday SET dateLastCheck=:date,countAlert=:countAlert WHERE id=:id ';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':date',$date);
        $stmnt->bindParam(':countAlert',$countAlert);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function addDateLastCheck(AlertCheckToday $AlertCheckToday){
        $countAlert=$AlertCheckToday->getCountAlert();
        $date=time();
        $sql='INSERT INTO alert_checktoday (countAlert,dateLastCheck) VALUES (:countAlert,:dateLastCheck)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':dateLastCheck',$date);
        $stmnt->bindParam(':countAlert',$countAlert);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        if($stmnt->rowCount() == 0)
        {
            throw new Exception('L\'enregistrement semble avoir échoué.');
        }

    }

    public function getCountAlert(){
        $sql='SELECT countAlert FROM alert_checktoday ';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $countAlert=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $countAlert=$row['countAlert'];
        }
        return $countAlert;
    }


}