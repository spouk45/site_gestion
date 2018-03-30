<?php
class MoveManager
{

    private $_db;

    public function __construct(PDO $db)
    {
        $this->_db = $db;
    }

    public function addMove(Move $Move)
    {

        $bottleId = $Move->getBottleId();
        $serialFiche = $Move->getSerialFiche();
        $dateOfMove = $Move->getDateOfMove();
        $chargeOut = $Move->getChargeOut();
        $chargeIn = $Move->getChargeIn();
        $gazId = $Move->getGazId();
        $customerId = $Move->getCustomerId();
        $techId = $Move->getTechId();
        $equipmentId = $Move->getEquipmentId();

        // verif anti-doublon
        $check=$this->antiDoublonSerial($serialFiche,$chargeIn,$chargeOut);
        if($check==false){
            throw new Exception('Cette fiche est déjà enregistrée.');
        }

        $sql = 'INSERT INTO flu_move(bottleId, serialFiche, dateOfMove, chargeOut, chargeIn, gazId, customerId, techId, equipmentId)
              VALUES (:bottleId, :serialFiche, :dateOfMove, :chargeOut, :chargeIn, :gazId, :customerId, :techId, :equipmentId)';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':bottleId', $bottleId);
        $stmnt->bindParam(':serialFiche', $serialFiche);
        $stmnt->bindParam(':dateOfMove', $dateOfMove);
        $stmnt->bindParam(':chargeOut', $chargeOut);
        $stmnt->bindParam(':chargeIn', $chargeIn);
        $stmnt->bindParam(':gazId', $gazId);
        $stmnt->bindParam(':customerId', $customerId);
        $stmnt->bindParam(':techId', $techId);
        $stmnt->bindParam(':equipmentId', $equipmentId);
        $stmnt->execute();

        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('L\'enregistrement semble avoir �chou�.');
        }
    }

    public function antiDoublonSerial($serialFiche,$chargeIn,$chargeOut){// retourne false si doublon

        if($chargeIn != null && $chargeOut !=null){
            $sql='SELECT COUNT(id) FROM flu_move WHERE serialFiche=:serialFiche AND chargeIn IS NOT NULL AND chargeOut IS NOT NULL';
        }
        elseif ($chargeOut !=null){
                $sql='SELECT COUNT(id) FROM flu_move WHERE serialFiche=:serialFiche AND chargeOut IS NOT NULL ';
        }
        elseif ($chargeIn !=null){
            $sql='SELECT COUNT(id) FROM flu_move WHERE serialFiche=:serialFiche AND chargeIn IS NOT NULL ';
        }
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':serialFiche', $serialFiche);
        $stmnt->execute();

        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }

        $count=null;

        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            foreach($row as $key=>$value){
                $count=$row['COUNT(id)'];
            }
        }

        if($count>0){
            return false;
        }
        else {
            return true;
        }
    }

    public function updateMove(Move $Move)
    {
        $id = $Move->getId();
        $bottleId = $Move->getBottleId();
        $serialFiche = $Move->getSerialFiche();
        $dateOfMove = $Move->getDateOfMove();
        $chargeOut = $Move->getChargeOut();
        $chargeIn = $Move->getChargeIn();
        $gazId = $Move->getGazId();
        $customerId = $Move->getCustomerId();
        $techId = $Move->getTechId();
        $equipmentId = $Move->getEquipmentId();

        $sql = 'UPDATE flu_move SET bottleId=:bottleId,serialFiche=:serialFiche,dateOfMove=:dateOfMove,chargeOut=:chargeOut,chargeIn=:chargeIn,gazId=:gazId,customerId=:customerId,techId=:techId,equipmentId=:equipmentId
                WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->bindParam(':bottleId', $bottleId);
        $stmnt->bindParam(':serialFiche', $serialFiche);
        $stmnt->bindParam(':dateOfMove', $dateOfMove);
        $stmnt->bindParam(':chargeOut', $chargeOut);
        $stmnt->bindParam(':chargeIn', $chargeIn);
        $stmnt->bindParam(':gazId', $gazId);
        $stmnt->bindParam(':customerId', $customerId);
        $stmnt->bindParam(':techId', $techId);
        $stmnt->bindParam(':equipmentId', $equipmentId);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('La mise a jout semble avoir �chou�.');
        }

    }

    public function deleteMove($id)
    {
        if (!is_numeric($id)) {
            throw new Exception('id doit etre numeric');
        }
        $sql = 'DELETE FROM flu_move WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('La suppression semble avoir échoué.');
        }
    }

    public function getMove($bottleId,$start,$end)
    {
       $dateStart=$start;
       $dateEnd=$end;

        if($bottleId!=null){
                $where=' WHERE bottleId=:bottleId';
        }
        else{
            $where=' WHERE flu_move.dateOfMove > :dateStart AND flu_move.dateOfMove < :dateEnd';
        }

        $sql='SELECT flu_move.id AS id,
                      flu_move.bottleId As bottleId,
                       flu_bottle.serial As bottleSerial,
                       flu_move.serialFiche As serialFiche,
                       flu_move.dateOfMove As dateOfMove,
                       flu_move.chargeOut As chargeOut,
                       flu_move.chargeIn As chargeIn,
                       flu_move.gazId As gazId,
                       flu_gaz.name As gazName,
                       flu_move.customerId As customerId,
                       customer.name As customerName,
                       customer.serial As customerSerial,
                       tech.id As techId,
                       tech.name As techName,
                       tech.firstname As techFirstName,
                       flu_move.equipmentId As equipmentId,
                       equipment.product_id As productId,
                       product.name As productName,
                       equipment.serial As equipmentSerial,
                       flu_type.name As typeName,
                       flu_bottle.typeId As typeId
              FROM flu_move
              INNER JOIN flu_bottle ON flu_bottle.id=flu_move.bottleId
              INNER JOIN flu_gaz ON flu_gaz.id=flu_move.gazId
              INNER JOIN flu_type ON flu_type.id=flu_bottle.typeId
              LEFT JOIN customer ON customer.id=flu_move.customerId
              LEFT JOIN tech ON tech.id=flu_move.techId
              LEFT JOIN equipment ON equipment.id=flu_move.equipmentId
              LEFT JOIN product ON product.id=equipment.product_id';

       $sql.=$where;
        $order=' ORDER BY dateOfMove DESC';
        //$limit=' LIMIT 50';
        $sql.=$order;
        //$sql.=$order.$limit;

        $stmnt=$this->_db->prepare($sql);
        if($bottleId!=null){
            //echo 'true';
            $stmnt->bindValue(':bottleId',$bottleId);
        }
        else{
            $stmnt->bindParam(':dateStart', $dateStart);
            $stmnt->bindParam(':dateEnd', $dateEnd);
        }

        //var_dump($dateEnd);
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
            throw new Exception('Aucun résultat.');
        }
        return $data;
    }


}