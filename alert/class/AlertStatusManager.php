<?php
class AlertStatusManager{

    private $_db;

    public function __construct(PDO $db){
        $this->_db=$db;
    }

    public function updateAlertStatus(AlertStatus $AlertStatus){
        $id=$AlertStatus->getId();
        $countDay=$AlertStatus->getCountDay();

        $sql='UPDATE status SET timeAlert=:countDay WHERE id=:id ';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':countDay',$countDay);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function getTimeAlert($id){
        $sql='SELECT timeAlert FROM status WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

        $data=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data['timeAlert']=$row['timeAlert'];
        }
        return $data;
    }

    public function getAlertList(){
        $sql='SELECT status.id AS statusId,status.timeAlert AS timeAlert,status_client.date AS dateClient,status_client.customerId AS customerId
              FROM status
              INNER JOIN status_client ON status_client.statusId=status.id
              WHERE timeAlert IS NOT NULL';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

        $data=null;
        $i=0;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data[$i]['statusId']=$row['statusId'];
            $data[$i]['timeAlert']=$row['timeAlert'];
            $data[$i]['dateClient']=$row['dateClient'];
            $data[$i]['customerId']=$row['customerId'];
            $i++;
        }
        return $data;
    }

    public function getListClientAlert($clientId){
        $sql='SELECT customer.id AS clientId,customer.name AS clientName,status.name AS statusName,customer.serial AS clientSerial,status_client.date AS clientDateStatus
        FROM customer
        INNER JOIN status_client ON status_client.customerId=customer.id
        INNER JOIN status ON status.id=status_client.statusId
        WHERE customer.id=:clientId';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':clientId',$clientId);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

        $data=null;

        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data['id']=$row['clientId'];
            $data['clientName']=$row['clientName'];
            $data['statusName']=$row['statusName'];
            $data['clientSerial']=$row['clientSerial'];
            $data['clientDateStatus']=$row['clientDateStatus'];
        }
        return $data;

    }
}