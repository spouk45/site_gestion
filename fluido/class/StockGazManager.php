<?php class StockGazManager{

    private $_db;

    public function __construct(PDO $db)
    {
        $this->_db = $db;
    }

    public function addStock(StockGaz $StockGaz){
        $year=$StockGaz->getYear();
        $gazId=$StockGaz->getGazId();
        $charge=$StockGaz->getCharge();
        $recup=$StockGaz->getRecup();

        $sql = 'INSERT INTO flu_stock(year, gazId, charge, recup)
              VALUES (:year,:gazId,:charge,:recup)';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':year', $year);
        $stmnt->bindParam(':gazId', $gazId);
        $stmnt->bindParam(':charge', $charge);
        $stmnt->bindParam(':recup', $recup);
        $stmnt->execute();

        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('L\'enregistrement semble avoir �chou�.');
        }
    }

    public function updateStock(StockGaz $StockGaz){
        $id=$StockGaz->getId();
        $year=$StockGaz->getYear();
        $gazId=$StockGaz->getGazId();
        $charge=$StockGaz->getCharge();
        $recup=$StockGaz->getRecup();

        $sql = 'UPDATE flu_stock SET year=:year,gazId=:gazId,charge=:charge,recup=:recup
                WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindValue(':id', $id);
        $stmnt->bindValue(':year', $year);
        $stmnt->bindValue(':gazId', $gazId);
        $stmnt->bindValue(':charge', $charge);
        $stmnt->bindValue(':recup', $recup);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('La mise a jout semble avoir �chou�.');
        }
    }

    public function deleteStock($id){
        if (!is_numeric($id)) {
            throw new Exception('id doit etre numeric');
        }
        $sql = 'DELETE FROM flu_stock WHERE id=:id';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }
        if ($stmnt->rowCount() == 0) {
            throw new Exception('La suppression semble avoir �chou�.');
        }

    }

   /* public function getStock($data,$param){
        if ($data == null) {
            throw new Exception('data est vide');
        }
        if($param != 'OR' && $param != 'AND' && $param != null){
            throw new Exception('mauvais param�tre entr�');
        }
        if($param =='' && count($data)>1){
            throw new Exception('le parametre ne peut pas etre null -> OR ou AND');
        }

        $sql='SELECT * FROM flu_stock WHERE ';

        $i=0;
        foreach($data as $key => $value){
            if(is_array($value)) {

                foreach ($value as $key2=>$value2){
                    if($i==0){ $sql.=$key.'=:'.$key.$key2;}
                    else {
                        $sql .=' ' . $param . ' ' .$key . '=:' . $key . $key2;
                    }
                    $i++;
                }
            }
            else {
                if ($i == 0) {
                    $sql .= $key . '=:' . $key;
                } else {
                    $sql .= ' ' . $param . ' ' . $key . '=:' . $key;
                }
            }
            $i++;
        }
        echo $sql;


        $stmnt=$this->_db->prepare($sql);

        foreach($data as $key => $value){
            if(is_array($value)){
                foreach($value as $key2=>$value2){
                    $stmnt->bindValue(':'.$key.$key2,$value2);
                }
            }
            else {
                $stmnt->bindValue(':'.$key,$value);
            }

            ?><pre><?php print_r($value); ?></pre><?php
        }

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
*/


    public function getStock($year){

        $sql='SELECT flu_stock.id AS stockId,year,gazId,flu_gaz.name AS name,charge,recup
              FROM flu_stock
              INNER JOIN flu_gaz ON flu_gaz.id=flu_stock.gazId
              WHERE year=:year';

        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindValue(':year', $year);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }

        $data=null;
        $i=0;
        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            foreach($row as $key=>$value){
                $data[$i][$key]=$value;
            }
            $i++;
        }

        return $data;
    }

    public function getStockByGaz($year,$gazId){ // gaz et year
        $sql='SELECT flu_stock.id AS id,year,gazId,flu_gaz.name AS name,charge,recup
              FROM flu_stock
              INNER JOIN flu_gaz ON flu_gaz.id=flu_stock.gazId
              WHERE year=:year AND gazId=:gazId';

        $stmnt = $this->_db->prepare($sql);
        $stmnt->bindValue(':year', $year);
        $stmnt->bindValue(':gazId', $gazId);
        $stmnt->execute();
        $error = $stmnt->errorInfo();
        if ($error[0] != 00000) {
            throw new Exception($error[2]);
        }

        $data=null;

        while($row=$stmnt->fetch(PDO::FETCH_ASSOC)) // a finir
        {
            foreach($row as $key=>$value){
                $data[$key]=$value;
            }

        }

        return $data;
    }
}