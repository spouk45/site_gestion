<?php
class GazManager
{
    private $_db;

    public function __construct(PDO $db)
    {
        $this->_db = $db;
    }


    public function addGaz(Gaz $Gaz){

        //$id=$Gaz->getId();
        $name=$Gaz->getName();

        // anti-doublon
        $count=$this->getGazByName($name);
        if($count!=null){throw new Exception('Nom déjà existant');}

        $sql='INSERT INTO flu_gaz(name) VALUES (:name)';
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
    public function updateGaz(Gaz $Gaz)
    {
        $id = $Gaz->getId();
        $name = $Gaz->getName();


        $sql = 'UPDATE flu_gaz SET name=:name WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->bindParam(':name', $name);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }

    }

    public  function deleteGaz($id){

        $sql='DELETE FROM flu_gaz WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function getGazByName($name){
        $sql='SELECT id,name FROM flu_gaz WHERE name=:name';
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
            $data['id']=$row['id'];
            $data['name']=$row['name'];
        }
        return $data;
    }

    public function getGaz($id){
       if($id==null){
           $sql='SELECT id,name FROM flu_gaz';
       }
        else {
            $sql='SELECT id,name FROM flu_gaz WHERE id=:id';
        }


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

        if($data==null){
            throw new Exception('Aucun résultat.');
        }
        return $data;

    }
}