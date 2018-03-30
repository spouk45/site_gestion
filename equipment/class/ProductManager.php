<?php
class ProductManager{

    private $_db;

    /*const ERROR_LOG='Login ou mot de passe incorrect';
    const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';*/

    public function __construct(PDO $db)
    {
        $this->_db=$db;
    }

    public function getProduct($data){// rechercher par nom ou numéro de client

        $where=' WHERE ';

        if(empty($data['id'])){
                $seek=$data['name'];
                $seek2='%'.$seek.'%';
                if($seek==''){
                    $seek2='%';
                }
                $where.=' product.name LIKE :seek ';

            if(!empty($data['markId'])){
                $markId=$data['markId'];
                $where.=' AND product.mark=:markId ';
            }
            if(!empty($data['categoryId'])){
                $categoryId=$data['categoryId'];
                $where.=' AND product.category_id=:categoryId ';
            }
        }
        else{
            $id=$data['id'];
            $where.=' product.id=:id ';
        }

        $sql='SELECT product.id ,product.name AS productName, mark.id AS markId,product.description ,mark.name AS markName,prod_category.name AS categoryName,prod_category.id AS categoryId
              FROM product
              LEFT JOIN mark ON product.mark=mark.id
              LEFT JOIN prod_category ON product.category_id= prod_category.id '.$where. ' LIMIT 50';
        $stmnt=$this->_db->prepare($sql);
        if(isset($seek2)){
        $stmnt->bindParam(':seek',$seek2);
        }
        if(!empty($markId)){
            $stmnt->bindValue(':markId', $markId);
        }
        if(!empty($categoryId)){
            $stmnt->bindValue(':categoryId', $categoryId);
        }
        if(!empty($id)){
            $stmnt->bindValue(':id', $id);
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
                if(!isset($id)) {
                    $data[$i][$key] = $row[$key];
                }
                else{
                    $data[$key] = $row[$key];
                }

            }
            $i++;
        }

        return $data;
    }
/*
    public function getProductByID($id){

        $sql='SELECT id,name,description,mark,category_id FROM product WHERE id=:id';
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
            $data['description']=$row['description'];
            $data['mark']=$row['mark'];
            $data['category_id']=$row['category_id'];
        }

        if($data==null){
            throw new Exception('Id introuvable.');
        }
        return $data;
    }
*/
   /* public function getSubList(){
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
    }*/

    public function getCategoryList(){
        $sql='SELECT id,name FROM prod_category';
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
    public function addProduct(Product $Product){
        $name=$Product->getName();
        $description=$Product->getDescription();
        $mark=$Product->getMark();
        $categoryId=$Product->getCategoryId();

        $sql='INSERT INTO product(name,description,mark,category_id)
            VALUES (:name,:description,:mark,:category_id)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':description',$description);
        $stmnt->bindParam(':mark',$mark);
        $stmnt->bindParam(':category_id',$categoryId);
        $stmnt->execute();
        if($stmnt->rowCount() == 0)
        {
            throw new Exception('L\'enregistrement semble avoir échoué.');
        }
    }

    public function updateProduct(Product $Product){
        $id=$Product->getId();
        $name=$Product->getName();
        $description=$Product->getDescription();
        $mark=$Product->getMark();
        $categoryId=$Product->getCategoryId();

        $sql='UPDATE product SET name=:name,description=:description,mark=:mark,category_id=:category_id
            WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':description',$description);
        $stmnt->bindParam(':mark',$mark);
        $stmnt->bindParam(':category_id',$categoryId);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

    public  function deleteProduct($id){
        $sql='DELETE FROM product WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->execute();
        $error=$stmnt->errorInfo();
        if($error[0]!=00000){
            throw new Exception($error[2]);
        }
    }

}