<?php
class HistoryManager{

    private $_db;

    public function __construct(PDO $db){
        $this->_db=$db;
    }

    public function addHistory(History $History){
        $text=$History->getText();
        $date=$History->getDate();
        $equipmentId=$History->getEquipmentId(); //array

        // on créer dans la table history la base text+date
            $sql='INSERT INTO history (date,text) VALUES (:date,:text)';
            $stmnt=$this->_db->prepare($sql);
            $stmnt->bindParam(':date',$date);
            $stmnt->bindParam(':text',$text);
            $stmnt->execute();
            $error=$stmnt->errorInfo();
            if($error[0]!=00000){
                throw new Exception($error[2]);
            }
            if($stmnt->rowCount() == 0)
            {
                throw new Exception('L\'enregistrement de l\'historique semble avoir échoué.');
            }

        // on récupère le id de l'entrée qu'on vient d'ajouter
            $historyId=$this->_db->lastInsertId();

        // on créer dans la base link histo les liens id

            foreach ($equipmentId as $id){
                $sql='INSERT INTO history_link (equipmentId, historyId) VALUES (:equipmentId,:historyId)';
                $stmnt=$this->_db->prepare($sql);
                $stmnt->bindParam(':historyId',$historyId);
                $stmnt->bindParam(':equipmentId',$id);
                $stmnt->execute();
                $error=$stmnt->errorInfo();
                if($error[0]!=00000){
                    $errorInfo=$error[2];
                }
                if($stmnt->rowCount() == 0)
                {
                    $errorInfo='L\'enregistrement du lien historique semble avoir échoué.';
                }
            }

        // si erreur dans le link on supprime l'entrée history
            if(!empty($errorInfo)){
                $this->deleteHistory($historyId);
                throw new Exception($errorInfo);
            }
    }

    public function deleteHistory($historyId){
        $sql='DELETE FROM history WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$historyId);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

    }

    public function getHistory($clientId,$GROUP){
        $group='';
        if($GROUP=='true'){
            $group=' GROUP BY history_link.historyId';
        }

        $sql='SELECT
          history.id AS id,
          history.date AS date,
          history.text AS text,
          history_link.equipmentId AS equipmentId,
          product.id AS productId,
          product.name AS productName,
          customer.id AS clientId,
          history_link.historyId AS historyLinkId,
          equipment.serial AS serial,
          equipment.id AS equipmentId,
          equipment.repere AS repere
        FROM history
        INNER JOIN history_link ON history_link.historyId=history.id
        INNER JOIN equipment ON equipment.id=history_link.equipmentId
        INNER JOIN customer ON customer.id=equipment.client_id
        INNER JOIN product ON product.id=equipment.product_id
        WHERE customer.id=:clientId'. $group .'
        ORDER BY date DESC
        ';
       // echo $sql.'<br>';

        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':clientId',$clientId);
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
                $data[$i][$key]=$value;
            }
            $i++;
        }
        //var_dump($data);
        return $data;
    }

    public function editHistory(History $History){
        $id=$History->getId();
        $text=$History->getText();

        $sql='UPDATE history SET text=:text WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':text',$text);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }

    }

   }