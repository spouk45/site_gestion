<?php

class StatusManager{
    private $_db;

    public function __construct(PDO $db){
        $this->_db=$db;
    }

    public function addStatus(Status $Status){
        $name=$Status->getName();

        // anti-doublon
        $nb=$this->countStatus($name);
        if($nb>0){
            throw new Exception('Status déjà existant');
        }


        $sql='INSERT INTO status (name) VALUES (:name)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':name',$name);
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

    public function updateStatus(Status $Status){
        $name=$Status->getName();
        $id=$Status->getId();
        $sql='UPDATE status SET name=:name WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':name',$name);
        $stmnt->execute();
        $error=$stmnt->errorInfo();

        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function deleteStatus(Status $Status){
        $id=$Status->getId();

        $sql='DELETE FROM status WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function getStatus(){
        $sql='SELECT id,name FROM status';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;
        $i=0;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data[$i]['id']=$row['id'];
            $data[$i]['name']=$row['name'];
            $i++;
        }
        return $data;
    }

    public function countStatus($name){
        $sql='SELECT COUNT(id) FROM status WHERE name=:name';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':name',$name);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;

        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data=$row['COUNT(id)'];
        }
        return $data;
    }

    public function addStatusClient(StatusClient $Stat){
        $CustomerId=$Stat->getCustomerId();
        $statusId=$Stat->getStatusId();
        $date=$Stat->getDate();

        $sql='INSERT INTO status_client(customerId, statusId, date) VALUES (:customerId,:statusId,:date)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':customerId',$CustomerId);
        $stmnt->bindParam(':statusId',$statusId);
        $stmnt->bindParam(':date',$date);
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

    public function updateStatusClient(StatusClient $Stat){
        $customerId=$Stat->getCustomerId();
        $statusId=$Stat->getStatusId();
        $date=$Stat->getDate();
        $id=$Stat->getId();

        $sql='UPDATE status_client SET customerId=:customerId,statusId=:statusId,date=:date WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':customerId',$customerId);
        $stmnt->bindParam(':statusId',$statusId);
        $stmnt->bindParam(':date',$date);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

       ?><script>
            $(document).ready(function(){
                $.post('<?php echo URL_ROOT.'alert/proc/check_alert.php';?>',{'force':1});
            });
        </script><?php

    }



    public function deleteStatusClient(StatusClient $Stat){
        $id=$Stat->getId();

        $sql='DELETE FROM status WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }




}