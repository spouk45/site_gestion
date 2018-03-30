<?php
class BottleManager {
    private $_db;

// ******** Bouteille *******************
    public function __construct(PDO $db){
        $this->_db=$db;
    }

    public function addBottle(Bottle $Bottle){

        //$id=$Bottle->getId();
        $serial=$Bottle->getSerial();
        $dateOfBuy=$Bottle->getDateOfBuy();
        $dateOfSell=$Bottle->getDateOfSell();
        $charge=$Bottle->getCharge();
        $gazId=$Bottle->getGazId();
        $typeId=$Bottle->getTypeId();
        $fournisseurId=$Bottle->getFournisseurId();



        $sql='INSERT INTO flu_bottle(serial,dateOfBuy,charge,gazId,typeId,fournisseurId,dateOfSell)
            VALUES (:serial,:dateOfBuy,:charge,:gazId,:typeId,:fournisseurId,:dateOfSell)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':serial',$serial);
        $stmnt->bindParam(':dateOfBuy',$dateOfBuy);
        $stmnt->bindParam(':charge',$charge);
        $stmnt->bindParam(':gazId',$gazId);
        $stmnt->bindParam(':typeId',$typeId);
        $stmnt->bindParam(':fournisseurId',$fournisseurId);
        $stmnt->bindParam(':dateOfSell',$dateOfSell);
        $stmnt->execute();

        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
        if($stmnt->rowCount() == 0)
        {
            throw new Exception('L\'enregistrement semble avoir �chou�.');
        }
    }

    public function updateBottle(Bottle $Bottle){
        $id=$Bottle->getId();
        $serial=$Bottle->getSerial();
        $dateOfBuy=$Bottle->getDateOfBuy();
        $dateOfSell=$Bottle->getDateOfSell();
        $charge=$Bottle->getCharge();
        $gazId=$Bottle->getGazId();
        $typeId=$Bottle->getTypeId();
        $fournisseurId=$Bottle->getFournisseurId();

        if($id==null){throw new Exception('Le id ne peut etre null.');}
        $sql='UPDATE flu_bottle SET serial=:serial,dateOfBuy=:dateOfBuy,charge=:charge,gazId=:gazId,typeId=:typeId,fournisseurId=:fournisseurId,dateOfSell=:dateOfSell
            WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':serial',$serial);
        $stmnt->bindParam(':dateOfBuy',$dateOfBuy);
        $stmnt->bindParam(':charge',$charge);
        $stmnt->bindParam(':gazId',$gazId);
        $stmnt->bindParam(':typeId',$typeId);
        $stmnt->bindParam(':fournisseurId',$fournisseurId);
        $stmnt->bindParam(':dateOfSell',$dateOfSell);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public  function deleteBottle($id){
        if($id==null){throw new Exception('id ne peut etre null');}

        $sql='DELETE FROM flu_bottle WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function getBottle(array $data){
        // id,serial,fournisseurId,gazId,dateOfBuy,dateOfSell


        $sql1='SELECT id,serial,dateOfBuy,charge,gazId,typeId,fournisseurId,dateOfSell FROM flu_bottle WHERE ';
        if(isset($data['id'])){
            $sql2='id=:id';
        }
        else if(isset($data['serial'])){
            $sql2='serial LIKE :serial';
            $serial='%'.$data['serial'].'%';
        }
        else if(isset($data['fournisseurId'])){
            $sql2='fournisseurId=:fournisseurId';
            $fournisseurId=$data['fournisseurId'];
        }
        else if(isset($data['gazId'])){
            $sql2='gazId=:gazId';
            $gazId=$data['gazId'];
        }
        else if(isset($data['dateOfBuy'])){
            $sql2='dateOfBuy=:dateOfBuy';
            $dateOfBuy=$data['dateOfBuy'];
        }
        else if(isset($data['year'])){
            $fin=$data['year']+1;
            $begin = DateTime::createFromFormat('Y',$data['year']);
            $end=DateTime::createFromFormat('Y',$fin);
            $sql2='dateOfBuy LIKE :serial';
        }
        else if(isset($data['dateOfSell'])){
            $sql2='dateOfSell=:dateOfSell';
            $dateOfSell=$data['dateOfSell'];
        }
        else  {
            throw new Exception('le tableau de données envoyé est vide.');
        }


        $sql=$sql1.$sql2;


        $stmnt=$this->_db->prepare($sql);
        if(isset($data['id'])){ $stmnt->bindParam(':id',$data['id']);}
        else if(isset($data['serial'])){ $stmnt->bindParam(':serial',$serial);}
        else if(isset($data['fournisseurId'])){ $stmnt->bindParam(':fournisseurId',$fournisseurId);}
        else if(isset($data['gazId'])){ $stmnt->bindParam(':gazId',$gazId);}
        else if(isset($data['dateOfBuy'])){ $stmnt->bindParam(':dateOfBuy',$dateOfBuy);}
        else if(isset($data['dateOfSell'])){ $stmnt->bindParam(':dateOfSell',$dateOfSell);}

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
                $data[$i]['serial']=$row['serial'];
                $data[$i]['fournisseurId']=$row['fournisseurId'];
                $data[$i]['gazId']=$row['gazId'];
                $data[$i]['dateOfBuy']=$row['dateOfBuy'];
                $data[$i]['dateOfSell']=$row['dateOfSell'];
                $data[$i]['serial']=$row['serial'];
                $data[$i]['charge']=$row['charge'];
                $data[$i]['typeId']=$row['typeId'];
                $i++;
            }

            if($data==null){
                throw new Exception('Aucun résultat.');
            }
            return $data;

    }

    public function getListBottle(){
        $sql='SELECT * FROM flu_bottle';
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
            foreach($row as $key=>$value){
                $data[$i][$key]=$row[$key];
            }
            $i++;
        }

        if($data==null){
            throw new Exception('Aucun r�sultat.');
        }
        return $data;
    }

    public function getType($id){
        if(!is_numeric($id)){throw new Exception('id doit etre un nombre.');}
        $sql='SELECT name FROM flu_type WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindValue(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();

        if($error[0]!=00000){throw new Exception($error[2]); }

        $name=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC))
        {
            $name=$row['name'];
        }

        if($name==null){ throw new Exception('Aucun r�sultat.'); }
        return $name;
    }

    public function getBottleByType($type,$serial){

        if($serial==null){
            throw new Exception('serial est vide');
        }
        $limit=' LIMIT 5';
        $serial='%'.$serial.'%';
        if($type==1){
                $where='WHERE (typeId=1 OR typeId=3) AND serial LIKE :serial ';
        }
        else{
            $where ='WHERE (typeId=3 OR typeId=2) AND serial LIKE :serial';
        }
        $sql='SELECT flu_bottle.id AS id,serial,typeId,flu_type.name AS type
        FROM flu_bottle INNER JOIN flu_type ON flu_type.id=flu_bottle.typeId ';
        $sql.=$where.$limit;

        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindValue(':serial',$serial);
        $stmnt->execute();
        $error=$stmnt->errorInfo();

        if($error[0]!=00000){throw new Exception($error[2]); }

        $i=null;
        $data=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC))
        {
            foreach($row as $key=>$value){
                $data[$i][$key]=$value;
            }
            $i++;
        }

        return $data;
    }

    public function getBottleBilan($dateStart,$dateEnd){//int

        $sql='SELECT id,serial,dateOfBuy,charge,gazId,typeId,fournisseurId,dateOfSell FROM flu_bottle
              WHERE (dateOfBuy >= :dateStart AND dateOfBuy <= :dateEnd AND typeId=1)
              OR  (dateOfSell >= :dateStart AND dateOfSell <= :dateEnd AND typeId != 1) ';

        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindValue(':dateStart',$dateStart);
        $stmnt->bindValue(':dateEnd',$dateEnd);
        $stmnt->execute();
        $error=$stmnt->errorInfo();

        if($error[0]!=00000){throw new Exception($error[2]); }

        $i=0;
        $data=null;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC))
        {
            foreach($row as $key=>$value){
                $data[$i][$key]=$value;
            }
            $i++;
        }

        return $data;

    }



}