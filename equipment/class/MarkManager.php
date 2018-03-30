<?php
class MarkManager{

    private $_db;

    /*const ERROR_LOG='Login ou mot de passe incorrect';
    const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';*/

    public function __construct(PDO $db)
    {
        $this->_db=$db;
    }
    public function getMark($seek){// rechercher par nom ou numéro de client

        $seek2='%'.$seek.'%';
        if($seek=='*'){
            $seek2='%';
        }

        $sql='SELECT id,name FROM mark WHERE name LIKE :seek';
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
            $i++;
        }

        return $data;
    }

    public function addMark(Mark $Mark){
        $name=$Mark->getName();

        $sql='INSERT INTO mark(name)
            VALUES (:name)';
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

    public function updateMark(Mark $Mark){
        $id=$Mark->getId();
        $name=$Mark->getName();

        $sql='UPDATE mark SET name=:name WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':name',$name);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public  function deleteMark($id){
        $sql='DELETE FROM mark WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

}