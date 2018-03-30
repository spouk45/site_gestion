<?php
class EquipmentManager{

    private $_db;

    /*const ERROR_LOG='Login ou mot de passe incorrect';
    const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';*/

    public function __construct(PDO $db)
    {
        $this->_db=$db;
    }

    public function getEquipment($clientId){


        $sql='SELECT equipment.id AS id,equipment.client_id AS clientId,equipment.product_id AS productId,equipment.serial AS serial,
            product.name AS productName,mark.name AS mark,prod_category.name AS categoryName
        FROM equipment
        LEFT JOIN product ON product.id=equipment.product_id
        LEFT JOIN prod_category ON prod_category.id=product.category_id
        LEFT JOIN mark ON product.mark=mark.id
        WHERE equipment.client_id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$clientId);
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
                    $data[$i][$key] = $row[$key];
                }
                $i++;
        }

        return $data;
    }

    public function getEquipmentByID($id){

        $sql='SELECT id,client_id,product_id,serial FROM equipment WHERE id=:id';
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
            $data[$i]['client_id']=$row['client_id'];
            $data[$i]['product_id']=$row['product_id'];
            $data[$i]['serial']=$row['serial'];
        }

        return $data;
    }

    public function addEquipment(Equipment $Equipment){
        $clientId=$Equipment->getClientId();
        $productId=$Equipment->getProductId();
        $serial=$Equipment->getSerial();

        $sql='INSERT INTO equipment(client_id,product_id,serial)
            VALUES (:clientId,:productId,:serial)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':clientId',$clientId);
        $stmnt->bindParam(':productId',$productId);
        $stmnt->bindParam(':serial',$serial);
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

    public function editEquipment(Equipment $Equipment){
        $productId=$Equipment->getProductId();
        $serial=$Equipment->getSerial();

        echo 'productId:'.$productId.' serial:'.$serial;
        $sql='UPDATE equipment SET serial=:serial
            WHERE id=:productId';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':productId',$productId);
        $stmnt->bindParam(':serial',$serial);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public function updateCategory(Category $category){
        $id=$category->getId();
        $name=$category->getName();
        $description=$category->getDescription();

        $sql='UPDATE prod_category SET name=:name,description=:description
            WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':description',$description);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public  function deleteCategory($id){
        $sql='DELETE FROM prod_category WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

}