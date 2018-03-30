<?php
class CustomerManager{

    private $_db;

    /*const ERROR_LOG='Login ou mot de passe incorrect';
    const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';*/

    public function __construct(PDO $db)
    {
        $this->_db=$db;
    }

    public function getCustomer($seek){// rechercher par nom ou numéro de client

        $seek2='%'.$seek.'%';
        if($seek=='*'){$seek2='%';}
        $sql='SELECT id,name,serial FROM customer WHERE name LIKE :seek OR serial LIKE :seek';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':seek',$seek2);
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
            $data[$i]['serial']=$row['serial'];

            $i++;
        }
        //var_dump($data);
        return $data;
    }
/*
    public function getCustomerByID($id){

        $sql='SELECT id,civilityId,name,firstName,postal,city,road,tel,port,mail,status,cl_number,contact,sub_id,com FROM customer WHERE id=:id';
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
            $data['id']=$row['id'];
            $data['civility_id']=$row['civility_id'];
            $data['name']=$row['name'];
            $data['firstName']=$row['firstName'];
            $data['adress']=$row['adress'];
            $data['tel']=$row['tel'];
            $data['port']=$row['port'];
            $data['mail']=$row['mail'];
            $data['status']=$row['status'];
            $data['cl_number']=$row['cl_number'];
            $data['contact']=$row['contact'];
            $data['sub_id']=$row['sub_id'];
            $data['com']=$row['com'];
        }
        //var_dump($data);
        if($data==null){
            throw new Exception('Id introuvable.');
        }
        return $data;
    }
*/
    public function getCivList(){
        $sql='SELECT id,tag,business FROM civility';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;
        $i=0;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC))
        {
            $data[$i]['id']=$row['id'];
            $data[$i]['tag']=$row['tag'];
            $data[$i]['business']=$row['business'];
            $i++;
        }
        if($data==null){
            throw new Exception('Erreur lors de la récupération de la liste des Civilités.');
        }
        return $data;
    }

    public function addCustomer(Customer $Customer){
        $status=$Customer->getStatus();
        $civility=$Customer->getCivility();
        $serial=$Customer->getSerial();
        $subId=$Customer->getSubId();
        $contact=$Customer->getContact();
        $name=$Customer->getName();
        $firstName=$Customer->getFirstName();
        $postal=$Customer->getPostal();
        $city=$Customer->getCity();
        $road=$Customer->getRoad();
        $phone=$Customer->getPhone();
        $phonePort=$Customer->getPhonePort();
        $mail=$Customer->getMail();
        $com=$Customer->getCom();

        // verif antidoublon
        $checkNumber=$this->getCustomerIdBySerial($serial);
        if($checkNumber!=null){
            throw new Exception('Numéro client déjà existant');
        }

        $sql='INSERT INTO customer(civilityId,name,firstName,postal,city,road,tel,port,mail,status,serial,contact,sub_id,com)
            VALUES (:civilityId,:name,:firstName,:postal,:city,:road,:tel,:port,:mail,:status,:serial,:contact,:sub_id,:com)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':civilityId',$civility);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':firstName',$firstName);
        $stmnt->bindParam(':postal',$postal);
        $stmnt->bindParam(':road',$road);
        $stmnt->bindParam(':city',$city);
        $stmnt->bindParam(':tel',$phone);
        $stmnt->bindParam(':port',$phonePort);
        $stmnt->bindParam(':mail',$mail);
        $stmnt->bindParam(':status',$status);
        $stmnt->bindParam(':serial',$serial);
        $stmnt->bindParam(':contact',$contact);
        $stmnt->bindParam(':sub_id',$subId);
        $stmnt->bindParam(':com',$com);
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

    public function updateCustomer(Customer $Customer){
        $id=$Customer->getId();
        $status=$Customer->getStatus();
        $civility=$Customer->getCivility();
        $serial=$Customer->getSerial();
        $subId=$Customer->getSubId();
        $contact=$Customer->getContact();
        $name=$Customer->getName();
        $firstName=$Customer->getFirstName();
        $postal=$Customer->getPostal();
        $city=$Customer->getCity();
        $road=$Customer->getRoad();
        $phone=$Customer->getPhone();
        $phonePort=$Customer->getPhonePort();
        $mail=$Customer->getMail();
        $com=$Customer->getCom();
        //var_dump($Customer);

        $sql='UPDATE customer SET civilityId=:civility_id ,name=:name,firstName=:firstName,postal=:postal,city=:city,road=:road,tel=:tel,port=:port,mail=:mail,status=:status,serial=:serial,contact=:contact,sub_id=:sub_id,com=:com
            WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':civility_id',$civility);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':firstName',$firstName);
        $stmnt->bindParam(':postal',$postal);
        $stmnt->bindParam(':city',$city);
        $stmnt->bindParam(':road',$road);
        $stmnt->bindParam(':tel',$phone);
        $stmnt->bindParam(':port',$phonePort);
        $stmnt->bindParam(':mail',$mail);
        $stmnt->bindParam(':status',$status);
        $stmnt->bindParam(':serial',$serial);
        $stmnt->bindParam(':contact',$contact);
        $stmnt->bindParam(':sub_id',$subId);
        $stmnt->bindParam(':com',$com);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    private function getCustomerIdBySerial($value){
        $sql='SELECT id FROM customer WHERE serial=:serial';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':serial',$value);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data=$row['id'];
        }
        return $data;
    }

    public function getNextClNumber(){
        $sql='SELECT MAX(serial) FROM customer';
        $stmnt=$this->_db->prepare($sql);
        //$stmnt->bindParam(':serial',$value);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            $data=$row['MAX(serial)'];
        }
        return $data;
    }

    public  function deleteId($id){
        $sql='DELETE FROM customer WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

}