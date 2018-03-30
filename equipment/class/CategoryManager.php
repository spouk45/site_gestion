<?php
class CategoryManager{

    private $_db;

    /*const ERROR_LOG='Login ou mot de passe incorrect';
    const ERROR_USER_ID='Erreur lors de la récupération de l\'user id';*/

    public function __construct(PDO $db)
    {
        $this->_db=$db;
    }
    public function getCategory($seek){// rechercher par nom ou numéro de client

        $seek2='%'.$seek.'%';
        if($seek=='*'){
            $seek2='%';
        }

        $sql='SELECT id,name,description,frigo FROM prod_category WHERE name LIKE :seek';
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
            $data[$i]['description']=$row['description'];
            $data[$i]['frigo']=$row['frigo'];
            $i++;
        }

        return $data;
    }

    public function getCategoryByID($id){

        $sql='SELECT id,name,description,frigo FROM prod_category WHERE id=:id';
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
            $data['frigo']=$row['frigo'];
        }

        if($data==null){
            throw new Exception('Id introuvable.');
        }
        return $data;
    }
/*
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
    }*/
    public function addCategory(Category $category){
        $name=$category->getName();
        $description=$category->getDescription();
        $frigo=$category->getFrigo();

        $sql='INSERT INTO prod_category(name,description,frigo)
            VALUES (:name,:description,:frigo)';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':description',$description);
        $stmnt->bindParam(':frigo',$frigo);
        $stmnt->execute();
        $error=$stmnt->errorInfo();

        if($error[0]!=00000){
            // verif anti-doublon
            if($error[0]==23000){
                throw new Exception('Nom déjà utilisé.');
            }
            throw new Exception($error[2]);
        }
        if($stmnt->rowCount() == 0)
        {
            throw new Exception('L\'enregistrement semble avoir échoué.');
        }
    }

    public function updateCategory(Category $category){
        $id=$category->getId();
        $name=$category->getName();
        $frigo=$category->getFrigo();
        $description=$category->getDescription();

        $sql='UPDATE prod_category SET name=:name,description=:description,frigo=:frigo
            WHERE id=:id';
        $stmnt=$this->_db->prepare($sql);
        $stmnt->bindParam(':id',$id);
        $stmnt->bindParam(':name',$name);
        $stmnt->bindParam(':description',$description);
        $stmnt->bindParam(':frigo',$frigo);
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