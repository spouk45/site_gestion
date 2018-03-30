<?php
class SubManager{

    private $_db;

    /*const ERROR_LOG='Login ou mot de passe incorrect';
    const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';*/

    public function __construct(PDO $db)
    {
        $this->_db=$db;
    }

    public function getSub($seek){// rechercher par nom ou numéro de client

        $seek2='%'.$seek.'%';
        if($seek=='*'){
            $seek2='%';
        }

        $sql='SELECT id,name,city,postal,road,tel,mail,contact,com FROM sub WHERE name LIKE :seek';
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
            $data[$i]['postal']=$row['postal'];
            $data[$i]['road']=$row['road'];
            $data[$i]['city']=$row['city'];
            $data[$i]['contact']=$row['contact'];
            $data[$i]['tel']=$row['tel'];
            $data[$i]['com']=$row['com'];
            $data[$i]['mail']=$row['mail'];
            $i++;
        }
        //var_dump($data);
        return $data;
    }

    public function getSubByID($id){

        $sql='SELECT id,name,city,postal,road,tel,mail,contact,com FROM sub WHERE id=:id';
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
            $data['name']=$row['name'];
            $data['road']=$row['road'];
            $data['city']=$row['city'];
            $data['contact']=$row['contact'];
            $data['contact']=$row['contact'];
            $data['tel']=$row['tel'];
            $data['com']=$row['com'];
            $data['mail']=$row['mail'];
        }

        if($data==null){
            throw new Exception('Id introuvable.');
        }
        return $data;
    }

    public function getSubList(){
        $sql='SELECT id,name FROM sub';
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
            $data[$i]['name']=$row['name'];
            $i++;
        }
        return $data;
    }

    public function addSub(Sub $Sub){
        $contact=$Sub->getContact();
        $name=$Sub->getName();
        $postal=$Sub->getPostal();
        $city=$Sub->getCity();
        $road=$Sub->getRoad();
        $phone=$Sub->getPhone();
        $mail=$Sub->getMail();
        $com=$Sub->getCom();

        // verif antidoublon
        $checkNumber=$this->getSubCountByName($name);
        if($checkNumber>0){
            throw new Exception('Sous-traitant déjà existant');
        }

        $sql='INSERT INTO sub(name,postal,city,road,tel,mail,contact,com)
            VALUES (:name,:postal,:city,:road,:tel,:mail,:contact,:com)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':postal',$postal);
        $stmnt->bindParam(':city',$city);
        $stmnt->bindParam(':road',$road);
        $stmnt->bindParam(':tel',$phone);
        $stmnt->bindParam(':mail',$mail);
        $stmnt->bindParam(':contact',$contact);
        $stmnt->bindParam(':com',$com);
        $stmnt->execute();
        if($stmnt->rowCount() == 0)
        {
            throw new Exception('L\'enregistrement semble avoir échoué.');
        }
    }

    private function getSubCountByName($value){
        $sql='SELECT COUNT(id) FROM sub WHERE name=:name';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':name',$value);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        $data=null;
        $row=$stmnt->fetch(PDO::FETCH_ASSOC); // a finir
        $nb=$row['COUNT(id)'];

        return $nb;
    }

    public function updateSub(Sub $Sub){
        $id=$Sub->getId();
        $contact=$Sub->getContact();
        $name=$Sub->getName();
        $postal=$Sub->getPostal();
        $city=$Sub->getCity();
        $road=$Sub->getRoad();
        $phone=$Sub->getPhone();
        $mail=$Sub->getMail();
        $com=$Sub->getCom();

        $sql='UPDATE sub SET name=:name,postal=:postal,city=:city,road=:road,tel=:tel,mail=:mail,contact=:contact,com=:com
            WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':postal',$postal);
        $stmnt->bindParam(':city',$city);
        $stmnt->bindParam(':road',$road);
        $stmnt->bindParam(':tel',$phone);
        $stmnt->bindParam(':mail',$mail);
        $stmnt->bindParam(':contact',$contact);
        $stmnt->bindParam(':com',$com);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public  function deleteId($id){
        $sql='DELETE FROM sub WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

}